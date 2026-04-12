(function () {
  var header = document.getElementById('mainHeader');
  var toTopBtn = document.getElementById('toTopBtn');
  var mobileToggle = document.getElementById('mobile-menu-toggle');

  function onScroll() {
    if (header) {
      header.classList.toggle('scrolled', window.scrollY > 12);
    }
    if (toTopBtn) {
      toTopBtn.classList.toggle('visible', window.scrollY > 300);
    }
  }

  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  if (toTopBtn) {
    toTopBtn.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  var wrapper = document.getElementById('userMenuWrapper');
  var trigger = document.getElementById('userTrigger');

  if (wrapper && trigger) {
    function openMenu() {
      wrapper.classList.add('open');
      trigger.setAttribute('aria-expanded', 'true');
    }

    function closeMenu() {
      wrapper.classList.remove('open');
      trigger.setAttribute('aria-expanded', 'false');
    }

    trigger.addEventListener('click', function (e) {
      e.stopPropagation();
      if (wrapper.classList.contains('open')) {
        closeMenu();
      } else {
        openMenu();
      }
    });

    document.addEventListener('click', function (e) {
      if (!wrapper.contains(e.target)) {
        closeMenu();
      }
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') {
        closeMenu();
      }
    });
  }

  var currentPath = window.location.pathname.toLowerCase();
  var navLinks = document.querySelectorAll('#navLinks a[data-nav="true"]');

  navLinks.forEach(function (link) {
    var href = (link.getAttribute('href') || '').toLowerCase();
    if (!href || href === '#') {
      return;
    }

    var absolutePath;
    try {
      absolutePath = new URL(href, window.location.origin).pathname.toLowerCase();
    } catch (err) {
      absolutePath = href;
    }

    if (
      currentPath === absolutePath ||
      (absolutePath !== '/' && currentPath.indexOf(absolutePath) === 0)
    ) {
      link.classList.add('active');
    }

    link.addEventListener('click', function () {
      if (mobileToggle) {
        mobileToggle.checked = false;
      }
    });
  });
})();
