/*global $, dotclear */
'use strict';

$(function () {
  Object.assign(dotclear.msg, dotclear.getData('featuredmedia'));

  $('#edit-entry').on('onetabload', function () {
    // Replace featured media remove links by a POST form submit
    $('a.featuredmedia-remove').on('click', function () {
      this.href = '';
      const m_name = $(this).parents('ul').find('li:first>a').attr('title');
      if (window.confirm(dotclear.msg.confirm_remove_featuredmedia.replace('%s', m_name))) {
        const f = $('#featuredmedia-remove-hide').get(0);
        f.elements.media_id.value = this.id.substring(14);
        f.submit();
      }
      return false;
    });
  });

  $('h5.s-featuredmedia').toggleWithLegend($('.s-featuredmedia').not('h5'), {
    user_pref: 'dcx_featuredmedia',
    legend_click: true,
  });
});
