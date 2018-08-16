<template>
    <div class="create-project-modal">
        <h1>Create a project</h1>

        <project-form @onSubmit="onSubmit"></project-form>
    </div><!-- /.create-project-modal -->
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
                    buttons: false
                }).then(() => {
                    this.$emit('close');
                });
            },

            onSubmit(data) {
                axios.post('/projects', data)
                    .then((response) => {
                        this.$emit('create', response.data);

                        swal({
                            title: 'Success!',
                            text: 'Project created',
                            icon: 'success',
                            buttons: false,
                            timer: 1500
                        })
                    }).catch(() => {
                        this.$emit('close');

                        swal({
                            title: 'Oops',
                            text: 'Project could not be created',
                            icon: 'error',
                            buttons: false,
                            timer: 1500
                        })
                    });
            }
        }
    };
</script>
