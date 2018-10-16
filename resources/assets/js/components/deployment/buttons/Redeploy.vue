<template>
    <a href="#" @click.prevent="deploy">
        <slot></slot>
    </a>
</template>

<script>
    export default {
        props: {
            projectId: {
                required: true,
                type: Number
            }
        },

        methods: {
            deploy() {
                axios.post(`/deploy/${this.projectId}`);
            }
        }
    }
</script>
