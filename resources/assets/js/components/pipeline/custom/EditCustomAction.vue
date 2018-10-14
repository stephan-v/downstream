<template>
    <form method="POST" @submit.prevent="onSubmit" class="text-left">
        <h3>Create custom action</h3>

        <div class="form-group">
            <label for="name">Action name</label>
            <input type="text" class="form-control" id="name" placeholder="Name" v-model="name">
        </div><!-- /.form-group -->

        <div class="form-group">
            <label for="description">Action description</label>
            <input type="text" class="form-control" id="description" placeholder="Description" v-model="description">
        </div><!-- /.form-group -->

        <div class="form-group">
            <label for="script">Your custom script</label>
            <textarea class="form-control" id="script" rows="6" v-model="script"></textarea>
        </div><!-- /.form-group -->

        <button type="submit" class="btn btn-primary">Create custom action</button>
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

        mounted() {
            this.openModal();
        },

        computed: {
            action() {
                return '';
            }
        },

        methods: {
            openModal() {
                swal({
                    content: this.$el,
                    buttons: false,
                    className: 'console-modal'
                }).then(() => {
                    this.$emit('close');
                });
            },

            onSubmit() {
                axios.post(`${window.location.href}/actions`, this.$data)
                    .then(() => {
                        swal({
                            title: 'Success',
                            text: 'Added custom pipeline action',
                            buttons: false,
                            timer: 1000,
                            icon: 'success'
                        }).then(() => {
                            this.$emit('close');
                        });
                    })
                    .catch(error => console.log(error));
            },
        }
    };
</script>

<style lang="scss" scoped>

</style>
