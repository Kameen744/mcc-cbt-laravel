<template>
       <stu-side-nav :username="currentUser.fullname" 
       :logout="logout">
       </stu-side-nav>
</template>

<script>
export default {
    
    data() {
        return {
            currentUser: ''
        }
    },

    props: {
        logout: '',
        user: ''
    },
     created() {
         this.currentUser = JSON.parse(this.user);
         Toast.fire({
            type: 'success',
            title: `${this.currentUser.fullname} Signed in successfully`
        });
        console.log(this.currentUser);
    },
    methods: {
        
    }
   
}
</script>

<style scoped>

</style>