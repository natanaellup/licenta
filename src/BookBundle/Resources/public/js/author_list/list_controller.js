(function () {

    var Filter;

    Filter = function (formSelector, freeTextField){

        /**
         * The form element.
         *
         * @type {*|jQuery|HTMLElement}
         */
        this.elementForm = $(formSelector);

        /**
         * The free text field.
         *
         * @type {*|jQuery|HTMLElement}
         */
        this.freeTextField = $(freeTextField);

        this.init();
    };


    Filter.prototype.init = function() {
        var self = this;

        $(document).ready(function(){
            self.store();
        });

        this.elementForm.on('submit', function(event){
            event.preventDefault();
            console.log(self.freeTextField.val());
            self.store();
        });
    };


    Filter.prototype.store = function () {

    };



    var ListController;

    ListController = function (){
        this.filter = new Filter('#form-search','#free-text');
    };

    $(document).ready(function (){
        new ListController();
    });
})();
