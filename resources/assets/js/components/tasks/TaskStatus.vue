<template>
    <span class="badge" :class="badge.css">
        {{ badge.text }}
    </span>
</template>

<script>
    export default {
        data() {
            return {
                options: {
                    enqueued: {
                        css: 'badge-secondary',
                        text: 'enqueued'
                    },

                    running: {
                        css: 'badge-warning',
                        text: 'in progress'
                    },

                    completed: {
                        css: 'badge-success',
                        text: 'completed'
                    },

                    failed: {
                        css: 'badge-danger',
                        text: 'failed'
                    }
                }
            };
        },

        props: {
            status: {
                required: true,
                type: Number
            }
        },

        computed: {
            badge() {
                return this.options[this.status];
            }
        }
    }
</script>

<style lang="scss" scoped>
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
