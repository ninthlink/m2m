$jq(document).ready(function(){
	var mults = $jq("select[multiple='multiple']");
	m2mmulttot = mults.size();
  mults.each(function(i){
    var filter_label = $jq('label[for="'+$jq(this).attr('id')+'"]').html();
    $jq(this).data('m2mcount',i).multiselect({
      checkAllText: "Select All",
      uncheckAllText: "None",
      noneSelectedText: filter_label,
      selectedText: filter_label+' (# of #)',
	  open: function(event, ui) {
		  var m2mc = $jq(this).data('m2mcount');
		  m2m_mult_fx(m2mc, $jq(this).attr('id'));
	  }
    });
  });
});