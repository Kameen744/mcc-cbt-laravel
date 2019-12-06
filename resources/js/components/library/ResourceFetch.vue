<template>
    <div>
        <div class="card">
          
        </div>
    </div>
</template>

<script>
export default {
    data() {
       
    },
    mounted() { 
        axios.get('library/Books')   
    }
}

</script>

<style scoped>
    img {
        width: 200px;
        height: 200px;
    }
    .card {
        /* max-width: 200px;
        max-height: 200px; */
        margin: 20px; 
    }
    .card-body {
        width: 200px;
        height: 100px;
        text-overflow: clip;
    }
</style>