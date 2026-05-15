<?php
session_start();

$logado = false;
$limiteUpload = 50;
$usuario_dir = "guest";

if(isset($_SESSION['google_id'])){
    $logado = true;
    $limiteUpload = 10000;
    $usuario_dir = $_SESSION['google_id'];
}

$dirTemp = "temp/".$usuario_dir;

if(!is_dir($dirTemp)){
    mkdir($dirTemp,0777,true);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Auditor Fiscal XML</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://accounts.google.com/gsi/client" async defer></script>

<style>
.drop-area{
border:2px dashed #0d6efd;
padding:40px;
text-align:center;
border-radius:10px;
background:#f8f9fa;
cursor:pointer;
transition:0.3s;
}

.drop-area:hover{
background:#e9ecef;
}

#nomeArquivo{
word-break: break-all;
}

/* mobile */
@media (max-width:768px){

.drop-area{
padding:20px;
font-size:14px;
}

#statusProcesso{
font-size:16px;
}

#nomeArquivo{
font-size:13px;
}

.progress{
height:25px;
}

button{
font-size:16px;
}

}
</style>

</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
<div class="container">

<span class="navbar-brand">
Analisador Fiscal XML
</span>

<div>

<?php if(!$logado){ ?>

<div id="g_id_onload"
data-client_id="107976644534-8knc18ps4i830labkk0petk6a7doo3pa.apps.googleusercontent.com"
data-callback="handleCredentialResponse"
data-auto_prompt="false">
</div>

<div class="g_id_signin"></div>

<?php } else { ?>

<img src="<?=$_SESSION['picture']?>" width="35" style="border-radius:50%">
<span class="text-white mx-2">
<?=$_SESSION['name']?>
</span>

<a href="logout_google.php" class="btn btn-sm btn-danger">
Sair
</a>

<?php } ?>

</div>
</div>
</nav>

<div class="container py-5">

<div class="alert alert-warning text-center">

Limite de análise: <b><?=$limiteUpload?> arquivos</b>

<?php if(!$logado){ ?>
<br>
Faça login com Google para liberar até <b>10.000 arquivos</b>.
<?php } ?>

</div>

<div class="alert alert-info text-center" id="contadorTemp">
Arquivos na pasta TEMP: ...
</div>

<div class="card shadow mb-4">

<div class="card-body">

<div class="drop-area mb-3">
<p>Selecione ou arraste os XML</p>
<input type="file" id="xml" multiple class="form-control" accept=".xml">
</div>

<div class="d-grid">
<button onclick="iniciar()" class="btn btn-primary btn-lg">
Analisar XML
</button>
</div>

<div class="d-grid mt-2">
<button onclick="limparTemp()" class="btn btn-danger">
Limpar diretório
</button>
</div>

<div class="progress mt-4">
<div id="barra" class="progress-bar progress-bar-striped progress-bar-animated" style="width:0%">
0%
</div>
</div>

<div class="progress mt-3">
<div id="barraTemp" class="progress-bar bg-danger progress-bar-striped progress-bar-animated" style="width:0%">
0%
</div>
</div>

<div class="text-center mt-2">
<div id="statusTemp"></div>
</div>

<div class="mt-3 text-center">

<div id="statusProcesso" style="font-size:18px;font-weight:bold;">
...
</div>

<div id="nomeArquivo" style="font-size:15px;color:#555;">
</div>

</div>

</div>
</div>

<div id="resultado"></div>

</div>

<script>

function handleCredentialResponse(response) {

const data = parseJwt(response.credential);

fetch("login_google.php", {
method: "POST",
headers: { "Content-Type": "application/json" },
body: JSON.stringify({
id: data.sub,
email: data.email,
name: data.name,
picture: data.picture
})
})

.then(response => response.json())

.then(result => {

if(result.success){

location.reload();

}else{

alert("Erro no login");

}

});

}

