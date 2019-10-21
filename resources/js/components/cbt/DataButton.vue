<template>
   <button :class="classes" @click="click(data)" title="Update">
        <span>
            <i class="fas fa-eye"></i>
        </span>
        &nbsp;
        {{ name }}
    </button>
</template>

<script>
export default {
    props: {
        data: {},
        name: {},
        click: {},
        meta: {},
        classes: {},
    }
}
</script>