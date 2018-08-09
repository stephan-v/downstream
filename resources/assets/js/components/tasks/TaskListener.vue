<template>
    <tr :class="{ running }">
        <td>{{ name }}</td>

        <td class="wrap-content">
            <task-status :status="status"></task-status>
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
    export default {
        data() {
            return {
                messages: [],
                status: 'enqueued'
            };
        },

        props: {
            name: {
                required: true,
                type: String
            }
        },

        created() {
            this.setRemoteOutputListener();
            this.setTaskStartedListener();
            this.setTaskFinishedListener();
            this.setTaskFailedListener();
        },

        computed: {
            running() {
                return this.status === 'running';
            },

            startedTask() {
                return `.started-task-${this.name}`;
            },

            finishedTask() {
                return `.finished-task-${this.name}`;
            },

            failedTask() {
                return `.failed-task-${this.name}`;
            }
        },

        methods: {
//            setRemoteOutputListener() {
//                window.Echo.private('deployment')
//                    .listen(`.${this.name}`, (message) => {
//                        this.messages.push(message.html);
//                    });
//            },

            setTaskStartedListener() {
                window.Echo.private('task-status')
                    .listen(this.startedTask, () => {
                        this.status = 'running';
                    });
            },

            setTaskFinishedListener() {
                window.Echo.private('task-status')
                    .listen(this.finishedTask, () => {
                        this.status = 'completed';
                    });
            },

            setTaskFailedListener() {
                window.Echo.private('task-status')
                    .listen(this.failedTask, () => {
                        this.status = 'failed';
                    });
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
</style>
