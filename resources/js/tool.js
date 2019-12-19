Nova.booting((Vue, router) => {
    router.addRoutes([
        {
            name: 'route-viewer',
            path: '/route-viewer',
            component: require('./components/Tool'),
        },
        {
            name: 'route-viewer-admin',
            path: '/route-viewer-admin',
            component: require('./components/ToolAdmin'),
        },
    ])
})
