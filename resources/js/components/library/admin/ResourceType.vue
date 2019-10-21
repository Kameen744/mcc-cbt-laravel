<template>
    <div class="card text-white bg-gradient-primary border-left-danger">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Resource type / folders</h4>
                        </div>
                        <div class="col-md-6">
                            <button @click="showModal(null)" type="button" 
                            class="btn btn-danger btn-sm float-right">
                            <i class="fas fa-plus-circle"></i> New Resource Type
                            </button>
                        </div>
                    </div>
                    <div class="col-12 p-0 mb-1"><hr class="p-0 m-0 bg-white"></div>
                    <data-table :columns="columns" :key="data_table_key"
                    :classes="classes" url="res_type"></data-table>
                </div>
            </div>
        </div>

        <div class="modal swal2-modal swal2-show" id="viewType" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header py-1">
                        <h5 class="modal-title text-primary">Type</h5>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">   
                            <div class="row shadow justify-content-center">
                                <div class="col-md-auto">
                                    <button @click="showModal(res_type)"
                                    class="btn btn-info btn-sm">
                                    <i class="fas fa-edit"></i> Edit</button>
                                </div>
                                <div class="col-md-auto">
                                    <button @click="delType(res_type.id)"
                                    class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Delete</button>
                                </div>
                            </div>
                            <div class="card-body shadow text-dark">
                                <h4 class="card-title">{{res_type.res_type}}</h4>
                                <h4 class="card-title">Created on: {{res_type.created_at|myDate}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal swal2-modal swal2-show" id="typeModal" tabindex="1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header py-1">
                        <h5 v-show="!editMode" class="modal-title text-primary">New Resource Type</h5>
                        <h5 v-show="editMode" class="modal-title text-warning">Edit Type</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent=" editMode ? editType() : newType() ">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="form-group">
                                <input type="text" v-model="form.res_type" name="res_type" 
                                class="form-control form-control-sm" placeholder="Type" 
                                :class="{ 'is-invalid': form.errors.has('res_type') }">
                                <has-error :form="form" field="res_type"></has-error>
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
            columns: [
                {
                    label: 'ID',
                    name: 'id',
                    filterable: true,
                },
                {
                    label: 'Type',
                    name: 'res_type',
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
                    handler: this.viewType,
                    component: DataButtonVue, 
                }
            ],
           
            editMode: true,
            data_table_key: 1,
            form: new Form({
                res_type: '',
            }),
            typeData: {
                res_type: null
            }, 
            errors: [],
            res_type: Object,
            res_types: [],
        }
    },

    methods: {
        updateDataTable() {
            this.data_table_key ? this.data_table_key = 0 : this.data_table_key = 1;
        },
        viewType(typ) {
            this.res_type = typ;
            $('#viewType').modal('show');
        },
        newType() {
            this.$Progress.start();
            this.form.post(`res_type`)
            .then(res  => { 
                this.res_type = res.data;
                this.updateDataTable();
                Toast.fire({
                    type: 'success',
                    title: 'created successfully'
                });
                this.form.reset();
            });
            this.$Progress.finish();
        },
        editType() {
            this.$Progress.start();
            this.form.put(`res_type/${this.form.id}`)
            .then(res  => { 
                this.res_type = res.data;
                this.updateDataTable();
                Toast.fire({
                    type: 'success',
                    title: 'updated successfully'
                });
                this.form.reset();
                 $('#typeModal').modal('hide');
            });
            this.$Progress.finish();
        },
        delType(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You want delete all the books in this folder!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0f442e',
                cancelButtonColor: '#810412',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.value) {
                    axios.delete(`res_type/${id}`)
                    .then(res => {
                        this.res_type = res.data;
                        this.updateDataTable();
                        $('#viewType').modal('hide');
                         Swal.fire(
                        'Deleted!',
                        'Resource type has been deleted.',
                        'success'
                        )
                    })
                }
            })
        },
        showModal(typ){
            if(typ){
                this.editMode = true;
                $('#typeModal').modal('show');
                this.form.reset();
                this.form.clear();
                this.form.fill(typ);
                this.form.id = typ.id;
            }else{
                this.editMode = false;
                $('#typeModal').modal('show');
                this.form.reset();
                this.form.clear();
            } 
        }
    }
}
</script>

<style scoped>
   
</style>