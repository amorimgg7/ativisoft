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
  <title>Cadastro Patrimonio</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <!-- endinject -->
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
        <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">

                

              <div class="card-body">
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

                <div class="card-body">
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
                </div>


                <div class="card-body" id="consulta" style="display: none;">
                  <h4 class="card-title">Consulta Pessoa</h4>
                  <p class="card-description">Procure pelo CPF</p>
                  <div class="kt-portlet__body">
                    <div class="row">
                      <div class="col-12 col-md-12">
                        <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                        <form method="POST">
                          
                          <input placeholder="Número de Série/Patrimônio" type="text" name="connserie_patrimonio" id="connserie_patrimonio" oninput="cnpj(this)" class="aspNetDisabled form-control form-control-sm" required>
                          <br>
                          <button type="submit" name="consulta" class="btn btn-success" >Consulta</button>
                        </form>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>


                <div class="card-body" id="edita" style="display: none;">
                  <h4 class="card-title">Consulta Patrimonio</h4>
                  <p class="card-description">Procure pelo Número de Série</p>
                  <div class="kt-portlet__body">
                    <div class="row">
                      <div class="col-12 col-md-12">
                        <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                        <form method="POST">
                          <h3 class="kt-portlet__head-title">Dados Patrimoniais</h3> 
                          <div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">
                            <label for="editcd_patrimonio">Código:</label>
                            <input type="text" name="editcd_patrimonio" id="editcd_patrimonio" class="aspNetDisabled form-control form-control-sm" readonly/>
                          
                            <button type="button" onclick="showPhotoPatrimonio()">Mostrar Foto</button>
                            <div id="photo-container-patrimonio"></div>

                            <script>
                              function showPhotoPatrimonio() {
                                var photoLink = document.getElementById("editfoto_patrimonio").value;
                                var photoContainer = document.getElementById("photo-container-patrimonio");
                                var photoImg = document.createElement("img");
                                photoImg.src = photoLink;
                                photoContainer.innerHTML = "";
                                photoContainer.appendChild(photoImg);
                                photoContainer.style.display = "block";
                              }
                            </script>                                                                      
                                           



                            <label for="editnserie_patrimonio">Numero de Série:</label>
                            <input type="text" name="editnserie_patrimonio" id="editnserie_patrimonio" class="aspNetDisabled form-control form-control-sm" readonly/>

                            <label for="edittipo_patrimonio">Tipo</label>
                            <select name="edittipo_patrimonio" id="edittipo_patrimonio"  class="aspNetDisabled form-control form-control-sm" style="pointer-events: none; touch-action: none;" readonly>
                              
                              <option value="DP" readonly>Desktop</option>
                              <option value="NK" readonly>Notebook</option>
                              <option value="MR" readonly>Monitor</option>
                              <option value="IA" readonly>Impressora</option>
                              <option value="SE" readonly>Smartphone</option>
                              <option value="MM" readonly>Modem</option>
                              <option value="RR" readonly>Roteador</option>
                              <option value="SH" readonly>Switch</option>
                            </select>

                            <label for="editmarca_patrimonio">Marca:</label>
                            <input type="text" name="editmarca_patrimonio" id="editmarca_patrimonio" class="aspNetDisabled form-control form-control-sm" readonly/>
                          
                            <label for="editmodelo_patrimonio">Modelo:</label>
                            <input type="text" name="editmodelo_patrimonio" id="editmodelo_patrimonio" class="aspNetDisabled form-control form-control-sm" readonly/>
                          
                            <label for="editversao_patrimonio">Versão:</label>
                            <input name="editversao_patrimonio" id="editversao_patrimonio" type="text" oninput="rg(this)" class="aspNetDisabled form-control form-control-sm" readonly/>
                              
                            <label for="editvcompra_patrimonio">Valor de Compra:</label>
                            <input name="editvcompra_patrimonio" id="editvcompra_patrimonio" type="tel" oninput="cnh(this)" class="aspNetDisabled form-control form-control-sm" />

                            <label for="editobsvcompra_patrimonio">Obs Compra:</label>
                            <input name="editobsvcompra_patrimonio" id="editobsvcompra_patrimonio" type="text" class="aspNetDisabled form-control" /><!--required="" data-required="true"-->
  
                            <label for="editvvenda_patrimonio">Valor de Venda:</label>
                            <input name="editvvenda_patrimonio" type="text" id="editvvenda_patrimonio"  class="aspNetDisabled form-control"/><!--required="" data-required="true"-->
  
                            <label for="editobsvvenda_patrimonio">Obs Venda:</label>
                            <input name="editobsvvenda_patrimonio" type="text" id="editobsvvenda_patrimonio"  class="aspNetDisabled form-control"/><!--required="" data-required="true"-->
                            
                            <button type="submit" name="atualizar" class="btn btn-success">Atualizar</button>
                          </div>
                        </form>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php

                  if(isset($_POST['connserie_patrimonio'])) {
                    // Consulta o usuário pelo CPF
                    $query = "SELECT * FROM tb_patrimonio WHERE nserie_patrimonio = '".$_POST['connserie_patrimonio']."'";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);

                    // Exibe as informações do usuário no formulário
                    if($row) {
                      include("../../partials/load.html");
                      echo '<script>document.getElementById("edita").style.display = "block";</script>';
                      echo '<script>document.getElementById("editcd_patrimonio").value = "'.$row['cd_patrimonio'].'"</script>';
                      echo '<script>document.getElementById("editnserie_patrimonio").value = "'.$row['nserie_patrimonio'].'"</script>';
                     
                      echo '<script>document.getElementById("edittipo_patrimonio").value = "'.$row['tipo_patrimonio'].'"</script>';
                      echo '<script>document.getElementById("editmarca_patrimonio").value = "'.$row['marca_patrimonio'].'"</script>';
                      echo '<script>document.getElementById("editmodelo_patrimonio").value = "'.$row['modelo_patrimonio'].'"</script>';
                      echo '<script>document.getElementById("editversao_patrimonio").value = "'.$row['versao_patrimonio'].'"</script>';
                      echo '<script>document.getElementById("editvcompra_patrimonio").value = "'.$row['vcompra_patrimonio'].'"</script>';
                      echo '<script>document.getElementById("editobsvcompra_patrimonio").value = "'.$row['obsvcompra_patrimonio'].'"</script>';
                      echo '<script>document.getElementById("editvvenda_patrimonio").value = "'.$row['vvenda_patrimonio'].'"</script>';
                      echo '<script>document.getElementById("editobsvvenda_patrimonio").value = "'.$row['obsvvenda_patrimonio'].'"</script>';
                    }
                    else
                    {
                      echo "<script>window.alert('Equipamento não encontrado, Cadastre já!');</script>";
                      echo '<script>document.getElementById("cadastro").style.display = "block";</script>';
                      echo '<script>document.getElementById("cnpj_empresa").value = "'.$_POST['concnpj_empresa'].'"</script>';
                    }
                  }

                  // Verifica se o formulário foi enviado
                  if(isset($_POST['atualizar'])) {
                    // Atualiza as informações do usuário no banco de dados
                    $query = "UPDATE tb_patrimonio SET
                      
                      tipo_patrimonio = '".$_POST['edittipo_patrimonio']."',
                      marca_patrimonio = '".$_POST['editmarca_patrimonio']."',
                      modelo_patrimonio = '".$_POST['editmodelo_patrimonio']."',
                      versao_patrimonio = '".$_POST['editversao_patrimonio']."',
                      vcompra_patrimonio = '".$_POST['editvcompra_patrimonio']."',
                      obsvcompra_patrimonio = '".$_POST['editobsvcompra_patrimonio']."',
                      vvenda_patrimonio = '".$_POST['editvvenda_patrimonio']."',
                      obsvvenda_patrimonio = '".$_POST['editobsvvenda_patrimonio']."'
                      WHERE nserie_patrimonio = '".$_POST['editnserie_patrimonio']."'";
                    mysqli_query($conn, $query);
  
                    echo "<script>window.alert('Cadastro atualizado com sucesso!');</script>";
                  }
                ?>

                

                <div class="card-body" id="cadastro" style="display:none;">
                  <h4 class="card-title">Cadastro de Patrimonio</h4>
                  
                    <p class="card-description">Informações patrimoniais</p>
                    <div class="kt-portlet__body">
                      <div class="row">
                        <div class="col-12 col-md-12">
                          <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                            <form method="POST">
                              <h3 class="kt-portlet__head-title">Dados do equipamento</h3> 
                              <div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">
                                <label for="cd_patrimonio">Código</label>
                                <input name="cd_patrimonio" type="text" maxlength="10" id="cd_patrimonio"  class="aspNetDisabled form-control form-control-sm" disabled="disabled"/>
                               
                                <label for="nserie_patrimonio">Numero de série</label>
                                <input name="nserie_patrimonio" type="text" maxlength="40"   class="aspNetDisabled form-control form-control-sm" />
                             
                                <label for="tipo_patrimonio">Tipo</label>
                                <select name="tipo_patrimonio" id="tipo_patrimonio"  class="aspNetDisabled form-control form-control-sm" placeholder="Estado Civil">
                                  <option selected="selected" value=""></option>
                                  <option value="DP">Desktop</option>
                                  <option value="NK">Notebook</option>
                                  <option value="MR">Monitor</option>
                                  <option value="IA">Impressora</option>
                                  <option value="SE">Smartphone</option>
                                  <option value="MM" readonly>Modem</option>
                                  <option value="RR" readonly>Roteador</option>
                                  <option value="SH" readonly>Switch</option>
                                </select>

                                <label for="marca_patrimonio">Marca</label>
                                <input name="marca_patrimonio" type="text" maxlength="40"   class="aspNetDisabled form-control form-control-sm" />
                              
                                <label for="modelo_patrimonio">Modelo</label>
                                <input name="modelo_patrimonio" type="text" maxlength="40"   class="aspNetDisabled form-control form-control-sm" />

                                <label for="versao_patrimonio">Versão</label>
                                <input name="versao_patrimonio" type="text" maxlength="40"   class="aspNetDisabled form-control form-control-sm" />
                              
                                <label for="vcompra_patrimonio">Valor de compra</label>
                                <input name="vcompra_patrimonio" type="tel" maxlength="40"   class="aspNetDisabled form-control form-control-sm" />
                              
                                <label for="obsvcompra_patrimonio">Detalhes de compra</label>
                                <input name="obsvcompra_patrimonio" type="text" class="aspNetDisabled form-control form-control-sm" />
                              
                                <label for="vvenda_patrimonio">Valor de venda</label>
                                <input name="vvenda_patrimonio" type="tel" class="aspNetDisabled form-control form-control-sm" />

                                <label for="obsvvenda_patrimonio">Detalhes de venda</label>
                                <input name="obsvvenda_patrimonio" type="text" class="aspNetDisabled form-control form-control-sm" />
                              
                                <label for="obs_patrimonio">Detalhes do equipamento</label>
                                <input name="obs_patrimonio" type="text" class="aspNetDisabled form-control form-control-sm" />

                                
                                <!--<input type="submit" class="btn btn-success" value="Salvar">-->
                              </div>

                          
                            <h3 class="kt-portlet__head-title">Garantia</h3>
                            <div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">
									            <label for="nfcompra_patrimonio">NF de compra</label>
                              <input name="nfcompra_patrimonio" type="text"  class="aspNetDisabled form-control form-control-sm"/>
								                                                 
									            <label for="dtinicialgarantia_patrimonio">data inicial</label>
                              <input name="dtinicialgarantia_patrimonio" type="date" maxlength="40" class="aspNetDisabled form-control form-control-sm"/>
								                                                   
									            <label for="dtfinalgarantia_patrimonio">Data final</label>
                              <input name="dtfinalgarantia_patrimonio"  type="date" class="aspNetDisabled form-control form-control-sm"/>
								              
									            <label for="obsgarantia_patrimonio">Contato com garantia</label>
                              <input name="obsgarantia_patrimonio" type="text"  class="aspNetDisabled form-control form-control-sm" placeholder="Link, Telefone ou email do prestador ou plataforma de garantia autorizada."/>
                            </div>                           
                            <input type="submit" class="btn btn-success" value="CADASTRAR">
                          
                            </form>
                          </div>
                          <?php
                          
                          if (isset($_POST['nserie_patrimonio']))
                          {
                            include("../../partials/load.html");
                            
                            $nserie_patrimonio = addslashes($_POST['nserie_patrimonio']);
                            $tipo_patrimonio = addslashes($_POST['tipo_patrimonio']);
                            $marca_patrimonio = addslashes($_POST['marca_patrimonio']);
                            $modelo_patrimonio = addslashes($_POST['modelo_patrimonio']);
                            $versao_patrimonio = addslashes($_POST['versao_patrimonio']);
                            $vcompra_patrimonio = addslashes($_POST['vcompra_patrimonio']);
                            $obsvcompra_patrimonio = addslashes($_POST['obsvcompra_patrimonio']);
                            $vvenda_patrimonio = addslashes($_POST['vvenda_patrimonio']);
                            $obsvvenda_patrimonio = addslashes($_POST['obsvvenda_patrimonio']);
                            $obs_patrimonio = addslashes($_POST['obs_patrimonio']);
                            $nfcompra_patrimonio = addslashes($_POST['nfcompra_patrimonio']);
                            
                            if (!empty($nserie_patrimonio))
                            //if (!empty($pnome_pessoal) && !empty($cpf_pessoal) && !empty($senha_pessoal)) 
                            {
                              $u->conectar(); 
                              if ($u-> $msgErro == "")
                              {
                                //$foto_patrimonio, $nserie_patrimonio, $tipo_patrimonio, $marca_patrimonio, $modelo_patrimonio, $versao_patrimonio, $vcompra_patrimonio, $obsvcompra_patrimonio, $vvenda_patrimonio, $obsvvenda_patrimonio, $obs_patrimonio, $nfgarantia_patrimonio, $dtinicialgarantia_patrimonio, $dtfinalgarantia_patrimonio, $obsgarantia_patrimonio
                                //if($u->cadPatrimonio($foto_patrimonio, $nserie_patrimonio, $tipo_patrimonio, $marca_patrimonio, $modelo_patrimonio, $versao_patrimonio, $vcompra_patrimonio, $obsvcompra_patrimonio, $vvenda_patrimonio, $obsvvenda_patrimonio, $obs_patrimonio, $nfgarantia_patrimonio, $dtinicialgarantia_patrimonio, $dtfinalgarantia_patrimonio, $obsgarantia_patrimonio)) 
                                if($u->cadPatrimonio($nserie_patrimonio, $tipo_patrimonio, $marca_patrimonio, $modelo_patrimonio, $versao_patrimonio, $vcompra_patrimonio, $obsvcompra_patrimonio, $vvenda_patrimonio, $obsvvenda_patrimonio, $obs_patrimonio, $nfcompra_patrimonio)) 
                                
                                {
                                  ?>
                                  <script>window.alert("Cadastro realizado com sucesso!");</script>
                                  <div id="msg-sucesso">Cadastrado com sucesso</div> 
                                  <?php
                                  //echo '<script>location.href="AreaPrivada.php";</script>';
                                }
                                else
                                {
                                  ?>
                                  <div class="msg-erro">Numero de série ja cadastrado!</div>
                                  <?php
                                }
                              }
                              else
                              {
                                ?>
                               
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