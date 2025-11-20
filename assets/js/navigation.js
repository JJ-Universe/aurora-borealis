/**
 * Simple mobile navigation toggle
 */
(function(){
  var toggle = document.querySelector('.mobile-toggle');
  var mobile = document.getElementById('mobile-navigation');
  var body = document.body;
  if (!toggle) return;

  function openMenu(){
    toggle.setAttribute('aria-expanded', 'true');
    body.classList.add('nav-open');
    if (mobile){
      mobile.setAttribute('aria-hidden', 'false');
      var firstLink = mobile.querySelector('a, button, [tabindex]:not([tabindex="-1"])');
      if(firstLink && typeof firstLink.focus === 'function'){
        firstLink.focus();
      }
    }
  }

  function closeMenu(restoreFocus){
    toggle.setAttribute('aria-expanded', 'false');
    body.classList.remove('nav-open');
    if (mobile){
      mobile.setAttribute('aria-hidden', 'true');
    }
    if (restoreFocus){
      try { toggle.focus(); } catch(err){}
    }
  }

  toggle.addEventListener('click', function(){
    var expanded = toggle.getAttribute('aria-expanded') === 'true';
    if (expanded){
      closeMenu(true);
    } else {
      openMenu();
    }
  });

  // close on escape and restore focus
  document.addEventListener('keydown', function(e){
    if(e.key === 'Escape' && body.classList.contains('nav-open')){
      closeMenu(true);
    }
  });

  document.addEventListener('click', function(event){
    if(!body.classList.contains('nav-open')) return;
    if (event.target === toggle || toggle.contains(event.target)) return;
    if (mobile && mobile.contains(event.target)) return;
    closeMenu(false);
  });

  window.addEventListener('resize', function(){
    if (body.classList.contains('nav-open')){
      closeMenu(false);
    }
  });
})();

