<template>
    <div class="login-button">
        <a href="#" @click.prevent="toggle">
            <span class="text">LOG IN</span>

            <span class="circle-wrapper">
                <i class="far fa-user"></i>
            </span><!-- /.circle-wrapper -->
        </a>

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

<style lang="scss" scoped>
    $color: #225a9c;

    a:hover {
        text-decoration: none;

        .text {
            color: #c5dfff;
        }
    }

    .circle-wrapper {
        border: 2px solid $color;
        display: inline-block;
        margin: 0 0 0 .5rem;
        border-radius: 50%;
        padding: .5rem;

        .far {
            background: $color;
            border-radius: 50%;
            padding: 8px 9px;
        }
    }
</style>
