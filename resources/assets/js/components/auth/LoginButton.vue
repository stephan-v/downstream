<template>
    <div class="login-button">
        <button type="button" class="btn btn-dark" @click="toggle">
            <slot></slot>
        </button><!-- .btn -->

        <login-modal v-if="visible" @close="toggle"></login-modal>
    </div><!-- /.login-button -->
</template>

<script>
    export default {
        data() {
            return {
                visible: false
            }
        },

        methods: {
            toggle() {
                this.visible = !this.visible;
            }
        }
    };
</script>
