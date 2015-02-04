(function($){
	var defaults = {
		expire:			'',
		logged_in:		'',
	};
	cookie_message = function(options) {
		var o = $.extend(true, {}, defaults, options);

		if( o.logged_in == 'enabled' ) {
			localStorage.removeItem('cm-timestamp');
			$('.cm-message').addClass('cm-show');
		} else if( o.logged_in == '') {
			var timestamp = cm_get_timestamp();
			var now = cm_get_now_timestamp();

			timestamp = cm_get_timestamp();
			now = cm_get_now_timestamp();

			console.log(timestamp);

			if( timestamp == null || ( timestamp != 0 && now >= timestamp ) ) {
				$('.cm-message').addClass('cm-show');
			}
		} else {
			localStorage.removeItem('cm-timestamp');
		}

		$( ".cm-button-wrap" ).click(function() {
			if( o.logged_in == '') {
				cm_set_timestamp(o.expire);
			}
			$('.cm-message').removeClass('cm-show');
		});
	}

	function cm_set_timestamp(expire) {
		console.log('set');
		if( expire == 'one_day') {
			timestamp = cm_get_tomorrow_timestamp();
		} else if( expire == 'one_week' ) {
			timestamp = cm_next_week();
		} else if( expire == 'one_month' ) {
			timestamp = cm_next_month();
		} else if( expire == 'one_year' ) {
			timestamp = cm_next_year();
		} else {
			timestamp = 0;
		}
		localStorage.setItem("cm-timestamp", timestamp);
	}

	function cm_get_tomorrow_timestamp() {
		var date = new Date();
		var tomorrow = date.setDate(date.getDate() + 1);
		return tomorrow;
	}

	function cm_next_week() {
		var date = new Date();
		var timestamp = date.setDate(date.getDate() + 7);
		return timestamp;
	}

	function cm_next_month() {
		var date = new Date();
		var timestamp = date.setMonth(date.getMonth() + 1);
		return timestamp;
	}

	function cm_next_year() {
		var date = new Date();
		var timestamp = date.setFullYear(date.getFullYear() + 1);
		return timestamp;
	}

	function cm_get_now_timestamp() {
		var now = new Date().getTime();
		return now;
	}

	function cm_get_timestamp() {
		var timestamp = localStorage.getItem("cm-timestamp");
		return timestamp;
	}

	/* Kanske inte behövs */
	function cm_timestamp_to_days(timestamp) {
		var timestamp_to_days = Math.floor(timestamp / 1000 / 60 / 60 / 24);
		return timestamp_to_days;
	}
})(jQuery);