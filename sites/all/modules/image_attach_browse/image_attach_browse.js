function myImageBrowserLoad(hash) {
  initImageBrowser();
  $(Drupal.settings.phImageBrowser + ' ul.pager a').bind('click', function() { 
    $(Drupal.settings.phImageBrowser).html(Drupal.settings.waiting);
    $(Drupal.settings.phImageBrowser).load($(this).attr('href'), {}, function() {
      myImageBrowserLoad(null);
    });
    return false; 
  });

  $(Drupal.settings.phImageBrowser + ' a.image-browser-choice').bind('click', function() { 
    var checkbox = $('input', this);
    checkbox.attr('checked', !checkbox.attr('checked'));
    imageAttachBrowserChoice(checkbox.val(), checkbox.attr('checked'));
    return false;
  });

  $(Drupal.settings.phImageBrowser + ' #image-browser-cancel').bind('click', function() {
    $(Drupal.settings.phImageBrowser).jqmHide();
    $(Drupal.settings.imageAttachSelectWrapper).slideDown();
    return false;
  });
  
  $(Drupal.settings.phImageBrowser + ' input[type="submit"]').bind('click', function() { 
    $(Drupal.settings.imageAttachSelect + ' option').attr('selected', '');
    if (!!Drupal.settings.imageBrowserChoices && Drupal.settings.imageBrowserChoices.length) {
      jQuery.each(Drupal.settings.imageBrowserChoices, function(key, value) {
        if (value == 0) {
          return; // continue;
        }
        $(Drupal.settings.imageAttachSelect + ' option[value="' + value + '"]').attr('selected', 'selected');
      });
    }
    $(Drupal.settings.phImageBrowser).jqmHide();
    $(Drupal.settings.imageAttachSelectWrapper).slideDown();
    return false;
  });
}

function imageAttachBrowserChoice(value, onoff) {
  if (onoff) {
    Drupal.settings.imageBrowserChoices.push(value);
  } else {
    var i = Drupal.settings.imageBrowserChoices.indexOf(value);
    if (i >= 0) {
      Drupal.settings.imageBrowserChoices[i] = 0;
    }
  }
}

function initImageBrowser() {
  $(Drupal.settings.phImageBrowser).jqm({
    modal: true,
    trigger: Drupal.settings.imageBrowserTrigger, 
    ajax: '@href',
    onLoad:myImageBrowserLoad
  });

  // Check the checkboxes that correspond to selected options
  if (!!$(Drupal.settings.imageAttachSelect).val() && $(Drupal.settings.imageAttachSelect).val().length) {
    Drupal.settings.imageBrowserChoices = new Array();
    jQuery.each($(Drupal.settings.imageAttachSelect).val(), function(key, value) {
      if(value == 0) {
        // If "None" is selected, deselect everything and break
        $(Drupal.settings.phImageBrowser + ' a.image-browser-choice input').attr('checked', '');
        return false;
      }
      if(!!$(Drupal.settings.phImageBrowser + ' a.image-browser-choice input[value="' + value + '"]')) {
        $(Drupal.settings.phImageBrowser + ' a.image-browser-choice input[value="' + value + '"]').attr('checked', 'checked');
        Drupal.settings.imageBrowserChoices.push(value);
      }
    });
  }
}

Drupal.behaviors.image_attach_browse = function() {
  if ($(Drupal.settings.imageAttachSelect + ' option').length > 1) {
    $('body').prepend($(Drupal.settings.phImageBrowser));
    $(Drupal.settings.phImageBrowser).html(Drupal.settings.waiting);
    initImageBrowser();
    Drupal.settings.imageBrowserChoices = new Array();
    if ($(Drupal.settings.imageAttachSelect + ' option:selected').length) {
      $(Drupal.settings.imageAttachSelect + ' option:selected').each(function() {
        if ($(this).val() == 0) {
          return false;
        }
        Drupal.settings.imageBrowserChoices.push($(this).val());
      });
    }
    $(Drupal.settings.imageAttachSelect).bind('change', function() {
      Drupal.settings.imageBrowserChoices = new Array();
      if (!!$(this).val() && $(this).val().length) {
        jQuery.each($(this).val(), function(key, value) {
          Drupal.settings.imageBrowserChoices.push(value);
        });
      }
    });
  } else {
    // Remove the browse button if there are no images uploaded yet!
    $(Drupal.settings.imageBrowserTrigger).remove();
  }
}
