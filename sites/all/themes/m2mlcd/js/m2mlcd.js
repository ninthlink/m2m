var qcyc, qar = new Array(), qhbx = 384, qhby = 360, qww = 1920, hcycms = 1500, qtar = false, QISDESKTOP = false;

// helper function to reshuffle array
function qdevice_restock(l) {
	console.log('restocking '+ l );
	for(j=0; j<l; j++) {
		qar[j] = j;
	}
	qar = $jq.shuffle(qar);
	console.log('rsok?');
}

// function for shuffling homepage devices
function qdevice_hcyc() {
	console.log('cyc');
	var d = $jq('.hdevices'); // actual 10 devices shown on the homepage screen
	var ds = d.children().size();
	var l = $jq('.view-homeslides .view-content ul'); // actual views results, however many that is
	// qar = array of positions of homepage devices to swap out
	// if it is empty, reshuffle...
	if ( qar.length == 0 ) {
		console.log('need restock');
		qdevice_restock(ds);
	}
	console.log('qar '+ qar.toSource());
	// pop the first # off, that is where we're shufflin
	var di = qar.shift();
	var dl = d.children().eq(di);
	if ( dl.hasClass('anim') ) {
		// due to OCD, we do not want to cycle out an item that was just cycled in
		if ( qar.length == 0 ) qdevice_restock(ds);
		di = qar.shift();
		dl = d.children().eq(di);
	}
	// choose a random element from our stock pool of non-visible items, to shuffle in
	var ls = l.children().size();
	var i = Math.floor(Math.random() * ls );
	var ll = l.children().eq(i);
	// add the item we are about to shuffle out, back in to our stock of non-visibles, for next time
	dl.clone().appendTo(l);
	// mark the current spot, so we don't choose to cycle it out again immediately next
	dl.addClass('anim').siblings('.anim').removeClass('anim');
	
	// now we know which spot we are cycling on
	// odd #s slide vertically, even #s slide horizontally
	if ( dl.hasClass('views-row-odd') ) {
		ll.children().css('top',qhby).addClass('n').appendTo(dl);
		ll.remove();
		dl.children().animate({
			top: '-='+ qhby
		}, 500, function() {
			if ( $jq(this).hasClass('n') ) {
				$jq(this).removeClass('n').siblings().remove();
			}
		});
	} else {
		ll.children().css('left',(-1 * qhbx)).addClass('n').appendTo(dl);
		ll.remove();
		dl.children().animate({
			left: '+='+ qhbx
		}, 500, function() {
			if ( $jq(this).hasClass('n') ) {
				$jq(this).removeClass('n').siblings().remove();
			}
		});
	}
	// keep on keepin on
	qcyc = setTimeout(qdevice_hcyc, hcycms);
}

// helper function to show the 4 categories on the homepage
function qdevice_hreveal() {
	$jq('#hcats ul a:hidden').eq(0).fadeIn(400);
	if ( $jq('#hcats ul a:hidden').size() > 0 ) {
		setTimeout(qdevice_hreveal,100);
	}
}

$jq(document).ready(function(){
	// lcd homepage js here?
	if ( $jq('body').hasClass('homeslider') ) {
		$jq('body').prepend('<ul class="hdevices" />');
		var hd = $jq('.hdevices');
		var ul = $jq('.view-homeslides .view-content ul');
		/*
		var whash = '' + window.location.hash;
		if ( whash == '#swipe' ) {
			// clone so our initial stock pool still has all items in it
			ul.children('li:lt(12)').clone().appendTo(hd);
			hcycms = 10000; // wait a lil longer?
			qcyc = setTimeout(qdevice_hswipe, hcycms);
		} else {
			*/
			ul.children('li:lt(12)').appendTo(hd);
			qcyc = setTimeout(qdevice_hcyc, hcycms); // start fading
		//}
		$jq('#m2mhcv').click(function() {
			$jq('#hcats ul').show();
			qdevice_hreveal();
			return false;
		});
	}
});