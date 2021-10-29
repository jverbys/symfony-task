var App = window.App || {};
window.App = App;

App.Bindings = {};
App.modalXhrRequest = false;

App.Core = {
    bindingsHolder: 'bind-js',
    bindingsInit: function(parent, filter) {
        if(filter === true){
            $.each($(parent).filter('[data-' + App.Core.bindingsHolder + ']'), function(){
                App.Core.bindingsElementPublisher($(this));
            });
        } else {
            $.each($(parent).find('[data-' + App.Core.bindingsHolder + ']'), function(){
                App.Core.bindingsElementPublisher($(this));
            });
        }
    },

    bindingsElementPublisher: function ($element) {
        var bindingsList = $element.data(App.Core.bindingsHolder).split(/\s+/);
        $.each( bindingsList, function(index, item){
            if (typeof window['App']['Bindings'][item] !== "undefined") {
                window['App']['Bindings'][item]['run']($element);
            }
        });
        $element.removeAttr('data-'+App.Core.bindingsHolder);
    },

    split: function (val) {
        return val.split( /,\s*/ );
    }
};

$(document).ready(function(){
    var $body = $('body');
    App.Core.bindingsInit($body);
});

$(document).on('hidden.bs.modal', '.modal', function () {
    $('.modal:visible').length && $(document.body).addClass('modal-open');
});

$(document).on('show.bs.modal', '.modal', function (e) {
    var zIndex = 2040 + (10 * $('.modal').length);
    $(this).css('z-index', zIndex);
    setTimeout(function () {
        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
    }, 0);
});
