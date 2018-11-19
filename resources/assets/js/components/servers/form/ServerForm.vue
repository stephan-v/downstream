<template>
    <form @submit.prevent="onSubmit">
        <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label">Name</label>

            <div class="col-sm-9">
                <input type="text"
                       class="form-control"
                       id="name"
                       aria-describedby="name"
                       placeholder="My server"
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

        <button type="submit" class="btn btn-primary">Add server</button>
    </form>
</template>

<script>
    export default {
        data() {
            return {
                name: '',
                ip_address: '',
                user: '',
                path: '',
                status: 0
            };
        },

        props: {
            server: {
                required: false,
                type: Object,
                default: () => {}
            }
        },

        created() {
            Object.assign(this.$data, this.server);
        },

        methods: {
            onSubmit() {
                this.$emit('onSubmit', this.$data);
            }
        }
    }
</script>
