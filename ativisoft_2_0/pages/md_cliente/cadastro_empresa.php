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
                
                <div class="card-body">
                  <h4>Cadastre já sua empresa!</h4>
                  <div class="template-demo">
                    <button type="button" class="btn btn-primary btn-icon-text"onclick="abrirCadastro()">
                      <i class="mdi mdi-upload btn-icon-prepend"></i>
                      Cadastrar
                    </button>
                    <button type="button" class="btn btn-dark btn-icon-text"onclick="abrirConsulta()">
                      <i class="mdi mdi-file-check btn-icon-append"></i>
                      Consultar/Editar
                    </button>
                  </div>
                </div>

              
                 	<script>
              	  	function abrirCadastro() {
                			document.getElementById("cadastro").style.display = "block";
                			document.getElementById("consulta").style.display = "none";
                      document.getElementById("edita").style.display = "none";
                		}

                		function abrirConsulta() {
                 			document.getElementById("cadastro").style.display = "none";
                			document.getElementById("consulta").style.display = "block";
                      document.getElementById("edita").style.display = "none";
                		}
                	</script>
               


                <div class="card-body" id="consulta" style="display: none;">
                  <h4 class="card-title">Consulta Pessoa</h4>
                  <p class="card-description">Procure pelo CPF</p>
                  <div class="kt-portlet__body">
                    <div class="row">
                      <div class="col-12 col-md-12">
                        <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                        <form method="POST">
                          
                          <input placeholder="CNPJ" type="tel" name="concnpj_empresa" id="concnpj_empresa" oninput="cnpj(this)" class="aspNetDisabled form-control form-control-sm" required>
                          <br>
                          <button type="submit" name="consulta" class="btn btn-success" >Consulta</button>
                        </form>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>


                <div class="card-body" id="edita" style="display: none;">
                  <h4 class="card-title">Consulta Empresa</h4>
                  <p class="card-description">Procure pelo CNPJ</p>
                  <div class="kt-portlet__body">
                    <div class="row">
                      <div class="col-12 col-md-12">
                        <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                        <form method="POST">
                          <h3 class="kt-portlet__head-title">Dados Empresariais</h3> 
                          <div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">
                            <label for="editcd_empresa">Código:</label>
                            <input type="text" name="editcd_empresa" id="editcd_empresa" class="aspNetDisabled form-control form-control-sm" readonly/>
                          
                            <label for="editcd_responsavel">Código:</label>
                            <input type="text" name="editcd_responsavel" id="editcd_responsavel" class="aspNetDisabled form-control form-control-sm" readonly/>
                          
                            <label for="editlogo_empresa">Logo:</label>
                            <input placeholder="Cole o link da sua foto" type="text" name="editlogo_empresa" id="editlogo_empresa" class="aspNetDisabled form-control form-control-sm"/>
                         
                            <button type="button" onclick="showPhotoEmpresa()">Mostrar Foto</button>
                            <div id="photo-container-empresa"></div>

                            <script>
                              function showPhotoEmpresa() {
                                var photoLink = document.getElementById("editlogo_empresa").value;
                                var photoContainer = document.getElementById("photo-container-empresa");
                                var photoImg = document.createElement("img");
                                photoImg.src = photoLink;
                                photoContainer.innerHTML = "";
                                photoContainer.appendChild(photoImg);
                                photoContainer.style.display = "block";
                              }
                            </script> 

                            <label for="editrsocial_empresa">Razão Social:</label>
                            <input type="text" name="editrsocial_empresa" id="editrsocial_empresa" class="aspNetDisabled form-control form-control-sm"/>
                          
                            <label for="editnfantasia_empresa">Nome Fantasia:</label>
                            <input type="text" name="editnfantasia_empresa" id="editnfantasia_empresa" class="aspNetDisabled form-control form-control-sm"/>
                          
                            <label for="editcnpj_empresa">CNPJ:</label>
                            <input type="tel" name="editcnpj_empresa" id="editcnpj_empresa" oninput="cnpj(this)" class="aspNetDisabled form-control form-control-sm" readonly/>
                          
                            <label for="editiestadual_empresa">Inscrição Estadual</label>
                            <input name="editiestadual_empresa" id="editiestadual_empresa" type="tel" class="aspNetDisabled form-control form-control-sm" />
                              
                            <label for="editimunicipal_empresa">Inscrição Municipal</label>
                            <input name="editimunicipal_empresa" id="editimunicipal_empresa" type="tel" oninput="cnh(this)" class="aspNetDisabled form-control form-control-sm" />

                            <label for="editdtabertura_empresa">Nascimento</label>
                            <input name="editdtabertura_empresa" id="editdtabertura_empresa" type="text" class="aspNetDisabled form-control" data-start="date-picker" data-cco-placeholder="Admissão" placeholder="  /  /    "  readonly/><!--required="" data-required="true"-->
  
                            <label for="editobs_empresa">Observações</label>
                            <input name="editobs_empresa" type="text" id="editobs_empresa"  class="aspNetDisabled form-control"/><!--required="" data-required="true"-->
  
                            <button type="submit" name="atualizar" class="btn btn-success">Atualizar</button>
                          </div>
                          <h3 class="kt-portlet__head-title">Contatos</h3> 
                          <div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">
                            <label for="edittel1_empresa">Telefone 1</label>
                            <input name="edittel1_empresa" id="edittel1_empresa" type="tel" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" data-cco-placeholder="Telefone 1" placeholder="(00)0000-0000" onkeyup="WebChoice.Util.formataTelefone(this, event);" MinLength="12" />
								                                                 
									          <label for="editobs_tel1_empresa">Complemento do Telefone 1</label>
                            <input name="editobs_tel1_empresa" id="editobs_tel1_empresa" type="text" maxlength="40" class="aspNetDisabled form-control form-control-sm" placeholder="Complemento" />
								                                                   
									          <label for="edittel2_empresa">Telefone 2</label>
                            <input name="edittel2_empresa" id="edittel2_empresa" type="tel" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" data-cco-placeholder="Telefone 2" placeholder="(00)0000-0000" onkeyup="WebChoice.Util.formataTelefone(this, event);" MinLength="12" />
								                  
									          <label for="editobs_tel2_empresa">Complemento do Telefone 2</label>
                            <input name="editobs_tel2_empresa" id="editobs_tel2_empresa" type="text" maxlength="40" class="aspNetDisabled form-control form-control-sm" placeholder="Complemento" />
								                  
									          <label for="editemail_empresa">E-Mail</label>
                            <input name="editemail_empresa" id="editemail_empresa" maxlength="80" class="aspNetDisabled form-control form-control-sm" data-cco-placeholder="E-Mail" placeholder="email@dominio.com.br" type="email" />
                          </div>
                        </form>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php

                  if(isset($_POST['concnpj_empresa'])) {
                    // Consulta o usuário pelo CPF
                    $query = "SELECT * FROM tb_empresa WHERE cnpj_empresa = '".$_POST['concnpj_empresa']."'";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);

                    // Exibe as informações do usuário no formulário
                    if($row) {
                      echo '<script>document.getElementById("edita").style.display = "block";</script>';
                      echo '<script>document.getElementById("editcd_empresa").value = "'.$row['cd_empresa'].'"</script>';
                      //echo '<script>document.getElementById("editcd_responsavel").value = "'.$row['cd_responsavel'].'"</script>';
                      echo '<script>document.getElementById("editlogo_empresa").value = "'.$row['logo_empresa'].'"</script>';
                      echo '<script>document.getElementById("editrsocial_empresa").value = "'.$row['rsocial_empresa'].'"</script>';
                      echo '<script>document.getElementById("editnfantasia_empresa").value = "'.$row['nfantasia_empresa'].'"</script>';
                      echo '<script>document.getElementById("editcnpj_empresa").value = "'.$row['cnpj_empresa'].'"</script>';
                      echo '<script>document.getElementById("editiestadual_empresa").value = "'.$row['iestadual_empresa'].'"</script>';
                      echo '<script>document.getElementById("editimunicipal_empresa").value = "'.$row['imunicipal_empresa'].'"</script>';
                      echo '<script>document.getElementById("editdtabertura_empresa").value = "'.$row['dtabertura_empresa'].'"</script>';
                      echo '<script>document.getElementById("editobs_empresa").value = "'.$row['obs_empresa'].'"</script>';
                      echo '<script>document.getElementById("edittel1_empresa").value = "'.$row['tel1_empresa'].'"</script>';
                      echo '<script>document.getElementById("editobs_tel1_empresa").value = "'.$row['obs_tel1_empresa'].'"</script>';
                      echo '<script>document.getElementById("edittel2_empresa").value = "'.$row['tel2_empresa'].'"</script>';
                      echo '<script>document.getElementById("editobs_tel2_empresa").value = "'.$row['obs_tel2_empresa'].'"</script>';
                      echo '<script>document.getElementById("editemail_empresa").value = "'.$row['email_empresa'].'"</script>';
                    }
                    else
                    {
                      echo "<script>window.alert('CPF não encontrado, Cadastre já!');</script>";
                      echo '<script>document.getElementById("cadastro").style.display = "block";</script>';
                      echo '<script>document.getElementById("cnpj_empresa").value = "'.$_POST['concnpj_empresa'].'"</script>';
                    }
                  }

                  // Verifica se o formulário foi enviado
                  if(isset($_POST['atualizar'])) {
                    include("../../partials/load.html");
                    // Atualiza as informações do usuário no banco de dados
                    $query = "UPDATE tb_empresa SET
                      logo_empresa = '".$_POST['editlogo_empresa']."',
                      rsocial_empresa = '".$_POST['editrsocial_empresa']."',
                      nfantasia_empresa = '".$_POST['editnfantasia_empresa']."',
                      cnpj_empresa = '".$_POST['editcnpj_empresa']."',
                      iestadual_empresa = '".$_POST['editiestadual_empresa']."',
                      imunicipal_empresa = '".$_POST['editimunicipal_empresa']."',
                      dtabertura_empresa = '".$_POST['editdtabertura_empresa']."',
                      obs_empresa = '".$_POST['editobs_empresa']."',
                      tel1_empresa = '".$_POST['edittel1_empresa']."',
                      obs_tel1_empresa = '".$_POST['editobs_tel1_empresa']."',
                      tel2_empresa = '".$_POST['edittel2_empresa']."',
                      obs_tel2_empresa = '".$_POST['editobs_tel2_empresa']."',
                      email_empresa = '".$_POST['editemail_empresa']."'
                      WHERE cnpj_empresa = '".$_POST['editcnpj_empresa']."'";
                    mysqli_query($conn, $query);
  
                    echo "<script>window.alert('Empresa atualizada com sucesso!');</script>";
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
                            include("../../partials/load.html");
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
                            //$meta_empresa = addslashes($_POST['cadmeta_empresa']);

                            //$endereco_empresa = addslashes($_POST['cadendereco_empresa']);
                            
                            
                            //$confSenha_pessoal = addslashes($_POST['confSenha_pessoal']);
                            //verificar se tem algum campo vazio
                            
                            if (!empty($cnpj_empresa))
                            //if (!empty($pnome_pessoal) && !empty($cpf_pessoal) && !empty($senha_pessoal)) 
                            {
                              $u->conectar(); 
                              if ($u-> $msgErro == "")
                              {
                                if($u->cadEmpresa($logo_empresa, $rsocial_empresa, $nfantasia_empresa, $cnpj_empresa, $iestadual_empresa, $imunicipal_empresa, $dtabertura_empresa, $obs_empresa, $tel1_empresa, $obs_tel1_empresa, $tel2_empresa, $obs_tel2_empresa, $email_empresa)) 
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
                                  <div class="msg-erro">CNPJ ja cadastrado!</div>
                                  <?php
                                  echo "<script>window.alert('CNPJ Já cadastrado!');</script>";
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
