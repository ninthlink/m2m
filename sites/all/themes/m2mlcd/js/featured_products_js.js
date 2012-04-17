  function toggle_devices(view_details){
    if(view_details){
      $('#device_details').show();
      $('#results').hide();
    }else{
      $('#device_details').hide();
      $('#results').show();
    }
  }
  $(document).ready(function(){
    $('.view-content .field-content a').click(function() {
      $('#devicehere').load($(this).attr('href')+" #main_content", function() {
        toggle_devices(true);
      });
      return false; 
    });
    $('#edit-fake-all-checkbox').click(function(){
        $jq(this).closest('form').find('.bef-checkboxes input:checkbox').attr("checked", false);
    });
    $('#views-exposed-form-featured-products-page-1 .bef-checkboxes input:checkbox').change(function(){
        alert($(this).attr('checked'));
    });
  });