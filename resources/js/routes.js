export default [
    // Welcome.
    {
        path: '/',
        component: require('./pages/welcome').default,
    },

    // Request.
    {
        path: '/:id',
        name: 'request',
        component: require('./pages/request').default,
    },

    // Response.
    {
        path: '/eg/:id',
        name: 'response',
        component: require('./pages/response').default,
    },

    // Catch all.
    {
        path: '*',
        name: 'catch-all',
        component: require('./pages/404').default,
    },
];