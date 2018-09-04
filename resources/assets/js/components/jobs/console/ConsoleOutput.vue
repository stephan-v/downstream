<template>
    <div class="console-output">
        <a href="#" @click.prevent="toggle">get output</a>

        <console-modal :output="placeholder" v-if="visible" @close="toggle"></console-modal>
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
            output: {
                required: true,
                type: String
            }
        },

        computed: {
            hasOutput() {
                return this.output.length;
            },

            placeholder() {
                return this.hasOutput ? this.output : ['Awaiting task output...'];
            }
        },

        methods: {
            toggle() {
                this.visible = !this.visible;
            }
        }
    }
</script>
