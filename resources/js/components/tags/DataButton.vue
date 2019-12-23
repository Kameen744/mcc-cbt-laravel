<template>
    <button :class="classes" @click="click(data)" title="Update">
        <span>
            <i :class="classes.font"></i>
        </span>
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