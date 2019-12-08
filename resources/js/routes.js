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

    // Example.
    {
        path: '/eg/:id',
        name: 'example',
        component: require('./pages/example').default,
    },

    // Catch all.
    {
        path: '*',
        name: 'catch-all',
        component: require('./pages/404').default,
    },
];