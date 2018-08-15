<template>
    <tr>
        <td>
            <a :href="route">
                {{ project.name }}
            </a>
        </td>

        <td>
            <a :href="url">
                <i class="fab fa-github"></i> {{ project.repository }}
            </a>
        </td>

        <td>{{ created }}</td>
    </tr>
</template>

<script>
    export default {
        data() {
            return {
                created: 'N/A'
            }
        },

        props: {
            project: {
                required: true,
                type: Object
            }
        },

        created() {
            this.setDeploymentListeners();
        },

        computed: {
            channel() {
                return `project.${this.project.id}`;
            },

            url() {
                return `https://github.com/${this.project.repository}`
            },

            route() {
                return `/projects/${this.project.id}`;
            },

            timePassedSinceCreation() {
                return moment(this.created, 'YYYY-MM-DD HH:mm:ss').from(this.now);
            },
        },

        methods: {
            setDeploymentListeners() {
                window.Echo.private(this.channel)
                    .listen('DeploymentStarted', (response) => {
                        this.lastDeployed = response.deployment.created_at;
                    });
            }
        }
    }
</script>
