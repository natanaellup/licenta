/**
 * Created by Naty on 9/11/2016.
 */
(function() {

    var Reader;

    Reader = function (readerButton, readerWrapper){

        this.readerButton = $(readerButton);

        this.readerWrapper = $(readerWrapper);

        this.DATA_ADD_URL = '/reader/add';

        this.init();
    };

    Reader.prototype.init = function()
    {
        var self = this;

        self.readerButton.on('click', function (event) {
            self.store();
        });
    };

    Reader.prototype.store = function()
    {
        var self = this;
        var value = new Array();
        value.push({name: 'bookId', value: $('.comment-field').data('book-id')});

        $.ajax({
            url: this.DATA_ADD_URL,
            type: "post",
            data: value,
            success: function (response) {
                self.updateWidget(response.htmlContent)
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    };

    Reader.prototype.updateWidget = function (content){
        this.readerButton.remove();
        this.readerWrapper.empty();
        this.readerWrapper.html(content);
    };

    $(document).ready(function () {
        new Reader('.reader-button-action', '.reader-wrapper');
    });
})();