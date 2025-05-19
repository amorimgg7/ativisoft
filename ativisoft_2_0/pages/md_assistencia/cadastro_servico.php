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
    if(isset($_SESSION['os_cliente'])){
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
  <title>Cadastro Servico</title>
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
  
  
  
<!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>-->

  <script>

    function updatePriceAndCode() {
    const select = document.getElementById('produto_servico');
    const selectedOption = select.options[select.selectedIndex];

    // Atualizar o preço
    const preco = selectedOption.getAttribute('data-preco') || 0;
    document.getElementById('produto_servico_preco').value = parseFloat(preco).toFixed(2);

    // Atualizar o ID do produto
    const cdProduto = selectedOption.value || '**';
    document.getElementById('produto_servico_id1').textContent = cdProduto;
    document.getElementById('produto_servico_id2').value = cdProduto;

    const tituloProdServ = selectedOption.text || '';
    document.getElementById('produto_servico_nome').value = tituloProdServ;

    const estoque = selectedOption.getAttribute('data-estoque') || 0;
    document.getElementById('produto_servico_estoque').value = estoque;

    const reserva = selectedOption.getAttribute('data-reserva') || 0;
    document.getElementById('produto_servico_reserva').value = reserva;


    // Recalcular o total
    calculateTotal();
}


    function calculateTotal() {
      const preco = parseFloat(document.getElementById('produto_servico_preco').value) || 0;
      const quantidade = parseFloat(document.getElementById('produto_servico_qtd').value) || 0;
      const estoque = parseFloat(document.getElementById('produto_servico_estoque').value) || 0;
      const reserva = parseFloat(document.getElementById('produto_servico_reserva').value) || 0;


      const total = preco * quantidade;

      // Validar se a quantidade excede o estoque
    if (quantidade > estoque) {
        // Adicionar borda vermelha
        document.getElementById('produto_servico_qtd').style.border = "2px solid red";
    } else if(quantidade > (estoque - reserva)){
      document.getElementById('produto_servico_qtd').style.border = "2px solid orange";
    }else{
        // Restaurar borda normal
        document.getElementById('produto_servico_qtd').style.border = "";
    }


      document.getElementById('produto_servico_vtotal').value = total.toFixed(2);
    }
</script>

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
                  if(isset($_POST['limparOS'])){
                    //echo "<script>window.alert('Mostrar botão de limpar OS!');</script>";
                    ////session_start();
                    $_SESSION['os_cliente'] = 0;
                    $_SESSION['cd_servico'] = 0;
                    $_SESSION['servico'] = 0;
                    $_SESSION['cd_cliente_comercial'] = 0;
                    $_SESSION['vcusto_orcamento'] = 0;
                    $_SESSION['vpag_servico'] = 0;
                  
                    echo '<script>document.getElementById("consulta").style.display = "block";</script>';//botoes
                    echo '<script>document.getElementById("cadOs").style.display = "none";</script>';//
                    echo '<script>document.getElementById("cadastroCliente").style.display = "none";</script>';
                  }

                  if(!isset($_SESSION['cd_servico'])){
                    $_SESSION['cd_servico'] = 0;
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
                      
                      echo '<script>document.getElementById("pergunta1").style.display = "none";</script>';
                      echo '<script>document.getElementById("consulta").style.display = "none";</script>';

                      echo '<div class="card-body" id="cadOs"><!--FORMULÁRIO PARA CRIAR OS-->';
                      echo '<div class="kt-portlet__body">';
                      echo '<div class="row">';
                      echo '<div class="col-12 col-md-12">';
                      echo '<div class="nc-form-tac">';
                      
                      echo '<form method="POST">';
                      echo '<h3 class="kt-portlet__head-title">Dados do Cliente</h3> ';
                      echo '<div  class="typeahead">';

                      echo '<div class="form-group-custom">';
                      echo '<input value="'.$result_cliente['cd_cliente'].'" name="cd_cliente" type="text" id="cd_cliente" class=" form-control form-control-sm" style="display: none;"/>';
                      echo '</div>';
                      echo '<div class="form-group-custom">';
                      echo '<label for="showpnome_cliente">Nome</label>';
                      echo '<input value="'.$result_cliente['pnome_cliente'].'" name="showpnome_cliente" type="text" id="showpnome_cliente" maxlength="40"   class=" form-control form-control-sm" readonly/>';
                      echo '</div>';
                      echo '<div class="form-group-custom">';
                      echo '<label for="showsnome_cliente">sobrenome</label>';
                      echo '<input value="'.$result_cliente['snome_cliente'].'" name="showsnome_cliente" type="text" id="showsnome_cliente" maxlength="40"   class=" form-control form-control-sm" readonly/>';
                      echo '</div>';
                      echo '<div class="form-group-custom">';
                      echo '<label for="showtel_cliente">Telefone</label>';
                      echo '<input value="'.$result_cliente['tel1_cliente'].'" name="showtel_cliente" type="tel"  id="showtel_cliente" oninput="tel(this)" class=" form-control form-control-sm" readonly/>';
                      echo '</div>';
                      if($result_cliente['alerta_financeiro'] != 'OK'){
                        echo "<script>alert('" . $result_cliente['alerta_financeiro'] . "');</script>";
                        echo $result_cliente['acao_alerta'];
                      }
                      
                      echo '</div>';
                              
                      echo '<h3 class="kt-portlet__head-title">Dados do serviço</h3>';
                      echo '<div  class="typeahead">';
                      echo '<input type="tel" name="cd_servico" id="cd_servico" style="display: none;">';
                      echo '<div class="form-group-custom">';
                      echo '<label for="obs_servico">Descrição Geral</label>';
                      echo '<input type="text" name="obs_servico" maxlength="999" id="obs_servico"  class="form-control form-control-sm" placeholder="Caracteristica geral do serviço" required>';
                      echo '<!--<textarea name="obs_servico" maxlength="999" id="obs_servico"  class="form-control form-control-sm" placeholder="Oque o cliente pediu pra fazer?" ></textarea>-->';
                      echo '</div>';
                      echo '<div class="form-group-custom">';   
                      echo '<label for="prioridade_servico">Prioridade</label>';
                      echo '<select name="prioridade_servico" id="prioridade_servico"  class="form-control form-control-sm" required>';
                      
                      echo '<option value="B">Baixa</option>';
                      echo '<option selected="selected" value="M">Média</option>';
                      echo '<option value="A">Alta</option>';
                      echo '<option value="U">Urgente</option>';
                      echo '</select>';
                      echo '</div>';
                      
                      echo '<!--<label for="showprazo_servico">Entrada</label>-->';
                      echo '<input name="data_hora_ponto" type="datetime-local" id="data_hora_ponto" placeholder="Data" class=" form-control form-control-sm" style="display: none;" />';
                      
                      echo '<div class="form-group-custom">';
                      echo '<label for="prazo_servico">Prazo</label>';
                      echo '<input name="prazo_servico" type="datetime-local" id="prazo_servico" placeholder="Data" class=" form-control form-control-sm" value="16:"/>';
                      echo '</div>';
                      echo '</div>';
                      echo '<button type="submit" name="cadServico" class="btn btn-block btn-lg btn-success" onclick="fechacadServico()">Lançar</button>';
                      echo '</form>';
                              
                      echo '</form>';
                      echo '<form method="post">';//echo '<button type="submit" class="btn btn-danger" name="limparOS" style="margin: 5px;">Nova Consulta</button>';
                      echo '<button type="submit" class="btn btn-block btn-lg btn-danger" name="limparOS" style="margin:10px 0px;">Refazer</button>';
                      echo '</form>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';

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
                            <button type="submit" class="btn btn-block btn-lg btn-danger" name="limparOS" style="margin: 5px;">Refazer</button>
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
                      
                      echo '<script>document.getElementById("pergunta1").style.display = "none";</script>';
                      echo '<script>document.getElementById("consulta").style.display = "none";</script>';

                      echo '<div class="card-body" id="cadOs"><!--FORMULÁRIO PARA CRIAR OS-->';
                      echo '<div class="kt-portlet__body">';
                      echo '<div class="row">';
                      echo '<div class="col-12 col-md-12">';
                      echo '<div class="nc-form-tac">';
                      
                      echo '<form method="POST">';
                      echo '<h3 class="kt-portlet__head-title">Dados do Cliente</h3> ';
                      echo '<div  class="typeahead">';

                      echo '<div class="form-group-custom">';
                      echo '<input value="'.$result_cliente['cd_cliente'].'" name="cd_cliente" type="text" id="cd_cliente" class=" form-control form-control-sm" style="display: none;"/>';
                      echo '</div>';
                      echo '<div class="form-group-custom">';
                      echo '<label for="showpnome_cliente">Nome</label>';
                      echo '<input value="'.$result_cliente['pnome_cliente'].'" name="showpnome_cliente" type="text" id="showpnome_cliente" maxlength="40"   class=" form-control form-control-sm" readonly/>';
                      echo '</div>';
                      echo '<div class="form-group-custom">';
                      echo '<label for="showsnome_cliente">sobrenome</label>';
                      echo '<input value="'.$result_cliente['snome_cliente'].'" name="showsnome_cliente" type="text" id="showsnome_cliente" maxlength="40"   class=" form-control form-control-sm" readonly/>';
                      echo '</div>';
                      echo '<div class="form-group-custom">';
                      echo '<label for="showtel_cliente">Telefone</label>';
                      echo '<input value="'.$result_cliente['tel1_cliente'].'" name="showtel_cliente" type="tel"  id="showtel_cliente" oninput="tel(this)" class=" form-control form-control-sm" readonly/>';
                      echo '</div>';
                      if($result_cliente['alerta_financeiro'] != 'OK'){
                        echo "<script>alert('" . $result_cliente['alerta_financeiro'] . "');</script>";
                        echo $result_cliente['acao_alerta'];
                      }
                      
                      echo '</div>';
                              
                      echo '<h3 class="kt-portlet__head-title">Dados do serviço</h3>';
                      echo '<div  class="typeahead">';
                      echo '<input type="tel" name="cd_servico" id="cd_servico" style="display: none;">';
                      echo '<div class="form-group-custom">';
                      echo '<label for="obs_servico">Descrição Geral</label>';
                      echo '<input type="text" name="obs_servico" maxlength="999" id="obs_servico"  class="form-control form-control-sm" placeholder="Caracteristica geral do serviço" required>';
                      echo '<!--<textarea name="obs_servico" maxlength="999" id="obs_servico"  class="form-control form-control-sm" placeholder="Oque o cliente pediu pra fazer?" ></textarea>-->';
                      echo '</div>';
                      echo '<div class="form-group-custom">';   
                      echo '<label for="prioridade_servico">Prioridade</label>';
                      echo '<select name="prioridade_servico" id="prioridade_servico"  class="form-control form-control-sm" required>';
                      
                      echo '<option value="B">Baixa</option>';
                      echo '<option selected="selected" value="M">Média</option>';
                      echo '<option value="A">Alta</option>';
                      echo '<option value="U">Urgente</option>';
                      echo '</select>';
                      echo '</div>';
                      
                      echo '<!--<label for="showprazo_servico">Entrada</label>-->';
                      echo '<input name="data_hora_ponto" type="datetime-local" id="data_hora_ponto" placeholder="Data" class=" form-control form-control-sm" style="display: none;" />';
                      
                      echo '<div class="form-group-custom">';
                      echo '<label for="prazo_servico">Prazo</label>';
                      echo '<input name="prazo_servico" type="datetime-local" id="prazo_servico" placeholder="Data" class=" form-control form-control-sm" value="16:"/>';
                      echo '</div>';
                      echo '</div>';
                      echo '<button type="submit" name="cadServico" class="btn btn-block btn-lg btn-success" onclick="fechacadServico()">Lançar</button>';
                      echo '</form>';
                              
                      echo '</form>';
                      echo '<form method="post">';//echo '<button type="submit" class="btn btn-danger" name="limparOS" style="margin: 5px;">Nova Consulta</button>';
                      echo '<button type="submit" class="btn btn-block btn-lg btn-danger" name="limparOS" style="margin:10px 0px;">Refazer</button>';
                      echo '</form>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';

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
                            <button type="submit" class="btn btn-block btn-lg btn-danger" name="limparOS" style="margin: 5px;">Refazer</button>
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

                  if(isset($_POST['cadServico'])) { //CADASTRAR SERVICO E CHAMAR SERVICO CADASTRADO PARA SESSION

                    $retornoCadServico = $u->cadServico(
                      $_POST['cd_cliente'],
                      $_SESSION['cd_colab'],
                      $_SESSION['cd_empresa'],
                      $_POST['obs_servico'],
                      $_POST['prioridade_servico'],
                      $_POST['data_hora_ponto'],
                      $_POST['prazo_servico']
                    );
                    
                    if($retornoCadServico['status'] == 'OK'){

                      echo "<script>alert('Ordem de Serviço Gerada: " . $retornoCadServico['cd_servico'] . "');</script>";
                      ////$_SESSION['cd_servico'] = $retornoCadServico[''];
                      $_SESSION['cd_servico']         = $retornoCadServico['cd_servico'];
                      $_SESSION['servico']            = $retornoCadServico['cd_servico'];
                      $_SESSION['cd_cliente']         = $retornoCadServico['cd_cliente'];
                      $_SESSION['titulo_servico']     = $retornoCadServico['titulo_servico'];
                      $_SESSION['obs_servico']        = $retornoCadServico['obs_servico'];        
                      $_SESSION['prioridade_servico'] = $retornoCadServico['prioridade_servico']; 
                      $_SESSION['entrada_servico']    = $retornoCadServico['entrada_servico'];    
                      $_SESSION['prazo_servico']      = $retornoCadServico['prazo_servico'];      
                      $_SESSION['orcamento_servico']  = $retornoCadServico['orcamento_servico'];  
                      $_SESSION['vpag_servico']       = $retornoCadServico['vpag_servico'];       
                  
                    }else{
                      echo "<script>alert('| - | - | - | ". $retornoCadServico['status'] . " | - | - | - |');</script>";
                    }

                  }

                  if(isset($_POST['editServico'])) {
                    
                    $result_servico = $u->editServico(
                      $_POST['cd_servico'],
                      $_SESSION['cd_empresa'],
                      $_POST['obs_servico'],
                      $_POST['prioridade_servico'],
                      $_POST['prazo_servico']
                    );
                    /*
                    if($result_servico['status'] == 'OK') {                          
                      $_SESSION['obs_servico']        = $result_servico['obs_servico'];
                      $_SESSION['prioridade_servico'] = $result_servico['prioridade_servico'];
                      $_SESSION['prazo_servico']      = $result_servico['prazo_servico'];
                    }*/

                  }

                  if(isset($_POST['lancarOrcamento'])) { 
                    $result_orcamento = $u->cadOrcamento('AVULSO', $_POST['cd_cliente'],$_SESSION['cd_empresa'], $_POST['cd_servico'], $_POST['titulo_orcamento'], $_POST['vcusto_orcamento']);
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
                    if($_POST['produto_servico']==false){
                      $_SESSION['produto_servico'] = $_POST['produto_servico_nome'];
                      $_SESSION['produto_servico_id'] = $_POST['produto_servico_id2'];
                      $_SESSION['produto_servico_preco'] = str_replace(',', '.', $_POST['produto_servico_preco']);
                      $_SESSION['produto_servico_qtd'] = $_POST['produto_servico_qtd'];
                      $_SESSION['produto_servico_vtotal'] = str_replace(',', '.', $_POST['produto_servico_vtotal']); 
                      echo "<script>window.alert('Selecione um produto!');</script>"; 
                    }elseif($_POST['produto_servico_qtd']<1){
                      $_SESSION['produto_servico'] = $_POST['produto_servico_nome'];
                      $_SESSION['produto_servico_id'] = $_POST['produto_servico_id2'];
                      $_SESSION['produto_servico_preco'] = str_replace(',', '.', $_POST['produto_servico_preco']);
                      $_SESSION['produto_servico_qtd'] = $_POST['produto_servico_qtd'];
                      $_SESSION['produto_servico_vtotal'] = str_replace(',', '.', $_POST['produto_servico_vtotal']);
                      echo "<script>window.alert('A quantidade não pode ser menor que 1!');</script>";  
                    }else{
                      if($_POST['produto_servico_estoque'] >= $_POST['produto_servico_qtd']){
                        $insertOrcamento = "INSERT INTO tb_orcamento_servico(cd_cliente, cd_servico, titulo_orcamento, cd_produto, vprod_orcamento, qtd_orcamento, vcusto_orcamento, tipo_orcamento, status_orcamento) VALUES(
                          '".$_SESSION['os_cliente']."',
                          '".$_SESSION['cd_servico']."',
                          '".$_POST['produto_servico_nome']."',
                          '".$_POST['produto_servico_id2']."',
                          '".str_replace(',', '.', $_POST['produto_servico_preco'])."',
                          '".$_POST['produto_servico_qtd']."',
                          '".str_replace(',', '.', $_POST['produto_servico_vtotal'])."',
                          'CADASTRADO',
                          '0')
                        ";
                        //mysqli_query($conn, $insertOrcamento);
                        if (mysqli_query($conn, $insertOrcamento)) {
                          // Obtém o último ID inserido
                          $cd_orcamento = mysqli_insert_id($conn);
                          $insertReserva = "INSERT INTO tb_reserva(cd_cliente, cd_servico, cd_orcamento, cd_prod_serv, qtd_reservado, dt_reservado) VALUES(
                            '".$_SESSION['os_cliente']."',
                            '".$_SESSION['cd_servico']."',
                            ".$cd_orcamento.",
                            '".$_POST['produto_servico_id2']."',
                            '".$_POST['produto_servico_qtd']."',
                            '".date('Y-m-d H:i')."')
                          ";
                          mysqli_query($conn, $insertReserva);
                        } else {
                          echo "Erro ao inserir os dados: " . mysqli_error($conn);
                        }  
                        $_SESSION['vcusto_orcamento'] = $_SESSION['orcamento_servico'] + str_replace(',', '.', $_POST['produto_servico_vtotal']);   
                        $updateOrcamentoServico = "UPDATE tb_servico SET
                          orcamento_servico = ".$_SESSION['vcusto_orcamento']."
                          WHERE cd_servico = ".$_SESSION['cd_servico']."";
                        if(mysqli_query($conn, $updateOrcamentoServico)){
                          echo "<script>window.alert('".$_POST['vcusto_orcamento']." + ".$_SESSION['orcamento_servico']." = ".$_SESSION['vcusto_orcamento']."');</script>";
                        }
                        $_SESSION['produto_servico'] = false;
                        $_SESSION['produto_servico_preco'] = false;
                        $_SESSION['produto_servico_qtd'] = false;
                        $_SESSION['produto_servico_vtotal'] = false;
                      }else{
                        echo "<script>window.alert('A quantidade não pode ser maior que o estoque disponível (".$_POST['produto_servico_estoque'].")!');</script>";
                      }
                      
                    }            
                  }
                        

                  if(isset($_POST['listaremover_orcamento'])) {//DELETE FROM `tb_orcamento_servico` WHERE `tb_orcamento_servico`.`cd_orcamento` = 198
                    if(($_SESSION['vcusto_orcamento'] - $_POST['listavalor_orcamento'])>=$_SESSION['vpag_servico']){
                      //echo "<script>window.alert('OK, pode remover');</script>";
                      $removeOrcamento = "DELETE FROM `tb_orcamento_servico` WHERE `tb_orcamento_servico`.`cd_orcamento` = '".$_POST['listaid_orcamento']."'";
                      mysqli_query($conn, $removeOrcamento);
                      $updateVtotalServico = "UPDATE tb_servico SET
                        orcamento_servico = orcamento_servico - ".$_POST['listavalor_orcamento']."
                        WHERE cd_servico = ".$_SESSION['cd_servico']."";
                      mysqli_query($conn, $updateVtotalServico);
                      if($_POST['listatipo_orcamento'] == 'CADASTRADO'){
                        $removeReserva = "DELETE FROM `tb_reserva` WHERE `tb_reserva`.`cd_orcamento` = ".$_POST['listaid_orcamento']."";
                        mysqli_query($conn, $removeReserva);
                      }
                      //echo "<script>window.alert('a!');</script>";  
                        echo '<script>location.href="'.$_SESSION['dominio'].'pages/md_assistencia/cadastro_servico.php";</script>';          
                    }else{
                      echo "<script>window.alert('Valor pago não pode ser maior que o total do serviço!');</script>";  
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
      INNER JOIN `tb_orcamento_servico` 
      ON `tb_prod_serv`.`cd_prod_serv` = `tb_orcamento_servico`.`cd_produto` 
      SET `tb_prod_serv`.`estoque_prod_serv` = `tb_prod_serv`.`estoque_prod_serv` + `tb_orcamento_servico`.`qtd_orcamento` 
      WHERE `tb_orcamento_servico`.`cd_orcamento` = " . intval($_POST['listaid_orcamento']);
      
  if(mysqli_query($conn, $updateEstoque)){
    echo '<script>alert("1");</script>';

  }

  $removeReserva = "DELETE FROM `tb_reserva` WHERE `cd_orcamento` = " . intval($_POST['listaid_orcamento']);
  
  if(mysqli_query($conn, $removeReserva)){
    echo '<script>alert("2");</script>';

  }
  $removeOrcamentoServico = "DELETE FROM `tb_orcamento_servico` WHERE `cd_orcamento` = " . intval($_POST['listaid_orcamento']);
  if (mysqli_query($conn, $removeOrcamentoServico)) {
    // Atualizar o estoque
    
      
    
      echo '<script>alert("Reserva removida e estoque atualizado com sucesso!");</script>';
      echo '<script>location.href="'.$_SESSION['dominio'].'pages/md_assistencia/cadastro_servico.php";</script>';          
    
        
  
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



                  
                    
                    
                    if(isset($_POST['limparOS'])){
                      //echo "<script>window.alert('Mostrar botão de limpar OS!');</script>";
                      ////session_start();
                      $_SESSION['os_cliente'] = 0;
                      $_SESSION['cd_servico'] = 0;
                      $_SESSION['vcusto_orcamento'] = 0;
                      $_SESSION['vpag_servico'] = 0;
                      echo '<script>document.getElementById("consulta").style.display = "block";</script>';//botoes
                      echo '<script>document.getElementById("botoes").style.display = "none";</script>';//    
                    }
                    
                    
                  
                  
                    
                      if(isset($_POST['pagar_servico'])){
                        $retorno = $f->movimentoFinanceiro(
                                    'R',
                                    $_SESSION['cd_empresa'],
                                    $_SESSION['cd_caixa'],
                                    $_SESSION['cd_cliente'],
                                    $_SESSION['cd_colab'],
                                    $_SESSION['cd_servico'],
                                    '',
                                    $_POST['fpag_movimento'],
                                    $_POST['vpag_movimento']
                                  );
    
                        if($retorno['status'] == 'sucesso'){
                          echo "<script>alert('Total pago: " . $retorno['servico_vpag'] . "');</script>";
                        }else{
                          echo "<script>alert('| - | - | - | ". $retorno['status'] . " | - | - | - |');</script>";
                        }
                      }


                
                  
                  
                  
                          
                  


                      if($_SESSION['cd_servico'] > 0){
                        $result_servico     = $u->conServico($_SESSION['cd_servico'], $_SESSION['cd_empresa']);
                        $result_cliente     = $u->conPessoa('cliente', 'codigo', $result_servico['cd_cliente']);
                        $result_orcamento   = $u->listOrcamentoServico($result_servico['cd_servico'], $_SESSION['cd_empresa']);
                        $result_financeiro  = $u->movimentoFinanceiro($_SESSION['dt_caixa'], $_SESSION['cd_empresa'], $_SESSION['cd_servico'], '', $result_orcamento['falta_pagar']);
                        $result_impressao   = $u->impressao1($_SESSION['tipo_impressao'], 'SERVICO', $_SESSION['cd_empresa'], $_SESSION['cd_servico']);
                        $result_mensagem   = $u->mensagem1($_SESSION['tipo_mensagem'], 'SERVICO', $_SESSION['cd_empresa'], $_SESSION['cd_servico']);
                        echo '<script>document.getElementById("consulta").style.display = "none";</script>';

                        //echo '<p>Cliente</p>';
                        //echo $result_cliente['partial_cliente'];
                        
                        //echo '<p>Servico</p>';
                        echo $result_servico['partial_servico']; 
     
                        //echo '<p>Orcamento</p>';
                        echo $result_orcamento['partial_orcamento']; 
                        
                        //echo '<p>Financeiro</p>';
                        echo $result_financeiro['partial_financeiro'];
                            
                        echo $result_mensagem['partial_mensagem']; 


                        //echo '<p>Impressão</p>';
                        echo $result_impressao['partial_impressao'];
                            

        
                            
                      }elseif($_SESSION['cd_servico'] == ''){
                        
                        

                      }elseif($_SESSION['cd_servico'] == 0){
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

                  document.getElementById("prazo_servico").value = `${ano}-${mes.toString().padStart(2, '0')}-${dia.toString().padStart(2, '0')}T${hora.toString().padStart(2, '0')}:${minuto.toString().padStart(2, '0')}`;
                </script>

</div>


                

          
            
            

<script>
function enviarMensagemWhatsApp() {
  // Obter os valores dos campos do formulário
  var nomeCliente = document.getElementById("btnpnome_cliente").value;
  var telefoneCliente = document.getElementById("btntel_cliente").value;
  var numeroOS = document.getElementById("btncd_servico").value;
  var entradaServico = document.getElementById("btnentrada_servico").value;

  var observacoesServico = document.getElementById("btnobs_servico").value;
  var prioridadeServico = document.getElementById("btnprioridade_servico").value;
  var prazoServico = document.getElementById("btnprazo_servico").value;

  var vtotalServico = document.getElementById("btnvcusto_orcamento").value;
  var vpagServico = document.getElementById("btnvpag_orcamento").value;


  var anoEntrada = entradaServico.substring(0, 4);
  var mesEntrada = entradaServico.substring(5, 7);
  var diaEntrada = entradaServico.substring(8, 10);
  var horaEntrada = entradaServico.substring(11, 13);
  var minutoEntrada = entradaServico.substring(14, 16);

  var anoPrazo = prazoServico.substring(0, 4);
  var mesPrazo = prazoServico.substring(5, 7);
  var diaPrazo = prazoServico.substring(8, 10);
  var horaPrazo = prazoServico.substring(11, 13);
  var minutoPrazo = prazoServico.substring(14, 16)

// Montar a data organizada
var entradaOrganizada = diaEntrada + "/" + mesEntrada + "/" + anoEntrada + " às " + horaEntrada + ":" + minutoEntrada;
var prazoOrganizado = diaPrazo + "/" + mesPrazo + "/" + anoPrazo + " às " + horaPrazo + ":" + minutoPrazo;
if(prioridadeServico == "U"){
  prioridadeOrganizada = "Urgente";
}
if(prioridadeServico == "A"){
  prioridadeOrganizada = "Alta";
}
if(prioridadeServico == "M"){
  prioridadeOrganizada = "Média";
}
if(prioridadeServico == "B"){
  prioridadeOrganizada = "Baixa";
}
faltaPagar = vtotalServico - vpagServico;

  // Construir a mensagem com todos os dados do formulário
  var mensagem = "*Olá, " + nomeCliente + "!*\n";
  mensagem += "Somos da *<?php echo $_SESSION['nfantasia_filial'];?>* e ficamos no endereço *<?php echo $_SESSION['endereco_filial'];?>*.\n\n";
                            
  mensagem += "Sua ordem de serviço de número *OS" + numeroOS + "*, deu entrada em nossa loja *" + entradaOrganizada + "*.\n";
  mensagem += "Descrição da atividade: " + observacoesServico + "\n";
  //mensagem += "Prioridade Requerida: *" + prioridadeOrganizada + "*\n";
  mensagem += "O prazo previsto para entrega é: *" + prazoOrganizado + "*\n\n";
  <?php 
  

  $select_orcamento_whatsapp = "SELECT * FROM tb_orcamento_servico WHERE cd_servico = '".$_SESSION['cd_servico']."' ORDER BY cd_orcamento ASC";
  $result_orcamento_whatsapp = mysqli_query($conn, $select_orcamento_whatsapp);
  echo 'mensagem += "*Lista detalhada*\n";';
  $count = 0;                  
  while($row_orcamento_whatsapp = $result_orcamento_whatsapp->fetch_assoc()) {
    $count ++;
    //echo 'mensagem += count + " - '.$row_orcamento_whatsapp['titulo_orcamento'].' - '.$row_orcamento_whatsapp['vcusto_orcamento'].'"\n";';
    ?>mensagem += "<?php echo '*'.$count.'* - '.$row_orcamento_whatsapp['titulo_orcamento'].' - R$:'.$row_orcamento_whatsapp['vcusto_orcamento']; ?>\n";<?php
  }
  echo 'mensagem += "\n";';


  ?>
  if(faltaPagar > 0 ){
    mensagem += "Total: *R$:" + vtotalServico + "*\n";
    //mensagem += "Valor pago: R$:*" + vpagServico + "*\n";
    mensagem += "Falta pagar: R$:" + faltaPagar + "*\n\n";
  }else if(faltaPagar < 0){
    mensagem += "Voce tem cupom de: *R$:" + faltaPagar + "* conosco!\n\n";
  }else{
    mensagem += "Total Pago: R$:*" + vpagServico + "*\n";
  }
  //mensagem += "Total: *R$:" + vtotalServico + "*\n";
  //mensagem += "Valor pago: R$:*" + vpagServico + "*\n";
  //mensagem += "Falta pagar: R$:" + faltaPagar + "*\n\n";

  mensagem += "\n __________________________________\n";
  <?php
    echo 'mensagem += "Acompanhe seu histórico pelo link:\n'.$_SESSION['dominio'].'pages/md_assistencia/acompanha_servico.php?cnpj='.$_SESSION['cnpj_empresa'].'&tel=" + telefoneCliente + "\n";';
  ?>
  mensagem += "\n __________________________________\n";


  mensagem += "OBS: *_<?php echo $_SESSION['saudacoes_filial'];?>_*\n\n";//$_SESSION['endereco_filial']
                            mensagem += "```NuvemSoft © | Release: B E T A```";//$_SESSION['endereco_filial']
                            
  // Codificar a mensagem para uso na URL
  var mensagemCodificada = encodeURIComponent(mensagem);

  // Construir a URL do WhatsApp
  var urlWhatsApp = "https://api.whatsapp.com/send?phone=" + telefoneCliente + "&text=" + mensagemCodificada;

  // Abrir a janela do WhatsApp com a mensagem preenchida
  window.open(urlWhatsApp, "_blank");
}
</script>

<script>
                          function generatePDF() {
                            // Crie uma instância do objeto jsPDF
                            var doc = new jsPDF();

                            // Defina os campos do formulário
                            var nome = document.getElementById("showpnome_cliente").value;
                            var sobrenome = document.getElementById("showsnome_cliente").value;
                            var telefone = document.getElementById("showtel_cliente").value;

                            var cdServico = document.getElementById("showcd_servico").value;
                            var tituloServico = document.getElementById("showtitulo_servico").value;
                            var obsServico = document.getElementById("showobs_servico").value;
                            var prioridadeServico = document.getElementById("showprioridade_servico").value;
                            var prazoServico = document.getElementById("showprazo_servico").value;
                            var orcamentoServico = document.getElementById("showorcamento_servico").value;
                            var vpagServico = document.getElementById("showvpag_servico").value;

                            // Defina as posições da tabela no documento
                            var startX = 10;
                            var startY = 10;
                            var rowHeight = 10;
                            var columnWidth = 40;

                            // Defina a estrutura da tabela
                            var rows = [
                              ["Nome", "Sobrenome", "Telefone", "showcd_servico", "showtitulo_servico", "showobs_servico", "showprioridade_servico","showprazo_servico", "showorcamento_servico", "showvpag_servico"],
                              [nome, sobrenome, telefone, showcd_servico, showtitulo_servico, showobs_servico, showprioridade_servico, showprazo_servico, showorcamento_servico, showvpag_servico]
                            ];

                            // Adicione a tabela ao documento PDF
                            for (var i = 0; i < rows.length; i++) {
                              var rowData = rows[i];
                              for (var j = 0; j < rowData.length; j++) {
                                doc.text(startX + j * columnWidth, startY + (i + 1) * rowHeight, rowData[j]);
                              }
                            }

                              // Salve ou abra o arquivo PDF
                            doc.save("formulario.pdf");
                          }
                        </script>

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