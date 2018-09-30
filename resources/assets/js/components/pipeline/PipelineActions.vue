<template>
    <section class="pipeline-actions">
        <h3 class="mb-3">Current pipeline</h3>

        <div class="pipeline">
            <div class="card mb-3" v-for="action in pipeline">
                <div class="card-header d-flex align-content-center">
                    {{ action.name }}
                </div><!-- /.card-header -->

                <div class="card-body">
                    <server-checkbox :server="server"
                                     :project-id="project.id"
                                     :action-id="action.id"
                                     :initial-checked="checked(action.servers, server.id)"
                                     :key="server.id"
                                     v-for="server in servers">
                    </server-checkbox>
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.pipeline -->
    </section><!-- /.pipeline-actions -->
</template>

<script>
    export default {
        props: {
            project: {
                required: true,
                type: Object
            }
        },

        computed: {
            pipeline() {
                return this.project.actions;
            },

            servers() {
                return this.project.servers;
            }
        },

        methods: {
            checked(servers, id) {
                const checked = servers.find((server) => {
                    return server.id === id;
                });

                // Cast the the outcome to a boolean.
                return !!checked;
            }
        }
    };
</script>
