<template>
  <div class="form-group" :class="groupClass">
    <input
      :type="type"
      v-model="form[name]"
      :name="name"
      class="form-control form-control-sm"
      :placeholder="placeholder"
      :class="{ 'is-invalid': form.errors.has(name) }"
    />
    <has-error :form="form" :field="name"></has-error>
  </div>
</template>

<script>
export default {
  props: {
    form: {},
    name: "",
    type: "",
    placeholder: "",
    groupClass: ""
  }
};
</script>