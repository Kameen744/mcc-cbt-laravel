<template>
  <div>
      <button @click="changed" :value="value">Edit Admin</button>
  </div>
</template>

<script>
export default {
    props: {
        changed: Function,
        value: ''
    }
}
</script>

<style>

</style>