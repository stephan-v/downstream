<template>
    <li class="list-group-item d-flex justify-content-between" :class="{ running }">
        <span>Server: {{ job.server.ip_address }}</span>

        <div class="d-flex">
            <span class="wrap-content">
                <job-status :status="status"></job-status>
            </span>

            <span class="wrap-content ml-2">
                <console-output :output="output"></console-output>
            </span>

            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated"
                     role="progressbar"
                     aria-valuenow="100"
                     aria-valuemin="0"
                     aria-valuemax="100"
                     style="width: 100%">
                </div><!-- /.progress-bar -->
            </div><!-- /.progress -->
        </div>
    </li>
</template>

<script>
    const RUNNING = 0;

    export default {
        data() {
            return {
                output: this.job.output || '',
                status: this.job.status
            };
        },

        props: {
            job: {
                required: true,
                type: Object
            }
        },

        created() {
            this.setJobListener();
        },

        computed: {
            channel() {
                return `task.${this.job.id}`;
            },

            running() {
                return this.status === RUNNING;
            }
        },

        methods: {
            setJobListener() {
                window.Echo.private(this.channel)
                    .listen('CommandExecuted', (response) => {
                        this.output.push(response.html);
                    })
                    .listen('JobUpdated', (response) => {
                        this.status = response.status;
                    });
            }
        }
    }
</script>

<style lang="scss" scoped>
    .wrap-content {
        z-index: 1;
    }

    .running {
        color: white;
        background-color: #FFB212;

        .progress {
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
