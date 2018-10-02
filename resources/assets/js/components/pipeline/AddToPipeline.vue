<template>
    <button type="button" class="btn btn-primary mt-auto" @click="add">
        Add to pipeline
    </button>
</template>

<script>
    import swal from 'sweetalert';

    export default {
        props: {
            actionId: {
                required: true,
                type: Number
            }
        },

        methods: {
            add() {
                axios.post(window.location.href, { 'action_id': this.actionId })
                    .then((response) => {
                        this.$emit('create', response.data);

                        swal({
                            title: 'Success!',
                            text: 'Added action to pipeline',
                            icon: 'success',
                            buttons: false,
                            timer: 1500
                        })
                    }).catch(() => {
                        swal({
                            title: 'Oops',
                            text: 'Action could not be added to pipeline',
                            icon: 'error',
                            buttons: false,
                            timer: 1500
                        })
                    });
            }
        }
    };
</script>
