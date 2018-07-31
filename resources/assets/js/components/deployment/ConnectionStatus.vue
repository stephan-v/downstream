<template>
    <button type="button" class="btn btn-info" @click="getConnectionStatus">
        Test server connection
    </button>
</template>

<script>
    import swal from 'sweetalert';

    export default {
        methods: {
            getConnectionStatus() {
                axios.post('/connection')
                    .then(this.success)
                    .catch(this.error);
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
