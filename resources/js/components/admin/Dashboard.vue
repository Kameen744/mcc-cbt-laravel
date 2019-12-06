<template>
       <navbar-side :username="currentUser.username"
       :logout="logout">
       </navbar-side>
</template>

<script>
export default {
    
    data() {
        return {
            // navGroups: [],
            // navbars: [],
            // requestResponse: {},
            // pageBody: '',
            currentUser: ''
        }
    },

    props: {
        logout: '',
        csrfkey: '',
        user: ''
    },
     created() {
         this.currentUser = JSON.parse(this.user);
         Toast.fire({
            type: 'success',
            title: `${this.currentUser.username} Signed in successfully`
        });
        // this.getNavGroups();
        // this.getNavbars();
    },
    methods: {
        // getNavGroups() {
        //     axios.get('admin/navbargroup')
        //     .then(res => {
        //         this.navGroups = res.data;
        //     });
        // },

        // getNavbars() {
        //     axios.get('admin/navbars')
        //     .then(res => {
        //         this.navbars = res.data;
        //     });
        // },  
        
        // getPageBody(name) {
        //     name = name.replace(/\s/g, "-");
        //     this.pageBody = name.toLowerCase();
        // }
    }
   
}
</script>

<style scoped>

</style>