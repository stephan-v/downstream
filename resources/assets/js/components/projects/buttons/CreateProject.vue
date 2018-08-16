<template>
    <div class="create-project">
        <button type="button" class="btn btn-primary" @click="toggle">
            Add project
        </button>

        <create-project-modal @close="toggle" v-if="visible" @create="create"></create-project-modal>
    </div><!-- /.create-project -->
</template>

<script>
    export default {
        data() {
            return {
                visible: false
            };
        },

        methods: {
            create(project) {
                this.$emit('create', project);
                this.toggle();
            },

            toggle() {
                this.visible = !this.visible;
            }
        }
    }
</script>