function parseJwt(token) {

var base64Url = token.split('.')[1];
var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');

var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
}).join(''));

return JSON.parse(jsonPayload);

}

let arquivos = [];
let indice = 0;
let resultados = [];

$(document).ready(function(){

atualizarContadorTemp();
setInterval(atualizarContadorTemp,2000);

});

let limite = <?=$limiteUpload?>;

function iniciar(){

arquivos = document.getElementById("xml").files;

if(arquivos.length === 0){
alert("Selecione arquivos XML");
return;
}

/* consultar quantos arquivos já existem */

$.get("listar_temp.php", function(resp){

let arquivosTemp = JSON.parse(resp);
let totalTemp = arquivosTemp.length;

/* verificar limite total */

if((totalTemp + arquivos.length) > limite){

alert(
"Limite máximo de "+limite+".\n\n"+
"Arquivos analisados: "+totalTemp+"\n"+
"Arquivos selecionados: "+arquivos.length+"\n"+
"Limpe seu diretório para continuar."
);

return;

}

/* iniciar processamento */

indice = 0;
resultados = [];

processarLote();

});

}
function processarLote(){

let lote = new FormData();

let inicioLote = indice;
let ultimoNome = "";

for(let i=0;i<20 && indice<arquivos.length;i++,indice++){

lote.append("xml[]",arquivos[indice]);
ultimoNome = arquivos[indice].name;

}

$("#statusProcesso").text(
"Processando arquivo "+(inicioLote+1)+" de "+arquivos.length
);

$("#nomeArquivo").text(ultimoNome);

$.ajax({

url:"processar.php",
method:"POST",
data:lote,
processData:false,
contentType:false,

success:function(resp){

let dados;

try{
dados = JSON.parse(resp);
}catch(e){
console.log(resp);
alert("Erro no processamento");
return;
}

resultados = resultados.concat(dados);

let progresso = Math.round((indice/arquivos.length)*100);

$("#barra").css("width",progresso+"%");
$("#barra").text(progresso+"%");

if(indice < arquivos.length){

processarLote();

}else{

$("#statusProcesso").text("Processamento finalizado");
$("#nomeArquivo").text("");

mostrarResultado();

}

}

});

}


