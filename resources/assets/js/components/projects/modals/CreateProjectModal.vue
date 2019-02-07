<template>
    <div class="create-project-modal">
        <div class="text-center mb-4">
            <svg-inline name="project"></svg-inline>
            <h2>Start a new project</h2>
        </div><!-- /.text-center -->

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
                    buttons: false,
                    className: 'text-left'
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
                        }).then(() => {
                            this.onProjectCreated(response.data.id)
                        });
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
            },

            onProjectCreated(projectId) {
                swal({
                    title: 'Would you like to add a webhook?',
                    text: `Setting a webhook will allow you to deploy your code automatically whenever you push changes.`,
                    icon: 'info',
                    buttons: true
                }).then((shouldSetWebhook) => {
                    if (shouldSetWebhook) {
                        axios.post(`/projects/${projectId}/webhooks`)
                            .then(() => {
                                swal({
                                    title: 'Success!',
                                    text: 'Webhook added',
                                    icon: 'success',
                                    buttons: false,
                                    timer: 1500
                                })
                            }).catch(() => {
                                swal({
                                    title: 'Webhook could not be added',
                                    text: 'Please check your repository permissions.',
                                    icon: 'error',
                                    buttons: false,
                                    timer: 1500
                                })
                            });
                    }
                })
            }
        }
    };
</script>

<style lang="scss" scoped>
    .svg-icon {
        margin: 1rem auto;
        display: block;
        width: 5rem;
        height: 5rem;
    }
</style>
