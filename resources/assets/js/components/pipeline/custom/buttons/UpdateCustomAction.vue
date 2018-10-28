<template>
    <span class="update-custom-action">
        <button type="button" class="btn btn-sm btn-dark" @click="toggle">
            edit action
        </button><!-- /.btn -->

        <update-custom-action-modal :action="action"
                                    v-if="visible"
                                    @close="toggle"
                                    @update="update">
        </update-custom-action-modal>
    </span><!-- /.update-custom-action -->
</template>

<script>
    export default {
        data() {
            return {
                visible: false
            };
        },

        props: {
            action: {
                required: true,
                type: Object
            }
        },

        methods: {
            update(action) {
                this.$emit('update', action);
                this.toggle();
            },

            toggle() {
                this.visible = !this.visible;
            }
        }
    }
</script>

