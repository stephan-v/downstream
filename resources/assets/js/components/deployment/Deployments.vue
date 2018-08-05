<template>
    <table class="table position-relative mt-3">
        <thead>
            <tr>
                <th>Started</th>
                <th>Commit</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>

        <tbody is="transition-group" name="list">
            <deployment v-for="deployment in deployments"
                        :deployment="deployment"
                        :key="deployment.id">
            </deployment>
        </tbody>
    </table>
</template>

<script>
    export default {
        data() {
            return {
                deployments: this.initialDeployments
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
            setDeploymentListeners() {
                window.Echo.private('deployment')
                    .listen('DeploymentStarted', (response) => {
                        this.deployments.unshift(response.deployment);
                        this.deployments.pop();
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
