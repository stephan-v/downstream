<template>
    <div class="update-custom-action-modal text-left">
        <h2>Update custom action</h2>

        <action-form :action="action" @onSubmit="onSubmit"></action-form>
    </div><!-- /.update-custom-action-modal -->
</template>

<script>
    import swal from 'sweetalert';

    export default {
        props: {
            action: {
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
                axios.patch(`${window.location.href}/actions/${this.action.id}`, data)
                    .then((response) => {
                        this.$emit('update', response.data);

                        swal({
                            title: 'Success',
                            text: 'Updated custom action',
                            buttons: false,
                            timer: 1000,
                            icon: 'success'
                        }).then(() => {
                            this.$emit('close');
                        });
                    })
                    .catch(() => {
                        this.$emit('close');

                        swal({
                            title: 'Oops',
                            text: 'Action could not be updated',
                            icon: 'error',
                            buttons: false,
                            timer: 1500
                        })
                    });
            }
        }
    };
</script>
