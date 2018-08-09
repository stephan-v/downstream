<template>
    <ul class="deployments">
        <deployment v-for="deployment in deployments" :deployment="deployment" :key="deployment.id"></deployment>
    </ul><!-- /.deployments -->
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

                        // Remove the last deployment if we have more than 5
                        if (this.deployments.length > 5) this.deployments.pop();
                    });
            },
        }
    }
</script>

<style lang="scss" scoped>
    ul {
        margin: 0;
        list-style: none;
    }
</style>
