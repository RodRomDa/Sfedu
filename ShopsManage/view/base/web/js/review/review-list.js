define([
    'uiComponent',
    'ko',
    'jquery',
    'mageUtils',
    'moment',
    'moment-timezone-with-data'
], function(Component, ko, $, utils, moment) {
    return Component.extend({
        defaults: {
            dateFormat: 'd MMMM, YYYY, H:mm',
        },
        page: ko.observable(0),
        pageSize: ko.observable(1),
        items: ko.observable([]),
        isLoading: ko.observable(false),
        fetchedItems: [],
        totalRecords: ko.observable(1),
        totalPages: 0,

        initialize: function (config) {
            this._super();
            ko.subscribable.fn.subscribeChanged = function (callback, callbackTarget) {
                var oldValue;
                this.subscribe(function (_oldValue) {
                    oldValue = _oldValue;
                }, this, "beforeChange");
                return this.subscribe(function (newValue) {
                    callback.bind(callbackTarget)(newValue, oldValue);
                });
            }
            this.config = config;
            this.dateFormat = utils.normalizeDate(this.dateFormat);
            this.page.subscribeChanged(this._validatePage, this);
            this.page.subscribe(this._setPage, this);
            this.totalPages = ko.computed(() => Math.ceil(this.totalRecords() / this.pageSize()));
            this.pageSize.subscribe((val) => {this.page(1); this._setPage(1)}, this);
            this.pageSize.subscribeChanged(this._validatePageSize, this);
            this.pageSize(config.defaultPageSize);
        },

        loadItems: function (pageIndex, pageSize) {
            if(!this.isLoading()) {
                this.isLoading(true);
                $.ajax({
                    url: [this.config.fetchUrl, this.config.scopeId, pageIndex, pageSize].join("/"),
                    type: 'get',
                    dataType: 'json',
                    contentType: 'application/json',
                    headers: {
                        'Authorization': 'Bearer ' + this.config.token,
                    },
                    showLoader: true,
                    loaderContext: $('#reviews'),
                }).done((data) => {
                    this.fetchedItems.splice(this.getIndex(pageIndex), data.reviews.length, ...data.reviews);
                    this.totalRecords(data.count);
                    this.isLoading(false);
                    this._setPage(pageIndex);
                })
            }
        },

        isValidPage(page) {
            return Number.isInteger(page)&&(page >= 1)&&(page <= this.totalPages());
        },

        _validatePage: function (pageNew, pageOld) {
            let page = Number(pageNew);
            if(this.isValidPage(page)) {
                this.page(page);
            } else this.page(pageOld);
        },

        _validatePageSize: function (pageSizeNew, pageSizeOld) {
            let page = Number(pageSizeNew);
            if(Number.isInteger(page)&&(page > 0)) {
                this.pageSize(page);
            } else this.pageSize(pageSizeOld);
        },

        _setPage: function (page) {
            if(this.isValidPage(page)) {
                let pageSize = this.pageSize();
                let index = this.getIndex(page);

                //Check that items are loaded
                for(let i = index; (i<pageSize+index)&&(i<this.totalRecords()); i++) {
                    if(!(i in this.fetchedItems)) {
                        this.loadItems(page, pageSize);
                    }
                }

                if(!this.isLoading()) {
                    this.items(this.fetchedItems.slice(this.getIndex(page), this.getIndex(page+1)));
                }
            }
        },

        onNext: function () {
            this.page(this.page() + 1);
        },

        onPrev: function () {
            this.page(this.page() - 1);
        },

        //Helper functions
        getPercent: function (rating, maxRating) {
            let percent = rating/maxRating * 100;
            return percent+"%";
        },

        getIndex: function (pageIndex) {
            return (Number(pageIndex)-1)*this.pageSize();
        },

        formatDate: function (date) {
            moment.locale(this.config.storeLocale, this.config.calendarConfig);
            date = moment.utc(date);
            date = date.tz(this.config.storeTimezone);
            date = date.isValid() ? date.format(this.dateFormat) : '';
            return date;
        },
    });
});

