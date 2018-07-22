<template>
    <div class="deployment-task">
        <div class="card">
            <div class="card-header">
                {{ name }}

                <div class="progress" v-show="messages.length">
                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                         role="progressbar"
                         aria-valuenow="100"
                         aria-valuemin="0"
                         aria-valuemax="100"
                         style="width: 100%">
                    </div><!-- /.progress-bar -->
                </div><!-- /.progress -->
            </div><!-- /.card-header -->

            <div class="card-body" v-show="messages.length">
                <pre><span v-for="message in messages" v-html="message"></span></pre>
            </div><!-- /.card-body -->
        </div><!-- /.card -->
    </div><!-- /.deployment-task -->
</template>

<script>
    // Be careful with white-spaces or indentation within the <pre> tag because they will be
    // interpreted verbatim.

    export default {
        data() {
            return {
                messages: []
            };
        },

        props: {
            name: {
                required: true,
                type: String
            }
        },

        mounted() {
            const name = `.${this.name}`;

            window.Echo.private('deployment')
                .listen(name, (message) => {
                    this.messages.push(message.html);
                })
        }
    }
</script>

<style lang="scss" scoped>
    .card {
        margin: 1rem 0;

        .progress {
            margin: 0.5rem 0 0 0;
        }

        .card-body {
            padding: 0;
        }
    }

    pre {
        margin: 0;
        background: #073642;
        padding: 5px 10px;
        border-radius: 0;
        color: white;
        text-align: left;
        min-height: 20px;
        // Text inside pre elements is displayed as it is in the source which would overflow by d.
        white-space: pre-wrap;
    }
</style>
