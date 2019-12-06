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
                    :classes="classes" url="library/resource"></data-table>
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
                                    <button @click="showModal(updRes)"
                                    class="btn btn-info btn-sm">
                                    <i class="fas fa-edit"></i> Edit</button>
                                </div>
                                <div class="col-md-auto">
                                    <button @click="delResource(updRes.id)"
                                    class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Delete</button>
                                </div>
                            </div>
                            <div class="card-body shadow text-dark">
                                <div class="row">
                                  <div class="col-md-8 p-0">
                                    <ul>
                                      <li><b class="bg-secondary px-1">Title:</b> {{updRes.res_title}}</li>
                                      <li><b class="bg-secondary px-1">Subjec:</b> {{updRes.res_subject}}</li>
                                      <li><b class="bg-secondary px-1">Author:</b> {{updRes.res_author}}</li>
                                      <li v-if="updRes.res_type"><b class="bg-secondary px-1">Type:</b> {{updRes.res_type.res_type}}</li>
                                      <li v-if="updRes.res_type"><b class="bg-secondary px-1">Department: </b><small>{{updRes.res_department.department}}</small></li>
                                      <li><b class="bg-secondary px-1">Uploaded:</b> {{updRes.created_at|myDate}}</li>
                                    </ul>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="card" v-if="updRes.res_cover">
                                      <img class="imgPrev" 
                                      :src="`/storage/library/${updRes.res_type.res_type}/cover/${updRes.res_cover}`">
                                    </div>
                                  </div>
                                </div>
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
                        <h5 v-show="editMode" class="modal-title text-warning">Edit Resource</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent=" editMode ? editResource() : newResource()">
                    <div class="modal-body">

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" v-model="form.res_title" name="res_title" 
                                class="form-control form-control-sm" placeholder="Title" 
                                :class="{ 'is-invalid': form.errors.has('res_title') }">
                                <has-error :form="form" field="res_title"></has-error>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" v-model="form.res_subject" name="res_subject" 
                                class="form-control form-control-sm" placeholder="Subject" 
                                :class="{ 'is-invalid': form.errors.has('res_subject') }">
                                <has-error :form="form" field="res_subject"></has-error>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" v-model="form.res_author" name="res_author" 
                                class="form-control form-control-sm" placeholder="Author" 
                                :class="{ 'is-invalid': form.errors.has('res_author') }">
                                <has-error :form="form" field="res_author"></has-error>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <select type="text" v-model="form.res_department_id" name="res_department_id" 
                              class="form-control form-control-sm" placeholder="Department" 
                              :class="{ 'is-invalid': form.errors.has('res_department_id') }">
                                <option value="" disabled selected>Select Department</option>
                                <option v-for="dept in departments" :key="dept.id"
                                :value="dept.id">{{dept.department}}</option>
                              </select>
                              <has-error :form="form" field="res_department_id"></has-error>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                                <select type="text" v-model="form.res_type_id" name="res_type_id" 
                                class="form-control form-control-sm" placeholder="Type" 
                                :class="{ 'is-invalid': form.errors.has('res_type_id') }">
                                  <option value="" disabled selected>Resource type</option>
                                  <option v-for="type in types" :key="type.id"
                                  :value="type.id">{{type.res_type}}</option>
                                </select>
                                <has-error :form="form" field="res_type_id"></has-error>
                                <has-error class="mt-2" :form="form" field="res_files"></has-error>
                            </div>
                          </div>
                          <div class="col-md-12" v-if="!editMode">
                            <div class="filezone">
                                <input type="file" id="files" ref="files" 
                                multiple @change="handleFiles"/>
                                <h6 class="text-center">
                                  Drop your files here <br>or click to search
                                </h6>
                            </div>
                          </div>
                          <div class="col-md-12 card-deck" v-if="!editMode">
                            <hr class="m-0 p-1">
                            <div v-for="(file, key) in form.res_files" :key="key" class="card">
                              <img class="card-img-top imgUpl" :src="file.loadimg">
                              <div class="card-body p-1">
                                <h6 class="text-dark"><small>{{ file.name }}</small></h6>
                                <a class="btn btn-sm btn-danger" @click="removeFile(key)">Remove</a>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="modal-footer py-1">
                        <div class="form-group" v-show="!editMode">
                            <button  :disabled="form.busy" type="submit" class="btn btn-primary btn-sm">
                           <i class="fas fa-plus-circle"></i>  Create</button>
                        </div>
                        <div class="form-group" v-show="editMode">
                            <button  :disabled="form.busy" type="submit" class="btn btn-warning btn-sm">
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
                  label: 'Title',
                  name: 'res_title', 
                  filterable: true,
              },
              {
                  label: 'Subject',
                  name: 'res_subject',
                  filterable: true,
              },
              {
                  label: 'Author',
                  name: 'res_author',
                  filterable: true,
              },
              {
                  label: 'Type',
                  name: 'res_type.res_type',
                  filterable: true,
              },
              {
                  label: 'Department',
                  name: 'res_department.department',
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
          classes: { 
              table: {
                'table': true,
                'table-striped': true,
                'table-bordered': true,
                'table-responsive': true,
                'text-white': true
              }
          },
          editMode: true,
          data_table_key: 1,
          form: new Form({
              res_files: [],
              res_title: '',
              res_subject: '',
              res_author: '',
              res_department_id: '',
              res_type_id: '',
          }),
          loadimage: '',
          errors: [],
          resource: {
            res_files: [],
            res_title: '',
            res_subject: '',
            res_author: '',
            res_department_id: '',
            res_type_id: '',
          },
          departments: null,
          types: null,
          updRes: []
      }
    },
    methods: {
        updateDataTable() {
            this.data_table_key ? this.data_table_key = 0 : this.data_table_key = 1;
        },
        loadDeptAndTypes() {
          if(!this.departments) {
            axios.get(`library/departments`)
            .then(res => {
              this.departments = res.data;
            });
          }
          if(!this.types) {
            axios.get(`library/res_type_all`)
            .then(res => {
              this.types = res.data;
            });
          }
        },
        handleFiles(e) {
            let file = e.target.files;
            if(file.length <= 2 & this.form.res_files.length < 2){
              for(let i = 0; i < file.length; i++) {
                if(this.form.res_files[i]) {
                  if(this.form.res_files[i].name !== file[i].name) {
                    this.form.res_files.push(file[i]);
                  }
                }else {
                  this.form.res_files.push(file[i]);
                }
              }
            }else {
              return alert('only two files allowed');
            }
            this.getImagePreviews();
        },
        getImagePreviews(){
            for( let i = 0; i < this.form.res_files.length; i++ ){
                if ( /\.(jpe?g|png|gif)$/i.test( this.form.res_files[i].name ) ) {
                  this.form.res_files[i].loadimg = URL.createObjectURL(this.form.res_files[i]);
                }else{
                  this.form.res_files[i].loadimg = '/storage/images/noimage.png';
                }
            }
        },

        removeFile( key ){
          this.form.res_files.splice( key, 1 );
          this.getImagePreviews();
        },

        newResource() {
          this.$Progress.start();
          if(this.form.res_files.length <= 1) {
            return alert('Two files required. PDF and JPG');
          }
          this.form.post(`resource`, {
            transformRequest: [function (data, headers) {
              return objectToFormData(data)
            }]
          })
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
        viewResource(res) {
          this.updRes = res;
          $('#viewResource').modal('show');
        },
        editResource() {
          this.$Progress.start();
          this.form.put(`library/resource/${this.form.id}`)
          .then(res  => { 
            this.updateDataTable();
            this.updRes = res.data;
            this.form.reset();
            this.form.clear();
            this.form.fill(updRes);
            Toast.fire({
                type: 'success',
                title: 'updated successfully'
            });
            this.form.reset();
          });
          this.$Progress.finish();
        },
        showModal(typ){
            if(typ){
                this.editMode = true;
                $('#resourceModal').modal('show');
                this.loadDeptAndTypes();
                this.form.reset();
                this.form.clear();
                this.form.fill(typ);
                this.form.id = typ.id;
            }else{
                this.editMode = false;
                this.loadDeptAndTypes();
                $('#resourceModal').modal('show');
                this.form.reset();
                this.form.clear();
            }  
        },
        delResource(id) {
          Swal.fire({
            title: 'Are you sure?',
            text: "You want delete!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0f442e',
            cancelButtonColor: '#810412',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.value) {
              axios.delete(`library/resource/${id}`)
              .then(res => {
                this.updRes = res.data;
                this.updateDataTable();
                $('#resourceModal').modal('hide');
                $('#viewResource').modal('hide');
                  Swal.fire(
                'Deleted!',
                'Resource type has been deleted.',
                'success'
                )
              })
            }
          })
        }
    }
}
</script>

<style scoped>
    table {
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
    }
    .imgUpl {
      max-height: 130px;
      max-width: 100%;
    }
    .imgPrev {
      height: 200px !important;
    }
    .card-title {
      max-height: 80px;
      overflow: hidden;
    }
    input[type="file"]{
        opacity: 0;
        width: 100%;
        height: 60px;
        position: absolute;
        cursor: pointer;
    }
    .filezone {
      outline: 2px dashed grey;
      outline-offset: -10px;
      background: #ccc;
      color: dimgray;
      padding: 10px 10px;
      min-height: 50px;
      position: relative;
      cursor: pointer;
    }
    .filezone:hover {
      background: #c0c0c0;
    }
    
</style>
