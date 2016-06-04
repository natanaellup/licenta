(function () {

    var Comment;

    Comment = function (commentsWrapper, freeTextField) {
        /**
         *
         * @type {*|jQuery|HTMLElement}
         */
        this.commentsWrapper = $(commentsWrapper);

        /**
         *
         * @type {*|jQuery|HTMLElement}
         */
        this.freeTextField = $(freeTextField);

        /**
         * The URL for fetching the campaign list data.
         * Route for Ajax request.
         *
         * @type {string}
         *
         * @constant
         */
        this.DATA_ADD_URL = '/comments/add';

        /**
         * The URL for delete comment.
         *
         * @type {string}
         *
         * @constant
         */
        this.DATA_DELETE_URL = '/comments/delete';

        /**
         *  Call init function.
         */
        this.init();
    };

    /**
     *  Init class.
     */
    Comment.prototype.init = function () {
        var self = this;

        $('.comments-form').on('submit', function (event) {
            event.preventDefault();
            self.store();
        });

        $('.remove-item').on('click', function () {
            console.log($(this).data('comment-id'));
            self.delete($(this));
        });
    };

    /**
     * Make Ajax request and load comments in comments wrapper.
     */
    Comment.prototype.store = function () {
        if (this.freeTextField.val() != "") {
            var self = this;
            var value = new Array();
            value.push({name: 'commentValue', value: this.freeTextField.val()});
            value.push({name: 'bookId', value: this.freeTextField.data('book-id')});

            $.ajax({
                url: this.DATA_ADD_URL,
                type: "post",
                data: value,
                success: function (response) {
                    self.updateWidget(response);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }
    };

    /**
     *
     * @param element
     */
    Comment.prototype.delete = function (element) {
        var value = new Array();
        var self = this;
        value.push({name: 'commentId', value: element.data('comment-id')});

        $.ajax({
            url: this.DATA_DELETE_URL,
            type: "post",
            data: value,
            success: function (response) {
                self.updateWidget(response);
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
    Comment.prototype.updateWidget = function (response) {
        this.commentsWrapper.empty();
        this.commentsWrapper.html(response.htmlContent);
    };

    $(document).ready(function () {
        new Comment('.comments-wrapper', '.comment-field');
    });
})();