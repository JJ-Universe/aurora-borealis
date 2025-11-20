(function(){
  'use strict';
  function applyLogoSizing(){
    var header = document.querySelector('.site-header');
    var logo = document.querySelector('.site-nav .brand img, .site-nav .brand svg, .custom-logo-link img, .custom-logo-link svg');
    if ( ! header || ! logo ) return;

    var headerStyles = window.getComputedStyle(header);
    var headerH = parseFloat( headerStyles.height ) || parseFloat( headerStyles.getPropertyValue('--header-height') ) || 72;
    var padding = 12; // small breathing room
    var maxH = Math.max(36, Math.round(headerH - padding));

    // Apply max-height (px) and ensure width auto
    try {
      logo.style.maxHeight = maxH + 'px';
      logo.style.width = 'auto';
      logo.style.height = 'auto';
    } catch(e){}

    // Respect CSS variable --logo-max-width if present
    try {
      var rootStyles = getComputedStyle(document.documentElement);
      var logoMax = rootStyles.getPropertyValue('--logo-max-width');
      if ( logoMax && logoMax.trim() ) {
        // If the variable is unitless (number), treat as px.
        var val = logoMax.trim();
        if (/^[0-9]+$/.test(val)) val = val + 'px';
        logo.style.maxWidth = val;
      }
    } catch(e){}
  }

  // Run on DOM ready and on resize to handle orientation changes
  if ( document.readyState === 'loading' ) {
    document.addEventListener('DOMContentLoaded', applyLogoSizing);
  } else {
    applyLogoSizing();
  }
  window.addEventListener('resize', function(){ window.requestAnimationFrame(applyLogoSizing); });
})();
