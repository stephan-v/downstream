<template>
    <div class="add-server">
        <button type="button" class="btn btn-primary" @click="toggle">
            <i class="fas fa-plus"></i>
            Add server
        </button>

        <create-server-modal @close="toggle" @create="create" v-if="visible" :project-id="projectId"></create-server-modal>
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
            create(server) {
                this.$emit('create', server);
                this.toggle();
            },

            toggle() {
                this.visible = !this.visible;
            }
        }
    }
</script>
