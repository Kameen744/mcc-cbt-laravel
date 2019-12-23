<template>
    <div class="card bg-gradient-primary border-left-success">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title">Exam</h4>
                        </div>
                        <button @click="showExamModal(null)" type="button" 
                            class="float-right btn btn-danger btn-sm">
                            <i class="fas fa-plus-circle"></i> Create Exam
                        </button>
                    </div>
                    <div class="col-12 p-0 mb-1"><hr class="p-0 m-0 bg-white"></div>
                    <data-table :columns="columns" :key="data_table_key"
                    :classes="classes" :font="font" url="exam"></data-table>
                </div>
            </div>
        </div>
        <!-- ----------Exam Modal ------------------->
        <div class="modal swal2-show" id="examModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header py-1">
                        <h5 v-show="!editExamMode" class="modal-title text-primary">New Exam</h5>
                        <h5 v-show="editExamMode" class="modal-title text-warning">Edit Exam</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent=" editExamMode ? editExam() : newExam() ">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Exam name/description</label>
                                    <input-tag :groupClass="'form-group'"
                                        :form="form" :type="'text'" :name="'exam'" 
                                        :placeholder="'Exam e.g First Entrance Exam'">
                                    </input-tag>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Date</label>
                                    <input-tag :groupClass="'form-group'"
                                        :form="form" :type="'date'" :name="'exam_date'" 
                                        :placeholder="'Exam Date'">
                                    </input-tag>
                                </div>
                                <div class="col-md-6">
                                    <label>Time</label>
                                    <input-tag :groupClass="'form-group'"
                                        :form="form" :type="'time'" :name="'exam_time'" 
                                        :placeholder="'Exam Time'">
                                    </input-tag>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="text-center">Exam Duration</h5>
                                </div>
                                <div class="col-md-6">
                                    <label>Hours</label>
                                    <input-tag :groupClass="'form-group'"
                                        :form="form" :type="'number'" :name="'exam_hours'" 
                                        :placeholder="'Hours'">
                                    </input-tag>
                                </div>
                                <div class="col-md-6">
                                    <label>Minutes</label>
                                    <input-tag :groupClass="'form-group'"
                                        :form="form" :type="'number'" :name="'exam_minutes'" 
                                        :placeholder="'Hours'">
                                    </input-tag>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer py-1">
                            <div class="form-group" v-show="!editExamMode">
                                <button  :disabled="form.busy" type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus-circle"></i> Create Exam</button>
                            </div>
                            <div class="form-group" v-show="editExamMode">
                                <button  :disabled="form.busy" type="submit" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>  Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>  
        <!-- ----------------View Exam Modal ------------------------ -->
        <div class="modal swal2-modal swal2-show" id="viewCourse" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header py-1">
                        <h5 class="modal-title text-primary">{{exam.exam}}</h5>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row shadow-sm justify-content-center">
                                <!-- <div class="col-md-auto">
                                    <button @click="viewExamModal(exam)"
                                    class="btn btn-success btn-sm">
                                    <i class="fas fa-eye"></i> View</button>
                                </div> -->
                                <div class="col-md-auto">
                                    <button @click="settingExamModal(exam)"
                                    class="btn btn-warning btn-sm">
                                    <i class="fas fa-wrench"></i> Settings</button>
                                </div>
                                <!-- <div class="col-md-auto">
                                    <button @click="showExamModal(exam)"
                                    class="btn btn-info btn-sm">
                                    <i class="fas fa-edit"></i> Edit</button>
                                </div> -->
                                <div class="col-md-auto">
                                    <button @click="deleteExam(exam.id)"
                                    class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Delete</button>
                                </div>
                            </div>
                            <div class="card-body shadow-sm text-white bg-primary viewModalBody">
                                
                                    <h4 class="card-title text-center">{{exam.exam}}</h4>
                                    <div class="row">
                                        <p class="col-3">Date:</p><p class="col-8">{{exam.exam_date | myDate}}</p>
                                        <p class="col-3">Time:</p><p class="col-8">{{exam.exam_time | myTime}}</p>
                                        <p class="col-3">Duration:</p>
                                        <p class="col-8">{{exam.exam_hours}}hr(s) {{exam.exam_minutes}}min(s)</p>
                                        <div v-if="examSections[0]" class="col-12">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Course</th>
                                                        <th>Section</th>
                                                        <th>No of Q</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="section in examSections" :key="section.id">
                                                        <td>{{section.course}}</td>
                                                        <td>{{section.section}}</td>
                                                        <td>{{section.no_questions}}</td>
                                                    </tr>
                                                    <tr v-if="examSections[0]">
                                                        <th>Total Questions</th>
                                                        <th colspan="3" class="text-center">
                                                            {{examSections[0].ttquestions}}
                                                        </th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <hr>
                                            <table v-if="examDepartments[0]" 
                                            class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Department</th>
                                                        <th>Code</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="department in examDepartments" :key="department.id">
                                                        <td>{{department.department}}</td>
                                                        <td>{{department.department_code}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <hr>
                                        </div>
                                    </div>
                                
                            </div>
                             
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- ---------- Settings Modal ----------------->
        <div class="modal swal2-show" id="settingModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header py-1">
                        <h5 class="modal-title" id="settingTitle">Exam Settings</h5>
                    </div>
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <h4 class="card-title text-center">{{exam.exam}}</h4>
                            <div class="row">
                                <div class="col-6">
                                    <h6 class="text-white text-center">Set Courses/Sections</h6>
                                    <div class="input-group">                                        
                                        <select id="course" @change="addExamCourse" v-model="setCourseForm.course_id" 
                                        name="course_id">
                                            <option disabled selected>Course</option>
                                            <option v-for="course in courses" 
                                            :key="course.id" :value="course.id">
                                                {{course.course}}
                                            </option>
                                        </select>
                                        
                                        <select data-toggle="tooltip" title="Section" v-model="setCourseForm.section_id" id="section">
                                            <option v-for="section in sections" :key="section.id"
                                            :value="section.id">
                                                {{section.section}}   
                                            </option>
                                        </select> 
                                        
                                        <input data-toggle="tooltip" title="No. of questions" class="inp-sm" type="number" v-model="setCourseForm.no_questions">
                                        
                                        <div class="input-group-btn">
                                            <button @click="addCourseSections"
                                            data-toggle="tooltip" title="Set course & no of questions">
                                                <i class="fas fa-plus-circle"></i> Add
                                            </button>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-white text-center">Set Departments</h6>
                                    <div class="input-group">
                                        <select v-model="department_id" 
                                        class="float-right form-control form-control-sm" 
                                            name="course" id="course">
                                            <option selected disabled>Department</option>
                                            <option v-for="department in departments" :key="department.id" :value="department.id">
                                                {{department.department}}
                                            </option>
                                        </select>
                                        <div class="input-group-btn">
                                            <button @click="addExamDepartments"
                                            data-toggle="tooltip" title="Set Departments">
                                                <i class="fas fa-plus-circle"></i> Add
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div  class="col-md-6">
                                    <hr>
                                    <table v-if="examSections[0]" 
                                    class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Course</th>
                                                <th>Section</th>
                                                <th>No of Q</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="section in examSections" :key="section.id">
                                                <td>{{section.course}}</td>
                                                <td>{{section.section}}</td>
                                                <td>{{section.no_questions}}</td>
                                                <td>
                                                    <button class="rounded-circle btn-danger" @click="delExamSection(section.id)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr v-if="examSections[0]">
                                                <th>Total Questions</th>
                                                <th colspan="3" class="text-center">{{examSections[0].ttquestions}}</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div  class="col-md-6">
                                    <hr>
                                    <table v-if="examDepartments[0]" 
                                    class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Department</th>
                                                <th>Code</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="department in examDepartments" :key="department.id">
                                                <td>{{department.department}}</td>
                                                <td>{{department.department_code}}</td>
                                                <td>
                                                    <button class="rounded-circle btn-danger" 
                                                    @click="delExamDepartment(department.id)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <hr>
                            <button @click="settingExamModal(null)" class="btn btn-danger btn-sm">
                            <i class="fas fa-times"></i> Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    data(){
        return {
            columns: [
                {
                    label: 'Exam',
                    name: 'exam',
                    filterable: true,
                },
                {
                    label: 'Exam Date',
                    name: 'exam_date',
                    filterable: true,
                },
                {
                    label: 'Created',
                    name: 'created_at',
                    filterable: true,
                },
                {
                    name: '  View',
                    filterable: false,
                    classes: { 
                        'btn': true,
                        'btn-info': true,
                        'btn-sm': true,
                        font: 'fas fa-eye'
                    },
                    event: "click",
                    handler: this.viewExam,
                    component: DataButtonVue, 
                },
                {
                    name: '  Edit',
                    filterable: false,
                    classes: { 
                        'btn': true,
                        'btn-warning': true,
                        'btn-sm': true,
                        font: 'fas fa-edit'
                    },
                    event: "click",
                    handler: this.showExamModal,
                    component: DataButtonVue, 
                }
            ],
            classes: { 
                table: {
                    'table': true,
                    'table-striped': true,
                    'table-bordered': true,
                    'text-white': true
                }
            },
            font: 'fas fa-eye',
            departments: [],
            editExamMode: false,
            form: new Form({
                exam: '',
                exam_date: '',
                exam_time: '',
                exam_hours: '',
                exam_minutes: ''
            }),
            setCourseForm: new Form({
                exam_id: '',
                course_id: '',
                section_id: '',
                no_questions: ''
            }),
            data_table_key: 0,
            examSections: [],
            examDepartments: [],
            department_id: '',
            exams: '',
            exam: '',
            courses: '',
            course: '',
            sections: '',
            section: ''
        }
    },
    created(){
        axios.get(`department`)
        .then(res => {
            this.departments = res.data.data; 
        });
        
    },
    methods: {
        updateDataTable() {
            this.data_table_key ? this.data_table_key = 0 : this.data_table_key = 1;
        },
        getDeptExams(e){
            this.$Progress.start();
            axios.get(`department/exam/${e.target.value}`)
            .then(res => {
                this.exams = res.data;
            });
            this.$Progress.finish();
        },
        showExamModal(exam){
            if(exam){
                this.editExamMode = true;
                this.form.id = exam.id;
                $('#examModal').modal('show');
                this.form.clear();
                this.form.reset();
                this.form.fill(exam); 
            }else {
                this.editExamMode = false;
                $('#examModal').modal('show');
                this.form.clear();
                this.form.reset();
            }
        },
        newExam(){
            this.$Progress.start();
            this.form.post(`exam`)
            .then(res => {
                this.exams = res.data;
                Toast.fire({
                    type: 'success',
                    title: 'saved successfully'
                });
                this.form.reset();
                this.updateDataTable();
            });
            this.$Progress.finish();
        },
        viewExam(exam) {
            this.exam = exam;
            axios.all([
                axios.get(`exam/sections/${exam.id}`),
                axios.get(`exam/departments/${exam.id}`)
            ])
            .then(axios.spread((examSectionsRes, exmaDepartmentsRes) => {
                this.examSections = examSectionsRes.data;
                this.examDepartments = exmaDepartmentsRes.data;
            }));
            $('#viewCourse').modal('show');
        },
        settingExamModal(exam){
            if(exam){
                this.setCourseForm.exam_id = exam.id;
                this.exam = exam;
                axios.all([
                    axios.get(`exam/sections/${exam.id}`),
                    axios.get(`exam/departments/${exam.id}`),
                    axios.get('course')
                ])
                .then(axios.spread((examSectionsRes, examDeptRes, coursesRes) => {
                    this.examSections = examSectionsRes.data;
                    this.examDepartments = examDeptRes.data;
                    this.courses = coursesRes.data.data;
                }));
                $('#settingModal').modal('show');
            }else{
                $('#settingModal').modal('hide');
            }
        },
        addExamCourse(e){
            this.setCourseForm.section_id = '';
             axios.get(`course/${e.target.value}`)
                .then(res => {
                    this.sections = res.data;
                });
        },
        addCourseSections(){
            this.setCourseForm.post(`exam/course_section`)
            .then(res => {
            this.examSections = res.data;
            });
        },
        addExamDepartments() {
            axios.post(`exam_set_dept/${this.exam.id}/${this.department_id}`)
            .then(res => {
                this.examDepartments = res.data;
            });
        },
        editExam(){
            this.$Progress.start();
                this.form.put(`exam/${this.form.id}`)
                .then(res => {
                    this.exams = res.data;
                    $('#examModal').modal('hide');
                     Toast.fire({
                        type: 'success',
                        title: 'updated successfully'
                    });
                    this.updateDataTable();
                });
            this.$Progress.finish();
        },
        deleteExam(id) {
             Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0f442e',
                cancelButtonColor: '#810412',
                confirmButtonText: 'Yes, delete it!'
                })
                .then((result) => {
                if (result.value) {
                    axios.delete(`exam/${id}`)
                    .then(res => {
                        this.exams = res.data;
                         Swal.fire(
                        'Deleted!',
                        'Exam has been deleted.',
                        'success'
                        );
                        this.updateDataTable();
                    })
                }
            });
        },
        delExamSection(id) {
            axios.get(`exam/del_exam_section/${id}`)
            .then(res => {
                this.examSections = res.data;
            })
        },
        delExamDepartment(id) {
            axios.get(`exam/del_exam_department/${this.exam.id}/${id}`)
            .then(res => {
                this.examDepartments = res.data;
            });
        }
    }
}
</script>
<style scoped>
    .viewModalBody {
        max-height: 550px;
        overflow-x: auto;
    }
    .input-group select, .input-group input {
        max-width: 100px;
    }

</style>

