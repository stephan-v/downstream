<template>
    <div class="update-project">
        <button type="button" class="btn btn-sm btn-primary" @click="toggle">
            <i class="fas fa-edit"></i>
            Edit project
        </button>

        <update-project-modal @close="toggle" @update="update" v-if="visible" :project="project"></update-project-modal>
    </div><!-- /.update-project -->
</template>

<script>
    export default {
        data() {
            return {
                visible: false
            };
        },

        props: {
            project: {
                required: true,
                type: Object
            }
        },

        methods: {
            update(project) {
                this.$emit('update', project);
                this.toggle();
            },

            toggle() {
                this.visible = !this.visible;
            }
        }
    }
</script>
