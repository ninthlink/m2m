jQuery(document).ready(
  function($){
    var search_btn;
    if($('#edit-submit-featured-products').length){
     search_btn = $('#edit-submit-featured-products');
    }else if($('#edit-submit-automotive-search').length){
      search_btn = $('#edit-submit-automotive-search');
    }else if($('#edit-submit-router-search').length){
      search_form = $('#views-exposed-form-router-search-page-1');
      search_btn = $('#edit-submit-router-search');
    }else if($('#edit-submit-connectivity-search').length){
      search_btn = $('#edit-submit-connectivity-search');
    }else if($('#edit-submit-Search').length){
      search_btn = $('#edit-submit-Search');
    }
    if(search_btn != null){
      search_btn.click(function(){
        if($('div.views-exposed-form option:selected').length > 0){
          $('#view-all').show();
        }else{
          $('#view-all').hide();
        }
      });
    }
  }
);