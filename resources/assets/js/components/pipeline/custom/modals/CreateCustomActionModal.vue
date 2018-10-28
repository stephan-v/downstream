<template>
    <div class="create-custom-action-modal text-left">
        <h2>Create a custom action</h2>

        <action-form @onSubmit="onSubmit"></action-form>
    </div><!-- /.create-custom-action-modal -->
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
                axios.post(`${window.location.href}/actions`, data)
                    .then((response) => {
                        this.$emit('create', response.data);

                        swal({
                            title: 'Success',
                            text: 'Added custom action',
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
                            text: 'Action could not be created',
                            icon: 'error',
                            buttons: false,
                            timer: 1500
                        })
                    });
            }
        }
    };
</script>
