/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'jquery',
    'mage/mage'
], function ($) {
    'use strict';

    return function (config, element) {
        $(element).mage('validation', {
            /** @inheritdoc */
            errorPlacement: function (error, el) {

                if (el.parents('#shop-review-table').length) {
                    $('#shop-review-table').siblings(this.errorElement + '.' + this.errorClass).remove();
                    $('#shop-review-table').after(error);
                } else {
                    el.after(error);
                }
            }
        });
    };
});
