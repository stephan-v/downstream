<template>
    <div class="add-custom-action mt-auto">
        <button type="button" class="btn btn-primary w-100" @click="toggle">
            Add to pipeline
        </button><!-- /.btn -->

        <create-custom-action-modal v-if="visible"
                                    @close="toggle"
                                    @create="create">
        </create-custom-action-modal>
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
            create(action) {
                console.log(action);

                this.$emit('create', action);
                this.toggle();
            },

            toggle() {
                this.visible = !this.visible;
            }
        }
    }
</script>

