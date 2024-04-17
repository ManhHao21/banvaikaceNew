(function ($) {
    "use strict";

    var HT = {};

    HT.select2M = () => {
        $(".js-select2-multi").select2();
    }
    $(document).ready(function () {
        HT.select2M();
    });
})(jQuery);
