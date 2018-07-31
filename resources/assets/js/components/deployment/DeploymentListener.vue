<template>
    <table class="table position-relative mt-3">
        <thead>
            <tr>
                <th>Started</th>
                <th>Commit</th>
            </tr>
        </thead>

        <tbody>
            <tr v-for="deployment in deployments">
                <td>{{ deployment.created_at | diffForHumans }}</td>
                <td>{{ deployment.commit }}</td>
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
            }
        },

        props: {
            initialDeployments: {
                required: true,
                type: Array
            }
        },

        created() {
            this.setDeploymentListeners();
        },

        methods: {
            setDeploymentListeners() {
                window.Echo.private('deployment')
                    .listen('DeploymentStarted', (response) => {
                        this.deployments.unshift(response.deployment);
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
