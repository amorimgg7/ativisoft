
<?php

session_start();
$dia_hoje = date('Y-m-d'); // Formatando a data de hoje para o formato do banco de dados (ano-mês-dia)

require_once '../../classes/conn_revenda.php';
require_once '../../classes/conn.php';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" >

  <!-- Required meta tags --> 
  <meta charset="utf-8">
  
  <!--<meta http-equiv="refresh" content="5;url=../samples/lock-screen.php">-->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
  <title>AtiviSoft</title>
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
  <link rel="shortcut icon" href="<?php echo $_SESSION['logo_empresa']; ?>" />
  <script>
                document.getElementById("c_body").style = '<?php echo $_SESSION['c_body'];?>';
                document.getElementById("c_card").style = '<?php echo $_SESSION['c_card'];?>';
              </script>
  
  <script src="https://sdk.mercadopago.com/js/v2"></script>
</head>
<script src="../../js/functions.js"></script>
<body onmousemove="resetTimer()" onclick="resetTimer()" onkeypress="resetTimer()">
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <?php include ("../../partials/_navbar.php");?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <?php include ("../../partials/_sidebar.php");?>
      <!-- partial -->
      <div class="main-panel" >
        <div class="content-wrapper" <?php echo $_SESSION['c_body'];?>>
          <div class="row">
            <div class="col-sm-12 mb-4 mb-xl-0">
            </div></div>


    


<?php

    $select_cliente_comercial = "SELECT * FROM tb_cliente_comercial where cnpj_cliente_comercial = ".$_SESSION['cnpj_filial'];
    $resulta_cliente_comercial = $conn_revenda->query($select_cliente_comercial);
    if ($resulta_cliente_comercial->num_rows > 0){ 
        while ( $cliente_matriz = $resulta_cliente_comercial->fetch_assoc()){
            $_SESSION['rsocial_fatura'] = $cliente_matriz['rsocial_cliente_comercial'];
            $_SESSION['nfantasia_fatura'] = $cliente_matriz['nfantasia_cliente_comercial'];
            $_SESSION['cnpj_fatura'] = $cliente_matriz['cnpj_cliente_comercial'];
            $_SESSION['email_fatura'] = $cliente_matriz['email_cliente_comercial'];
            $_SESSION['valor_fatura'] = $cliente_matriz['fatura_prevista_cliente_fiscal'];
            $data_fornecida = $cliente_matriz['dtvalidlicenca_cliente_comercial'];
            $diferenca_dias = round((strtotime($data_fornecida) - strtotime($dia_hoje)) / (60 * 60 * 24), 2);
            //$diferenca_dias = number_format(floatval($diferenca_dias), 2);
            $_SESSION['fatura_prevista'] = number_format(floatval($_SESSION['valor_fatura'] + (-$diferenca_dias)), 2);
        }
    }

    include 'tratar_payment.php';

?>
<!--
    <h2><?php //echo 'R$: '.$_SESSION['valor_fatura']. ' + R$: '. number_format(floatval(-$diferenca_dias), 2);?></h4>
    <h4>Multa de R$: 1,00 por dia</h4>
    <h1>Valor a Pagar: R$: <?php //echo $_SESSION['fatura_prevista'];?></h1>
  -->

  
  
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
                
        <div class="card-body">
          <div class="grid-margin stretch-card">
            <h4>Dados de Pagamento</h4>
          </div>
          <div class="table-responsive">
                
            <table class="table">
              <thead>
                <tr>
                  <th>Forma de Pagamento</th>
                  <th>Nome</th>
                  <th>CNPJ</th>
                  <th>Email</th>
                  <th>Valor</th>
                  <th>Multa</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                <tr><!---->
                  <form method="POST">
                    <?php //gerencianet/examples/pix/cob/pixCreateImmediateCharge.php
                      echo '<td><button type="submit" class="btn btn-danger" name="tratar_pix" id="tratar_pix">PIX</button></td>';
                      echo '<td>'.$_SESSION['rsocial_fatura'].'<input style="display:none;" type="text" id="nome" name="nome" value="'.$_SESSION['rsocial_fatura'].'" readonly></td>';
                      echo '<td>'.$_SESSION['cnpj_fatura'].'<input style="display:none;" type="text" id="cnpj" name="cnpj" value="'.$_SESSION['cnpj_fatura'].'" readonly></td>';
                      echo '<td>'.$_SESSION['email_fatura'].'<input style="display:none;" type="text" value="'.$_SESSION['email_fatura'].'" readonly></td>';
                      echo '<td>R$: '.$_SESSION['valor_fatura'].'<input style="display:none;" type="text" id="licenca" name="licenca" value="'.$_SESSION['valor_fatura'].'" readonly></td>';
                      echo '<td>R$: '.number_format(floatval(-$diferenca_dias), 2).'<input style="display:none;" type="text" id="multa" name="multa" value="'.-$diferenca_dias.'" readonly></td>';
                      echo '<td>R$: '.$_SESSION['fatura_prevista'].'<input style="display:none;" type="text" id="valor" name="valor" value="'.$_SESSION['fatura_prevista'].'" readonly></td>';
                    ?>
                  </form>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>


    <?php
  if(isset($_POST['tratar_pix'])){
    
    echo '<div class="col-lg-12 grid-margin stretch-card">';
    echo '<div class="card">';
                
    echo '<div class="card-body">';
    echo '<div class="grid-margin stretch-card">';
    echo '<h4>PIX</h4>';
    echo '</div>';
    echo '<div class="table-responsive">';
                
    echo '<table class="table">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>QR</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    echo '<tr><!---->';
    //gerencianet/examples/pix/cob/pixCreateImmediateCharge.php
    include 'gerencianet/examples/pix/cob/pixCreateImmediateCharge.php';
    echo '</tr>';
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    
  }
  
  ?>
  
  <script>
  	function copiarTexto1() {
	    var textarea = document.getElementById('link1');
    	textarea.select();
    	document.execCommand('copy');
    	//alert('Conteúdo copiado para a área de transferência!');
  	}
	</script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" ></script>


</div>

        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <?php include("../../partials/_footer.php");?>
        <!--
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © sistma.com 2023</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://localhost/_1_1_sistema" target="_blank">Sistema.com</a> from 1.1</span>
          </div>
          <span class="text-muted d-block text-center text-sm-left d-sm-inline-block mt-2">Distributed By: <a href="https://www.themewagon.com/" target="_blank">ThemeWagon</a></span>
        </footer>
    -->
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
        



