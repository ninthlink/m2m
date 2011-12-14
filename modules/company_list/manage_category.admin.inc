<?php
// Category Addtion & Listing

function category_list(){

    $path   = base_path();
	
	$output='<style type="text/css">
	#table_border
	{
	border:1px solid #cccccc;
	}
	tbody th {
	  border-bottom:6px solid #CCCCCC;
	  background:#CCCCCC;
	  
	  padding:5px 0px 5px 0px;
	}
	#add_new
	{
	border:1px solid #1D74CB;
	width:auto;
	font: bold 14px Tahoma;
	color:#fff;
	margin:10px 0 10px 0;
	background:#6699CC;
	}
	#add_new a
	{
	color:#fff;
	}
	</style>';
	
    $output .= "<table width=\"100%\" border=\"0\" class=\"sticky-enabled tableSelect-processed sticky-table\" id=\"add_new\" cellpadding=\"3\" cellspacing=\"3\"><tr>
    <td><a href=\"".$path."admin/manage/category/create\">Add New Category</a></td>
    </tr></table><table width=\"40%\" border=\"0\" class=\"sticky-enabled tableSelect-processed sticky-table\"><tr><th class=\"active\" align=\"left\">Category Name</th><th class=\"active\" align=\"left\">Operations</th></tr>";
	
    $result = db_query("SELECT * FROM {insol_category} ORDER BY catName ASC");
	
    while ($user = db_fetch_object($result)) {
	
		$output.="<tr class=\"even\">";
		$output.="<td>".$user->catName."</td>";
		
		$output.="<td><a href=\"".$path."admin/manage/category/edit/$user->id\">Edit</a> / <a href=\"".$path."admin/manage/category/delete/$user->id\">Delete</a></td>";
		$output.="</tr>";
    }
	$output .="</table>";
	return $output;
}

function category_list_create(){
    return drupal_get_form('category_list_create_form');
}

function category_list_create_form($form_state) {

    $form = array();
    //$form['#attributes']['enctype'] = 'multipart/form-data';

  //make a texfield
    $form['catname'] = array (
    '#type' => 'textfield',
    '#title' => t('Category Name'),
    '#required' => TRUE,
	'#size'=>35,
    );  

  $form['submit'] = array(
	  '#type' => 'submit',
	  '#value' => t('Save'),
  );
  return $form;
}

// Category Addtion ENDING

// Category Editing

function category_list_edit($uid){
    return drupal_get_form('category_list_edit_form',$uid);
}

function category_list_edit_form($form_state,$uid) {

	$result = db_query("SELECT catName,id FROM {insol_category} where id = '$uid'");
	$data   = db_fetch_object($result);

    $form = array();
    //$form['#attributes']['enctype'] = 'multipart/form-data';

  //make a texfield
    $form['catname'] = array (
    '#type' => 'textfield',
    '#title' => t('Category Name'),
	'#default_value' => $data->catName,	
    '#required' => TRUE,
	'#size'=>35,
    );  
	
  $form['catId'] = array('#type' => 'hidden', '#value' => $data->id);
  
  $form['submit'] = array(
	  '#type' => 'submit',
	  '#value' => t('Save'),
  );
  return $form;
}
// Category Editing ENDING

// Category Delete
function category_list_delete($uid){

	$result  = db_query("DELETE FROM {insol_category} WHERE id = $uid");
	$results = db_query("DELETE FROM {insol_sub_category} WHERE catId = $uid");
	
    drupal_set_message(t('Delete Successfull'));	
    drupal_goto('admin/manage/category');
}
// Category Delete ENDING

//Sub - Category Listing

