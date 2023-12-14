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
  <link rel="shortcut icon" href="<?php echo $_SESSION['logo_empresa']; ?>" />
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
          

        <div class="col-lg-12 grid-margin stretch-card">
<i type="submit" class="btn btn-success"style="margin:auto; display:none;"id="noprazo">No prazo</i>
<i type="submit" class="btn btn-warning"style="margin:auto; display:none;"id="parahoje">Previsto para hoje</i>
<i type="submit" class="btn btn-danger"style="margin:auto; display:none;" id="extrapolado">Prazo extrapolado</i>
</div>

            <?php //À FAZER
              //"SELECT marca_patrimonio, modelo_patrimonio, COUNT(*) AS total FROM tb_patrimonio WHERE tipo_patrimonio = 'Impressora' GROUP BY marca_patrimonio, modelo_patrimonio";
              //$sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 0";
              $sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 0 
                ORDER BY 
                CASE 
                    WHEN prioridade_servico = 'U' THEN 1
                    WHEN prioridade_servico = 'A' THEN 2
                    WHEN prioridade_servico = 'M' THEN 3 
                    ELSE 4
                END, cd_servico";

              $resulta_servico = $conn->query($sql_servico);
              if ($resulta_servico->num_rows > 0){
                echo '<div class="col-lg-12 grid-margin stretch-card" data-toggle="collapse" href="#os_afaser" aria-expanded="false" aria-controls="os_afaser">';
                echo '<div class="card" '.$_SESSION['c_card'].'>';
                
                echo '<div class="card-body">';
                echo '<div class="grid-margin stretch-card">';
                echo '<h4 style="display: inline-block; margin-left: 10px;">À FAZER</h4>';
                echo '<i class="btn btn-success" style="margin:auto; display:none;" id="noprazoafaser"></i><i class="btn btn-warning" style="margin:auto; display:none;" id="parahojeafaser"></i><i class="btn btn-danger" style="margin:auto; display:none;" id="extrapoladoafaser"></i>';
                echo '</div>';

                
                echo '<div class="collapse table-responsive" id="os_afaser">';
                
                echo '<table class="table" '.$_SESSION['c_card'].'>';
                echo '<thead>';
                echo '<tr>';
                echo '<th>OS</th>';
                echo '<th>Prioridade</th>';
                echo '<th>Prazo</th>';
                
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                $extrapolado = 0;
                $extrapoladoafaser = 0;
                $parahoje = 0;
                $parahojeafazer = 0;
                $noprazo = 0;
                $noprazoafaser = 0;
                while ( $servico = $resulta_servico->fetch_assoc()){
                  echo '<tr>';
                  echo '<form method="POST" action="../../pages/md_assistencia/consulta_servico.php">';
                  echo '<td style="display: none;"><input type="tel" id="conos_servico" name="conos_servico" value="'.$servico['cd_servico'].'"></td>';
                  echo '<td><button type="submit" class="btn btn-danger" name="btn_cd_'.$servico['cd_servico'].'" id="btn_cd_'.$servico['cd_servico'].'">'.$servico['cd_servico'].'</button></td>';
                  echo '</form>';

                  
                                    
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
                  }
                  echo '<td name="btn_dt_'.$servico['cd_servico'].'" id="btn_dt_'.$servico['cd_servico'].'">'.date('d/m/y', strtotime($servico['prazo_servico'])).'</td>';

		              if(date('Y-m-d', strtotime('+1 hour')) > date('Y-m-d', strtotime($servico['prazo_servico']))){
                    echo '<script>document.getElementById("btn_cd_'.$servico['cd_servico'].'").className = "btn btn-danger";</script>';
                    //echo '<script>document.getElementById("btn_dt_'.$servico['cd_servico'].'").className = "badge badge-danger";</script>';
                    $extrapolado = $extrapolado+1;
                    $extrapoladoafaser = $extrapoladoafaser+1;
                  }else{
                    if(date('Y-m-d', strtotime('+1 hour')) == date('Y-m-d', strtotime($servico['prazo_servico']))){
                      echo '<script>document.getElementById("btn_cd_'.$servico['cd_servico'].'").className = "btn btn-warning";</script>';
                      //echo '<script>document.getElementById("btn_dt_'.$servico['cd_servico'].'").className = "badge badge-warning";</script>';
                      $parahoje = $parahoje+1;
                      $parahojeafazer = $parahojeafazer + 1;
                    }else{
                      if(date('Y-m-d', strtotime('+1 hour')) < date('Y-m-d', strtotime($servico['prazo_servico']))){
                        echo '<script>document.getElementById("btn_cd_'.$servico['cd_servico'].'").className = "btn btn-success";</script>';
                        //echo '<script>document.getElementById("btn_dt_'.$servico['cd_servico'].'").className = "badge badge-success";</script>';
                        $noprazo = $noprazo+1;
                        $noprazoafaser = $noprazoafaser+1;
                      }
                    }
                  }
                }
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                
                if($noprazoafaser > 0){
                  echo '<script>document.getElementById("noprazoafaser").innerHTML = "'.$noprazoafaser.'";</script>';
                  echo '<script>document.getElementById("noprazoafaser").style.display = "block";</script>';
                }
                if($parahojeafazer > 0){
                  echo '<script>document.getElementById("parahojeafaser").innerHTML = "'.$parahojeafazer.'";</script>';
                  echo '<script>document.getElementById("parahojeafaser").style.display = "block";</script>';
                }
                if($extrapoladoafaser > 0){
                  echo '<script>document.getElementById("extrapoladoafaser").innerHTML = "'.$extrapoladoafaser.'";</script>';
                  echo '<script>document.getElementById("extrapoladoafaser").style.display = "block";</script>';
                }
              }
            ?>

            <?php //EM ANDAMENTO
              //"SELECT marca_patrimonio, modelo_patrimonio, COUNT(*) AS total FROM tb_patrimonio WHERE tipo_patrimonio = 'Impressora' GROUP BY marca_patrimonio, modelo_patrimonio";
              //$sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 0";
              $sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 1 
                ORDER BY 
                CASE 
                    WHEN prioridade_servico = 'U' THEN 1
                    WHEN prioridade_servico = 'A' THEN 2
                    WHEN prioridade_servico = 'M' THEN 3
                    ELSE 4
                END, cd_servico";

              $resulta_servico = $conn->query($sql_servico);
              if ($resulta_servico->num_rows > 0){
                echo '<div class="col-lg-12 grid-margin stretch-card" data-toggle="collapse" href="#os_emandamento" aria-expanded="false" aria-controls="os_emandamento">';
                echo '<div class="card" '.$_SESSION['c_card'].'>';
                echo '<div class="card-body">';

                echo '<div class="grid-margin stretch-card">';
                echo '<h4 style="display: inline-block; margin-left: 10px;">EM ANDAMENTO</h4>';
                echo '<i class="btn btn-success" style="margin:auto; display:none;" id="noprazoemandamento"></i><i class="btn btn-warning" style="margin:auto; display:none;" id="parahojeemandamento"></i><i class="btn btn-danger" style="margin:auto; display:none;" id="extrapoladoemandamento"></i>';
                echo '</div>';
                echo '<h4 ></h4>';
                
                echo '<div class="collapse table-responsive" id="os_emandamento">';
                
                echo '<table class="table" '.$_SESSION['c_card'].'>';
                echo '<thead>';
                echo '<tr>';
                echo '<th>OS</th>';
                echo '<th>Prioridade</th>';
                echo '<th>Prazo</th>';
                
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                $extrapolado = 0;
                $extrapoladoemandamento = 0;
                $parahoje = 0;
                $parahojeemandamento = 0;
                $noprazo = 0;
                $noprazoemandamento = 0;
                while ( $servico = $resulta_servico->fetch_assoc()){
                  echo '<tr>';
                  echo '<form method="POST" action="../../pages/md_assistencia/consulta_servico.php">';
                  echo '<td style="display: none;"><input type="tel" id="conos_servico" name="conos_servico" value="'.$servico['cd_servico'].'"></td>';
                  echo '<td><button type="submit" class="btn btn-danger" name="btn_cd_'.$servico['cd_servico'].'" id="btn_cd_'.$servico['cd_servico'].'">'.$servico['cd_servico'].'</button></td>';
                  echo '</form>';

                  if(date('Y-m-d', strtotime('+1 hour')) > date('Y-m-d', strtotime($servico['prazo_servico']))){
                    echo '<script>document.getElementById("btn_cd_'.$servico['cd_servico'].'").className = "btn btn-danger";</script>';
                    $extrapolado = $extrapolado+1;
                    $extrapoladoemandamento = $extrapoladoemandamento+1;
                  }else{
                    if(date('Y-m-d', strtotime('+1 hour')) == date('Y-m-d', strtotime($servico['prazo_servico']))){
                    echo '<script>document.getElementById("btn_cd_'.$servico['cd_servico'].'").className = "btn btn-warning";</script>';
                    $parahoje = $parahoje+1;
                    $parahojeemandamento = $parahojeemandamento+1;
                    }else{
                      if(date('Y-m-d', strtotime('+1 hour')) < date('Y-m-d', strtotime($servico['prazo_servico']))){
                        echo '<script>document.getElementById("btn_cd_'.$servico['cd_servico'].'").className = "btn btn-success";</script>';
                        $noprazo = $noprazo+1;
                        $noprazoemandamento = $noprazoemandamento+1;
                      }
                    }
                  }

                  
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
                  }
                  echo '<td>'.date('d/m/y', strtotime($servico['prazo_servico'])).'</td>';

                }
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                
                if($parahojeemandamento > 0){
                  echo '<script>document.getElementById("parahojeemandamento").innerHTML = "'.$parahojeemandamento.'";</script>';
                  echo '<script>document.getElementById("parahojeemandamento").style.display = "block";</script>';
                }
                if($noprazoemandamento > 0){
                  echo '<script>document.getElementById("noprazoemandamento").innerHTML = "'.$noprazoemandamento.'";</script>';
                  echo '<script>document.getElementById("noprazoemandamento").style.display = "block";</script>';
                }
                if($extrapoladoemandamento > 0){
                  echo '<script>document.getElementById("extrapoladoemandamento").innerHTML = "'.$extrapoladoemandamento.'";</script>';
                  echo '<script>document.getElementById("extrapoladoemandamento").style.display = "block";</script>';
                }
              }
            ?>

            <?php //LIBERADO
              //"SELECT marca_patrimonio, modelo_patrimonio, COUNT(*) AS total FROM tb_patrimonio WHERE tipo_patrimonio = 'Impressora' GROUP BY marca_patrimonio, modelo_patrimonio";
              //$sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 0";
              $sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 2 
                ORDER BY 
                CASE 
                    WHEN prioridade_servico = 'U' THEN 1
                    WHEN prioridade_servico = 'A' THEN 2
                    WHEN prioridade_servico = 'M' THEN 3
                    ELSE 4
                END, cd_servico";

              $resulta_servico = $conn->query($sql_servico);
              if ($resulta_servico->num_rows > 0){
                echo '<div class="col-lg-12 grid-margin stretch-card"  data-toggle="collapse" href="#os_liberado" aria-expanded="false" aria-controls="os_liberado">';
                echo '<div class="card" '.$_SESSION['c_card'].'>';
                echo '<div class="card-body">';
                echo '<div class="grid-margin stretch-card">';
                echo '<h4 style="display: inline-block; margin-left: 10px;">LIBERADO</h4>';
                echo '<i class="btn btn-success" style="margin:auto; display:none;" id="liberado"></i><i class="btn btn-warning" style="margin:auto; display:none;" id="liberado"></i><i class="btn btn-danger" style="margin:auto; display:none;" id="liberado"></i>';
                echo '</div>';
                echo '<h4 ></h4>';
                
                echo '<div class="collapse table-responsive" id="os_liberado">';
                echo '<table class="table" '.$_SESSION['c_card'].'>';
                echo '<thead>';
                echo '<tr>';
                echo '<th>OS</th>';
                echo '<th>Prioridade</th>';
                echo '<th>Prazo</th>';
                
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                $liberado = 0;
                while ( $servico = $resulta_servico->fetch_assoc()){
                  echo '<tr>';
                  echo '<form method="POST" action="../../pages/md_assistencia/consulta_servico.php">';
                  echo '<td style="display: none;"><input type="tel" id="conos_servico" name="conos_servico" value="'.$servico['cd_servico'].'"></td>';
                  echo '<td><button type="submit" class="btn btn-danger" name="btn_cd_'.$servico['cd_servico'].'" id="btn_cd_'.$servico['cd_servico'].'">'.$servico['cd_servico'].'</button></td>';
                
                  echo '</form>';
                  

                  
                    echo '<script>document.getElementById("btn_cd_'.$servico['cd_servico'].'").className = "btn btn-danger";</script>';
                    $liberado = $liberado + 1;
                  
                                  
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
                  }
                  echo '<td>'.date('d/m/y', strtotime($servico['prazo_servico'])).'</td>';
                  
                  echo '</tr>';
                }
                
                 
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                echo '</li>';
                echo '</div>';
                echo '</div>';
                echo '</div>';  



                if($liberado > 0){
                  echo '<script>document.getElementById("liberado").innerHTML = "'.$liberado.'";</script>';
                  echo '<script>document.getElementById("liberado").style.display = "block";</script>';
                }
                


              }
            ?>

            <?php //RETIRADO / DEVOLVIDO
            
              $sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 3 
                ORDER BY 
                CASE 
                    WHEN prioridade_servico = 'U' THEN 1
                    WHEN prioridade_servico = 'A' THEN 2
                    WHEN prioridade_servico = 'M' THEN 3
                    ELSE 4
                END, cd_servico";

              $resulta_servico = $conn->query($sql_servico);
              if ($resulta_servico->num_rows > 0){
                echo '<div class="col-lg-12 grid-margin stretch-card"  data-toggle="collapse" href="#os_retirado" aria-expanded="false" aria-controls="os_retirado">';
                echo '<div class="card" '.$_SESSION['c_card'].'>';
                echo '<div class="card-body">';

                echo '<div class="grid-margin stretch-card">';
                echo '<h4 style="display: inline-block; margin-left: 10px;">RETIRADO / DEVOLVIDO</h4>';
                echo '<i class="btn btn-success" style="margin:auto; display:none;" id="retiradodevolvido"></i><i class="btn btn-warning" style="margin:auto; display:none;" id="retiradodevolvido"></i><i class="btn btn-danger" style="margin:auto; display:none;" id="retiradodevolvido"></i>';
                echo '</div>';
                echo '<h4 ></h4>';

                
                echo '<div class="collapse table-responsive" id="os_retirado">';
                
                echo '<table class="table" '.$_SESSION['c_card'].'>';
                echo '<thead>';
                echo '<tr>';
                echo '<th>OS</th>';
                echo '<th>Prioridade</th>';
                echo '<th>Prazo</th>';
                
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                $retiradodevolvido = 0;
                while ( $servico = $resulta_servico->fetch_assoc()){
                  echo '<tr>';
                  echo '<form method="POST" action="../../pages/md_assistencia/consulta_servico.php">';
                  echo '<td style="display: none;"><input type="tel" id="conos_servico" name="conos_servico" value="'.$servico['cd_servico'].'"></td>';
                  echo '<td><button type="submit" class="btn btn-danger" name="btn_cd_'.$servico['cd_servico'].'" id="btn_cd_'.$servico['cd_servico'].'">'.$servico['cd_servico'].'</button></td>';
                  echo '</form>';

                    echo '<script>document.getElementById("btn_cd_'.$servico['cd_servico'].'").className = "btn btn-danger";</script>';
                    $retiradodevolvido = $retiradodevolvido + 1;
                  

              
                  


                  
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
                  }
                  echo '<td>'.date('d/m/y', strtotime($servico['prazo_servico'])).'</td>';
                  echo '<script>document.getElementById("botoes").style.display = "none";</script>';//
                }
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';  

                if($liberado > 0){
                  echo '<script>document.getElementById("retiradodevolvido").innerHTML = "'.$retiradodevolvido.'";</script>';
                  echo '<script>document.getElementById("retiradodevolvido").style.display = "block";</script>';
                }
              }


              if($parahoje > 0){
                echo '<script>document.getElementById("parahoje").innerHTML = "Para Hoje</br>'.$parahoje.'";</script>';
                echo '<script>document.getElementById("parahoje").style.display = "block";</script>';
              }
              if($noprazo > 0){
                echo '<script>document.getElementById("noprazo").innerHTML = "No Prazo</br>'.$noprazo.'";</script>';
                echo '<script>document.getElementById("noprazo").style.display = "block";</script>';
              }
              if($extrapolado > 0){
                echo '<script>document.getElementById("extrapolado").innerHTML = "Prazo Extrapolado</br>'.$extrapolado.'";</script>';
                echo '<script>document.getElementById("extrapolado").style.display = "block";</script>';
              }
              
            ?>
            
            
            <?php //ARQUIVADO
              $sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 4 
                ORDER BY 
                CASE 
                    WHEN prioridade_servico = 'U' THEN 1
                    WHEN prioridade_servico = 'A' THEN 2
                    WHEN prioridade_servico = 'M' THEN 3
                    WHEN prioridade_servico = 'M' THEN 4
                    ELSE 5
                END, cd_servico";

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
                echo '<th>Prioridade</th>';
                echo '<th>Prazo</th>';
                
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                $arquivado = 0;
                while ( $servico = $resulta_servico->fetch_assoc()){
                  echo '<tr>';
                  echo '<form method="POST" action="../../pages/md_assistencia/consulta_servico.php">';
                  echo '<td style="display: none;"><input type="tel" id="conos_servico" name="conos_servico" value="'.$servico['cd_servico'].'"></td>';
                  echo '<td><button type="submit" class="btn btn-danger" name="btn_cd_'.$servico['cd_servico'].'" id="btn_cd_'.$servico['cd_servico'].'">'.$servico['cd_servico'].'</button></td>';
                  echo '</form>';

                    echo '<script>document.getElementById("btn_cd_'.$servico['cd_servico'].'").className = "btn btn-danger";</script>';
                    $arquivado = $arquivado + 1;
                  

              //    // Contagem de equipamentos em uso
              //    $sql_cliente = "SELECT * FROM tb_cliente WHERE cd_cliente = '".$servico['cd_cliente']."'"; 
              //    $resulta_cliente = $conn->query($sql_cliente);
              //    $cliente = $resulta_cliente->fetch_assoc();
                  
              //    echo '<td>'.$cliente['pnome_cliente'].'</td>';

              //    // Contagem de equipamentos fora de uso
                  
              //    echo '<td>'.$cliente['tel_cliente'].'</td>';

              //    //echo '<td><label class="badge badge-info">'.$qtd_uso.'</label></td>';
              //    //echo '<td><label class="badge badge-warning">'.$qtd_fora_de_uso.'</label></td>';
                  
                  


                  
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
                  }
                  echo '<td>'.date('d/m/y', strtotime($servico['prazo_servico'])).'</td>';
                  echo '<script>document.getElementById("botoes").style.display = "none";</script>';//
                }
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                if($arquivado > 0){
                  echo '<script>document.getElementById("arquivado").innerHTML = "'.$arquivado.'";</script>';
                  echo '<script>document.getElementById("arquivado").style.display = "block";</script>';
                }
              }

              if($parahoje > 0){
                echo '<script>document.getElementById("parahoje").innerHTML = "Para Hoje</br>'.$parahoje.'";</script>';
                echo '<script>document.getElementById("parahoje").style.display = "block";</script>';
              }
              if($noprazo > 0){
                echo '<script>document.getElementById("noprazo").innerHTML = "No Prazo</br>'.$noprazo.'";</script>';
                echo '<script>document.getElementById("noprazo").style.display = "block";</script>';
              }
              if($extrapolado > 0){
                echo '<script>document.getElementById("extrapolado").innerHTML = "Prazo Extrapolado</br>'.$extrapolado.'";</script>';
                echo '<script>document.getElementById("extrapolado").style.display = "block";</script>';
              }
              
            ?>
        
     
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