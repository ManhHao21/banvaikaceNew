(function ($) {
	"use strict";

	var HT = {};

	HT.getLocation = () => {
		$(document).on('change', '.location', function () {
			var _this = $(this);
			var option = {
				'data': {
					'province_id': _this.val(),
				},
				'target': _this.attr('data-target')
			}
			console.log(option);
			HT.SendDataTogetLocation(option);
		});
	};
	HT.SendDataTogetLocation = (option) => {
		$.ajax({
			type: "get",
			url: "/ajax/address",
			data: option,
			dataType: "json",
			success: function (response) {
				console.log(response.html);
				$('.' + option.target).html(response.html);
				if (district_id != '' && option.target == 'districts') {
					$('.districts').val(district_id).trigger('change');
				}
				if (ward_id != '' && option.target == 'wards') {
					$('.wards').val(ward_id).trigger('change');
				}
			}
		});
	}
	HT.loadCity = () => {
		if (province_id != "") {
			$(".province").val(province_id).trigger('change');
		}
	}
	$(document).ready(function () {
		HT.getLocation();
		HT.loadCity();
	});
})(jQuery);
