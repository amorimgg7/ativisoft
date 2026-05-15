<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Ativisoft • Monitoramento de Câmeras</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- HLS -->
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>

<style>
body {
    background: #0f172a;
    color: #e5e7eb;
}
.navbar {
    background: #020617;
}
.card {
    background: #020617;
    border: 1px solid #1e293b;
    cursor: pointer;
}
.card img {
    height: 160px;
    object-fit: cover;
    background: #000;
}
.online {
    color: #22c55e;
    font-weight: bold;
}
.offline {
    color: #ef4444;
    font-weight: bold;
}
#playerModal video {
    width: 100%;
    background: #000;
}
</style>
</head>

<body>

<nav class="navbar navbar-dark">
  <div class="container-fluid">
    <span class="navbar-brand">📡 Ativisoft • Câmeras Ao Vivo</span>
  </div>
</nav>

<div class="container mt-4">
  <div class="row g-3" id="cameras">
    <div class="col-12 text-center">Carregando câmeras…</div>
  </div>
</div>

<!-- MODAL PLAYER -->
<div class="modal fade" id="playerModal" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle"></h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <video id="video" controls autoplay></video>
      </div>
    </div>
  </div>
</div>

<script>
/* ===============================
   CONFIGURAÇÃO
================================*/
const API_BASE = "http://191.252.220.154/api_camera.php";
const CAMERAS = [
    "BRECHOZINHO",
    "MARCENARIA_1",
    "MARCENARIA_2"
    // 👉 se quiser, pode listar mais chaves aqui
];

/* ===============================
   FUNÇÕES
================================*/
function carregarCameras() {
    let html = "";

    Promise.all(
        CAMERAS.map(cam =>
            fetch(`${API_BASE}?chave=${cam}`)
                .then(r => r.json())
                .then(d => ({ cam, d }))
        )
    ).then(resultados => {

        resultados.forEach(({ cam, d }) => {

            let statusClass = d.status === "ONLINE" ? "online" : "offline";
            let snapshot = d.imagem ? d.imagem + "?t=" + Date.now() : "";

            html += `
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card" onclick="abrirPlayer('${cam}', '${d.video || ""}')">
                    <img src="${snapshot}" onerror="this.src='https://via.placeholder.com/400x200?text=SEM+IMAGEM'">
                    <div class="card-body text-center">
                        <div>${cam}</div>
                        <div class="${statusClass}">${d.status}</div>
                    </div>
                </div>
            </div>`;
        });

        document.getElementById("cameras").innerHTML = html;
    });
}

let hls;
function abrirPlayer(nome, url) {
    if (!url) {
        alert("Câmera offline");
        return;
    }

    document.getElementById("modalTitle").innerText = nome;
    let video = document.getElementById("video");

    if (hls) {
        hls.destroy();
        hls = null;
    }

    if (Hls.isSupported()) {
        hls = new Hls({ lowLatencyMode: true });
        hls.loadSource(url);
        hls.attachMedia(video);
    } else {
        video.src = url;
    }

    new bootstrap.Modal(document.getElementById("playerModal")).show();
}

/* ===============================
   LOOP
================================*/
carregarCameras();
setInterval(carregarCameras, 5000);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
