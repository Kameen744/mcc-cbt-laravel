<template>
    <div class="card bg-gradient-primary border-left-success">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3"> 
                            <h4 class="card-title text-white">Questions</h4>
                        </div>
                        <div class="col-md-3">
                            <select @change="getQuestions" class="float-right form-control form-control-sm" 
                                name="course" id="course">
                                <option selected disabled>Course</option>
                                <option v-for="course in courses" :key="course.id" :value="course.id">
                                    {{course.course}}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select @change="getSectionQuestions" class="float-right form-control form-control-sm">
                                <option selected disabled>Section</option>
                                <option v-for="section in sections" :key="section.id" :value="section.id">
                                    {{section.section}}
                                </option>
                            </select>
                        </div>
                        <!-- <div class="col-md-2">
                            <button @click="showUploadModal" class="btn btn-success btn-sm">
                               <i class="fas fa-upload"></i> Upload Questions
                            </button>
                        </div> -->
                        <div class="col-md-3">
                            <button @click="showQuestionModal(null)" type="button" 
                                class="float-right btn btn-danger btn-sm">
                                <i class="fas fa-plus-circle"></i> Add Question
                            </button>
                        </div>
                    </div>  
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Question</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody v-for="(question, index) in questions" :key="question.id">
                            <tr>
                                <td>{{index+1}}</td>
                                <td v-html="question.question"></td>
                                <td>
                                    <button class="rounded-circle btn-info" @click="showQuestionModal(question)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <i> </i>
                                    <button class="rounded-circle btn-danger" @click="deleteQuestion(question.id)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
         <!-- ------------------Question Modal--------------------->
        <div class="modal swal2-show" id="questionModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header py-1">
                        <h5 v-show="!editQuestionMode" class="modal-title text-primary">Add New Question</h5>
                        <h5 v-show="editQuestionMode" class="modal-title text-warning">Edit Question</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent=" editQuestionMode ? editQuestion() : newQuestion() ">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select Course</label>
                                        <select class="form-control form-control-sm" v-model="form.course_id" 
                                        @change="getSections" :class="{ 'is-invalid': form.errors.has('course_id')}">
                                            <option v-for="course in courses" :key="course.id" :value="course.id">
                                                {{course.course}}
                                            </option>
                                        </select>
                                        <has-error :form="form" field="course_id"></has-error>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select Section</label>
                                        <select class="form-control form-control-sm" v-model="form.section_id" 
                                        :class="{ 'is-invalid': form.errors.has('section_id')}">
                                            <option v-for="section in sections" :key="section.id" :value="section.id">
                                                {{section.section}}
                                            </option>
                                        </select>
                                        <has-error :form="form" field="course_id"></has-error>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <vue-editor id="question" v-model="form.question" :editorToolbar="customToolbar"
                                        placeholder="Question" :class="{ 'is-invalid': form.errors.has('question') }"></vue-editor>
                                        <has-error :form="form" field="question"></has-error>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <vue-editor id="option_a" v-model="form.option_a"  :editorToolbar="customToolbar"
                                        placeholder="Option A" :class="{ 'is-invalid': form.errors.has('option_a') }"></vue-editor>
                                        <has-error :form="form" field="option_a"></has-error>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <vue-editor class="text-black" id="option_b" v-model="form.option_b" :editorToolbar="customToolbar"
                                        placeholder="Option B" :class="{ 'is-invalid': form.errors.has('option_b') }"></vue-editor>
                                        <has-error :form="form" field="option_b"></has-error>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <vue-editor id="option_c" v-model="form.option_c" :editorToolbar="customToolbar"
                                        placeholder="Option C" :class="{ 'is-invalid': form.errors.has('option_c') }"></vue-editor>
                                        <has-error :form="form" field="option_c"></has-error>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <vue-editor id="option_d" v-model="form.option_d" :editorToolbar="customToolbar"
                                        placeholder="Option D" :class="{ 'is-invalid': form.errors.has('option_d') }"></vue-editor>
                                        <has-error :form="form" field="option_d"></has-error>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control form-control-sm" v-model="form.answer" 
                                        :class="{ 'is-invalid': form.errors.has('answer')}">
                                            <option value="">Answer</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                        </select>
                                        <has-error :form="form" field="answer"></has-error>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer py-1">
                            <div class="form-group" v-show="!editQuestionMode">
                                <button  :disabled="form.busy" type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus-circle"></i> Add Question</button>
                            </div>
                            <div class="form-group" v-show="editQuestionMode">
                                <button  :disabled="form.busy" type="submit" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>  Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- -------------------uload questions modal -------------------- -->
        <!-- <div class="modal swal2-show" id="uploadQuestionModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header py-1">
                        <h5 class="modal-title text-warning">Upload Questions</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="uploadQuestion">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Course</label>
                                    <select class="form-control form-control-sm" v-model="uploadForm.course_id" 
                                    @change="getSections" :class="{ 'is-invalid': uploadForm.errors.has('course_id')}">
                                        <option v-for="course in courses" :key="course.id" :value="course.id">
                                            {{course.course}}
                                        </option>
                                    </select>
                                    <has-error :form="uploadForm" field="course_id"></has-error>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Section</label>
                                    <select class="form-control form-control-sm" v-model="uploadForm.section_id" 
                                    :class="{ 'is-invalid': uploadForm.errors.has('section_id')}">
                                        <option v-for="section in sections" :key="section.id" :value="section.id">
                                            {{section.section}}
                                        </option>
                                    </select>
                                    <has-error :form="uploadForm" field="course_id"></has-error>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="questions">Select File</label>
                            <input @change="selectFile" type="file" class="form-control-file" name="questions" id="questions" placeholder="">
                        </div>
                        <div class="modal-footer py-1">
                            <div class="form-group">
                                <button  :disabled="uploadForm.busy" type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-upload"></i> Upload Question</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> -->
                
    </div>
