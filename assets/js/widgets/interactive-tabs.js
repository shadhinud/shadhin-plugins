(function($) {
  'use strict';

  var MH_Interactive_Tabs_Title = function ($scope) {
    if ($('.mh-interactive-tabs').length) {
      $('.mh-interactive-tabs').each(function() {
        var $this_tabs = jQuery(this);
        var target_parent = $($this_tabs.attr('data-tab-content-id'));
        $this_tabs.find('.tab-buttons .tab-btn').each(function() {
          var $this = jQuery(this);
          if ($this.hasClass('active-btn')) {
            var target = $($this.attr('data-tab'));
            $(target_parent).find(target).fadeIn(500).addClass('active-tab');
          }
        });
        $this_tabs.find('.tab-buttons .tab-btn').on('click', function (e) {
          e.preventDefault();
          var $this = jQuery(this);
          var target = $($this.attr('data-tab'));
          if ($(target_parent).find(target).is(':visible')) {
            return false;
          } else {
            $this.parents('.e-parent').find('.tab-buttons').find('.tab-btn').removeClass('active-btn');
            $this.addClass('active-btn');
            $this.parents('.e-parent').find('.mh-interactive-tabs-content').find('.tab').fadeOut(0);
            $this.parents('.e-parent').find('.mh-interactive-tabs-content').find('.tab').removeClass('active-tab');
            $(target_parent).find(target).fadeIn(500).addClass('active-tab');
          }
        });
      });
    }
  };

  //elementor front start
  $(window).on("elementor/frontend/init", function () {
      elementorFrontend.hooks.addAction(
          "frontend/element_ready/mh-ele-interactive-tabs-title.default",
          MH_Interactive_Tabs_Title
      );
      elementorFrontend.hooks.addAction(
          "frontend/element_ready/mh-ele-interactive-tabs-title.skin-style1",
          MH_Interactive_Tabs_Title
      );
  });
})(jQuery);