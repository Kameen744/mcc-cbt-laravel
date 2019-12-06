<template>
    <div class="card text-white bg-gradient-primary border-left-danger">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title">Departments List</h4>
                        </div>
                        <div class="col-md-6">
                            <button @click="showModal(null)" type="button" class="btn btn-danger btn-sm float-right"><i class="fas fa-plus-circle"></i> Add Department</button>
                        </div>
                    </div>
                    <div class="col-12 p-0 mb-1"><hr class="p-0 m-0 bg-white"></div>
                    <data-table :columns="columns" :key="data_table_key"
                    :classes="classes" url="department"></data-table>
                </div>
            </div>
        </div>
        <div class="modal swal2-modal swal2-show" id="viewDept" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header py-1">
                        <h5 class="modal-title text-primary">Department</h5>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            
                            <div class="row shadow-sm justify-content-center">
                                <div class="col-md-auto">
                                    <button @click="showModal(department)"
                                    class="btn btn-info btn-sm">
                                    <i class="fas fa-edit"></i> Edit</button>
                                </div>
                                <div class="col-md-auto">
                                    <button @click="delDeptartment(department.id)"
                                    class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Delete</button>
                                </div>
                            </div>
                            <div class="card-body shadow-sm text-dark">
                                <h4 class="card-title">{{department.department}}</h4>
                                <h5 class="card-title">Code: {{department.department_code}}</h5>
                                <h5 class="card-title">Created on {{department.created_at | myDate}}</h5>
                            </div>
                             
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal swal2-modal swal2-show" id="deptModal" tabindex="1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header py-1">
                        <h5 v-show="!editMode" class="modal-title text-primary">Add New Department</h5>
                        <h5 v-show="editMode" class="modal-title text-warning">Edit Department</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent=" editMode ? editDepartment() : newDepartment() ">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="form-group">
                                <input type="text" v-model="form.department" name="department" 
                                class="form-control form-control-sm" placeholder="Department" 
                                :class="{ 'is-invalid': form.errors.has('department') }">
                                <has-error :form="form" field="department"></has-error>
                            </div>

                            <div class="form-group">
                                <input type="text" v-model="form.department_code" name="department_code" 
                                class="form-control form-control-sm" placeholder="Department Code"
                                :class="{ 'is-invalid': form.errors.has('department_code') }">
                                <has-error :form="form" field="department_code"></has-error>
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
// import DataButtonVue from '../../DataButton.vue';
export default {
    data() {
        return {
            columns: [
                {
                    label: 'ID',
                    name: 'id',
                    filterable: true,
                },
                {
                    label: 'Department',
                    name: 'department',
                    filterable: true,
                },
                {
                    label: 'Code',
                    name: 'department_code',
                    filterable: true,
                },
                {
                    label: 'Created',
                    name: 'created_at',
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
                    handler: this.viewDepartment,
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
                department: '',
                department_code: '',
            }),
            deptData: {
                department: null,
                department_code: null,
               
            }, 
            errors: [],
            department: Object,
            // departments: [],
        }
    },
    created() {
        // this.getDepartments();
    },
    props: [
        'csrfkey'
    ],

    methods: {
        validate() {
            if(this.deptData.department && this.deptData.department_code){
                return true;
            }

            this.errors = [];

            if(!this.deptData.department){
                this.errors.push('Department is required');
            }

            if(!this.deptData.department_code){
                this.errors.push('Department code required');
            }

            return false;
        },
        updateDataTable() {
            this.data_table_key ? this.data_table_key = 0 : this.data_table_key = 1;
        },
        viewDepartment(dept) {
            this.department = dept;
            $('#viewDept').modal('show');
        },
        newDepartment() {
            this.$Progress.start();
            this.form.post(`department`)
            .then(res  => { 
                this.department = res.data;
                this.updateDataTable();
                Toast.fire({
                    type: 'success',
                    title: 'created successfully'
                });
                this.form.reset();
            });
            this.$Progress.finish();
        },
        editDepartment() {
            this.$Progress.start();
            this.form.put(`department/${this.form.id}`)
            .then(res  => { 
                this.department = res.data;
                this.updateDataTable();
                Toast.fire({
                    type: 'success',
                    title: 'updated successfully'
                });
                this.form.reset();
                 $('#deptModal').modal('hide');
            });
            this.$Progress.finish();
        },
        delDeptartment(id){
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
                    axios.delete(`department/${id}`)
                    .then(res => {
                        this.department = res.data;
                        this.updateDataTable();
                        $('#viewDept').modal('hide');
                         Swal.fire(
                        'Deleted!',
                        'Department has been deleted.',
                        'success'
                        )
                    })
                }
            })
        },
        showModal(dept){
            if(dept){
                this.editMode = true;
                $('#deptModal').modal('show');
                this.form.reset();
                this.form.clear();
                this.form.fill(dept);
                this.form.id = dept.id;
            }else{
                this.editMode = false;
                $('#deptModal').modal('show');
                this.form.reset();
                this.form.clear();
            } 
        }
    }
}
</script>