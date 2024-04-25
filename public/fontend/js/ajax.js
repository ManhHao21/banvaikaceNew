$(document).ready(function () {
    $(".comment").click(function (e) {
        e.preventDefault();
        console.log('312312');
        var formData = $("#formcomment").serializeArray();
        console.log(formData); var errors = [];

        formData.forEach(function (field) {
            if (field.name === "content" && field.value.trim() === "") {
                $('.required').show();
            }
            if (field.name === "name" && field.value.trim() === "") {
                $('.required').show();
            }
            if (field.name === "email" && field.value.trim() === "") {
                $('.required').show();
            }
            if (field.name === "email" && field.value.trim() !== "" && !IsEmail(field.value)) {
                $('.email').show();
            }
        });


        $('input[type="text"], input[type="email"]').focus(function () {
            $('.required').hide();
            $('.email').hide();
        });
        $.ajax({
            type: "post",
            url: "/ajax/comment",
            data: formData,
            dataType: "json", headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $('.commentView').append(response.html); $("#formcomment")[0].reset();
            }
        });
    });
    function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!regex.test(email)) {
            return false;
        } else {
            return true;
        }
    }

    $('body').on('click', '.add-to-cart', function (e) {
        e.preventDefault();
        var carts = $(".badge").text();
        var values = $(this).parent().find('.values').val();
        var id = $(this).parent().find('.id').data('id');
        console.log(values, id);
        $.ajax({
            type: "POST",
            url: "/post/ProductDetail",
            data: {
                "idProduct": id,
                "quantity": values
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
                if (response.success == 200) {
                    $('.badge').html(response.quantity);
                }
            }
        });
    })
});


