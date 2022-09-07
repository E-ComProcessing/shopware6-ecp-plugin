import EcomprocessingGenesisUtils from '../services/ecomprocessing-genesis-utils.service';

const { Application } = Shopware;
const initContainer = Application.getContainer('init');

Application.addServiceProvider(
    'EcomprocessingGenesisUtils',
    (container) =>
        new EcomprocessingGenesisUtils(initContainer.httpClient, container.loginService)
);
