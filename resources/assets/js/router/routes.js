import VueRouter from 'vue-router';

import Deployments from './../components/deployment/Deployments.vue';
import Servers from './../components/servers/Servers.vue';

const routes = [
    {
        name: 'deployments',
        path: '/projects/:id',
        component: Deployments
    },
    {
        name: 'servers',
        path: '/projects/:id/servers',
        component: Servers
    },
    // {
    //     path: '/projects/:id/pipeline',
    //     component: Pipeline
    // }
];

export default new VueRouter({
    mode: 'history',

    linkActiveClass: 'active',

    routes
});
