<template>
    <div class="add-project">
        <button type="button" class="btn btn-primary" @click="toggle">
            Add project
        </button>

        <project-modal @close="toggle" v-if="visible"></project-modal>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                visible: false
            };
        },

        methods: {
            toggle() {
                this.visible = !this.visible;
            }
        }
    }
</script>

