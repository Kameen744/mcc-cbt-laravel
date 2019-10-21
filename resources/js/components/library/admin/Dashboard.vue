<template>
    <libadmin-navbarside 
    :username="currentUser.username" :logout="logout">
    </libadmin-navbarside>
</template>

<script>
export default {
    data() {
        return {
            currentUser: Object
        }
    },
    props: {
        user: String,
        logout: String
    },
    created() {
        this.currentUser = JSON.parse(this.user);
    }
}
</script>

<style>

</style>