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
    <link href="/<?php echo drupal_get_path('theme', 'm2m2');?>/css/jquery.multiselect.css" type="text/css" rel="stylesheet" />
    <script src="/<?php echo drupal_get_path('theme', 'm2m2');?>/js/jquery-ui-1.8.17.multiselect.min.js" type="text/javascript"></script>
    <?php print $styles ?>
    <?php print $scripts ?>
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

          <?php if ($tabs): print '<div id="tabs-wrapper" class="clear-block">'; endif; ?>
          <?php if ($tabs): print '<ul class="tabs primary">'. $tabs .'</ul></div>'; endif; ?>
          <?php if ($tabs2): print '<ul class="tabs secondary">'. $tabs2 .'</ul>'; endif; ?>
          <?php if ($title): print '<h1'. ($tabs ? ' class="with-tabs"' : '') .'>'. $title .'</h1>'; endif; ?>

          <?php print $help; ?>
          <?php print $content ?>
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
        <?php print $footer ?>
        <div class="clear"></div>
      </div>
      <?php endif; ?>
  </div><!-- END: page layout -->
</div><!-- END: bg -->



  <?php print $closure ?>
  </body>
</html>
