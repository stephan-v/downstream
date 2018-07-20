
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',

    methods: {
        deploy() {
            axios.post('/deploy');
        },

        // Create a seperate component for the connection status with a spinner and a red light which turns green
        // When this SSH connection test is successful.
        getConnectionStatus() {
            axios.post('/connection').then((response) => {
                console.log(response)
            }).catch((response) => {
                console.log(response);
            });
        }
    }
});
