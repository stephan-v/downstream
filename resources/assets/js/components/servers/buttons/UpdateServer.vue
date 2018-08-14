<template>
    <div class="add-server">
        <button type="button" class="btn btn-sm btn-primary" @click="toggle">
            <i class="fas fa-edit"></i>
            Edit server
        </button>

        <update-server-modal @close="toggle" @update="update" v-if="visible" :server="server"></update-server-modal>
    </div><!-- /.add-server -->
</template>

<script>
    export default {
        data() {
            return {
                visible: false
            };
        },

        props: {
            server: {
                required: true,
                type: Object
            }
        },

        methods: {
            update(id) {
                this.$emit('update', id);
            },

            toggle() {
                this.visible = !this.visible;
            }
        }
    }
</script>
