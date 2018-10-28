<template>
    <div class="add-custom-action mt-auto">
        <button type="button" class="btn btn-primary w-100" @click="toggle">
            Add to pipeline
        </button><!-- /.btn -->

        <create-custom-action-modal @close="toggle" v-if="visible" @create="create"></create-custom-action-modal>
    </div><!-- /.add-custom-action -->
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

