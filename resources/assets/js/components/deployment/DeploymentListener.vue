<template>
    <table class="table position-relative mt-3">
        <thead>
            <tr>
                <th>Started</th>
                <th>Commit</th>
                <th></th>
            </tr>
        </thead>

        <tbody is="transition-group" name="list">
            <tr v-for="deployment in deployments" :key="deployment.id">
                <td>{{ deployment.created_at | diffForHumans }}</td>

                <td class="wrap-content">
                    <a :href="commitUrl(deployment.commit)" target="_blank">
                        {{ deployment.commit | short }}
                    </a>
                </td>

                <td class="wrap-content">
                    <a :href="deploymentUrl(deployment.id)" class="btn btn-primary btn-sm ml-3" role="button">
                        View deployment
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    import moment from 'moment';

    export default {
        data() {
            return {
                deployments: this.initialDeployments
            }
        },

        filters: {
            diffForHumans(time) {
                return moment(time, 'YYYY-MM-DD HH:mm:ss').fromNow();
            },

            short(hash) {
                return hash.substring(0, 7);
            }
        },

        props: {
            initialDeployments: {
                required: true,
                type: Array
            },

            repository: {
                required: true,
                type: String
            },

            route: {
                required: true,
                type: String
            }
        },

        created() {
            this.setDeploymentListeners();
        },

        methods: {
            commitUrl(hash) {
                return `${this.repository}/commit/${hash}`;
            },

            deploymentUrl(deploymentId) {
                return `${this.route}/deployments/${deploymentId}`;
            },

            setDeploymentListeners() {
                window.Echo.private('deployment')
                    .listen('DeploymentStarted', (response) => {
                        this.deployments.unshift(response.deployment);
                        this.deployments.pop();
                    });

                window.Echo.private('deployment')
                    .listen('DeploymentFinished', () => {
                        console.log('Deployment finished');
                    });
            },
        }
    }
</script>

<style lang="scss" scoped>
    td {
        z-index: 2;
        position: relative;

        &.wrap-content {
            width: 1%;
            white-space: nowrap;
        }
    }

    .running {
        color: white;
        background-color: #FFB212;

        .progress {
            z-index: 1;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            background-color: transparent;
            display: flex;

            .progress-bar {
                background-color: inherit;
            }
        }
    }

    .progress {
        display: none;
    }
</style>
