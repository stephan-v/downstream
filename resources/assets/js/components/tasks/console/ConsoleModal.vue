<template>
    <div class="console-modal">
        <div class="header">Console output</div>

        <div class="body">
            <!-- do not use whitespace or new lines within the pre tag (verbatim markup) -->
            <pre><span v-for="message in output" v-html="message"></span></pre>
        </div><!-- /.body -->
    </div><!-- /.console-modal -->
</template>

<script>
    import swal from 'sweetalert';

    export default {
        props: {
            output: {
                required: true,
                type: Array
            }
        },

        mounted() {
            this.openModal();
        },

        methods: {
            openModal() {
                swal({
                    content: this.$el,
                    buttons: false,
                    className: 'console-modal'
                }).then(() => {
                    this.$emit('close');
                });
            }
        }
    }
</script>

<style lang="scss">
    .console-modal {
        width: 800px;

        .header {
            background: #2B3351;
            color: white;
            font-weight: bold;
            padding: 0.5em;
            text-align: left;
        }

        .body {
            max-height: 500px;
            overflow-y: auto;
        }

        .swal-content {
            margin: 0;
            padding: 0;
        }

        pre {
            margin: 0;
            background: #212636;
            padding: 5px 10px;
            border-radius: 0;
            color: white;
            text-align: left;
            white-space: pre-wrap;
        }
    }
</style>
