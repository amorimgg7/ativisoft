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
    <title>Análise de caixa</title>
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
                <div class="content-wrapper" <?php echo $_SESSION['c_body'];?>>
                    <div class="row">
                        <div class="col-sm-12 mb-4 mb-xl-0">
                            <?php
                                if(isset($_POST['con_conf_cd_caixa']))
                                {
                                    echo '<h1>Conferir Caixa Passado</h1>';
                                    $select_caixa_conferido = "SELECT * FROM tb_caixa WHERE cd_caixa = '".$_POST['con_conf_cd_caixa']."'";
                                    //echo '<h3>'.$dia_hoje.'</h3>';
                                    //insert into tb_caixa(dt_abertura, cd_colab_abertura, saldo_abertura, status_caixa) VALUES('2023-08-12T13:00','1','15','0')
                                    $resulta_caixa_conferido = $conn->query($select_caixa_conferido);
                                    if ($resulta_caixa_conferido->num_rows > 0){ 
                                        //echo '<div class="col-lg-6 grid-margin stretch-card" style="background-color: #FF0000;">';//dia anterior aberto
                                        
                                        echo '<div class="card" '.$_SESSION['c_card'].'';
                                        echo '<div class="card-body">';
                                          
                                        echo '<h4 class="card-title">Dados Analíticos</h4>';
                                        echo '<div class="table-responsive">';
                                        echo '<table class="table">';
                                        echo '<thead>';
                                        echo '<tr>';
                                        echo '<th>Abertura</th>';
                                        echo '<th>Fechamento</th>';
                                        echo '<th>Responsável</th>';
                                        echo '<th>Total Abertura</th>';
                                        echo '<th>Saldo Movimento</th>';
                                        echo '<th>Total Fechamento</th>'; 
                                        echo '</tr>';
                                        echo '</thead>';
                                        echo '<tbody>';
                                        while ( $row_caixa_conferido = $resulta_caixa_conferido->fetch_assoc()){
                                            $_SESSION['cd_caixa_conferido'] = $row_caixa_conferido['cd_caixa'];
                                            echo '<tr>';
                                            echo '<td>'.date('d/m/y H:i', strtotime($row_caixa_conferido['dt_abertura'])).'</td>';
                                            echo '<td>'.date('d/m/y H:i', strtotime($row_caixa_conferido['dt_fechamento'])).'</td>';
                                            
                                            //echo '<td>'.$row_caixa['dt_abertura'].'/'.$row_caixa['dt_fechamento'].'</td>';
                                            $select_responsavel_conferido = "SELECT * FROM tb_colab WHERE cd_colab = '".$row_caixa_conferido['cd_colab_abertura']."'";
                                            //insert into tb_caixa(dt_abertura, cd_colab_abertura, saldo_abertura, status_caixa) VALUES('2023-08-12T13:00','1','15','0')
                                            $resulta_responsavel_conferido = $conn->query($select_responsavel_conferido);
                                            while ($row_responsavel_conferido = $resulta_responsavel_conferido->fetch_assoc()){
                                                echo '<td>'.$row_responsavel_conferido['pnome_colab'].' '.$row_responsavel_conferido['snome_colab'].'</td>';
                                            }
                                            $total_abertura_caixa = $row_caixa_conferido['saldo_abertura'];
                                            echo '<td>R$: '.$row_caixa_conferido['saldo_abertura'].'</td>';
                                            echo '<td>R$: '.$row_caixa_conferido['total_movimento'].'</td>';
                                            echo '<td>R$: '.$row_caixa_conferido['saldo_fechamento'].'</td>';
                                        }
                                        echo '</tr>';
                                        echo '</tbody>';
                                        echo '</table>';
                                        echo '</div>';
                                        
                                        
                                        $select_caixa_conferido2 = "SELECT * FROM tb_caixa_conferido WHERE cd_caixa_analitico = '".$_POST['con_conf_cd_caixa']."'";

                                        $resulta_caixa_conferido2 = $conn->query($select_caixa_conferido2);
                                        if ($resulta_caixa_conferido2->num_rows > 0){ 
                                            //echo '<div class="col-lg-6 grid-margin stretch-card" style="background-color: #FF0000;">';//dia anterior aberto

                                            echo '<h4 class="card-title">Conferencias realizadas</h4>';
                                            echo '<div class="table-responsive">';
                                            echo '<table class="table">';
                                            
                                            echo '<thead>';
                                            echo '<tr>';
                                            echo '<th>CD</th>';
                                            echo '<th>Data Conferencia</th>';
                                            echo '<th>Responsável Conferencia</th>';
                                            echo '<th>Abertura Conferida</th>';
                                            echo '<th>Movimento Conferido</th>';
                                            echo '<th>Fechamento Conferido</th>';
                                            echo '<th>OBS Conferencia</th>'; 
                                            echo '</tr>';
                                            echo '</thead>';
                                            echo '<tbody>';
                                            while ( $row_caixa_conferido2 = $resulta_caixa_conferido2->fetch_assoc()){
                                                echo '<tr>';
                                                echo '<td>'.$row_caixa_conferido2['cd_caixa_conferido'].'</td>';
                                                
                                                echo '<td>'.date('d/m/y H:i', strtotime($row_caixa_conferido2['dt_conferencia'])).'</td>';
                                                
                                                
                                                //echo '<td>'.$row_caixa['dt_abertura'].'/'.$row_caixa['dt_fechamento'].'</td>';
                                                $select_responsavel_conferido = "SELECT * FROM tb_colab WHERE cd_colab = '".$row_caixa_conferido2['cd_colab_conferencia']."'";
                                                //insert into tb_caixa(dt_abertura, cd_colab_abertura, saldo_abertura, status_caixa) VALUES('2023-08-12T13:00','1','15','0')
                                                $resulta_responsavel_conferido = $conn->query($select_responsavel_conferido);
                                                while ($row_responsavel_conferido = $resulta_responsavel_conferido->fetch_assoc()){
                                                    echo '<td>'.$row_responsavel_conferido['pnome_colab'].' '.$row_responsavel_conferido['snome_colab'].'</td>';
                                                }
                                                echo '<td>R$: '.$row_caixa_conferido2['saldo_abertura_conferido'].'</td>';
                                                echo '<td>R$: '.$row_caixa_conferido2['saldo_movimento_conferido'].'</td>';
                                                echo '<td>R$: '.$row_caixa_conferido2['saldo_fechamento_conferido'].'</td>';
                                                echo '<td>R$: '.$row_caixa_conferido2['obs_conferencia'].'</td>';
                                            }
                                            echo '</tbody>';
											echo '</table>';
	                                        echo '</div>';


											
	                                    }
											echo '</div>';
											echo '</div>';	
                                    }





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

                                echo '<h4 class="card-title" id="soma_sangria">.</h4>';

                                echo '<h4 class="card-title" id="soma_suprimento">.</h4>';

                                echo '<h2 class="card-title" style="font-size: 24px;" id="soma_total">.</h2>';


								$select_movimento_grafico = "SELECT * FROM tb_movimento_financeiro WHERE cd_caixa = '".$_SESSION['cd_caixa_conferido']."'";
                                $resulta_caixa_conferido = $conn->query($select_caixa_conferido);
                                if ($resulta_caixa_conferido->num_rows > 0)
								{ 
									while ( $row_caixa_conferido = $resulta_caixa_conferido->fetch_assoc())
									{
										$_SESSION['cd_caixa_conferido'] = $row_caixa_conferido['cd_caixa'];
									}
								}



                                
                                if (isset($_POST['con_conf_cd_caixa'])) {
                                    //$query_count_0 = "SELECT * FROM tb_servico WHERE status_servico = '0' AND cd_cliente = '".$_SESSION['acompanha_cd_cliente']."'";
                                    //$query_fpag_dinheiro = "SELECT COUNT(*) as count_dinheiro FROM tb_movimento_financeiro WHERE date(data_movimento) = '09/09/2023' and fpag_movimento = 'DINHEIRO'" . $_SESSION['acompanha_cd_cliente'] . "'";
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

                                    $query_fpag_sangria = "SELECT SUM(valor_sangria) as soma_sangria 
                                        FROM tb_movimento_financeiro 
                                        WHERE cd_caixa_movimento = '".$_SESSION['cd_caixa_conferido']."' 
                                        AND tipo_movimento = 3";

                                    $query_fpag_suprimento = "SELECT SUM(valor_suprimento) as soma_suprimento 
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
                                    session_start();
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

                                    if ($row_fpag_sangria['soma_sangria'] > 0) {
                                        $_SESSION['soma_sangria'] = $row_fpag_sangria['soma_sangria'];
                                        echo '<script>document.getElementById("soma_sangria").innerHTML = "Sangria: R$'.$row_fpag_sangria['soma_sangria'].'";</script>';//
                                        $_SESSION['soma_total'] = $_SESSION['soma_total'] + $_SESSION['soma_sangria'];
                                        //$_SESSION['count3'] = 25;
                                        //echo '<script>var count3 = 25;</script>';
                                    } else {
                                        echo '<script>document.getElementById("soma_sangria").innerHTML = "";</script>';//
                                        $_SESSION['soma_sangria'] = 0;
                                    }

                                    if ($row_fpag_suprimento['soma_suprimento'] > 0) {
                                        $_SESSION['soma_suprimento'] = $row_fpag_suprimento['soma_suprimento'];
                                        echo '<script>document.getElementById("soma_suprimento").innerHTML = "Suprimento: R$'.$row_fpag_suprimento['soma_suprimento'].'";</script>';//
                                        $_SESSION['soma_total'] = $_SESSION['soma_total'] - $_SESSION['soma_sangria'];
                                        //$_SESSION['count3'] = 25;
                                        //echo '<script>var count3 = 25;</script>';
                                    } else {
                                        echo '<script>document.getElementById("soma_cofre").innerHTML = "";</script>';//
                                        $_SESSION['soma_cofre'] = 0;
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
                                }
                                ?>

                                


                                <?php
                                echo '</div> ';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';

								








                        if (isset($_POST['con_conf_cd_caixa']))
                        {
                                    ?>	

							<div class="col-sm-6 grid-margin stretch-card">
								<div class="card">
									<div class="card-body">



									<?php

									echo '<h4 class="card-title">Movimentação</h4>';
                                          echo '<div class="table-responsive">';
                                          echo '<table class="table">';
                                          echo '<thead>';
                                          echo '<tr>';
                                          echo '<th>Tipo</th>';
                                          echo '<th>Valor Movimento</th>';
                                          echo '<th>Forma de Pagamento</th>';
                                          echo '<th>OBS</th>'; 
                                          echo '</tr>';
                                          echo '</thead>';
                                          echo '<tbody>';


									$select_movimento_caixa = "SELECT * FROM tb_movimento_financeiro WHERE cd_caixa_movimento = '".$_SESSION['cd_caixa_conferido']."'";
                                          //insert into tb_caixa(dt_abertura, cd_colab_abertura, saldo_abertura, status_caixa) VALUES('2023-08-12T13:00','1','15','0')
                                          $resulta_movimento_caixa = $conn->query($select_movimento_caixa);
                                          while ( $row_movimento_caixa = $resulta_movimento_caixa->fetch_assoc()){
                                              echo '<tr>';
                                              if($row_movimento_caixa['tipo_movimento'] == 1){echo '<td>Receita</td>';}
                                              if($row_movimento_caixa['tipo_movimento'] == 2){echo '<td>Suprimento</td>';}
                                              if($row_movimento_caixa['tipo_movimento'] == 3){echo '<td>Sangria</td>';}
                                              echo '<td>R$: '.$row_movimento_caixa['valor_movimento'].'</td>';
                                              echo '<td>'.$row_movimento_caixa['fpag_movimento'].'</td>';
                                              echo '<td>'.$row_movimento_caixa['obs_movimento'].'</td>';

                                              echo '<form method="POST">';
                                              echo '<td style="display:none;"><input type="tel" value="'.$row_movimento_caixa['cd_movimento'].'" id="cd_movimento" name="cd_movimento"></td>';
                                              echo '<td style="display:none;"><input type="tel" value="'.$row_movimento_caixa['cd_os_movimento'].'" id="cd_os_movimento" name="cd_os_movimento" ></td>';
                                              echo '<td style="display:none;"><input type="tel" value="'.$row_movimento_caixa['valor_movimento'].'" id="valor_servico" name="valor_servico"></td>';
                                              echo '</form>';
                                            }

											echo '</tbody>';
                                            echo '</table>';
                                            echo '</div>';
                                        }
											?>



										
					                </div>
								</div>
					        </div>




                            <div class="col-sm-12 mb-4 mb-xl-0">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="" method="post">
                                            <button type="submit" name="form_confer_movimento" id="form_confer_movimento" class="btn btn-lg btn-block btn-outline-success" style="margin: 5px;"><i class="mdi mdi-file-check"></i>Conferir por movimento financeiro</button>
                                        </form>
                                        <form action="" method="post">
                                            <button type="submit" name="form_confer_totalizadores" id="form_confer_totalizadores" class="btn btn-lg btn-block btn-outline-warning" style="margin: 5px;"><i class="mdi mdi-file-check"></i>Conferir por totalizadores</button>
                                        </form>
                                    </div><!-- form_confer_totalizadores -->
                                </div>
                            </div>



                            <?php













								}else{
									echo "<h3>Consulte um caixa</h3>";
								}
							
							?>

                            
								
							
						</div> <!-- col-sm-12 mb-4 mb-xl-0 -->
					</div><!-- row -->
		        </div><!-- content-wrapper -->
			</div><!-- main-panel -->
	    </div><!-- container-fluid page-body-wrapper -->
	</div><!-- container-scroller -->
    
    <?php
    include("../../partials/_footer.php");
    ?>
    <!-- partial -->
    
    <!-- main-panel ends -->
    
    <!-- page-body-wrapper ends -->
    
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