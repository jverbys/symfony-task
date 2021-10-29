App.Bindings.daterangePickerInit = {
    run: function ($element) {
        var $startInput = $($element.data('start-input'));
        var $endInput = $($element.data('end-input'));

        var startDate = false;
        var endDate = false;
        if($startInput.val() != '') {
            startDate = moment($startInput.val());
        }

        if($endInput.val() != '') {
            endDate = moment($endInput.val());
        }

        $element.daterangepicker({
            autoApply: true,
            locale: {
                format: 'YYYY-MM-DD'
            },
            startDate: startDate,
            endDate: endDate
        });

        $element.change(function () {
            App.Bindings.daterangePickerInit.changeFilterValue($element, $element.data('daterangepicker'));
        });

        $element.on('apply.daterangepicker', function (ev, picker) {
            App.Bindings.daterangePickerInit.changeFilterValue($element, picker);
        });
    },
    changeFilterValue: function ($element, $datepicker) {
        var $startInput = $($element.data('start-input'));
        var $endInput = $($element.data('end-input'));
        var startDate = $datepicker.startDate;
        var endDate = $datepicker.endDate;
        $startInput.val(startDate.format('YYYY-MM-DD'));
        $endInput.val(endDate.format('YYYY-MM-DD'));
    }
};
