<template>
    <div class="pipeline">
        <pipeline-options :actions="actions" @create="create"></pipeline-options>
        <pipeline-actions :project="project" :pipeline="pipeline" @destroy="destroy"></pipeline-actions>
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
            }
        }
    };
</script>
