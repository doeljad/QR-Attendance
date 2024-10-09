(function($) {
  'use strict';
  $(function() {
    var body = $('body');
    var sidebar = $('.sidebar');

    // Ambil parameter page dari URL
    var urlParams = new URLSearchParams(window.location.search);
    var currentPage = urlParams.get('page');

    // Fungsi untuk menambahkan class active
    function addActiveClass(element) {
      if (currentPage === null) {
        // untuk root url
        if (element.attr('href').indexOf("index.php") !== -1) {
          element.parents('.nav-item').last().addClass('active');
          if (element.parents('.sub-menu').length) {
            element.closest('.collapse').addClass('show');
            element.addClass('active');
          }
        }
      } else {
        // untuk URL lain
        if (element.attr('href').indexOf(currentPage) !== -1) {
          element.parents('.nav-item').last().addClass('active');
          if (element.parents('.sub-menu').length) {
            element.closest('.collapse').addClass('show');
            element.addClass('active');
          }
          if (element.parents('.submenu-item').length) {
            element.addClass('active');
          }
        }
      }
    }

    // Cek semua link di sidebar dan horizontal menu
    $('.nav li a', sidebar).each(function() {
      var $this = $(this);
      addActiveClass($this);
    });

    $('.horizontal-menu .nav li a').each(function() {
      var $this = $(this);
      addActiveClass($this);
    });

    // Tutup submenu lain saat membuka submenu baru
    sidebar.on('show.bs.collapse', '.collapse', function() {
      sidebar.find('.collapse.show').collapse('hide');
    });

    // Terapkan perfect scrollbar jika diperlukan
    applyStyles();

    function applyStyles() {
      if (!body.hasClass("rtl")) {
        if ($('.settings-panel .tab-content .tab-pane.scroll-wrapper').length) {
          const settingsPanelScroll = new PerfectScrollbar('.settings-panel .tab-content .tab-pane.scroll-wrapper');
        }
        if ($('.chats').length) {
          const chatsScroll = new PerfectScrollbar('.chats');
        }
        if (body.hasClass("sidebar-fixed")) {
          var fixedSidebarScroll = new PerfectScrollbar('#sidebar .nav');
        }
      }
    }

    // Toggle sidebar
    $('[data-toggle="minimize"]').on("click", function() {
      if ((body.hasClass('sidebar-toggle-display')) || (body.hasClass('sidebar-absolute'))) {
        body.toggleClass('sidebar-hidden');
      } else {
        body.toggleClass('sidebar-icon-only');
      }
    });

    // Checkbox dan radio button
    $(".form-check label,.form-radio label").append('<i class="input-helper"></i>');
  });
})(jQuery);
