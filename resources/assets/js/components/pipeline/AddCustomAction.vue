<template>
    <div class="add-custom-action mt-auto">
        <button type="button" class="btn btn-primary" @click="open">
            Add to pipeline
        </button>

        <create-custom-action @close="close" v-if="visible" @create="create"></create-custom-action>
    </div><!-- /.add-custom-action -->
</template>

<script>
    import swal from 'sweetalert';

    export default {
        data() {
            return {
                visible: false
            }
        },

        methods: {
            create(action) {
                this.$emit('create', action);
            },

            close() {
                this.visible = false;
            },

            open() {
                this.visible = true;
            }
        }
    };
</script>
