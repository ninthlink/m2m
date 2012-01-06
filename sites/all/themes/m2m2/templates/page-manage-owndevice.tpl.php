<?php
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
  <head>
    <?php print $head ?>
    <title>Approve Devices</title>
    <?php print $styles ?>
    <?php print $scripts ?>
 <script type="text/javascript">
  $(function(){
    var speedA = $('select#speedA').selectmenu();
    $("#index").click(function(event){
      console.log($('select#speedA').selectmenu("index"));
    });
    $("#indexNumber").click(function(event){
      console.log($('select#speedA').selectmenu("index", 4));
    });
    $("#value").click(function(event){
      console.log($('select#speedA').selectmenu("value"));
    });
    $("#valueString").click(function(event){
      console.log($('select#speedA').selectmenu("value", "Medium"));
    });
    $("#valueNumber").click(function(event){
      console.log($('select#speedA').selectmenu("value", 4));
    });
    $("#valueNumberAsString").click(function(event){
      console.log($('select#speedA').selectmenu("value", "11"));
    });
    $("#valueNonExisting").click(function(event){
      console.log($('select#speedA').selectmenu("value", "test123"));
    });
  });
</script>

  </head>
<body class="<?php print $body_classes;?>">

  <div id="bg">
  <div id="page-layout">
  <div id="header">
    <div id="logo">
        <?php
          if ($logo || $site_title) {
            print '<a href="'. check_url($base_path) .'" title="'. $site_title .'">';
            if ($logo) {
              print '<img src="'. check_url($logo) .'" alt="'. $site_title .'" />';
            }
            print $site_html .'</a>';
          }
        ?>
  </div>

    <?php print $header; ?>
<div class="clear-block block block-menu" id="block-menu-primary-links">
    <ul class="menu">
      <li class="leaf first">
        <a title="" href="/">Module Search</a>
      </li>
      <li class="leaf last">
        <a title="" href="/routers">Wireless/Gateway Routers</a>
      </li>
    </ul>
</div>
<div class="clear-block block block-menu" id="block-menu-secondary-links">
  <div class="content">
    <ul class="menu">
      <li class="leaf first">
        <a title="" href="/resources">Resources</a>
      </li>
      <li class="leaf last">
        <a title="Featured" href="/featured">Featured</a>
      </li>
    </ul>
  </div>
</div>



  </div><!-- END: header -->



