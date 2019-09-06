<template>
    <div class="navbar navbar-expand navbar-primary static-top shadow" id="dashNavbar">
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fa fa-bars"></i>
    </button>
    <!-- <ul class="navbar-nav ml-auto">
    <div class="topbar-divider d-none d-sm-block"></div> -->
    <!-- <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{currentUser.username}}</span>
        </a>
        
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        <a class="dropdown-item" href="" @click.prevent="getPageBody('settings')">
            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
            Settings
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" :href="logout">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            Logout
        </a>
        </div>
    </li> -->
    <!-- </ul> -->
</div>
</template>

<script>
// export default {
//     data() {
//         return {
//             pageBody: ''
//         }
//     },
//     props: {
//         currentUser: '',
//         logout: '',
//         pageName: ''
//     },

//     methods: {
//         getPageBody(name) {
//             this.pageBody = name;
//         }
//     }
// }
</script>

<style scoped>
    /* .navbar{
        max-height: 2rem !important;
    } */
</style>

