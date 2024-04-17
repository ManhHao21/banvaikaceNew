(function ($) {
    "use strict";
    var HT = {};

    HT.BrowseServerInput = (object, type) => {
        if (typeof (type) === 'undefined') {
            type = "Images";
        }
        var finder = new CKFinder();
        finder.resourceType = type;
        finder.selectActionFunction = function (fileUrl, data) {
            object.val(fileUrl);
        };
        finder.popup();
    };

    HT.inputImage = () => {
        $(document).on('click', '.input-image', function () {
            console.log('Click event triggered.');
            let _this = $(this);
            let fileUpload = _this.attr('data-upload');
            HT.BrowseServerInput(_this, fileUpload);
        });
    };


    $(document).ready(function () {
        HT.inputImage();
    });
})(jQuery);
