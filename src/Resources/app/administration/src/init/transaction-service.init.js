import EcomprocessingGenesisTransaction from '../services/ecomprocessing-genesis-transaction.service';

const { Application } = Shopware;
const initContainer = Application.getContainer('init');

Application.addServiceProvider(
    'EcomprocessingGenesisTransaction',
    (container) =>
    new EcomprocessingGenesisTransaction(initContainer.httpClient, container.loginService)
);
