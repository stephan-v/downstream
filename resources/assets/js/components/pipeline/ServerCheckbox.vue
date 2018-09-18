<template>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" v-model="checked" :id="server.id">

        <label class="form-check-label" :for="server.id">
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

            pipelineId: {
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

        methods: {
            // Sync to the pivot table and create a record.
            attach() {
                axios.post(window.location.href, {
                    'action_id': this.actionId,
                    'project_id': this.projectId,
                    'server_id': this.server.id
                }).then(() => {
                    console.log('Attach record to the pivot table')
                });
            },

            // Sync to the pivot table and destroy a record.
            detach() {
                axios.delete(`${window.location.href}/${this.actionId}/${this.server.id}`)
                    .then(() => {
                        console.log('Detached record from the pivot table')
                    });
            }
        }
    };
</script>

<style lang="scss" scoped>
    //
</style>
