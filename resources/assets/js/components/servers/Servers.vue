<template>
    <div class="servers">
        <div class="d-flex justify-content-between">
            <h2>Servers</h2>

            <create-server :project-id="project.id" @create="create"></create-server>
        </div><!-- /.d-flex -->

        <table class="table position-relative mt-3" v-if="servers.length">
            <thead>
                <tr>
                    <th>NAME</th>
                    <th>CONNECT AS</th>
                    <th>IP ADDRESS </th>
                    <th>CONNECTION STATUS</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="server in servers" :key="server.id">
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

        <p v-else>No servers have been assigned to this project.</p>
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
    table {
        tbody {
            background: white;
            box-shadow: 0 1px 1px #00000021;
        }

        th {
            border: 0;
            color: #616F7A;
            font-weight: normal;
        }

        tr:first-child {
            td {
                border: 0;
            }
        }

        td {
            border-color: #EDEDEF;
            vertical-align: middle;

            &.wrap-content {
                width: 1%;
                white-space: nowrap;
            }
        }
    }
</style>

