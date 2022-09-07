import './extension/sw-order-detail/index';
import './page/sw-order-ecomprocessing-genesis-transaction-details';
import './components/index';

Shopware.Module.register('sw-tab-ecomprocessing-genesis-transaction-details', {
    routeMiddleware(next, currentRoute) {
        if (currentRoute.name === 'sw.order.detail') {
            currentRoute.children.push({
                name: 'sw.order.ecomprocessing-genesis-transaction-details',
                path: '/sw/order/ecomprocessing-genesis-transaction/detail/:id',
                isChildren: true,
                component: 'sw-order-ecomprocessing-genesis-transaction-details',
                meta: {
                    parentPath: "sw.order.index"
                }
            });
        }
        next(currentRoute);
    }
});
