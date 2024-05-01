(function ($) {
    "use strict";
    var HT = {};
    HT.key = 0; // Define key as a property of HT object
    HT.start = () => {
        if ($(".fa-star-o").length > 0) {
            $(".fa-star-o, .fa-star").on("click", function (e) {
                e.preventDefault();
                HT.key = $(this).data("key"); // Update HT.key when a star is clicked
                if ($(this).hasClass("fa-star-o")) {
                    $(".fa-star").each(function () {
                        if ($(this).data("key") <= HT.key) {
                            $(this).removeClass("d-none"); // Show the stars
                            $(this)
                                .next(
                                    ".fa-star-o[data-key='" +
                                        $(this).data("key") +
                                        "']"
                                )
                                .addClass("d-none"); // Hide the empty stars
                        } else {
                            $(this).addClass("d-none"); // Hide the stars
                            $(this)
                                .prev(
                                    ".fa-star-o[data-key='" +
                                        $(this).data("key") +
                                        "']"
                                )
                                .removeClass("d-none"); // Show the empty stars
                        }
                    });
                } else if ($(this).hasClass("fa-star")) {
                    $(".fa-star-o").each(function () {
                        if ($(this).data("key") >= HT.key) {
                            $(this).removeClass("d-none"); // Show the stars
                            $(this)
                                .prev(
                                    ".fa-star[data-key='" +
                                        $(this).data("key") +
                                        "']"
                                )
                                .addClass("d-none"); // Hide the empty stars
                        } else {
                            $(this).addClass("d-none"); // Hide the stars
                            $(this)
                                .prev(
                                    ".fa-star-o[data-key='" +
                                        $(this).data("key") +
                                        "']"
                                )
                                .removeClass("d-none"); // Show the empty stars
                        }
                    });
                }
            });
        }
    };
    HT.submitComment = () => {
        // Log the length of selected form elements for debugging
        console.log(
            "Number of selected form elements:",
            $(".submit_comment").length
        );

        if ($(".submit_comment").length > 0) {
            $(".submit_comment").on("click", function (e) {
                e.preventDefault();
                // Get the action URL from the form's action attribute
                let url = $("form#form_comment").attr("action");
                // Check if the URL is not undefined or empty
                if (url) {
                    let form_comment = $("#form_comment")[0]; // Get the form element
                    let formData = new FormData(form_comment);
                    formData.append("rating", HT.key);
                    $.ajax({
                        type: "post",
                        url: url, // Use the obtained URL
                        data: formData,
                        dataType: "json",
                        success: function (response) {
                            // Handle success response
                        },
                    });
                } else {
                    console.error("Action URL is undefined or empty");
                }
            });
        }
        // Access HT.key within submitComment function
    };

    $(document).ready(function () {
        HT.start();
        HT.submitComment();
    });
})(jQuery);
