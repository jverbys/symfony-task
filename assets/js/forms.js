App.Bindings.showModal = {
    run: function ($element) {
        var $url = $element.data('modal-url');
        $element.click(function (e) {
            e.preventDefault();
            e.stopPropagation();
            if (App.modalXhrRequest) {
                App.modalXhrRequest.abort();
                App.modalXhrRequest = false;
            }
            App.modalXhrRequest = App.Bindings.showModal.loadModalWindow($url);
        });
    },
    loadModalWindow: function ($url) {
        return $.ajax({
            url: $url,
            data: [],
            method: 'GET',
            cache: false
        }).done(function ($data) {
            if ($('.modal').length === 0) {
                App.Bindings.showModal.showModalWindow($data);
            } else {
                $('.modal').last().on('hidden.bs.modal', function () {
                    App.Bindings.showModal.showModalWindow($data);
                });
                $('.modal').last().modal('toggle');
            }
        });
    },
    showModalWindow: function ($content) {
        var $modalDiv = $('<div/>').addClass('modal').addClass('fade').attr('tabindex', '-1');
        var $modal = $($content);
        $modalDiv.append($modal);
        $('body').append($modalDiv);
        $modalDiv.modal({backdrop: 'static'});
        $modalDiv.on('hidden.bs.modal', function () {
            $modalDiv.remove();
            $('.modal').last().focus();
        });

        $modalDiv.on('shown.bs.modal', function () {
            App.Core.bindingsInit($modal);
        });
    }
};

App.Bindings.modalForm = {
    run: function ($element) {
        var $url = $element.attr('action');
        var $modal = $element.closest('.modal');
        var $initFormData = $element.serialize();

        $element.submit(function (e) {
            e.preventDefault();

            if ($modal.length == 0) {
                $modal = $('body');
            }

            App.Bindings.doFormSubmit.run($modal, $element, $url);

            return false;
        });

        $element.change(function () {
            if ($element.data('modal-form-extra-error-alert')) {
                if ($initFormData != $(this).serialize()) {
                    var $errorWrap = $element.find('.extra-error-wrap');
                    if ($errorWrap) {
                        $element.data('modal-form-extra-error-alert', null);
                        $element.data('modal-form-extra-errors', null);
                        $errorWrap.remove();
                    }
                }
            }
        });
    },
    redirect: function () {
        location.reload();
    }
};

App.Bindings.doFormSubmit = {
    run: function ($modal, $element, $url) {
        var data = new FormData($element[0]);
        var $request = $.ajax({
            method: 'POST',
            url: $url,
            contentType: false,
            processData: false,
            data: data
        }).fail(function ($data) {
            $modal.html($($data.responseText));
        }).always(function () {
            App.Core.bindingsInit($modal);
        }).done(function () {
            $modal.modal('toggle');
            $modal.on('hidden.bs.modal', function () {
                App.Bindings.doFormSubmit.showSuccessAlert($element);
            });
        });

        App.Bindings.doFormSubmit.addLoader($modal);
        return $request;
    },
    addLoader: function ($modal) {
        var loader =
            '<div class="sk-spinner sk-spinner-three-bounce">' +
            '<div class="sk-bounce1"></div>' +
            '<div class="sk-bounce2"></div>' +
            '<div class="sk-bounce3"></div>' +
            '</div>';

        var $modalBody = $modal.find('.modal-body');
        var $modalFooter = $modal.find('.modal-footer');

        $modalFooter.remove();
        $modalBody.html(loader);
    },
    showSuccessAlert: function ($element) {
        var $successAlertTitle = $element.data('modal-form-success-alert-title');
        var $closeBtnTxt = $element.data('alert-close-btn');
        swal({
                title: $successAlertTitle,
                text: '',
                type: "success",
                allowEscapeKey: false,
                confirmButtonText: $closeBtnTxt
            },
            function () {
                App.Bindings.modalForm.redirect();
            }
        );
    }
};

App.Bindings.posPlaceServiceEmbedForm = {
    run: function ($element) {
        var $addNewButton = $('' +
            '<a href="#" class="btn btn-info break-btn btn-sm">' +
            '<i class="fa fa-plus" aria-hidden="true"></i> ' +
            '</a>');

        $element.find('.table-actions').append($addNewButton);
        var $itemsCount = $element.find('.pos-service-form').length;
        $element.data('index', $itemsCount);

        if ($itemsCount === 0) {
            App.Bindings.posPlaceServiceEmbedForm.addForm($element);
        }

        $addNewButton.on('click', function (e) {
            e.preventDefault();
            App.Bindings.posPlaceServiceEmbedForm.addForm($element);
        });
    },
    addForm: function ($element) {
        var servicePrototype = $element.data('prototype-service');
        var priorityPrototype = $element.data('prototype-priority');
        var index = $element.data('index');

        var serviceField = servicePrototype.replace(/__service_prot__/g, index);
        var priorityField = priorityPrototype.replace(/__service_prot__/g, index);
        $element.data('index', index + 1);

        var $newForm = $('<tr class="pos-service-form embeded-form">' +
            '<td class="p-l-0">'+ serviceField +'</td>' +
            '<td class="width-120">'+ priorityField +'</td>' +
            '<td class="form-actions width-120 p-r-0"></td>' +
            '</tr>'
        );
        $element.append($newForm);
        App.Bindings.posPlaceServiceEmbedForm.addFormDeleteLink($newForm, $element);
    },
    addFormDeleteLink: function ($form, $element) {
        var $removeButton = $(
            '<button class="btn btn-danger btn-sm">' +
                '<i class="fa fa-times"></i>' +
            '</button>');

        $form.find('.form-actions').append($removeButton);

        $removeButton.on('click', function (e) {
            e.preventDefault();
            $form.remove();
            App.Bindings.posPlaceServiceEmbedForm.renumberBlocks($element);
        });
    },
    getFormWrapper: function (prototype, posPlaceIndex, $element) {
        var formWrapper = $('<div data-bind-js="posPlaceServiceEmbedForm"></div>');
        formWrapper.data('prototype', prototype);
        formWrapper.data('pos-place-index', posPlaceIndex);
        formWrapper.data('add-new-btn-txt', $element.data('place-service-btn-txt'));
        formWrapper.data('label-txt', $element.data('place-service-label-txt'));

        return formWrapper;
    },
    renumberBlocks: function ($element) {
        $element.find('.embeded-form').each(function (index) {
            var prefix = "placeServices[" + index + "]";
            $(this).find("input, select").each(function () {
                this.name = this.name.replace(/placeServices\[\d+\]/, prefix);
            });
        });
    }
};

App.Bindings.removeEmbededForm = {
    run: function ($element) {
        $element.click(function (e) {
            e.preventDefault();
            $element.parent().parent().remove();
        })
    }
};
