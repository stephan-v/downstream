<template>
    <button type="button" class="btn btn-info" @click="getConnectionStatus">
        <i class="fas fa-spinner fa-spin" v-if="pending"></i>
        Test server connection
    </button>
</template>

<script>
    import swal from 'sweetalert';

    export default {
        data() {
            return {
                pending: false
            }
        },

        methods: {
            getConnectionStatus() {
                this.pending = true;

                axios.post('/connection')
                    .then(() => {
                        this.pending = false;
                        this.success();
                    })
                    .catch(() => {
                        this.pending = false;
                        this.error();
                    });
            },

            success() {
                swal({
                    title: 'Success!',
                    text: 'Connection established',
                    icon: 'success',
                    buttons: false,
                    timer: 1500
                })
            },

            error() {
                swal({
                    title: 'Oops',
                    text: 'Connection could not be established',
                    icon: 'error',
                    buttons: false,
                    timer: 1500
                })
            }
        }
    }
</script>
