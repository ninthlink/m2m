var m2mmulttot = 0, m2mmultcount = 0;

function m2m_mult_fx(i, id) {
	var m2msel = jQuery('#'+id);
	if ( m2msel.data('m2msfx') != 'ready') {
		jQuery('.ui-multiselect-checkboxes:eq('+i+')').jScrollPane();
		m2msel.data('m2msfx', 'ready');
	}
}
function m2m_mult_created() {
	m2mmultcount++;
	if ( m2mmultcount == m2mmulttot ) m2m_mult_fx();
}

if((typeof view_type === 'undefined')) {
	var view_type = 'thumbs';
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
    // initial scroll to top of menu
    if ( $('body').hasClass('front') ) {
      // dont scroll for now on front page? quickfix..
      $('html,body').addClass('scrolld');
    } else {
      $('html,body').addClass('scrolld').scrollTop(527);
    }
		if ( $('.devicelist').size() > 0 ) {
			if(view_type == 'thumbs') {
				show_grid();
			} else {
				hide_grid();
			}
      // expand/collapse filters too?
      if ( $('.views-exposed-form').size() > 0 ) {
        $('.views-exposed-form > div > div').each(function() {
          var flabel = $(this).children(':first');
          if ( flabel.is('label') ) {
            flabel.prepend('<input type="checkbox" name="'+ flabel.attr('for') +'" />').children('input').bind('change', function() {
              flabel.next().find('.bef-toggle').click();
            });
            flabel.bind('click', function(event) {
              var targ = $( event.target );
              if ( targ.is('input') == false ) {
                $(this).parent().toggleClass('collapsed');
              }
            });
            flabel.next().append('<input type="submit" value="Apply Filter" class="form-submit apply" />');
            
            if ( flabel.next().find('input:checked').size() == 0 ) {
              $(this).addClass('collapsed');
            }
          }
        });
      }
		}
    
    // expand/collapse for ABOUT block(s) ?
    var m2mablock = $('.aboutblock');
    if ( m2mablock.size() > 0 ) {
      m2mablock.find('.opener a, .closer a').click(function() {
        $('body').toggleClass('closedabout');
        return false;
      });
    }
    
    // some device details magics :
    // cant figure out setting menu active so another temp quickfix..
    if ( $('body').hasClass('node-type-device') ) {
      $('#block-menu-primary-links a.item_cellular').addClass('active').parent().addClass('active-trail');
      $('.group-product-details > div > div:even').addClass('stripe');
    }
    if ( $('body').hasClass('node-type-connectivity-module') ) {
      $('#block-menu-primary-links a.item_connectivity').addClass('active').parent().addClass('active-trail');
      $('.group-product-details > div > div:even').addClass('stripe');
    }
    if ( $('body').hasClass('node-type-featured-product') ) {
      $('#block-menu-primary-links a.item_featured').addClass('active').parent().addClass('active-trail');
      $('.group-product-details > div > div:even').addClass('stripe');
    }
    if ( $('body').hasClass('node-type-router') ) {
      $('#block-menu-primary-links a.item_wireless').addClass('active').parent().addClass('active-trail');
      $('.group-product-details > div > div:even').addClass('stripe');
    }
	};
})(jQuery);