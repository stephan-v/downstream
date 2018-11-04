<template>
    <button type="button" class="btn btn-dark" @click="showConfirmationModal">
        <slot></slot>
    </button><!-- /.btn -->
</template>

<script>
    import swal from 'sweetalert';

    export default {
        methods: {
            showConfirmationModal() {
                swal({
                    title: "Are you sure you want to log out?",
                    icon: "warning",
                    buttons: ['Cancel', 'Log out'],
                    dangerMode: true,
                }).then((logoutConfirmed) => {
                        if(logoutConfirmed) {
                            this.confirmLogout()
                        }
                    }
                );
            },

            confirmLogout() {
                axios.post('/logout')
                    .then(() => {
                        this.showLogoutSuccess();
                    })
                    .catch(error => console.log(error.response.data));
            },

            showLogoutSuccess() {
                swal({
                    title: 'Logged out',
                    text: 'See you next time',
                    buttons: false,
                    timer: 2000,
                    icon: 'success'
                }).then(() => {
                    location.reload();
                });
            }
        }
    };
</script>
