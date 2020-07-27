<template>
  <div id="wrapper">
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href>
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-chalkboard-teacher"></i>
        </div>
        <div class="sidebar-brand-text mx-3">
          MCCST
          <sup></sup>
        </div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0" />

      <!-- Nav Item - Dashboard -->
      <li class="nav-item no-arrow">
        <a
          class="nav-link collapsed"
          href="#"
          data-toggle="collapse"
          data-target="#userSettings"
          aria-expanded="true"
          aria-controls="userSettings"
        >
          <b class="p-0 m-0">
            <i class="fas fa-chalkboard-teacher"></i>
            {{username}}
          </b>
        </a>
        <div id="userSettings" class="collapse" aria-labelledby="headingUtilities">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Settings:</h6>
            <a class="collapse-item" href @click.prevent="getPageBody('settings')">
              <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
              Settings
            </a>
            <a class="collapse-item" :href="logout">
              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
              Logout
            </a>
          </div>
        </div>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider" />
      <li class="nav-item">
        <a
          class="nav-link collapsed"
          href="#"
          data-toggle="collapse"
          data-target="#collapseBooks"
          aria-expanded="true"
          aria-controls="collapseBooks"
        >
          <i class="fas fa-fw fa-cog"></i>
          <span>Resources</span>
        </a>
        <div
          id="collapseBooks"
          class="collapse"
          aria-labelledby="headingTwo"
          data-parent="#accordionSidebar"
        >
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Resources:</h6>
            <router-link :to="`resource-type`" class="collapse-item">Resources Type</router-link>
            <router-link :to="`lib-resources`" class="collapse-item">Library Resources</router-link>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a
          class="nav-link collapsed"
          href="#"
          data-toggle="collapse"
          data-target="#collapseUsers"
          aria-expanded="true"
          aria-controls="collapseUsers"
        >
          <i class="fas fa-fw fa-cog"></i>
          <span>Users</span>
        </a>
        <div
          id="collapseUsers"
          class="collapse"
          aria-labelledby="headingTwo"
          data-parent="#accordionSidebar"
        >
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Users:</h6>
            <router-link :to="`/upload-newbook`" class="collapse-item">Upload New</router-link>
          </div>
        </div>
      </li>

      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
    </ul>

    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <navbar-top :username="username" :logout="logout"></navbar-top>
        <div class="container-fluid m-0 p-1">
          <router-view></router-view>
          <vue-progress-bar></vue-progress-bar>
        </div>
      </div>
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <i class="fas fa-copyright"></i> Developed by Kamal - kamalaminu94@gmail.com
          </div>
        </div>
      </footer>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {};
  },

  props: {
    username: "",
    logout: ""
  },

  created() {},

  methods: {}
};
</script>

<style scoped>
</style>