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
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <tr is="project" :project="project" v-for="project in projects" @del="del" @update="update"></tr>
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

            del(project) {
                this.projects.splice(this.projects.indexOf(project), 1);
            },

            update(project) {
                const index = this.projects.findIndex(oldProject => oldProject.id === project.id);

                // Copy properties from the updated server object to the outdated server object.
                this.projects[index] = Object.assign(this.projects[index], project);
            },
        }
    }
</script>
