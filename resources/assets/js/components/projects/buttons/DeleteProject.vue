<template>
    <button type="button" class="btn btn-sm btn-primary" @click="openModal">
        <i class="fas fa-trash"></i>
        Delete project
    </button>
</template>

<script>
    import swal from 'sweetalert';

    export default {
        props: {
            project: {
                required: true,
                type: Object
            }
        },

        methods: {
            openModal() {
                swal({
                    title: "Are you sure?",
                    text: `This will permanently delete project: ${this.project.name}`,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) this.del();
                });
            },

            del() {
                axios.delete(`/projects/${this.project.id}`)
                    .then(() => {
                        this.$emit('del', this.project);

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
                        text: 'Something went wrong while trying to delete the project',
                        icon: 'error',
                        buttons: false,
                        timer: 1500
                    })
                });
            }
        }
    }
</script>
