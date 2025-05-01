

<?php
    require_once '../../classes/conn.php'; 
    
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">


<head>

<!-- Bootstrap (Certifique-se de que está incluído no seu projeto) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>



  <!-- Required meta tags -->
  <meta charset="utf-8"> 
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Contrato</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../images/favicon.png" />
  <script src="../../js/functions.js"></script>


  <script>
    // Função para obter os parâmetros da URL
function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param) || null; // Retorna null se não existir
}





</script>



</head>



<body>

<input type="hidden" id="idacesso_hidden" name="idacesso">

<script>
window.onload = function() {
    let idAcesso = getQueryParam("id");
    if (idAcesso) {
        let id_acesso = document.getElementById("id");
        let idacesso_hidden = document.getElementById("idacesso_hidden");

        if (id_acesso) {
            id_acesso.readOnly = true;
            id_acesso.value = idAcesso;
        }

        if (idacesso_hidden) {
            idacesso_hidden.value = idAcesso;
        }
    }
};
</script>

<?php
$idacesso = isset($_GET['id']) ? $_GET['id'] : '';
//echo '<h1>'.$idacesso.'</h1>';
?>


<div class="container-scroller">
<div class="container-fluid page-body-wrapper full-page-wrapper">
<div class="content-wrapper d-flex align-items-center auth px-0">
<div class="row w-100 mx-0">
<body class="col-lg-4 mx-auto">
              

