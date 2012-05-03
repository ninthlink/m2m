<?php
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
  <head>
    <?php print $head ?>
    <title><?php print $head_title ?></title>
    <link href="/<?php echo drupal_get_path('theme', 'm2m2');?>/css/jquery-ui-1.8.17.multiselect.css" type="text/css" rel="stylesheet" />
    <script src="/<?php echo drupal_get_path('theme', 'm2m2');?>/js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      var $jq = jQuery.noConflict();
    </script>
    <?php print $styles ?>
    <?php print $scripts ?>
  </head>
<body class="<?php print $body_classes;?> homeslider">
<?php print $content ?>
<div id="hcats">
<a href="#view" id="m2mhcv">Discover M2M Solutions</a>
<ul>
<li class="c0"><a href="cellular-modules">Cellular Module Search</a></li>
<li class="c1"><a href="connectivity-modules">Connectivity Module Search</a></li>
<li class="c2"><a href="routers">Wireless Gateway/Router Search</a></li>
<li class="c3"><a href="featured">Featured End Products</a></li>
</ul>
</div>
<?php print $closure ?>
</body>
</html>
