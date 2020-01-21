<template>
  <div class="col-md-12">
    <div class="row d-flex justify-content-between px-3">
      <export-excel
        class="btn btn-secondary btn-sm mb-1"
        :data="examResult.students"
        :meta="result_meta"
        worksheet="Result"
        :name="`${examResult.exam}.xls`"
      >
        Download Excel
        <i class="fas fa-file-excel"></i>
      </export-excel>
      <button type="button" class="btn btn-success btn-sm ml-auto" @click="printDoc">
        Print
        <i class="fas fa-print"></i>
      </button>
    </div>

    <span ref="resultTable">
      <h4 class="text-white text-center">{{examResult.exam}}</h4>

      <table class="table table-bordered table-condensed table-hover table-responsive">
        <thead>
          <tr>
            <th>Application No.</th>
            <th>Name</th>
            <th>Phone</th>
            <th>State</th>
            <th>LGA</th>
            <th v-show="print">1ST Choice</th>
            <th v-show="print">2ND Choice</th>
            <th v-show="print">O-leve 1</th>
            <th v-show="print">O-level 2</th>
            <th>Courses</th>
            <th>Total</th>
            <th v-show="print">Remark</th>
            <th v-show="print">Recmd</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="student in examResult.students" :key="student.id">
            <td>{{student.app_number}}</td>
            <td>{{student.fullname}}</td>
            <td>{{student.phone}}</td>
            <td>{{student.state_of_origin}}</td>
            <td>{{student.lga_of_origin}}</td>
            <td v-show="print">{{student.first_choice}}</td>
            <td v-show="print">{{student.second_choice}}</td>
            <td v-show="print">{{student.o_level_1}}</td>
            <td v-show="print">{{student.o_level_2}}</td>
            <td>
              <div class="border-bottom-white" v-for="score in student.scores" :key="score.id">
                <small>{{score.course.course}}: {{score.marks}}</small>
              </div>
            </td>
            <td>{{student.total}}</td>
            <td v-show="print"></td>
            <td v-show="print"></td>
          </tr>
        </tbody>
      </table>
    </span>
  </div>
</template>

<script>
import Printd from "printd";
export default {
  data() {
    return {
      print: false,
      result_fields: {
        "Application No": "app_number",
        Name: "fullname",
        Gender: "gender",
        Courses: {
          field: "courses",
          callback: value => {
            return `${value.course} : ${value}`;
          }
        },
        Total: "total"
      },
      result_meta: [
        [
          {
            key: "charset",
            value: "utf-8"
          }
        ]
      ]
    };
  },
  props: {
    examResult: Object
  },
  methods: {
    printDoc() {
      this.print = !this.print;
      const cssText = `
        table {
                color:black;
                border-collapse: collapse;
                width: 100%;
            }
            th {
                color:#810412;
                height: 30px;
                padding-top: 2px;
                padding-bottom: 1px;
            }
            tr:nth-child(even) {
                background-color: #f2f2f2;
            }
            td {
                height: 20px;
                padding: 2px;
                text-align: center;
            }
            table, th, td {
                border: 1px solid black;
            }
       `;
      const d = new Printd();
      d.print(this.$refs.resultTable, [cssText]);
    }
  }
};
</script>

<style>
</style>