<?php //

  $dia_hoje = date('Y-m-d'); // Formatando a data de hoje para o formato do banco de dados (ano-mês-dia)
  $dia_ontem = date('Y-m-d', strtotime('-1 day'));
  //$dia_hoje = date('Y-m-d H:i', strtotime('+1 hour'));
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['contrato_mensal'])){
    //A - Aberto
    //F - Fechado
    //E - Encerrado
    //C - Cancelado
    //N - Em negociação

    $query_contrato = "SELECT * FROM tb_contrato WHERE (status_contrato = 'A' OR status_contrato = 'N') AND cd_empresa = '".$_SESSION['cd_empresa']."'";
    $result_contrato = mysqli_query($conn, $query_contrato);
    $row_contrato = mysqli_fetch_assoc($result_contrato);

    // Exibe as informações do usuário no formulário
    if($row_contrato) {
        




    } else{
        if(isset($_POST['contrato_mensal'])){
          echo "<script> console.log('Contrato Mensal'); window.alert('Contrato Mensal');</script>";
            echo '<h1>Criar Contrato Mensal</h1>';

            /*

            ds_contrato, cd_acesso, vl_licenca, vl_contrato, dt_contrato, dt_validade, cd_empresa, cd_contratante             

                obs_contrato    - ds_contrato
                id_acesso       - cd_acesso
                vl_licenca      - vl_licenca
                vl_contrato     - vl_contrato
                dt_contrato     - dt_contrato
                dt_vencimento   - dt_validade
                cd_cliente      - cd_empresa
                cd_contratante  - cd_contratante
            */

            $insert_contrato = "INSERT INTO tb_contrato(ds_contrato, cd_acesso, vl_licenca, vl_contrato, dt_contrato, dt_validade, cd_empresa, cd_contratante, status_contrato) VALUES(
                '".$_POST['obs_contrato_mensal']."',
                ".$_POST['id_acesso_mensal'].",
                '".number_format($_POST['vl_licenca_mensal'], 2)."',
                '".number_format($_POST['vl_contrato_mensal'], 2)."',
                '".date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_POST['dt_contrato_mensal'])))."',
                '".date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_POST['dt_vencimento_mensal'])))."',
                ".$_POST['cd_cliente_mensal'].",
                ".$_POST['cd_contratante_mensal'].",
                'A')
                ";
                if(mysqli_query($conn, $insert_contrato)){
                  echo "<script> console.log('Sucesso mensal'); window.alert('Sucesso no contrato mensal');</script>";
                }else{
                  echo "<script> console.log('erro mensal'); window.alert('Erro no contrato mensal');</script>";
                }

        }

        if(isset($_POST['contrato_anual'])){
          echo "<script> console.log('Contrato Anual'); window.alert('Contrato Anual');</script>";

          echo '<h1>Criar Contrato Anual</h1>';

          /*

          ds_contrato, cd_acesso, vl_licenca, vl_contrato, dt_contrato, dt_validade, cd_empresa, cd_contratante             

              obs_contrato    - ds_contrato
              id_acesso       - cd_acesso
              vl_licenca      - vl_licenca
              vl_contrato     - vl_contrato
              dt_contrato     - dt_contrato
              dt_vencimento   - dt_validade
              cd_cliente      - cd_empresa
              cd_contratante  - cd_contratante
          */

          $insert_contrato = "INSERT INTO tb_contrato(ds_contrato, cd_acesso, vl_licenca, vl_contrato, dt_contrato, dt_validade, cd_empresa, cd_contratante, status_contrato) VALUES(
              '".$_POST['obs_contrato_anual']."',
              ".$_POST['id_acesso_anual'].",
              '".number_format($_POST['vl_licenca_anual'], 2)."',
              '".number_format($_POST['vl_contrato_anual'], 2)."',
              '".date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_POST['dt_contrato_anual'])))."',
              '".date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_POST['dt_vencimento_anual'])))."',
              ".$_POST['cd_cliente_anual'].",
              ".$_POST['cd_contratante_anual'].",
              'A')
              ";
              if(mysqli_query($conn, $insert_contrato)){
                echo "<script> console.log('Sucesso anual'); window.alert('Sucesso no contrato Anual');</script>";
              }else{
                echo "<script> console.log('erro anual'); window.alert('Erro no contrato Anual');</script>";
              }

        }

        
    }     
    

}
  
    $select_cliente_comercial = "SELECT * FROM tb_empresa where cd_empresa = ".$_SESSION['cd_empresa'];
    $resulta_cliente_comercial = $conn->query($select_cliente_comercial);
    if ($resulta_cliente_comercial->num_rows > 0){ 
        while ( $cliente_matriz = $resulta_cliente_comercial->fetch_assoc()){

            $select_contrato = "SELECT * FROM tb_contrato where (status_contrato = 'A' OR status_contrato = 'N') AND cd_empresa = ".$_SESSION['cd_empresa'];
            $resulta_contrato = $conn->query($select_contrato);
            if ($resulta_contrato->num_rows > 0){ 
                while ( $row_contrato = $resulta_contrato->fetch_assoc()){
                  switch ($row_contrato['status_contrato']){
                    case "A":
                      echo '<h1>Aberto</h1>';
                      break;
                    case "N":
                      echo '<h1>Em Negociação</h1>';
                      break;
                  }
                  
                                    
                    //echo '<h1 class="card-title">Contrato: '.$row_contrato['cd_contrato'].'</h1>';
                    echo '<div class="col-lg-12 grid-margin stretch-card btn-info">';
                    echo '<div class="card" '.$_SESSION['c_card'].'>';
                    echo '<div class="card-body">';
                    echo '<h2 class="card-title">Escolha sua forma de pagamento</h2>';
                    echo '<div class="table-responsive">';
                    echo '<form method="POST">';
                    echo '<table class="table">';
                    echo '<thead>';
                    echo '<td><button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#ModalGooglePay">Google Pay</button></td>';
                    echo '<td id="mostrar_pix1" name="mostrar_pix1"><button type="submit" id="tratar_pix" name="tratar_pix" class="btn btn-secondary">PIX</button></td>';
                    echo '<td id="mostrar_pix2" name="mostrar_pix2"><button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalPix">PIX Gerado</button></td>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '</table>';
                    echo '<table class="table">';
                    echo '<tbody>';
                    echo '<tr>';
                    echo '<!--<td></td>--><td class="card-title" style="text-align:right;">Nome</td><td>'.$_SESSION['nfantasia_empresa'].'<input style="display:none;" type="text" id="nome" name="nome" value="'.$_SESSION['nfantasia_empresa'].'" readonly></td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<!--<td></td>--><td class="card-title" style="text-align:right;">CNPJ</td><td>'.$_SESSION['cnpj_empresa'].'<input style="display:none;" type="text" id="cnpj" name="cnpj" value="'.$_SESSION['cnpj_empresa'].'" readonly></td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<!--<td></td>--><td class="card-title" style="text-align:right;">Email</td><td>'.$_SESSION['email_filial'].'<input style="display:none;" type="text" value="email@email.com" readonly></td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<!--<td></td>--><td class="card-title" style="text-align:right;">Contrato</td><td>'.$row_contrato['cd_contrato'].'<input style="display:none;" type="text" id="contrato" name="contrato" value="'.$row_contrato['cd_contrato'].'" readonly></td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<!--<td></td>--><td class="card-title" style="text-align:right;">Validade</td><td>'.$row_contrato['dt_validade'].'<input style="display:none;" type="text" id="dt_validade" name="dt_validade" value="'.$row_contrato['dt_validade'].'" readonly></td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<!--<td></td>--><td class="card-title" style="text-align:right;">Subtotal</td><td>R$: '.$row_contrato['vl_licenca'].'<input style="display:none;" type="text" id="licenca" name="licenca" value="'.$row_contrato['vl_licenca'].'" readonly></td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<!--<td></td>--><td class="card-title" style="text-align:right;">Multa</td><td>R$: 0<input style="display:none;" type="text" id="multa" name="multa" value="0" readonly></td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<!--<td></td>--><td class="card-title" style="text-align:right;">Total</td><td>R$: '.$row_contrato['vl_contrato'].'<input style="display:none;" type="text" id="valor" name="valor" value="'.$row_contrato['vl_contrato'].'" readonly></td>';
                    echo '</tr>';
                    echo '</tbody>';
                    echo '</table>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    //echo '<h1>'.$_SESSION['txid'].'</h1>';
                    if(isset($_POST['tratar_pix']) || isset($_SESSION['txid'])){
                      echo '
                        <script>
                          document.addEventListener("DOMContentLoaded", function() {
                            document.getElementById("mostrar_pix1").style.display = "none"; 
                            document.getElementById("mostrar_pix2").style.display = "block"; 
                            var myModal = new bootstrap.Modal(document.getElementById("ModalPix"));
                            myModal.show();
                          });
                        </script>
                      ';
                      echo '<div class="modal fade" id="ModalPix" tabindex="-1" role="dialog" aria-labelledby="PixLabel" aria-hidden="true">';
                      echo '<div class="modal-dialog modal-dialog-centered" role="document">';
                      echo '<div class="modal-content">';
                      echo '<div class="modal-header">';
                      echo '<h5 class="modal-title" id="PixLabel">Pagamento via Pix</h5>';
                      echo '<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">';
                      echo '<span aria-hidden="true">&times;</span>';
                      echo '</button>';
                      echo '</div>';
                      echo '<div class="modal-body">';
                      echo '<div class="table-responsive">'; 
                      echo '<table class="table">';
                      echo '<thead>';
                      //echo '<tr>';
                      //echo '<th>QR</th>';
                      //echo '</tr>';
                      echo '</thead>';
                      echo '<tbody>';
                      echo '<tr>';
                      $select_movimento_financeiro = "SELECT * FROM tb_movimento_financeiro WHERE status_movimento = 0 AND cd_cliente_comercial = '".$_SESSION['cd_empresa']."' ";
                      $result_movimento_financeiro = mysqli_query($conn, $select_movimento_financeiro);
                      $row_movimento_financeiro = mysqli_fetch_assoc($result_movimento_financeiro);
                      // Exibe as informações do usuário no formulário
                      if($row_movimento_financeiro) {
                        $_SESSION['cd_movimento'] = $row_movimento_financeiro['cd_movimento'];
                        $_SESSION['txid'] = $row_movimento_financeiro['key_pay_movimento'];
                        if($row_contrato['vl_contrato'] != $row_movimento_financeiro['valor_movimento']){
                          $update_movimento_financeiro = "UPDATE tb_movimento_financeiro SET
                          valor_movimento = '".$row_contrato['vl_contrato']."'
                          WHERE cd_movimento = ".$_SESSION['cd_movimento'];
                          if(mysqli_query($conn_revenda, $update_movimento_financeiro)){
                            //echo "<script>window.alert('Movimento alterado!');</script>";
                          }else{
                            echo "<script>window.alert('Erro ao alterar o Movimento!');</script>";
                          }
                          include 'gerencianet/examples/pix/cob/pixUpdateCharge.php';
                        }else{
                          include 'gerencianet/examples/pix/cob/pixDetailCharge.php';
                        }
                      }else{
                        include 'gerencianet/examples/pix/cob/pixCreateImmediateCharge.php';
                        $insert_pagar_servico = "INSERT INTO tb_movimento_financeiro(cd_cliente_comercial, cd_filial, fpag_movimento, valor_movimento, data_movimento, obs_movimento, status_movimento, key_pay_movimento) VALUES(
                          ".$_SESSION['cd_empresa'].",
                          ".$_SESSION['cd_empresa'].",
                          'PIX',
                          '".$row_contrato['vl_contrato']."',
                          '".date('Y-m-d H:i')."',
                          'Cliente Gerou o PIX',
                          0,
                          '".$_SESSION['txid']."'
                          )
                        ";
                        if(mysqli_query($conn, $insert_pagar_servico)){
                          //echo "<script>window.alert('Movimento Financeiro Criado!');</script>";
                        }else{
                          echo "<script>window.alert('Erro ao Criar Movimento Financeiro!');</script>";
                        }
                      }
                      echo '</tr>';
                      echo '</tbody>';
                      echo '</table>';
                      echo '</div>';
                      echo '</div>';
                      echo '<div class="modal-footer">';
                      echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>';
                      echo '<button type="button" class="btn btn-primary">Confirmar Pagamento</button>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                    }else{
                      echo '
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                              document.getElementById("mostrar_pix1").style.display = "block"; 
                              document.getElementById("mostrar_pix2").style.display = "none"; 
                            });
                        </script>
                      ';
                    }
                    // Modal Google Pay
                    echo '<div class="modal fade" id="ModalGooglePay" tabindex="-1" role="dialog" aria-labelledby="GooglePayLabel" aria-hidden="true">';
                    echo '<div class="modal-dialog modal-dialog-centered" role="document">';
                    echo '<div class="modal-content">';
                    echo '<div class="modal-header">';
                    echo '<h5 class="modal-title" id="GooglePayLabel">Pagamento via Google Pay</h5>';
                    echo '<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">';
                    echo '<span aria-hidden="true">&times;</span>';
                    echo '</button>';
                    echo '</div>';
                    echo '<div class="modal-body">';
                    echo '<script>';
                    echo '
                      const baseRequest = {
                         apiVersion: 2,
                         apiVersionMinor: 0
                        };
                        const allowedCardNetworks = ["AMEX", "DISCOVER", "INTERAC", "JCB", "MASTERCARD", "VISA"];
                        const allowedCardAuthMethods = ["PAN_ONLY", "CRYPTOGRAM_3DS"];
                        const tokenizationSpecification = {
                          type: "PAYMENT_GATEWAY",
                          parameters: {
                            "gateway": "example",
                            "gatewayMerchantId": "exampleGatewayMerchantId"
                          }
                        };
                        const baseCardPaymentMethod = {
                          type: "CARD",
                          parameters: {
                            allowedAuthMethods: allowedCardAuthMethods,
                            allowedCardNetworks: allowedCardNetworks
                          }
                        };
                        const cardPaymentMethod = Object.assign(
                          {},
                          baseCardPaymentMethod,
                          {
                            tokenizationSpecification: tokenizationSpecification
                          }
                        );
                        let paymentsClient = null;
                        function getGoogleIsReadyToPayRequest() {
                         return Object.assign(
                         {},
                         baseRequest,
                         {
                         allowedPaymentMethods: [baseCardPaymentMethod]
                         }
                        );
                        }
                        function getGooglePaymentDataRequest() {
                        const paymentDataRequest = Object.assign({}, baseRequest);
                        paymentDataRequest.allowedPaymentMethods = [cardPaymentMethod];
                        paymentDataRequest.transactionInfo = getGoogleTransactionInfo();
                        paymentDataRequest.merchantInfo = {
                        // @todo a merchant ID is available for a production environment after approval by Google
                        // See {@link https://developers.google.com/pay/api/web/guides/test-and-deploy/integration-checklist|Integration checklist}
                        // merchantId: "01234567890123456789",
                        merchantName: "Example Merchant"
                        };
                        return paymentDataRequest;
                        }


                        function getGooglePaymentsClient() {
                        if ( paymentsClient === null ) {
                         paymentsClient = new google.payments.api.PaymentsClient({environment: "TEST"});
                        }
                        return paymentsClient;
                        }


                        function onGooglePayLoaded() {
                        const paymentsClient = getGooglePaymentsClient();
                        paymentsClient.isReadyToPay(getGoogleIsReadyToPayRequest())
                        .then(function(response) {
                        if (response.result) {
                         addGooglePayButton();
                         // @todo prefetch payment data to improve performance after confirming site functionality
                         // prefetchGooglePaymentData();
                        }
                        })
                        .catch(function(err) {
                         // show error in developer console for debugging
                         console.error(err);
                        });
                        }


                        function addGooglePayButton() {
                         const paymentsClient = getGooglePaymentsClient();
                         const button =
                         paymentsClient.createButton({onClick: onGooglePaymentButtonClicked});
                         document.getElementById("container").appendChild(button);
                        }


                        function getGoogleTransactionInfo() {
                          return {
                            countryCode: "BR",
                            currencyCode: "BRL",
                            totalPriceStatus: "FINAL",
                            // set to cart total
                            totalPrice: "'.$row_contrato['vl_contrato'].'"
                          };
                        }


                        function prefetchGooglePaymentData() {
                          const paymentDataRequest = getGooglePaymentDataRequest();
                          // transactionInfo must be set but does not affect cache
                          paymentDataRequest.transactionInfo = {
                            totalPriceStatus: "NOT_CURRENTLY_KNOWN",
                            currencyCode: "BRL"
                          };
                          const paymentsClient = getGooglePaymentsClient();
                          paymentsClient.prefetchPaymentData(paymentDataRequest);
                        }


                        function onGooglePaymentButtonClicked() {
                         const paymentDataRequest = getGooglePaymentDataRequest();
                         paymentDataRequest.transactionInfo = getGoogleTransactionInfo();

                         const paymentsClient = getGooglePaymentsClient();
                         paymentsClient.loadPaymentData(paymentDataRequest)
                         .then(function(paymentData) {
                        // handle the response
                         processPayment(paymentData);
                         })
                         .catch(function(err) {
                         // show error in developer console for debugging
                         console.error(err);
                         });
                        }


                        function processPayment(paymentData) {
                         // show returned data in developer console for debugging
                         console.log(paymentData);
                         // @todo pass payment token to your gateway to process payment
                         paymentToken = paymentData.paymentMethodData.tokenizationData.token;
                        }
                    ';
                    echo '</script>';
                    echo 'Detalhes do pagamento via Google Pay aqui...';
                    echo '
                      <div id="container"></div>
                      <script async
                        src="https://pay.google.com/gp/p/js/pay.js"
                        // onload="onGooglePayLoaded()"></script>
                      ';
                    echo '</div>';
                    echo '<div class="modal-footer">';
                    echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>';
                    echo '<button type="button" class="btn btn-primary">Confirmar Pagamento</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    
                    // Modal Pix
                    //echo '<div class="modal fade" id="ModalPix" tabindex="-1" role="dialog" aria-labelledby="PixLabel" aria-hidden="true">';
                    //echo '<div class="modal-dialog modal-dialog-centered" role="document">';
                    //echo '<div class="modal-content">';
                    //echo '<div class="modal-header">';
                    //echo '<h5 class="modal-title" id="PixLabel">Pagamento via Pix</h5>';
                    //echo '<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">';
                    //echo '<span aria-hidden="true">&times;</span>';
                    //echo '</button>';
                    //echo '</div>';
                    //echo '<div class="modal-body">';
                    //echo 'Detalhes do pagamento via Pix aqui...';
                    //echo '</div>';
                    //echo '<div class="modal-footer">';
                    //echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>';
                    //echo '<button type="button" class="btn btn-primary">Confirmar Pagamento</button>';
                    //echo '</div>';
                    //echo '</div>';
                    //echo '</div>';
                    //echo '</div>';
                    



                }
            }else{
              
                $select_acesso = "SELECT * FROM tb_acesso where cd_acesso = '".$idacesso."'";
                $resulta_acesso = $conn->query($select_acesso);
                if ($resulta_acesso->num_rows > 0){ 
                    while ( $row_acesso = $resulta_acesso->fetch_assoc()){
                        //echo '<h1 class="card-title">Sem contrato</h1>';
                        echo '<div class="col-lg-12 grid-margin stretch-card btn-secondary">';//
                        echo '<div class="card">';
                        echo '<div class="card-body">';
                        echo '<div class="table-responsive">';
                        echo '<table class="table">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th><h6 class="card-title">Contrato '.$row_acesso['titulo_acesso'].' ('.$row_acesso['obs_acesso'].')</h6></th>';   
                        echo '</tr>';
                        echo '<tr>';  
                        //echo '<td>-<td>';
                        echo '<td><label class="badge badge-info">Contrato Mensal</label><td>';
                        echo '<td><label class="badge badge-success">Contrato Anual</label><td>';
                        echo '</tr>';
                        $dataAtual = date('d/m/Y'); // Obtém a data atual no formato YYYY-MM-DD
                        $dataFutura = date('d/m/Y', strtotime('+1 month')); // Adiciona um mês à data atual
                        echo '<tr>';  
                        //echo '<td>-<td>';
                        echo '<td><form method="POST">';
                        echo '<input type="hidden" style="display: block;" readonly id="obs_contrato_mensal" name="obs_contrato_mensal" value="'.$row_acesso['obs_acesso'].'">';
                        echo '<input type="hidden" style="display: none;" readonly id="id_acesso_mensal" name="id_acesso_mensal" value="'.$row_acesso['cd_acesso'].'">';
                        echo 'R$ Parcial:<input type="text" style="display: block;" readonly id="vl_licenca_mensal" name="vl_licenca_mensal" value="'.number_format($row_acesso['vl_preco'],2).'">';
                        echo 'R$ Total:<input type="text" style="display: block;" readonly id="vl_contrato_mensal" name="vl_contrato_mensal" value="'.number_format((($row_acesso['vl_preco'])), 2).'">';
                        echo 'Data do contrato<input type="text" style="display: block;" readonly id="dt_contrato_mensal" name="dt_contrato_mensal" value="'.$dataAtual.'">';
                        echo 'Data de vencimento<input type="text" style="display: block;" readonly id="dt_vencimento_mensal" name="dt_vencimento_mensal" value="'.$dataFutura.'">';
                        echo '<input type="hidden" style="display: block;" readonly id="cd_cliente_mensal" name="cd_cliente_mensal" value="'.$_SESSION['cd_empresa'].'">';
                        echo '<input type="hidden" style="display: block;" readonly id="cd_contratante_mensal" name="cd_contratante_mensal" value="'.$_SESSION['cd_pessoa'].'">';
                        echo '<button type="submit" class="btn btn-info" name="contrato_mensal" id="contrato_mensal">Contrato Mensal</button>';
                        echo '</td>';
                        echo '<td>';
                        echo '<input type="hidden" style="display: block;" readonly id="obs_contrato_anual" name="obs_contrato_anual" value="'.$row_acesso['obs_acesso'].'">';
                        echo '<input type="hidden" style="display: none;" readonly id="id_acesso_anual" name="id_acesso_anual" value="'.$row_acesso['cd_acesso'].'">';
                        echo 'R$ Parcial:<input type="text" style="display: block;" readonly id="vl_licenca_anual" name="vl_licenca_anual" value="'.number_format($row_acesso['vl_preco'],2).'">';
                        echo 'R$ Total:<input type="text" style="display: block;" readonly id="vl_contrato_anual" name="vl_contrato_anual" value="'.number_format((($row_acesso['vl_preco'])), 2).'">';
                        echo 'Data do contrato<input type="text" style="display: block;" readonly id="dt_contrato_anual" name="dt_contrato_anual" value="'.$dataAtual.'">';
                        echo 'Data de vencimento<input type="text" style="display: block;" readonly id="dt_vencimento_anual" name="dt_vencimento_anual" value="'.$dataFutura.'">';
                        echo '<input type="hidden" style="display: block;" readonly id="cd_cliente_anual" name="cd_cliente_anual" value="'.$_SESSION['cd_empresa'].'">';
                        echo '<input type="hidden" style="display: block;" readonly id="cd_contratante_anual" name="cd_contratante_anual" value="'.$_SESSION['cd_pessoa'].'">';
                        echo '<button type="submit" class="btn btn-info" name="contrato_anual" id="contrato_anual">Contrato Anual</button>';
                        echo '';
                        echo '</form><td>';                       
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>'; 
                    }
                }
            }

