import template from './sw-settings-usage-data-general.html.twig';

/**
 * @sw-package data-services
 *
 * @private
 */
export default HeyFrame.Component.wrapComponentConfig({
    name: 'sw-settings-usage-data-general',

    template,

    inject: [
        'usageDataService',
    ],

    methods: {
        async createdComponent() {
            const consent = await this.usageDataService.getConsent();

            HeyFrame.Store.get('usageData').updateConsent(consent);
        },
    },

    created() {
        void this.createdComponent();
    },
});
