<template>
    <tr :class="{ running }">
        <td>{{ task.name }}</td>

        <td class="wrap-content">
            <task-status :status="status"></task-status>
        </td>

        <td class="wrap-content">
            <console-output :output="output"></console-output>
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
    const RUNNING = 0;

    export default {
        data() {
            return {
                output: this.task.output || '',
                status: this.task.status
            };
        },

        props: {
            task: {
                required: true,
                type: Object
            }
        },

        created() {
            this.setTaskListener();
        },

        computed: {
            channel() {
                return `task.${this.task.id}`;
            },

            running() {
                return this.status === RUNNING;
            }
        },

        methods: {
            setTaskListener() {
                window.Echo.private(this.channel)
                    .listen('CommandExecuted', (response) => {
                        this.output.push(response.html);
                    })
                    .listen('TaskUpdated', (response) => {
                        this.status = response.status;
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