</template>
<script>
export default {
    data() {
        return {
            editQuestionMode: false,
            form: new Form({
                course_id: '',
                section_id: '',
                question: '',
                option_a: '',
                option_b: '',
                option_c: '',
                option_d: '',
                answer: ''
            }),
            uploadForm: new Form({
                courses_id: '',
                section_id: '',
                file: null
            }),
            courses: [],
            sections: [],
            sectionsSelect: [],
            questions: {},
            customToolbar: [
                ['bold', 'italic', 'underline'],
                [{ 'script': 'sub'}, { 'script': 'super' }],
                ['code-block']
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
        getSections(e) {
            axios.get(`course/${e.target.value}`)
            .then(res => {
                this.sections = res.data;
            });
        },
        newQuestion() {
            this.$Progress.start();
            this.form.post('/question')
            .then(res => {
                this.questions = res.data;
                Toast.fire({
                    type: 'success',
                    title: 'section saved successfully'
                });
                this.form.reset();
            });
            this.$Progress.finish();
        },
        showUploadModal(){
             $('#uploadQuestionModal').modal('show');
        },
        selectFile(e){
            this.uploadForm.file = e.target.files[0];
        },
        uploadQuestion() {
            this.uploadForm.post('/question', {
              // Transform form data to FormData
              transformRequest: [function (data, headers) {
                return objectToFormData(data)
              }],
              onUploadProgress: e => {
                this.$Progress.start();
              }
            })
            .then(res => {
                // this.questions = res.data;
                // Toast.fire({
                //     type: 'success',
                //     title: 'section saved successfully'
                // });
                // this.uploadForm.reset();
                console.log(res.data);
                 this.$Progress.finish();
            });
        },
        editQuestion() {
            this.$Progress.start();
                this.form.put(`/question/${this.form.id}`)
                .then(res => {
                    this.questions = res.data;
                    $('#questionModal').modal('hide');
                     Toast.fire({
                        type: 'success',
                        title: 'question updated successfully'
                    });
                });
            this.$Progress.finish();
        },
        deleteQuestion(id) {
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
                    axios.delete(`/question/${id}`)
                    .then(res => {
                        this.questions = res.data;
                         Swal.fire(
                        'Deleted!',
                        'Question has been deleted.',
                        'success'
                        )
                    })
                }
            });
        },
        getQuestions(e){
            this.$Progress.start();
            axios.get(`course/${e.target.value}`)
            .then(res => {
                this.sections = res.data;
            });
            axios.get(`coursequestions/${e.target.value}`)
            .then(res => {
                this.questions = res.data;
            });
            this.$Progress.finish();
        },
        getSectionQuestions(e){
            this.$Progress.start();
            axios.get(`sectionquestions/${e.target.value}`)
            .then(res => {
                this.questions = res.data;
            });
            this.$Progress.finish();
        },
        showQuestionModal(question) {
            if(question){
               this.editQuestionMode = true;
               this.form.id = question.id;
               $('#questionModal').modal('show');
               this.form.clear();
               this.form.reset();
               this.form.fill(question); 
            }else {
                this.editQuestionMode = false;
                $('#questionModal').modal('show');
                this.form.clear();
                this.form.reset();
            }
        }
    }
}
</script>
<style>
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
    /* label, select, input {
        color: black !important;
    } */
    #question, #option_a, #option_b, #option_c, #option_d { 
        max-height: 50px; 
        overflow: auto;
    }
    .modal-lg {
    max-width: 80% !important;
}
/* var fullToolbar = [
[{ 'font': [] }],
[{ 'header': [false, 1, 2, 3, 4, 5, 6, ] }],
[{ 'size': ['small', false, 'large', 'huge'] }],
['bold', 'italic', 'underline', 'strike'],
[{'align': ''}, {'align': 'center'}, {'align': 'right'}, {'align': 'justify'}],
[{ 'header': 1 }, { 'header': 2 }],
['blockquote', 'code-block'],
[{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
[{ 'script': 'sub'}, { 'script': 'super' }],
[{ 'indent': '-1'}, { 'indent': '+1' }],
[{ 'color': [] }, { 'background': [] }],
['link', 'image', 'video', 'formula'],
[{ 'direction': 'rtl' }],
['clean'],
] */
</style>


