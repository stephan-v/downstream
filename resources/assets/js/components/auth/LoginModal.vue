<template>
    <div class="row">
        <div class="col-md-6 order-md-2 px-0">
            <div class="overlay"></div>
            <img src="https://images.unsplash.com/photo-1511936606692-5e0d73f6b638?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=368644cd897c9865b56508d0334b3cf5&auto=format&fit=crop&w=675&q=80" alt="" class="img-fluid">
        </div><!-- /.col -->

        <div class="col-md-6 order-md-1 align-items-center d-flex flex-column justify-content-center">
            <h3>Login/Register</h3>

            <a href="/login/github" class="btn btn-login w-100 mt-3">
                <i class="fab fa-github mr-3"></i>
                LOGIN WITH GITHUB
            </a>
        </div><!-- /.col -->
    </div><!-- /.login-modal -->
</template>

<script>
    import swal from 'sweetalert';

    export default {
        mounted() {
            this.openModal();
        },

        methods: {
            openModal() {
                swal({
                    content: this.$el,
                    className: 'login-modal',
                    buttons: false
                }).then(() => {
                    this.$emit('close');
                });
            }
        }
    };
</script>

<style lang="scss">
    .login-modal {
        overflow: hidden;

        .swal-content {
            padding: 0;
            margin: 0 15px;

            .btn-login {
                color: #FFF;
                background: #2D3442;
            }
        }

        .overlay {
            width: 100%;
            height: 100%;
            opacity: 0.8;
            display: block;
            position: absolute;
            background: linear-gradient(135deg, #3277E8, #4683EA);
        }
    }

    @media (min-width: 768px) {
        .login-modal {
            width: 768px;
        }
    }
</style>
