<template>
    <div class="row">
        <vue-progress-bar></vue-progress-bar>
        <transition>
            <keep-alive>
                <component :is="books" 
                v-on:compChange="compChange($event)" :link="res_link"></component>
            </keep-alive>
        </transition>
    </div>
</template>

<script>
export default {
    data() {
        return {
            path: `/storage/library/`,
            res_link: '',
            books: 'books'
        }
    },
    methods: {
        compChange(read) {
            this.res_link = read.link;
            this.books = read.comp;
        }
    }
}
</script>

<style scoped>
</style>
