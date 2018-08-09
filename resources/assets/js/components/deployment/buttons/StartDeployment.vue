<template>
    <button type="button" class="btn btn-success" @click="deploy">
        <i class="fas fa-spinner fa-spin" v-if="status === 1 || status === 2 "></i>
        <span>{{ text }}</span>
    </button>
</template>

<script>
    import { FINISHED, PENDING, WAITING } from '../../../deployments/status-types';

    export default {
        data() {
            return {
                status: FINISHED
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
                    case WAITING:
                        return 'Awaiting workers';
                    case PENDING:
                        return 'Deploying';
                    default:
                        return 'Start deployment';
                }
            }
        },

        methods: {
            deploy() {
                this.status = WAITING;

                axios.post('/deploy', {
                    projectId: this.projectId
                });
            },

            setDeploymentListeners() {
                const channel = `project.${this.projectId}`;

                window.Echo.private(channel)
                    .listen('DeploymentStarted', () => {
                        console.log('deployment started');

                        this.status = PENDING;
                    });

                window.Echo.private(channel)
                    .listen('DeploymentFinished', () => {
                        this.status = FINISHED;
                    });
            },
        }
    }
</script>
