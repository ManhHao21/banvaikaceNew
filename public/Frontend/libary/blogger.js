(function ($) {
    "use strict";
    var HT = {};
    HT.loadAjax = () => {
        $.ajax({
            type: "get",
            url: "/blog",
            data: filter,
            dataType: "json",
            success: function (response) {},
        });
    };
    $(document).ready(function () {
        HT.loadCate();
    });
})(jQuery);
