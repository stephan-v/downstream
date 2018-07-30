<template>
    <div class="add-server">
        <button type="button" class="btn btn-primary" @click="toggle">
            <i class="fas fa-plus"></i>
            Add server
        </button>

        <server-modal @close="toggle" v-if="visible" :project-id="projectId"></server-modal>
    </div><!-- /.add-server -->
</template>

<script>
    export default {
        data() {
            return {
                visible: false
            };
        },

        props: {
            projectId: {
                required: true,
                type: Number
            }
        },

        methods: {
            toggle() {
                this.visible = !this.visible;
            }
        }
    }
</script>
