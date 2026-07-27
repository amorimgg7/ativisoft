<?php
session_start();
require_once '../../classes/conn.php';

// ================= BUSCA =================
$busca = $_GET['busca'] ?? '';

if ($busca) {

    $stmt = $pdo->prepare("
        SELECT
            p.*,

            v.cd_vinculo,
            v.tipo_vinculo,
            v.ativo AS vinculo_ativo,

            ct.cd_ct_marcial,
            ct.nome_ct,

            am.cd_arte_marcial,
            am.nome_arte,

            g.cd_graduacao,
            g.nome_graduacao,
            g.cor,
            g.ordem

        FROM tb_pessoa p

        LEFT JOIN tb_vinculo v
            ON v.cd_pessoa = p.cd_pessoa

        LEFT JOIN tb_ct_marcial ct
            ON ct.cd_ct_marcial = v.cd_ct_marcial

        LEFT JOIN tb_arte_marcial am
            ON am.cd_arte_marcial = v.cd_arte_marcial

        LEFT JOIN tb_aluno_graduacao ag
            ON ag.cd_vinculo = v.cd_vinculo

        LEFT JOIN tb_graduacao g
            ON g.cd_graduacao = ag.cd_graduacao

        WHERE p.pnome_pessoa LIKE ?

        ORDER BY p.pnome_pessoa,
                 g.ordem DESC
    ");

    $stmt->execute(["%{$busca}%"]);

} else {

    $stmt = $pdo->query("
        SELECT
            p.*,

            v.cd_vinculo,
            v.tipo_vinculo,
            v.ativo AS vinculo_ativo,

            ct.cd_ct_marcial,
            ct.nome_ct,

            am.cd_arte_marcial,
            am.nome_arte,

            g.cd_graduacao,
            g.nome_graduacao,
            g.cor,
            g.ordem

        FROM tb_pessoa p

        LEFT JOIN tb_vinculo v
            ON v.cd_pessoa = p.cd_pessoa

        LEFT JOIN tb_ct_marcial ct
            ON ct.cd_ct_marcial = v.cd_ct_marcial

        LEFT JOIN tb_arte_marcial am
            ON am.cd_arte_marcial = v.cd_arte_marcial

        LEFT JOIN tb_aluno_graduacao ag
            ON ag.cd_vinculo = v.cd_vinculo

        LEFT JOIN tb_graduacao g
            ON g.cd_graduacao = ag.cd_graduacao

        ORDER BY p.pnome_pessoa,
                 g.ordem DESC
    ");
}

$alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  

  <!-- Required meta tags --> 
  <meta charset="utf-8">
  <meta>
  <!--<meta http-equiv='refresh' content='30'>-->
  <!--<meta http-equiv="refresh" content="5;url=../samples/lock-screen.php">-->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

  <title>Dashboard</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">


  <!-- endinject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="../../vendors/flag-icon-css/css/flag-icon.min.css"/>
  <link rel="stylesheet" href="../../vendors/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../../vendors/jquery-bar-rating/fontawesome-stars-o.css">
  <link rel="stylesheet" href="../../vendors/jquery-bar-rating/fontawesome-stars.css"> 
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <!-- endinject -->
  <link rel="manifest" href="manifest.json">


  <style>
    #installBtn {
      display: none;
    }
  </style>

  

  <script>
    document.getElementById("c_body").style = '<?php echo $_SESSION['c_body'];?>';
    document.getElementById("c_card").style = '<?php echo $_SESSION['c_card'];?>';
  </script>
  

</head>

<body>

<div class="container-scroller">

<?php include("../../partials/_navbar.php"); ?>

<div class="container-fluid page-body-wrapper">

<?php include("../../partials/_sidebar.php"); ?>

<div class="main-panel">
<div class="content-wrapper">

<h3 class="mb-4">Gerenciar Alunos</h3>

<!-- AÇÕES -->
<div class="row mb-3">

<div class="col-md-4">
<a href="cadastro.php" class="btn btn-primary w-100">
<i class="fa fa-plus"></i> Novo Aluno
</a>
</div>

<div class="col-md-8">
<form method="GET">
<div class="input-group">
<input type="text" name="busca" class="form-control" placeholder="Buscar aluno..." value="<?= $busca ?>">
<div class="input-group-append">
<button class="btn btn-secondary">
<i class="fa fa-search"></i>
</button>
</div>
</div>
</form>
</div>

</div>

<!-- LISTA -->
<div class="card p-3">

<div class="table-responsive">
<table class="table table-hover">

<thead>
<tr>
<th>ID</th>
<th>Nome</th>
<th>Ações</th>
<th>Graduação</th>
</tr>
</thead>

<tbody>

<?php foreach($alunos as $a): ?>
<tr>
<td><?= $a['cd_pessoa'] ?></td>
<td><?= $a['pnome_pessoa'] ?></td>
<td><?= $a['nome_graduacao'].$a['cor'] ?></td>


<td>
<a href="editar.php?id=<?= $a['cd_pessoa'] ?>" class="btn btn-warning btn-sm">
<i class="fa fa-edit"></i> Editar
</a>
</td>

</tr>
<?php endforeach; ?>

</tbody>

</table>
</div>

</div>

</div>
</div>

</div>
</div>


<?php
          include("../../partials/_footer.php");
        ?>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <!--<footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © sistma.com 2023</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://localhost/_1_1_sistema" target="_blank">Sistema.com</a> from 1.1</span>
          </div>
          <span class="text-muted d-block text-center text-sm-left d-sm-inline-block mt-2">Distributed By: <a href="https://www.themewagon.com/" target="_blank">ThemeWagon</a></span>
        </footer>-->
        
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
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