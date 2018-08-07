<template>
    <button type="button" class="btn btn-success" @click="deploy">
        <i class="fas fa-spinner fa-spin" v-if="status === 1 || status === 2 "></i>
        <span>{{ text }}</span>
    </button>
</template>

<script>
    export default {
        data() {
            return {
                status: 0
            }
        },

        props: {
            projectId: {
                required: true,
                type: Number
            }
        },

        created() {
            this.setDeploymentListeners();
        },

        computed: {
            text() {
                switch(this.status) {
                    case 1:
                        return 'Awaiting workers';
                    case 2:
                        return 'Deploying';
                    default:
                        return 'Start deployment';
                }
            }
        },

        methods: {
            deploy() {
                axios.post('/deploy', {
                    projectId: this.projectId
                }).then(() => {
                    this.status = 1;
                });
            },

            setDeploymentListeners() {
                window.Echo.private('deployment')
                    .listen('DeploymentStarted', () => {
                        this.status = 2;
                    });

                window.Echo.private('deployment')
                    .listen('DeploymentFinished', () => {
                        this.status = 0;
                    });
            },
        }
    }
</script>
