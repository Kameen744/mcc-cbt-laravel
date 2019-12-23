<template>
  <div>
    <button
      class="list-group-item list-group-item-action bg-gray-300 border-0 shadow-sm d-flex py-2"
      @click="attemptQuestion(question, option)"
    >
      <button
        class="btn-circle"
        :class=" mrkAtt(question.id, option) ? 'btn-primary' : 'btn-sm btn-secondary' "
      >
        <b>{{option}}</b>
        <i :class="{ 'ml-1 fas fa-check' : mrkAtt(question.id, option) }"></i>
      </button>
      <b class="pl-2 pt-1 text-dark" v-html="option_question"></b>
    </button>
  </div>
</template>

<script>
export default {
  props: {
    question: Object,
    attempted: Array,
    loadAttempts: Array,
    option_question: "",
    option: ""
  },
  methods: {
    attemptQuestion(question, ans) {
      this.$emit("attemptQuestion", question, ans);
    },
    mrkAtt(id, ans) {
      return this.attempted[id] === ans ? true : false;
    }
  }
};
</script>

<style></style>
