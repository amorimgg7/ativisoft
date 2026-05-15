<?php 
    session_start();  
    if(!isset($_SESSION['cd_colab']))
    {
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
  <title>Cadastro de cliente</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">

  
  
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <!-- endinject -->
  <script src="../../js/functions.js"></script>
  <link rel="shortcut icon" href="<?php //echo $_SESSION['logo_empresa']; ?>" />
</head>

<body onmousemove="resetTimer()" onclick="resetTimer()" onkeypress="resetTimer()">
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

            <?php //LIBERADO
            if($_POST['tipo_card'] == 2){
              

              $sql_servico = "SELECT concat(c.pnome_pessoa, ' ',c.snome_pessoa) as full_name, s.* FROM tb_servico s, tb_pessoa c WHERE s.cd_cliente = c.cd_pessoa and status_servico = 2 and cd_filial = '".$_SESSION['cd_empresa']."'
                ORDER BY 
                CASE 
                    WHEN prioridade_servico = 'U' THEN 1
                    WHEN prioridade_servico = 'A' THEN 2
                    WHEN prioridade_servico = 'M' THEN 3
                    ELSE 4
                END, cd_servico limit 200";

              $resulta_servico = $conn->query($sql_servico);
              if ($resulta_servico->num_rows > 0){
                echo '<div class="col-lg-12 grid-margin stretch-card"  data-toggle="collapse" href="#os_liberado" aria-expanded="false" aria-controls="os_liberado">';
                echo '<div class="card" '.$_SESSION['c_card'].'>';
                echo '<div class="card-body">';
                echo '<div class="grid-margin stretch-card">';
                echo '<h4 style="display: inline-block; margin-left: 10px;">LIBERADO</h4>';
                echo '<i class="btn btn-outline-success" style="margin:auto; display:none;" id="liberado"></i>';
                echo '</div>';
                echo '<h4 ></h4>';
                
                echo '<div class="collapse table-responsive" id="os_liberado">';
                echo '<table class="table" '.$_SESSION['c_card'].'>';
                echo '<thead>';
                echo '<tr>';
                echo '<th>OS</th>';
                echo '<th>Financeiro</th>';
                echo '<th>Cliente</th>';
                echo '<th>Descrição</th>';
                
                
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                $liberado = 0;
                while ( $servico = $resulta_servico->fetch_assoc()){


                  $liberado = $liberado + 1;
                  if($liberado > 199){
                    echo '<script>document.getElementById("liberado").innerHTML = "+ '.$liberado.'";</script>';
                  }else{
                    echo '<script>document.getElementById("liberado").innerHTML = "'.$liberado.'";</script>';
                  }
                  
                  echo '<script>document.getElementById("liberado").style.display = "block";</script>';//

                  echo '<tr>';
                  echo '<form method="POST" action="../../pages/md_assistencia/consulta_servico.php">';
                  echo '<td style="display: none;"><input type="tel" id="conos_servico" name="conos_servico" value="'.$servico['cd_servico'].'"></td>';
                  echo '<td><button type="submit" class="btn btn-secondary" name="btn_cd_'.$servico['cd_servico'].'" id="btn_cd_'.$servico['cd_servico'].'">'.$servico['cd_servico'].'</button></td>';
                
                  echo '</form>';
                  
                  if($servico['orcamento_servico'] == 0){
                    echo '<td><label class="badge badge-secondary">FREE / Garantia</label></td>';
                  }else{
                    if($servico['orcamento_servico'] == $servico['vpag_servico']){
                      echo '<td><label class="badge badge-success">Liquidado: R$:'. $servico['vpag_servico'] .'</label></td>';
                    }else{
                      $orcamento_servico = isset($servico['orcamento_servico']) && is_numeric($servico['orcamento_servico']) ? $servico['orcamento_servico'] : 0;
                      $vpag_servico = isset($servico['vpag_servico']) && is_numeric($servico['vpag_servico']) ? $servico['vpag_servico'] : 0;
                      echo '<td><label class="badge badge-danger">Falta pagar: R$:' . ($orcamento_servico - $vpag_servico) . ' de R$:' . $orcamento_servico . '</label></td>';
                    }
                  }
                  
                     
                  echo '<td>'.$servico['full_name'].'</td>';
                  echo '<td>'.$servico['obs_servico'].'</td>';
/*
                  if($servico['prioridade_servico'] == "B"){
                    echo '<td><label class="badge badge-success">Baixa</label></td>';
                  
                  }
                  if($servico['prioridade_servico'] == "M"){
                    echo '<td><label class="badge badge-info">Média</label></td>';
                  
                  }
                  if($servico['prioridade_servico'] == "A"){
                    echo '<td><label class="badge badge-warning">Alta</label></td>';
                  
                  }
                  if($servico['prioridade_servico'] == "U"){
                    echo '<td><label class="badge badge-danger">Urgente</label></td>';
                  }*/
                  
                  //echo '<td>'.date('d/m/y', strtotime($servico['prazo_servico'])).'</td>';
                  
                  echo '</tr>';
                }
                
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                echo '</li>';
                echo '</div>';
                echo '</div>';
                echo '</div>';  
              }


            }
            ?>

            <?php //RETIRADO / DEVOLVIDO
            if($_POST['tipo_card'] == 3){
              $sql_servico = "SELECT concat(c.pnome_pessoa, ' ',c.snome_pessoa) as full_name, s.cd_servico, s.vpag_servico, s.orcamento_servico, s.prioridade_servico, s.obs_servico, s.prazo_servico FROM tb_servico s, tb_pessoa c WHERE s.cd_cliente = c.cd_pessoa and s.status_servico = 3 and cd_filial = '".$_SESSION['cd_empresa']."' order by prazo_servico desc  limit 200";
              $resulta_servico = $conn->query($sql_servico);
              if ($resulta_servico->num_rows > 0){
                echo '<div class="col-lg-12 grid-margin stretch-card"  data-toggle="collapse" href="#os_retirado" aria-expanded="false" aria-controls="os_retirado">';
                echo '<div class="card" '.$_SESSION['c_card'].'>';
                echo '<div class="card-body">';

                echo '<div class="grid-margin stretch-card">';
                echo '<h4 style="display: inline-block; margin-left: 10px;">RETIRADO / DEVOLVIDO</h4>';
                echo '<i class="btn btn-outline-success" style="margin:auto; display:none;" id="retiradodevolvido"></i>';
                echo '</div>';
                echo '<h4 ></h4>';

                echo '<div class="collapse table-responsive" id="os_retirado">';
                
                echo '<table class="table" '.$_SESSION['c_card'].'>';
                echo '<thead>';
                echo '<tr>';
                echo '<th>OS</th>';
                echo '<th>Financeiro</th>';
                echo '<th>Cliente</th>';
                
                echo '<th>Prazo</th>';
                echo '<th>Descrição</th>';
                
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                $retiradodevolvido = 0;
                while ( $servico = $resulta_servico->fetch_assoc()){

                  $retiradodevolvido = $retiradodevolvido + 1;
                  if($retiradodevolvido > 199){
                    echo '<script>document.getElementById("retiradodevolvido").innerHTML = "+ '.$retiradodevolvido.'";</script>';
                  }else{
                    echo '<script>document.getElementById("retiradodevolvido").innerHTML = "'.$retiradodevolvido.'";</script>';
                  }
                  
                  echo '<script>document.getElementById("retiradodevolvido").style.display = "block";</script>';//


                  echo '<tr>';
                  echo '<form method="POST" action="../../pages/md_assistencia/consulta_servico.php">';
                  echo '<td style="display: none;"><input type="tel" id="conos_servico" name="conos_servico" value="'.$servico['cd_servico'].'"></td>';
                  echo '<td><button type="submit" class="btn btn-secondary" name="btn_cd_'.$servico['cd_servico'].'" id="btn_cd_'.$servico['cd_servico'].'">'.$servico['cd_servico'].'</button></td>';
                  echo '</form>';

                  if($servico['orcamento_servico'] == 0){
                    echo '<td><label class="badge badge-secondary">FREE / Garantia</label></td>';
                  }else{
                    if($servico['orcamento_servico'] == $servico['vpag_servico']){
                      echo '<td><label class="badge badge-success">Liquidado: R$:'. $servico['vpag_servico'] .'</label></td>';
                    }else{
                      $orcamento_servico = isset($servico['orcamento_servico']) && is_numeric($servico['orcamento_servico']) ? $servico['orcamento_servico'] : 0;
                      $vpag_servico = isset($servico['vpag_servico']) && is_numeric($servico['vpag_servico']) ? $servico['vpag_servico'] : 0;
                      echo '<td><label class="badge badge-danger">Falta pagar: R$:' . ($orcamento_servico - $vpag_servico) . ' de R$:' . $orcamento_servico . '</label></td>';
                    }
                  }

                      
                    
                    echo '<td>'.$servico['full_name'].'</td>';
                    
                    echo '<td>'.date('d/m/y', strtotime($servico['prazo_servico'])).'</td>';
                    echo '<td>'.$servico['obs_servico'].'</td>';
                    //echo '<td>'.date('d/m/y', strtotime($servico['prazo_servico'])).'</td>';
                    //echo '<script>document.getElementById("botoes").style.display = "none";</script>';//
                }
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';  

              }

            }
            ?>
            
            
            <?php //ARQUIVADO
            if($_POST['tipo_card'] == 4){
              $sql_servico = "SELECT concat(c.pnome_pessoa, ' ',c.snome_pessoa) as full_name, s.cd_servico, s.vpag_servico, s.orcamento_servico FROM tb_servico s, tb_pessoa c WHERE s.cd_cliente = c.cd_pessoa and s.status_servico = 4 and cd_filial = '".$_SESSION['cd_empresa']."' order by cd_servico desc ";


              $resulta_servico = $conn->query($sql_servico);
              if ($resulta_servico->num_rows > 0){
                echo '<div class="col-lg-12 grid-margin stretch-card"  data-toggle="collapse" href="#os_arquivado" aria-expanded="false" aria-controls="os_arquivado">';
                echo '<div class="card" '.$_SESSION['c_card'].'>';
                echo '<div class="card-body">';

                echo '<div class="grid-margin stretch-card">';
                echo '<h4 style="display: inline-block; margin-left: 10px;">ARQUIVADO</h4>';
                echo '<i class="btn btn-success" style="margin:auto; display:none;" id="arquivado"></i>';
                echo '</div>';
                echo '<h4 ></h4>';
                
                echo '<div class="collapse table-responsive" id="os_arquivado">';
                
                echo '<table class="table" '.$_SESSION['c_card'].'>';
                echo '<thead>';
                echo '<tr>';
                echo '<th>OS</th>';
                echo '<th>Financeiro</th>';
                echo '<th>Cliente</th>';
                
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                $arquivado = 0;
                while ( $servico = $resulta_servico->fetch_assoc()){

                  $arquivado = $arquivado + 1;
                  echo '<script>document.getElementById("arquivado").innerHTML = "'.$arquivado.'";</script>';
                  echo '<script>document.getElementById("arquivado").style.display = "block";</script>';

                  echo '<tr>';
                  echo '<form method="POST" action="../../pages/md_assistencia/consulta_servico.php">';
                  echo '<td style="display: none;"><input type="tel" id="conos_servico" name="conos_servico" value="'.$servico['cd_servico'].'"></td>';
                  echo '<td><button type="submit" class="btn btn-secondary" name="btn_cd_'.$servico['cd_servico'].'" id="btn_cd_'.$servico['cd_servico'].'">'.$servico['cd_servico'].'</button></td>';
                  echo '</form>';

                  if($servico['orcamento_servico'] == 0){
                    echo '<td><label class="badge badge-secondary">FREE / Garantia</label></td>';
                  }else{
                    if($servico['orcamento_servico'] == $servico['vpag_servico']){
                      echo '<td><label class="badge badge-success">Liquidado: R$:'. $servico['vpag_servico'] .'</label></td>';
                    }else{
                      $orcamento_servico = isset($servico['orcamento_servico']) && is_numeric($servico['orcamento_servico']) ? $servico['orcamento_servico'] : 0;
                      $vpag_servico = isset($servico['vpag_servico']) && is_numeric($servico['vpag_servico']) ? $servico['vpag_servico'] : 0;
                      echo '<td><label class="badge badge-danger">Falta pagar: R$:' . ($orcamento_servico - $vpag_servico) . ' de R$:' . $orcamento_servico . '</label></td>';
                    }
                  }


                  

                  echo '<td>'.$servico['full_name'].'</td>';
                    

                  

              //    // Contagem de equipamentos em uso
              //    $sql_cliente = "SELECT * FROM tb_cliente WHERE cd_cliente = '".$servico['cd_cliente']."'"; 
              //    $resulta_cliente = $conn->query($sql_cliente);
              //    $cliente = $resulta_cliente->fetch_assoc();
                  
              //    echo '<td>'.$cliente['pnome_cliente'].'</td>';

              //    // Contagem de equipamentos fora de uso
                  
              //    echo '<td>'.$cliente['tel_cliente'].'</td>';

              //    //echo '<td><label class="badge badge-info">'.$qtd_uso.'</label></td>';
              //    //echo '<td><label class="badge badge-warning">'.$qtd_fora_de_uso.'</label></td>';
                  
                  


                  
                  
                  echo '<script>document.getElementById("botoes").style.display = "none";</script>';//
                }
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                
              }

            }
            ?>
            
            
            <a href="<?php echo $_SESSION['dominio'];?>/pages/dashboard" class="btn btn-lg btn-block btn-outline-danger">VOLTAR</a>
            
        
     
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