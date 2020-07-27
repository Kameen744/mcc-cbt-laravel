<template>
  <div class="card text-white bg-gradient-primary border-left-danger">
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-12">
              <div class="row d-flex justify-content-center">
                <div class="form-group col-3">
                  <select class="form-control form-control-sm" @change="getDeptExams">
                    <option value selected>Departments</option>
                    <option
                      v-for="department in departments"
                      :key="department.id"
                      :value="department.id"
                    >{{ department.department }}</option>
                  </select>
                </div>

                <div class="form-group col-3">
                  <select class="form-control form-control-sm" @change="getExamScores">
                    <option value selected>Exams</option>
                    <option v-for="exam in exams" :key="exam.id" :value="exam.id">{{ exam.exam }}</option>
                  </select>
                </div>
              </div>
              <hr class="p-0 m-0 bg-white" />
            </div>
          </div>
          <div class="col-12 p-0 mb-1">
            <hr class="p-0 m-0 bg-white" />
          </div>
          <data-table
            v-if="data_table_url"
            :columns="columns"
            :key="data_table_key"
            :classes="classes"
            :url="data_table_url"
          ></data-table>
        </div>
      </div>
    </div>
    <div
      class="modal swal2-modal swal2-show"
      id="viewStudent"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modelTitleId"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header py-1">
            <h5 class="modal-title text-primary">Student</h5>
          </div>
          <div class="modal-body">
            <div class="container-fluid">
              <div class="row shadow-sm justify-content-center">
                <div class="col-md-auto">
                  <select
                    class="form-control form-control-lg bg-primary text-white"
                    @change="recommend"
                  >
                    <option disabled selected>Recommendation</option>
                    <option
                      v-for="(recommend, key) in recommendations"
                      :key="key"
                      :value="recommend"
                    >{{recommend}}</option>
                  </select>
                </div>
              </div>
              <div class="card-body shadow-sm text-dark">
                <h5 class="card-title text-center text-dark">
                  <b class="px-2 btn-primary">{{Student.fullname}}</b>
                </h5>
                <h5 class="card-title">
                  <h5 class="px-2 btn-primary">App No:</h5>
                  {{Student.app_number}}
                </h5>
                <h5 class="card-title">
                  <h5 class="px-2 btn-primary">Registered:</h5>
                  {{Student.created_at | myDate}}
                </h5>
                <hr />
                <div class="row">
                  <div class="col-6 border-left-danger shadow-sm">
                    <h5 class="px-2 btn-primary">First Choice:</h5>
                    {{Student.first_choice}}
                  </div>
                  <div class="col-6 border-left-danger shadow-sm">
                    <h5 class="px-2 btn-primary">Second Choice:</h5>
                    {{Student.second_choice}}
                  </div>

                  <div class="col-12 border-left-danger shadow-sm">
                    <h5 class="px-2 btn-primary">O level 1:</h5>
                    {{Student.o_level_1}}
                  </div>
                  <div class="col-12 border-left-danger shadow-sm" v-if="Student.o_level_2">
                    <h5 class="px-2 btn-primary">O level 2:</h5>
                    {{Student.o_level_2}}
                  </div>

                  <div class="col-12 border-left-danger shadow-sm">
                    <h5 class="text-center btn-primary">{{current_exam.exam}} Scores</h5>
                  </div>

                  <div
                    class="col-3 border-left-danger"
                    v-for="score in Student.scores"
                    :key="score.id"
                  >
                    <h5 class="btn-primary text-center">
                      {{score.course.course}}
                      <p>
                        <b>{{score.marks}}</b>
                      </p>
                    </h5>
                  </div>
                  <div class="col-12 border-left-danger shadow-sm">
                    <h5 class="text-center btn-primary">
                      Total Marks:
                      <p>
                        <b>{{Student.total}}</b>
                      </p>
                    </h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import readXlsxFile from "read-excel-file";
import Printd from "printd";
export default {
  data() {
    return {
      columns: [
        {
          label: "Application No.",
          name: "app_number",
          filterable: true
        },
        {
          label: "Full Name",
          name: "fullname",
          filterable: true
        },
        {
          label: "Gender",
          name: "gender",
          filterable: true
        },
        {
          label: "State",
          name: "state_of_origin",
          filterable: true
        },
        {
          label: "LGA",
          name: "lga_of_origin",
          filterable: true
        },
        {
          label: "Phone",
          name: "phone",
          filterable: true
        },
        {
          label: "Entry",
          name: "mode_of_entry",
          filterable: true
        },
        {
          label: "",
          name: "View",
          filterable: false,
          classes: {
            btn: true,
            "btn-danger": true,
            "btn-sm": true,
            font: "fas fa-eye"
          },
          event: "click",
          handler: this.viewStudent,
          component: DataButtonVue
        }
      ],
      classes: {
        table: {
          table: true,
          "table-striped": true,
          "table-bordered": true,
          "text-white": true
        }
      },
      editMode: true,
      data_table_key: 1,
      data_table_url: null,
      form: new Form({
        app_number: "",
        fullname: "",
        gender: "",
        state_of_origin: "",
        lga_of_origin: "",
        email: "",
        phone: "",
        mode_of_entry: "",
        first_choice: "",
        second_choice: "",
        o_level_1: "",
        o_level_2: "",
        department_id: ""
      }),
      uploadForm: new Form({
        department_id: null,
        students: []
      }),
      departments: [],
      current_exam: [],
      Student: Object,
      uploadResponse: "",
      departmentStudents: null,
      recommendations: [
        "BMA",
        "BMT",
        "CHEW",
        "JCHW",
        "ND-DT",
        "DST",
        "EVT",
        "ND-EH",
        "PDHIM",
        "NDHIM",
        "MLT",
        "PTP"
      ],
      departments: [],
      department: null,
      exams: [],
      examResult: null
    };
  },
  created() {
    this.getDeprtments();
  },
  methods: {
    updateDataTable() {
      this.data_table_key
        ? (this.data_table_key = 0)
        : (this.data_table_key = 1);
    },
    getDeprtments() {
      axios.get("department").then(res => {
        this.departments = res.data.data;
      });
    },
    viewStudent(student) {
      //   this.Student = student;
      // axios
      //   .get(`get_student_score/${current_exam}/${student.id}/`)
      //   .then(res => {
      //     this.departmentStudents = res.data;
      //   });
      let result = this.examResult.students.find(stu => stu.id === student.id);
      if (result) {
        this.Student = result;
      }

      $("#viewStudent").modal("show");
    },
    getDepartmentStudents(e) {
      axios.get(`get_department_students/${e.target.value}`).then(res => {
        this.departmentStudents = res.data;
      });
    },
    recommend(e) {
      axios
        .post(`recommendation/${this.Student.id}/${e.target.value}`)
        .then(res => {
          e.target.value = "";
        });
    },

    getFilterOptions() {
      axios.get("department").then(res => {
        this.departments = res.data.data;
      });
    },
    getDeptExams(e) {
      this.department = e.target.value;
      axios.get(`department_exams/${this.department}`).then(res => {
        this.exams = res.data;
      });
    },
    getExamScores(e) {
      this.current_exam = this.exams.find(exm => exm.id == e.target.value);
      if (this.current_exam.id) {
        axios
          .get(`exam_scores/${this.department}/${this.current_exam.id}`)
          .then(res => {
            this.examResult = res.data;
          });
        this.data_table_url = "get_students";
      }
    }
  },
  created() {
    this.getFilterOptions();
  }
};
</script>
<style scoped>
</style>

