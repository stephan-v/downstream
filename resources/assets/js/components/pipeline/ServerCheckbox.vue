<template>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" v-model="checked" :id="identifier">

        <label class="form-check-label" :for="identifier">
            {{ server.ip_address }}
            <small class="text-muted">({{ server.name }})</small>
        </label>
    </div><!-- /.form-check -->
</template>

<script>
    export default {
        data() {
            return {
                checked: this.initialChecked
            }
        },

        props: {
            actionId: {
                required: true,
                type: Number
            },

            projectId: {
                required: true,
                type: Number
            },

            initialChecked: {
                required: true,
                type: Boolean
            },

            server: {
                required: true,
                type: Object
            }
        },

        watch: {
            checked(checked) {
                checked ? this.attach() : this.detach();
            }
        },

        computed: {
            identifier() {
                return `${this.actionId}-${this.server.id}`;
            },

            route() {
                return `/projects/${this.projectId}/pipeline/servers`;
            }
        },

        methods: {
            // Sync to the pivot table and create a record.
            attach() {
                axios.post(this.route, {
                    'action_id': this.actionId,
                    'server_id': this.server.id
                }).then(() => {
                    console.log('Attach record to the pivot table')
                });
            },

            // Sync to the pivot table and destroy a record.
            detach() {
                axios.delete(`${this.route}/${this.server.id}`, {
                    data: {
                        'action_id': this.actionId
                    }
                })
                    .then(() => {
                        console.log('Detached record from the pivot table')
                    });
            }
        }
    };
</script>

<style lang="scss" scoped>
    label {
        cursor: pointer;
    }
</style>
