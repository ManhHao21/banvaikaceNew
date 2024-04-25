$(document).ready(function () {
    $(".delete").click(function (e) {
        var id = $(this).closest('.rowProduct').data('id');
        $.ajax({
            type: "post",
            url: "/delete/cart",
            data: { id: id },
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    $('.wrapper-table').html(response.html);
                }
            }
        });
    });

    $(document).ready(function () {
        $(".btn-update").click(function () {
            // Create an array to store product data
            var productsToUpdate = [];

            // Iterate through each row in the table
            $(".rowProduct").each(function () {
                var row = $(this);
                var id = row.data('id');
                var quantity = row.find('.form-control').val();

                // Add product data to the array
                productsToUpdate.push({
                    id: id,
                    quantity: quantity
                });
            });

            // Make an AJAX request to update the quantities
            $.ajax({
                type: "post",
                url: "/update/cart",
                data: {
                    products: productsToUpdate
                },
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        $('.wrapper-table').html(response.html);
                        window.location.reload();
                    }
                }
            });
        });
    });
});