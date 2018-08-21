<template>
    <div class="pipeline">
        <div class="row">
            <div class="col-lg-6" v-for="action in actions">
                <div class="card" @click="add(action)">
                    <h5>{{ action }}</h5>
                </div><!-- /.card -->
            </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->

        <div class="row">
            <div class="col-lg-12">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center" v-for="action in pipeline">
                        {{ action }}
                    </li><!-- /.list-group-item -->
                </ul><!-- /.list-group -->
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->
    </div><!-- /.pipeline -->
</template>

<script>
    export default {
        data() {
            return {
                actions: [
                    'Git clone',
                    'Composer install',
                    'Activate new release',
                    'Purge old releases',
                    'Custom SSH action'
                ],
                pipeline: []
            }
        },

        methods: {
            add(action) {
                // 0. Compose the actions out of

                // 1. Open a sweetalert modal with action details.

                // 2. Persist to the database.

                this.pipeline.push(action);
            }
        }
    }
</script>

<style lang="scss" scoped>
    .card {
        cursor: pointer;
        padding: 1.5rem;
        box-shadow: 0 0.1875rem 0.375rem rgba(33, 37, 41, 0.05);
        margin-bottom: 1.5rem;

        h5 {
            margin: 0;
        }
    }
</style>
