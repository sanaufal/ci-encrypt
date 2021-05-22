$(document).ready(function () {
	$('form').on('focus', '.form-number-custom', function (e) {
		$(this).on('wheel.disableScroll', function (e) {
			e.preventDefault();
		});
	});
	$('form').on('blur', '.form-number-custom', function (e) {
		$(this).off('wheel.disableScroll');
	});
	$('form').on('keydown', '.form-number-custom', function (e) {
		var key = e.charCode || e.keyCode;
		if (key == 38 || key == 40) {
			e.preventDefault();
		} else {
			return;
		}
	});

	$('input[data-only="number"]').keypress(function (e) {
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});

	// datatables default option
	$.extend(true, $.fn.dataTable.defaults, {
		language: {
			search: "_INPUT_",
			searchPlaceholder: "Search"
		},
		"processing": true,
		"initComplete": function (settings, json) {
			$('select, .form-control').removeClass('form-control-sm');
			$('.btn').removeClass('btn-sm');
		}
	});
});
