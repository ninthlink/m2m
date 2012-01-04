<?php
// $Id: page.tpl.php,v 1.18.2.1 2009/04/30 00:13:31 goba Exp $
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
  <head>
    <?php print $head ?>
    <title><?php print $head_title ?></title>
    <?php print $styles ?>
    <?php print $scripts ?>
    <!--[if lt IE 7]>
      <?php print phptemplate_get_ie_styles(); ?>
    <![endif]-->
  </head>
  <body<?php print phptemplate_body_class($left, $right); ?>>

<!-- Layout -->
  <div class="headerMain">
 <div class="headertop">
  <div class="headerLogo"><a href="/"><img src="<?php echo $base_path.$directory;?>/images/msm_logo.png" width="158" height="80" alt="M2M" /></a></div>
 </div>
</div>
 <!-- /header -->

    <div id="wrapper">
    <div id="container" class="clear-block">


      

      <div id="center"><div id="squeeze"><div class="right-corner"><div class="left-corner">
          <?php print $breadcrumb; ?>
          <?php if ($mission): print '<div id="mission">'. $mission .'</div>'; endif; ?>
          <?php if ($tabs): print '<div id="tabs-wrapper" class="clear-block">'; endif; ?>
          <?php if ($title): print '<h2'. ($tabs ? ' class="with-tabs"' : '') .'>'. $title .'</h2>'; endif; ?>
          <?php if ($tabs): print '<ul class="tabs primary">'. $tabs .'</ul></div>'; endif; ?>
          <?php if ($tabs2): print '<ul class="tabs secondary">'. $tabs2 .'</ul>'; endif; ?>
          <?php if ($show_messages && $messages): print $messages; endif; ?>
          <?php print $help; ?>
          <div class="clear-block">
            <?php print $content ?>
          </div>
          <?php print $feed_icons ?>
         
      </div></div></div></div> <!-- /.left-corner, /.right-corner, /#squeeze, /#center -->

      <?php if ($right): ?>
        <div id="sidebar-right" class="sidebar">
          <?php if (!$left && $search_box): ?><div class="block block-theme"><?php print $search_box ?></div><?php endif; ?>
          <?php print $right ?>
        </div>
      <?php endif; ?>

    </div> <!-- /container -->
  </div>
<!-- /layout -->

<div class="footerMain">
 <div class="footer">
   <a href="http://www.qualcomm.com"  target="_blank"><div class="footerLogo"></div></a> 
   <div class="footerLink"><a href="/">Home</a><span>l</span><a href="/devicesearch">Search</a><span>l</span> <a href="http://www.qualcomm.com/site/legal"  target="_blank">legal</a><span>l</span> <a href="http://www.qualcomm.com/site/privacy" target="_blank">Privacy</a><span>l</span><?php global $user;if($user->uid && $user->uid!=0) {?> <a href="<?php echo $base_path;?>user/<?php echo $user->uid;?>">My account</a><span>l</span><a href="<?php echo $base_path;?>logout">Logout</a><?php }else{?><a href="<?php echo $base_path;?>user/login">Login</a><?php }?><?php if($user->uid==1) {?><span>l</span><a href="/device_exp.php">Export Devices</a><?php }?>
   </div>
   <div class="footerCopyright"> &copy; 2011 QUALCOMM Incorporated. All Rights Reserved</div>
 </div>
</div>
  <?php print $closure ?>
  </body>
</html>
