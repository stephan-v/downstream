<template>
    <div class="console-output">
        <a href="#" @click.prevent="openModal">get output</a>

        <console-modal :messages="messages" v-if="visible"></console-modal>
    </div><!-- /.console-output -->
</template>

<script>
    import swal from 'sweetalert';

    export default {
        data() {
            return {
                visible: false
            }
        },

        props: {
            messages: {
                required: true,
                type: Array
            }
        },

        methods: {
            openModal() {
                this.visible = true;
            }
        }
    }
</script>
