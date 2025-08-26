/**
 * @sw-package data-services
 *
 * @private
 */
export default function initUsageData(): Promise<void> {
    return new Promise<void>((resolve) => {
        const loginService = HeyFrame.Service('loginService');
        const usageDataApiService = HeyFrame.Service('usageDataService');

        if (!loginService.isLoggedIn()) {
            HeyFrame.Store.get('usageData').resetConsent();

            resolve();

            return;
        }

        usageDataApiService
            .getConsent()
            .then((usageData) => {
                HeyFrame.Store.get('usageData').updateConsent(usageData);
            })
            .catch(() => {
                HeyFrame.Store.get('usageData').resetConsent();
            })
            .finally(() => {
                resolve();
            });
    });
}