/*
            $data_fornecida = $cliente_matriz['dtvalidlicenca_cliente_comercial'];
            $diferenca_dias = round((strtotime($data_fornecida) - strtotime($dia_hoje)) / (60 * 60 * 24));
            if($diferenca_dias > 5){
            
            }else if($diferenca_dias >= 0){
                echo '<div class="col-lg-12 grid-margin stretch-card btn-secondary">';//
                echo '<div class="card" '.$_SESSION['c_card'].'>';
                echo '<div class="card-body">';
                //echo '<h6 class="card-title">Módulo Geral!</h6>';
                echo '<h6 class="card-title">Tudo certo, criar pagamento opcional.</h6>';
                echo '<h6 class="card-title">Expira em: '.$diferenca_dias.' dia(s).</h6>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            } else if($diferenca_dias < 0){
                echo '<div class="col-lg-12 grid-margin stretch-card btn-warning">';//
                echo '<div class="card" '.$_SESSION['c_card'].'>';
                echo '<div class="card-body">';
                echo '<h6 class="card-title">Criado orcamento para a parcela automaticamente.</h6>';
                echo '<h6 class="card-title">Licenciamento vencido a '.-$diferenca_dias.' dia(s).</h6>';
                echo '<div class="table-responsive">';
                echo '<table class="table">';
                echo '<thead>';      
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                echo '</tbody>';
                echo '</table>';
                //echo '<td><p>Tolerância de 10 dias para multa prevista em contrato</p></td>';
                //echo '<td><label class="badge badge-warning">Parcela prevista: R$:'. $cliente_matriz['fatura_prevista_cliente_fiscal'] .'</label></td>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';  
            }else{
                echo '<div class="col-lg-12 grid-margin stretch-card btn-danger">';//
                echo '<div class="card" '.$_SESSION['c_card'].'>';
                echo '<div class="card-body">';
            
                echo '<div class="table-responsive">';
                echo '<table class="table">';
                echo '<thead>';
                echo '<th>';
                echo '<h6 class="card-title">Licenciamento vencido a '.-$diferenca_dias.' dia(s)</h6>';     
                echo '<h6 class="card-title">Tolerância de 10 dias para multa prevista em contrato</h6>';
                echo '<label class="badge badge-danger">Parcela prevista R$:' . ($cliente_matriz['fatura_prevista_cliente_fiscal'] + (-$diferenca_dias)) . '</label>';
                echo '</th>';
                echo '<th><form method="POST" action="'.$_SESSION['dominio'].'pages/auto_pagamento/payment.php">';
                echo '<input type="text" style="display: none;" readonly id="cd_cliente_comercial_pagamento" name="cd_cliente_comercial_pagamento" value="'.$_SESSION['cd_empresa'].'">';
                echo '<input type="text" style="display: none;" readonly id="cnpj_cliente_comercial_pagamento" name="cnpj_cliente_comercial_pagamento" value="'.$_SESSION['cnpj_empresa'].'">';
                echo '<input type="text" style="display: none;" readonly id="valor_pagamento" name="valor_pagamento" value="'.$cliente_matriz['fatura_prevista_cliente_fiscal'].'">';
                echo '<button type="submit" class="btn btn-danger" name="pagar_pagamento" id="pagar_pagamento">Renovar Licenciamento</button>';

                echo '';
                echo '</form></th>';
            
                echo '</thead>';
                echo '<tbody>';
            
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';  
            }
*/
            
        } 
    }else{}

    
    


?>
</div>
</div>
</div>
</div>
</div>
</body>
              