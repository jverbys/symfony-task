App.Bindings.choiceLoadRelatedChoiceData = {
    run: function ($element) {
        $($element).change(function () {
            var $relatedChoice = $($element.data('related-choice'));
            $relatedChoice.val('');
            var $url = $element.data('data-url');
            if ($element.val() != '') {
                $url += '/' + $element.val();
            }
            $.ajax({
                url: $url,
                type: 'GET',
                success: function (json) {
                    $relatedChoice.find('option').remove();
                    $.each(json, function (key, value) {
                        $relatedChoice.append('<option value=' + key + '>' + value + '</option>');
                    });
                }
            });
        });
    }
};
App.Bindings.submitOnSelect = {
    run: function ($element) {
        $($element).change(function () {
            $element.closest('form').submit();
        });
    }
};