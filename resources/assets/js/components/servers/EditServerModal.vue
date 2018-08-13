<template>
    <form @submit.prevent="onSubmit">
        <h1>Edit server</h1>

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
            <label for="ip-address" class="col-sm-3 col-form-label">IP Address</label>

            <div class="col-sm-9">
                <input type="text"
                       class="form-control"
                       id="ip-address"
                       aria-describedby="ip-address"
                       placeholder="IP Address"
                       v-model="ip_address">
            </div><!-- /.col-sm-* -->
        </div><!-- /.form-group -->

        <div class="form-group row">
            <label for="user" class="col-sm-3 col-form-label">Connect as</label>

            <div class="col-sm-9">
                <input type="text"
                       class="form-control"
                       id="user"
                       aria-describedby="user"
                       placeholder="User"
                       v-model="user">
            </div><!-- /.col-sm-* -->
        </div><!-- /.form-group -->

        <div class="form-group row">
            <label for="path" class="col-sm-3 col-form-label">Project Path</label>

            <div class="col-sm-9">
                <input type="text"
                       class="form-control"
                       id="path"
                       aria-describedby="path"
                       placeholder="/home/forge/app.com"
                       v-model="path">
            </div><!-- /.col-sm-* -->
        </div><!-- /.form-group -->

        <button type="submit" class="btn btn-primary">Edit server</button>
    </form>
</template>

<script>
    import swal from 'sweetalert';

    export default {
        data() {
            return {
                name: '',
                ip_address: '',
                user: '',
                path: ''
            };
        },

        props: {
            server: {
                required: true,
                type: Object
            }
        },

        created() {
            this.name = this.server.name;
            this.ip_address = this.server.ip_address;
            this.user = this.server.user;
            this.path = this.server.path;
        },

        mounted() {
            this.openModal();
        },

        methods: {
            openModal() {
                swal({
                    content: this.$el,
                    buttons: false,
                    className: 'edit-server-modal'
                }).then(() => {
                    this.$emit('close');
                });
            },

            onSubmit() {
                axios.patch(`/servers/${this.server.id}`, {
                    ...this.$data,
                    project_id: this.server.project_id
                }).then(() => {
                    swal({
                        title: 'Success!',
                        text: 'Server settings updated',
                        icon: 'success',
                        buttons: false,
                        timer: 1500
                    })
                }).catch(() => {
                    swal({
                        title: 'Oops',
                        text: 'Server settings could not be updated',
                        icon: 'error',
                        buttons: false,
                        timer: 1500
                    })
                });
            }
        }
    };
</script>
