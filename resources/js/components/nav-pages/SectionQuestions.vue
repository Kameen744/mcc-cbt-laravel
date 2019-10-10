<template>
    <div>
       <div class="card text-white bg-gradient-primary border-left-info">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-6">
                                <h4 class="card-title">Section Questions</h4>
                            </div>
                            <div class="col-6">
                                <div class="row content-justify-right">
                                    
                                    <select @change="getSections" class="col-md-6 m-2 form-control form-control-sm" 
                                        name="course" id="course">
                                        <option>Select Course</option>
                                        <option v-for="course in courses" :key="course.id" :value="course.id">
                                            {{course.course}}
                                        </option>
                                    </select>
                                   
                                    <button @click="showSectionModal(null)" 
                                    type="button" class="col-md-5 m-2 btn btn-danger btn-sm"><i class="fas fa-plus-circle">
                                        </i> Add Section
                                    </button>
                                          
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Section</th>
                                    <th>Question / Instruction</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody v-for="section in sections" :key="section.id">
                                <tr>
                                    <td>{{section.section}}</td>
                                    <td v-html="section.question"></td>
                                    <td>
                                        <button class="rounded-circle btn-info" @click="showSectionModal(section)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <i> </i>
                                        <button class="rounded-circle btn-danger" @click="deleteSection(section.id)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
       </div>

       <!-- ------------------Section Modal--------------------->
        <div class="modal swal2-modal swal2-show" id="sectionModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header py-1">
                        <h5 v-show="!editSectionMode" class="modal-title text-primary">Add New Section</h5>
                        <h5 v-show="editSectionMode" class="modal-title text-warning">Edit Section</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent=" editSectionMode ? editSection() : newSection() ">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Course</label>
                                    <select class="form-control form-control-sm" v-model="form.course_id" 
                                    placeholder="Select Course" :class="{ 'is-invalid': form.errors.has('course_id')}">
                                        <option v-for="course in courses" :key="course.id" :value="course.id">
                                            {{course.course}}
                                        </option>
                                    </select>
                                    <has-error :form="form" field="course_id"></has-error>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Section</label>
                                    <input type="text" v-model="form.section" 
                                    class="form-control form-control-sm" placeholder="Section" 
                                    :class="{ 'is-invalid': form.errors.has('section') }">
                                    <has-error :form="form" field="section"></has-error>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Section Question / Instruction</label>
                                    
                                    <vue-editor v-model="form.question" :editorToolbar="customToolbar"
                                    :class="{ 'is-invalid': form.errors.has('question') }"></vue-editor>
                                    <has-error :form="form" field="question"></has-error>
                                </div>
                            </div>
                        </div>    
                        
                    </div>
                    <div class="modal-footer py-1">
                        <div class="form-group" v-show="!editSectionMode">
                            <button  :disabled="form.busy" type="submit" class="btn btn-primary btn-sm">
                           <i class="fas fa-plus-circle"></i> Add Section</button>
                        </div>
                        <div class="form-group" v-show="editSectionMode">
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
            editSectionMode: false,
            form: new Form({
                course_id: '',
                section: '',
                question: ''
            }),
            sections: {},
            courses: {},
            customToolbar: [
                ["bold", "italic", "underline"],
                [{ list: "ordered" }, { list: "bullet" }],
                ["code-block"]
            ]
        }
    },
    created() {
        axios.get('/course')
        .then(res => {
            this.courses = res.data;
        });
    },
    methods: {
        newSection() {
            this.$Progress.start();
            this.form.post('/section')
            .then(res => {
                this.sections = res.data;
                Toast.fire({
                    type: 'success',
                    title: 'section saved successfully'
                });
                this.form.reset();
            });
            this.$Progress.finish();
        },
        editSection() {
            this.$Progress.start();
                this.form.put('/section/' + this.form.id)
                .then(res => {
                    this.sections = res.data;
                    $('#sectionModal').modal('hide');
                     Toast.fire({
                        type: 'success',
                        title: 'section updated successfully'
                    });
                });
            this.$Progress.finish();
        },
        deleteSection(id) {
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
                    axios.delete('/section/' +id)
                    .then(res => {
                        this.sections = res.data;
                         Swal.fire(
                        'Deleted!',
                        'Section has been deleted.',
                        'success'
                        )
                    })
                }
            });
        },
        getSections(e){
            this.$Progress.start();
            axios.get('/course/' + e.target.value)
            .then(res => {
                this.sections = res.data;
            });
            this.$Progress.finish();
        },
        showSectionModal(section) {
            if(section){
               this.editSectionMode = true;
               this.form.id = section.id;
               $('#sectionModal').modal('show');
               this.form.clear();
               this.form.reset();
               this.form.fill(section); 
            }else {
                this.editSectionMode = false;
                $('#sectionModal').modal('show');
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
    td p{
        padding: 0px;
    }
    th,td {
        padding-top: 2px;
        padding-bottom: 2px;
    } */
    
</style>

