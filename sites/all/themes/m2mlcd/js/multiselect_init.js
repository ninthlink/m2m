$jq(document).ready(function(){
  $jq("select[multiple='multiple']").each(function(){
    var filter_label = $jq('label[for="'+$jq(this).attr('id')+'"]').html();
    $jq(this).multiselect({
      checkAllText: "Select All",
      uncheckAllText: "None",
      noneSelectedText: filter_label,
      selectedText: filter_label+' (# of #)'
    });
  });
});