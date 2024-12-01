self.addEventListener('fetch', (event) => {
    const url = new URL(event.request.url);
    
    // Verifica se está rodando no modo standalone e redireciona
    if (url.pathname === '/' || url.pathname === '/index.php') {
      event.respondWith(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then((clientList) => {
          if (clientList.length > 0) {
            clientList[0].navigate('/pages/dashboard/index.php');
            return new Response('', { status: 307 });
          }
          return fetch(event.request);
        })
      );
    } else {
      event.respondWith(caches.match(event.request).then((response) => {
        return response || fetch(event.request);
      }));
    }
  });
  