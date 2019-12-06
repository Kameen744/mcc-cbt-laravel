<template>
    <div class="card text-white bg-gradient-primary border-left-danger">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div>
                            <h6 class="card-title">Students</h6>
                        </div>
                        <div class="flex-grow-1">
                            <button @click="showModal('upload')" type="button" 
                            class="btn btn-danger btn-sm float-right mx-2 ">
                            <i class="fas fa-plus-circle"></i> Upload Students</button>

                            <button @click="showModal(null)" type="button" 
                            class="btn btn-danger btn-sm float-right">
                            <i class="fas fa-plus-circle"></i> Add Student</button>
                        </div>
                    </div>
                    <div class="col-12 p-0 mb-1"><hr class="p-0 m-0 bg-white"></div>
                    <data-table :columns="columns" :key="data_table_key"
                    :classes="classes" url="get_students"></data-table>
                </div>
            </div>
        </div>
        <div class="modal swal2-modal swal2-show" id="viewStudent" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header py-1">
                        <h5 class="modal-title text-primary">Student</h5>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            
                            <div class="row shadow-sm justify-content-center">
                                <div class="col-md-auto">
                                    <button @click="showModal(Student)"
                                    class="btn btn-info btn-sm">
                                    <i class="fas fa-edit"></i> Edit</button>
                                </div>
                                <div class="col-md-auto">
                                    <button @click="delStudent(Student.id)"
                                    class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Delete</button>
                                </div>
                            </div>
                            <div class="card-body shadow-sm text-dark">
                                <h4 class="card-title text-center text-dark">{{Student.fullname}}</h4>
                                <h5 class="card-title">Code: {{Student.app_number}}</h5>
                                <h5 class="card-title">Created on {{Student.created_at | myDate}}</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-6 border-left-danger shadow-sm">First Choice: {{Student.first_choice}}</div>
                                    <div class="col-6 border-left-danger shadow-sm">Second Choice: {{Student.second_choice}}</div>
                                    <div class="col-6 border-left-danger shadow-sm">Phone: {{Student.phone}}</div>
                                    <div class="col-6 border-left-danger shadow-sm">Password: {{Student.vn_number}}</div>
                                    <div class="col-12 border-left-danger shadow-sm">Admission No.: {{Student.admission_number}}</div>
                                    <div class="col-12 border-left-danger shadow-sm">O level 1: {{Student.o_level_1}}</div>
                                    <div class="col-12 border-left-danger shadow-sm">O level 2: {{Student.o_level_2}}</div>
                                </div>
                            </div>
                             
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- upload students modal -->
        <div class="modal swal2-modal swal2-show" id="studentsUploadModal" 
        tabindex="1" role="dialog" ref="uploadModal"
        aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header py-1">
                        <h5 class="text-dark">Upload Students</h5>
                    </div>
                    <div class="modal-body overflow-auto px-3 h-auto" ref="uploadContainer">
                        <h6 v-if="uploadResponse" class="text-center text-danger">{{uploadResponse}}</h6>
                        <div class="row">
                            <div class="filezone col-md-8">
                                <input type="file" id="files" ref="files" 
                                multiple @change="handleFiles"/>
                                <h6 class="text-center">
                                  Drop your MS.Excel .XLSX files here or click to search.
                                </h6>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group p-0 m-0 mb-2">
                                    <select v-model="uploadForm.department_id" 
                                    class="form-control form-control-sm"
                                    :class="{ 'is-invalid': uploadForm.errors.has('department_id') }">
                                        <option value="" selected>Department</option>
                                        <option 
                                        v-for="(dept, key) in departments" :key="key"
                                        :value="dept.id">{{dept.department}}</option>
                                    </select>
                                    <has-error :form="uploadForm" field="department_id"></has-error>
                                </div>
                                <button :disabled="uploadForm.busy" type="button" @click="uploadStudents" 
                                class="btn btn-danger btn-sm btn-lg btn-block">Upload</button>
                            </div>
                        </div>
                        <div class="row">
                            <table class="table table-bordered bg-gradient-primary" 
                            v-if="uploadForm.students[0]">
                                <thead>
                                    <tr>
                                        <th v-for="(th_col, key) in uploadForm.students[0].slice(0, 6)" 
                                        :key="key">
                                        </th>    
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(tr_data, tr_key) in uploadForm.students" :key="tr_key"> 
                                        <td v-for="(td_data, td_key) in tr_data.slice(0, 6)" 
                                        :key="td_key" :class="!td_data ? 'bg-danger' : '' ">
                                            {{td_data}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
        <!-- Add new student Modal -->
        <div class="modal swal2-modal swal2-show" id="studentModal" tabindex="1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header py-1">
                        <h5 v-show="!editMode" class="modal-title text-primary">Add New Student</h5>
                        <h5 v-show="editMode" class="modal-title text-warning">Edit Student</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent=" editMode ? editStudent() : newStudent() ">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <input-tag :groupClass="'form-group col-md-6'"
                                :form="form" :type="'text'" :name="'app_number'" 
                                :placeholder="'Application Number'">
                                </input-tag>

                                <input-tag :groupClass="'form-group col-md-6'"
                                :form="form" :type="'text'" :name="'fullname'" 
                                :placeholder="'Full Name'">
                                </input-tag>
                            </div>
                            <div class="row">
                                <input-tag :groupClass="'form-group col-md-6'"
                                :form="form" :type="'text'" :name="'gender'" 
                                :placeholder="'Gender'">
                                </input-tag>

                                <input-tag :groupClass="'form-group col-md-6'"
                                :form="form" :type="'text'" :name="'state_of_origin'" 
                                :placeholder="'State of origin'">
                                </input-tag>
                            </div>
                            <div class="row">
                                <input-tag :groupClass="'form-group col-md-6'"
                                :form="form" :type="'text'" :name="'lga_of_origin'" 
                                :placeholder="'LG of origin'">
                                </input-tag>

                                <input-tag :groupClass="'form-group col-md-6'"
                                :form="form" :type="'text'" :name="'email'" 
                                :placeholder="'email'">
                                </input-tag>
                            </div>
                            <div class="row">
                                <input-tag :groupClass="'form-group col-md-6'"
                                :form="form" :type="'text'" :name="'phone'" 
                                :placeholder="'Phone'">
                                </input-tag>

                                <div class="form-group col-md-6">
                                    <select v-model="form.mode_of_entry" name="mode_of_entry" 
                                    class="form-control form-control-sm"
                                    :class="{ 'is-invalid': form.errors.has('mode_of_entry') }">
                                        <option value="" disabled>Mode of entry</option>
                                        <option value="Fresh">Fresh</option>
                                        <option value="Retraining">Retraining</option>
                                    </select>
                                    <has-error :form="form" field="mode_of_entry"></has-error>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" v-model="form.first_choice" name="first_choice" 
                                class="form-control form-control-sm" placeholder="First choice"
                                :class="{ 'is-invalid': form.errors.has('first_choice') }">
                                <has-error :form="form" field="first_choice"></has-error>
                            </div>

                            <div class="form-group">
                                <input type="text" v-model="form.second_choice" name="second_choice" 
                                class="form-control form-control-sm" placeholder="Second choice"
                                :class="{ 'is-invalid': form.errors.has('second_choice') }">
                                <has-error :form="form" field="second_choice"></has-error>
                            </div>
                            
                            <div class="form-group">
                                <input type="text" v-model="form.o_level_1" name="o_level_1" 
                                class="form-control form-control-sm" placeholder="O-Level 1"
                                :class="{ 'is-invalid': form.errors.has('o_level_1') }">
                                <has-error :form="form" field="o_level_2"></has-error>
                            </div>

                            <div class="form-group">
                                <input type="text" v-model="form.o_level_2" name="o_level_2" 
                                class="form-control form-control-sm" placeholder="O-Level 2"
                                :class="{ 'is-invalid': form.errors.has('o_level_2') }">
                                <has-error :form="form" field="o_level_2"></has-error>
                            </div>

                            <div class="form-group">
                                <select v-model="form.department_id" name="department_id" 
                                class="form-control form-control-sm"
                                :class="{ 'is-invalid': form.errors.has('department_id') }">
                                    <option value="" disabled>Department</option>
                                    <option 
                                    v-for="(dept, key) in departments" :key="key"
                                    :value="dept.id">{{dept.department}}</option>
                                </select>
                                <has-error :form="form" field="department_id"></has-error>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer py-1">
                        <div class="form-group" v-show="!editMode">
                            <button  :disabled="form.busy" type="submit" class="btn btn-primary btn-sm btn-block">
                           <i class="fas fa-plus-circle"></i>  Create</button>
                        </div>
                        <div class="form-group" v-show="editMode">
                            <button  :disabled="form.busy" type="submit" class="btn btn-warning btn-sm btn-block">
                            <i class="fas fa-edit"></i>  Update </button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import readXlsxFile from 'read-excel-file';
export default {
    data() {
        return {
            columns: [
                {
                    label: 'Application No.',
                    name: 'app_number',
                    filterable: true,
                },
                {
                    label: 'Full Name',
                    name: 'fullname',
                    filterable: true,
                },
                {
                    label: 'Gender',
                    name: 'gender',
                    filterable: true,
                },
                {
                    label: 'State',
                    name: 'state_of_origin',
                    filterable: true,
                },
                {
                    label: 'LGA',
                    name: 'lga_of_origin',
                    filterable: true,
                },
                {
                    label: 'Phone',
                    name: 'phone',
                    filterable: true,
                },
                {
                    label: 'Entry',
                    name: 'mode_of_entry',
                    filterable: true,
                },
                {
                    label: '',
                    name: 'View',
                    filterable: false,
                    classes: { 
                        'btn': true,
                        'btn-danger': true,
                        'btn-sm': true,
                    },
                    event: "click",
                    handler: this.viewStudent,
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
            editMode: true,
            data_table_key: 1,
            form: new Form({
                app_number: '',
                fullname: '',
                gender: '',
                state_of_origin: '',
                lga_of_origin: '',
                email: '',
                phone: '',
                mode_of_entry: '',
                first_choice: '',
                second_choice: '',
                o_level_1: '',
                o_level_2: '',
                department_id: '',
            }),
            uploadForm: new Form({
                department_id: null,
                students: []
            }),
            departments: [], 
            Student: Object,
            uploadResponse: ''
        }
    },
    created() {
        this.getDeprtments();
    },
    methods: {
        updateDataTable() {
            this.data_table_key ? this.data_table_key = 0 : this.data_table_key = 1;
        },
        getDeprtments() {
            axios.get('department')
            .then(res => {
                this.departments = res.data.data;
            })
        },
        viewStudent(student) {
            this.Student = student;
            $('#viewStudent').modal('show');
            console.log(student);
        },
        newStudent() {
            this.$Progress.start();
            this.form.post(`student`)
            .then(res  => { 
                this.updateDataTable();
                Toast.fire({
                    type: 'success',
                    title: 'created successfully'
                });
                this.form.reset();
            });
            this.$Progress.finish();
        },
        handleFiles(e) {
            let file = e.target.files[0];
            let loader = this.$loading.show({
                container: this.$refs.uploadContainer,
                canCancel: false,
            });
            readXlsxFile(file).then((rows) => {
                this.uploadForm.students = rows;
                loader.hide();
            });
        },
        uploadStudents() {
            this.uploadForm.post(`student`)
            .then(res => {
               this.uploadResponse = res.data;
               this.uploadForm.reset();
               this.updateDataTable();
            });
        },
        editStudent() {
            this.$Progress.start();
            this.form.put(`student/${this.form.id}`)
            .then(res  => { 
                this.Student = res.data;
                this.updateDataTable();
                Toast.fire({
                    type: 'success',
                    title: 'updated successfully'
                });
                this.form.reset();
                 $('#studentModal').modal('hide');
            });
            this.$Progress.finish();
        },
        delStudent(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0f442e',
                cancelButtonColor: '#810412',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.value) {
                    axios.delete(`student/${id}`)
                    .then(res => {
                        this.Student = res.data;
                        this.updateDataTable();
                        $('#viewStu').modal('hide');
                        $('#studentModal').modal('hide');
                         Swal.fire(
                        'Deleted!',
                        'Student has been deleted.',
                        'success'
                        )
                    })
                }
            })
        },
        showModal(student){
            if(student){
                if(student === 'upload') {
                    $('#studentsUploadModal').modal('show');
                } else {
                    this.editMode = true;
                    $('#studentModal').modal('show');
                    this.form.reset();
                    this.form.clear();
                    this.form.fill(student);
                    this.form.id = student.id;
                }
            }else{
                this.editMode = false;
                $('#studentModal').modal('show');
                this.form.reset();
                this.form.clear();
            } 
        }
    }
}
</script>
<style scoped>
    .modal-body {
        max-height: 500px;
        overflow-y: auto;
    }
    input[type="file"]{
        opacity: 0;
        width: 100%;
        height: 70px;
        position: absolute;
        cursor: pointer;
    }
    .filezone {
      outline: 2px dashed grey;
      outline-offset: -10px;
      background: #ccc;
      color: dimgray;
      padding: 10px 10px;
      height: 70px;
      position: relative;
      cursor: pointer;
    }
    .filezone:hover {
      background: #c0c0c0;
    }
</style>

