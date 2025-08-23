<?php 
    session_start();
    if(!isset($_SESSION['cd_colab']))
    {
        header("location: ../../pages/samples/login.php");
        exit;
    }
    require_once '../../classes/conn.php';
    include("../../classes/functions.php");
    include("../../classes/financeiro.php");
    $u = new Usuario;

    $f = new Financeiro;
    


?><!--Validar sessão aberta, se usuário está logado.-->

<!DOCTYPE html>
<html lang="pt-br">

<head>
<?php 
    if(isset($_SESSION['bloqueado'])){
      if($_SESSION['bloqueado'] == 1){
        //echo "<meta http-equiv='refresh' content='15;url=../auto_pagamento/payment.php'>";
        
      }else if($_SESSION['bloqueado'] == 2){
        echo "<meta http-equiv='refresh' content='1;url=../auto_pagamento/payment.php'>";
      }
    }

  ?>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Consulta Servico</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
  
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="stylesheet" href="../../css/custom.css">
  <link rel='shortcut icon' href='https://lh3.googleusercontent.com/pw/AP1GczOReqQClzL-PZkykfOwgmMyVzQgx27DTp783MI7iwKuKSv-6P6V7KOEbCC74sGdK3DEV3O88CsBLeIvOaQwGT3x4bqCTPRtyV9zcODbYVDRxAF8zf8Uev7geh4ONPdl3arNhnSDPvbQfMdpFRPM263V9A=w250-h250-s-no-gm?authuser=0' />

  <!-- endinject -->
  <script src="../../js/functions.js"></script>
  <!--<link rel="shortcut icon" href="<?php //echo $_SESSION['logo_empresa']; ?>" />-->


  <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Popper e Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.2/js/bootstrap.min.js"></script>

</div>
</head>

