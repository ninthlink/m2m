<?php // $Id: page.tpl.php,v 1.18.2.1 2009/04/30 00:13:31 goba Exp $ ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
  <head>
    <?php print $head ?>
    <title><?php print $head_title ?></title>
    <?php print $styles ?>
    <?php print $scripts ?>
    <!--[if lt IE 7]>
      <?php print phptemplate_get_ie_styles(); ?>
    <![endif]-->
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
  <body<?php print phptemplate_body_class($left, $right); ?>   <?php if ($is_front):?>id="home"<?php endif; ?>>
<div class="headerMain">
 <div class="header">
  <div class="headerLogo"><a href="/"><img src="<?php echo $base_path.$directory;?>/images/msm_logo.png" width="158" height="80" alt="M2M" /></a></div>
  <div class="headerMenu">
  <!--<ul>
  <li><a href="#">Home</a></li>
  <li><a href="#">Register</a></li>
  </ul> -->  
  </div>
  <div class="headerLogin">
    <?php if ($search_box): ?><?php print $search_box ?><?php endif; ?>
  </div>
 </div>
</div>
<div class="wrapperMain">
  <div class="wrapper">  
    <?php
	if(strpos($_SERVER['REQUEST_URI'],"search")===false) echo '<div class="maincontainer">';?>
    
     <?php 
	 	global $user;
	 if($base_path!=$_SERVER['REQUEST_URI']){
	 if (isset($primary_links) && strpos($_SERVER['REQUEST_URI'],'/search/')===false) : ?>
          <?php print theme('links', $primary_links, array('class' => 'links primary-links')) ?>
        <?php endif; ?>
        <?php if (isset($secondary_links)) : ?>
          <?php print theme('links', $secondary_links, array('class' => 'links secondary-links')) ?>
        <?php endif; ?>
         <?php //if ($show_messages && $messages): print $messages; endif; ?>
       <div>
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
            <?php if($title == 'User account') print "Partner Login"; else print $title; ?>
          <?php endif ; ?></h1>
       <?php if(!is_front) print $breadcrumb; ?>
          <?php if ($mission): print '<div id="mission">'. $mission .'</div>'; endif; ?>
          <?php if ($tabs): print '<div id="tabs-wrapper" class="clear-block">'; endif; ?>
<?php
global $node, $user;
$node = node_load(arg(1));

if((arg(0)=='user' && arg(1)==$user->uid && $user->uid!=0) || (strpos($_SERVER['REQUEST_URI'],"managedevice")!==false) || ($node->type=='profile')){

	$id=arg(1);
	if(strpos($_SERVER['REQUEST_URI'], "user/".$user->uid."/edit")!==false) $act2=' class="active"';
	if(strpos($_SERVER['REQUEST_URI'], "node/add/device")!==false) $act3=' class="active"';
	if(strpos($_SERVER['REQUEST_URI'], "user/".$user->uid)!==false && arg(2)=='') $act1=' class="active"';
	if(strpos($_SERVER['REQUEST_URI'], "managedevice")!==false && arg(2)=='') $act4=' class="active"';
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
          <?php if ($tabs && strpos($_SERVER['REQUEST_URI'],'/search/')===false): print '<ul class="tabs primary">'. $tabs .'</ul></div>'; endif; ?>
          <?php //if ($tabs2): print '<ul class="tabs secondary">'. $tabs2 .'</ul>'; endif; ?>
          <?php }?>
          <?php //if ($show_messages && $messages): echo "<br><br>";print $messages; endif; ?>
          <?php print $help; ?>         
	   <?php print $content;?>       
       </div>
       <?php }?>       
       <?php if ($is_front):?>            
           <?php print $content;?>           
       <?php endif;?>
  </div>
</div>
<div class="footerMain">
 <div class="footer">
   <a href="http://www.qualcomm.com"  target="_blank"><div class="footerLogo"></div></a> 
   <div class="footerLink"><a href="/">Home</a><span>l</span><a href="/devicesearch">Search</a><span>l</span> <a href="http://www.qualcomm.com/site/legal"  target="_blank">legal</a><span>l</span> <a href="http://www.qualcomm.com/site/privacy" target="_blank">Privacy</a><span>l</span><?php if($user->uid && $user->uid!=0) {?> <a href="<?php echo $base_path;?>user/<?php echo $user->uid;?>">My account</a><span>l</span><a href="<?php echo $base_path;?>logout">Logout</a><?php }else{?><a href="<?php echo $base_path;?>user/login">Login</a><?php }?><?php if($user->uid==1) {?><span>l</span><a href="/device_exp.php">Export Devices</a><?php }?>
   </div>
   <div class="footerCopyright"> &copy; 2011 QUALCOMM Incorporated. All Rights Reserved</div>
 </div>
</div>
  <?php print $closure ?>
 <script language="javascript">
  $("#edit-search-theme-form-1").click(function(){
	  $("#edit-search-theme-form-1").val('');     
  });
  $("#search-theme-form").submit(function(){
	var uri="search/device_list/".$("#edit-search-theme-form-1").val();
	window.location(uri);exit;
									 
  });
  </script>
  </body>
</html>
