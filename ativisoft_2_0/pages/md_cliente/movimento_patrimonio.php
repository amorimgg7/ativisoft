<?php 
    session_start(); 
    if(!isset($_SESSION['cd_pessoal']))
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
  <title>Cadastro Empresa</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <script src="../../js/functions.js"></script>
  <!-- endinject -->
  <link rel="shortcut icon" href="<?php echo $_SESSION['logo_empresa']; ?>" />
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <?php include ("../../partials/_navbar.php");?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <?php include ("../../partials/_sidebar.php");?>
      <!-- partial -->
      <div class="main-panel">        
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                
                
               


                <div class="card-body" id="consulta">
                  <h4 class="card-title">Informe o numero de série</h4>
                  <p class="card-description">Identifique o equipamento que será movimentado.</p>
                  <div class="kt-portlet__body">
                    <div class="row">
                      <div class="col-12 col-md-12">
                        <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                        <form method="POST">
                          <input placeholder="Número de Série" type="text" name="connserie_patrimonio" id="connserie_patrimonio" class="aspNetDisabled form-control form-control-sm" required>
                          <br>
                          <button type="submit" name="consulta" class="btn btn-success" >Consulta</button>
                        </form>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
                  if(isset($_POST['connserie_patrimonio'])) {
                    // Consulta o usuário pelo CPF
                    $query = "SELECT * FROM movimento_patrimonio WHERE nserie_patrimonio = '".$_POST['connserie_patrimonio']."' ORDER BY token_alter DESC LIMIT 1";
                    $result = mysqli_query($conn, $query);
                    $row1 = mysqli_fetch_assoc($result);

                    // Exibe as informações do usuário no formulário
                    if($row1) {
                      echo '<div class="card-body" id="status_atual">';
                      echo '<h4 class="card-title">Status Atual</h4>';
                      echo '<div class="kt-portlet__body">';
                      echo '<div class="row">';
                      echo '<div class="col-12 col-md-12">';
                      echo '<div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">';
                      echo '<form>';
                      echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">';
                      echo '<label for="cd_movimento">CD Movimento</label>';
                      echo '<input type="text" name="cd_movimento" id="cd_movimento" class="aspNetDisabled form-control form-control-sm" readonly/>';
                      echo '<label for="responsavel">Responsável</label>';
                      echo '<input type="text" name="responsavel" id="responsavel" class="aspNetDisabled form-control form-control-sm" readonly/>';
                      echo '<label for="empresa">Empresa</label>';
                      echo '<input type="text" name="empresa" id="empresa" class="aspNetDisabled form-control form-control-sm" readonly/>';
                      echo '<label for="setor">Setor</label>';
                      echo '<input type="text" name="setor" id="setor" class="aspNetDisabled form-control form-control-sm" readonly/>';
                      echo '<label for="dataehora">Data e Hora</label>';
                      echo '<input type="text" name="dataehora" id="dataehora" class="aspNetDisabled form-control form-control-sm" value="'.$row1['data_movimento'].' '.$row1['hora_movimento'].'" readonly/>';
                      echo '</div>';
                      echo '</form>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                      echo '<script>document.getElementById("cd_movimento").value = "'.$row1['token_alter'].'"</script>';
                      

                      $query = "SELECT * FROM tb_pessoal WHERE cd_pessoal = '".$row1['cd_pessoal']."'";
                      $result = mysqli_query($conn, $query);
                      $row = mysqli_fetch_assoc($result);
                      // Exibe as informações do usuário no formulário
                      if($row) {
                        echo '<script>document.getElementById("responsavel").value = "'.$row['pnome_pessoal'].'"</script>';
                      }

                      $query = "SELECT * FROM tb_empresa WHERE cd_empresa = '".$row1['cd_empresa']."'";
                      $result = mysqli_query($conn, $query);
                      $row = mysqli_fetch_assoc($result);
                      // Exibe as informações do usuário no formulário
                      if($row) {
                        echo '<script>document.getElementById("empresa").value = "'.$row['rsocial_empresa'].'"</script>';
                      }

                      
                    }

                    

                    echo '<script>document.getElementById("consulta").style.display = "none";</script>';

                    echo '<div class="card-body" id="status_futuro">';
                    echo '<h4 class="card-title">Status Futuro</h4>';
                    echo '<p class="card-description">Informe quem está recebendo este patrimônio</p>';
                    echo '<div class="kt-portlet__body">';
                    echo '<div class="row">';
                    echo '<div class="col-12 col-md-12">';
                    echo '<div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">';
                    echo '<form method="POST">';
                    echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">';
                    echo '<label for="nserie_patrimonio">Patrimonio</label>';
                    echo '<input type="text" name="nserie_patrimonio" id="nserie_patrimonio" class="aspNetDisabled form-control form-control-sm" readonly/>';



                    $sql_responsavel = "SELECT * FROM tb_pessoal"; 
										$resulta_responsavel = $conn->query($sql_responsavel);
										if ($resulta_responsavel->num_rows > 0){
										  echo '<label for="atual_responsavel" class="col-xl-3 col-lg-3 col-form-label">Responsavel</label>';
											echo '<div class="col-lg-9 col-xl-6">';
                	    echo '<select name="atual_responsavel" id="atual_responsavel" class="form-control">';
											echo '<option value="">Marque o futuro responsavel</option>';
                    	while ( $row = $resulta_responsavel->fetch_assoc()){
                        echo '<option value="'.$row['cd_pessoal'].'">'.$row['pnome_pessoal'].' '.$row['snome_pessoal'].'</option>';
                    	}
											echo '</select>';
											echo '</div>';
										}

                    $sql_empresa = "SELECT * FROM tb_empresa"; 
										$resulta_empresa = $conn->query($sql_empresa);
										if ($resulta_empresa->num_rows > 0){
										  echo '<label for="atual_empresa" class="col-xl-3 col-lg-3 col-form-label">Empresa</label>';
											echo '<div class="col-lg-9 col-xl-6">';
                	    echo '<select name="atual_empresa" id="atual_empresa" class="form-control">';
											echo '<option value="">Empresa de destino</option>';
                    	while ( $row = $resulta_empresa->fetch_assoc()){
                        echo '<option value="'.$row['cd_empresa'].'">'.$row['rsocial_empresa'].'</option>';
                    	}
											echo '</select>';
											echo '</div>';
										}


                    //echo '<label for="atual_setor">Setor</label>';
                    //echo '<input type="text" name="atual_setor" id="atual_setor" class="aspNetDisabled form-control form-control-sm"/>';
                    echo '<label for="atual_data">Data</label>';
                    echo '<input type="text" name="atual_data" id="atual_data" class="aspNetDisabled form-control form-control-sm" readonly/>';
                    echo '<label for="atual_hora">Hora</label>';
                    echo '<input type="text" name="atual_hora" id="atual_hora" class="aspNetDisabled form-control form-control-sm" readonly/>';
                    echo '<label for="atual_obs">Observações</label>';
                    echo '<input type="text" name="atual_obs" id="atual_obs" class="aspNetDisabled form-control form-control-sm"/>';
                    echo '<button type="submit" name="movimentar" class="btn btn-success">Movimentar</button>';
                    echo '</div>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';

                    ?>
                      <script>
                        var data = new Date();
                        var mesPorExtenso = new Intl.DateTimeFormat('pt-BR', { month: 'long' }).format(data).toUpperCase();
                        var mes = data.getMonth() + 1;
                        var dia = data.getDate();
                        var ano = data.getFullYear();
                        var hora = data.getHours();
                        var minuto = data.getMinutes();
                        var segundo = data.getSeconds();
                        //document.getElementById("data-atual").innerHTML = 'HOJE É '+dia + ' DE ' + mesPorExtenso + ', ' + ano;
                        document.getElementById("atual_data").value = ''+dia+'/'+mes+'/'+ano;
                        //document.getElementById("data_ponto2").innerHTML = ''+dia+'/'+mes+'/'+ano;
                        document.getElementById("atual_hora").value = ''+hora+':'+minuto+':'+segundo;
                      </script>
                    <?php

                    $query = "SELECT * FROM tb_patrimonio WHERE nserie_patrimonio = '".$_POST['connserie_patrimonio']."'";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);

                    // Exibe as informações do usuário no formulário
                    if($row) {
                      echo '<script>document.getElementById("nserie_patrimonio").value = "'.$row['nserie_patrimonio'].'"</script>';
                    }




                  }

                  // Verifica se o formulário foi enviado
                  //$sql = $pdo->prepare("INSERT INTO tb_pessoal(foto_pessoal, pnome_pessoal, snome_pessoal, cpf_pessoal, rg_pessoal, cnh_pessoal, carttrabalho_pessoal, pis_pessoal, dtnasc_pessoal, sexo_pessoal, ecivil_pessoal, obs_pessoal, tel1_pessoal, obs_tel1_pessoal, tel2_pessoal, obs_tel2_pessoal, email_pessoal, dtentrada_pessoal, funcao_pessoal, meta_pessoal, endereco_pessoal, senha_pessoal) VALUES (:ftp, :pnp, :snp, :cfp, :rgp, :cnp, :ctp, :pip, :dnp, :sxp, :ecp, :obp, :t1p, :o1p, :t2p, :o2p, :emp, :dep, :fup, :mtp, :enp, :sep)");
                  //if(isset($_POST['movimentar'])) {
                    // Atualiza as informações do usuário no banco de dados
                  //  $query = "INSERT INTO movimento_patrimonio(cd_pessoal, nserie_patrimonio, cd_empresa, data_movimento, hora_movimento) 
                  //  VALUES 
                  //  (                    
                  //  ".$_POST['atual_responsavel'].",
                  //  ".$_POST['nserie_patrimonio'].",
                  //  ".$_POST['atual_empresa'].",
                  //  
                  //  ".$_POST['atual_data'].",
                  //  ".$_POST['atual_hora']."
                  //  )";  
                  //  mysqli_query($conn, $query);
  
                  //  echo "<script>window.alert('Comando Movimentar rodou!');</script>";
                  //}

                  if (isset($_POST['movimentar']))
                  { include("../../partials/load.html");
                    $cd_pessoal = addslashes($_POST['atual_responsavel']);
                    $nserie_patrimonio = addslashes($_POST['nserie_patrimonio']);
                    $cd_empresa = addslashes($_POST['atual_empresa']);
                    $data_movimento = addslashes($_POST['atual_data']);
                    $hora_movimento = addslashes($_POST['atual_hora']);
                    $u->conectar();

                    global $pdo;
                  //não cadastrado, cadastrando agora
                    //$sql = $pdo->prepare("INSERT INTO tb_pessoal(pnome_pessoal, snome_pessoal, cpf_pessoal, rg_pessoal, cnh_pessoal, carttrabalho_pessoal, pis_pessoal, dtnasc_pessoal, sexo_pessoal, ecivil_pessoal, tel1_pessoal, obs_tel1_pessoal, tel2_pessoal, obs_tel2_pessoal, email_pessoal, dtentrada_pessoal, funcao_pessoal, meta_pessoal, endereco_pessoal, foto_pessoal, senha_pessoal) VALUES (:pnp, :snp, :cfp, :rgp, :cnp, :ctp, :pip, :dnp, :sxp, :t1p, :o1p, :t2p, :o2p, :emp, :dep, :fup, :mtp, :enp, :ftp, :snp)");
                    $sql1 = $pdo->prepare("UPDATE movimento_patrimonio SET status_movimento = '2' WHERE `movimento_patrimonio`.`token_alter` = ".$token_alter.";");
                    
                    $sql1->execute();
                    if ($u-> $msgErro == "")
                    {
                      //$foto_patrimonio, $nserie_patrimonio, $tipo_patrimonio, $marca_patrimonio, $modelo_patrimonio, $versao_patrimonio, $vcompra_patrimonio, $obsvcompra_patrimonio, $vvenda_patrimonio, $obsvvenda_patrimonio, $obs_patrimonio, $nfgarantia_patrimonio, $dtinicialgarantia_patrimonio, $dtfinalgarantia_patrimonio, $obsgarantia_patrimonio
                      //if($u->cadPatrimonio($foto_patrimonio, $nserie_patrimonio, $tipo_patrimonio, $marca_patrimonio, $modelo_patrimonio, $versao_patrimonio, $vcompra_patrimonio, $obsvcompra_patrimonio, $vvenda_patrimonio, $obsvvenda_patrimonio, $obs_patrimonio, $nfgarantia_patrimonio, $dtinicialgarantia_patrimonio, $dtfinalgarantia_patrimonio, $obsgarantia_patrimonio)) 
                      if($u->movimentoPatrimonio($cd_pessoal, $nserie_patrimonio, $cd_empresa, $data_movimento, $hora_movimento))
                      {
                        ?>
                          <script>window.alert("Movimento realizado!");</script>
                        <?php
                      }
                      else
                      {
                        ?>
                          <script>window.alert("Errado!");</script>
                        <?php
                      }
                    }
                    else
                    {
                      ?>
                               
                      <?php
                    }
                  }
                  
                ?>



                


                <div class="card-body" id="cadastro" style="display:none;">
                  <h4 class="card-title">Cadastro de Institucional</h4>
                  
                    <p class="card-description">Informações institucional</p>
                    <div class="kt-portlet__body">
                      <div class="row">
                        <div class="col-12 col-md-12">
                          <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                            <form method="POST">
                              <h3 class="kt-portlet__head-title">Dados institucionais</h3> 
                              <div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">
                                <label for="cadcd_empresa">Código</label>
                                <input name="cadcd_empresa" id="cadcd_empresa" type="text"  class="aspNetDisabled form-control form-control-sm" disabled="disabled"/>                             
                                
                                <label for="cadcd_responsavel">Código</label>
                                <input name="cadcd_responsavel" id="cadcd_responsavel" type="text"  class="aspNetDisabled form-control form-control-sm" value="<?php echo $_SESSION['cd_pessoal'];?>" style="display:none;"/>                             
                                
                                <!--
                                <div class="kt-portlet__body">
                                  <div class="row">
                                    <div class="col-12 col-md-12">
                                      <div class="form-group form-group-sm">
                                        <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                                          <h3 class="kt-portlet__head-title">FOTO</h3>
                                          <div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">
                                            <label>File upload</label>
                                            <input type="file" name="img[]" class="file-upload-default">
                                            <div class="input-group col-xs-12">
                                              <input type="text" class="form-control file-upload-info"  placeholder="Upload Image"disabled/>
                                              <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                              </span>
                                            </div>
                                          </div>
                                          <a id="ContentPlaceHolder1_iAcCidade_iLkBtActionPosSelect" href="javascript:__doPostBack(&#39;ctl00$ContentPlaceHolder1$iAcCidade$iLkBtActionPosSelect&#39;,&#39;&#39;)"></a>
                                        </div>  
      						  		              </div>
                                    </div>
                                  </div>
                                </div>
                                -->
                                <label for="cadlogo_empresa">Logo</label>
                                <input name="cadlogo_empresa" id="cadlogo_empresa" type="text" maxlength="500"  class="aspNetDisabled form-control form-control-sm" placeholder="Cole o link da sua logo"/>

                                <label for="cadrsocial_empresa">Razão Social</label>
                                <input name="cadrsocial_empresa" id="cadrsocial_empresa" type="text" maxlength="40"   class="aspNetDisabled form-control form-control-sm" />
                             
                                <label for="cadnfantasia_empresa">Nome Fantasia</label>
                                <input name="cadnfantasia_empresa" id="cadnfantasia_empresa" type="text" maxlength="40"   class="aspNetDisabled form-control form-control-sm" />
                              
                                <label for="cadcnpj_empresa">CNPJ</label>
                                <input name="cadcnpj_empresa" id="cadcnpj_empresa" type="tel" oninput="cnpj(this)" class="aspNetDisabled form-control form-control-sm" />

                                <label for="cadiestadual_empresa">Inscrição Estadual</label>
                                <input name="cadiestadual_empresa" id="cadiestadual_empresa" type="text" maxlength="40"   class="aspNetDisabled form-control form-control-sm" />
                              
                                <label for="cadimunicipal_empresa">Inscrição Municipal</label>
                                <input name="cadimunicipal_empresa" id="cadimunicipal_empresa" type="text" maxlength="40"   class="aspNetDisabled form-control form-control-sm" />
                              
                                <label for="caddtabertura_empresa">Data de abertura</label>
                                <input name="caddtabertura_empresa" id="caddtabertura_empresa" type="date" class="aspNetDisabled form-control form-control-sm" />

                                <label for="cadobs_empresa">Observações</label>
                                <input name="cadobs_empresa" id="cadobs_empresa" type="text" class="aspNetDisabled form-control form-control-sm" />
                              
                                
                                <!--<input type="submit" class="btn btn-success" value="Salvar">-->
                              </div>

                          
                            <h3 class="kt-portlet__head-title">Contatos</h3>
                            <div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">
									            <label for="cadtel1_empresa">Telefone 1</label>
                              <input name="cadtel1_empresa" id="cadtel1_empresa" type="tel"  class="aspNetDisabled form-control form-control-sm" data-cco-placeholder="Telefone 1" placeholder="(00)0000-0000" onkeyup="WebChoice.Util.formataTelefone(this, event);" MinLength="12" />
								                                                 
									            <label for="cadobs_tel1_empresa">Complemento do Telefone 1</label>
                              <input name="cadobs_tel1_empresa" id="cadobs_tel1_empresa" type="text" maxlength="40" class="aspNetDisabled form-control form-control-sm" placeholder="Complemento" />
								                                                   
									            <label for="cadtel2_empresa">Telefone 2</label>
                              <input name="cadtel2_empresa" id="cadtel2_empresa" type="text"  class="aspNetDisabled form-control form-control-sm" data-cco-placeholder="Telefone 2" placeholder="(00)0000-0000" onkeyup="WebChoice.Util.formataTelefone(this, event);" MinLength="12" />
								                  
									            <label for="cadobs_tel2_empresa">Complemento do Telefone 2</label>
                              <input name="cadobs_tel2_empresa" id="cadobs_tel2_empresa" type="text" maxlength="40" id="obs_tel2_pessoal"  class="aspNetDisabled form-control form-control-sm" placeholder="Complemento" />
								                  
									            <label for="cademail_empresa">E-Mail</label>
                              <input name="cademail_empresa" id="cademail_empresa" maxlength="80" class="aspNetDisabled form-control form-control-sm" data-cco-placeholder="E-Mail" placeholder="email@dominio.com.br" type="email" />

                            </div>

                            <h3 class="kt-portlet__head-title">Endereço</h3>
                            <div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">
                              <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                              <script>
                                $(document).ready(function() {
                                  $('#cadcep_pessoal').blur(function() {
                                    var cadcep_pessoal = $(this).val().replace(/\D/g, '');
                                    if (cadcep_pessoal != "") {
                                      var url = "https://viacep.com.br/ws/" + cadcep_pessoal + "/json/";
                                      $.getJSON(url, function(dados) {
                                        if (!("erro" in dados)) {
                                          $('#cadendereco_empresa').val(dados.logradouro);
                                          $('#cadbairro_empresa').val(dados.bairro);
                                          $('#cadcidade_empresa').val(dados.localidade);
                                          $('#caduf_empresa').val(dados.uf);
                                        } else {
                                          alert("CEP não encontrado.");
                                        }
                                      });
                                    }
                                  });
                                });
                              </script>
                              <label for="cadcep_empresa">CEP</label>
                              <input name="cadcep_empresa" id="cadcep_empresa" type="text" maxlength="10" class="aspNetDisabled form-control form-control-sm"/>
                              <label for="cadlogradouro_empresa">Logradouro</label>
                              <select name="cadlogradouro_empresa" id="cadlogradouro_empresa" class="aspNetDisabled form-control form-control-sm" placeholder="Logradouro">
                                <option selected="selected" value=""></option>
                                <option value="Alameda">Alameda</option>
                                <option value="Avenida">Avenida</option>
                                <option value="Beco">Beco</option>
                                <option value="Estrada">Estrada</option>
                                <option value="Praça">Pra&#231;a</option>
                                <option value="Rodovia">Rodovia</option>
                                <option value="Rua">Rua</option>
                                <option value="Travessa">Travessa</option>
                                <option value="Outros">Outros</option>
                              </select>
                              <label for="cadendereco_empresa">Endereço</label>
                              <input name="cadendereco_empresa" id="cadendereco_empresa" type="text" maxlength="60" class="aspNetDisabled form-control form-control-sm" placeholder="Endereço" MinLength="5" />
                              <label for="cadcomplemento_empresa">Complemento</label>
                              <input name="cadcomplemento_empresa" id="cadcomplemento_empresa" type="text" maxlength="20" class="aspNetDisabled form-control form-control-sm" placeholder="Complemento" MinLength="2" />

                              <label for="cadbairro_empresa">Bairro</label>
                              <input name="cadbairro_empresa" id="cadbairro_empresa" type="text" maxlength="30" class="aspNetDisabled form-control form-control-sm" placeholder="Bairro" MinLength="3" />
                              <label for="caduf_empresa">UF</label>
                              <input name="caduf_empresa" type="text" id="caduf_empresa"  class="aspNetDisabled form-control form-control-sm" placeholder="Cidade" onkeydown="change_ContentPlaceHolder1_iAcCidade()" data-bv-callback="true" data-bv-callback-message="Valor selecionado de forma incorreta" data-bv-callback-callback="acBootstrapValidadorCheck_ContentPlaceHolder1_iAcCidade" />
                              <label for="cadcidade_empresa">Cidade</label>
                              <input name="cadcidade_empresa" type="text" id="cadcidade_empresa"  class="aspNetDisabled form-control form-control-sm" placeholder="Cidade" onkeydown="change_ContentPlaceHolder1_iAcCidade()" data-bv-callback="true" data-bv-callback-message="Valor selecionado de forma incorreta" data-bv-callback-callback="acBootstrapValidadorCheck_ContentPlaceHolder1_iAcCidade" />
                            </div>
                            <a id="ContentPlaceHolder1_iAcCidade_iLkBtActionPosSelect" href="javascript:__doPostBack(&#39;ctl00$ContentPlaceHolder1$iAcCidade$iLkBtActionPosSelect&#39;,&#39;&#39;)"></a>

                            
                            <input type="submit" class="btn btn-success" value="CADASTRAR">
                          
                            </form>
                          </div>
                          <?php
                          
                          if (isset($_POST['cadcnpj_empresa']))
                          {
                            $logo_empresa = addslashes($_POST['cadlogo_empresa']);
                            $rsocial_empresa = addslashes($_POST['cadrsocial_empresa']);
                            $nfantasia_empresa = addslashes($_POST['cadnfantasia_empresa']);
                            $cnpj_empresa = addslashes($_POST['cadcnpj_empresa']);
                            $iestadual_empresa = addslashes($_POST['cadiestadual_empresa']);
                            $imunicipal_empresa = addslashes($_POST['cadimunicipal_empresa']);
                            $dtabertura_empresa = addslashes($_POST['caddtabertura_empresa']);
                            $obs_empresa = addslashes($_POST['cadobs_empresa']);
                            $tel1_empresa = addslashes($_POST['cadtel1_empresa']);
                            $obs_tel1_empresa = addslashes($_POST['cadobs_tel1_empresa']);
                            $tel2_empresa = addslashes($_POST['cadtel2_empresa']);
                            $obs_tel2_empresa = addslashes($_POST['cadobs_tel2_empresa']);
                            $email_empresa = addslashes($_POST['cademail_empresa']);
                            $meta_empresa = addslashes($_POST['cadmeta_empresa']);

                            $endereco_empresa = addslashes($_POST['cadendereco_empresa']);
                            
                            
                            //$confSenha_pessoal = addslashes($_POST['confSenha_pessoal']);
                            //verificar se tem algum campo vazio
                            
                            if (!empty($cnpj_empresa))
                            //if (!empty($pnome_pessoal) && !empty($cpf_pessoal) && !empty($senha_pessoal)) 
                            {
                              $u->conectar(); 
                              if ($u-> $msgErro == "")
                              {
                                if($u->cadEmpresa($logo_empresa, $rsocial_empresa, $nfantasia_empresa, $cnpj_empresa, $iestadual_empresa, $imunicipal_empresa, $dtabertura_empresa,$obs_empresa, $tel1_empresa, $obs_tel1_empresa, $tel2_empresa, $obs_tel2_empresa, $email_empresa, $meta_empresa, $endereco_empresa)) 
                                {
                                  ?>
                                  <div id="msg-sucesso">Cadastrado com sucesso</div> 
                                  <?php
                                  echo "<script>window.alert('Cadastrado com sucesso!');</script>";
                                  //echo '<script>location.href="AreaPrivada.php";</script>';
                                }
                                else
                                {
                                  ?>
                                  <div class="msg-erro">CPF ja cadastrado!</div>
                                  <?php
                                  echo "<script>window.alert('Já cadastrado!');</script>";
                                }
                              }
                              else
                              {
                                ?>
                                <div class="msg-erro">
                                  <?php echo "Erro: ".$u->msgErro;?>
                                </div>
                                <?php
                              }
                            }
                            else
                            {
                              ?>
                              <script>window.alert("Preencha todos os campos!");</script>
                              <div class="msg-erro">Preencha todos os campos!</div>
                              <?php
                            }
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>


              </div>
            
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © bootstrapdash.com 2020</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap dashboard templates</a> from Bootstrapdash.com</span>
          </div>
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
