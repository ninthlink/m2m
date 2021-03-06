var m2mmulttot = 0, m2mmultcount = 0;

function m2m_mult_fx(i, id) {
	// dont worry about it
}
function m2m_mult_created() {
	m2mmultcount++;
	if ( m2mmultcount == m2mmulttot ) m2m_mult_fx();
}

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
	var jspApi = $('body').data('jsp');
	if ( jspApi ) {
		jspApi.reinitialise();
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
			$('body').css({'width':1920,'height':1080}).jScrollPane();
//			$('body').css({'width':1360,'height':768}).jScrollPane();//{showArrows:true});
		}
	};
})(jQuery);