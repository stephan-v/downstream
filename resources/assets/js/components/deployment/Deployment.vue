<template>
    <li class="deployment d-flex justify-content-between align-items-center" :class="{ failed }">
        <div class="title">
            <h2>Hooked up websockets</h2>

            <span class="green" v-if="finished">
                <i class="fas fa-check"></i> #{{ deployment.id }} passed
            </span>

            <span class="red" v-if="failed">
                <i class="fas fa-times"></i> #{{ deployment.id }} failed
            </span>

            <span v-if="pending">
                <i class="fas fa-spinner fa-spin"></i> Deploying
            </span>
        </div><!-- /.title -->

        <div class="d-flex justify-content-between align-items-center">
            <div class="metadata mr-3">
                <div class="row mb-1">
                    <div class="col-5" title="The commit hash related to this deployment">
                        <i class="fab fa-github-alt"></i>

                        <a :href="commitUrl" target="_blank">
                            {{ shortSha }}
                        </a>
                    </div><!-- /.col -->

                    <div class="col-7" title="The total runtime of this deployment">
                        <i class="far fa-clock"></i>
                        <span v-if="deployment.finished_at">{{ totalRuntime }}</span>
                        <span v-else>Unknown</span>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <div class="row">
                    <div class="col-5" title="The branch used for this deployment">
                        <i class="fas fa-code-branch"></i>
                        <span>master</span>
                    </div><!-- /.col -->

                    <div class="col-7" title="The time that passed since this deployment ran">
                        <i class="far fa-calendar-alt"></i>
                        <span class="text-nowrap">{{ timePassedSinceCreation }}</span>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.metadata -->

            <div class="actions">
                <redeploy :project-id="deployment.project_id">
                    <i class="fas fa-redo-alt"></i>
                </redeploy>

                <a :href="deploymentUrl" title="View deployment" target="_blank">
                    <i class="far fa-eye"></i>
                </a>
            </div><!-- /.actions -->
        </div>
    </li><!-- /.deployment -->
</template>

<script>
    import moment from 'moment';
    import { FINISHED, PENDING, FAILED } from './deployment-status-types';

    export default {
        data() {
            return {
                now: moment(),
                interval: null
            };
        },

        props: {
            deployment: {
                required: true,
                type: Object
            }
        },

        created() {
            this.setDeploymentListeners();
            this.updateCurrentTime();
        },

        beforeDestroy() {
            clearInterval(this.interval);
        },

        computed: {
            timePassedSinceCreation() {
                const created = this.deployment.created_at;

                return moment(created, 'YYYY-MM-DD HH:mm:ss').from(this.now);
            },

            totalRuntime() {
                const deployment = this.deployment;

                const finished = moment(deployment.finished_at, 'YYYY-MM-DD HH:mm:ss');
                const started = moment(deployment.created_at, 'YYYY-MM-DD HH:mm:ss');

                return moment.duration(finished.diff(started)).humanize();
            },

            commitUrl() {
                return this.deployment.commit_url;
            },

            shortSha() {
                return this.deployment.commit.slice(0, 7);
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
            updateCurrentTime() {
              this.interval = setInterval(() => {
                  this.now = moment();
              }, 1000)
            },

            setDeploymentListeners() {
                const channel = `project.${this.deployment.project_id}`;

                window.Echo.private(channel)
                    .listen('DeploymentFinished', (response) => {
                        const deployment = response.deployment;

                        // Only update this specific deployment instance.
                        if (this.deployment.id === deployment.id) {
                            this.deployment.status = deployment.status;
                            this.deployment.finished_at = deployment.finished_at;
                        }
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

    .red {
        color: #ff2929;
    }

    .deployment {
        font-size: 1rem;
        background: white;
        border-left: 10px solid $green;
        margin: 0 0 .8rem 0;
        padding: 1rem;
        color: #A5A9B5;
        box-shadow: 0 1px 1px #00000021;

        &.failed {
            border-left-color: #ff2929;
        }

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
