<template>
  <div class="card text-white bg-gradient-primary border-left-danger">
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-6">
              <h4 class="card-title">Staff</h4>
            </div>
            <div class="col-md-6">
              <button
                @click="showModal(null)"
                type="button"
                class="btn btn-danger btn-sm float-right"
              >
                <i class="fas fa-plus-circle"></i> New Staff
              </button>
            </div>
          </div>
          <div class="col-12 p-0 mb-1">
            <hr class="p-0 m-0 bg-white" />
          </div>
          <data-table :columns="columns" :key="data_table_key" :classes="classes" url="get_admins"></data-table>
        </div>
      </div>
    </div>

    <div
      class="modal swal2-modal swal2-show"
      id="viewStaff"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modelTitleId"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header py-1">
            <h5 class="modal-title text-primary">Staff</h5>
          </div>
          <div class="modal-body">
            <div class="container-fluid">
              <div class="row shadow-sm justify-content-center">
                <div class="col-md-auto">
                  <button @click="showModal(admin)" class="btn btn-info btn-sm">
                    <i class="fas fa-edit"></i> Edit
                  </button>
                </div>
                <div class="col-md-auto">
                  <button @click="permissionModal(admin)" class="btn btn-success btn-sm">
                    <i class="fas fa-key"></i> Permissions Settings
                  </button>
                </div>
                <div class="col-md-auto">
                  <button @click="delStaff(admin.id)" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash"></i> Delete
                  </button>
                </div>
              </div>
              <div class="card-body shadow-sm text-dark">
                <h4 class="card-title">{{admin.username}}</h4>
                <h5 class="card-title">Created on {{admin.created_at | myDate}}</h5>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- --------------new stafff modal------------------------ -->
    <div
      class="modal swal2-show"
      id="staffModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modelTitleId"
      aria-hidden="true"
    >
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
                        <input
                          type="text"
                          v-model="form.username"
                          class="form-control form-control-sm"
                          placeholder="Username"
                          :class="{ 'is-invalid': form.errors.has('username') }"
                        />
                        <has-error :form="form" field="username"></has-error>
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Password:</label>
                        <input
                          type="password"
                          v-model="form.password"
                          class="form-control form-control-sm"
                          placeholder="Password"
                          :class="{ 'is-invalid': form.errors.has('password') }"
                        />
                        <has-error :form="form" field="password"></has-error>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer py-1">
                  <div class="form-group" v-show="!editUserMode">
                    <button :disabled="form.busy" type="submit" class="btn btn-primary btn-sm">
                      <i class="fas fa-plus-circle"></i> New User
                    </button>
                  </div>
                  <div class="form-group" v-show="editUserMode">
                    <button :disabled="form.busy" type="submit" class="btn btn-warning btn-sm">
                      <i class="fas fa-edit"></i> Update
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ------------------staff permission --------------------- -->
    <div
      class="modal swal2-show"
      id="permissionModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modelTitleId"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header py-1">
            <h5 class="modal-title text-dark" id="settingTitle">Staff Permissions</h5>
          </div>
          <div class="card text-dark">
            <div class="card-body">
              <div class="row">
                <div class="col-6 shadow-sm">
                  <div v-for="(group, key) in navGroups" :key="key">
                    <div>Manage {{group.name}}</div>

                    <div v-for="nav in navbars" :key="nav.id">
                      <a
                        href
                        v-if="nav.navgroup_id === group.id"
                        class="mb-2 btn btn-primary btn-icon-split btn-sm"
                        @click.prevent="newPermission(nav.id)"
                      >
                        <span class="icon text-white-50">
                          <i class="fas fa-check"></i>
                        </span>
                        <span class="text">{{nav.name}}</span>
                      </a>
                    </div>
                  </div>
                  <hr class="bg-danger" />
                </div>
                <div class="card bg-primary col-6 text-white">
                  <h5 class="text-center">Permited Controls</h5>
                  <hr class="p-0 m-0 bg-secondary" />
                  <div v-for="(group, key) in navGroups" :key="key">
                    <div>Manage {{group.name}}</div>

                    <div v-for="(nav, key) in permitedNavbars" :key="key">
                      <a
                        href
                        v-if="nav.navgroup_id === group.id"
                        class="mb-2 btn btn-danger btn-icon-split btn-sm"
                        @click.prevent="deletePermission(nav.id)"
                      >
                        <span class="icon text-white-50">
                          <i class="fas fa-times"></i>
                        </span>
                        <span class="text">{{nav.name}}</span>
                      </a>
                    </div>
                  </div>
                  <hr class="bg-secondary" />
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
      columns: [
        {
          label: "ID",
          name: "id",
          filterable: true
        },
        {
          label: "Login Name",
          name: "username",
          filterable: true
        },
        {
          label: "Created",
          name: "created_at",
          filterable: true
        },
        {
          label: "",
          name: "View",
          filterable: false,
          classes: {
            btn: true,
            "btn-danger": true,
            "btn-sm": true,
            font: "fas fa-eye"
          },
          event: "click",
          handler: this.viewStaff,
          component: DataButtonVue
        }
      ],
      classes: {
        table: {
          table: true,
          "table-striped": true,
          "table-bordered": true,
          "text-white": true
        }
      },
      data_table_key: 0,
      form: new Form({
        username: "",
        password: ""
      }),
      permForm: new Form({
        admin_id: "",
        navbar_id: ""
      }),
      navGroups: Object,
      navbars: Object,
      permitedNavGroups: Object,
      permitedNavbars: Object,
      editUserMode: false,
      admins: null,
      admin: Object,
      dataTable: null,
      permissionTab: "tab-pane fade show",
      adminClicked: 0,
      mychange: 0
    };
  },
  props: {
    currentUser: ""
  },
  watch: {
    adminClicked: "changed",
    mychange: "changed"
  },
  methods: {
    updateDataTable() {
      this.data_table_key
        ? (this.data_table_key = 0)
        : (this.data_table_key = 1);
    },
    getNavGroups() {
      axios.get(`admin/navbargroup`).then(res => {
        this.navGroups = res.data;
      });
    },

    getNavbars() {
      axios.get(`admin/navbars`).then(res => {
        this.navbars = res.data;
      });
    },
    getPermitedNavbars(id) {
      axios.get(`admin/permited_navbars/${id}`).then(res => {
        this.permitedNavbars = res.data;
      });
    },

    getAdmin(id) {
      axios.get(`get_admin/${id}`).then(res => {
        this.admin = res.data;
      });
    },

    editAdmin() {
      this.updateDataTable();
    },
    newUser() {
      this.$Progress.start();
      this.form.post("admin").then(res => {
        this.updateDataTable();
        Toast.fire({
          type: "success",
          title: "created successfully"
        });
        this.form.reset();
      });
      this.$Progress.finish();
    },
    editUser() {
      this.$Progress.start();
      this.form.put(`admin/${this.form.id}`).then(res => {
        this.updateDataTable();
        Toast.fire({
          type: "success",
          title: "updated successfully"
        });
        this.form.reset();
        $("#staffModal").modal("hide");
      });
      this.$Progress.finish();
    },
    newPermission(id) {
      this.permForm.navbar_id = id;
      this.permForm
        .post(`add_permission/${this.permForm.admin_id}`)
        .then(res => {
          this.permitedNavbars = res.data;
        });
    },
    deletePermission(id) {
      this.permForm.navbar_id = id;
      this.permForm
        .delete(`delete_permission/${this.permForm.admin_id}`)
        .then(res => {
          this.permitedNavbars = res.data;
        });
    },
    viewStaff(admin) {
      this.admin = admin;
      $("#viewStaff").modal("show");
    },
    delStaff(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#0f442e",
        cancelButtonColor: "#810412",
        confirmButtonText: "Yes, delete it!"
      }).then(result => {
        if (result.value) {
          axios.delete(`admin/${id}`).then(res => {
            this.updateDataTable();
            Swal.fire("Deleted!", "Staff has been deleted.", "success");
          });
        }
      });
    },
    // showStaffModal(admin) {
    //    if(admin){
    //        this.editUserMode = true;
    //        this.form.id = admin.id;
    //        $('#staffModal').modal('show');
    //        this.form.clear();
    //        this.form.reset();
    //        this.form.fill(admin);
    //    }
    // },
    permissionModal(admin) {
      this.getAdmin(admin.id);
      this.permForm.admin_id = admin.id;
      this.getNavGroups();
      this.getNavbars();
      this.getPermitedNavbars(admin.id);
      this.permissionTab = "tab-pane fade active show";
      $("#permissionModal").modal("show");
      // this.permitedNavbars = '';
    },
    closeModal() {
      $("#adminEditModal").hide();
      this.permissionTab = "tab-pane fade";
    },
    showModal(admin) {
      if (admin) {
        this.editUserMode = true;
        this.form.id = admin.id;
        $("#staffModal").modal("show");
        this.form.clear();
        this.form.reset();
        this.form.fill(admin);
      } else {
        this.editUserMode = false;
        $("#staffModal").modal("show");
        this.form.clear();
        this.form.reset();
      }
    }
  }
};
</script>
<style  scoped>
</style>

