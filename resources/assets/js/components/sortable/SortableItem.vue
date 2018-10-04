<script>
    export default {
        props: [],

        render() {
            return this.$slots.default[0];
        },

        mounted() {
            this.$el.classList.add('sortable-item');
        }
    }
</script>

<style lang="scss" scoped>
    .sortable-item {
        cursor: move;
    }

    .draggable--over {
        border: 2px dashed #c3d8e6;

        * {
            visibility: hidden;
        }
    }
</style>
