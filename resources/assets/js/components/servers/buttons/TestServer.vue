<template>
    <div class="connection-status">
        <span class="status-color" :class="statusClass"></span>
        <span>{{ statusText }}</span>
        <i class="fas fa-sync-alt" :class="{ 'fa-spin': pending }" @click="getConnectionStatus"></i>
    </div><!-- /.connection-status -->
</template>

<script>
    const UNTESTED = 0;
    const SUCCESSFUL = 1;
    const FAILED = 2;

    export default {
        data() {
            return {
                pending: false,
                status: UNTESTED
            }
        },

        props: {
            server: {
                required: true,
                type: Object
            }
        },

        created() {
            this.status = this.server.status;
        },

        computed: {
            statusText() {
                const status = {};

                status[UNTESTED] = 'unknown';
                status[SUCCESSFUL] = 'successful';
                status[FAILED] = 'failed';

                return status[this.status];
            },

            statusClass() {
                return {
                    untested: this.untested,
                    successful: this.successful,
                    failed: this.failed
                }
            },

            untested() {
                return this.status === UNTESTED;
            },

            successful() {
                return this.status === SUCCESSFUL;
            },

            failed() {
                return this.status === FAILED;
            }
        },

        methods: {
            getConnectionStatus() {
                this.pending = true;

                axios.post(`/servers/connection/${this.server.id}`)
                    .then(() => {
                        this.pending = false;
                        this.status = SUCCESSFUL;
                    })
                    .catch(() => {
                        this.pending = false;
                        this.status = FAILED;
                    });
            }
        }
    }
</script>

<style lang="scss" scoped>
    .status-color {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin: 0 0.2rem 0;

        &.untested {
            background: #f3a202;
        }

        &.successful {
            background: #00a745;
        }

        &.failed {
            background: #e82f2f;
        }
    }

    i {
        cursor: pointer;
        margin: 0 0 0 0.2rem;
    }
</style>
