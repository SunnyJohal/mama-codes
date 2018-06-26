export default {
  init() {
    // JavaScript to be fired on all pages

    // Navigation overlay close
    jQuery('body').on('click', '.mobile-sticky-header-overlay', () => {
      jQuery('#main-menu').removeClass('open');
    });
  },

  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  }
};
