(function () {

    var Like;

    Like = function (likeButton, likeWrapper) {
        /**
         *
         * @type {*|jQuery|HTMLElement}
         */
        this.likeButton = $(likeButton);

        /**
         * @type {*|jQuery|HTMLElement}
         */
        this.likeWrapper = $(likeWrapper);

        /**
         * The URL for fetching the campaign list data.
         * Route for Ajax request.
         *
         * @type {string}
         *
         * @constant
         */
        this.DATA_ADD_URL = '/likes/add';

        /**
         * The URL for delete comment.
         *
         * @type {string}
         *
         * @constant
         */
        this.DATA_DELETE_URL = '/likes/delete';

        /**
         *  Call init function.
         */
        this.init();
    };

    /**
     *  Init class.
     */
    Like.prototype.init = function () {
        var self = this;

        self.likeButton.on('click', function (event) {
            if(self.likeButton.hasClass('like-button')){
                self.store();
            }else{
                self.delete();
            }
        });

        $('.remove-item').on('click', function () {
            console.log($(this).data('comment-id'));
            self.delete($(this));
        });
    };

    /**
     * Make Ajax request and load comments in comments wrapper.
     */
    Like.prototype.store = function () {

            var self = this;
            var value = new Array();
            value.push({name: 'bookId', value: $('.comment-field').data('book-id')});

            $.ajax({
                url: this.DATA_ADD_URL,
                type: "post",
                data: value,
                success: function (response) {
                    self.changeLikeButton();
                    self.updateWidget(response.htmlContent)
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
    };

    Like.prototype.changeLikeButton = function() {
        this.likeButton.empty();
        if(this.likeButton.hasClass('like-button')){
            this.likeButton.removeClass('like-button');
            this.likeButton.addClass('unlike-button');
            this.likeButton.html('Unlike');
        }else{
            this.likeButton.removeClass('unlike-button');
            this.likeButton.addClass('like-button');
            this.likeButton.html('Like');
        }
    };

    /**
     *
     * @param element
     */
    Like.prototype.delete = function (element) {
        var value = new Array();
        var self = this;
        value.push({name: 'bookId', value: $('.comment-field').data('book-id')});

        $.ajax({
            url: this.DATA_DELETE_URL,
            type: "post",
            data: value,
            success: function (response) {
                self.changeLikeButton();
                self.updateWidget(response.htmlContent);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    };

    /**
     * Update comments widget.
     *
     * @param response
     */
    Like.prototype.updateWidget = function (htmlContent) {
        this.likeWrapper.empty();
        this.likeWrapper.html(htmlContent);
    };

    $(document).ready(function () {
        new Like('.like-button-action', '.like-wrapper');
    });
})();