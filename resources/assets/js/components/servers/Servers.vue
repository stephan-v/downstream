<template>
    <div class="servers">
        <div class="d-flex justify-content-between">
            <h2>Servers</h2>

            <create-server :project-id="project.id" @create="create"></create-server>
        </div><!-- /.d-flex -->

        <table class="table position-relative mt-3">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Connect as</th>
                    <th>IP Address </th>
                    <th>Connection status</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="server in servers">
                    <td>{{ server.name }}</td>
                    <td>{{ server.user }}</td>
                    <td>{{ server.ip_address }}</td>

                    <td>
                        <test-server :server="server"></test-server>
                    </td>

                    <td class="wrap-content">
                        <update-server :server="server" @update="update"></update-server>
                    </td>

                    <td class="wrap-content">
                        <delete-server :server="server" @del="del"></delete-server>
                    </td>
                </tr>
            </tbody>
        </table>
    </div><!-- /.servers -->
</template>

<script>
    export default {
        data() {
            return {
                servers: this.project.servers
            };
        },

        props: {
            project: {
                required: true,
                type: Object
            }
        },

        methods: {
            create(server) {
                this.servers.push(server);
            },

            update(server) {
                const index = this.servers.findIndex(oldServer => oldServer.id === server.id);

                // Copy properties from the updated server object to the outdated server object.
                this.servers[index] = Object.assign(this.servers[index], server);
            },

            del(server) {
                this.servers.splice(this.servers.indexOf(server), 1);
            }
        }
    }
</script>

<style lang="scss" scoped>
    td {
        &.wrap-content {
            width: 1%;
            white-space: nowrap;
        }
    }
</style>

