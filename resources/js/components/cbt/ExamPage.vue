<template>
  <span>
    <div class="container-fluid" v-if="!examStart">
      <nav class="navbar navbar-expand-sm navbar-light bg-light navbar-fixed-top shadow-sm m-0 p-1">
        <a class="navbar-brand" href="#">MCCHST CBT</a>
        <a class="navbar-brand ml-auto border-primary">Name: {{currentUser.fullname}}</a>
      </nav>
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-3">{{currentExam.exam}}</h1>
          <h4 class="lead">Exam Instructions</h4>
          <hr class="my-2" />
          <h5>Your Name: {{currentUser.fullname}}</h5>
          <h5>Application Number: {{currentUser.app_number}}</h5>
          <span v-if="timeHasFinish">
            <h3>Your time on this exam has finished.</h3>
            <p class="lead">
              <a class="btn btn-danger btn-lg" :href="logout">Logout</a>
            </p>
          </span>

          <p class="lead" v-else>
            <a
              class="btn btn-primary btn-lg"
              href
              :class="{'disabled' : !startExamButton}"
              @click.prevent="startExam"
            >Start Exam</a>
          </p>
        </div>
      </div>
    </div>

    <div class="container-fluid bg-gray-400" v-if="examStart">
      <nav class="navbar navbar-expand-sm navbar-light bg-gray-200 navbar-fixed-top shadow-sm py-0">
        <a class="navbar-brand" href="#">MCCHST CBT</a>

        <exam-timer class="ml-auto" :startTime="startTime" :endTime="endTime" @timeEnd="timerEnds"></exam-timer>
      </nav>
      <div class="row mb-0" v-if="currentCourse">
        <div class="col-md-9">
          <div class="row d-flex justify-content-center m-0 p-0">
            <button
              class="btn btn-flat btn-sm m-2"
              v-for="(course, key) in currentExam.course"
              :key="key"
              @click="getQuestions(key)"
              :class="course.id === currentCourse.id ? 'btn-primary' : 'btn-secondary' "
            >{{course.course}}</button>
          </div>

          <div class="row">
            <div class="col-md-12">
              <span v-for="(section, key) in questions[currentCourse.id].sections" :key="key">
                <div
                  class="row border-bottom-primary d-flex justify-content-between mb-1 mx-1"
                  v-if="section.id === questions[currentCourse.id].questions[currentQuestion].section_id"
                >
                  <b
                    class
                  >Question No: {{currentQuestion +1}} / {{questions[currentCourse.id].questions.length}}</b>
                  <b class="text-right">{{section.section}}</b>
                </div>
                <p
                  class="text-center text-dark sectionQuestion p-2 bg-gray-300 shadow-sm"
                  v-if="section.id === questions[currentCourse.id].questions[currentQuestion].section_id"
                  v-html="section.question"
                ></p>
              </span>
              <hr class="mt-0 mb-1" />
            </div>
          </div>

          <div
            class="row"
            v-for="(question, key) in questions[currentCourse.id].questions"
            :key="key"
          >
            <div class="col-md-12" v-if="key === currentQuestion">
              <hr />
              <h5 class="d-block pl-3 shadow-sm pb-2 mb-0 text-dark" v-html="question.question"></h5>
              <div class="list-group shadow-sm mt-0" :key="checked">
                <question-option
                  :question="question"
                  :attempted="attempted"
                  :option="`A`"
                  :option_question="question.option_a"
                  @attemptQuestion="attemptQuestion"
                ></question-option>

                <question-option
                  :question="question"
                  :attempted="attempted"
                  :option="`B`"
                  :option_question="question.option_b"
                  @attemptQuestion="attemptQuestion"
                ></question-option>

                <question-option
                  :question="question"
                  :attempted="attempted"
                  :option="`C`"
                  :option_question="question.option_c"
                  @attemptQuestion="attemptQuestion"
                ></question-option>

                <question-option
                  :question="question"
                  :attempted="attempted"
                  :option="`D`"
                  :option_question="question.option_d"
                  @attemptQuestion="attemptQuestion"
                ></question-option>
              </div>
            </div>
          </div>

          <div class="row d-flex justify-content-center mt-1">
            <button class="btn btn-primary btn-flat mr-2" @click="previousQuestion">
              <i class="fas fa-arrow-circle-left"></i> Prev
            </button>
            <button class="btn btn-success btn-flat mr-2" @click="nextQuestion">
              Next
              <i class="fas fa-arrow-circle-right"></i>
            </button>
          </div>
        </div>
        <div class="col-md-3 pr-4 mt-2">
          <div class="row bg-gray-200 shadow-sm p-2">
            <div class="col-md-12 questionsContainer p-1" :key="this.checked">
              <h6 class="text-center">Questions overview</h6>
              <hr />
              <question-no
                :questions="questions[currentCourse.id].questions"
                :attempted="attempted"
                @gotoQuestion="gotoQuestion"
              ></question-no>
              <hr />
            </div>
            <div class="col-md-12 mt-2">
              <div class="row d-flex justify-content-between">
                <b>
                  <i class="fas fa-circle fa-1x text-primary"></i> Attempted
                </b>
                <b>
                  <i class="fas fa-circle fa-1x text-secondary"></i> Not Attempted
                </b>
              </div>
            </div>
            <div class="col-12 mt-3">
              <div class="row">
                <button
                  class="btn btn-secondary btn-sm btn-block mb-1 shadow-sm"
                  @click="showCalculator"
                >
                  <i class="fas fa-calculator"></i> Calculator
                </button>
                <button class="btn btn-secondary btn-sm btn-block mb-1 shadow-sm">
                  <i class="fas fa-sticky-note"></i> Instructions
                </button>
                <button
                  class="btn btn-danger btn-sm btn-block mt-2 shadow-sm"
                  @click="finishedExam"
                >Finish</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <hr class="m-0" />
      <h6 class="text-left mb-1">
        <i class="fas fa-copyright"></i> MCCHST (Developed by KAMEEN IT Solution 2348034932065)
      </h6>
    </div>
    <!-- ---------------calculator modal----------------------- -->
    <div
      class="modal swal2-modal swal2-show"
      id="viewCalculator"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modelTitleId"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="container-fluid p-2 calculator">
            <calculator></calculator>
          </div>
        </div>
      </div>
    </div>
  </span>
