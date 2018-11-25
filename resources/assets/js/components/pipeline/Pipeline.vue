<template>
    <div class="pipeline mt-4">
        <pipeline-options :actions="actions" @create="create"></pipeline-options>
        <pipeline-actions :project="project" :pipeline="pipeline" @destroy="destroy" @update="update"></pipeline-actions>
    </div><!-- /.pipeline -->
</template>

<script>
    export default {
        data() {
            return {
                pipeline: this.project.actions
            }
        },

        props: {
            actions: {
                required: true,
                type: Array
            },

            project: {
                required: true,
                type: Object
            }
        },

        methods: {
            create(action) {
                this.pipeline.push(action);
            },

            destroy(action) {
                this.pipeline.splice(this.pipeline.indexOf(action), 1);
            },

            update(action) {
                const index = this.pipeline.findIndex(oldAction => oldAction.id === action.id);

                // Copy properties from the updated action object to the outdated action object.
                this.pipeline[index] = Object.assign(this.pipeline[index], action);
            },
        }
    };
</script>
