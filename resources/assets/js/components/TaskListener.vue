<template>
    <tr  :class="{ running }">
        <td>{{ name }}</td>

        <td class="wrap-content">
            <span class="badge badge-warning" v-if="running">in progress</span>
            <span class="badge badge-secondary" v-if="enqueued">enqueued</span>
            <span class="badge badge-success" v-if="completed">completed</span>
        </td>

        <td class="wrap-content">
            <console-output :messages="messages"></console-output>
        </td>

        <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated"
                 role="progressbar"
                 aria-valuenow="100"
                 aria-valuemin="0"
                 aria-valuemax="100"
                 style="width: 100%">
            </div><!-- /.progress-bar -->
        </div><!-- /.progress -->
    </tr><!-- /.deployment-task -->
</template>

<script>
    // Be careful with white-spaces or indentation within the <pre> tag because they will be
    // interpreted verbatim.

    export default {
        data() {
            return {
                messages: [],
                running: false,
                completed: false
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
                    this.completed = true;
                });
        },

        computed: {
            enqueued() {
                return !this.completed && !this.running;
            },

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
    td {
        z-index: 2;
        position: relative;

        &.wrap-content {
            width: 1%;
            white-space: nowrap;
        }
    }

    .running {
        color: white;
        background-color: #FFB212;

        .progress {
            z-index: 1;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            background-color: transparent;
            display: flex;

            .progress-bar {
                background-color: inherit;
            }
        }
    }

    .progress {
        display: none;
    }

    .badge {
        padding: 0.7em 1em;
        color: white;
    }

    .badge-warning {
        animation-duration: 0.5s;
        animation-name: inProgress;
        animation-iteration-count: infinite;
        animation-direction: alternate;
        background: #FF9715;
    }

    @keyframes inProgress {
        0% {
            transform: scale(1);
        }

        100% {
            transform: scale(0.9);
        }
    }
</style>
