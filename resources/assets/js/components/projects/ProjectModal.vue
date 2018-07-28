<template>
    <form @submit.prevent="onSubmit">
        <h1>Add a project</h1>

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

        <button type="submit" class="btn btn-primary">Save project</button>
    </form>
</template>

<script>
    import swal from 'sweetalert';

    export default {
        data() {
            return {
                name: '',
                repository: ''
            };
        },

        mounted() {
            this.openModal();
        },

        methods: {
            openModal() {
                swal({
                    content: this.$el,
                    buttons: false,
                    className: 'add-project-modal'
                }).then(() => {
                    this.$emit('close');
                });
            },

            onSubmit() {
                // @TODO Show feedback on whether the project was successfully created or not.
                axios.post('/projects', this.$data);
            }
        }
    };
</script>
