<?php
session_start();
require_once '../../classes/conn.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login - Sistema Marcial</title>

<link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
<link rel="stylesheet" href="../../vendors/feather/feather.css">
<link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
<link rel="stylesheet" href="../../css/style.css">

<link rel="shortcut icon" href="../../images/logo.png" />

<style>
body {
  background: linear-gradient(135deg, #1e3c72, #2a5298);
}
.auth-form-light {
  background: rgba(255,255,255,0.95);
  border-radius: 12px;
}
</style>

</head>

<body>

<div class="container-scroller">
<div class="container-fluid page-body-wrapper full-page-wrapper">
<div class="content-wrapper d-flex align-items-center auth px-0">

<div class="row w-100 mx-0">
<div class="col-lg-4 mx-auto">

<div class="auth-form-light text-left py-5 px-4 px-sm-5">

<!-- FRASE -->
<?php
echo '<h4>"Disciplina supera talento"</h4>';
echo '<h6 class="font-weight-light">Treine todos os dias 🥋</h6>';
?>

<!-- FORM -->
<form class="pt-3" method="POST">

<div class="form-outline mb-4">
<input type="text" class="form-control" name="login" id="login" placeholder="Login ou Email">
</div>

<div class="form-outline mb-4">
<input type="password" class="form-control" name="senha" id="senha" placeholder="Senha">
</div>

<div class="mt-3">
<input class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" 
type="submit" onclick="submitForm()" value="ACESSAR">
</div>

<div class="my-2 d-flex justify-content-between align-items-center">
<div class="form-check">
<label class="form-check-label text-muted">
<input type="checkbox" id="rememberMe" class="form-check-input">
Lembrar
</label>
</div>
</div>

</form>

<!-- GOOGLE LOGIN (OPCIONAL) -->
<div class="text-center mt-3">

<div id="g_id_onload"
data-client_id="SEU_CLIENT_ID_AQUI"
data-callback="handleCredentialResponse">
</div>

<div class="g_id_signin"></div>

</div>

<script src="https://accounts.google.com/gsi/client" async defer></script>

<script>
function handleCredentialResponse(response) {
    const data = parseJwt(response.credential);

    fetch("login_google.php", {
        method: "POST",
        headers: {"Content-Type":"application/json"},
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(result => {
        if(result.success){
            window.location.href = "../dashboard/index.php";
        }
    });
}

function parseJwt(token) {
    let base64Url = token.split('.')[1];
    let base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    let jsonPayload = decodeURIComponent(atob(base64).split('').map(c =>
        '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2)
    ).join(''));
    return JSON.parse(jsonPayload);
}
</script>

<!-- PROCESSAMENTO LOGIN -->
<?php
if (isset($_POST['login']) && isset($_POST['senha']))
{
    require_once '../../classes/functions.php';

    $u = new Usuario();

    $login = addslashes($_POST['login']);
    $senha = addslashes($_POST['senha']);

    if (!empty($login) && !empty($senha))
    {
        $u->conectar();

        if ($msgErro == "")
        {
            include("../../partials/load.html");

            if($u->logar($login, $senha))
            {
                echo '<div class="msg-sucesso">Entrando...</div>';
                echo '<script>location.href="../dashboard/index.php";</script>';
                exit;
            }
            else
            {
                echo '<div class="msg-erro">Login ou senha incorretos!</div>'; 
            }
        }
        else
        {
            echo '<div class="msg-erro">Erro: '.$msgErro.'</div>';
        }
    }
    else
    {
        echo '<div class="msg-erro">Preencha todos os campos!</div>';
    }
}
?>

</div>
</div>
</div>

</div>
</div>
</div>

<!-- REMEMBER -->
<script>
function submitForm() {
  let login = document.getElementById("login").value;
  let senha = document.getElementById("senha").value;
  let remember = document.getElementById("rememberMe").checked;

  if (remember) {
    localStorage.setItem("login", login);
    localStorage.setItem("senha", senha);
  } else {
    localStorage.removeItem("login");
    localStorage.removeItem("senha");
  }
}

window.onload = function() {
  let login = localStorage.getItem("login");
  let senha = localStorage.getItem("senha");

  if (login && senha) {
    document.getElementById("login").value = login;
    document.getElementById("senha").value = senha;
    document.getElementById("rememberMe").checked = true;
  }
}
</script>

<script src="../../vendors/base/vendor.bundle.base.js"></script>
<script src="../../js/off-canvas.js"></script>
<script src="../../js/template.js"></script>

</body>
</html>