<template>
    <div class="add-server">
        <button type="button" class="btn btn-sm btn-primary" @click="toggle">
            <i class="fas fa-edit"></i>
            Edit server
        </button>

        <edit-server-modal @close="toggle" v-if="visible" :server="server"></edit-server-modal>
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
            toggle() {
                this.visible = !this.visible;
            }
        }
    }
</script>
