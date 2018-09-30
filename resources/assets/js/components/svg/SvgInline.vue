<template>
    <div :class="classes" v-html="svg"></div>
</template>

<script>
    export default {
        data() {
            return {
                svg: ''
            };
        },

        props: {
            name: {
                type: String,
                required: true
            },
            inline: {
                type: Boolean,
                default: true
            }
        },

        created() {
            if (this.name.indexOf('.svg') > -1) {
                throw new TypeError(`Do not use the .svg extension for: ${this.name}`);
            }

            this.svg = require(`public/images/svg/${this.name}.svg`);
        },

        computed: {
            classes() {
                const inline = this.inline ? 'inline' : '';
                const name = this.name.slice(this.name.lastIndexOf('/') + 1);

                return `svg-icon svg-${name} ${inline}`;
            }
        }
    };
</script>
