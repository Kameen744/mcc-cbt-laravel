<template>
    <div>
        <nav class="navbar navbar-expand-sm shadow-sm navbar-dark bg-gradient-primary fixed-top">
            <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="" @click:prevent="resources">Resource</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Rules & Regulations</a>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" name="name" id="name" placeholder="" aria-label="">
                        <span class="input-group-btn">
                            <button class="btn btn-danger btn-sm" type="button" aria-label="">
                                <i class="fas fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
            </div>
        </nav>
        
            <div class="mt-5 pt-2">
                <object :data="link" id="bookArea" type="application/pdf"></object>
            </div>
            
            <!-- <div class="mt-5 pt-2 embed-responsive embed-responsive-21by9">
            <object class="embed-responsive-item" :data="link" ></object>
            </div> -->
        
    </div>
</template>

<script>
export default {
    props: {
        link: ''
    },
    methods: {
        resources() {
            this.$emit('compChange', {
                link: '',
                comp: 'books'
            });
        }
    }
}
</script>

<style scoped>
    #bookArea {
        min-width: 98vw;
        min-height: 90vh;
    }
</style>