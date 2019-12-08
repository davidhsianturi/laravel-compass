export default [
    // Welcome.
    {
        path: '/',
        component: require('./pages/welcome').default,
    },

    // Cortex.
    {
        path: '/:id',
        name: 'cortex',
        component: require('./pages/cortex').default,
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