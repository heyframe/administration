import './acl';

/**
 * @sw-package checkout
 */

/* eslint-disable max-len, sw-deprecation-rules/private-feature-declarations */
HeyFrame.Component.register('sw-settings-tax-list', () => import('./page/sw-settings-tax-list'));
HeyFrame.Component.register('sw-settings-tax-detail', () => import('./page/sw-settings-tax-detail'));
HeyFrame.Component.register('sw-settings-tax-provider-detail', () => import('./page/sw-settings-tax-provider-detail'));
HeyFrame.Component.register(
    'sw-settings-tax-provider-sorting-modal',
    () => import('./component/sw-settings-tax-provider-sorting-modal'),
);
HeyFrame.Component.register('sw-tax-rule-card', () => import('./component/sw-tax-rule-card'));
HeyFrame.Component.register('sw-settings-tax-rule-modal', () => import('./component/sw-settings-tax-rule-modal'));
HeyFrame.Component.register(
    'sw-settings-tax-rule-type-individual-states',
    () => import('./component/sw-settings-tax-rule-type-individual-states'),
);
HeyFrame.Component.register(
    'sw-settings-tax-rule-type-zip-code',
    () => import('./component/sw-settings-tax-rule-type-zip-code'),
);
HeyFrame.Component.register(
    'sw-settings-tax-rule-type-zip-code-range',
    () => import('./component/sw-settings-tax-rule-type-zip-code-range'),
);
HeyFrame.Component.register(
    'sw-settings-tax-rule-type-individual-states-cell',
    () => import('./component/sw-settings-tax-rule-type-individual-states-cell'),
);
HeyFrame.Component.register(
    'sw-settings-tax-rule-type-zip-code-cell',
    () => import('./component/sw-settings-tax-rule-type-zip-code-cell'),
);
HeyFrame.Component.register(
    'sw-settings-tax-rule-type-zip-code-range-cell',
    () => import('./component/sw-settings-tax-rule-type-zip-code-range-cell'),
);
/* eslint-enable max-len, sw-deprecation-rules/private-feature-declarations */

const { Module } = HeyFrame;

// eslint-disable-next-line sw-deprecation-rules/private-feature-declarations
Module.register('sw-settings-tax', {
    type: 'core',
    name: 'settings-tax',
    title: 'sw-settings-tax.general.mainMenuItemGeneral',
    description: 'Tax section in the settings module',
    color: '#9AA8B5',
    icon: 'regular-cog',
    favicon: 'icon-module-settings.png',
    entity: 'tax',

    routes: {
        index: {
            component: 'sw-settings-tax-list',
            path: 'index',
            meta: {
                parentPath: 'sw.settings.index',
                privilege: 'tax.viewer',
            },
        },
        detail: {
            component: 'sw-settings-tax-detail',
            path: 'detail/:id',
            meta: {
                parentPath: 'sw.settings.tax.index',
                privilege: 'tax.viewer',
            },
            props: {
                default(route) {
                    return {
                        taxId: route.params.id.toLowerCase(),
                    };
                },
            },
        },
        create: {
            component: 'sw-settings-tax-detail',
            path: 'create',
            meta: {
                parentPath: 'sw.settings.tax.index',
                privilege: 'tax.creator',
            },
        },
        'tax_provider.detail': {
            component: 'sw-settings-tax-provider-detail',
            path: 'tax-provider/detail/:id',
            meta: {
                parentPath: 'sw.settings.tax.index',
                privilege: 'tax.viewer',
            },
            props: {
                default(route) {
                    return {
                        taxProviderId: route.params.id.toLowerCase(),
                    };
                },
            },
        },
    },

    settingsItem: {
        group: 'localization',
        to: 'sw.settings.tax.index',
        icon: 'regular-chart-pie',
        privilege: 'tax.viewer',
    },
});
