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
    if(isset($_SESSION['venda_cliente'])){
      echo '<script>document.getElementById("abrirOS").style.display = "block";</script>';      
    }
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
  <title>Nova Conta</title>
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
  
  
  


<script>
              		function abrirCadastro() {
                	  document.getElementById("cadastroCliente").style.display = "block";
                  	document.getElementById("consulta").style.display = "none";
                    
                    document.getElementById("showOS").style.display = "none";
                    document.getElementById("pergunta1").style.display = "none";
                  }

                  function abrirConsulta() {
                  	document.getElementById("cadastroCliente").style.display = "none";
                  	document.getElementById("consulta").style.display = "block";
                      
                    document.getElementById("showOS").style.display = "none";
                    document.getElementById("pergunta1").style.display = "none";
                  }

                  function fechacadServico() {                     
                    document.getElementById("showOS").style.display = "none";
                  }
                </script>
</head>

<!--<body onmousemove="resetTimer()" onclick="resetTimer()" onkeypress="resetTimer()">-->

<body>

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
              <div class="card">
                <div class="card-body" id="consulta" >
                  <h4 class="card-title">Identifique o cliente</h4>
                  <div class="kt-portlet__body">
                    <div class="row">
                      <div class="col-12 col-md-12">
                        <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                          <form method="POST"> 
                            <div class="form-group" style="display: flex;">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <select name="cd_pais" id="cd_pais"  class="input-group-text" required>
                                    <option selected="selected" value="55">+55 Brasil</option>
                                  </select>  
                                </div>
                                <input placeholder="Telefone do Cliente" type="tel" name="contel_cliente" id="contel_cliente" oninput="tel(this)" class=" form-control form-control-sm" required oninput="validateInput(this)">
                              </div>
                            </div>
                            <p id="error-message" style="color: #DDDDDD;"></p>
                            <br>
                            <button type="submit" name="consulta" class="btn btn-block btn-success">Consulta</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              


                <?php  
                  if(isset($_POST['limparVenda'])){
                    //echo "<script>window.alert('Mostrar botão de limpar Venda!');</script>";
                    ////session_start();
                    $_SESSION['venda_cliente'] = 0;
                    $_SESSION['cd_venda'] = 0;
                    $_SESSION['venda'] = 0;
                    $_SESSION['cd_cliente_comercial'] = 0;
                    $_SESSION['vcusto_venda'] = 0;
                    $_SESSION['vpag_venda'] = 0;
                  
                    echo '<script>document.getElementById("consulta").style.display = "block";</script>';//botoes
                    echo '<script>document.getElementById("cadOs").style.display = "none";</script>';//
                    echo '<script>document.getElementById("cadastroCliente").style.display = "none";</script>';
                  }

                  if(!isset($_SESSION['cd_venda'])){
                    $_SESSION['cd_venda'] = 0;
                  }

                  if(isset($_POST['cad_cliente'])) {
                    //include("../../partials/load.html");
                    // Atualiza as informações do usuário no banco de dados
                    $query = "INSERT INTO tb_pessoa(pnome_pessoa, snome_pessoa, tel1_pessoa, id_google, id_facebook, tipo_pessoa) VALUES(
                      '".$_POST['pnome_cliente']."',
                      '".$_POST['snome_cliente']."',
                      '".$_POST['cd_pais'].$_POST['tel_cliente']."',
                      'N',
                      'N',
                      'cliente')
                    ";
                    if(mysqli_query($conn, $query)){
                      $last_id = mysqli_insert_id($conn);
                      echo "<script>alert('| - | - | - | Cliente cadastrado com sucesso (".$last_id.") | - | - | - |');</script>";

                      $result_cliente = $u->conPessoa('cliente', 'codigo', $last_id);

                    if($result_cliente['status'] == 'OK'){
                      $_SESSION['venda_cliente'] = $result_cliente['cd_cliente'];
                      echo '<script>document.getElementById("pergunta1").style.display = "none";</script>';
                      echo '<script>document.getElementById("consulta").style.display = "none";</script>';

                      
                      if($result_cliente['alerta_financeiro'] != 'OK'){
                        echo "<script>alert('" . $result_cliente['alerta_financeiro'] . "');</script>";
                        echo $result_cliente['acao_alerta'];
                      }
                      
                      echo '</div>';
                              
                      
                    }else if($result_cliente['status'] == 'Não encontrado cliente'){
                      echo '<script>document.getElementById("pergunta1").style.display = "none";</script>';
                      echo '<script>document.getElementById("consulta").style.display = "none";</script>';

                      echo '<div class="card-body" id="cadastroCliente" style="display:block;">
                  <h3 class="kt-portlet__head-title">Dados do clientessss</h3>
                  <div class="kt-portlet__body">
                    <div class="row">
                      <div class="col-12 col-md-12">
                        <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                          <form method="POST">
                            <div  class="typeahead">
                              <div class="form-group-custom">
                                <label for="pnome_cliente">Nome</label>
                                <input name="pnome_cliente" type="text" id="pnome_cliente" maxlength="40"   class=" form-control form-control-sm" required/>
                              </div>

                              <div class="form-group-custom">
                                <label for="snome_cliente">sobrenome</label>
                                <input name="snome_cliente" type="text" id="snome_cliente" maxlength="40"   class=" form-control form-control-sm" />
                              </div>

                              <div class="form-group-custom">
                                <label for="tel_cliente">Telefone</label>
                                <input name="tel_cliente" type="tel" value="'.$_POST['cd_pais'].$_POST['contel_cliente'].'" id="tel_cliente" oninput="tel(this)" class=" form-control form-control-sm" readonly/>
                              <!--<input type="submit" class="btn btn-success" value="Salvar">-->
                              </div>
                            </div>
                            <button type="submit" name="cad_cliente" class="btn btn-block btn-lg btn-success" >Salvar</button>
                          </form>
                          <form method="post">
                            <button type="submit" class="btn btn-block btn-lg btn-danger" name="limparConta" style="margin: 5px;">Refazer</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>';
                      echo '<script>document.getElementById("tel_cliente").value = "'.$_POST['cd_pais'].$_POST['contel_cliente'].'"</script>';
                    }else{
                      echo "<script>alert('| - | - | - | ". $result_cliente['status'] . " | - | - | - |');</script>";
                    }

                    }else{
                      echo "<script>alert('| - | - | - | Falha ao cadastrar | - | - | - |');</script>";

                    }
                      
                    

                  }

                  if(isset($_POST['contel_cliente'])) { //CHAMAR CLIENTE CADASTRADO PARA SESSION

                    $result_cliente = $u->conPessoa('cliente', 'telefone', $_POST['cd_pais'].$_POST['contel_cliente']);

                    if($result_cliente['status'] == 'OK'){
                      $_SESSION['venda_cliente'] = $result_cliente['cd_cliente'];
                      echo '<script>document.getElementById("pergunta1").style.display = "none";</script>';
                      echo '<script>document.getElementById("consulta").style.display = "none";</script>';

                      
                      if($result_cliente['alerta_financeiro'] != 'OK'){
                        echo "<script>alert('" . $result_cliente['alerta_financeiro'] . "');</script>";
                        echo $result_cliente['acao_alerta'];
                      }
                      
                      
                      $result_venda = $u->conVenda(
                        'CC',
                        $result_cliente['cd_cliente'],
                        $_SESSION['cd_filial']
                      );
                      if($result_venda['status'] == 'OK'){
                        //echo '<h1>Venda</h1>';
                        //echo $result_venda['partial_venda'];
                        
                        
                        $_SESSION['cd_venda']         = $result_venda['cd_venda'];
                        $_SESSION['venda']            = $result_venda['cd_venda'];
                          

                      }else{
                        echo "<h1>".$result_venda['status']."</h1>";
                        echo $result_venda['partial_venda'];
                        echo "<script>alert('| - | - | - | ... | - | - | - |');</script>";

                      }
                      
                    }else if($result_cliente['status'] == 'Não encontrado cliente'){
                      echo '<script>document.getElementById("pergunta1").style.display = "none";</script>';
                      echo '<script>document.getElementById("consulta").style.display = "none";</script>';

                      echo '<div class="card-body" id="cadastroCliente" style="display:block;">
                  <h3 class="kt-portlet__head-title">Dados do cliente</h3>
                  <div class="kt-portlet__body">
                    <div class="row">
                      <div class="col-12 col-md-12">
                        <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                          <form method="POST">
                            <div  class="typeahead">
                              <div class="form-group-custom">
                                <label for="pnome_cliente">Nome</label>
                                <input name="pnome_cliente" type="text" id="pnome_cliente" maxlength="40"   class=" form-control form-control-sm" required/>
                              </div>

                              <div class="form-group-custom">
                                <label for="snome_cliente">sobrenome</label>
                                <input name="snome_cliente" type="text" id="snome_cliente" maxlength="40"   class=" form-control form-control-sm" />
                              </div>

                              <div class="form-group-custom">
                                <label for="tel_cliente">Telefone</label>
                                <input name="tel_cliente" type="tel" value="'.$_POST['cd_pais'].$_POST['contel_cliente'].'" id="tel_cliente" oninput="tel(this)" class=" form-control form-control-sm" readonly/>
                              <!--<input type="submit" class="btn btn-success" value="Salvar">-->
                              </div>
                            </div>
                            <button type="submit" name="cad_cliente" class="btn btn-block btn-lg btn-success" >Salvar</button>
                          </form>
                          <form method="post">
                            <button type="submit" class="btn btn-block btn-lg btn-danger" name="limparConta" style="margin: 5px;">Refazer</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>';
                      echo '<script>document.getElementById("tel_cliente").value = "'.$_POST['cd_pais'].$_POST['contel_cliente'].'"</script>';
                    }else{
                      echo "<script>alert('| - | - | - | ". $result_cliente['status'] . " | - | - | - |');</script>";
                    }
                    
                  }

                  if(isset($_POST['cadVenda'])) { //CADASTRAR SERVICO E CHAMAR SERVICO CADASTRADO PARA SESSION

                    $retornoCadVenda = $u->cadVenda(
                      $_POST['cd_cliente'],
                      $_SESSION['cd_colab'],
                      $_SESSION['cd_empresa']
                    );
                    
                    if($retornoCadVenda['status'] == 'OK'){

                      echo "<script>alert('Conta Gerada: " . $retornoCadVenda['cd_venda'] . "');</script>";
                      ////$_SESSION['cd_venda'] = $retornoCadServico[''];
                      $_SESSION['cd_venda']         = $retornoCadVenda['cd_venda'];
                      $_SESSION['venda']            = $retornoCadVenda['cd_venda'];
                      $_SESSION['cd_cliente']       = $retornoCadVenda['cd_cliente'];
                      $_SESSION['titulo_venda']     = $retornoCadVenda['titulo_venda'];
                      $_SESSION['obs_venda']        = $retornoCadVenda['obs_venda'];        
                      $_SESSION['prioridade_venda'] = $retornoCadVenda['prioridade_venda']; 
                      $_SESSION['entrada_venda']    = $retornoCadVenda['entrada_venda'];    
                      $_SESSION['prazo_venda']      = $retornoCadVenda['prazo_venda'];      
                      $_SESSION['orcamento_venda']  = $retornoCadVenda['orcamento_venda'];  
                      $_SESSION['vpag_venda']       = $retornoCadVenda['vpag_venda'];       
                  
                    }else{
                      echo "<script>alert('| - | - | - | ". $retornoCadServico['status'] . " | - | - | - |');</script>";
                    }

                  }

                  if(isset($_POST['editVenda'])) {
                    
                    $result_venda = $u->editVenda(
                      $_POST['cd_venda'],
                      $_SESSION['cd_empresa'],
                      $_POST['titulo_venda'],
                      $_POST['fechamento_venda'],
                      $_POST['orcamento_venda'],
                      $_POST['vpag_venda'],
                      $_POST['status_venda']
                    );
                    /*
                    if($result_venda['status'] == 'OK') {                          
                      $_SESSION['obs_venda']        = $result_venda['obs_venda'];
                      $_SESSION['prioridade_venda'] = $result_venda['prioridade_venda'];
                      $_SESSION['prazo_venda']      = $result_venda['prazo_venda'];
                    }*/

                  }

                  if(isset($_POST['lancarOrcamento'])) { 
                    $result_orcamento = $u->cadOrcamento('AVULSO', $_POST['cd_cliente'],$_SESSION['cd_empresa'], $_POST['cd_venda'], $_POST['titulo_orcamento'], $_POST['vcusto_venda']);
                    if($result_orcamento['status'] == 'OK'){
                      //echo "<script>alert('Orçamento gerado: " . $result_orcamento['cd_orcamento'] . "');</script>";
                      //echo "<script>alert('SQL: " . addslashes(json_encode($result_orcamento['SQL'], JSON_PRETTY_PRINT)) . "');</script>";
                      //echo "<script>alert('| - | - | - | ". $result_orcamento['status'] . " | - | - | - |');</script>";
                    }else{
                      echo "<script>alert('SQL: " . addslashes(json_encode($result_orcamento['SQL'], JSON_PRETTY_PRINT)) . "');</script>";
                      echo "<script>alert('| - | - | - | ".$result_orcamento['cd_orcamento'].' - '. $result_orcamento['status'] . " | - | - | - |');</script>";
                    }
          
                  }

                  if(isset($_POST['lancarOrcamentoCadastro'])) {      
                    if($_POST['produto_venda']==false){
                      $_SESSION['produto_venda'] = $_POST['produto_venda_nome'];
                      $_SESSION['produto_venda_id'] = $_POST['produto_venda_id2'];
                      $_SESSION['produto_venda_preco'] = str_replace(',', '.', $_POST['produto_venda_preco']);
                      $_SESSION['produto_venda_qtd'] = $_POST['produto_venda_qtd'];
                      $_SESSION['produto_venda_vtotal'] = str_replace(',', '.', $_POST['produto_venda_vtotal']); 
                      echo "<script>window.alert('Selecione um produto!');</script>"; 
                    }elseif($_POST['produto_venda_qtd']<1){
                      $_SESSION['produto_venda'] = $_POST['produto_venda_nome'];
                      $_SESSION['produto_venda_id'] = $_POST['produto_venda_id2'];
                      $_SESSION['produto_venda_preco'] = str_replace(',', '.', $_POST['produto_venda_preco']);
                      $_SESSION['produto_venda_qtd'] = $_POST['produto_venda_qtd'];
                      $_SESSION['produto_venda_vtotal'] = str_replace(',', '.', $_POST['produto_venda_vtotal']);
                      echo "<script>window.alert('A quantidade não pode ser menor que 1!');</script>";  
                    }else{
                      if($_POST['produto_venda_estoque'] >= $_POST['produto_venda_qtd']){
                          //echo "<script>window.alert('1');</script>";
                        $insertOrcamento = "INSERT INTO tb_orcamento_venda(cd_cliente, cd_filial, cd_venda, titulo_orcamento, cd_produto, vcusto_orcamento, qtd_orcamento, vtotal_orcamento, status_orcamento) VALUES(
                          '".$_SESSION['venda_cliente']."',
                          '".$_SESSION['cd_filial']."',
                          '".$_SESSION['cd_venda']."',
                          '".$_POST['produto_venda_nome']."',
                          '".$_POST['produto_venda_id2']."',
                          '".str_replace(',', '.', $_POST['produto_venda_preco'])."',
                          '".$_POST['produto_venda_qtd']."',
                          '".str_replace(',', '.', $_POST['produto_venda_vtotal'])."',
                          '0')
                        ";
                        //echo "<script>window.alert(" . json_encode($insertOrcamento) . ");</script>";
                        //echo "<script>window.alert('".addslashes($insertOrcamento)."');</script>";
                        //mysqli_query($conn, $insertOrcamento);
                        if (mysqli_query($conn, $insertOrcamento)) {
                          //echo "<script>window.alert('3');</script>";

                          // Obtém o último ID inserido
                          $cd_orcamento = mysqli_insert_id($conn);
                          $insertReserva = "INSERT INTO tb_reserva(cd_cliente, cd_venda, cd_orcamento, cd_prod_serv, qtd_reservado, dt_reservado) VALUES(
                            '".$_SESSION['venda_cliente']."',
                            '".$_SESSION['cd_venda']."',
                            ".$cd_orcamento.",
                            '".$_POST['produto_venda_id2']."',
                            '".$_POST['produto_venda_qtd']."',
                            now())
                          ";
                          //echo "<script>window.alert(" . json_encode($insertReserva) . ");</script>";

                          mysqli_query($conn, $insertReserva);
                        } else {
                          echo "Erro ao inserir os dados: " . mysqli_error($conn);
                        }
                        $_SESSION['vcusto_venda'] = $_SESSION['orcamento_venda'] + str_replace(',', '.', $_POST['produto_venda_vtotal']);   
                        $updateVenda = "UPDATE tb_venda SET
                          orcamento_venda = orcamento_venda + ".$_POST['produto_venda_vtotal']."
                          WHERE cd_venda = ".$_SESSION['cd_venda']."";
                        if(mysqli_query($conn, $updateVenda)){
                          //echo "<script>window.alert(" . json_encode($updateVenda) . ");</script>";
                          //echo "<script>window.alert('".$_POST['vcusto_venda']." + ".$_SESSION['orcamento_venda']." = ".$_SESSION['vcusto_venda']."');</script>";
                        }else{
                          echo "<script>window.alert('erro');</script>";
                        }
                        $_SESSION['produto_venda'] = false;
                        $_SESSION['produto_venda_preco'] = false;
                        $_SESSION['produto_venda_qtd'] = false;
                        $_SESSION['produto_venda_vtotal'] = false;
                      }else{
                        echo "<script>window.alert('A quantidade não pode ser maior que o estoque disponível (".$_POST['produto_venda_estoque'].")!');</script>";
                      }
                      
                    }            
                  }
                        

                  if(isset($_POST['listaremover_orcamento'])) {//DELETE FROM `tb_orcamento_venda` WHERE `tb_orcamento_venda`.`cd_orcamento` = 198
                    if(($_SESSION['vcusto_venda'] - $_POST['listavalor_orcamento'])>=$_SESSION['vpag_venda']){
                      //echo "<script>window.alert('OK, pode remover');</script>";
                      $removeOrcamento = "DELETE FROM `tb_orcamento_venda` WHERE `tb_orcamento_venda`.`cd_orcamento` = '".$_POST['listaid_orcamento']."'";
                      mysqli_query($conn, $removeOrcamento);
                      $updateVtotalServico = "UPDATE tb_venda SET
                        orcamento_venda = orcamento_venda - ".$_POST['listavalor_orcamento']."
                        WHERE cd_venda = ".$_SESSION['cd_venda']."";
                      mysqli_query($conn, $updateVtotalServico);
                      if($_POST['listatipo_orcamento'] == 'CADASTRADO'){
                        $removeReserva = "DELETE FROM `tb_reserva` WHERE `tb_reserva`.`cd_orcamento` = ".$_POST['listaid_orcamento']."";
                        mysqli_query($conn, $removeReserva);
                      }
                      //echo "<script>window.alert('a!');</script>";  
                        echo '<script>location.href="'.$_SESSION['dominio'].'pages/md_assistencia/cadastro_venda.php";</script>';          
                    }else{
                      echo "<script>window.alert('Valor pago não pode ser maior que o total do Venda!');</script>";  
                    }
                  }

                  if (isset($_POST['listaremover_orcamento_efetivado']) && !isset($_POST['confirmacao'])) {
                    // Construir a mensagem com os itens separados por quebra de linha
                    $mensagem = "O item selecionado retornará ao estoque?";
  
                    // Gerar o modal via PHP
                    echo '
                      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                      <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Confirmação</h5>
                      <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                      </button>-->
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
                      <button type="submit" name="confirmacao" value="sim" class="btn btn-success">Sim</button>
                      <button type="submit" name="confirmacao" value="nao" class="btn btn-danger">Não</button>
                      <button type="submit" name="confirmacao" value="cancelar" class="btn btn-secondary">Cancelar</button>
                      </form>
                      </div>
                      </div>
                      </div>
                      </div>
                      <script>
                      $(document).ready(function() {
                      $("#exampleModalCenter").modal("show");
                      });
                      </script>';
                    }

