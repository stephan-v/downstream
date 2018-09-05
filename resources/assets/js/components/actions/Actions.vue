<template>
    <ul>
        <li v-for="action in actions" @click="save(action)">
            {{ action }}
        </li>
    </ul>
</template>

<script>
    export default {
        data() {
            return {
                actions: [
                    'clean',
                    'clone',
                    'composer',
                    'ssh'
                ]
            };
        },

        methods: {
            save(action) {
                axios.post(`/projects/1/actions/${action}`);
            }
        }
    };
</script>

<style lang="scss" scoped>
    //
</style>
