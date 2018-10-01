<template>
    <section class="pipeline-options">
        <h3 class="mb-3">Available pre-defined actions</h3>

        <div class="card-deck">
            <div class="card text-center mb-3" v-for="action in actions">
                <div class="card-body d-flex flex-column">
                    <div class="svg-icon inline large mb-3">
                        <svg-inline :name="action.icon" class="large"></svg-inline>
                    </div><!-- /.svg-icon -->

                    <h5 class="card-title">{{ action.name }}</h5>
                    <p class="card-text">{{ action.description }}</p>

                    <add-to-pipeline :action-id="action.id"></add-to-pipeline>
                </div><!-- /.card-body -->
            </div><!-- /.card -->

            <div class="card text-center mb-3">
                <div class="card-body d-flex flex-column">
                    <div class="svg-icon inline large mb-3">
                        <svg-inline name="energy" class="large"></svg-inline>
                    </div><!-- /.svg-icon -->

                    <h5 class="card-title">Custom action</h5>
                    <p class="card-text">Create your own defined action</p>

                    <button type="button" class="btn btn-primary mt-auto">Add to pipeline</button>
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.row -->
    </section><!-- /.pipeline-options -->
</template>

<script>
    export default {
        props: {
            actions: {
                required: true,
                type: Array
            }
        }
    }
</script>
