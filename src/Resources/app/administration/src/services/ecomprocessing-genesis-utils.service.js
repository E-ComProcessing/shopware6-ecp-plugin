const ApiService = Shopware.Classes.ApiService;

class EcomprocessingGenesisUtils extends ApiService
{
    constructor(httpClient, loginService, apiEndpoint = 'ecomprocessing-v1') {
        super(httpClient, loginService, apiEndpoint)
    }

    convertAmountToExponent(amount, currency) {
        const apiRoute = `${this.getApiBasePath()}/genesis/utils/convert-amount-exponent/${amount}/${currency}`;

        return this.httpClient.get(
            apiRoute,
            this.getDefaultOptions()
        ).then((response) => {
            return ApiService.handleResponse(response)
        })
    }

    getDefaultOptions() {
        return {
            headers: this.getBasicHeaders(),
            version: Shopware.Context.api.apiVersion
        };
    }
}
export default EcomprocessingGenesisUtils;
