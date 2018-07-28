<template>
    <div class="console-output">
        <a href="#" @click.prevent="toggle">get output</a>

        <console-modal :messages="output" v-if="visible" @close="toggle"></console-modal>
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

        computed: {
            // Output with a placeholder which is used when no messages are received yet.
            output() {
                return this.messages.length ? this.messages : ['Awaiting task output...'];
            }
        },

        methods: {
            toggle() {
                this.visible = !this.visible;
            }
        }
    }
</script>
