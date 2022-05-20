define([
    'Magento_Ui/js/grid/columns/thumbnail'
], function (Column) {
    'use strict';

    return Column.extend({

        /**
         * Returns field action handler if it was specified.
         *
         * @param {Object} record - Record object with which action is associated.
         * @returns {Function|Undefined}
         */
        getFieldHandler: function (record) {
            if (this.hasFieldAction()) {
                return this.applyFieldAction.bind(this, record._rowIndex);
            }
        },
    });
});
