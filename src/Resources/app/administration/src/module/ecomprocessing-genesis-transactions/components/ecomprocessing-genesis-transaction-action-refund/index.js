import template from './ecomprocessing-genesis-transaction-action-refund.html.twig';
import '../../assets/css/ecomprocessing-genesis-transactions.scss';
import {
    PENDING_ASYNC,
    APPROVED,
    DECLINED
} from '../ecomprocessing-genesis-transaction-actions/ecomprocessing-genesis-transaction-action-constants';

Shopware.Component.register('ecomprocessing-genesis-transaction-action-refund', {
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

    computed: {
        modalMessage: function () {
            let translation = this.$tc('ecomprocessing-genesis-transactions.transaction-actions.descriptions.refund');
            translation = translation.replace('%amount%', this.actionTransaction.amount);
            translation = translation.replace('%currency%', this.actionTransaction.currency);
            translation = translation.replace('%transaction_type%', this.actionTransaction.transaction_type);
            return translation;
        }
    },

    data() {
        return {
            isLoading: false
        };
    },

    methods: {
        refundPayment() {
            this.isLoading = true;

            this.EcomprocessingGenesisTransaction
                .doRefund(this.$route.id, this.actionTransaction.unique_id)
                .then((data) => {
                    if (data.status === 'success') {
                        this.parseResponse(data.response);
                    }

                    if (data.status === 'error') {
                        this.createNotificationError({
                            title: this.$tc('ecomprocessing-genesis-transactions.notifications.error-title'),
                            message: this.$tc(
                                'ecomprocessing-genesis-transactions.transaction-actions.messages.refund-failure'
                            ) + '</br>' + data.message
                        });
                    }

                    this.isLoading = false;
                    this.closeModal();

                    this.$emit('executed-refund-event');
                });
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
            let title = '';
            switch (response.status) {
                case APPROVED:
                case PENDING_ASYNC:
                    title = this.$tc('ecomprocessing-genesis-transactions.notifications.success-title');
                    break;
                default:
                    title = this.$tc('ecomprocessing-genesis-transactions.notifications.error-title');
            }

            return title;
        },

        getSuccessfulResponseMessage(response) {
            let message = '';
            switch (response.status) {
                case PENDING_ASYNC:
                    message = this.$tc(
                        'ecomprocessing-genesis-transactions.transaction-actions.messages.refund-pending'
                    ) + ` ${response.amount} ${response.currency}` +
                        '</br>' + ((response.message) ? response.message : '');
                    break;
                case APPROVED:
                    message = this.$tc(
                        'ecomprocessing-genesis-transactions.transaction-actions.messages.refund-success'
                    ) + ` ${response.amount} ${response.currency}` +
                        '</br>' + ((response.message) ? response.message : '');
                    break;
                case DECLINED:
                    message = this.$tc(
                        'ecomprocessing-genesis-transactions.transaction-actions.messages.refund-decline'
                    ) + '</br>' + ((response.message) ? response.message : '');
                    break;
            }

            return message;
        },

        closeModal() {
            this.$emit('modal-close');
        },
    }
});
