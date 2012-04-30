if((typeof view_type === 'undefined')) {
	var view_type = 'list';
}
function toggle_devices(view_details) {
	if(view_details) {
		$('#device_details').show();
		$('#results').hide();
	} else {
		$('#device_details').hide();
		$('#results').show();
	}
}
function show_grid() {
	$('div.view-content').hide();
	$('div.view div.attachment').show();
	$('div.view div.attachment div.view-content').show();
	$('.grid-view').addClass('active');
	$('.list-view').removeClass('active');
	view_type = 'thumbs';
}
function hide_grid() {
	$('div.view div.attachment').hide();
	$('div.view-content').show();
	$('.grid-view').removeClass('active');
	$('.list-view').addClass('active');
	view_type = 'list';
}

(function($) {
	Drupal.behaviors.m2m_devicelist = function(context) {
		if ( $('.devicelist').size() > 0 ) {
			if(view_type == 'thumbs') {
				show_grid();
			} else {
				hide_grid();
			}
			$('.view-content .field-content a').click(function() {
				$('#devicehere').load($(this).attr('href')+" #main_content", function() {
					toggle_devices(true);
				});
				return false;
			});
		}
	};
})(jQuery);