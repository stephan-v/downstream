<template>
    <li class="deployment d-flex justify-content-between align-items-center">
        <div class="title">
            <h2>Hooked up websockets</h2>

            <span class="green" v-if="finished">
                <i class="fas fa-check"></i> #{{ deployment.id }} passed
            </span>

            <span v-if="pending">
                <i class="fas fa-spinner fa-spin"></i> Deploying
            </span>
        </div><!-- /.title -->

        <div class="d-flex justify-content-between align-items-center">
            <div class="metadata mr-3">
                <div class="row mb-1">
                    <div class="col-5">
                        <i class="fab fa-github-alt"></i>

                        <a :href="commitUrl" target="_blank">
                            {{ deployment.commit }}
                        </a>
                    </div><!-- /.col -->

                    <div class="col-7">
                        <i class="far fa-clock"></i>
                        <span>{{ duration }}</span>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <div class="row">
                    <div class="col-5">
                        <i class="fas fa-code-branch"></i>
                        <span>master</span>
                    </div><!-- /.col -->

                    <div class="col-7">
                        <i class="far fa-calendar-alt"></i>
                        <span class="text-nowrap">{{ deployment.created_at | diffForHumans }}</span>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.metadata -->

            <div class="actions">
                <redeploy :project-id="deployment.project_id">
                    <i class="fas fa-redo-alt"></i>
                </redeploy>

                <a :href="deploymentUrl">
                    <i class="far fa-eye"></i>
                </a>
            </div><!-- /.actions -->
        </div>
    </li><!-- /.deployment -->
</template>

<script>
    import moment from 'moment';
    import { FINISHED, PENDING, FAILED } from '../../deployments/status-types';

    export default {
        props: {
            deployment: {
                required: true,
                type: Object
            }
        },

        filters: {
            diffForHumans(time) {
                return moment(time, 'YYYY-MM-DD HH:mm:ss').fromNow();
            }
        },

        created() {
            this.setDeploymentListeners();
        },

        computed: {
            duration() {
                const deployment = this.deployment;

                const finished = moment(deployment.finished_at, 'YYYY-MM-DD HH:mm:ss');
                const started = moment(deployment.created_at, 'YYYY-MM-DD HH:mm:ss');
                const duration = moment.duration(finished.diff(started)).humanize();

                return duration;
            },

            commitUrl() {
                return 'test';
            },

            deploymentUrl() {
                const origin = window.location.origin;
                const pathName = window.location.pathname;

                return `${origin}${pathName}/deployments/${this.deployment.id}`;
            },

            finished() {
                return this.deployment.status === FINISHED;
            },

            pending() {
                return this.deployment.status === PENDING;
            },

            failed() {
                return this.deployment.status === FAILED;
            },
        },

        methods: {
            setDeploymentListeners() {
                window.Echo.private('deployment')
                    .listen('DeploymentFinished', () => {
                        this.deployment.status = FINISHED;
                    });
            }
        }
    }
</script>

<style lang="scss" scoped>
    $green: #2CAF76;

    .green {
        color: $green;
    }

    .deployment {
        font-size: 1rem;
        background: white;
        border: 1px solid #E4E3E3;
        border-left: 10px solid $green;
        border-radius: 5px;
        margin: 0 0 1rem 0;
        padding: 1rem;
        color: #A5A9B5;

        h2 {
            color: black;
            font-size: 1.1rem;
            margin: 0 0 0.3rem 0;
        }

        .metadata {
            min-width: 250px;

            .col-5, .col-7 {
                padding: 0;

                i {
                    margin: 0 0.3rem 0 0;
                }
            }
        }

        .actions {
            a {
                color: #A5A9B5;

                i {
                    font-size: 1.4rem;
                    margin: 0 0 0 1.5rem;
                }
            }
        }
    }
</style>
