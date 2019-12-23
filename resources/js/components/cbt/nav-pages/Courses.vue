<template>
    <div class="card text-white bg-gradient-primary border-left-warning">

        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title">Courses</h4>
                        </div>
                        <div class="col-md-6">
                            <button @click="showModal(null)" type="button" 
                            class="btn btn-danger btn-sm float-right">
                            <i class="fas fa-plus-circle"></i> Add Course
                            </button>
                        </div>
                    </div>
                    <div class="col-12 p-0 mb-1"><hr class="p-0 m-0 bg-white"></div>
                    <data-table :columns="columns" :key="data_table_key"
                    :classes="classes" url="course"></data-table>
                </div>
            </div>
        </div>

        <div class="modal swal2-modal swal2-show" id="viewCourse" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header py-1">
                        <h5 class="modal-title text-primary">Course</h5>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            
                            <div class="row shadow-sm justify-content-center">
                                <div class="col-md-auto">
                                    <button @click="showModal(course)"
                                    class="btn btn-info btn-sm">
                                    <i class="fas fa-edit"></i> Edit</button>
                                </div>
                                <div class="col-md-auto">
                                    <button @click="delCourse(course.id)"
                                    class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Delete</button>
                                </div>
                            </div>
                            <div class="card-body shadow-sm text-dark">
                                <h4 class="card-title">{{course.course}}</h4>
                                <h5 class="card-title">Created on {{course.created_at | myDate}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ------------------Course Modal--------------------->
        <div class="modal swal2-modal swal2-show" id="courseModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header py-1">
                        <h5 v-show="!editCourseMode" class="modal-title text-primary">Add New Course</h5>
                        <h5 v-show="editCourseMode" class="modal-title text-warning">Edit Course</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent=" editCourseMode ? editCourse() : newCourse() ">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="form-group">
                                <input type="text" v-model="form.course" name="course" 
                                class="form-control form-control-sm" placeholder="Course" 
                                :class="{ 'is-invalid': form.errors.has('course') }">
                                <has-error :form="form" field="course"></has-error>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer py-1">
                        <div class="form-group" v-show="!editCourseMode">
                            <button  :disabled="form.busy" type="submit" class="btn btn-primary btn-sm">
                           <i class="fas fa-plus-circle"></i> Add Course</button>
                        </div>
                        <div class="form-group" v-show="editCourseMode">
                            <button  :disabled="form.busy" type="submit" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>  Update</button>
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
            columns: [
                {
                    label: 'ID',
                    name: 'id',
                    filterable: true,
                },
                {
                    label: 'Course',
                    name: 'course',
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
                        font: 'fas fa-eye'
                    },
                    event: "click",
                    handler: this.viewCourse,
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
            data_table_key: 0,
            editCourseMode: false,
            form: new Form({
                course: ''
            }),
            course: {}
        }
    },
    created() {
        // this.$Progress.start();
        // axios.get(`course`)
        // .then(res => {
        //     this.courses = res.data;
        // });
        // this.$Progress.finish();
    },
    methods: {
        updateDataTable() {
            this.data_table_key ? this.data_table_key = 0 : this.data_table_key = 1;
        },
        newCourse() {
            this.$Progress.start();
            this.form.post(`course`)
            .then(res => {
                this.courses = res.data;
                this.updateDataTable();
                Toast.fire({
                    type: 'success',
                    title: 'course saved successfully'
                });
                this.form.reset();
            });
            this.$Progress.finish();
        },
        viewCourse(course) {
            this.course = course;
            $('#viewCourse').modal('show');
        },
        editCourse() {
            this.$Progress.start();
                this.form.put(`course/${this.form.id}`)
                .then(res => {
                    this.courses = res.data;
                    this.updateDataTable();
                    $('#courseModal').modal('hide');
                     Toast.fire({
                        type: 'success',
                        title: 'course updated successfully'
                    });
                });
            this.$Progress.finish();
        },
        delCourse(id) {
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
                    axios.delete(`course/${id}`)
                    .then(res => {
                        this.courses = res.data;
                        this.updateDataTable();
                         Swal.fire(
                        'Deleted!',
                        'Course has been deleted.',
                        'success'
                        )
                    })
                }
            });
        },
        showModal(course) {
            if(course){
               this.editCourseMode = true;
               this.form.id = course.id;
               $('#courseModal').modal('show');
               this.form.clear();
               this.form.reset();
               this.form.fill(course); 
            }else {
                this.editCourseMode = false;
                $('#courseModal').modal('show');
                this.form.clear();
                this.form.reset();
            }
        }
    }
}
</script>
