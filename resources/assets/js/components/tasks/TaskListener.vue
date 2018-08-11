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
            deploymentId: {
                required: true,
                type: Number
            },

            name: {
                required: true,
                type: String
            }
        },

        created() {
            this.setTaskListener();
        },

        computed: {
            channel() {
                return `deployment.${this.deploymentId}`;
            }
        },

        methods: {
            setTaskListener() {
                window.Echo.private(this.channel)
                    .listen('test', () => {
                        this.status = 'running';
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