<body onmousemove="resetTimer()" onclick="resetTimer()" onkeypress="resetTimer()">
<script src="../../js/gtag.js"></script>
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
            <div class="col-12 grid-margin">
              <h1><?php //echo $_SESSION['bloqueado'];?></h1>
              <div class="card" <?php $_SESSION['c_card'];?>>
                

                <div class="col-lg-12 grid-margin stretch-card">
                  <i type="submit" class="btn btn-warning"style="margin:auto; display:none;" id="comissao_a_pagar">Comissões a Pagar</i>
                </div>


            <?php



    if (isset($_POST['lanca_comissao']) && !isset($_POST['fpag_comissao'])) {
    // Mensagem do modal
    $mensagem = "Qual a forma de pagamento da comissão?";

    // Gerar o modal via PHP
    echo '
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Confirmação</h5>
          </div>
          <div class="modal-body">
            <p>' . htmlspecialchars($mensagem, ENT_QUOTES) . '</p>
          </div>
          <div class="modal-footer">
            <form method="POST" action="">
    ';

    // Preservar os dados do POST no modal
    foreach ($_POST as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $subValue) {
                echo '<input type="hidden" name="' . htmlspecialchars($key, ENT_QUOTES) . '[]" value="' . htmlspecialchars($subValue, ENT_QUOTES) . '">';
            }
        } else {
            echo '<input type="hidden" name="' . htmlspecialchars($key, ENT_QUOTES) . '" value="' . htmlspecialchars($value, ENT_QUOTES) . '">';
        }
    }

    echo '
              <button type="submit" name="fpag_comissao" value="DINHEIRO" class="btn btn-success">Dinheiro</button>
              <button type="submit" name="fpag_comissao" value="PIX" class="btn btn-info">PIX</button>
              <button type="submit" name="fpag_comissao" value="cancelar" class="btn btn-danger">Cancelar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <script>
      $(document).ready(function() {
        $("#exampleModalCenter").modal("show");
      });
    </script>
    ';
}


                  if (isset($_POST['fpag_comissao'])) {
                    if ($_POST['fpag_comissao'] === 'DINHEIRO') {
                      $updateEstoque = "
                        UPDATE tb_comissao 
                        SET obs_comissao = CONCAT(obs_comissao, ' Pago por  ".$_SESSION['pnome_colab']." (', DATE_FORMAT(NOW(), '%d/%m/%Y : %H:%i'), ') |'), status_comissao = 1
                        WHERE cd_colab = " . intval($_POST['lancar_cd_colab']);
                      
                      $insert_suprimento = "INSERT INTO tb_movimento_financeiro(cd_filial, tipo_movimento, cd_caixa_movimento, cd_colab_movimento, fpag_movimento, valor_movimento, data_movimento, obs_movimento) VALUES(
                        '".$_SESSION['cd_empresa']."',
                        3,
                        '".$_SESSION['cd_caixa']."',
                        '".$_SESSION['cd_colab']."',
                        'dinheiro',
                        '".$_POST['vpag_comissao']."',
                        NOW(),
                        'COMISSÕES: ".$_POST['obs_comissao']."'
                        )
                      ";
                      mysqli_query($conn, $insert_suprimento);

                      if(mysqli_query($conn, $updateEstoque)){
                        echo '<script>alert("Comissão paga no DINHEIRO com sucesso!");</script>';
                      }else{
                        echo '<script>alert("Erro ao dar baixa na comissão: ' . mysqli_error($conn) . '");</script>';
                      }
                    
                      
                      
                          
                          //echo '<script>location.href="'.$_SESSION['dominio'].'pages/md_assistencia/cadastro_servico.php";</script>';          

                    
                    } elseif ($_POST['fpag_comissao'] === 'PIX') {
                        $updateEstoque = "
                        UPDATE tb_comissao 
                        SET obs_comissao = CONCAT(obs_comissao, ' Pago por  ".$_SESSION['pnome_colab']." (', DATE_FORMAT(NOW(), '%d/%m/%Y : %H:%i'), ') |'), status_comissao = 1
                        WHERE cd_colab = " . intval($_POST['lancar_cd_colab']);
                      
                      $insert_suprimento = "INSERT INTO tb_movimento_financeiro(cd_filial, tipo_movimento, cd_caixa_movimento, cd_colab_movimento, fpag_movimento, valor_movimento, data_movimento, obs_movimento) VALUES(
                        '".$_SESSION['cd_empresa']."',
                        3,
                        '".$_SESSION['cd_caixa']."',
                        '".$_SESSION['cd_colab']."',
                        'pix',
                        '".$_POST['vpag_comissao']."',
                        NOW(),
                        'COMISSÕES: ".$_POST['obs_comissao']."'
                        )
                      ";
                      mysqli_query($conn, $insert_suprimento);

                      if(mysqli_query($conn, $updateEstoque)){
                        echo '<script>alert("Comissão paga no PIX com sucesso!");</script>';
                      }else{
                        echo '<script>alert("Erro ao dar baixa na comissão: ' . mysqli_error($conn) . '");</script>';
                      }
                    } elseif ($_POST['fpag_comissao'] === 'cancelar') {
                        echo '<script>alert("Operação cancelada pelo usuário.");</script>';
                        // Lógica para "Cancelar"
                    }
                  }


              $comissao_a_pagar = 0;

              $sql_comissao = "
                SELECT 
                    p.cd_pessoa,
                    p.pnome_pessoa AS nome_colab,
                    SUM(c.vl_comissao) AS total_comissao,
                    GROUP_CONCAT(CONCAT('OS ', c.cd_servico, ' = R$ ', FORMAT(c.vl_comissao, 2, 'pt_BR')) SEPARATOR ' | ') AS obs
                FROM tb_comissao c
                JOIN tb_pessoa p ON p.cd_pessoa = c.cd_colab
                WHERE c.status_comissao = 0
                  AND c.cd_filial = '".$_SESSION['cd_filial']."'
                GROUP BY p.cd_pessoa, p.pnome_pessoa, p.snome_pessoa
                ORDER BY total_comissao DESC;
              ";


              $resulta_comissao = $conn->query($sql_comissao);
              if ($resulta_comissao->num_rows > 0){
                echo '<div class="col-lg-12 grid-margin stretch-card" >';
                echo '<div class="card" '.$_SESSION['c_card'].'>';
                
                echo '<div class="card-body">';
                echo '<div class="grid-margin stretch-card">';
                echo '<h4 style="display: inline-block; margin-left: 10px;">COMISSÕES À PAGAR</h4>';
                echo '</div>';

                echo '<div class=" table-responsive">';
                
                echo '<table class="table" '.$_SESSION['c_card'].'>';
                echo '<thead>';
                echo '<tr>';
                //echo '<th>CD</th>';
                echo '<th>Colaborador</th>';
                echo '<th>Descrição</th>';
                echo '<th>Total à pagar</th>';
                //echo '<th>Prazo</th>';
                
                
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                
                while ( $comissao = $resulta_comissao->fetch_assoc()){
                  echo '<tr>';
                  //echo '<form method="POST" action="../../pages/md_assistencia/consulta_servico.php">';
                  //echo '<td style="display: none;"><input type="tel" id="conos_servico" name="conos_servico" value="'.$comissao['cd_comissao'].'"></td>';
                  //echo '<td><button type="submit" class="btn btn-warning" name="btn_cd_'.$comissao['cd_comissao'].'" id="btn_cd_'.$comissao['cd_comissao'].'">'.$comissao['cd_comissao'].'</button></td>';
                  //echo '</form>';
                  
                  echo '<td name="colab_'.$comissao['cd_colab'].'" id="colab_'.$comissao['cd_colab'].'">'.$comissao['nome_colab'].'</td>';
                  $obs_comissao = '';
                  //$obs_comissao = $obs_comissao . ' ('.$comissao['obs_comissao'].')';

                  $obs_comissao = $obs_comissao . ' ' . str_replace('|', '<br>', $comissao['obs']);

                  echo '<td name="obs_'.$comissao['cd_comissao'].'" id="obs_'.$comissao['cd_comissao'].'">'.$obs_comissao.'</td>';
                  echo '<td name="vl_comissao_'.$comissao['cd_comissao'].'" id="vl_comissao_'.$comissao['cd_comissao'].'">R$: '.$comissao['total_comissao'].'</td>';

                  echo '<form name="lanca_comissao" id="lanca_comissao" method="POST">';
                  echo '<td style="display: none;"><input type="tel" id="lancar_cd_colab" name="lancar_cd_colab" value="'.$comissao['cd_pessoa'].'"></td>';
                  echo '<td style="display: none;"><input type="tel" id="vpag_comissao" name="vpag_comissao" value="'.$comissao['total_comissao'].'"></td>';
                  echo '<td style="display: none;"><input type="tel" id="obs_comissao" name="obs_comissao" value="'.$comissao['obs'].'"></td>';
                  echo '<td><button type="submit" class="btn btn-warning" name="lanca_comissao" id="lanca_comissao">PAGAR</button></td>';
                  echo '</form>';

                  $comissao_a_pagar += (float)$comissao['total_comissao']; 

                  // Quando for exibir:
                  $vl_comissao = number_format($comissao['total_comissao'], 2, ',', '.');
                  $vl_total = number_format($comissao_a_pagar, 2, ',', '.');

                  echo '<script>document.getElementById("comissao_a_pagar").innerHTML = "R$: '.$vl_total.'";</script>';
                  echo '<script>document.getElementById("comissao_a_pagar").style.display = "block";</script>';
                  
                }
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                
              }else{
                echo '<div class="grid-margin stretch-card">';
                echo '<h4 style="display: inline-block; margin-left: 10px;">Sem comissões pendentes</h4>';
                echo '</div>';
              }        
?>

 <!-- #region -->
  
 

 <!-- #endregion -->
                </div>
                


                


              
                <?php
  
?>
                
             

                

              </div>
            </div>
          </div>
        
     
    
  

        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
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