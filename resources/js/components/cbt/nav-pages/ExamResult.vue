<template>
  <div class="card bg-gradient-primary border-left-danger">
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <div class="row d-flex justify-content-center">
            <div class="form-group col-3">
              <select
                class="form-control form-control-sm"
                @change="getDeptExams"
              >
                <option value selected>Departments</option>
                <option
                  v-for="department in departments"
                  :key="department.id"
                  :value="department.id"
                >
                  {{ department.department }}
                </option>
              </select>
            </div>

            <div class="form-group col-3">
              <select
                class="form-control form-control-sm"
                @change="getExamScores"
              >
                <option value selected>Exams</option>
                <option v-for="exam in exams" :key="exam.id" :value="exam.id">
                  {{ exam.exam }}
                </option>
              </select>
            </div>
          </div>
          <hr class="p-0 m-0 bg-white" />
        </div>
        <!-- result table -->
        <result-table v-if="examResult" :examResult="examResult"></result-table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      departments: [],
      department: null,
      //   courses: [],
      exams: [],
      examResult: null,
    };
  },
  methods: {
    getFilterOptions() {
      //   axios.all([axios.get("department"), axios.get("course")]).then(
      //     axios.spread((departments, courses) => {
      //       this.departments = departments.data.data;
      //       this.courses = courses.data.data;
      //     })
      //   );
      axios.get("department").then((res) => {
        this.departments = res.data.data;
      });
    },
    getDeptExams(e) {
      this.department = e.target.value;
      axios.get(`department_exams/${this.department}`).then((res) => {
        this.exams = res.data;
      });
    },
    getExamScores(e) {
      let exam_id = e.target.value;
      if (exam_id) {
        axios.get(`exam_scores/${this.department}/${exam_id}`).then((res) => {
          this.examResult = res.data;
        });
      }
    },
  },
  created() {
    this.getFilterOptions();
  },
};
</script>

<style></style>
