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

.bg-arte { background: #3f51b5; }
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
                            if($_SESSION['perfil'] == "ADMIN"){
                                $totalAlunos = $pdo->query("SELECT COUNT(*) FROM tb_vinculo WHERE tipo_vinculo='ALUNO'")->fetchColumn();
                                $totalInstrutores = $pdo->query("SELECT COUNT(*) FROM tb_vinculo WHERE tipo_vinculo='INSTRUTOR'")->fetchColumn();
                                $totalTreinos = $pdo->query("SELECT COUNT(*) FROM tb_treino")->fetchColumn();
                                $totalExames = $pdo->query("SELECT COUNT(*) FROM tb_exame_graduacao")->fetchColumn();

                                echo '
                                    <h1>Perfil de administrador</h1>
                                    <div class="row">
                                        <div class="col-6 col-md-3">
                                            <div class="card-box bg-aluno">
                                                <h3>'.$totalAlunos.'</h3>
                                                <p>Alunos</p>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="card-box bg-arte">
                                                <h3>'.$totalInstrutores.'</h3>
                                                <p>Instrutores</p>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="card-box bg-treino">
                                                <h3>'.$totalTreinos.'</h3>
                                                <p>Treinos</p>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="card-box bg-exame">
                                                <h3>'.$totalExames.'</h3>
                                                <p>Exames de Faixa</p>
                                            </div>
                                        </div>
                                    </div>
                                ';

                            }
                            if($_SESSION['perfil'] == "INSTRUTOR"){
                                echo '<h1>Perfil de Instrutor</h1>';
                            }
                            if($_SESSION['perfil'] == "ALUNO"){
                                echo '<h1>Perfil de Aluno</h1>';
                            }
                        ?>
                        

                    <!-- AÇÕES RÁPIDAS -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card p-3">
                                <h5>Ações Rápidas</h5>
                                <a href="../md_aluno/index.php" class="btn bg-aluno">Gerenciar Alunos</a>
                                <a href="../md_treinos/index.php" class="btn btn-warning">Treinos</a>
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