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
                            
                                <?php
                                    //echo '<div class="row flex-grow">';
                                    echo '<div class="col-12 grid-margin stretch-card btn-dark" style="display:none;">'; //
                                    echo '<div class="card" '.$_SESSION['c_card'].'>';
                                    echo '<div class="card-body">';
                                    echo '<h4 class="card-title">Consulte o caixa pelo período!</h4>';
                                    echo '<div class="collapse" style="display:block;">';
                                    echo '<form action="impresso.php" method="POST" target="_blank">';
                                    echo '<h4 class="card-title">Ferramentas</h4>';

                                    echo '<div>';

                                    echo '</div>';

                                    echo '<div class="form-group">';
                                    echo '<div class="input-group">';
                                    echo '<div class="input-group-prepend">';
                                    echo '<span class="input-group-text btn-outline-info">INÍCIO</span>';
                                    echo '</div>';
                                    echo '<input name="dt_inicio" type="date" id="dt_inicio" class="form-control form-control-sm" required/>';
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
                                    echo '<input name="dt_fim" type="date" id="dt_fim" class="form-control form-control-sm"/>';
                                    echo '<div class="input-group-append">';
                                    //echo '<span class="input-group-text">.00</span>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '<button type="submit" name="rel_fechamento_caixa" id="rel_fechamento_caixa" class="btn btn-lg btn-block btn-outline-warning" style="margin: 5px;"><i class="mdi mdi-file-check"></i>Consultar</button>';
                                    echo '</form>';
                                    echo '</div> ';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '<div class="col-12 grid-margin stretch-card btn-dark">'; //
                                    echo '<div class="card" ' . $_SESSION['c_card'] . '>';
                                    echo '<div class="card-body">';
                                    echo '<h4 class="card-title">Listagem de Caixas</h4>';
                                    echo '<div class="collapse" style="display:block;">';

                                    //$select_caixa_lista = "SELECT * FROM tb_caixa WHERE DATE(dt_abertura) >= '".$dt_inicio."' AND DATE(dt_abertura) <= '".$dt_fim."' ORDER by cd_caixa ASC";
                                    $select_caixa_lista = "SELECT * FROM tb_caixa where status_caixa > 0 ORDER by cd_caixa DESC";
                



                                    //À FAZER
                                    //"SELECT marca_patrimonio, modelo_patrimonio, COUNT(*) AS total FROM tb_patrimonio WHERE tipo_patrimonio = 'Impressora' GROUP BY marca_patrimonio, modelo_patrimonio";
                                    //$sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 0";


                                    $resulta_caixa = $conn->query($select_caixa_lista);
                                    if ($resulta_caixa->num_rows > 0){
                                    
                
                                        echo '<div class="card-body">';
                                    

                
                                        echo '<div class="collapse table-responsive" style="display:block;">';
                
                                        echo '<table class="table" '.$_SESSION['c_card'].'>';
                                        echo '<thead>';
                                        echo '<tr>';
                                        echo '<th>Caixa</th>';
                                        echo '<th>Abertura</th>';
                                        echo '<th>Fechamento</th>';
                
                                        echo '</tr>';
                                        echo '</thead>';
                                        echo '<tbody>';
                                        while ( $caixa = $resulta_caixa->fetch_assoc()){
                                            echo '<tr>';
                                            echo '<form method="POST" action="form_conf_caixa.php">';
                                            echo '<td style="display: none;"><input type="tel" id="con_conf_cd_caixa" name="con_conf_cd_caixa" value="'.$caixa['cd_caixa'].'"></td>';
                                            echo '<td><button type="submit" class="btn btn-outline-dark" name="btn_cd_'.$caixa['cd_caixa'].'" id="btn_cd_'.$caixa['cd_caixa'].'">'.$caixa['cd_caixa'].'</button></td>';
                                            echo '</form>';

                                            echo '<td><label>'.date('d/m/y', strtotime($caixa['dt_abertura'])).'</label></td>';
                                            echo '<td><label>'.date('d/m/y', strtotime($caixa['dt_fechamento'])).'</label></td>';

                                        }
                                        echo '</tbody>';
                                        echo '</table>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                    echo '</div> ';
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