<div id="main_outer">
  <div id="main">

        <?php if ($section_title): ?>
        <div id="section_title">
          <?php print $section_title ?>
        </div><!-- END: section_title -->
      <?php endif; ?>

      <?php if ($left): ?>
        <div id="sidebar_first" class="sidebar">
          <?php print $left ?>
          <div class="clear"></div>
        </div><!-- END: sidebar -->
      <?php endif; ?>

    <div id="main_content">

      <?php if ($show_messages && $messages): print $messages; endif; ?>

      <?php if ($content_top): ?>
        <div id="content_top">
          <?php print $content_top ?>
          <div class="clear"></div>
        </div><!-- END: content_top -->
      <?php endif; ?>

      <div id="content">





    <?php
  if(strpos($_SERVER['REQUEST_URI'],"search")===false) echo '<div class="maincontainer">';?>

     <?php
    global $user;
   if($base_path!=$_SERVER['REQUEST_URI']){
   if (isset($primary_links)) : ?>
          <?php print theme('links', $primary_links, array('class' => 'links primary-links')) ?>
        <?php endif; ?>
        <?php if (isset($secondary_links)) : ?>
          <?php print theme('links', $secondary_links, array('class' => 'links secondary-links')) ?>
        <?php endif; ?>
         <?php //if ($show_messages && $messages): print $messages; endif; ?>
       <div style="float:left;">
         <h1 class="title"><?php if (arg(0) == 'user' && arg(1) == 'register') : ?>
            Create an Account
          <?php elseif (arg(0) == 'user' && arg(1) == 'password') : ?>
            Retrieve lost password
          <?php elseif (arg(0) == 'user' && arg(1) == 'login') : ?>
            Partner Login
          <?php elseif (arg(0) == 'user' && arg(1)=='') : ?>
            Partner Login
          <?php elseif (arg(0) == 'user' && arg(1)==$user->uid && arg(2)=='') : ?>
            Profile Page
         <?php elseif (arg(0) == 'user' && arg(1)==$user->uid && (arg(2)=='edit' ||  arg(2)=='profile')) : ?>
            Profile Page - Update profile
          <?php else : ?>
            <?php if($title == 'User account') print "Partner Login"; else print "Devices waiting for approval"; ?>
          <?php endif ; ?></h1>
       <?php if(!is_front) print $breadcrumb; ?>
          <?php if ($mission): print '<div id="mission">'. $mission .'</div>'; endif; ?>
          <?php if ($tabs): print '<div id="tabs-wrapper" class="clear-block">'; endif; ?>
<?php
global $node;
$node = node_load(arg(1));

if((arg(0)=='user' && arg(1)==$user->uid && $user->uid!=0) || (strpos($_SERVER['REQUEST_URI'],"manage/device")!==false) || ($node->type=='profile') || (strpos($_SERVER['REQUEST_URI'],"manage/owndevice")!==false)){

  $id=arg(1);
  if(strpos($_SERVER['REQUEST_URI'],"user/".$user->uid."/edit")!==false) $act2=' class="active"';
  if(strpos($_SERVER['REQUEST_URI'],"node/add/device")!==false) $act3=' class="active"';
  if(strpos($_SERVER['REQUEST_URI'], "user/".$user->uid)!==false && arg(2)=='') $act1=' class="active"';
  if(strpos($_SERVER['REQUEST_URI'], "manage/device")!==false && arg(2)=='') $act4=' class="active"';
  if(strpos($_SERVER['REQUEST_URI'], "manage/owndevice")!==false && arg(2)=='') $act5=' class="active"';

  $user_fields = user_load($user->uid);
  //if($user_fields->roles[3]=='Sales Rep')
  $device_url1="manage/owndevice";
  //else
  if($user_fields->roles[3]=='Sales Rep')
    $device_url="manage/device";
  else
    $device_url="managedevice";

  echo '<ul class="tabs primary"><li'.$act1.'><a href="'.$base_path.'user/'.$user->uid.'">View</a></li><li'.$act2.'><a href="'.$base_path.'user/'.$user->uid.'/edit">Update Profile</a></li>';
  if($user_fields->roles[3]=='Sales Rep') echo '<li'.$act5.'><a href="'.$base_path.$device_url1.'">Approve Devices</a></li>';
  echo '<li'.$act3.'><a href="'.$base_path.'node/add/device">Add Devices</a></li><li'.$act4.'><a href="'.$base_path.$device_url.'">Manage Devices</a></li></ul></div>';
  }else{?>

          <?php if ($tabs): print '<ul class="tabs primary">'. $tabs .'</ul></div>'; endif; ?>
          <?php //if ($tabs2): print '<ul class="tabs secondary">'. $tabs2 .'</ul>'; endif; ?>
          <?php }?>
          <?php //if ($show_messages && $messages): echo "<br><br>";print $messages; endif; ?>
          <?php print $help; ?>

     <?php //print $content;?>
      <?php
    global $user;
      $sql_1="select c.field_company_value, n.title from {content_field_company} c, {node} n where n.uid='$user->uid' AND n.type='profile' AND n.nid=c.nid";
$res_1=db_query($sql_1);
while($row_1=db_fetch_array($res_1)){
  $option_company1[]=$row_1['field_company_value'];
}
$option_sales_comp=implode("', '",$option_company1);
$cmp_val= "('".$option_sales_comp."')";

  /*    $sql_company_list=db_query("select field_company_value from {node} n, {content_field_company} c where n.uid='$user->uid' AND n.type='profile' AND n.nid=c.nid");
    $option_company=array();
    while($row_company_list=db_fetch_array($sql_company_list)){
    $option_company[]=$row_company_list['field_company_value'];
    }  */
  $sql_count=db_query("SELECT node.nid FROM {node} node LEFT JOIN {content_type_device} node_data_field_image ON node.vid = node_data_field_image.vid LEFT JOIN {content_field_company} node_data_field_company ON node.vid = node_data_field_company.vid
 LEFT JOIN {node_revisions} node_revisions ON node.vid = node_revisions.vid INNER JOIN {users} users ON node.uid = users.uid
 WHERE node.type in ('device') AND node.status='0' AND (node_data_field_company.field_company_value IN $cmp_val OR node.uid='$user->uid') GROUP BY node.nid");
  //$rows=db_fetch_array($sql_count);
  $rows=0;
  while($rows_count=db_fetch_array($sql_count)){
    $rows++;
    }
  if(!$rows){
  echo "No devices";
}else{

//  echo "NUM ROWS: ".$rows;
  if (!(isset($_REQUEST['pagenum'])))  {
 $pagenum = 1;
 } else{
 $pagenum = $_REQUEST['pagenum'];
}
 $page_rows =10;

 $last = ceil($rows/$page_rows);
 if ($pagenum < 1)  {
 $pagenum = 1;
 }elseif ($pagenum > $last)  {
 $pagenum = $last;
 }
 $max = 'limit ' .($pagenum - 1) * $page_rows .',' .$page_rows;

 echo "<div style='float: right; padding-top: 5px;'><p>";
 echo " Page $pagenum of $last ";
 if ($pagenum == 1)  { }
 else  {
 echo " <a href='".$base_path."manage/owndevice?pagenum=1'> First </a>";
 $previous = $pagenum-1;
 echo "<a href='".$base_path."manage/owndevice?pagenum=$previous'>Previous</a> ";
 }
 echo "    ";
 if ($pagenum == $last) { }
 else {
 $next = $pagenum+1;
 echo "<a href='".$base_path."manage/owndevice?pagenum=$next'>Next </a>";
 echo " <a href='".$base_path."manage/owndevice?pagenum=$last'>Last </a>";
 }
 echo "</p></div>";
  $sql="SELECT node.nid AS nid,
   node_data_field_image.field_image_fid AS node_data_field_image_field_image_fid,
   node_data_field_image.field_image_list AS node_data_field_image_field_image_list,
   node_data_field_image.field_image_data AS node_data_field_image_field_image_data,
   node.type AS node_type,
   node.vid AS node_vid,
   node.title AS node_title,
   node_data_field_company.field_company_value AS node_data_field_company_field_company_value,
   node_data_field_company.delta AS node_data_field_company_delta,
   node_data_field_image.field_frequncy_bands_value AS node_data_field_image_field_frequncy_bands_value,
   node_data_field_image.field_commercial_availability_value AS node_data_field_image_field_commercial_availability_value,
   node_data_field_image.field_voice_support_value AS node_data_field_image_field_voice_support_value,
   node_data_field_image.field_sms_support_value AS node_data_field_image_field_sms_support_value,
   node_data_field_image.field_gps_capabilities_value AS node_data_field_image_field_gps_capabilities_value,
   node.uid AS node_uid,
   node_revisions.format AS node_revisions_format,
   users.uid AS users_uid,
   node.created AS node_created
 FROM {node} node
 LEFT JOIN {content_type_device} node_data_field_image ON node.vid = node_data_field_image.vid
 LEFT JOIN {content_field_company} node_data_field_company ON node.vid = node_data_field_company.vid
 LEFT JOIN {node_revisions} node_revisions ON node.vid = node_revisions.vid
 INNER JOIN {users} users ON node.uid = users.uid
 WHERE node.type in ('device') AND node.status='0' AND (node_data_field_company.field_company_value IN $cmp_val OR node.uid='$user->uid') GROUP BY node.nid ORDER BY node_created DESC $max";

 $res=db_query($sql);
 while($row=db_fetch_object($res)){

   $sql_company=db_query("select field_company_value from {node} n, {content_field_company} c where n.nid='$row->nid' AND n.nid=c.nid");
  $option_company1=array();
  while($row_company=db_fetch_array($sql_company)){
    $option_company1[]=$row_company['field_company_value'];
  }
  //$common=array_intersect($option_company1,$option_company);
    //if($user->uid==$row->node_uid || count($common)){
    $sql_modem=db_query("select field_modem_technology_value from {content_field_modem_technology} m where m.nid='$row->nid'");
    $option_modem=array();
    while($row_modem=db_fetch_array($sql_modem)){
      $option_modem[]=$row_modem['field_modem_technology_value'];
    }
    $sql_operator=db_query("select field_operator_certifications_value from {content_field_operator_certifications} o where o.nid='$row->nid'");
    $option_operator=array();
    while($row_operator=db_fetch_array($sql_operator)){
      $option_operator[]=$row_operator['field_operator_certifications_value'];
    }
    $sql_img=db_query("select filepath from {files} where fid='$row->node_data_field_image_field_image_fid'");
    $row_img=db_fetch_array($sql_img);

?>
<div class="views-row views-row-1 views-row-odd views-row-first views-row-last">
<div class="views-field-field-image-fid">
                <span class="field-content"><a class="imagecache imagecache-142x106 imagecache-linked imagecache-142x106_linked" href="/node/<?php echo $row->nid;?>"><img height="106" width="142" class="imagecache imagecache-142x106" title="" alt="" src="<?php echo $base_path.$row_img['filepath'];?>"></a></span>
  </div>
  <div class="views-field-title"><label class="views-label-title">Product:</label><span class="field-content"><?php echo $row->node_title;?></span>
  </div>
  <div class="views-field-field-company-value"><label class="views-label-field-company-value">Company:</label><div class="field-content"><?php  echo substr(rtrim(implode(",",$option_company1),","),0,23)."...";?></div></div>
 <div class="views-field-field-modem-technology-value"><label class="views-label-field-modem-technology-value">Modem Technology:</label><div class="field-content"><?php  echo substr(trim(implode(",",$option_modem),","),0,23)."...";?></div></div>
  <div class="views-field-field-frequncy-bands-value"><label class="views-label-field-frequncy-bands-value">Frequency Bands:</label><span class="field-content"><?php echo $row->node_data_field_image_field_frequncy_bands_value;?></span></div>
  <div class="views-field-field-commercial-availability-value"><label class="views-label-field-commercial-availability-value">Commercial Availability:</label><span class="field-content"><?php echo $row->node_data_field_image_field_commercial_availability_value;?></span></div>
  <div class="views-field-field-voice-support-value"><label class="views-label-field-voice-support-value">Voice support:</label><span class="field-content"><?php echo $row->node_data_field_image_field_voice_support_value;?></span></div>
  <div class="views-field-field-sms-support-value"><label class="views-label-field-sms-support-value">SMS Support:</label><span class="field-content"><?php echo $row->node_data_field_image_field_sms_support_value;?></span></div>
  <div class="views-field-field-gps-capabilities-value"><label class="views-label-field-gps-capabilities-value">GPS Capabilities:</label><span class="field-content"><?php echo $row->node_data_field_image_field_gps_capabilities_value;?></span></div>
  <div class="views-field-field-operator-certifications-value"><label class="views-label-field-operator-certifications-value">Operator Certifications:</label><div class="field-content"><?php  echo substr(rtrim(implode(",",$option_operator),","),0,23)."...";?></div></div>
  <div class="div_manage_links">
<div class="views-field-edit-node"><span class="field-content"><a href="/node/<?php echo $row->nid;?>/publish?destination=manage/owndevice">Approve Device</a></span></div> <div class="views-field-edit-node"><span class="field-content"><a href="/node/<?php echo $row->nid;?>?destination=manage/owndevice">View</a></span></div> <div class="views-field-edit-node"><span class="field-content"><a href="/node/<?php echo $row->nid;?>/edit?destination=manage/owndevice">Edit</a></span></div>    <div class="views-field-delete-node"><span class="field-content"><a href="/node/<?php echo $row->nid;?>/delete?destination=manage/owndevice">Delete</a></span></div>
  </div>
  </div>
   <?php
  //}
}
}//device found
?>
       </div>
       <?php }?>

          <div class="clear"></div>
      </div><!-- END: content -->

      <?php if ($content_bottom): ?>
        <div id="content_bottom">
          <?php print $content_bottom ?>
          <div class="clear"></div>
        </div><!-- END: content_bottom -->
      <?php endif; ?>

      </div><!-- END: main_content -->

      <?php if ($right): ?>
        <div id="sidebar_second" class="sidebar">
          <?php print $right ?>
          <div class="clear"></div>
        </div><!-- END: sidebar -->
      <?php endif; ?>

    <div class="clear"></div>
    </div></div><!-- END: main -->
      <?php if ($footer): ?>
      <div id="footer">
<div class="clear-block block block-menu" id="block-menu-menu-footer">
  <div class="content">
    <ul class="menu">
      <li class="leaf first active-trail">
        <a class="active" title="" href="/">Home</a>
      </li>
      <li class="leaf">
        <a title="" href="/devicesearch">Search</a>
      </li>
      <li class="leaf">
        <a title="" href="http://www.qualcomm.com/site/legal">Legal</a>
      </li>
      <li class="leaf">
        <a title="" href="http://www.qualcomm.com/site/privacy">Privacy</a>
      </li>
      <li class="leaf last">
        <a title="" href="/logout">Logout</a>
      </li>
    </ul>
  </div>
</div>
        <?php print $footer ?>
        <div class="clear"></div>
      </div>
      <?php endif; ?>
  </div><!-- END: page layout -->
</div><!-- END: bg -->



  <?php print $closure ?>
  </body>
</html>