<template>
    <form @submit.prevent="onSubmit">
        <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label">Name</label>

            <div class="col-sm-9">
                <input type="text"
                       class="form-control"
                       id="name"
                       aria-describedby="name"
                       placeholder="My project"
                       v-model="name">
            </div><!-- /.col-sm-* -->
        </div><!-- /.form-group -->

        <div class="form-group row">
            <label for="repository" class="col-sm-3 col-form-label">Repository</label>

            <div class="col-sm-9">
                <input type="text"
                       class="form-control"
                       id="repository"
                       aria-describedby="repository"
                       placeholder="user/repository"
                       v-model="repository">
            </div><!-- /.col-sm-* -->
        </div><!-- /.form-group -->

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">Save project</button>
        </div><!-- /.text-center -->
    </form>
</template>

<script>
    export default {
        data() {
            return {
                name: '',
                repository: ''
            };
        },

        props: {
            project: {
                required: false,
                type: Object,
                default: () => {}
            }
        },

        created() {
            Object.assign(this.$data, this.project);
        },

        methods: {
            onSubmit() {
                this.$emit('onSubmit', this.$data);
            }
        }
    }
</script>
