<template>
    <form method="POST" @submit.prevent="onSubmit" class="text-left">
        <div class="form-group">
            <label for="name">Action name</label>
            <input type="text" class="form-control" id="name" placeholder="Name" v-model="name">
        </div><!-- /.form-group -->

        <div class="form-group">
            <label for="description">Action description</label>
            <input type="text" class="form-control" id="description" placeholder="Description" v-model="description">
        </div><!-- /.form-group -->

        <div class="form-group">
            <label for="script" class="mb-0">Your custom script</label>

            <small class="form-text text-muted mt-0 mb-1">
                Each command should be on a separate line.
            </small>

            <textarea class="form-control" id="script" rows="6" v-model="script"></textarea>
        </div><!-- /.form-group -->

        <button type="submit" class="btn btn-primary">Save action</button>
    </form>
</template>

<script>
    export default {
        data() {
            return {
                name: '',
                description: '',
                script: ''
            }
        },

        props: {
            action: {
                required: false,
                type: Object,
                default: () => {}
            }
        },

        created() {
            Object.assign(this.$data, this.action);
        },

        methods: {
            onSubmit() {
                this.$emit('onSubmit', this.$data);
            }
        }
    };
</script>
