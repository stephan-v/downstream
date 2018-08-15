<template>
    <div class="projects">
        <h1>Project overview</h1>

        <create-project @create="create"></create-project>

        <table class="table mt-3" v-if="projects.length">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Repository</th>
                    <th>Last deployed</th>
                </tr>
            </thead>

            <tbody>
                <tr is="project" :project="project" v-for="project in projects"></tr>
            </tbody>
        </table>

        <div class="alert alert-warning mt-3" role="alert" v-else>
            Add a project to get started
        </div>
    </div><!-- /.projects -->
</template>

<script>
    export default {
        data() {
            return {
                projects: this.initialProjects
            }
        },

        props: {
            initialProjects: {
                required: true,
                type: Array
            }
        },



        methods: {
            create(project) {
                this.projects.push(project);
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
