<template>
    <section class="pipeline-actions">
        <h3 class="mb-3">Current pipeline</h3>

        <div class="pipeline">
            <sortable-list v-model="actions" @input="updateOrder">
                <ul slot-scope="{ items }">
                    <sortable-item v-for="action in actions" :key="action.id">
                        <li class="card mb-3">
                            <div class="card-header d-flex align-items-center">
                                <svg-inline name="drag"></svg-inline>

                                <span>{{ action.name }}</span>

                                <div class="ml-auto">
                                    <button type="button"
                                            class="btn btn-dark btn-sm"
                                            v-if="action.custom">
                                        edit action
                                    </button>

                                    <button type="button" class="btn btn-danger btn-sm" @click="destroy(action)">
                                        delete action
                                    </button>
                                </div><!-- /.ml-auto -->
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
                        </li><!-- /.card -->
                    </sortable-item>
                </ul>
            </sortable-list>
        </div><!-- /.pipeline -->
    </section><!-- /.pipeline-actions -->
</template>

<script>
    export default {
        data() {
            return {
                actions: this.pipeline,
                servers: this.project.servers
            }
        },

        props: {
            pipeline: {
                required: true,
                type: Array
            },

            project: {
                required: true,
                type: Object
            }
        },

        methods: {
            checked(servers, id) {
                const checked = servers.find((server) => {
                    return server.id === id;
                });

                // Cast the the outcome to a boolean.
                return !!checked;
            },

            destroy(action) {
                axios.delete(`${window.location.href}/${action.id}`)
                    .then(() => {
                        this.$emit('destroy', action);
                    });
            },

            updateOrder(actions) {
                axios.patch(`${window.location.href}`, {
                    actions: actions
                }).then(() => {
                    console.log('updated order')
                })
            }
        }
    };
</script>

<style lang="scss" scoped>
    ul {
        padding: 0;
    }

    .svg-drag {
        margin: 0 10px 0 0;

        /deep/ svg {
            fill: #737373;
            bottom: -0.07em;
        }
    }
</style>
