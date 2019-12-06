<template>
    <div class="card text-white bg-gradient-primary border-left-danger">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>New Resource</h4>
                        </div>
                        <div class="col-md-6">
                            <button @click="showModal(null)" type="button" 
                            class="btn btn-danger btn-sm float-right">
                            <i class="fas fa-plus-circle"></i> Upload New Resource
                            </button>
                        </div>
                    </div>
                    <div class="col-12 p-0 mb-1"><hr class="p-0 m-0 bg-white"></div>
                    <data-table :columns="columns" :key="data_table_key"
                    :classes="classes" url="resource"></data-table>
                </div>
            </div>
        </div>

        <div class="modal swal2-modal swal2-show" id="viewResource" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header py-1">
                        <h5 class="modal-title text-primary">Type</h5>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">   
                            <div class="row shadow justify-content-center">
                                <div class="col-md-auto">
                                    <button @click="ResourceModal(resource)"
                                    class="btn btn-info btn-sm">
                                    <i class="fas fa-edit"></i> Edit</button>
                                </div>
                                <div class="col-md-auto">
                                    <button @click="delResource(resource.id)"
                                    class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Delete</button>
                                </div>
                            </div>
                            <div class="card-body shadow text-dark">
                                <h4 class="card-title">{{resource.title}}</h4>
                                <h4 class="card-title">Created on: {{resource.created_at|myDate}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal swal2-modal swal2-show" id="resourceModal" tabindex="1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header py-1">
                        <h5 v-show="!editMode" class="modal-title text-primary">New Resource</h5>
                        <h5 v-show="editMode" class="modal-title text-warning">Edit Type</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent=" editMode ? editResource() : newResource() ">
                    <div class="modal-body">

                        <div class="container-fluid">
                            
                            <div class="large-12 medium-12 small-12 filezone">
                                <input type="file" id="files" ref="files" 
                                multiple @change="handleFiles()"/>
                                <p>
                                    Drop your files here <br>or click to search
                                </p>
                            </div>

                            <div v-for="(file, key) in files" :key="key" class="file-listing">
                                <img class="preview" :ref="'preview'+parseInt(key)"/>
                                {{ file.name }}
                                <div class="success-container" v-if="file.id > 0">
                                    Success
                                </div>
                                <div class="remove-container" v-else>
                                    <a class="remove" @click="removeFile(key)">Remove</a>
                                </div>
                            </div>

                            <a class="submit-button" @click="submitFiles()" 
                            v-show="files.length > 0">Submit</a>

                            <!-- <label>Resource File eg. PDF
                                <input type="file" name="res_file" @change="uploadBook"/>
                            </label>
                            <label>Resource Cover eg. jpg, png
                                <input type="file" name="res_cover" @change="uploadCover"/>
                            </label>
                            <div class="form-group">
                                <input type="text" v-model="form.res_file" name="res_type" 
                                class="form-control form-control-sm" placeholder="Type" 
                                :class="{ 'is-invalid': form.errors.has('res_type') }">
                                <has-error :form="form" field="res_type"></has-error>
                            </div> -->

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
            columns: [
                {
                    label: 'ID',
                    name: 'id',
                    filterable: true,
                },
                {
                    label: 'Title',
                    name: 'title', 
                    filterable: true,
                },
                {
                    label: 'Subject',
                    name: 'subject',
                    filterable: true,
                },
                {
                    label: 'Author',
                    name: 'author',
                    filterable: true,
                },
                {
                    label: '',
                    name: 'View',
                    filterable: false,
                    classes: { 
                        'btn-danger': true,
                    },
                    event: "click",
                    handler: this.viewResource,
                    component: DataButtonVue, 
                }
            ],

            editMode: true,
            data_table_key: 1,
            form: new Form({
                res_file: '',
                res_cover: '',
                res_title: '',
                res_subject: '',
                res_department: '',
                resource: '',
            }),
     
            errors: [],
            resource: Object,
            files: []
        }
    },
    methods: {
        getImagePreviews(){
            for( let i = 0; i < this.files.length; i++ ){
                if ( /\.(jpe?g|png|gif)$/i.test( this.files[i].name ) ) {
                    let reader = new FileReader();
                    reader.addEventListener("load", function(){
                        this.$refs['preview'+parseInt(i)][0].src = reader.result;
                    }.bind(this), false);
                    reader.readAsDataURL( this.files[i] );
                }else{
                    this.$nextTick(function(){
                        this.$refs['preview'+parseInt(i)][0].src = '/img/generic.png';
                    });
                }
            }
        },

        removeFile( key ){
            this.files.splice( key, 1 );
            this.getImagePreviews();
        },

        submitFiles() {
            for( let i = 0; i < this.files.length; i++ ){
                if(this.files[i].id) {
                    continue;
                }
                let formData = new FormData();
                formData.append('file', this.files[i]);

                axios.post('/' + this.post_url,
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(function(data) {
                    this.files[i].id = data['data']['id'];
                    this.files.splice(i, 1, this.files[i]);
                    console.log('success');
                }.bind(this)).catch(function(data) {
                    console.log('error');
                });
            }
        }
    }
}
</script>

<style scoped>
    input[type="file"]{
        opacity: 0;
        width: 100%;
        height: 200px;
        position: absolute;
        cursor: pointer;
    }
    .filezone {
        outline: 2px dashed grey;
        outline-offset: -10px;
        background: #ccc;
        color: dimgray;
        padding: 10px 10px;
        min-height: 200px;
        position: relative;
        cursor: pointer;
    }
    .filezone:hover {
        background: #c0c0c0;
    }

    .filezone p {
        font-size: 1.2em;
        text-align: center;
        padding: 50px 50px 50px 50px;
    }
    div.file-listing img{
        max-width: 90%;
    }

    div.file-listing{
        margin: auto;
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    div.file-listing img{
        height: 100px;
    }
    div.success-container{
        text-align: center;
        color: green;
    }

    div.remove-container{
        text-align: center;
    }

    div.remove-container a{
        color: red;
        cursor: pointer;
    }

    a.submit-button{
        display: block;
        margin: auto;
        text-align: center;
        width: 200px;
        padding: 10px;
        text-transform: uppercase;
        background-color: #CCC;
        color: white;
        font-weight: bold;
        margin-top: 20px;
    }
</style>
