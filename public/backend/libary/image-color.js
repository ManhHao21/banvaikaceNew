$(document).ready(function () {
    var fileArr = [];

    $("#images").change(function () {
        var total_file = document.getElementById("images").files;
        if (!total_file.length) return;

        for (var i = 0; i < total_file.length; i++) {
            if (total_file[i].size > 1048576) {
                return false;
            } else if (!fileExists(total_file[i])) {
                fileArr.push(total_file[i]);
                $("#image_preview").append(
                    "<div class='img-div' id='img-div" +
                        (fileArr.length - 1) +
                        "'><img src='" +
                        URL.createObjectURL(total_file[i]) +
                        "' class='img-responsive image img-thumbnail' title='" +
                        total_file[i].name +
                        "' width='200px' height='200px'><div class='middle'><button id='action-icon' value='img-div" +
                        (fileArr.length - 1) +
                        "' class='btn btn-danger' role='" +
                        total_file[i].name +
                        "'><i class='fa fa-trash'></i></button></div></div>"
                );
            }
        }
    });
test
    $("body").on("click", "#action-icon", function (evt) {
        var divName = this.value;
        var fileName = $(this).attr("role");
        $("#" + divName).remove();

        fileArr = fileArr.filter(function (file) {
            return file.name !== fileName;
        });
        var input = document.getElementById("images");
        input.value = "";
        evt.preventDefault();
    });

    function fileExists(file) {
        for (var i = 0; i < fileArr.length; i++) {
            if (
                fileArr[i].name === file.name &&
                fileArr[i].size === file.size
            ) {
                return true;
            }
        }
        return false;
    }
});
