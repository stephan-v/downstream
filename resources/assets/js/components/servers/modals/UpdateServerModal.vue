<template>
    <div class="update-server-modal">
        <h2>Edit server</h2>

        <server-form :server="server" @onSubmit="onSubmit"></server-form>
    </div><!-- /.update-server-modal -->
</template>

<script>
    import swal from 'sweetalert';

    export default {
        props: {
            server: {
                required: true,
                type: Object
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
                axios.patch(`/servers/${this.server.id}`, { ...data })
                    .then((response) => {
                        this.$emit('update', response.data);

                        swal({
                            title: 'Success!',
                            text: 'Server settings updated',
                            icon: 'success',
                            buttons: false,
                            timer: 1500
                        })
                    }).catch(() => {
                        this.$emit('close');

                        swal({
                            title: 'Oops',
                            text: 'Server settings could not be updated',
                            icon: 'error',
                            buttons: false,
                            timer: 1500
                        })
                    });
            }
        }
    };
</script>
