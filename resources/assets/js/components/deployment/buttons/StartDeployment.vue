<template>
    <button type="button" class="btn" @click="deploy">
        <i class="fas fa-spinner fa-spin" v-if="status === 1 || status === 2 "></i>
        <span>{{ text }}</span>
    </button>
</template>

<script>
    import { FINISHED, PENDING, WAITING } from '../deployment-status-types';

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

                axios.post(`/deploy/${this.projectId}`);
            },

            setDeploymentListeners() {
                const channel = `project.${this.projectId}`;

                window.Echo.private(channel)
                    .listen('DeploymentStarted', () => {
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

<style lang="scss" scoped>
    .btn {
        background: none;
        border-radius: 20px;
        padding: 0.5rem 1.5rem;
        border: 2px solid black;
        color: black;
    }
</style>
