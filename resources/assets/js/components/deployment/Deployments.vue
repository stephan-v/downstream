<template>
    <ul class="deployments">
        <deployment v-for="deployment in deployments"
                    :deployment="deployment"
                    :key="deployment.id">
        </deployment>
    </ul>
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

            projectId: {
                required: true,
                type: Number
            }
        },

        created() {
            this.setDeploymentListeners();
        },

        computed: {
            channel() {
                return `project.${this.projectId}`;
            }
        },

        methods: {
            addDeployment(deployment) {
                this.deployments.unshift(deployment);
            },

            cleanOldDeployments() {
                if (this.deployments.length > 5) this.deployments.pop();
            },

            setDeploymentListeners() {
                window.Echo.private(this.channel)
                    .listen('DeploymentStarted', (response) => {
                        this.addDeployment(response.deployment);
                        this.cleanOldDeployments();
                    });
            }
        }
    }
</script>

<style lang="scss" scoped>
    ul {
        margin: 0;
        padding: 0;
        list-style: none;

        li:last-child {
            margin: 0;
        }
    }
</style>
