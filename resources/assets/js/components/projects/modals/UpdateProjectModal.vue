<template>
    <div class="update-project-modal">
        <h2>Update project</h2>

        <project-form :project="project" @onSubmit="onSubmit"></project-form>
    </div><!-- /.update-project-modal -->
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

        mounted() {
            this.openModal();
        },

        methods: {
            openModal() {
                swal({
                    content: this.$el,
                    buttons: false,
                    className: 'text-left'
                }).then(() => {
                    this.$emit('close');
                });
            },

            onSubmit(data) {
                axios.patch(`/projects/${this.project.id}`, data)
                    .then((response) => {
                        this.$emit('update', response.data);

                        swal({
                            title: 'Success!',
                            text: 'Project updated',
                            icon: 'success',
                            buttons: false,
                            timer: 1500
                        })
                    }).catch(() => {
                        this.$emit('close');

                        swal({
                            title: 'Oops',
                            text: 'Project could not be updated',
                            icon: 'error',
                            buttons: false,
                            timer: 1500
                        })
                    });
            }
        }
    };
</script>
