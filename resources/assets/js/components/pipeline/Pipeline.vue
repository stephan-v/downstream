<template>
    <div class="pipeline">
        <div class="row">
            <div class="col-lg-6" v-for="action in actions">
                <div class="card" @click="add(action)">
                    <h5>{{ action.name }}</h5>
                </div><!-- /.card -->
            </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->

        <div class="row">
            <div class="col-lg-12">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center" v-for="action in pipeline">
                        {{ action.name }}
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
                    {
                        fqcn: 'CloneRepository',
                        name: 'Git clone',
                    },
                    {
                        fqcn: 'ComposerInstall',
                        name: 'Composer install'
                    },
                    {
                        fqcn: 'CleanOldReleases',
                        name: 'Clean old releases'
                    },
                    {
                        fqcn: 'CustomSSH',
                        name: 'Custom SSH action'
                    }
                ],
                pipeline: []
            }
        },

        methods: {
            add(action) {
                axios.post('/actions', {
                    name: action.name,
                    fqcn: action.fqcn
                })
                    .then(() => {
                        this.pipeline.push(action);

                        swal({
                            title: 'Success!',
                            text: 'Action added',
                            icon: 'success',
                            buttons: false,
                            timer: 1500
                        })
                    }).catch(() => {
                        swal({
                            title: 'Oops',
                            text: 'Action could not be added',
                            icon: 'error',
                            buttons: false,
                            timer: 1500
                        })
                    });
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
