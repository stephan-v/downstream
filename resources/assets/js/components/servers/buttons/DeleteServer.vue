<template>
    <div class="add-server">
        <button type="button" class="btn btn-sm btn-primary" @click="openModal">
            <i class="fas fa-trash"></i>
            Delete server
        </button>
    </div><!-- /.add-server -->
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

        methods: {
            openModal() {
                swal({
                    title: "Are you sure?",
                    text: `This will permanently delete server: ${this.server.name}`,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) this.del();
                });
            },

            del() {
                axios.delete(`/servers/${this.server.id}`)
                    .then(() => {
                        this.$emit('del', this.server);

                        swal({
                            title: 'Success!',
                            text: 'Server deleted',
                            icon: 'success',
                            buttons: false,
                            timer: 1500
                        })
                    }).catch(() => {
                        swal({
                            title: 'Oops',
                            text: 'Something went wrong while trying to delete the server',
                            icon: 'error',
                            buttons: false,
                            timer: 1500
                        })
                    });
            }
        }
    }
</script>
