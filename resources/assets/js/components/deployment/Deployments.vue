<template>
    <div class="deployments">
        <ul class="deployments">
            <deployment v-for="deployment in deployments" :deployment="deployment" :key="deployment.id"></deployment>
        </ul>
    </div><!-- /.deployments -->
</template>

<script>
    export default {
        data() {
            return {
                deployments: this.project.deployments
            }
        },

        props: {
            project: {
                required: true,
                type: Object
            }
        },

        methods: {
            addDeployment(deployment) {
                this.deployments.unshift(deployment);
            },

            cleanOldDeployments() {
                if (this.deployments.length > 5) this.deployments.pop();
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