function mostrarResultado(){

let totalNotas = resultados.length;

let vtotal = 0;
let icms = 0;
let pis = 0;
let cofins = 0;
let ipi = 0;
let fecp = 0;

let linhas = "";

resultados.forEach(r=>{

vtotal += parseFloat(r.valor_nota || 0);
icms += parseFloat(r.icms_total || 0);
pis += parseFloat(r.pis_total || 0);
cofins += parseFloat(r.cofins_total || 0);
ipi += parseFloat(r.ipi_total || 0);
fecp += parseFloat(r.fecp_total || 0);

linhas += `
<tr>
<td>${r.empresa}</td>
<td>${r.cnpj}</td>
<td>${r.numero}</td>

<td>R$ ${parseFloat(r.valor_nota || 0).toLocaleString('pt-BR',{minimumFractionDigits:2})}</td>
<td>${parseFloat(r.icms_total || 0).toLocaleString('pt-BR',{minimumFractionDigits:2})}</td>
<td>${parseFloat(r.pis_total || 0).toLocaleString('pt-BR',{minimumFractionDigits:2})}</td>
<td>${parseFloat(r.cofins_total || 0).toLocaleString('pt-BR',{minimumFractionDigits:2})}</td>
<td>${parseFloat(r.ipi_total || 0).toLocaleString('pt-BR',{minimumFractionDigits:2})}</td>
<td>${parseFloat(r.fecp_total || 0).toLocaleString('pt-BR',{minimumFractionDigits:2})}</td>

<td>
<a href="gerar_danfe.php?xml=${r.arquivo}" 
target="_blank"
class="btn btn-sm btn-primary">
Imprimir DANFE
</a>
</td>

</tr>
`;

});

let html = `

<div class="row mb-4">

<div class="col-6 col-md-3 col-lg-2 mb-3">
<div class="card text-bg-primary">
<div class="card-body">
<h6>Notas</h6>
<h4>${totalNotas}</h4>
</div>
</div>
</div>

<div class="col-6 col-md-3 col-lg-2 mb-3">
<div class="card text-bg-primary">
<div class="card-body">
<h6>Valor Total</h6>
<h4>R$ ${vtotal.toLocaleString('pt-BR',{minimumFractionDigits:2})}</h4>
</div>
</div>
</div>

<div class="col-6 col-md-3 col-lg-2 mb-3">
<div class="card text-bg-success">
<div class="card-body">
<h6>ICMS</h6>
<h4>R$ ${icms.toLocaleString('pt-BR',{minimumFractionDigits:2})}</h4>
</div>
</div>
</div>

<div class="col-6 col-md-3 col-lg-2 mb-3">
<div class="card text-bg-warning">
<div class="card-body">
<h6>PIS</h6>
<h4>R$ ${pis.toLocaleString('pt-BR',{minimumFractionDigits:2})}</h4>
</div>
</div>
</div>

<div class="col-6 col-md-3 col-lg-2 mb-3">
<div class="card text-bg-danger">
<div class="card-body">
<h6>COFINS</h6>
<h4>R$ ${cofins.toLocaleString('pt-BR',{minimumFractionDigits:2})}</h4>
</div>
</div>
</div>

<div class="col-6 col-md-3 col-lg-2 mb-3">
<div class="card text-bg-info">
<div class="card-body">
<h6>IPI</h6>
<h4>R$ ${ipi.toLocaleString('pt-BR',{minimumFractionDigits:2})}</h4>
</div>
</div>
</div>

<div class="col-6 col-md-3 col-lg-2 mb-3">
<div class="card text-bg-dark">
<div class="card-body">
<h6>FECP</h6>
<h4>R$ ${fecp.toLocaleString('pt-BR',{minimumFractionDigits:2})}</h4>
</div>
</div>
</div>

</div>

<div class="card shadow">

<div class="card-body">

<h4>Notas analisadas</h4>

<div class="table-responsive">

<table class="table table-striped">

<thead class="table-dark">

<tr>
<th>Empresa</th>
<th>CNPJ</th>
<th>Número</th>
<th>Valor</th>
<th>ICMS</th>
<th>PIS</th>
<th>COFINS</th>
<th>IPI</th>
<th>FECP</th>
<th>PDF</th>
</tr>

</thead>

<tbody>

${linhas}

</tbody>

</table>

</div>

</div>

</div>

`;

document.getElementById("resultado").innerHTML = html;

}


function limparTemp(){

if(!confirm("Deseja apagar todos os arquivos da pasta TEMP?")){
return;
}

$("#barraTemp").css("width","0%");
$("#barraTemp").text("0%");

$.get("listar_temp.php", function(resp){

let arquivos = JSON.parse(resp);

if(arquivos.length === 0){
alert("Nenhum arquivo na pasta TEMP");
return;
}

let total = arquivos.length;
let apagados = 0;

function apagarProximo(){

$.post("limpar_temp.php",{arquivo:arquivos[apagados]},function(){

apagados++;

let progresso = Math.round((apagados/total)*100);

$("#barraTemp").css("width",progresso+"%");
$("#barraTemp").text(progresso+"%");

$("#statusTemp").text(
"Apagando arquivo "+apagados+" de "+total
);

if(apagados < total){

apagarProximo();

}else{

$("#statusTemp").text("Limpeza concluída");
atualizarContadorTemp();

}

});

}

apagarProximo();

});

}

function atualizarContadorTemp(){

$.get("listar_temp.php", function(resp){

let arquivos = JSON.parse(resp);

$("#contadorTemp").html(
"Arquivos salvos no geral: <b>"+arquivos.length+"</b>"
);

});

}

</script>

</body>
</html>