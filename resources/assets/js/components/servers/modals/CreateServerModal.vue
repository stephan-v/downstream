<template>
    <div class="create-server-modal">
        <h2>Add a server</h2>

        <server-form @onSubmit="onSubmit"></server-form>
    </div><!-- /.create-server-modal -->
</template>

<script>
    import swal from 'sweetalert';

    export default {
        props: {
            projectId: {
                required: true,
                type: Number
            }
        },

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
                axios.post('/servers', { ...data, project_id: this.projectId})
                    .then((response) => {
                        this.$emit('create', response.data);

                        swal({
                            title: 'Success!',
                            text: 'Server added',
                            icon: 'success',
                            buttons: false,
                            timer: 1500
                        })
                    }).catch(() => {
                        this.$emit('close');

                        swal({
                            title: 'Oops',
                            text: 'Server could not be created',
                            icon: 'error',
                            buttons: false,
                            timer: 1500
                        })
                    });
            }
        }
    };
</script>
