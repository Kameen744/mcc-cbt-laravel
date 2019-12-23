<template>
  <div class="row d-flex justify-content-center">
    <button
      class="btn-circle btn-sm m-1"
      v-for="(question, key) in questions"
      :key="key"
      :class=" mrkAtt(question.id) ? 'btn-primary' : 'btn-secondary' "
      @click="gotoQuestion(key)"
    >{{key +1}}</button>
  </div>
</template>

<script>
export default {
  props: {
    questions: Array,
    attempted: Array
  },
  methods: {
    gotoQuestion(key) {
      this.$emit("gotoQuestion", key);
    },
    mrkAtt(id) {
      return this.attempted[id] ? true : false;
    }
  }
};
</script>

<style>
</style>