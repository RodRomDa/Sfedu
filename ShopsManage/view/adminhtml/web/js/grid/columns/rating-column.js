
define([
    'underscore',
    'Magento_Ui/js/grid/columns/column'
], function (_, Column) {
    'use strict';

    return Column.extend({
        defaults: {
            bodyTmpl: 'Sfedu_ShopsManage/grid/columns/rating',
            maxStars: 8
        },
        /**
         * Retrieves label associated with a provided value.
         *
         * @returns {String}
         */
        getLabel: function (record) {
            return record[this.index];
        },

        getStars: function (record) {
            return +record[this.index];
        },

        getMaxStars: function () {
            return +this.maxStars;
        },

        getPercent: function (record) {
            let percent = this.getStars(record)/this.getMaxStars() * 100;
            return percent + '%';
        },
    });
});
