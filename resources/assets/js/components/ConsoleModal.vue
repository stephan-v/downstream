<template>
    <div class="console-modal">
        <div class="header">Console output</div>

        <div class="body">
            <pre><span v-for="message in messages" v-html="message"></span></pre>
        </div><!-- /.body -->
    </div><!-- /.console-modal -->
</template>

<script>
    import swal from 'sweetalert';

    export default {
        props: {
            messages: {
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
                });
            }
        }
    }
</script>

<style lang="scss">
    .console-modal {
        .header {
            background: #2B3351;
            color: white;
            font-weight: bold;
            padding: 0.5em;
            text-align: left;
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
            min-height: 50px;
            // Text inside pre elements is displayed as it is in the source which would overflow by d.
            white-space: pre-wrap;
        }
    }
</style>