function subcategory_list(){

    $path   = base_path();
	
	$output='<style type="text/css">
	#table_border
	{
	border:1px solid #cccccc;
	}
	tbody th {
	  border-bottom:6px solid #CCCCCC;
	  background:#CCCCCC;
	  
	  padding:5px 0px 5px 0px;
	}
	#add_new
	{
	border:1px solid #1D74CB;
	width:auto;
	font: bold 14px Tahoma;
	color:#fff;
	margin:10px 0 10px 0;
	background:#6699CC;
	}
	#add_new a
	{
	color:#fff;
	}
	</style>';
	
    $output .= "<table width=\"100%\" border=\"0\" class=\"sticky-enabled tableSelect-processed sticky-table\" id=\"add_new\" cellpadding=\"3\" cellspacing=\"3\"><tr>
    <td><a href=\"".$path."admin/manage/sub-category/create\">Add New Sub-Category</a></td>
    </tr></table><table width=\"40%\" border=\"0\" class=\"sticky-enabled tableSelect-processed sticky-table\"><tr><th class=\"active\" align=\"left\">Category Name</th><th class=\"active\" align=\"left\">Sub-Category Name</th><th class=\"active\" align=\"left\">Operations</th></tr>";
	
    $result = db_query("SELECT id,catId,SubCatName FROM {insol_sub_category} ORDER BY catId ASC");
	
    while ($user = db_fetch_object($result)) {
	
		$catResult = db_query("SELECT catName FROM {insol_category} WHERE id=$user->catId"); 
		$catRow = db_fetch_object($catResult);
		
		$output.="<tr class=\"even\">";
		$output.="<td>".$catRow->catName."</td>";
		$output.="<td>".$user->SubCatName."</td>";
		$output.="<td><a href=\"".$path."admin/manage/sub-category/edit/$user->id\">Edit</a> / <a href=\"".$path."admin/manage/sub-category/delete/$user->id\">Delete</a></td>";
		$output.="</tr>";
    }
	$output .="</table>";
	return $output;

}
//Sub - Category Listing END


//Sub - Category CREATION

function subcategory_list_create(){
    return drupal_get_form('subcategory_list_create_form');
}

function subcategory_list_create_form($form_state) {

    $form = array();
	$options_cat = array();
	
    //$form['#attributes']['enctype'] = 'multipart/form-data';
	
	$catResult = db_query("SELECT id,catName FROM {insol_category} ORDER BY catName ASC"); 
	
	while($catRow = db_fetch_object($catResult)){
		$options_cat[$catRow->id]=$catRow->catName;
	}
	
 	//make a SelectBox
	
 	$form['catname'] = array(
	'#type' => 'select',
	'#multiple' => false,
	'#title' => t('Select Category'),
	//'#default_value' => array('1','2'),
	'#required' => TRUE,
	'#options' => $options_cat,
	);


  //make a texfield
    $form['subcatname'] = array (
    '#type' => 'textfield',
    '#title' => t('Sub-Category Name'),
    '#required' => TRUE,
	'#size'=>35,
    );  

  $form['submit'] = array(
	  '#type' => 'submit',
	  '#value' => t('Save'),
  );
  
  return $form;
}
//Sub - Category CREATION END

//Sub -  Category Editing

function subcategory_list_edit($uid){
    return drupal_get_form('subcategory_list_edit_form',$uid);
}

function subcategory_list_edit_form($form_state,$uid) {

	$options_cat = array();

	$subresult = db_query("SELECT id,catId,SubCatName FROM {insol_sub_category} where id = '$uid'");
	$subCatRow = db_fetch_object($subresult);

	$catResult = db_query("SELECT id,catName FROM {insol_category} ORDER BY catName ASC"); 
	
	while($catRow = db_fetch_object($catResult)){
		$options_cat[$catRow->id]=$catRow->catName;
	}

    $form = array();
    //$form['#attributes']['enctype'] = 'multipart/form-data';
	
 	//make a SelectBox
	
 	$form['catname'] = array(
	'#type' => 'select',
	'#multiple' => false,
	'#title' => t('Select Category'),
	'#default_value' => array($subCatRow->catId),
	'#required' => TRUE,
	'#options' => $options_cat,
	);

  //make a texfield
    $form['subcatname'] = array (
    '#type' => 'textfield',
    '#title' => t('Sub-Category Name'),
	'#default_value' => $subCatRow->SubCatName,	
    '#required' => TRUE,
	'#size'=>35,
    );  
	
  $form['subCatId'] = array('#type' => 'hidden', '#value' => $subCatRow->id);
  
  $form['submit'] = array(
	  '#type' => 'submit',
	  '#value' => t('Save'),
  );
  return $form;
}
//Sub -  Category Editing ENDING

//Sub -  Category Delete

function subcategory_list_delete($uid){

	$result = db_query("DELETE FROM {insol_sub_category} WHERE id = $uid");
	
    drupal_set_message(t('Delete Successfull'));	
    drupal_goto('admin/manage/sub-category');
}
//Sub -  Category Delete ENDING

