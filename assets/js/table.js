App.Bindings.fixFirstColumn = {
    run: function ($element) {
        if($(window).width() > 500) {
            $element.tableHeadFixer({"head" : false, "left" : 1});
        }
    }
};