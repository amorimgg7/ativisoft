<?php 
    session_start(); 
//    if(!isset($_SESSION['cd_colab']))
//    {
//        header("location: ../../pages/samples/login.php");
//        exit;
//    }
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
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                

                
                 	
                


                <div class="card-body" id="consulta" style="display: block;">
                  <h4 class="card-title">Acompanhe o carrinho do cliente</h4>
                  <p class="card-description">Consulte todos os produtos adicionados ao carrinho do cliente!</p>
                  <div class="kt-portlet__body">
                    <div class="row">
                      <div class="col-12 col-md-12">
                        <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                          <form method="POST">                
                            <input placeholder="Telefone" type="tel" name="contel_cliente" id="contel_cliente" type="tel" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" required>
                            <br>
                            <button type="submit" name="consulta" class="btn btn-success" >Consulta</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <?php //session_start();
            if(isset($_POST['contel_cliente_carrinho'])) {
              $query_select_cliente = "SELECT * FROM tb_cliente WHERE tel_cliente = '".$_POST['contel_cliente_carrinho']."'";
              $result_select_cliente = mysqli_query($conn, $query_select_cliente);
              $row_select_cliente = mysqli_fetch_assoc($result_select_cliente);
              // Exibe as informações do usuário no formulário
              if($row_select_cliente) {
                $_SESSION['acompanha_cd_cliente'] = $row_select_cliente['cd_cliente'];
                $_SESSION['acompanha_pnome_cliente'] = $row_select_cliente['pnome_cliente'];
                $_SESSION['acompanha_snome_cliente'] = $row_select_cliente['snome_cliente'];
                $_SESSION['acompanha_tel_cliente'] = $row_select_cliente['tel_cliente'];
              }          
            }
            if($_SESSION['acompanha_cd_cliente'] > 0){
              echo '<div class="col-12 grid-margin stretch-card">';
              echo '<div class="card">';
              echo '<div class="card-body">';
              echo '<h4 class="card-title">Ficha do cliente</h4>';
                
              echo '<div class="table-responsive">';
              echo '<table class="table">';
              echo '<thead>';
              echo '<tr>';
              echo '<th>Nome completo</th>';
              echo '<th>Telefone</th>';
              echo '</tr>';
              echo '</thead>';
              echo '<tbody>';

              echo '<tr>';
              echo '<td>'.$_SESSION['acompanha_pnome_cliente'].' '.$_SESSION['acompanha_snome_cliente'].'</td>';
              echo '<form method="POST" target="_blank">';
              echo '<td><button type="button" class="btn btn-social-icon-text btn-success" onclick="enviarFichaWhatsApp()" style="margin: 5px;"><i class="mdi mdi-whatsapp"></i>'.$_SESSION['acompanha_tel_cliente'].'</button></td>';
              echo '</form>';
              echo '</tbody>';
              echo '</table>';
              echo '</div>';
              echo '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';

              //echo '<canvas id="pieChart" width="585" height="292" style="display: block; width: 585px; height: 292px;" class="chartjs-render-monitor"></canvas>';
              //echo '<canvas id="pieChart" width="585" height="292"></canvas>';

              //echo '<div class="col-lg-6 grid-margin grid-margin-lg-0 stretch-card">';
              //echo '<div class="card">';
              //echo '  <div class="card-body">';
              echo '    <h4 class="card-title">Gráfico de Serviços</h4>';
              echo '    <canvas id="pieChart"></canvas>';
              //echo '  </div>';
              //echo '</div>';
              //echo '</div>';

              
              echo '</div>';
              echo '</div>';
              echo '</div>';
            }
          ?>
          <?php
            if($_SESSION['acompanha_cd_cliente'] > 0) {
              //$query_count_0 = "SELECT * FROM tb_servico WHERE status_servico = '0' AND cd_cliente = '".$_SESSION['acompanha_cd_cliente']."'";
              $query_count_0 = "SELECT COUNT(*) as count0 FROM tb_servico WHERE status_servico = '0' AND cd_cliente = '".$_SESSION['acompanha_cd_cliente']."'";
              $query_count_1 = "SELECT COUNT(*) as count1 FROM tb_servico WHERE status_servico = '1' AND cd_cliente = '".$_SESSION['acompanha_cd_cliente']."'";
              $query_count_2 = "SELECT COUNT(*) as count2 FROM tb_servico WHERE status_servico = '2' AND cd_cliente = '".$_SESSION['acompanha_cd_cliente']."'";
              $query_count_3 = "SELECT COUNT(*) as count3 FROM tb_servico WHERE status_servico = '3' AND cd_cliente = '".$_SESSION['acompanha_cd_cliente']."'";

              $result_count_0 = mysqli_query($conn, $query_count_0);
              $result_count_1 = mysqli_query($conn, $query_count_1);
              $result_count_2 = mysqli_query($conn, $query_count_2);
              $result_count_3 = mysqli_query($conn, $query_count_3);

              $row_count_0 = mysqli_fetch_assoc($result_count_0);
              $row_count_1 = mysqli_fetch_assoc($result_count_1);
              $row_count_2 = mysqli_fetch_assoc($result_count_2);
              $row_count_3 = mysqli_fetch_assoc($result_count_3);
              
              // Exibe as informações do usuário no formulário
              session_start();
              if($row_count_0['count0'] > 0) {
                $_SESSION['count0'] = $row_count_0['count0'];
                //$_SESSION['count0'] = 25;
              }else{
                $_SESSION['count0'] = 0;
              }
              if($row_count_1['count1'] > 0) {
                $_SESSION['count1'] = $row_count_1['count1'];
                //$_SESSION['count1'] = 25;
              }else{
                $_SESSION['count1'] = 0;
              }
              if($row_count_2['count2'] > 0) {
                $_SESSION['count2'] = $row_count_2['count2'];
                //$_SESSION['count2'] = 25;
              }else{
                $_SESSION['count2'] = 0;
              }
              if($row_count_3['count3'] > 0) {
                $_SESSION['count3'] = $row_count_3['count3'];
                //$_SESSION['count3'] = 25;
                //echo '<script>var count3 = 25;</script>';
              }else{
                $_SESSION['count3'] = 0;
              }
              
              
            }
          ?>
          <script>
                          function enviarFichaWhatsApp() {
                            // Obter os valores dos campos do formulário
                            var nomeCliente = "<?php session_start(); echo $_SESSION['acompanha_pnome_cliente'];?>";
                            var telefoneCliente = "<?php echo $_SESSION['acompanha_tel_cliente'];?>";
                            
                            var count0 = "<?php echo $_SESSION['count0'];?>";
                            var count1 = "<?php echo $_SESSION['count1'];?>";
                            var count2 = "<?php echo $_SESSION['count2'];?>";
                            var count3 = "<?php echo $_SESSION['count3'];?>";
                            

                            
                            var mensagem = "*Olá, " + nomeCliente + "!*\n";
                            mensagem += "*Gráfico de Serviços:*\n\n";
                            
                              

                            if(count0 > 0){
                              mensagem += "À Fazer:                   ";
                              for (var i = 0; i < count0; i++) {
                                mensagem += "█";
                              }
                              mensagem += count0 + "\n";
                            }

                            if(count1 > 0){
                              mensagem += "Em Andamento:     ";
                              for (var i = 0; i < count1; i++) {
                                mensagem += "█";
                              }
                              mensagem += count1 + "\n";
                            }

                            if(count2 > 0){
                              mensagem += "Finalizado:              ";
                              for (var i = 0; i < count2; i++) {
                                mensagem += "█";
                              }
                              mensagem += count2 + "\n";
                            }

                            if(count3 > 0){
                              mensagem += "Entregue:                ";
                              for (var i = 0; i < count3; i++) {
                                mensagem += "█";
                              }
                              mensagem += count3 + "\n";
                            }
                            mensagem += "__________________________________";
                            mensagem += "\n";
                            
                            
                            <?php
                              $select_entrada_servico = "SELECT * FROM tb_servico WHERE status_servico = 0 AND cd_cliente = '".$_SESSION['acompanha_cd_cliente']."'
                              ORDER BY 
                              CASE 
                              WHEN prioridade_servico = 'U' THEN 1
                              WHEN prioridade_servico = 'A' THEN 2
                              WHEN prioridade_servico = 'M' THEN 3
                              ELSE 4
                              END, cd_servico";
                              $result_entrada_servico = mysqli_query($conn, $select_entrada_servico);
                              echo 'mensagem += "*Serviços À fazer*\n";';
                              echo 'mensagem += "*|  OS  |Priori|           Prazo            |*\n";';
                              while($row_entrada_servico = $result_entrada_servico->fetch_assoc()) {
                                $counter = $counter + 1;
                                if($row_entrada_servico['prioridade_servico'] == "U"){$prioridade = "Urgen";}
                                if($row_entrada_servico['prioridade_servico'] == "A"){$prioridade = "Alta    ";}
                                if($row_entrada_servico['prioridade_servico'] == "M"){$prioridade = "Média";}
                                if($row_entrada_servico['prioridade_servico'] == "B"){$prioridade = "Baixa   ";}
                                //echo 'mensagem += count + " - '.$row_orcamento_whatsapp['titulo_orcamento'].' - '.$row_orcamento_whatsapp['vcusto_orcamento'].'"\n";';
                                ?>mensagem += "<?php echo '*| '.$row_entrada_servico['cd_servico'].'* |'.$prioridade.'| '.$row_entrada_servico['entrada_servico']; ?>|\n";<?php
                              }
                              echo 'mensagem += "__________________________________";';
                              echo 'mensagem += "\n";';
                            ?>

<?php
                              $select_andamento_servico = "SELECT * FROM tb_servico WHERE status_servico = 1 AND cd_cliente = '".$_SESSION['acompanha_cd_cliente']."'
                              ORDER BY 
                              CASE 
                              WHEN prioridade_servico = 'U' THEN 1
                              WHEN prioridade_servico = 'A' THEN 2
                              WHEN prioridade_servico = 'M' THEN 3
                              ELSE 4
                              END, cd_servico";
                              $result_andamento_servico = mysqli_query($conn, $select_andamento_servico);
                              echo 'mensagem += "*Serviços Em Andamento*\n";';
                              echo 'mensagem += "*|  OS  |Priori|           Prazo            |*\n";';
                              while($row_andamento_servico = $result_andamento_servico->fetch_assoc()) {
                                $counter = $counter + 1;
                                if($row_andamento_servico['prioridade_servico'] == "U"){$prioridade = "Urgen";}
                                if($row_andamento_servico['prioridade_servico'] == "A"){$prioridade = "Alta    ";}
                                if($row_andamento_servico['prioridade_servico'] == "M"){$prioridade = "Média";}
                                if($row_andamento_servico['prioridade_servico'] == "B"){$prioridade = "Baixa   ";}
                                //echo 'mensagem += count + " - '.$row_orcamento_whatsapp['titulo_orcamento'].' - '.$row_orcamento_whatsapp['vcusto_orcamento'].'"\n";';
                                ?>mensagem += "<?php echo '*| '.$row_andamento_servico['cd_servico'].'* |'.$prioridade.'| '.$row_andamento_servico['entrada_servico']; ?>|\n";<?php
                              }
                              echo 'mensagem += "__________________________________";';
                              echo 'mensagem += "\n";';
                            ?>
                            <?php
                              $select_finalizado_servico = "SELECT * FROM tb_servico WHERE status_servico = 2 AND cd_cliente = '".$_SESSION['acompanha_cd_cliente']."'
                              ORDER BY 
                              CASE 
                              WHEN prioridade_servico = 'U' THEN 1
                              WHEN prioridade_servico = 'A' THEN 2
                              WHEN prioridade_servico = 'M' THEN 3
                              ELSE 4
                              END, cd_servico";
                              $result_finalizado_servico = mysqli_query($conn, $select_finalizado_servico);
                              echo 'mensagem += "*Serviços Finalizados*\n";';
                              echo 'mensagem += "*|  OS  |Priori|           Prazo            |*\n";';
                              while($row_finalizado_servico = $result_finalizado_servico->fetch_assoc()) {
                                $counter = $counter + 1;
                                if($row_finalizado_servico['prioridade_servico'] == "U"){$prioridade = "Urgen";}
                                if($row_finalizado_servico['prioridade_servico'] == "A"){$prioridade = "Alta    ";}
                                if($row_finalizado_servico['prioridade_servico'] == "M"){$prioridade = "Média";}
                                if($row_finalizado_servico['prioridade_servico'] == "B"){$prioridade = "Baixa   ";}
                                //echo 'mensagem += count + " - '.$row_orcamento_whatsapp['titulo_orcamento'].' - '.$row_orcamento_whatsapp['vcusto_orcamento'].'"\n";';
                                ?>mensagem += "<?php echo '*| '.$row_finalizado_servico['cd_servico'].'* |'.$prioridade.'| '.$row_finalizado_servico['entrada_servico']; ?>|\n";<?php
                              }
                              echo 'mensagem += "__________________________________";';
                              echo 'mensagem += "\n";';
                            ?>
                            <?php
                              $select_entregue_servico = "SELECT * FROM tb_servico WHERE status_servico = 3 AND cd_cliente = '".$_SESSION['acompanha_cd_cliente']."'
                              ORDER BY 
                              CASE 
                              WHEN prioridade_servico = 'U' THEN 1
                              WHEN prioridade_servico = 'A' THEN 2
                              WHEN prioridade_servico = 'M' THEN 3
                              ELSE 4
                              END, cd_servico";
                              $result_entregue_servico = mysqli_query($conn, $select_entregue_servico);
                              echo 'mensagem += "*Serviços Entregues*\n";';
                              echo 'mensagem += "*|  OS  |Priori|           Prazo            |*\n";';
                              while($row_entregue_servico = $result_entregue_servico->fetch_assoc()) {
                                $counter = $counter + 1;
                                if($row_entregue_servico['prioridade_servico'] == "U"){$prioridade = "Urgen";}
                                if($row_entregue_servico['prioridade_servico'] == "A"){$prioridade = "Alta    ";}
                                if($row_entregue_servico['prioridade_servico'] == "M"){$prioridade = "Média";}
                                if($row_entregue_servico['prioridade_servico'] == "B"){$prioridade = "Baixa   ";}
                                //echo 'mensagem += count + " - '.$row_orcamento_whatsapp['titulo_orcamento'].' - '.$row_orcamento_whatsapp['vcusto_orcamento'].'"\n";';
                                ?>mensagem += "<?php echo '*| '.$row_entregue_servico['cd_servico'].'* |'.$prioridade.'| '.$row_entregue_servico['entrada_servico']; ?>|\n";<?php
                              }
                              echo 'mensagem += "__________________________________";';
                              echo 'mensagem += "\n";';
                            ?>


                            
                            
                            // Codificar a mensagem para uso na URL
                            var mensagemCodificada = encodeURIComponent(mensagem);
                            // Construir a URL do WhatsApp
                            var urlWhatsApp = "https://api.whatsapp.com/send?phone=55" + telefoneCliente + "&text=" + mensagemCodificada;
                            // Abrir a janela do WhatsApp com a mensagem preenchida
                            window.open(urlWhatsApp, "_blank");
                          }
                </script>

          <script>
        var ctx = document.getElementById('pieChart').getContext('2d');
        
        var aaa = 26;
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['À Fazer', 'Em Andamento', 'Liberado', 'Retirado / Devolvido'],
                datasets: [{
                    //data: [<?php //echo $_SESSION['count0'].','.$_SESSION['count1'].','.$_SESSION['count2'].','.$_SESSION['count3']?>], // 25% para cada valor
                    data: [<?php echo $_SESSION['count0'];?>,<?php echo $_SESSION['count1'];?>,<?php echo $_SESSION['count2'];?>,<?php echo $_SESSION['count3'];?>], // 25% para cada valor
                    
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)', // Cor para Valor 1
                        'rgba(54, 162, 235, 0.6)', // Cor para Valor 2
                        'rgba(255, 206, 86, 0.6)', // Cor para Valor 3
                        'rgba(75, 192, 192, 0.6)'  // Cor para Valor 4
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
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
          <div class="row mt-3">
            <div class="col-xl-3 flex-column d-flex grid-margin stretch-card">
              <div class="row flex-grow">


                <?php //À FAZER
                  //"SELECT marca_patrimonio, modelo_patrimonio, COUNT(*) AS total FROM tb_patrimonio WHERE tipo_patrimonio = 'Impressora' GROUP BY marca_patrimonio, modelo_patrimonio";
                  //$sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 0";
                  if($_SESSION['acompanha_cd_cliente'] > 0) {
                    $sql_cliente = "SELECT * FROM tb_cliente WHERE tel_cliente = '".$_SESSION['acompanha_tel_cliente']."'";
                    $result_cliente = mysqli_query($conn, $sql_cliente);
                    $row_cliente = mysqli_fetch_assoc($result_cliente);
                    // Exibe as informações do usuário no formulário
                    if($row_cliente) {
                      echo '<script>document.getElementById("cd_cliente").value = "'.$row_cliente['cd_cliente'].'"</script>';
                      $sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 0 AND cd_cliente = '".$row_cliente['cd_cliente']."'
                        ORDER BY 
                        CASE 
                        WHEN prioridade_servico = 'U' THEN 1
                        WHEN prioridade_servico = 'A' THEN 2
                        WHEN prioridade_servico = 'M' THEN 3
                        ELSE 4
                        END, cd_servico";
                      $resulta_servico = $conn->query($sql_servico);
                      if ($resulta_servico->num_rows > 0){
                        echo '<div class="col-lg-6 grid-margin stretch-card">';
                        echo '<div class="card">';
                        echo '<div class="card-body">';
                        echo '<h4 class="card-title">À FAZER</h4>';
                        echo '<div class="table-responsive">';
                        echo '<table class="table">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th>OS</th>';
                        echo '<th>Prioridade</th>';
                        echo '<th>Prazo</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        while ( $servico = $resulta_servico->fetch_assoc()){
                          echo '<tr>';
                          echo '<td>'.$servico['cd_servico'].'</td>';
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
                          echo '<td>'.$servico['prazo_servico'].'</td>';
                        }
                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';
                        echo '</div>';
                        //echo '<button type="button" class="btn btn-social-icon-text btn-success" style="margin: 5px;"><i class="mdi mdi-whatsapp"></i>Enviar</button>';
                        //echo '<button type="button" class="btn btn-social-icon-text btn-info" style="margin: 5px;"><i class="mdi mdi-printer"></i>Imprimir</button>';
                        echo '</div>';
                        echo '</div>';
                      }
                    }          
                  }
                ?>

                <?php //EM ANDAMENTO
                  //"SELECT marca_patrimonio, modelo_patrimonio, COUNT(*) AS total FROM tb_patrimonio WHERE tipo_patrimonio = 'Impressora' GROUP BY marca_patrimonio, modelo_patrimonio";
                  //$sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 0";
                  if($_SESSION['acompanha_cd_cliente'] > 0) {
                    $sql_cliente = "SELECT * FROM tb_cliente WHERE tel_cliente = '".$_SESSION['acompanha_tel_cliente']."'";
                    $result_cliente = mysqli_query($conn, $sql_cliente);
                    $row_cliente = mysqli_fetch_assoc($result_cliente);
                    // Exibe as informações do usuário no formulário
                    if($row_cliente) {
                      echo '<script>document.getElementById("cd_cliente").value = "'.$row_cliente['cd_cliente'].'"</script>';
                      $sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 1 AND cd_cliente = '".$row_cliente['cd_cliente']."'
                        ORDER BY 
                        CASE 
                        WHEN prioridade_servico = 'U' THEN 1
                        WHEN prioridade_servico = 'A' THEN 2
                        WHEN prioridade_servico = 'M' THEN 3
                        ELSE 4
                        END, cd_servico";
                      $resulta_servico = $conn->query($sql_servico);
                      if ($resulta_servico->num_rows > 0){
                        echo '<div class="col-lg-6 grid-margin stretch-card">';
                        echo '<div class="card">';
                        echo '<div class="card-body">';
                        echo '<h4 class="card-title">EM ANDAMENTO</h4>';
                        echo '<div class="table-responsive">';
                        echo '<table class="table">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th>OS</th>';
                        echo '<th>Prioridade</th>';
                        echo '<th>Prazo</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        while ( $servico = $resulta_servico->fetch_assoc()){
                          echo '<tr>';
                          echo '<td>'.$servico['cd_servico'].'</td>';
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
                          echo '<td>'.$servico['prazo_servico'].'</td>';
                        }
                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';
                        echo '</div>';
                        //echo '<button type="button" class="btn btn-social-icon-text btn-success" style="margin: 5px;"><i class="mdi mdi-whatsapp"></i>Enviar</button>';
                        //echo '<button type="button" class="btn btn-social-icon-text btn-info" style="margin: 5px;"><i class="mdi mdi-printer"></i>Imprimir</button>';
                        echo '</div>';
                        echo '</div>';  
                      }
                    }          
                  }
                ?>

                <?php //LIBERADO
                  //"SELECT marca_patrimonio, modelo_patrimonio, COUNT(*) AS total FROM tb_patrimonio WHERE tipo_patrimonio = 'Impressora' GROUP BY marca_patrimonio, modelo_patrimonio";
                  //$sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 0";
                  if($_SESSION['acompanha_cd_cliente'] > 0) {
                    $sql_cliente = "SELECT * FROM tb_cliente WHERE tel_cliente = '".$_SESSION['acompanha_tel_cliente']."'";
                    $result_cliente = mysqli_query($conn, $sql_cliente);
                    $row_cliente = mysqli_fetch_assoc($result_cliente);
                    // Exibe as informações do usuário no formulário
                    if($row_cliente) {
                      echo '<script>document.getElementById("cd_cliente").value = "'.$row_cliente['cd_cliente'].'"</script>';
                      $sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 2 AND cd_cliente = '".$row_cliente['cd_cliente']."'
                        ORDER BY 
                        CASE 
                        WHEN prioridade_servico = 'U' THEN 1
                        WHEN prioridade_servico = 'A' THEN 2
                        WHEN prioridade_servico = 'M' THEN 3
                        ELSE 4
                        END, cd_servico";
                      $resulta_servico = $conn->query($sql_servico);
                      if ($resulta_servico->num_rows > 0){
                        echo '<div class="col-lg-6 grid-margin stretch-card">';
                        echo '<div class="card">';
                        echo '<div class="card-body">';
                        echo '<h4 class="card-title">LIBERADO PARA ENTREGA / DEVOLUÇÃO</h4>';
                        echo '<div class="table-responsive">';
                        echo '<table class="table">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th>OS</th>';
                        echo '<th>Prioridade</th>';
                        echo '<th>Prazo</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        while ( $servico = $resulta_servico->fetch_assoc()){
                          echo '<tr>';
                          echo '<td>'.$servico['cd_servico'].'</td>';
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
                          echo '<td>'.$servico['prazo_servico'].'</td>';
                        }
                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';
                        echo '</div>';
                        //echo '<button type="button" class="btn btn-social-icon-text btn-success" style="margin: 5px;"><i class="mdi mdi-whatsapp"></i>Enviar</button>';
                        //echo '<button type="button" class="btn btn-social-icon-text btn-info" style="margin: 5px;"><i class="mdi mdi-printer"></i>Imprimir</button>';
                        echo '</div>';
                        echo '</div>';  
                      }
                    }          
                  }
                ?>

                <?php //RETIRADO / DEVOLVIDO
                  //"SELECT marca_patrimonio, modelo_patrimonio, COUNT(*) AS total FROM tb_patrimonio WHERE tipo_patrimonio = 'Impressora' GROUP BY marca_patrimonio, modelo_patrimonio";
                  //$sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 0";
                  if($_SESSION['acompanha_cd_cliente'] > 0) {
                    $sql_cliente = "SELECT * FROM tb_cliente WHERE tel_cliente = '".$_SESSION['acompanha_tel_cliente']."'";
                    $result_cliente = mysqli_query($conn, $sql_cliente);
                    $row_cliente = mysqli_fetch_assoc($result_cliente);
                    // Exibe as informações do usuário no formulário
                    if($row_cliente) {
                      echo '<script>document.getElementById("cd_cliente").value = "'.$row_cliente['cd_cliente'].'"</script>';
                      $sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 3 AND cd_cliente = '".$row_cliente['cd_cliente']."'
                        ORDER BY 
                        CASE 
                        WHEN prioridade_servico = 'U' THEN 1
                        WHEN prioridade_servico = 'A' THEN 2
                        WHEN prioridade_servico = 'M' THEN 3
                        ELSE 4
                        END, cd_servico";
                      $resulta_servico = $conn->query($sql_servico);
                      if ($resulta_servico->num_rows > 0){
                        echo '<div class="col-lg-6 grid-margin stretch-card">';
                        echo '<div class="card">';
                        echo '<div class="card-body">';
                        echo '<h4 class="card-title">RETIRADO / DEVOLVIDO</h4>';
                        
                        echo '<div class="table-responsive">';
                        echo '<table class="table">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th>OS</th>';
                        echo '<th>Prioridade</th>';
                        echo '<th>Prazo</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        while ( $servico = $resulta_servico->fetch_assoc()){
                          echo '<tr>';
                          echo '<td>'.$servico['cd_servico'].'</td>';
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
                          echo '<td>'.$servico['prazo_servico'].'</td>';
                        }
                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';
                        echo '</div>';
                        //echo '<button type="button" class="btn btn-social-icon-text btn-success" style="margin: 5px;"><i class="mdi mdi-whatsapp"></i>Enviar</button>';
                        //echo '<button type="button" class="btn btn-social-icon-text btn-info" style="margin: 5px;"><i class="mdi mdi-printer"></i>Imprimir</button>';
                        echo '</div>';
                        echo '</div>';  
                      }
                    }          
                  }
                ?>
              </div>
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