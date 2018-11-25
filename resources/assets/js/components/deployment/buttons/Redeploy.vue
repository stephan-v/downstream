<template>
    <a href="#" @click.prevent="deploy" title="Redeploy this deployment">
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
