<template>
    <tr v-if="date">
        <td>{{ date }}</td>
        <td>{{ commit }}</td>
    </tr>
</template>

<script>
    export default {
        data() {
            return {
                date: '',
                commit: ''
            }
        },

        created() {
            this.setDeploymentListeners();
        },

        methods: {
            setDeploymentListeners() {
                window.Echo.private('deployment')
                    .listen('DeploymentStarted', (e) => {
                        this.date = e.created_at.date;
                        this.commit = e.commit;
                    });

                window.Echo.private('deployment')
                    .listen('DeploymentFinished', () => {
                        console.log('Deployment finished');
                    });
            },
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
