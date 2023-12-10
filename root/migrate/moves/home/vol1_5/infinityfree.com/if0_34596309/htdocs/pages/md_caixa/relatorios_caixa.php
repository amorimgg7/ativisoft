<?php 
    session_start(); 
    //if(!isset($_SESSION['cd_colab']))
    //{
    //    header("location: ../../pages/samples/login.php");
    //    exit;
    //}
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
        <?php include ("../../partials/_navbar.php");?>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <?php include ("../../partials/_sidebar.php");?>
            <!-- partial -->
            <div class="main-panel">        
                <div class="content-wrapper" <?php echo $_SESSION['c_body'];?>>
                    <div class="row">
                        <div class="col-sm-12 mb-4 mb-xl-0">
                            <script>
                                document.getElementById("c_body").style = '<?php echo $_SESSION['c_body'];?>';
                                document.getElementById("c_card").style = '<?php echo $_SESSION['c_card'];?>';
                            </script>
                        <p><?php echo $_SESSION['c_body'];?></p>
                        <p><?php echo $_SESSION['c_card'];?></p>
                            <p class="font-weight-normal mb-2 text-muted"><span id="data-atual"></span></p>
                            <script>
                                var data = new Date();
                                var mesPorExtenso = new Intl.DateTimeFormat('pt-BR', { month: 'long' }).format(data).toUpperCase();
                                var dia = data.getDate();
                                var ano = data.getFullYear();
                                document.getElementById("data-atual").innerHTML = 'HOJE É '+dia + ' DE ' + mesPorExtenso + ', ' + ano;
                            </script>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-xl-3 flex-column d-flex grid-margin stretch-card">
                            <div class="row flex-grow">
                                <?php
                                    echo '<div class="col-12 grid-margin stretch-card btn-dark">';//
                                    echo '<div class="card" '.$_SESSION['c_card'].'>';
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
                                    echo '<input value="'.date('d/m/Y H:i', strtotime('+1 hour')).'" name="dt_emissao" type="text" id="dt_emissao" class="aspNetDisabled form-control form-control-sm" readonly/>';
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






                                    $sql_describe = "DESCRIBE tb_caixa";
$result_describe = mysqli_query($conn, $sql_describe);

$found_start = false;

if ($result_describe) {
    while ($row_describe = mysqli_fetch_assoc($result_describe)) {
        if ($row_describe['Field'] == 'diferenca_caixa') {
            $found_start = true;
            continue; // Começar a coleta após encontrar a coluna "diferenca_caixa"
        }
        
        if ($found_start && $row_describe['Field'] == 'status_caixa') {
            break; // Parar a coleta após encontrar a coluna "status_caixa"
        }
        
        if ($found_start) {
            $column_name = str_replace('fpag_', '', $row_describe['Field']);
            echo $column_name . "<br>";
        }
    }
} else {
    echo "Erro na consulta: " . mysqli_error($conn);
}


                                    
                                    










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