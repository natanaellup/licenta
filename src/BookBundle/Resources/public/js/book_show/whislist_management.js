(function() {

    var Whislist;

    Whislist = function (whislistButton, whislistWrapper){

        this.whislistButton = $(whislistButton);

        this.whislistWrapper = $(whislistWrapper);

        this.DATA_ADD_URL = '/whislist/add';

        this.init();
    };

    Whislist.prototype.init = function()
    {
        var self = this;

        self.whislistButton.on('click', function (event) {
            self.store();
        });
    };

    Whislist.prototype.store = function()
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

    Whislist.prototype.updateWidget = function (content){
        this.whislistButton.remove();
        this.whislistWrapper.empty();
        this.whislistWrapper.html(content);
    };

    $(document).ready(function () {
        new Whislist('.whislist-button-action', '.whislist-wrapper');
    });
})();
