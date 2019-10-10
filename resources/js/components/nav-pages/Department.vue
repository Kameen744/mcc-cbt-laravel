<template>
    <div class="card text-white bg-gradient-primary border-left-danger">
        <div class="card-body">
            <div class="row">
                
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title">Departments List</h4>
                        </div>
                        <div class="col-6">
                            <button @click="showModal(null)" type="button" class="btn btn-danger btn-sm float-right"><i class="fas fa-plus-circle"></i> Add Department</button>
                        </div>
                    </div>
                    
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Department</th>
                                <th>Code</th>
                                <th>Created</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody v-for="dept in departments" :key="dept.id">
                            <tr>
                                <td>{{dept.department}}</td>
                                <td>{{dept.department_code}}</td>
                                <td>{{dept.created_at | myDate}}</td>
                                <td>
                                    <button class="rounded-circle btn-info" @click="showModal(dept)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <i> </i>
                                    <button class="rounded-circle btn-danger" @click="delDeptartment(dept.id)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal swal2-modal swal2-show" id="deptModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
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
export default {
    data() {
        return {
            editMode: true,
            form: new Form({
                department: '',
                department_code: '',
            }),
            deptData: {
                department: null,
                department_code: null,
               
            }, 
            errors: [],
            departments: [],
        }
    },
    created() {
        this.getDepartments();
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
        getDepartments() {
            this.$Progress.start();
            axios.get('department')
            .then(res => {
                this.departments = res.data;
                this.$Progress.finish();
            });
        },
        newDepartment() {
            this.$Progress.start();
            this.form.post('/department')
            .then(res  => { 
                this.departments = res.data;
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
            this.form.put('/department/' + this.form.id)
            .then(res  => { 
                this.departments = res.data;
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
                    axios.delete('/department/' +id)
                    .then(res => {
                        this.departments = res.data;
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

<style scoped>
    /* table {
        color:white !important;
    }
    th {
        color:#810412;
        background: white;
    }
    th,td {
        padding-top: 2px;
        padding-bottom: 2px;
    } */
</style>
