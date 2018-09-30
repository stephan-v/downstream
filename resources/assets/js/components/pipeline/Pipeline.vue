<template>
    <div class="pipeline">
        <pipeline-options :actions="actions"></pipeline-options>
        <pipeline-actions :project="project"></pipeline-actions>
    </div><!-- /.pipeline -->
</template>

<script>
    export default {
        props: {
            actions: {
                required: true,
                type: Array
            },

            project: {
                required: true,
                type: Object
            }
        }
    };
</script>
