<template>
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" :class="toggled ? 'toggled' : '' " id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-chalkboard-teacher "></i>
            </div>
            <div class="sidebar-brand-text mx-3">MCCST<sup></sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item no-arrow">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" 
                data-target="#userSettings" aria-expanded="true" 
                aria-controls="userSettings">
                        
                <b class="p-0 m-0">
                    <i class="fas fa-chalkboard-teacher"></i>
                    {{username}}
                </b>
                    
                </a>
                <div id="userSettings" class="collapse" aria-labelledby="headingUtilities">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Settings:</h6>
                        <a class="collapse-item" href="" @click.prevent="getPageBody('settings')">
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
            <hr class="sidebar-divider m-0">
            <div class="navsArea pb-5">
            <div v-for="(group, key) in navGroups" :key="group.id">
                <!-- Heading -->
                <!-- <div class="sidebar-heading">
                    Manage {{group.name}}
                </div> -->

                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" :data-target="`#collapse${key}`" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-folder"></i>
                        <span class="navtext">{{group.name}}</span>
                    </a>
                    <div :id="`collapse${key}`" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">{{group.name}}:</h6>
                            <div v-for="nav in navbars" :key="nav.id">
                                <router-link v-if="nav.navgroup_id === group.id" 
                                :to="`/${getNavName(nav.name)}`" class="collapse-item">
                                    {{nav.name}}
                                </router-link>
                            </div>
                        </div>
                    </div>
                </li> 
                <!-- Divider -->
                <hr class="sidebar-divider m-0">
            </div>
            </div>
            <div class="text-center d-none d-md-inline mt-4">
            <button @click="sidebarToggle" 
            class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- <navbar-top :username="username" :logout="logout"></navbar-top> -->
                <div class="container-fluid m-0 p-1">
                   <!-- <component :is="pageBody"></component> -->
                   <router-view></router-view>
                   <vue-progress-bar></vue-progress-bar>
                </div>
            </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto" style="padding: 0px;">
                        <span>Copyright &copy; MCCHST 2019</span>
                    </div>
                </div>
            </footer>
        </div> 
        
    </div>
</template>

<script>

export default {
    
    data() {
        return {
            navGroups: [],
            navbars: [],
            requestResponse: {},
            pageBody: '',
            toggled: false,
        }
    },

    props: {
        username: '',
        logout: ''
    },

     created() {
        this.getNavGroups();
        this.getNavbars();
    },

    methods: {
        reqData(url, opt = null) {
           return opt ? fetch(url, opt) : fetch(url)
            .then(res => res.json())
            .catch(err => console.log(err));
        },

        getNavGroups() {
            this.reqData(`admin/navbargroup`)
            .then(res => {
                this.navGroups = res;
            });
        },

        getNavbars() {
            this.reqData(`admin/navbars`)
            .then((res) => {
               this.navbars = res;
            });
        },  
        
        getNavName(name) {
            return name.replace(/\s/g, "-").toLowerCase();
        },
        sidebarToggle() {
            this.toggled = !this.toggled;
        }
    },
   
}
</script>

<style scoped>
    .navsArea {
        max-height: 67vh;
        overflow-x: hidden;
        overflow-y: auto;
    }
    .navtext {
        font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        size: 15rem;
    }
</style>

