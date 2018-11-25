<template>
    <div class="deployments">
        <h2>Recent deployments</h2>

        <ul class="deployments" v-if="deployments.length">
            <transition-group name="list">
                <deployment v-for="deployment in deployments"
                            :deployment="deployment"
                            :key="deployment.id">
                </deployment>
            </transition-group>
        </ul>

        <p v-else>No recent deployments</p>
    </div><!-- /.deployments -->
</template>

<script>
    export default {
        data() {
            return {
                deployments: this.project.deployments.reverse()
            }
        },

        props: {
            project: {
                required: true,
                type: Object
            }
        },

        created() {
            this.setDeploymentListener();
        },

        methods: {
            addDeployment(deployment) {
                this.deployments.unshift(deployment);
            },

            cleanOldDeployments() {
                if (this.deployments.length > 5) this.deployments.pop();
            },

            setDeploymentListener() {
                const channel = `project.${this.project.id}`;

                window.Echo.private(channel)
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

    // Transition group animations.
    .list-enter-active {
        transition: all 1s;
    }

    .list-enter {
        opacity: 0;
        transform: translateX(30px);
    }

    .list-leave-to {
        display: none;
    }
</style>
