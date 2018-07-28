<template>
    <h1>Add a project</h1>
</template>

<script>
    import swal from 'sweetalert';

    export default {
        mounted() {
            this.openModal();
        },

        methods: {
            openModal() {
                swal({
                    content: this.$el,
                    buttons: false,
                    className: 'add-project-modal'
                }).then(() => {
                    this.$emit('close');
                });
            }
        }
    };
</script>
