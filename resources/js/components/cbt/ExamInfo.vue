<template>
    <span>
        <div class="col-md-12 questionsContainer p-1">
            <h6 class="text-center">Questions overview</h6>
            <hr>
            <div class="row d-flex justify-content-center">
                <button class=" btn-circle btn-sm m-1"
                v-for="(question, key) in crQuestions" :key="key"
                :class=" attempted[question.id] === 'A' ? 'btn-primary' : 'btn-secondary' "
                @click="$emit('gotoQuestion', key)">
                {{key +1}}
                </button>
                
            </div>
            <hr>
        </div>
        <div class="col-md-12 mt-2">
            <div class="row d-flex justify-content-between">
                <b><i class="fas fa-circle fa-1x text-primary"></i> Attempted</b>
                <b><i class="fas fa-circle fa-1x text-secondary"></i> Not Attempted</b>
            </div>
        </div>
    </span>
</template>

<script>
export default {
    props: {
        crQuestions: null,
        attempted: null,
    }
}
</script>

<style scoped>
    .questionsContainer {
        height: 350px;
        overflow: hidden;
        overflow-y: auto;
    }
</style>