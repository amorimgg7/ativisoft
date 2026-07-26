<?php
session_start();
require_once '../../classes/conn.php';

// ================= SALVAR =================
if($_POST){

    $pdo->beginTransaction();

    try{

        // ================= PESSOA =================
        $stmt = $pdo->prepare("
            INSERT INTO tb_pessoa (
                pnome_pessoa, snome_pessoa, sexo_pessoa, cpf_pessoa,
                dt_nasc_pessoa, tel_pessoa, email_pessoa, senha_pessoa,
                dt_cadastro
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ");

        $stmt->execute([
            $_POST['pnome'],
            $_POST['snome'],
            $_POST['sexo'],
            $_POST['cpf'],
            $_POST['dt_nasc'],
            $_POST['tel'],
            $_POST['email'],
            password_hash($_POST['senha'], PASSWORD_DEFAULT)
        ]);

        $cd_pessoa = $pdo->lastInsertId();

        // ================= VÍNCULOS =================
        if(isset($_POST['vinculos'])){
            foreach($_POST['vinculos'] as $v){

                if(empty($v['cd_ct_marcial'])) continue;

                $stmt = $pdo->prepare("
                    INSERT INTO tb_vinculo (
                        cd_pessoa, cd_ct_marcial, tipo_vinculo,
                        dt_inicio, ativo
                    ) VALUES (?, ?, ?, ?, 'ATIVO')
                ");

                $stmt->execute([
                    $cd_pessoa,
                    $v['cd_ct_marcial'],
                    $v['tipo'],
                    $v['dt_inicio']
                ]);
            }
        }

        $pdo->commit();

        header("Location: index.php");
        exit;

    } catch(Exception $e){
        $pdo->rollBack();
        echo "Erro: " . $e->getMessage();
    }
}

// ================= ACADEMIAS =================
$academias = $pdo->query("SELECT cd_ct_marcial, nome_ct FROM tb_ct_marcial")->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Novo Aluno</title>

<link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
<link rel="stylesheet" href="../../vendors/feather/feather.css">
<link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
<link rel="stylesheet" href="../../vendors/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="../../css/style.css">

</head>

<body>

<div class="container-scroller">

<?php include("../../partials/_navbar.php"); ?>
<div class="container-fluid page-body-wrapper">
<?php include("../../partials/_sidebar.php"); ?>

<div class="main-panel">
<div class="content-wrapper">

<h3 class="mb-4">Novo Aluno</h3>

<form method="POST">

<!-- ================= DADOS ================= -->
<div class="card p-3 mb-3">
<h5>Dados do Aluno</h5>

<div class="row">

<div class="col-md-4">
<label>Primeiro Nome</label>
<input type="text" name="pnome" class="form-control" required>
</div>

<div class="col-md-4">
<label>Sobrenome</label>
<input type="text" name="snome" class="form-control">
</div>

<div class="col-md-4">
<label>Sexo</label>
<select name="sexo" class="form-control">
<option value="">Selecione</option>
<option>M</option>
<option>F</option>
</select>
</div>

<div class="col-md-4 mt-2">
<label>CPF</label>
<input type="text" name="cpf" class="form-control">
</div>

<div class="col-md-4 mt-2">
<label>Data Nascimento</label>
<input type="date" name="dt_nasc" class="form-control">
</div>

<div class="col-md-4 mt-2">
<label>Telefone</label>
<input type="text" name="tel" class="form-control">
</div>

<div class="col-md-6 mt-2">
<label>Email</label>
<input type="email" name="email" class="form-control">
</div>

<div class="col-md-6 mt-2">
<label>Senha</label>
<input type="password" name="senha" class="form-control">
</div>

</div>
</div>

<!-- ================= VINCULOS ================= -->

<!-- ================= SALVAR ================= -->
<button class="btn btn-success">
<i class="fa fa-save"></i> Salvar
</button>

</form>

</div>
<?php
                    include("../../partials/_footer.php");
                ?>
            </div>

        </div>
    </div>


    
  <!-- container-scroller -->

  <!-- base:js -->
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