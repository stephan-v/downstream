<template>
    <div class="deployment-task">
        <div class="card">
            <div class="card-header">
                {{ name }}

                <div class="progress" v-show="running">
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
                messages: [],
                running: false
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

            // Listen for SSH output.
            window.Echo.private('deployment')
                .listen(name, (message) => {
                    this.messages.push(message.html);
                });

            // Listen for starting and finished tasks.
            window.Echo.private('task-status')
                .listen(this.startedTask, () => {
                    this.running = true;
                })
                .listen(this.finishedTask, () => {
                    this.running = false;
                });
        },

        computed: {
            startedTask() {
                return `.started-task-${this.name}`;
            },

            finishedTask() {
                return `.finished-task-${this.name}`;
            }
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
