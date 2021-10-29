App.Bindings.displayAlert = {
    run: function ($element) {
        var $message = $element.data('alert-message');
        var $title = $element.data('alert-title');
        var $type = $element.data('alert-type');
        swal({
                title: $title,
                text: $message,
                type: $type,
                allowEscapeKey: true
            }
        );
    }
};
App.Bindings.sendRequestWithAlert = {
    run: function ($element) {
        $element.click(function (e) {
            e.preventDefault();
            var $message = $element.data('alert-message');
            var $title = $element.data('alert-title');
            var $confirmBtnTxt = $element.data('alert-confirm-btn');
            var $cancelBtnText = $element.data('alert-cancel-btn');

            swal({
                title: $title,
                text: $message,
                confirmButtonText: $confirmBtnTxt,
                cancelButtonText: $cancelBtnText,
                allowEscapeKey: true,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                closeOnConfirm: false,
                html: true
            }, function () {
                App.Bindings.sendRequestWithAlert.makeRequest($element);
            });

            return false;
        });
    },
    makeRequest: function ($element) {
        var $successMessage = $element.data('alert-message-success');
        var $successTitle = $element.data('alert-title-success');
        var $errorTitle = $element.data('alert-title-error');
        var $closeBtnTxt = $element.data('alert-close-btn');

        $request = $.ajax({
            method: 'GET',
            url: $element.attr('href'),
            data: $element.serialize()
        }).fail(function ($data) {
            var $errorText = $data.responseJSON.errors.join('<br>');
            swal({
                    title: $errorTitle,
                    text: $errorText,
                    type: "error",
                    allowEscapeKey: false,
                    closeOnConfirm: true,
                    confirmButtonText: $closeBtnTxt
                }
            );
        }).done(function () {
            swal({
                    title: $successTitle,
                    text: $successMessage,
                    type: "success",
                    allowEscapeKey: false,
                    closeOnConfirm: true,
                    confirmButtonText: $closeBtnTxt
                },
                function () {
                    App.Bindings.modalForm.redirect();
                }
            );
            return false;
        });
    }
};