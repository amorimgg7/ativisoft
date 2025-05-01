// Carrega o script do Google Tag Manager dinamicamente
(function() {
  const gtagScript = document.createElement('script');
  gtagScript.async = true;
  gtagScript.src = 'https://www.googletagmanager.com/gtag/js?id=G-WNS05ELYC8';
  document.head.appendChild(gtagScript);

  // Inicializa o Google Analytics após o carregamento do script
  gtagScript.onload = function() {
      window.dataLayer = window.dataLayer || [];
      function gtag() {
          dataLayer.push(arguments);
      }
      gtag('js', new Date());
      gtag('config', 'G-WNS05ELYC8');
  };
})();
