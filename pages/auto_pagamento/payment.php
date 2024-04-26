
<?php

session_start();
$dia_hoje = date('Y-m-d'); // Formatando a data de hoje para o formato do banco de dados (ano-mês-dia)

require_once '../../classes/conn_revenda.php';
require_once '../../classes/conn.php';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  

  <!-- Required meta tags --> 
  <meta charset="utf-8">
  <meta http-equiv='refresh' content='30'>
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
            $diferenca_dias = round((strtotime($data_fornecida) - strtotime($dia_hoje)) / (60 * 60 * 24));
            $_SESSION['fatura_prevista'] = $_SESSION['valor_fatura'] + (-$diferenca_dias);
        }
    }

    $chaveMP = "TEST-767dfaf0-1461-48ee-9b84-17cc1c784b45";
?>
    <h2><?php echo 'R$: '.$_SESSION['valor_fatura']. ' + R$: '. number_format(floatval(-$diferenca_dias), 2);?></h4>
    <h4>Multa de R$: 1,00 por dia</h4>
    <h1>Valor a Pagar: R$: <?php echo number_format(floatval($_SESSION['fatura_prevista']), 2);?></h1>
    

<div id="paymentBrick_container">
    <!-- Seu conteúdo de pagamento aqui -->
</div>

        <div id="qrCodeContainer"></div>

  <script>
    // Substitua por sua chave de teste do Mercado Pago
    const mp = new MercadoPago('<?php echo $chaveMP; ?>', {
      locale: 'pt'
    });

    const bricksBuilder = mp.bricks();

    async function renderPaymentBrick(bricksBuilder) {
      const settings = {
        initialization: {
          amount: <?php echo $_SESSION['fatura_prevista'];?>, // Valor total a pagar
          preferenceId: 250, // ID da preferência (obtida no seu servidor)
          payer: {
            firstName: "<?php echo $_SESSION['rsocial_fatura'];?>", // Nome do pagador (opcional)
            lastName: "<?php echo $_SESSION['nfantasia_fatura'];?>", // Sobrenome do pagador (opcional)
            email: "<?php echo $_SESSION['email_fatura'];?>" // Email do pagador (opcional)
          }
        },
        customization: {
          visual: {
            style: {
              theme: "bootstrap",
            },
          },
          paymentMethods: {
            atm: "all",
										wallet_purchase: "all",
										bankTransfer: "all",
            maxInstallments: 1
          },
        },
        callbacks: {
          onReady: () => {
            // Callback quando o brick estiver pronto
            console.log('Brick do Mercado Pago pronto!');
          },
          onSubmit: ({ selectedPaymentMethod, formData }) => {
            // Callback quando o usuário envia os dados de pagamento
            return fetch('/process_payment', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json'
              },
              body: JSON.stringify({
                selectedPaymentMethod,
                formData
              })
            })
            .then(response => response.json())
            .then(response => {
              if (response.status === 'success') {
                console.log('Pagamento realizado com sucesso!');

                // Gere o QR Code com a preferenceId da resposta do servidor
                const preferenceId = response.preferenceId;
                generateQRCode(preferenceId);
              } else {
                console.error('Erro no processamento do pagamento:', response.message);
                // Exiba uma mensagem de erro para o usuário.
              }
            })
            .catch(error => {
              console.error('Erro na comunicação com o servidor:', error);
              // Exiba uma mensagem de erro para o usuário.
            });
          },
          onError: (error) => {
            // Callback para erros do brick
            console.error('Erro no brick do Mercado Pago:', error);
          }
        }
      };

      const paymentBrickController = await bricksBuilder.create("payment", "paymentBrick_container", settings);
    }

    async function generateQRCode(preferenceId) {
      try {
        const qrCodeResponse = await mp.qrCodes.create({
          preferenceId: preferenceId
        });

        const qrCodeURL = qrCodeResponse.qrCode;
        console.log('QR Code gerado:', qrCodeURL);

        const qrCodeContainer = document.getElementById('qrCodeContainer');
        if (qrCodeContainer) {
          qrCodeContainer.innerHTML = `<img src="${qrCodeURL}" alt="QR Code do Mercado Pago">`;
        }
      } catch (error) {
        console.error('Erro ao gerar QR Code:', error);
      }
    }

    renderPaymentBrick(bricksBuilder);
  </script>

<table>
<th>
    <?php
        //echo '<h1>Opção 1</h1><h2>Copiar Conteúdo '.$_POST['valor_pagamento'].'</h2>';
    ?>
    <!--
    <textarea id="link1" rows="5" cols="50">00020101021126580014br.gov.bcb.pix01366f253057-2713-4a14-8076-7c8bdab319f7520400005303986540580.005802BR5920GABRIEL GOMES AMORIM6009SAO PAULO622905251HW9BJC9HWVN0HTT6CQDPC1SC6304D2C3</textarea><br>

    <button onclick="copiarTexto1()">Copiar</button>
-->
    <script>
        function copiarTexto1() {
            var textarea = document.getElementById("link1");
            textarea.select();
            document.execCommand("copy");
            alert("Conteúdo copiado para a área de transferência!");
        }
    </script>
</th>
<th>
    <!--
    <?php
        //echo '<h1>Opção 2</h1><h2>Copiar Conteúdo '.$_POST['valor_pagamento'].'</h2>';
    ?>
    <textarea id="link2" rows="5" cols="50">00020101021126580014br.gov.bcb.pix01366f253057-2713-4a14-8076-7c8bdab319f7520400005303986540580.005802BR5920GABRIEL GOMES AMORIM6009SAO PAULO622905251HW9BMVAVD941FJY580TA9XM16304A243</textarea><br>
    <button onclick="copiarTexto2()">copiar</button>
    -->
    <script>
        function copiarTexto2() {
            var textarea = document.getElementById("link2");
            textarea.select();
            document.execCommand("copy");
            alert("Conteúdo copiado para a área de transferência!");
        }
    </script>
</th>

</table>
</div>

        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © sistma.com 2023</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://localhost/_1_1_sistema" target="_blank">Sistema.com</a> from 1.1</span>
          </div>
          <span class="text-muted d-block text-center text-sm-left d-sm-inline-block mt-2">Distributed By: <a href="https://www.themewagon.com/" target="_blank">ThemeWagon</a></span>
        </footer>
        
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
        



