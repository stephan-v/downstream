<template>
    <button type="button" class="btn btn-success" @click="deploy">
        Start deployment
    </button>
</template>

<script>
    export default {
        props: {
            projectId: {
                required: true,
                type: Number
            },

            serverId: {
                required: true,
                type: Number
            }
        },

        methods: {
            deploy() {
                axios.post('/deploy', {
                    projectId: this.projectId,
                    serverId: this.serverId
                });
            }
        }
    }
</script>
