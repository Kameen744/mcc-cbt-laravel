<template>
    <div class="card text-white bg-gradient-primary border-left-warning">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title">Courses</h4>
                        </div>
                        <div class="col-6">
                            <button @click="showCourseModal(null)" type="button" class="btn btn-danger btn-sm float-right"><i class="fas fa-plus-circle"></i> Add Course</button>
                        </div>
                    </div>
                    
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th>Created</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody v-for="course in courses" :key="course.id">
                            <tr>
                                <td>{{course.course}}</td>
                                <td>{{course.created_at | myDate}}</td>
                                <td>
                                     <button class="rounded-circle btn-info" @click="showCourseModal(course)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <i> </i>
                                    <button class="rounded-circle btn-danger" @click="deleteCourse(course.id)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
            editCourseMode: false,
            form: new Form({
                course: ''
            }),
            courses: {}
        }
    },
    created() {
        this.$Progress.start();
        axios.get('/course')
        .then(res => {
            this.courses = res.data;
        });
        this.$Progress.finish();
    },
    methods: {
        newCourse() {
            this.$Progress.start();
            this.form.post('/course')
            .then(res => {
                this.courses = res.data;
                Toast.fire({
                    type: 'success',
                    title: 'course saved successfully'
                });
                this.form.reset();
            });
            this.$Progress.finish();
        },
        editCourse() {
            this.$Progress.start();
                this.form.put(`course/${this.form.id}`)
                .then(res => {
                    this.courses = res.data;
                    $('#courseModal').modal('hide');
                     Toast.fire({
                        type: 'success',
                        title: 'course updated successfully'
                    });
                });
            this.$Progress.finish();
        },
        deleteCourse(id) {
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
                    axios.delete('/course/' +id)
                    .then(res => {
                        this.courses = res.data;
                         Swal.fire(
                        'Deleted!',
                        'Course has been deleted.',
                        'success'
                        )
                    })
                }
            });
        },
        showCourseModal(course) {
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
