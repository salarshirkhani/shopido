jQuery(function ($) {
  // رنگ‌بردار
  $('.shopido-color').wpColorPicker();

  // دکمه آپلود
  $('.shopido-upload').on('click', function (e) {
    e.preventDefault();
    const target = $($(this).data('target'));
    const frame = wp.media({
      title: 'انتخاب/آپلود فایل',
      button: { text: 'استفاده از این فایل' },
      multiple: false
    });
    frame.on('select', function () {
      const file = frame.state().get('selection').first().toJSON();
      target.val(file.url);
    });
    frame.open();
  });

  // ناوبری راست: اسکرول نرم + هایلایت
  $('.shopido-nav a').on('click', function (e) {
    e.preventDefault();
    const id = $(this).attr('href');
    $('html, body').animate({ scrollTop: $(id).offset().top - 80 }, 250);
  });
  const links = $('.shopido-nav a');
  $(window).on('scroll', function () {
    let fromTop = $(this).scrollTop() + 100;
    $('.shopido-section').each(function () {
      let top = $(this).offset().top;
      let bottom = top + $(this).outerHeight();
      if (fromTop >= top && fromTop <= bottom) {
        let id = '#' + $(this).attr('id');
        links.removeClass('active');
        links.filter('[href="'+id+'"]').addClass('active');
      }
    });
  });
});
