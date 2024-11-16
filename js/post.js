/*global dotclear */
'use strict';

dotclear.ready(() => {
  Object.assign(dotclear.msg, dotclear.getData('featuredmedia'));

  // Replace featured media remove links by a POST form submit
  const removes = document.querySelectorAll('a.featuredmedia-remove');
  for (const remove of removes) {
    remove.addEventListener('click', (e) => {
      remove.href = '';
      const media_title = remove.parentNode.parentNode.querySelector('li > a')?.getAttribute('title');
      if (window.confirm(dotclear.msg.confirm_remove_featuredmedia.replace('%s', media_title))) {
        const form = document.getElementById('featuredmedia-remove-hide');
        if (form) {
          // Extract media ID
          form.elements.media_id.value = remove.id.substring(14);
          form.submit();
        }
      }
      e.preventDefault();
      return false;
    });
  }

  const legend = document.querySelector('h5.s-featuredmedia');
  if (legend) {
    const childs = document.querySelectorAll('.s-featuredmedia:not(h5)');
    dotclear.toggleWithLegend(legend, childs, {
      user_pref: 'dcx_featuredmedia',
      legend_click: true,
    });
  }
});
