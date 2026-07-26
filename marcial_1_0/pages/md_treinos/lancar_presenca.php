<?php
session_start();
require_once '../../classes/conn.php';

// pega o treino
$idTreino = $_GET['id'] ?? null;

if(!$idTreino){
    echo "Treino não informado";
    exit;
}

// ================= ALUNOS =================

// ATIVOS
$alunosAtivos = $pdo->query("
    SELECT p.cd_pessoa, p.pnome_pessoa
    FROM tb_pessoa p
    INNER JOIN tb_vinculo v ON v.cd_pessoa = p.cd_pessoa
    WHERE v.tipo_vinculo = 'ALUNO' 
    AND v.ativo = 'ATIVO'
")->fetchAll(PDO::FETCH_ASSOC);

// INATIVOS
$alunosInativos = $pdo->query("
    SELECT p.cd_pessoa, p.pnome_pessoa
    FROM tb_pessoa p
    INNER JOIN tb_vinculo v ON v.cd_pessoa = p.cd_pessoa
    WHERE v.tipo_vinculo = 'ALUNO' 
    AND v.ativo != 'ATIVO'
")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

  <title>Lançar Presença</title>

  <!-- base:css -->
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">

  <!-- plugins -->
  <link rel="stylesheet" href="../../vendors/flag-icon-css/css/flag-icon.min.css"/>
  <link rel="stylesheet" href="../../vendors/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../../vendors/jquery-bar-rating/fontawesome-stars-o.css">
  <link rel="stylesheet" href="../../vendors/jquery-bar-rating/fontawesome-stars.css"> 

  <!-- style -->
  <link rel="stylesheet" href="../../css/style.css">

  <link rel="manifest" href="manifest.json">

  <style>
    .card {
        border-radius: 12px;
    }
  </style>
</head>

<body>

<div class="container-scroller">

<?php include("../../partials/_navbar.php"); ?>

<div class="container-fluid page-body-wrapper">

<?php include("../../partials/_sidebar.php"); ?>

<div class="main-panel">
<div class="content-wrapper">

<h3 class="mb-4">Lista de Presença</h3>

<form method="POST" action="salvar_presenca.php">

<input type="hidden" name="id_treino" value="<?= $idTreino ?>">

<div class="row">

<!-- ATIVOS -->
<div class="col-md-6">
<div class="card p-3">
<h5 class="text-success mb-3">Alunos Ativos</h5>

<?php foreach($alunosAtivos as $a): ?>
<div class="form-check">
    <input class="form-check-input" type="checkbox" name="presenca[]" value="<?= $a['cd_pessoa'] ?>">
    <label class="form-check-label">
        <?= $a['pnome_pessoa'] ?>
    </label>
</div>
<?php endforeach; ?>

</div>
</div>

<!-- INATIVOS -->
<div class="col-md-6">
<div class="card p-3">
<h5 class="text-danger mb-3">Alunos Inativos</h5>

<?php foreach($alunosInativos as $a): ?>
<div class="form-check">
    <input class="form-check-input" type="checkbox" name="presenca[]" value="<?= $a['cd_pessoa'] ?>">
    <label class="form-check-label">
        <?= $a['pnome_pessoa'] ?>
    </label>
</div>
<?php endforeach; ?>

</div>
</div>

</div>


<div class="card p-3 mt-4">

<div class="card p-2 mb-3">
    <strong>Servidor de Reconhecimento:</strong>
    <span id="statusServidor">🔄 Verificando...</span>
</div>


    <h5>Chamada por Reconhecimento Facial</h5>

    <video id="video" width="100%" autoplay playsinline style="border-radius:10px;"></video>

    <canvas id="canvas" style="display:none;"></canvas>

    <button type="button" class="btn btn-success mt-3" onclick="capturar()" disabled>
        <i class="fa fa-camera"></i> Capturar e Reconhecer
    </button>

    <div id="resultado" class="mt-3"></div>
</div>

<!-- BOTÃO -->
<div class="mt-4">
<button type="submit" class="btn btn-primary">
<i class="fa fa-save"></i> Salvar Presença
</button>
</div>

</form>




</div> <!-- content-wrapper -->

                    <?php include("../../partials/_footer.php"); ?>

                </div> <!-- main-panel -->
            </div> <!-- page-body-wrapper -->
        </div> <!-- container-scroller -->
        <script src="../../vendors/base/vendor.bundle.base.js"></script>
        <!-- endinject -->
        <!-- Plugin js for this page-->
        <!-- End plugin js for this page-->
        <!-- inject:js -->
        <script src="../../js/off-canvas.js"></script>
        <script src="../../js/hoverable-collapse.js"></script>
        <script src="../../js/template.js"></script>
        <!-- endinject -->
        <!-- plugin js for this page -->
        <script src="../../vendors/chart.js/Chart.min.js"></script>
        <script src="../../vendors/jquery-bar-rating/jquery.barrating.min.js"></script>
        <!-- End plugin js for this page -->
        <!-- Custom js for this page-->
        <script src="../../js/dashboard.js"></script>
        <!-- End custom js for this page-->
    </body>

</html>

<script>
const video = document.getElementById('video');
const statusEl = document.getElementById("statusServidor");
const btnCapturar = document.querySelector("button[onclick='capturar()']");

const URL_VM = "http://192.168.1.6:8000";

let cameraAtiva = false;
let streamGlobal = null;
let servidorOnline = false;
let falhasSeguidas = 0;

// =====================
// 🎥 ATIVAR CÂMERA
// =====================
async function iniciarCamera() {
    if (cameraAtiva) return;

    try {
        const stream = await navigator.mediaDevices.getUserMedia({ video: true });
        video.srcObject = stream;

        streamGlobal = stream;
        cameraAtiva = true;

        btnCapturar.disabled = false;

    } catch (err) {
        console.error("Erro ao acessar câmera:", err);
    }
}

// =====================
// 🛑 PARAR CÂMERA
// =====================
function pararCamera() {
    if (!cameraAtiva || !streamGlobal) return;

    streamGlobal.getTracks().forEach(track => track.stop());
    video.srcObject = null;

    cameraAtiva = false;
    btnCapturar.disabled = true;
}

// =====================
// ⏱️ FETCH COM TIMEOUT
// =====================
function fetchComTimeout(url, tempo = 2000) {
    return Promise.race([
        fetch(url, { cache: "no-store" }),
        new Promise((_, reject) =>
            setTimeout(() => reject(new Error("timeout")), tempo)
        )
    ]);
}

// =====================
// 🌐 VERIFICAR SERVIDOR
// =====================
async function checarServidor() {
    const inicio = performance.now();

    try {
        const response = await fetchComTimeout(URL_VM + "/ping", 2000);
        const fim = performance.now();
        const latencia = Math.round(fim - inicio);

        if (!response.ok) throw new Error("Resposta inválida");

        falhasSeguidas = 0;

        // 👇 status mais inteligente
        if (latencia < 150) {
            statusEl.innerHTML = `🟢 Online (${latencia} ms)`;
        } else if (latencia < 500) {
            statusEl.innerHTML = `🟡 Lento (${latencia} ms)`;
        } else {
            statusEl.innerHTML = `🟠 Muito lento (${latencia} ms)`;
        }

        // 👇 só muda estado se necessário
        if (!servidorOnline) {
            servidorOnline = true;
            iniciarCamera();
        }

    } catch (e) {

        falhasSeguidas++;

        // 👇 tolerância de falha (evita piscar)
        if (falhasSeguidas < 2) return;

        statusEl.innerHTML = `🔴 Offline`;
        servidorOnline = false;

        pararCamera();
    }
}

// =====================
// 📸 CAPTURAR
// =====================
function capturar() {
    if (!cameraAtiva) {
        alert("Câmera não está ativa.");
        return;
    }

    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    ctx.drawImage(video, 0, 0);

    const imagem = canvas.toDataURL('image/jpeg');

    enviarImagem(imagem);
}

// =====================
// 📡 ENVIAR IMAGEM
// =====================
function enviarImagem(base64) {

    if (!servidorOnline) {
        document.getElementById("resultado").innerHTML = "Servidor offline";
        return;
    }

    fetch(URL_VM + "/reconhecer", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ imagem: base64 })
    })
    .then(res => {
        if (!res.ok) throw new Error("API falhou");
        return res.json();
    })
    .then(data => {

        document.getElementById("resultado").innerHTML = data.msg || "Sem resposta";

        if(data.nome){
            marcarPresenca(data.nome);
        }
    })
    .catch(() => {
        document.getElementById("resultado").innerHTML = "Erro no reconhecimento";
    });
}

// =====================
// ✅ MARCAR PRESENÇA
// =====================
function marcarPresenca(nome) {
    document.querySelectorAll("label").forEach(label => {
        if(label.innerText.trim().toLowerCase() === nome.toLowerCase()){
            label.previousElementSibling.checked = true;
        }
    });
}

// =====================
// 🔁 LOOP INTELIGENTE
// =====================
setInterval(checarServidor, 3000);
checarServidor();
</script>