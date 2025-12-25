// Google Translate initialization
function googleTranslateElementInit() {
  new google.translate.TranslateElement({ 
    pageLanguage: 'en',
    includedLanguages: 'en,si,ta',
    autoDisplay: false 
  }, 'google_translate_element');
  
  console.log('Google Translate initialized');
}

// Helper: attempt to clear Google Translate cookies so we can return to original English
function clearGoogleTranslateCookies() {
  try {
    const cookieNames = ['googtrans', 'googtrans\u0000'];
    const hosts = [window.location.hostname];
    // Also try with leading dot and without domain (especially for localhost)
    if (window.location.hostname.indexOf('.') !== 0) {
      hosts.push('.' + window.location.hostname);
    }
    const paths = ['/', window.location.pathname.split('/').slice(0, 2).join('/') || '/'];
    const expires = 'expires=Thu, 01 Jan 1970 00:00:00 GMT';
    cookieNames.forEach((name) => {
      // Clear without domain (for localhost)
      paths.forEach((p) => {
        document.cookie = `${name}=; ${expires}; path=${p}; SameSite=Lax`;
      });
      // Clear with domain variations
      hosts.forEach((domain) => {
        paths.forEach((p) => {
          document.cookie = `${name}=; ${expires}; path=${p}; domain=${domain}; SameSite=Lax`;
        });
      });
    });
    console.log('Attempted to clear Google Translate cookies');
  } catch (e) {
    console.warn('Failed clearing translate cookies:', e);
  }
}

// Helper: Reset translation back to original English content
function resetToEnglish() {
  clearGoogleTranslateCookies();
  const combo = document.querySelector('#google_translate_element select.goog-te-combo');
  if (combo) {
    combo.value = '';
    combo.dispatchEvent(new Event('change'));
  } else {
    // Try again shortly if not ready yet
    setTimeout(resetToEnglish, 200);
  }
}

// Set language in Google Translate
function setGoogleTranslateLanguage(lang) {
  if (!lang || lang === 'en') {
    // If English or empty, reload the page to restore original content
    console.log('Resetting to English - reloading page');
    clearGoogleTranslateCookies();
    localStorage.setItem('langPref', 'en');
    window.location.reload();
    return;
  }

  const combo = document.querySelector('#google_translate_element select.goog-te-combo');
  if (!combo) {
    console.log('Google Translate not ready, retrying...');
    return setTimeout(() => setGoogleTranslateLanguage(lang), 200);
  }

  console.log('Setting language to:', lang);
  combo.value = lang;
  combo.dispatchEvent(new Event('change'));
}

// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', function() {
  const langSelect = document.getElementById('custom-translate');
  
  if (!langSelect) {
    console.error('Language selector not found!');
    return;
  }

  console.log('Language selector found');

  // Language change handler
  langSelect.addEventListener('change', function() {
    const selectedLang = this.value;
    console.log('Language changed to:', selectedLang);
    localStorage.setItem('langPref', selectedLang);
    setGoogleTranslateLanguage(selectedLang);
  });

  // Load saved language preference
  const savedLang = localStorage.getItem('langPref');
  if (savedLang) {
    console.log('Restoring saved language:', savedLang);
    langSelect.value = savedLang;
    // Wait a bit for Google Translate to fully initialize
    setTimeout(() => {
      if (savedLang === 'en') {
        resetToEnglish();
      } else {
        setGoogleTranslateLanguage(savedLang);
      }
    }, 800);
  } else {
    // No saved preference: default to English automatically
    const defaultLang = 'en';
    console.log('No saved language found. Defaulting to:', defaultLang);
    langSelect.value = defaultLang;
    localStorage.setItem('langPref', defaultLang);
    // Apply after a short delay to allow Google Translate to initialize
    setTimeout(() => resetToEnglish(), 1000);
  }
});
