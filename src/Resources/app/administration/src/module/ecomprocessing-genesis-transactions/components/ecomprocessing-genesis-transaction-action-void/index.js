import template from './ecomprocessing-genesis-transaction-action-void.html.twig';
import {
    APPROVED,
    DECLINED
} from "../ecomprocessing-genesis-transaction-actions/ecomprocessing-genesis-transaction-action-constants";

Shopware.Component.register('ecomprocessing-genesis-transaction-action-void', {
    template,

    inject: [
        'EcomprocessingGenesisTransaction'
    ],

    mixins: [
        'notification'
    ],

    props: {
        actionTransaction: {
            type: Object,
            required: true
        }
    },

    data() {
        return {
            isLoading: false
        };
    },

    computed: {
        modalMessage: function () {
            let translation = this.$tc('ecomprocessing-genesis-transactions.transaction-actions.descriptions.void');
            translation = translation.replace('%amount%', this.actionTransaction.amount);
            translation = translation.replace('%currency%', this.actionTransaction.currency);
            translation = translation.replace('%transaction_type%', this.actionTransaction.transaction_type);
            return translation;
        }
    },

    methods: {
        voidPayment() {
            this.isLoading = true;
            this.EcomprocessingGenesisTransaction
                .doVoid(this.$route.id, this.actionTransaction.unique_id)
                .then((data) => {
                    if (data.status === 'success') {
                        this.parseResponse(data.response);
                    }

                    if (data.status === 'error') {
                        this.createNotificationError({
                            title: this.$tc('ecomprocessing-genesis-transactions.notifications.error-title'),
                            message: this.$tc(
                                'ecomprocessing-genesis-transactions.transaction-actions.messages.void-failure'
                            ) + '</br>' + data.message
                        });
                    }

                    this.isLoading = false;
                    this.closeModal();

                    this.$emit('executed-void-event');
                })
        },

        parseResponse(response) {
            if (response.status === APPROVED) {
                this.createNotificationSuccess({
                    title: this.getSuccessfulResponseTitle(response),
                    message: this.getSuccessfulResponseMessage(response)
                });
            }

            if (response.status !== APPROVED) {
                this.createNotificationInfo({
                    title: this.getSuccessfulResponseTitle(response),
                    message: this.getSuccessfulResponseMessage(response)
                });
            }
        },

        getSuccessfulResponseTitle(response) {
            let title = this.$tc('ecomprocessing-genesis-transactions.notifications.success-title');

            if (!response.hasOwnProperty('status') || response.status !== APPROVED) {
                title = this.$tc('ecomprocessing-genesis-transactions.notifications.error-title');
            }

            return title;
        },

        getSuccessfulResponseMessage(response) {
            let message = '';
            switch (response.status) {
                case APPROVED:
                    message = this.$tc(
                        'ecomprocessing-genesis-transactions.transaction-actions.messages.void-success'
                    ) + '</br>' + ((response.message) ? response.message : '');
                    break;
                case DECLINED:
                    message = this.$tc(
                        'ecomprocessing-genesis-transactions.transaction-actions.messages.void-decline'
                    ) + '</br>' + ((response.message) ? response.message : '');
                    break;
            }

            return message;
        },

        closeModal() {
            this.$emit('modal-close');
        }
    }
});
