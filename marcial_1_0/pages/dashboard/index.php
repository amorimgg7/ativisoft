<?php
    session_start();
    require_once '../../classes/conn.php';
    include("../../classes/functions.php");

    if(!isset($_SESSION['cd_pessoa']))
    {
        echo '<script>location.href="'.$_SESSION['dominio'].'/pages/samples/login.php";</script>';
        exit; 
    }

    

    $u = new Usuario();
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Painel Marcial</title>

        <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
        <link rel="stylesheet" href="../../css/style.css">
<style>
    .card-box {
    border-radius: 12px;
    color: #fff;
    margin-bottom: 15px;
    padding: 12px;

    height: 90px; /* altura do retângulo */

    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.card-box h3 {
    margin: 0;
    font-size: 1.8rem;
    font-weight: bold;
}

.card-box p {
    margin: 2px 0 0;
    font-size: 0.85rem;
}

.bg-arte { background: #3f51b5; color: #fff}
.bg-aluno { background: #009688; color: #fff}
.bg-treino { background: #ff9800; }
.bg-exame { background: #9c27b0; }



</style>
    </head>

    <body>

        <div class="container-scroller">

            <?php include("../../partials/_navbar.php"); ?>
            <div class="container-fluid page-body-wrapper">
            <?php include("../../partials/_sidebar.php"); ?>

                <div class="main-panel">
                    <div class="content-wrapper">

                        <!-- DATA -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <h4>Bem-vindo, <?= $_SESSION['pnome_pessoa'] ?></h4>
                                <p id="data-atual"></p>
                            </div>
                        </div>

                        <script>
                            let data = new Date();
                            document.getElementById("data-atual").innerHTML =
                            "Hoje é " + data.toLocaleDateString('pt-BR');
                        </script>

                        <!-- CARDS -->
                         
                        <?php

                        $stmt = $pdo->prepare("
    SELECT
        ct.*,
        v.tipo_vinculo,
        v.dt_inicio,
        v.dt_fim,
        v.ativo
    FROM tb_vinculo v
    INNER JOIN tb_ct_marcial ct
        ON ct.cd_ct_marcial = v.cd_ct_marcial
    WHERE v.cd_pessoa = :cd_pessoa
    ORDER BY ct.nome_ct
");

$stmt->execute([
    ':cd_pessoa' => $_SESSION['cd_pessoa']
]);

$academias = $stmt->fetchAll(PDO::FETCH_ASSOC);



if (count($academias) > 0) {

    echo '<div class="row">';

    foreach ($academias as $academia) {
      echo '<div class="col-md-4">';
      echo '<div class="card mb-3">';
      echo '<div class="card-body">';
      echo '<h5>'.$academia['nome_ct'].'</h5>';
      echo '<p><strong>Vínculo:</strong> '.$academia['tipo_vinculo'].'</p>';
      echo '<p><strong>Status:</strong> '.($academia['ativo'] ? 'Ativo' : 'Inativo').'</p>';
      if (!empty($academia['dt_inicio'])) {
        echo '<p><strong>Início:</strong> '.date('d/m/Y', strtotime($academia['dt_inicio'])).'</p>';
      }
      echo '</div>';
      // Botões
      echo '<div class="row justify-content-center">';
      echo ($academia['tipo_vinculo'] == 'ADMIN'                  ? '<div class="col-4"><a href="../md_admin/index.php" class="btn btn-warning w-100 mr-2">Admin</a></div>' : '');
      echo ($academia['tipo_vinculo'] == 'ALUNO'                  ? '<div class="col-4"><a href="../md_aluno/index.php" class="btn btn-warning w-100 mr-2">Aluno</a></div><div class="col-4"><a href="../md_simulado/index.php" class="btn bg-treino w-100 mr-2">Simulado</a></div>' : '');
      echo ($academia['tipo_vinculo'] == 'INSTRUTOR'              ? '<div class="col-4"><a href="../md_instrutor/index.php" class="btn bg-arte w-100 mr-2">Instrutor</a></div> <div class="col-4"><a href="../md_aluno/listar.php" class="btn bg-aluno w-100 mr-2">Gerenciar Alunos</a></div>' : '');
      echo ($academia['tipo_vinculo'] == 'AUXILIAR DE INSTRUTOR'  ? '<div class="col-4"><a href="../md_auxiliar_de_instrutor/index.php" class="btn btn-warning w-100 mr-2">Auxiliar de Instrutor</a></div>' : '');
      echo ($academia['tipo_vinculo'] == 'MESTRE'                 ? '<div class="col-4"><a href="../md_mestre/index.php" class="btn btn-warning w-100 mr-2">Mestre</a></div>' : '');
      echo ($academia['tipo_vinculo'] == 'GRÃO MESTRE'            ? '<div class="col-4"><a href="../md_grao_mestre/index.php" class="btn btn-warning w-100 mr-2">Grão Mestre</a></div>' : '');
      echo ($academia['tipo_vinculo'] == 'COMPETIDOR'             ? '<div class="col-4"><a href="../md_competidor/index.php" class="btn btn-warning w-100 mr-2">Competidor</a></div>' : '');
      echo '</div>';
      echo '</div>';
      echo '</div>';
    }

    echo '</div>';

} else {

    echo '<div class="alert alert-warning">';
    echo 'Você não possui vínculo com nenhuma academia.';
    echo '</div>';

}


                            if($_SESSION['perfil'] == "ADMIN"){
                                include '../../pages/md_admin/index.php';
                                include '../../pages/md_instrutor/index.php';
                                include '../../pages/md_aluno/index.php';
                            }
                            if($_SESSION['perfil'] == "INSTRUTOR"){
                                include '../../pages/md_instrutor/index.php';
                            }
                            if($_SESSION['perfil'] == "ALUNO"){
                                include '../../pages/md_aluno/index.php';
                            }
                        ?>
                        

                    <!-- AÇÕES RÁPIDAS -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card p-3">
                                <h5>Ações Rápidas</h5>
                                <a href="../md_aluno/listar.php" class="btn bg-aluno">Gerenciar Alunos</a>
                                <a href="../md_treinos/index.php" class="btn btn-warning">Treinos</a>
                                <!--<a href="../md_estudos/index.php" class="btn btn-warning">Estudos</a>-->
                                <!--<a href="../exames/index.php" class="btn btn-dark">Exames</a>
                                <a href="../competicoes/index.php" class="btn btn-success">Competições</a>-->
                            </div>
                        </div>
                    </div>

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