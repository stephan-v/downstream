<template>
    <tr>
        <td>
            <a :href="route">
                {{ project.name }}
            </a>
        </td>

        <td>
            <a :href="url">
                <i class="fab fa-github"></i> {{ project.repository }}
            </a>
        </td>

        <td>{{ lastDeployment }}</td>

        <td class="wrap-content">
            <update-project :project="project" @update="update"></update-project>
        </td><!-- /.wrap-content -->

        <td class="wrap-content">
            <delete-project :project="project" @del="del"></delete-project>
        </td><!-- /.wrap-content -->
    </tr>
</template>

<script>
    export default {
        props: {
            project: {
                required: true,
                type: Object
            }
        },

        computed: {
            lastDeployment() {
                const deployments = this.project.deployments || [];

                const lastDeployment = deployments[deployments.length - 1];

                return lastDeployment ? lastDeployment.created_at : 'N/A';
            },

            url() {
                return `https://github.com/${this.project.repository}`
            },

            route() {
                return `/projects/${this.project.id}`;
            }
        },

        methods: {
            del(project) {
                this.$emit('del', project);
            },

            update(project) {
                this.$emit('update', project);
            }
        }
    }
</script>

<style lang="scss" scoped>
    td {
        &.wrap-content {
            width: 1%;
            white-space: nowrap;
        }
    }
</style>
