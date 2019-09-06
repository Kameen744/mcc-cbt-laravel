<template>
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-chalkboard-teacher    "></i>
            </div>
            <div class="sidebar-brand-text mx-3">MCCST<sup></sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
            <a class="nav-link" href="/admin">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>{{username}}</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
            
            <div v-for="(group, key) in navGroups" :key="group.id">
                <!-- Heading -->
                <div class="sidebar-heading">
                    Manage {{group.name}}
                </div>

                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" :data-target="`#collapse${key}`" aria-expanded="true" aria-controls="collapseTwo">
                   
                    <span>{{group.name}}</span>
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
                <hr class="sidebar-divider">
            </div>

            <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <navbar-top :username="username" :logout="logout"></navbar-top>
                <div class="container-fluid m-0 p-1">
                   <!-- <component :is="pageBody"></component> -->
                   <router-view></router-view>
                </div>
            </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
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
            pageBody: ''
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
        }
    },
   
}
</script>

<style scoped>

</style>

