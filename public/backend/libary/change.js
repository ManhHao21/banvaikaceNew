(function ($) {
    "use strict";
    var HT = {};

    HT.changStatus = () => {
        if ($('.status').length) {
            $(document).on('change', '.status', function () {
                let _this = $(this);
                let option = {
                    'value': _this.prop('checked') ? 'on' : 'off',
                    'modelId': _this.attr('data-id'),
                    'data-model': _this.attr('data-model'),
                    'data-field': _this.attr('data-field'),
                };
                console.log(option);
                $.ajax({
                    type: "POST",
                    url: "/ajax/dashboard/changeStatus",
                    data: option, headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json",
                    success: function (response) {

                    }
                });
            });
        }
    }
    HT.changeStatusAll = () => {
        if ($('.changeStatusAll').length) {
            $(document).on('click', '.changeStatusAll', function (e) {
                let _this = $(this);
                let id = [];
                $('.checkItem').each(function () {
                    let checkbox = $(this);
                    if (checkbox.prop('checked')) {
                        id.push(checkbox.val());
                    }
                });

                let option = {
                    'value': _this.attr('data-value'),
                    'id': id,
                    'data-model': _this.attr('data-model'),
                    'data-field': _this.attr('data-field'),
                };
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "/ajax/dashboard/changeStatusPublicAll",
                    data: option, headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json",
                    success: function (response) {
                        if (response.flag === true) {
                            for (let i = 0; i < id.length; i++) {
                                let classid = '.js-switch-' + id[i];
                                let checkbox = $(classid);
                                let isChecked = checkbox.prop('checked');
                                console.log(isChecked);
                                // Đảo ngược trạng thái của checkbox
                                if (checkbox.prop('checked')) {
                                    checkbox.prop('checked', !checkbox.prop('checked'));
                                } else if (! checkbox.prop('checked')) {
                                    checkbox.prop('checked', checkbox.prop('checked'));
                                }
                            }
                        }
                    }

                });
            })
        }
    }
    HT.checkAll = () => {
        if ($('.checkAll').length) {
            $(document).on('click', '.checkAll', function () {
                let isChecked = $(this).prop('checked');
                $('.checkItem').prop('checked', isChecked);
                $('.checkItem').each(function () {
                    let _this = $(this);
                    if (_this.prop('checked')) {
                        _this.closest('tr').addClass('active-bg');
                    } else {
                        _this.closest('tr').removeClass('active-bg');

                    }
                })
            });
        };
    };
    HT.checkBoxItem = () => {
        if ($('.checkItem').length) {
            $(document).on('click', '.checkItem', function () {
                let _this = $(this);
                let isChecked = $(this).prop('checked');
                let uncheckedCheckboxesExist = $('.input-check:not(:checked)').length > 0;
                $('.checkAll').prop('checked', !uncheckedCheckboxesExist);
                if (isChecked) {
                    _this.closest('tr').addClass('active-bg');
                } else {
                    _this.closest('tr').removeClass('active-bg');

                }
                HT.allChecked();
            });
        };
    };
    HT.allChecked = () => {
        let allChecked = $('.checkItem:checked').length == $('.checkItem').length;
        $('.checkAll').prop('checked', allChecked)
    }
    $(document).ready(function () {
        HT.changStatus();
        HT.checkAll();
        HT.checkBoxItem();
        HT.changeStatusAll();
    });
})(jQuery);
