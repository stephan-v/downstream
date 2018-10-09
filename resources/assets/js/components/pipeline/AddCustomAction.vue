<template>
    <div class="add-custom-action mt-auto">
        <button type="button" class="btn btn-primary" @click="add">
            Add to pipeline
        </button>

        <custom-action-modal></custom-action-modal>
    </div><!-- /.add-custom-action -->
</template>

<script>
    import swal from 'sweetalert';

    export default {
        methods: {
            add() {
//                axios.post(window.location.href, { 'action_id': this.actionId })
//                    .then((response) => {
//                        this.$emit('create', response.data);
//
//                        swal({
//                            title: 'Success!',
//                            text: 'Added action to pipeline',
//                            icon: 'success',
//                            buttons: false,
//                            timer: 1500
//                        })
//                    }).catch(() => {
//                        swal({
//                            title: 'Oops',
//                            text: 'Action could not be added to pipeline',
//                            icon: 'error',
//                            buttons: false,
//                            timer: 1500
//                        })
//                    });
            }
        }
    };
</script>
