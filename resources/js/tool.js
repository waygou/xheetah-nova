Nova.booting((Vue, router) => {
    router.addRoutes([
        {
            name: 'xheetah-nova',
            path: '/xheetah-nova',
            component: require('./components/Tool'),
        },
    ])
})
