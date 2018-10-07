<script>
    import { Sortable } from '@shopify/draggable';

    function move(items, oldIndex, newIndex) {
        const itemRemovedArray = [
            ...items.slice(0, oldIndex),
            ...items.slice(oldIndex + 1, items.length)
        ];

        return [
            ...itemRemovedArray.slice(0, newIndex),
            items[oldIndex],
            ...itemRemovedArray.slice(newIndex, itemRemovedArray.length)
        ];
    }

    export default {
        props: {
            value: {
                required: true
            }
        },

        render() {
            return this.$scopedSlots.default({
                items: this.value
            });
        },

        mounted() {
            new Sortable(this.$el, {
                draggable: '.sortable-item',
                mirror: {
                    constrainDimensions: true
                }
            }).on('sortable:stop', ({ oldIndex, newIndex }) => {
                this.$emit('input', move(this.value, oldIndex, newIndex));
            })
        }
    }
</script>