</template>

<script>
import moment from "moment";
export default {
  data() {
    return {
      currentUser: "",
      currentExam: [],
      startTime: Date,
      endTime: Date,
      examStart: false,
      currentCourse: null,
      curretnSection: 0,
      currentQuestion: 0,
      currentQuestionsNumber: 0,
      questions: [],
      startExamButton: false,
      attempted: [],
      attemptForm: new Form({
        attempts: []
      }),
      checked: true,
      timeHasFinish: false
    };
  },
  props: {
    logout: "",
    user: ""
  },
  created() {
    this.currentUser = JSON.parse(this.user);
    Toast.fire({
      type: "success",
      title: `${this.currentUser.fullname} Signed in successfully`
    });
    axios.get(`get_exams/${this.currentUser.department_id}`).then(res => {
      this.currentExam = res.data[0];
      this.getQuestions(0);
      this.getAttempted();
      this.setExamTimer();
    });
  },
  methods: {
    timerEnds() {
      this.submitAttempt();
      this.timeHasFinish = true;
      this.examStart = false;
    },
    setExamTimer() {
      let startDate = new Date(
        `${this.currentExam.exam_date} ${this.currentExam.exam_time}`
      );

      let finishDate = new Date(startDate);

      finishDate.setHours(startDate.getHours() + this.currentExam.exam_hours);
      finishDate.setMinutes(
        startDate.getMinutes() + this.currentExam.exam_minutes
      );

      let time = Date.parse(new Date(finishDate)) - Date.parse(new Date());
      if (time > 0) {
        this.startTime = startDate;
        this.endTime = finishDate;
      } else {
        this.timeHasFinish = true;
      }
    },
    startExam() {
      this.examStart = true;
    },
    getQuestions(courseKey) {
      this.currentQuestion = 0;
      let crCourse = this.currentExam.course[courseKey];
      if (!this.questions[crCourse.id]) {
        axios
          .get(
            `get_course_questions/${this.currentUser.id}/${this.currentExam.id}/${crCourse.id}`
          )
          .then(res => {
            this.questions[crCourse.id] = res.data;
            this.currentCourse = crCourse;
            this.setTotalNumberOfQuestions(crCourse);
            this.startExamButton = true;
            this.checked = !this.checked;
          });
      } else {
        this.currentCourse = crCourse;
        this.setTotalNumberOfQuestions(crCourse);
      }
    },
    getAttempted() {
      let attemptsForm = new Form({
        student: this.currentUser.id,
        courses: this.currentExam.course
      });
      attemptsForm.post("get_attempted").then(res => {
        res.data.forEach(attempt => {
          this.attempted[attempt.question_id] = attempt.stu_attempt;
        });
      });
    },
    setTotalNumberOfQuestions(crCourse) {
      this.currentQuestionsNumber = this.questions[
        crCourse.id
      ].questions.length;
    },
    attemptQuestion(question, answer) {
      let guess = {
        student_id: this.currentUser.id,
        exam_id: this.currentExam.id,
        course_id: question.course_id,
        section_id: question.section_id,
        question_id: question.id,
        stu_attempt: answer
      };

      this.attempted[question.id] = answer;
      this.checked = !this.checked;
      this.attemptForm.attempts.push(guess);
      if (this.attemptForm.attempts.length === 1) {
        this.submitAttempt();
      }
    },
    submitAttempt() {
      this.attemptForm
        .post("attempt")
        .then(res => {
          this.attemptForm.attempts.length = 0;
        })
        .catch(error => {
          console.log(error);
          this.attemptForm.attempts.length = 0;
        });
    },
    nextQuestion() {
      if (this.currentQuestion < this.currentQuestionsNumber - 1) {
        this.currentQuestion += 1;
        this.checked = null;
      } else {
        let numOfCourses = this.currentExam.course.length;
        let curCourseIndex = this.currentExam.course.indexOf(
          this.currentCourse
        );
        if (curCourseIndex < numOfCourses - 1) {
          this.getQuestions(curCourseIndex + 1);
        }
      }
    },
    previousQuestion() {
      if (this.currentQuestion > 0) {
        this.currentQuestion -= 1;
      } else {
        let numOfCourses = this.currentExam.course.length;
        let curCourseIndex = this.currentExam.course.indexOf(
          this.currentCourse
        );
        if (curCourseIndex > 0) {
          this.getQuestions(curCourseIndex - 1);
        }
      }
    },
    gotoQuestion(questionKey) {
      this.currentQuestion = questionKey;
      this.checked = null;
    },
    showCalculator() {
      $("#viewCalculator").modal("show");
    },
    finishedExam() {
      Swal.fire({
        title: "Are you sure?",
        text: "You finshed the exam and want logout!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#0f442e",
        cancelButtonColor: "#810412",
        confirmButtonText: "Yes, Submit and Logout!"
      }).then(result => {
        if (result.value) {
          this.submitAttempt();
          this.timerEnds();
        }
      });
    }
  }
};
</script>

<style scoped>
.questionsContainer {
  height: 360px;
  overflow: hidden;
  overflow-y: auto;
}
.btn-flat {
  border-radius: 0px;
}
.container-fluid {
  height: 100vh;
  overflow: hidden;
}
.sectionQuestion {
  max-height: 160px;
  overflow-y: auto;
}
.list-group-item {
  max-height: 50px;
  overflow: hidden;
  padding-top: 3px;
  padding-bottom: 0px;
  margin-bottom: 0px;
}
.calculator {
  max-height: 380px;
  overflow: hidden;
}
.modal-content {
  max-width: 300px;
}
</style>