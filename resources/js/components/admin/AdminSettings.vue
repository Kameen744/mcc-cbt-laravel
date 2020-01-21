<template>
  <div class="card text-white bg-gradient-primary border-left-danger">
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <h1>Admin Settings</h1>
          <div class="card text-left">
            <div class="card-body text-primary" :key="updateAdmin">
              <h4 class="card-title">Name: {{currentUser.username}}</h4>
              <p class="card-text">Created: {{currentUser.created_at}}</p>
              <p class="card-text">Created: {{currentUser.updated_at}}</p>
              <hr />
              <button
                type="button"
                class="btn btn-primary"
                @click="showModal(currentUser)"
              >Edit Username or Password</button>
            </div>
          </div>
          <hr />
        </div>
      </div>
    </div>
    <!-- -----------------Edit Staff---------------------- -->
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
              <form @submit.prevent="editUser">
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
  </div>
</template>

<script>
export default {
  data() {
    return {
      updateAdmin: false,
      form: new Form({
        username: "",
        password: ""
      })
    };
  },
  props: {
    currentUser: ""
  },
  methods: {
    editUser() {
      this.$Progress.start();
      this.form.put(`admin/${this.form.id}`).then(res => {
        Toast.fire({
          type: "success",
          title: "updated successfully"
        });
        this.updateAdmin = !this.updateAdmin;
        this.form.reset();
        $("#staffModal").modal("hide");
      });
      this.$Progress.finish();
    },
    showModal(admin) {
      if (admin) {
        this.editUserMode = true;
        this.form.id = admin.id;
        $("#staffModal").modal("show");
        this.form.clear();
        this.form.reset();
        this.form.fill(admin);
      }
    }
  }
};
</script>

<style>
</style>