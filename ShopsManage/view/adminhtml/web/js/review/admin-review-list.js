define([
    'Sfedu_ShopsManage/js/review/review-list',
    'jquery'
], function(ReviewList, $) {
    return ReviewList.extend({

        getApproveHandler: function (review) {
            return this.setApproved.bind(this, review.id, review.is_approved);
        },

        setApproved: function (reviewId, approved) {
            if(!this.isLoading()) {
                this.isLoading(true);
                $.ajax({
                    url: [this.config.approveUrl, reviewId, Number(approved)].join("/"),
                    type: 'put',
                    dataType: 'json',
                    contentType: 'application/json',
                    headers: {
                        'Authorization': 'Bearer ' + this.config.token,
                    },
                    showLoader: true,
                    loaderContext: $('#reviews'),
                    beforeSend: function(xhr){
                        //Empty to remove magento's default handler
                    }
                }).done((data) => {
                    console.log(data);
                    this.isLoading(false);
                })
            }
        },

    });
});
