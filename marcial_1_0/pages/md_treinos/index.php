<?php
    session_start();
    if(!isset($_SESSION['cd_pessoa']))
    {
        echo '<script>location.href="'.$_SESSION['dominio'].'index.php";</script>';
        exit; 
    }
    
    require_once '../../classes/conn.php';
    include("../../classes/functions.php");
    
    $u = new Usuario();
    
    // ================= DATAS =================
    $hoje = date('Y-m-d');
    
    // semana
    $inicioSemana = date('Y-m-d', strtotime('monday this week'));
    $fimSemana = date('Y-m-d', strtotime('sunday this week'));
    
    // mês
    $inicioMes = date('Y-m-01');
    $fimMes = date('Y-m-t');
    
    // filtro
    $dataInicio = $_GET['data_inicio'] ?? null;
    $dataFim = $_GET['data_fim'] ?? null;
    
    // ================= QUERIES =================
    
    // HOJE
    $treinosHoje = $pdo->prepare("SELECT * FROM tb_treino WHERE DATE(data_treino) = ?");
    $treinosHoje->execute([$hoje]);
    
    // SEMANA
    $treinosSemana = $pdo->prepare("SELECT * FROM tb_treino WHERE DATE(data_treino) BETWEEN ? AND ?");
    $treinosSemana->execute([$inicioSemana, $fimSemana]);
    
    // MÊS
    $treinosMes = $pdo->prepare("SELECT * FROM tb_treino WHERE DATE(data_treino) BETWEEN ? AND ?");
    $treinosMes->execute([$inicioMes, $fimMes]);
    
    // FILTRO
    $treinosFiltro = null;
    if($dataInicio && $dataFim){
        $treinosFiltro = $pdo->prepare("SELECT * FROM tb_treino WHERE DATE(data_treino) BETWEEN ? AND ?");
        $treinosFiltro->execute([$dataInicio, $dataFim]);
    }
    
    // ================= CARDS =================
    $totalAlunos = $pdo->query("SELECT COUNT(*) FROM tb_vinculo WHERE tipo_vinculo='ALUNO'")->fetchColumn();
    $totalInstrutores = $pdo->query("SELECT COUNT(*) FROM tb_vinculo WHERE tipo_vinculo='INSTRUTOR'")->fetchColumn();
    $totalTreinos = $pdo->query("SELECT COUNT(*) FROM tb_treino")->fetchColumn();
    $totalExames = $pdo->query("SELECT COUNT(*) FROM tb_exame_graduacao")->fetchColumn();
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
                padding: 20px;
                color: #fff;
                margin-bottom: 20px;
            }
            .bg-arte { background: #3f51b5; }
            .bg-aluno { background: #009688; }
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
                        <!-- FILTRO -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="card p-3">
                                    <form method="GET">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Data Inicial</label>
                                                <input type="date" name="data_inicio" class="form-control" value="<?= $dataInicio ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label>Data Final</label>
                                                <input type="date" name="data_fim" class="form-control" value="<?= $dataFim ?>">
                                            </div>
                                            <div class="col-md-4 d-flex align-items-end">
                                                <button class="btn btn-primary w-100">Filtrar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- CARDS -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card-box bg-aluno">
                                    <h3><?= $totalAlunos ?></h3>
                                    <p>Alunos</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card-box bg-arte">
                                    <h3><?= $totalInstrutores ?></h3>
                                    <p>Instrutores</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card-box bg-treino">
                                    <h3><?= $totalTreinos ?></h3>
                                    <p>Treinos</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card-box bg-exame">
                                    <h3><?= $totalExames ?></h3>
                                    <p>Exames de Faixa</p>
                                </div>
                            </div>
                        </div>
                        <!-- TREINOS -->
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <div class="card p-3">
                                    <h5>Treinos de Hoje</h5>
                                    <?php foreach($treinosHoje as $t): ?>
                                        <p>📌 <?= $t['descricao'] ?> - <?= date('d/m H:i', strtotime($t['data_treino'])) ?></p>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card p-3">
                                    <h5>Treinos da Semana</h5>
                                    <?php foreach($treinosSemana as $t): ?>
                                        <p>📅 <?= $t['descricao'] ?> - <?= date('d/m H:i', strtotime($t['data_treino'])) ?></p>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card p-3">
                                    <h5>Treinos do Mês</h5>
                                    <?php foreach($treinosMes as $t): ?>
                                        <p>🗓️ <?= $t['descricao'] ?> - <?= date('d/m H:i', strtotime($t['data_treino'])) ?></p>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <!-- RESULTADO FILTRO -->
                        <?php if($treinosFiltro): ?>
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="card p-3">
                                        <h5>Resultado do Filtro</h5>
                                        <?php 
                                            $hoje = date('Y-m-d');
                                            foreach($treinosFiltro as $t): 
                                            $dataTreino = date('Y-m-d', strtotime($t['data_treino']));
                                        ?>
                                        <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                            <div>
                                            🔎 <?= $t['descricao'] ?> - <?= date('d/m H:i', strtotime($t['data_treino'])) ?>
                                            </div>
                                            <?php if($dataTreino == $hoje): ?>
                                                <a href="lancar_presenca.php?id=<? $t['cd_treino'] ?>" class="btn btn-success btn-sm">
                                                ✔ Lançar Presença
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
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