if (isset($_POST['confirmacao'])) {

if ($_POST['confirmacao'] === 'sim') {
  $updateEstoque = "
      UPDATE `tb_prod_serv` 
      INNER JOIN `tb_orcamento_venda` 
      ON `tb_prod_serv`.`cd_prod_serv` = `tb_orcamento_venda`.`cd_produto` 
      SET `tb_prod_serv`.`estoque_prod_serv` = `tb_prod_serv`.`estoque_prod_serv` + `tb_orcamento_venda`.`qtd_orcamento` 
      WHERE `tb_orcamento_venda`.`cd_orcamento` = " . intval($_POST['listaid_orcamento']);
      
  if(mysqli_query($conn, $updateEstoque)){
    echo '<script>alert("1");</script>';

  }

  $removeReserva = "DELETE FROM `tb_reserva` WHERE `cd_orcamento` = " . intval($_POST['listaid_orcamento']);
  
  if(mysqli_query($conn, $removeReserva)){
    echo '<script>alert("2");</script>';

  }
  $removeOrcamentoServico = "DELETE FROM `tb_orcamento_venda` WHERE `cd_orcamento` = " . intval($_POST['listaid_orcamento']);
  if (mysqli_query($conn, $removeOrcamentoServico)) {
    // Atualizar o estoque
    
      
    
      echo '<script>alert("Reserva removida e estoque atualizado com sucesso!");</script>';
      echo '<script>location.href="'.$_SESSION['dominio'].'pages/md_assistencia/cadastro_venda.php";</script>';          
    
        
  
  } else {
      echo '<script>alert("Erro ao remover a reserva: ' . mysqli_error($conn) . '");</script>';
  }

} elseif ($_POST['confirmacao'] === 'nao') {
    echo '<script>alert("Não retornou ao estoque!");</script>';
    // Lógica para confirmação "Não"
} elseif ($_POST['confirmacao'] === 'cancelar') {
    echo '<script>alert("Operação cancelada pelo usuário.");</script>';
    // Lógica para "Cancelar"
}
}



                  
                    
                    
                    if(isset($_POST['limparConta'])){
                      //echo "<script>window.alert('Mostrar botão de limpar Venda!');</script>";
                      ////session_start();
                      $_SESSION['venda_cliente'] = 0;
                      $_SESSION['cd_venda'] = 0;
                      $_SESSION['vcusto_venda'] = 0;
                      $_SESSION['vpag_venda'] = 0;
                      echo '<script>document.getElementById("consulta").style.display = "block";</script>';//botoes
                      echo '<script>document.getElementById("botoes").style.display = "none";</script>';//    
                    }
                    
                    
                  
                  
                    
                      if(isset($_POST['pagar'])){
                        $retorno = $f->movimentoFinanceiro(
                                    'R',
                                    $_SESSION['cd_empresa'],
                                    $_SESSION['cd_caixa'],
                                    $_SESSION['venda_cliente'],
                                    $_SESSION['cd_colab'],
                                    '',
                                    $_SESSION['cd_venda'],
                                    $_POST['fpag_movimento'],
                                    $_POST['vpag_movimento']
                                  );
    
                        if($retorno['status'] == 'sucesso'){
                          echo "<script>alert('Total pago: " . $retorno['vpag'] . "');</script>";
                        }else{
                          echo "<script>alert('| - | - | - | ". $retorno['status'] . " | - | - | - |');</script>";
                        }
                      }


                
                  
                  
                  
                          
                  


                      if($_SESSION['cd_venda'] > 0){
                        $result_venda       = $u->conVenda('CV', $_SESSION['cd_venda'], $_SESSION['cd_empresa']);
                        $result_cliente     = $u->conPessoa('cliente', 'codigo', $result_venda['cd_cliente']);
                        $result_orcamento   = $u->listOrcamentoVenda($result_venda['cd_venda'], $_SESSION['cd_empresa'], true);
                        $result_financeiro  = $u->movimentoFinanceiro($_SESSION['dt_caixa'], $_SESSION['cd_empresa'], '', $result_venda['cd_venda'], $result_orcamento['falta_pagar']);
                        $result_impressao   = $u->impressao1($_SESSION['tipo_impressao'], 'VENDA', $_SESSION['cd_empresa'], $result_venda['cd_venda']);
                        $result_mensagem   = $u->mensagem1($_SESSION['tipo_mensagem'], 'VENDA', $_SESSION['cd_empresa'], $result_venda['cd_venda']);
                        echo '<script>document.getElementById("consulta").style.display = "none";</script>';

                        $_SESSION['venda_cliente'] = $result_cliente['cd_cliente'];
                        //echo '<p>Cliente</p>';
                        //echo $result_cliente['partial_cliente'];
                        
                        //echo '<p>Venda</p>';
                        echo $result_venda['partial_venda']; 
     
                        //echo '<p>Orcamento</p>';
                        echo $result_orcamento['partial_orcamento']; 
                        
                        //echo '<p>Financeiro</p>';
                        echo $result_financeiro['partial_financeiro'];
                        
                        echo '<p>Mensagens</p>';
                        echo $result_mensagem['partial_mensagem']; 

                        //echo '<p>Impressão</p>';
                        echo $result_impressao['partial_impressao'];
                            

        
                            
                      }elseif($_SESSION['cd_venda'] == ''){
                        
                        

                      }elseif($_SESSION['cd_venda'] == 0){
                      }


                    
                      
                      
                ?>
                
                <script>
                  var data = new Date();
                  var dia = data.getDate() + 5;
                  var mes = data.getMonth() + 1;
                  var ano = data.getFullYear();
                  var hora = '16';
                  var minuto = '00';

                  // Verifica se ultrapassou o último dia do mês
                  if (dia > new Date(ano, mes, 0).getDate()) {
                      dia = dia - new Date(ano, mes, 0).getDate();
                      mes++;
                  }

                  // Atualiza o ano e o mês se necessário
                  if (mes > 12) {
                      mes = 1;
                      ano++;
                  }

                  document.getElementById("prazo_venda").value = `${ano}-${mes.toString().padStart(2, '0')}-${dia.toString().padStart(2, '0')}T${hora.toString().padStart(2, '0')}:${minuto.toString().padStart(2, '0')}`;
                </script>

</div>


                

          
          

  <script>
    
    window.onload = function () {
        var data = new Date();
        var mes = data.getMonth() + 1;
        var dia = data.getDate();
        var ano = data.getFullYear();
        var hora = data.getHours();
        var minuto = data.getMinutes();

        var input = document.getElementById("data_hora_ponto");
        if (input) {
            input.value = `${ano}-${mes.toString().padStart(2, '0')}-${dia.toString().padStart(2, '0')}T${hora.toString().padStart(2, '0')}:${minuto.toString().padStart(2, '0')}`;
        } else {
            console.warn("Elemento #data_hora_ponto não encontrado.");
        }
    };
  </script>

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