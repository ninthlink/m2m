<?php
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
  <head>
    <?php print $head ?>
    <title><?php print $head_title ?></title>
    <?php print $styles ?>
    <?php print $scripts ?>
  </head>
<body class="<?php print $body_classes;?>">

  <div id="bg">

  <div id="header">
    <div id="logo">
        <?php
          $site_title = check_plain( $site_name );
          if ($logo || $site_title) {
            print '<a href="'. check_url($base_path) .'" title="'. $site_title .'">';
            if ($logo) {
              print '<img src="'. check_url($logo) .'" alt="'. $site_title .'" />';
            }
            print '<span class="site_title">'. $site_title .'</span></a>';
          }
        ?>
  </div>

    <?php print $header; ?>

  </div><!-- END: header -->
      <?php if ($header_top): ?>
        <div id="header_top">
          <?php print $header_top ?>
          <div class="clear"></div>
        </div><!-- END: header_top -->
      <?php endif; ?>
  <div id="page-layout">

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
      
      <?php if ($breadcrumb): print $breadcrumb; endif; ?>
      
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
  </div><!-- END: page layout -->

      <div id="footer_outer">
      <?php if ($footer_top): ?>
        <div id="footer_top">
          <?php print $footer_top ?>
          <div class="clear"></div>
        </div>
      <?php endif; ?>
      <?php if ($footer): ?>
        <div id="footer">
          <div class="fline"></div>
          <div class="footer_inner">
            <?php print $footer ?>
          </div>
          <div class="clear"></div>
        </div>
      <?php endif; ?>
      </div><!-- END: footer_outer -->
</div><!-- END: bg -->



  <?php print $closure ?>
  </body>
</html>
