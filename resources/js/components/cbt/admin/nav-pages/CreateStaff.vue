<template>
    <div class="border-left-warning">
        <input type="hidden" id="adminClickedVal">            
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <b class="m-0 font-weight-bold text-primary">Staff</b>
                <button @click="showStaffModal(null)" 
                class="btn btn-danger btn-sm float-right">
                <i class="fas fa-plus-circle">
                    </i> New Staff
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table v-cloak class="table table-bordered" id="adminsDataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th></th>
                            </tr>
                        </thead>
                        
                        <tbody> 
                            <!-- <tr v-for="admin in admins" :key="admin.id">
                                <td class="dataRow">{{admin.id}}</td>
                                <td class="dataRow">{{admin.username}}</td>
                                <td class="dataRow" v-if="admin.id != 1">
                                    <button class="rounded-circle btn-success" @click="showStaffPermissionModal(admin)">
                                        <i class="fas fa-key"></i>
                                    </button>
                                    <button class="rounded-circle btn-info" @click="showStaffModal(admin)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <i> </i>
                                    <button class="rounded-circle btn-danger" @click="deleteStaff(admin.id)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr> -->
                        </tbody> 
                    </table>
                </div>
            </div>
        </div>
        <!-- --------------new stafff modal------------------------ -->
        <div class="modal swal2-show" id="staffModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header py-1">
                        <h5 class="modal-title" id="settingTitle">Staff</h5>
                    </div>
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                           <form @submit.prevent=" editUserMode ? editUser() : newUser() ">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Username:</label>
                                                <input type="text" v-model="form.username" 
                                                class="form-control form-control-sm" placeholder="Username" 
                                                :class="{ 'is-invalid': form.errors.has('username') }">
                                                <has-error :form="form" field="username"></has-error>
                                            </div>
                                        </div>
                                    
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Password:</label>
                                                <input type="password" v-model="form.password" 
                                                class="form-control form-control-sm" placeholder="Password" 
                                                :class="{ 'is-invalid': form.errors.has('password') }">
                                                <has-error :form="form" field="password"></has-error>
                                            </div>
                                        </div>
                                    </div>    
                                    
                                </div>
                                <div class="modal-footer py-1">
                                    <div class="form-group" v-show="!editUserMode">
                                        <button  :disabled="form.busy" type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus-circle"></i> New User</button>
                                    </div>
                                    <div class="form-group" v-show="editUserMode">
                                        <button  :disabled="form.busy" type="submit" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>  Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ------------- admincliced modal -------------------- -->
        <div class="modal swal2-show" id="adminEditModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header py-1">
                        <h5 class="modal-title" id="settingTitle">Staff Controls</h5>
                    </div>
                    <div class="col-xs-12 px-4 card">
                        <nav>
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link" id="nav-home-tab" 
                                data-toggle="tab" href="#nav-home" role="tab" 
                                aria-controls="nav-home" aria-selected="true">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                                <a class="nav-item nav-link" id="nav-profile-tab" 
                                data-toggle="tab" href="#nav-profile" role="tab" 
                                aria-controls="nav-profile" aria-selected="false">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a class="nav-item nav-link" @click="adminPermission" 
                                id="adminSettings" data-toggle="tab" href="#nav-contact" 
                                role="tab" aria-controls="adminSettings" aria-selected="false">
                                    <i class="fas fa-key"></i> Settings
                                </a>
                            </div>
                        </nav>
                        <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                            <div class="tab-pane fade" id="nav-home" role="tabpanel" 
                            aria-labelledby="nav-home-tab">
                                Et et consectetur ipsum labore excepteur est proident excepteur ad velit occaecat qui minim occaecat veniam. Fugiat veniam incididunt anim aliqua enim pariatur veniam sunt est aute sit dolor anim. Velit non irure adipisicing aliqua ullamco irure incididunt irure non esse consectetur nostrud minim non minim occaecat. Amet duis do nisi duis veniam non est eiusmod tempor incididunt tempor dolor ipsum in qui sit. Exercitation mollit sit culpa nisi culpa non adipisicing reprehenderit do dolore. Duis reprehenderit occaecat anim ullamco ad duis occaecat ex.
                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" 
                            aria-labelledby="nav-profile-tab">
                                Et et consectetur ipsum labore excepteur est proident excepteur ad velit occaecat qui minim occaecat veniam. Fugiat veniam incididunt anim aliqua enim pariatur veniam sunt est aute sit dolor anim. Velit non irure adipisicing aliqua ullamco irure incididunt irure non esse consectetur nostrud minim non minim occaecat. Amet duis do nisi duis veniam non est eiusmod tempor incididunt tempor dolor ipsum in qui sit. Exercitation mollit sit culpa nisi culpa non adipisicing reprehenderit do dolore. Duis reprehenderit occaecat anim ullamco ad duis occaecat ex.
                            </div>
                            <div :class="permissionTab" id="nav-contact" role="tabpanel" 
                            aria-labelledby="adminSettings">
                                <div class="row">
                                    <div class="col-6 shadow-lg">
                                        <div v-for="(group, key) in navGroups" :key="key">
                                            <div>
                                                Manage {{group.name}}
                                            </div>
                                            
                                            <div  v-for="nav in navbars" :key="nav.id">
                                    
                                                <a href="" v-if="nav.navgroup_id === group.id" 
                                                class="mb-2 btn btn-primary btn-icon-split btn-sm"
                                                @click.prevent="newPermission(nav.id)">
                                                    <span class="icon text-white-50">
                                                    <i class="fas fa-check"></i>
                                                    </span>
                                                    <span class="text">{{nav.name}}</span>
                                                </a>
                                                
                                            </div>
                                        </div>
                                        <hr class="bg-danger">
                                    </div>
                                    <div class="card bg-danger col-6">
                                        <h5 class="text-center">Permited Controls</h5>
                                        <hr class="p-0 m-0 bg-secondary">
                                        <div v-for="(group, key) in navGroups" :key="key">
                                            <div>
                                                Manage {{group.name}}
                                            </div>
                                            
                                            <div  v-for="(nav, key) in permitedNavbars" :key="key">
                                                <a href="" v-if="nav.navgroup_id === group.id" 
                                                class="mb-2 btn btn-primary btn-icon-split btn-sm"
                                                @click.prevent="deletePermission(nav.id)">
                                                    <span class="icon text-white-50">
                                                    <i class="fas fa-times"></i>
                                                    </span>
                                                    <span class="text">{{nav.name}}</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn-danger" @click="closeModal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- ------------------staff permission --------------------- -->
        <div class="modal swal2-show" id="permissionModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header py-1">
                        <h5 class="modal-title" id="settingTitle">Staff Permissions</h5>
                    </div>
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 shadow-lg">
                                    <div v-for="(group, key) in navGroups" :key="key">
                                        <div>
                                            Manage {{group.name}}
                                        </div>
                                        
                                        <div  v-for="nav in navbars" :key="nav.id">
                                        
                                            <a href="" v-if="nav.navgroup_id === group.id" 
                                            class="mb-2 btn btn-primary btn-icon-split btn-sm"
                                            @click.prevent="newPermission(nav.id)">
                                                <span class="icon text-white-50">
                                                <i class="fas fa-check"></i>
                                                </span>
                                                <span class="text">{{nav.name}}</span>
                                            </a>
                                            
                                        </div>
                                    </div>
                                    <hr class="bg-danger">
                                </div>
                                <div class="card bg-danger col-6">
                                    <h5 class="text-center">Permited Controls</h5>
                                    <hr class="p-0 m-0 bg-secondary">
                                    <div v-for="(group, key) in navGroups" :key="key">
                                        <div>
                                            Manage {{group.name}}
                                        </div>
                                        
                                        <div  v-for="(nav, key) in permitedNavbars" :key="key">
                                            <a href="" v-if="nav.navgroup_id === group.id" 
                                            class="mb-2 btn btn-primary btn-icon-split btn-sm"
                                            @click.prevent="deletePermission(nav.id)">
                                                <span class="icon text-white-50">
                                                <i class="fas fa-times"></i>
                                                </span>
                                                <span class="text">{{nav.name}}</span>
                                            </a>
                                        </div>
                                    </div>
                                    <hr class="bg-secondary">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: new Form({
                username: '',
                password: ''
            }),
            permForm: new Form({
                admin_id: '',
                navbar_id: ''
            }),
            navGroups: Object,
            navbars: Object,
            permitedNavGroups: Object,
            permitedNavbars: Object,
            editUserMode: false,
            admins: null,
            admin: Object,
            dataTable: null,
            permissionTab: 'tab-pane fade show',
            adminClicked: 0,
            mychange: 0
            
        }
    },
    props: {
        currentUser: ''
    },
    mounted() {
        this.getAdmins();
    },
    watch: {
        adminClicked: 'changed',
        mychange: 'changed'
    },
    methods: {
        changed(e) {
            console.log($('#adminClickedVal').val());
            console.log($refs.adminClickedVal);
        },
         getNavGroups() {
            axios.get(`admin/navbargroup`)
            .then(res => {
                this.navGroups = res.data;
            });
        },

        getNavbars() {
            axios.get(`admin/navbars`)
            .then(res => {
                this.navbars = res.data;
            });
        },
        getPermitedNavbars(id)
        {
            axios.get(`admin/permited_navbars/${id}`)
            .then(res => {
                this.permitedNavbars = res.data;
            });
        },
        getAdmins() {
            axios.get(`get_admins`)
            .then(res => {
                let data = res.data;
                $('#dataTable').DataTable();
                this.admins = data;
                this.dataTable = $('#adminsDataTable').DataTable({});
                for (let ii = 0; ii < data.length; ii++) {
                    this.dataTable.row.add([
                    data[ii].id,
                    data[ii].username,
                    `<button onclick="
                        $('#adminClickedVal').val(${data[ii].id});
                        $('#adminEditModal').show();
                    ">
                    <i class="fas fa-wrench"></i>
                    </button>`
                    ]).draw(false) 
                }
            })
        },
        
        getAdmin(id) {
            axios.get(`get_admin/${id}`)
            .then(res => {
                this.admin = res.data;
            });
        },

        editAdmin() {
            console.log('pressed');
        },
        newUser() {
            this.$Progress.start();
            this.form.post('admin')
            .then(res  => { 
                this.admins = res.data;
                Toast.fire({
                    type: 'success',
                    title: 'created successfully'
                });
                this.form.reset();
            });
            this.$Progress.finish();
        },
        editUser() {
            this.$Progress.start();
            this.form.put(`admin/${this.form.id}`)
            .then(res => {
                this.admins = res.data;
                Toast.fire({
                    type: 'success',
                    title: 'updated successfully'
                });
                this.form.reset();
                 $('#staffModal').modal('hide');
            });
            this.$Progress.finish();
        },
        newPermission(id) {
            this.permForm.navbar_id = id;
            this.permForm.post(`add_permission/${this.permForm.admin_id}`)
            .then(res => {
                this.permitedNavbars = res.data;
            });
        },
        deletePermission(id) {
            this.permForm.navbar_id = id;
            this.permForm.delete(`delete_permission/${this.permForm.admin_id}`)
            .then(res => {
                this.permitedNavbars = res.data;
            });
        },
        deleteStaff(id) {
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
                    axios.delete(`admin/${id}`)
                    .then(res => {
                        this.admins = res.data;
                         Swal.fire(
                        'Deleted!',
                        'Staff has been deleted.',
                        'success'
                        )
                    })
                }
            })
        },
        showStaffModal(admin) {
           if(admin){
               this.editUserMode = true;
               this.form.id = admin.id;
               $('#staffModal').modal('show');
               this.form.clear();
               this.form.reset();
               this.form.fill(admin); 
           }
        },
        adminPermission() {
                let id = $('#adminClickedVal').val();
                this.getAdmin(id)
                this.permForm.admin_id = id;
                this.getNavGroups();
                this.getNavbars();
                this.getPermitedNavbars(id);
                this.permissionTab = 'tab-pane fade active show';
                // $('#permissionModal').show();
            
                // this.permitedNavbars = '';
            
        },
        closeModal() {
            $('#adminEditModal').hide();
            this.permissionTab = 'tab-pane fade';
        }
    }
}
</script>
<style  scoped>
  
</style>

