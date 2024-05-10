<?php
session_start();
if (!isset($_SESSION['cd_colab'])) {
    header("location: ../../pages/samples/login.php");
    exit;
}
require_once '../../classes/conn.php';
include("../../classes/functions.php");
$u = new Usuario;

?><!--Validar sessão aberta, se usuário está logado.-->

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Abrir Caixa</title>
    <!-- base:css -->
    <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../vendors/feather/feather.css">
    <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../../css/style.css">
  <link rel="shortcut icon" href="<?php echo $_SESSION['dominio'].'pages/web/imagens/'.$_SESSION['cnpj_empresa'].'/Logos/LogoEmpresa.jpg'; ?>" /><!--$_SESSION['dominio'].'pages/samples/lock-screen.php';-->

    <!-- endinject -->
    <script src="../../js/functions.js"></script>
    <link rel="shortcut icon" href="<?php echo $_SESSION['logo_empresa']; ?>" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>




</head>

<!--<body onmousemove="resetTimer()" onclick="resetTimer()" onkeypress="resetTimer()">-->

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <?php include("../../partials/_navbar.php"); ?>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <?php include("../../partials/_sidebar.php"); ?>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper" <?php echo $_SESSION['c_body']; ?>>
                    <div class="row">
                        <div class="col-sm-12 mb-4 mb-xl-0">
                            <script>
                                document.getElementById("c_body").style = '<?php echo $_SESSION['c_body']; ?>';
                                document.getElementById("c_card").style = '<?php echo $_SESSION['c_card']; ?>';
                            </script>
                            <p>
                                <?php echo $_SESSION['c_body']; ?>
                            </p>
                            <p>
                                <?php echo $_SESSION['c_card']; ?>
                            </p>
                            <p class="font-weight-normal mb-2 text-muted"><span id="data-atual"></span></p>
                            <script>
                                var data = new Date();
                                var mesPorExtenso = new Intl.DateTimeFormat('pt-BR', { month: 'long' }).format(data).toUpperCase();
                                var dia = data.getDate();
                                var ano = data.getFullYear();
                                document.getElementById("data-atual").innerHTML = 'HOJE É ' + dia + ' DE ' + mesPorExtenso + ', ' + ano;
                            </script>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-xl-3 flex-column d-flex grid-margin stretch-card">
                            <div class="row flex-grow">
                                <?php
                                    echo '<div class="col-12 grid-margin stretch-card btn-dark">'; //
                                    echo '<div class="card" ' . $_SESSION['c_card'] . '>';
                                    echo '<div class="card-body">';
                                    echo '<h4 class="card-title">Emissão de fechamento de caixa e dia fiscal por período</h4>';
                                    echo '<div class="collapse" style="display:block;">';
                                    echo '<form action="impresso.php" method="POST" target="_blank">';
                                    echo '<h4 class="card-title">Ferramentas</h4>';

                                    echo '<div>';

                                    echo '<div class="form-group">';
                                    echo '<div class="input-group">';
                                    echo '<div class="input-group-prepend">';
                                    echo '<span class="input-group-text btn-outline-info">EMISSÃO</span>';
                                    echo '</div>';
                                    echo '<input value="' . date('d/m/Y H:i', strtotime('+1 hour')) . '" name="dt_emissao" type="text" id="dt_emissao" class="aspNetDisabled form-control form-control-sm" readonly/>';
                                    echo '<div class="input-group-append">';
                                    //echo '<span class="input-group-text">.00</span>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';

                                    echo '<div class="form-group row justify-content-center">';
                                    echo '    <div class="col text-center">';
                                    echo '        <p class="mb-2 card-title">Por dia Fiscal</p>';
                                    echo '        <label class="toggle-switch toggle-switch-dark">';
                                    echo '            <input name="dia_fiscal_check" id="dia_fiscal_check" type="checkbox" onclick="handleCheckboxClick(\'dia_fiscal_check\', \'dia_caixa_check\');">';
                                    echo '            <span class="toggle-slider round"></span>';
                                    echo '        </label>';
                                    echo '    </div>';
                                    echo '    <div class="col text-center">';
                                    echo '        <p class="mb-2 card-title">Por Caixa</p>';
                                    echo '        <label class="toggle-switch toggle-switch-dark">';
                                    echo '            <input name="dia_caixa_check" id="dia_caixa_check" type="checkbox" onclick="handleCheckboxClick(\'dia_caixa_check\', \'dia_fiscal_check\');">';
                                    echo '            <span class="toggle-slider round"></span>';
                                    echo '        </label>';
                                    echo '    </div>';
                                    echo '</div>';
                                    echo '<script>';
                                    echo '    function handleCheckboxClick(checkboxClicked, otherCheckbox) {';
                                    echo '        const clickedCheckbox = document.getElementById(checkboxClicked);';
                                    echo '        const otherCheckboxElement = document.getElementById(otherCheckbox);';
                                    echo '';
                                    echo '        if (clickedCheckbox.checked) {';
                                    echo '            otherCheckboxElement.checked = false;';
                                    echo '        }';
                                    echo '    }';
                                    echo '</script>';
                                    echo '<script>';
                                    echo '    const checkboxes = document.querySelectorAll(\'input[type="checkbox"]\');';
                                    echo '    checkboxes.forEach(checkbox => {';
                                    echo '        checkbox.addEventListener(\'change\', () => {';
                                    echo '            if (document.querySelectorAll(\'input[type="checkbox"]:checked\').length === 0) {';
                                    echo '                checkboxes.forEach(cb => {';
                                    echo '                    cb.setCustomValidity(\'Selecione pelo menos uma opção\');';
                                    echo '                });';
                                    echo '            } else {';
                                    echo '                checkboxes.forEach(cb => {';
                                    echo '                    cb.setCustomValidity(\'\');';
                                    echo '                });';
                                    echo '            }';
                                    echo '        });';
                                    echo '    });';
                                    echo '</script>';


                                    //echo '<div class="col">';
                                    //echo '<p class="mb-2 card-title">Ocorrências</p>';
                                    //echo '<label class="toggle-switch toggle-switch-success">';
                                    //echo '<input type="checkbox" checked>';
                                    //echo '<span class="toggle-slider round"></span>';
                                    //echo '</label>';
                                    //echo '</div>';
                                    

                                    echo '</div>';

                                    echo '<div class="form-group">';
                                    echo '<div class="input-group">';
                                    echo '<div class="input-group-prepend">';
                                    echo '<span class="input-group-text btn-outline-info">INÍCIO</span>';
                                    echo '</div>';
                                    echo '<input name="dt_inicio" type="date" id="dt_inicio" class="aspNetDisabled form-control form-control-sm" required/>';
                                    echo '<div class="input-group-append">';
                                    //echo '<span class="input-group-text">.00</span>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';

                                    echo '<div class="form-group">';
                                    echo '<div class="input-group">';
                                    echo '<div class="input-group-prepend">';
                                    echo '<span class="input-group-text btn-outline-info">FIM</span>';
                                    echo '</div>';
                                    echo '<input name="dt_fim" type="date" id="dt_fim" class="aspNetDisabled form-control form-control-sm"/>';
                                    echo '<div class="input-group-append">';
                                    //echo '<span class="input-group-text">.00</span>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';




                                    echo '</div>';

                                    echo '<button type="submit" name="rel_fechamento_caixa" id="rel_fechamento_caixa" class="btn btn-lg btn-block btn-outline-warning" style="margin: 5px;"><i class="mdi mdi-file-check"></i>Imprimir Relatório</button>';


                                    echo '</form>';




                                    echo '</div> ';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';





                                    //GRÁFICO DE CAIXA
                                    echo '<div class="col-sm-6 grid-margin stretch-card">'; //
                                    echo '<div class="card" '.$_SESSION['c_card'].'>';
                                    echo '<div class="card-body">';
                                    echo '<h4 class="card-title">Balanço do caixa '.$_SESSION['cd_caixa_conferido'].'</h4>';
                                    echo '<div class="collapse" style="display:block;">';

                                    echo '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';

                                    echo '<canvas id="pieChart"></canvas>';
                                    
                                    echo '<h4 class="card-title" id="soma_dinheiro">.<h4>';

                                    echo '<h4 class="card-title" id="soma_debito">.</h4>';

                                    echo '<h4 class="card-title" id="soma_credito">.</h4>';

                                    echo '<h4 class="card-title" id="soma_pix">.</h4>';

                                    echo '<h4 class="card-title" id="soma_cofre">.</h4>';

                                    echo '<h4 class="card-title" id="soma_suprimento">.</h4>';

                                    echo '<h4 class="card-title" id="soma_sangria">.</h4>';

                                    echo '<h2 class="card-title" style="font-size: 24px;" id="soma_total">.</h2>';


                                    $query_fpag_dinheiro = "SELECT SUM(valor_movimento) as soma_dinheiro 
                                        FROM tb_movimento_financeiro 
                                        WHERE cd_caixa_movimento = '".$_SESSION['cd_caixa_conferido']."' 
                                        AND fpag_movimento = 'DINHEIRO' AND tipo_movimento = 1";
                                        
                                    $query_fpag_debito = "SELECT SUM(valor_movimento) as soma_debito 
                                        FROM tb_movimento_financeiro 
                                        WHERE cd_caixa_movimento = '".$_SESSION['cd_caixa_conferido']."' 
                                        AND fpag_movimento = 'debito'";

                                    $query_fpag_credito = "SELECT SUM(valor_movimento) as soma_credito 
                                        FROM tb_movimento_financeiro 
                                        WHERE cd_caixa_movimento = '".$_SESSION['cd_caixa_conferido']."' 
                                        AND fpag_movimento = 'credito'";

                                    $query_fpag_pix = "SELECT SUM(valor_movimento) as soma_pix 
                                        FROM tb_movimento_financeiro 
                                        WHERE cd_caixa_movimento = '".$_SESSION['cd_caixa_conferido']."' 
                                        AND fpag_movimento = 'pix'";

                                    $query_fpag_cofre = "SELECT SUM(valor_movimento) as soma_cofre 
                                        FROM tb_movimento_financeiro 
                                        WHERE cd_caixa_movimento = '".$_SESSION['cd_caixa_conferido']."' 
                                        AND fpag_movimento = 'cofre'";

                                    $query_fpag_sangria = "SELECT SUM(valor_movimento) as soma_sangria 
                                        FROM tb_movimento_financeiro 
                                        WHERE cd_caixa_movimento = '".$_SESSION['cd_caixa_conferido']."' 
                                            AND tipo_movimento = 3";

                                    $query_fpag_suprimento = "SELECT SUM(valor_movimento) as soma_suprimento 
                                        FROM tb_movimento_financeiro 
                                        WHERE cd_caixa_movimento = '".$_SESSION['cd_caixa_conferido']."' 
                                        AND tipo_movimento = 2";


                                    $result_soma_dinheiro = mysqli_query($conn, $query_fpag_dinheiro);
                                    $result_soma_debito = mysqli_query($conn, $query_fpag_debito);
                                    $result_soma_credito = mysqli_query($conn, $query_fpag_credito);
                                    $result_soma_pix = mysqli_query($conn, $query_fpag_pix);
                                    $result_soma_cofre = mysqli_query($conn, $query_fpag_cofre);
                                    $result_soma_sangria = mysqli_query($conn, $query_fpag_sangria);
                                    $result_soma_suprimento = mysqli_query($conn, $query_fpag_suprimento);

                                    $row_fpag_dinheiro = mysqli_fetch_assoc($result_soma_dinheiro);
                                    $row_fpag_debito = mysqli_fetch_assoc($result_soma_debito);
                                    $row_fpag_credito = mysqli_fetch_assoc($result_soma_credito);
                                    $row_fpag_pix = mysqli_fetch_assoc($result_soma_pix);
                                    $row_fpag_cofre = mysqli_fetch_assoc($result_soma_cofre);
                                    $row_fpag_sangria = mysqli_fetch_assoc($result_soma_sangria);
                                    $row_fpag_suprimento = mysqli_fetch_assoc($result_soma_suprimento);

                                    // Exibe as informações do usuário no formulário
                                        
                                    $_SESSION['soma_total'] = 0;
                                    if ($row_fpag_dinheiro['soma_dinheiro'] > 0) {
                                        $_SESSION['soma_dinheiro'] = $row_fpag_dinheiro['soma_dinheiro'];
                                        echo '<script>document.getElementById("soma_dinheiro").innerHTML = "Dinheiro: R$'.$row_fpag_dinheiro['soma_dinheiro'].'";</script>';//
                                        $_SESSION['soma_total'] = $_SESSION['soma_total'] + $_SESSION['soma_dinheiro'];
                                        //$_SESSION['count0'] = 25;
                                    } else {
                                        echo '<script>document.getElementById("soma_dinheiro").innerHTML = "";</script>';//
                                        $_SESSION['soma_dinheiro'] = 0;
                                    }
                                    if ($row_fpag_debito['soma_debito'] > 0) {
                                        $_SESSION['soma_debito'] = $row_fpag_debito['soma_debito'];
                                        echo '<script>document.getElementById("soma_debito").innerHTML = "Débito: R$'.$row_fpag_debito['soma_debito'].'";</script>';//
                                        $_SESSION['soma_total'] = $_SESSION['soma_total'] + $_SESSION['soma_debito'];
                                        //$_SESSION['count1'] = 25;
                                    } else {
                                        echo '<script>document.getElementById("soma_debito").innerHTML = "";</script>';//
                                        $_SESSION['soma_debito'] = 0;
                                    }
                                    if ($row_fpag_credito['soma_credito'] > 0) {
                                        $_SESSION['soma_credito'] = $row_fpag_credito['soma_credito'];
                                        echo '<script>document.getElementById("soma_credito").innerHTML = "Crédito: R$'.$row_fpag_credito['soma_credito'].'";</script>';//
                                        $_SESSION['soma_total'] = $_SESSION['soma_total'] + $_SESSION['soma_credito'];
                                        //$_SESSION['count2'] = 25;
                                    } else {
                                        echo '<script>document.getElementById("soma_credito").innerHTML = "";</script>';//
                                        $_SESSION['soma_credito'] = 0;
                                    }
                                    if ($row_fpag_pix['soma_pix'] > 0) {
                                        $_SESSION['soma_pix'] = $row_fpag_pix['soma_pix'];
                                        echo '<script>document.getElementById("soma_pix").innerHTML = "PIX: R$'.$row_fpag_pix['soma_pix'].'";</script>';//
                                        $_SESSION['soma_total'] = $_SESSION['soma_total'] + $_SESSION['soma_pix'];
                                        //$_SESSION['count3'] = 25;
                                        //echo '<script>var count3 = 25;</script>';
                                    } else {
                                        echo '<script>document.getElementById("soma_pix").innerHTML = "";</script>';//
                                        $_SESSION['soma_pix'] = 0;
                                    }
                                    if ($row_fpag_cofre['soma_cofre'] > 0) {
                                        $_SESSION['soma_cofre'] = $row_fpag_cofre['soma_cofre'];
                                        echo '<script>document.getElementById("soma_cofre").innerHTML = "Cófre: R$'.$row_fpag_cofre['soma_cofre'].'";</script>';//
                                        $_SESSION['soma_total'] = $_SESSION['soma_total'] + $_SESSION['soma_cofre'];
                                        //$_SESSION['count3'] = 25;
                                        //echo '<script>var count3 = 25;</script>';
                                    } else {
                                        echo '<script>document.getElementById("soma_cofre").innerHTML = "";</script>';//
                                        $_SESSION['soma_cofre'] = 0;
                                    }

                                    if ($row_fpag_suprimento['soma_suprimento'] > 0) {
                                        $_SESSION['soma_suprimento'] = $row_fpag_suprimento['soma_suprimento'];
                                        echo '<script>document.getElementById("soma_suprimento").innerHTML = "Suprimento: R$'.$row_fpag_suprimento['soma_suprimento'].'";</script>';//
                                        $_SESSION['soma_total'] = $_SESSION['soma_total'] + $_SESSION['soma_suprimento'];
                                        //$_SESSION['count3'] = 25;
                                        //echo '<script>var count3 = 25;</script>';
                                    } else {
                                        echo '<script>document.getElementById("soma_cofre").innerHTML = "";</script>';//
                                        $_SESSION['soma_cofre'] = 0;
                                    }

                                    if ($row_fpag_sangria['soma_sangria'] > 0) {
                                        $_SESSION['soma_sangria'] = $row_fpag_sangria['soma_sangria'];
                                        echo '<script>document.getElementById("soma_sangria").style.color = "#FF0000";</script>';//
                                        echo '<script>document.getElementById("soma_sangria").innerHTML = "Sangria: R$ - '.$row_fpag_sangria['soma_sangria'].'";</script>';//
                                        $_SESSION['soma_total'] = $_SESSION['soma_total'] - $_SESSION['soma_sangria'];
                                        //$_SESSION['count3'] = 25;
                                        //echo '<script>var count3 = 25;</script>';
                                    } else {
                                        echo '<script>document.getElementById("soma_sangria").innerHTML = "";</script>';//
                                        $_SESSION['soma_sangria'] = 0;
                                    }
                                    echo '<script>document.getElementById("soma_total").innerHTML = "Total: R$" + ' . number_format($_SESSION['soma_total'], 2, ',', '.') . ';</script>';
                                    //echo '<script>document.getElementById("soma_total").innerHTML = "Total: R$'.$_SESSION['soma_total'].'";</script>';//
                                
                                ?>
                                <script>
                                    var ctx = document.getElementById('pieChart').getContext('2d');
                                    var aaa = 26;
                                    var myChart = new Chart(ctx, {
                                        type: 'doughnut',
                                        data: {
                                            labels: ['Dinheiro', 'Débito', 'Crédito', 'Pix', 'Cofre', 'Sangria', 'Suprimento'],
                                            datasets: [{
                                                //data: [<?php //echo $_SESSION['count0'].','.$_SESSION['count1'].','.$_SESSION['count2'].','.$_SESSION['count3']?>], // 25% para cada valor
                                                data: [<?php echo $_SESSION['soma_dinheiro']; ?>, <?php echo $_SESSION['soma_debito']; ?>, <?php echo $_SESSION['soma_credito']; ?>, <?php echo $_SESSION['soma_pix']; ?>, <?php echo $_SESSION['soma_cofre']; ?>, <?php echo $_SESSION['soma_sangria']; ?>, <?php echo $_SESSION['soma_suprimento']; ?>], // 25% para cada valor
                                                backgroundColor: [
                                                    'rgba(75, 192, 192, 0.6)', // Cor para Valor 1
                                                    'rgba(75, 192, 192, 0.6)', // Cor para Valor 2
                                                    'rgba(75, 192, 192, 0.6)', // Cor para Valor 3
                                                    'rgba(75, 192, 192, 0.6)',  // Cor para Valor 4
                                                    'rgba(75, 192, 192, 0.6)',  // Cor para Valor 4
                                                    'rgba(255, 99, 132, 0.6)',
                                                    'rgba(75, 192, 192, 0.6)',
                                                ],
                                                borderColor: [
                                                    'rgba(54, 162, 235, 1)',
                                                    'rgba(54, 162, 235, 1)',
                                                    'rgba(54, 162, 235, 1)',
                                                    'rgba(54, 162, 235, 1)',
                                                    'rgba(54, 162, 235, 1)',
                                                    'rgba(54, 162, 235, 1)'
                                                ],
                                                borderWidth: 1
                                            }]
                                        },
                                        options: {
                                            responsive: false, // Desabilitar responsividade
                                            maintainAspectRatio: false, // Manter proporção do canvas
                                            legend: {
                                                position: 'bottom'
                                            }
                                        }
                                    });
                                                
                                </script>
                                <?php

                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">

            </div>
        </div>
    </div>
    </div>
    <?php
    include("../../partials/_footer.php");
    ?>
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
    <!-- inject:js -->
    <script src="../../js/off-canvas.js"></script>
    <script src="../../js/hoverable-collapse.js"></script>
    <script src="../../js/template.js"></script>
    <!-- endinject -->
    <!-- plugin js for this page -->
    <script src="../../vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <script src="../../vendors/select2/select2.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- Custom js for this page-->
    <script src="../../js/file-upload.js"></script>
    <script src="../../js/typeahead.js"></script>
    <script src="../../js/select2.js"></script>
    <!-- End custom js for this page-->
</body>

</html>