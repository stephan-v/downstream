<template>
    <tr>
        <td>{{ deployment.created_at | diffForHumans }}</td>

        <td>
            <a :href="commitUrl" target="_blank">
                {{ deployment.commit | short }}
            </a>
        </td>

        <td>
            <template v-if="finished">
                <i class="fas fa-check text-success"></i>
                <span>Finished</span>
            </template>

            <template v-if="pending">
                <i class="fas fa-spinner fa-spin"></i>
                <span>Deploying</span>
            </template>
        </td>

        <td>
            <a :href="deploymentUrl" class="btn btn-primary btn-sm" role="button">
                View deployment
            </a>
        </td>
    </tr>
</template>

<script>
    import moment from 'moment';
    import { FINISHED, PENDING, FAILED } from '../../deployments/status-types';

    export default {
        props: {
            deployment: {
                required: true,
                type: Object
            }
        },

        filters: {
            diffForHumans(time) {
                return moment(time, 'YYYY-MM-DD HH:mm:ss').fromNow();
            },

            short(hash) {
                return hash.substring(0, 7);
            }
        },

        created() {
            this.setDeploymentListeners();
        },

        computed: {
            commitUrl() {
                return `${this.repository}/commit/${this.deployment.commit}`;
            },

            deploymentUrl() {
                return `${this.route}/deployments/${this.deployment.id}`;
            },

            finished() {
                return this.deployment.status === FINISHED;
            },

            pending() {
                return this.deployment.status === PENDING;
            },

            failed() {
                return this.deployment.status === FAILED;
            },
        },

        methods: {
            setDeploymentListeners() {
                window.Echo.private('deployment')
                    .listen('DeploymentFinished', () => {
                        this.deployment.status = FINISHED;
                    });
            }
        }
    }
</script>
