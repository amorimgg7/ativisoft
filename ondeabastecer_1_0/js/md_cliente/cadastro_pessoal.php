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
  <title>Cadastro Pessoal</title>
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

                    function abrirEdicao() {
                 			document.getElementById("cadastro").style.display = "none";
                			document.getElementById("consulta").style.display = "none";
                      document.getElementById("edita").style.display = "block";
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
                          
                          <input placeholder="CPF" type="tel" name="concpf_pessoal" id="concpf_pessoal" type="tel" maxlength="10" oninput="cpf(this)" class="aspNetDisabled form-control form-control-sm" required>
                          <br>
                          <button type="submit" name="consulta" class="btn btn-success" >Consulta</button>
                        </form>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="card-body" id="edita" style="display: none;">
                  <h4 class="card-title">Consulta Pessoa</h4>
                  <p class="card-description">Procure pelo CPF</p>
                  <div class="kt-portlet__body">
                    <div class="row">
                      <div class="col-12 col-md-12">
                        <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                        <form method="POST">
                          <h3 class="kt-portlet__head-title">Dados pessoais</h3> 
                          <div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">
                            <label for="editcd_pessoal">Código:</label>
                            <input type="text" name="editcd_pessoal" id="editcd_pessoal" class="aspNetDisabled form-control form-control-sm" readonly/>
                          
                            <label for="editfoto_pessoal">Foto:</label>
                            <input placeholder="Cole o link da sua foto" type="text" name="editfoto_pessoal" id="editfoto_pessoal" class="aspNetDisabled form-control form-control-sm"/>
                         
                            <button type="button" onclick="showPhoto()">Mostrar Foto</button>
                            <div id="photo-container"></div>

                            <script>
                              function showPhoto() {
                                var photoLink = document.getElementById("editfoto_pessoal").value;
                                var photoContainer = document.getElementById("photo-container");
                                var photoImg = document.createElement("img");
                                photoImg.src = photoLink;
                                photoContainer.innerHTML = "";
                                photoContainer.appendChild(photoImg);
                                photoContainer.style.display = "block";
                              }
                            </script>

                            <label for="editpnome_pessoal">Nome:</label>
                            <input type="text" name="editpnome_pessoal" id="editpnome_pessoal" class="aspNetDisabled form-control form-control-sm"/>
                          
                            <label for="editsnome_pessoal">Sobrenome:</label>
                            <input type="text" name="editsnome_pessoal" id="editsnome_pessoal" class="aspNetDisabled form-control form-control-sm"/>
                          
                            <label for="editcpf_pessoal">CPF:</label>
                            <input type="text" name="editcpf_pessoal" id="editcpf_pessoal" class="aspNetDisabled form-control form-control-sm" readonly/>
                          
                            <label for="editrg_pessoal">RG</label>
                            <input name="editrg_pessoal" id="editrg_pessoal" type="tel" oninput="rg(this)" class="aspNetDisabled form-control form-control-sm" />
                              
                            <label for="editcnh_pessoal">CNH</label>
                            <input name="editcnh_pessoal" id="editcnh_pessoal" type="tel" oninput="cnh(this)" class="aspNetDisabled form-control form-control-sm" />

                            <label for="editpis_pessoal">PIS</label>
                            <input name="editpis_pessoal" id="editpis_pessoal" type="tel" maxlength="10" oninput="pis(this)" class="aspNetDisabled form-control form-control-sm" />

                            <label for="editcarttrabalho_pessoal">Cart. de Tragbalho</label>
                            <input name="editcarttrabalho_pessoal" id="editcarttrabalho_pessoal" type="tel"  oninput="cartTrabalho(this)" class="aspNetDisabled form-control form-control-sm" placeholder="Carteira de Trabalho"/>
                                
                            <label for="editdtnasc_pessoal">Nascimento</label>
                            <input name="editdtnasc_pessoal" id="editdtnasc_pessoal" type="text" class="aspNetDisabled form-control" data-start="date-picker" data-cco-placeholder="Admissão" placeholder="  /  /    "  readonly/><!--required="" data-required="true"-->
  
                            <label for="editsexo_pessoal">Sexo</label>
                            <select name="editsexo_pessoal" id="editsexo_pessoal"  class="aspNetDisabled form-control form-control-sm" placeholder="Sexo">
                              <option selected="selected" value=""></option>
                              <option value="M">Masculino</option>
                              <option value="F">Feminino</option>
                              <option value="O">Outros</option>
                            </select>
                            <label for="editecivil_pessoal">Estado Civil</label>
                            <select name="editecivil_pessoal" id="editecivil_pessoal"  class="aspNetDisabled form-control form-control-sm" placeholder="Estado Civil">
                              <option selected="selected" value=""></option>
                              <option value="S">Solteiro</option>
                              <option value="C">Casado</option>
                              <option value="V">Viúvo</option>
                              <option value="D">Divorciado</option>
                            </select>
  
                            <label for="editobs_pessoal">Observações</label>
                            <input name="editobs_pessoal" type="text" id="editobs_pessoal"  class="aspNetDisabled form-control"/><!--required="" data-required="true"-->
  
                            
                          </div>
                          <h3 class="kt-portlet__head-title">Contatos</h3> 
                          <div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">
                          <label for="edittel1_pessoal">Telefone 1</label>
                            <input name="edittel1_pessoal" id="edittel1_pessoal" type="tel" maxlength="40" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" data-cco-placeholder="Telefone 1" placeholder="(00)0000-0000" onkeyup="WebChoice.Util.formataTelefone(this, event);" MinLength="12" />
								                                                 
									          <label for="editobstel1_pessoal">Complemento do Telefone 1</label>
                            <input name="editobstel1_pessoal" id="editobstel1_pessoal" type="text" maxlength="40" class="aspNetDisabled form-control form-control-sm" placeholder="Complemento" />
								                                                   
									          <label for="edittel2_pessoal">Telefone 2</label>
                            <input name="edittel2_pessoal" id="edittel2_pessoal" type="tel" maxlength="40" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" data-cco-placeholder="Telefone 2" placeholder="(00)0000-0000" onkeyup="WebChoice.Util.formataTelefone(this, event);" MinLength="12" />
								                  
									          <label for="editobstel2_pessoal">Complemento do Telefone 2</label>
                            <input name="editobstel2_pessoal" id="editobstel2_pessoal" type="text" maxlength="40" maxlength="40" class="aspNetDisabled form-control form-control-sm" placeholder="Complemento" />
								                  
									          <label for="editemail_pessoal">E-Mail</label>
                            <input name="editemail_pessoal" id="editemail_pessoal" maxlength="80" class="aspNetDisabled form-control form-control-sm" data-cco-placeholder="E-Mail" placeholder="email@dominio.com.br" type="email"/>
                          </div>
                          



              
                          <?php
                            $sql_empresa2 = "SELECT * FROM tb_empresa"; 
														$resulta2 = $conn->query($sql_empresa2);
    													if ($resulta2->num_rows > 0){
                                echo '<h3 class="kt-portlet__head-title">Empresa vinculada</h3>'; 
                                echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">';
                        	      echo '<select name="editcd_empresa" id="editcd_empresa" class="form-control">';
                                echo '<option value=""></option>';
                        		  	while ( $row2 = $resulta2->fetch_assoc()){
                          			  echo '<option value="'.$row2['cd_empresa'].'">'.$row2['rsocial_empresa'].' '.$row2['nfantasia_empresa'].'</option>';
                        				}
                                echo '</select>';
                                echo '</div>';
    													}
                            ?>
                          <button type="submit" name="atualizar" class="btn btn-success">Atualizar</button>
                          <?php
/*
                            $sql_empresa = "SELECT * FROM seg_pessoal_empresa_estilo WHERE cd_pessoal = '".$_SESSION['cd_pessoal']."'"; 
                            $resulta_empresa = $conn->query($sql_empresa);
                            if ($resulta_empresa->num_rows > 0){
                              while ( $rows = $resulta_empresa->fetch_assoc()){
                                echo '<h3 class="kt-portlet__head-title">Contratante</h3>';
                                echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">';
                                echo '<label for="editcdempresa_pessoal">CD Empresa</label>';
                                echo '<input name="editcdempresa_pessoal" id="editcdempresa_pessoal" type="text" value="'.$rows['cd_empresa'].'" class="aspNetDisabled form-control form-control-sm"/>';

                                $query3 = "SELECT * FROM tb_empresa WHERE cd_empresa = '".$rows['cd_empresa']."'";
                                $result3 = mysqli_query($conn, $query3);
                                $row3 = mysqli_fetch_assoc($result3);

                                // Exibe as informações do usuário no formulário
                                if($row3) {
                                  echo '<label for="editcdempresa_pessoal">Logo</label>';
                                  echo '<input name="editcdempresa_pessoal" id="editcdempresa_pessoal" type="text" value="'.$row3['logo_empresa'].'" class="aspNetDisabled form-control form-control-sm"/>';
  
                                  echo '<label for="editcdempresa_pessoal">Razão Social</label>';
                                  echo '<input name="editcdempresa_pessoal" id="editcdempresa_pessoal" type="text" value="'.$row3['rsocial_empresa'].'" class="aspNetDisabled form-control form-control-sm"/>';
                                }
                                echo '</div>';
                              }
                              
                            }
*/
                          ?>
                        </form>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php

                  if(isset($_POST['concpf_pessoal'])) {
                    // Consulta o usuário pelo CPF
                    $query = "SELECT * FROM tb_pessoal WHERE cpf_pessoal = '".$_POST['concpf_pessoal']."'";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);

                    // Exibe as informações do usuário no formulário
                    if($row) {
                      echo '<script>document.getElementById("edita").style.display = "block";</script>';
                      echo '<script>document.getElementById("editcd_pessoal").value = "'.$row['cd_pessoal'].'"</script>';
                      echo '<script>document.getElementById("editfoto_pessoal").value = "'.$row['foto_pessoal'].'"</script>';
                      echo '<script>document.getElementById("editpnome_pessoal").value = "'.$row['pnome_pessoal'].'"</script>';
                      echo '<script>document.getElementById("editsnome_pessoal").value = "'.$row['snome_pessoal'].'"</script>';
                      echo '<script>document.getElementById("editcpf_pessoal").value = "'.$row['cpf_pessoal'].'"</script>';
                      echo '<script>document.getElementById("editrg_pessoal").value = "'.$row['rg_pessoal'].'"</script>';
                      echo '<script>document.getElementById("editcnh_pessoal").value = "'.$row['cnh_pessoal'].'"</script>';
                      echo '<script>document.getElementById("editpis_pessoal").value = "'.$row['pis_pessoal'].'"</script>';
                      echo '<script>document.getElementById("editcarttrabalho_pessoal").value = "'.$row['carttrabalho_pessoal'].'"</script>';
                      echo '<script>document.getElementById("editdtnasc_pessoal").value = "'.$row['dtnasc_pessoal'].'"</script>';
                      echo '<script>document.getElementById("editsexo_pessoal").value = "'.$row['sexo_pessoal'].'"</script>';
                      echo '<script>document.getElementById("editecivil_pessoal").value = "'.$row['ecivil_pessoal'].'"</script>';
                      echo '<script>document.getElementById("editobs_pessoal").value = "'.$row['obs_pessoal'].'"</script>';
                      echo '<script>document.getElementById("edittel1_pessoal").value = "'.$row['tel1_pessoal'].'"</script>';
                      echo '<script>document.getElementById("editobstel1_pessoal").value = "'.$row['obs_tel1_pessoal'].'"</script>';
                      echo '<script>document.getElementById("edittel2_pessoal").value = "'.$row['tel2_pessoal'].'"</script>';
                      echo '<script>document.getElementById("editobstel2_pessoal").value = "'.$row['obs_tel2_pessoal'].'"</script>';
                      echo '<script>document.getElementById("editemail_pessoal").value = "'.$row['email_pessoal'].'"</script>';
                      

//                      $query2 = "SELECT * FROM seg_pessoal_empresa_estilo WHERE cd_pessoal = '".$row['cd_pessoal']."'";
//                      $result2 = mysqli_query($conn, $query2);
//                      $row2 = mysqli_fetch_assoc($result2);

                      // Exibe as informações do usuário no formulário
//                      if($row2) {
                        //echo '<script>document.getElementById("edita").style.display = "block";</script>';
//                        echo '<script>document.getElementById("editseg_pessoal").value = "'.$row2['cd_seg'].'"</script>';
//                        echo '<script>document.getElementById("editestilo_pessoal").value = "'.$row2['cd_estilo'].'"</script>';
//                        echo '<script>document.getElementById("editcdempresa_pessoal").value = "'.$row2['cd_empresa'].'"</script>';

//                        $query3 = "SELECT * FROM tb_empresa WHERE cd_empresa = '".$row2['cd_empresa']."'";
//                        $result3 = mysqli_query($conn, $query3);
//                        $row3 = mysqli_fetch_assoc($result3);

                        // Exibe as informações do usuário no formulário
//                        if($row3) {
                          //echo '<script>document.getElementById("edita").style.display = "block";</script>';
//                          echo '<script>document.getElementById("editrsocial_empresa").value = "'.$row3['rsocial_empresa'].'"</script>';
//                          echo '<script>document.getElementById("editlogo_empresa").value = "'.$row3['logo_empresa'].'"</script>';
//                        }


//                      }
                    
                    
                    }


                    




                  }

                  $query2 = "SELECT * FROM seg_pessoal_empresa_estilo WHERE cd_pessoal = '".$_SESSION['cd_pessoal']."'";
                  $result2 = mysqli_query($conn, $query2);
                  $row2 = mysqli_fetch_assoc($result2);
                  if($row2) {
                    echo '<script>document.getElementById("editcd_empresa").value = "'.$row2['cd_empresa'].'"</script>';
                  }



                  // Verifica se o formulário foi enviado
                  if(isset($_POST['atualizar'])) {
                    // Atualiza as informações do usuário no banco de dados
                    $query = "UPDATE tb_pessoal SET
                      foto_pessoal = '".$_POST['editfoto_pessoal']."',
                      pnome_pessoal = '".$_POST['editpnome_pessoal']."',
                      snome_pessoal = '".$_POST['editsnome_pessoal']."',
                      rg_pessoal = '".$_POST['editrg_pessoal']."',
                      cnh_pessoal = '".$_POST['editcnh_pessoal']."',
                      pis_pessoal = '".$_POST['editpis_pessoal']."',
                      carttrabalho_pessoal = '".$_POST['editcarttrabalho_pessoal']."',
                      sexo_pessoal = '".$_POST['editsexo_pessoal']."',
                      ecivil_pessoal = '".$_POST['editecivil_pessoal']."',
                      obs_pessoal = '".$_POST['editobs_pessoal']."',
                      tel1_pessoal = '".$_POST['edittel1_pessoal']."',
                      obs_tel1_pessoal = '".$_POST['editobstel1_pessoal']."',
                      tel2_pessoal = '".$_POST['edittel2_pessoal']."',
                      obs_tel2_pessoal = '".$_POST['editobstel2_pessoal']."',
                      email_pessoal = '".$_POST['editemail_pessoal']."'
                      WHERE cpf_pessoal = '".$_POST['editcpf_pessoal']."'";
                    mysqli_query($conn, $query);
                    //echo "<script>window.alert('Usuário atualizado com sucesso!');</script>";

                    $query = "UPDATE seg_pessoal_empresa_estilo SET
                      cd_empresa = '".$_POST['editcd_empresa']."'
                      WHERE cd_pessoal = '".$_SESSION['cd_pessoal']."'";
                    mysqli_query($conn, $query);
                    //echo "<script>window.alert('Usuário atualizado com sucesso!');</script>";
                  }
                ?>

                





                




                


                <div class="card-body" id="cadastro" style="display:none;">
                  <h4 class="card-title">Cadastro de pessoal</h4>
                    <p class="card-description">Informações pessoais</p>
                    <div class="kt-portlet__body">
                      <div class="row">
                        <div class="col-12 col-md-12">
                          <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                            <form method="POST">
                              <h3 class="kt-portlet__head-title">Dados pessoais</h3> 
                              <div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">
                                <label for="cd_pessoal">Código</label>
                                <input name="cd_pessoal" type="text" maxlength="10" id="cd_pessoal"  class="aspNetDisabled form-control form-control-sm" disabled="disabled"/>                             
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
                                
                                <label for="foto_pessoal">Foto</label>
                                <input name="foto_pessoal" type="text" maxlength="500" class="aspNetDisabled form-control form-control-sm" placeholder="Cole o link da sua foto"/>

                               
                                
                                <label for="pnome_pessoal">Nome</label>
                                <input name="pnome_pessoal" type="text" id="pnome_pessoal" maxlength="40"   class="aspNetDisabled form-control form-control-sm" />
                              
                             
                                <label for="snome_pessoal">sobrenome</label>
                                <input name="snome_pessoal" type="text" id="snome_pessoal" maxlength="40"   class="aspNetDisabled form-control form-control-sm" />
                              
                                <label for="cpf_pessoal">CPF</label>
                                <input name="cpf_pessoal" type="tel"  oninput="cpf(this)" class="aspNetDisabled form-control form-control-sm" />

                                <label for="rg_pessoal">RG</label>
                                <input name="rg_pessoal" type="tel"   oninput="rg(this)" class="aspNetDisabled form-control form-control-sm" />
                              
                                <label for="cnh_pessoal">CNH</label>
                                <input name="cnh_pessoal" type="tel" value="000" oninput="cnh(this)" id="cnh_pessoal"  class="aspNetDisabled form-control form-control-sm" />

                                <label for="pis_pessoal">PIS</label>
                                <input name="pis_pessoal" type="tel" maxlength="10" oninput="pis(this)" id="pis_pessoal"  class="aspNetDisabled form-control form-control-sm" />

                                <label for="carttrabalho_pessoal">Cart. de Tragbalho</label>
                                <input name="carttrabalho_pessoal" type="text"  oninput="cartTrabalho(this)" id="carttrabalho_pessoal"  class="aspNetDisabled form-control form-control-sm" placeholder="Carteira de Trabalho" />
                                
                                <label for="dtnasc_pessoal">Nascimento</label>
                                <input name="dtnasc_pessoal" type="date" id="dtnasc_pessoal"  class="aspNetDisabled form-control" data-start="date-picker" data-cco-placeholder="Admissão" placeholder="  /  /    "  /><!--required="" data-required="true"-->
  
                                <label for="sexo_pessoal">Sexo</label>
                                <select name="sexo_pessoal" id="sexo_pessoal"  class="aspNetDisabled form-control form-control-sm" placeholder="Sexo">
                                  <option selected="selected" value=""></option>
                                  <option value="M">Masculino</option>
                                	<option value="F">Feminino</option>
                                </select>
                                <label for="ecivil_pessoal">Estado Civil</label>
                                <select name="ecivil_pessoal" id="ecivil_pessoal"  class="aspNetDisabled form-control form-control-sm" placeholder="Estado Civil">
                                  <option selected="selected" value=""></option>
                                  <option value="S">Solteiro</option>
                                  <option value="C">Casado</option>
                                  <option value="V">Viúvo</option>
                                  <option value="D">Divorciado</option>
                                </select>
  
                                <label for="obs_pessoal">Observações</label>
                                <input name="obs_pessoal" type="text" id="obs_pessoal"  class="aspNetDisabled form-control"/><!--required="" data-required="true"-->
  
                                
                                <!--<input type="submit" class="btn btn-success" value="Salvar">-->
                              </div>

                          
                            <h3 class="kt-portlet__head-title">Contatos</h3>
                            <div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">
									            <label for="tel1_pessoal">Telefone 1</label>
                              <input name="tel1_pessoal" type="tel" maxlength="40" id="tel1_pessoal" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" data-cco-placeholder="Telefone 1" placeholder="(00)0000-0000" onkeyup="WebChoice.Util.formataTelefone(this, event);"/>
								                                                 
									            <label for="obs_tel1_pessoal">Complemento do Telefone 1</label>
                              <input name="obs_tel1_pessoal" type="text" maxlength="40" id="obs_tel1_pessoal"  class="aspNetDisabled form-control form-control-sm" placeholder="Complemento" />
								                                                   
									            <label for="tel2_pessoal">Telefone 2</label>
                              <input name="tel2_pessoal" type="tel" id="tel2_pessoal" maxlength="40" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" data-cco-placeholder="Telefone 2" placeholder="(00)0000-0000" onkeyup="WebChoice.Util.formataTelefone(this, event);"/>
								                  
									            <label for="obs_tel2_pessoal">Complemento do Telefone 2</label>
                              <input name="obs_tel2_pessoal" type="text" maxlength="40" id="obs_tel2_pessoal"  class="aspNetDisabled form-control form-control-sm" placeholder="Complemento" />
								                  
									            <label for="email_pessoal">E-Mail</label>
                              <input name="email_pessoal" maxlength="80" id="email_pessoal"  class="aspNetDisabled form-control form-control-sm" data-cco-placeholder="E-Mail" placeholder="email@dominio.com.br" type="email" />

                            </div>
                          
                          <!--
                            <h3 class="kt-portlet__head-title">Para empresa</h3>
                            <div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">
                              <label for="dtentrada_pessoal">Admissão</label>
                              <input name="dtentrada_pessoal" type="date" id="dtentrada_pessoal"  class="aspNetDisabled form-control" data-start="date-picker" data-cco-placeholder="Admissão" placeholder="  /  /    "  /><!--required="" data-required="true"
  						    	          
                              <label for="funcao_pessoal">Função</label>
                              <select name="funcao_pessoal" id="funcao_pessoal"  class="aspNetDisabled form-control form-control-sm" placeholder="Tipo">
				                        <option selected="selected" value=""></option>
                          		  <option value="C">Consultor</option>
                            		<option value="T">T&#233;cnico</option>
                            		<option value="CT">Consultor e T&#233;cnico</option>
                              </select>
                            
                            <label for="meta_pessoal">Meta de faturamento mensal</label>
                            <input name="meta_pessoal" type="tel" oninput="real(this)" id="meta_pessoal"  class="aspNetDisabled form-control"/>
                            </div>


                           
                              <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                              <script>
                                $(document).ready(function() {
                                  $('#cep_pessoal').blur(function() {
                                    var cep_pessoal = $(this).val().replace(/\D/g, '');
                                    if (cep_pessoal != "") {
                                      var url = "https://viacep.com.br/ws/" + cep_pessoal + "/json/";
                                      $.getJSON(url, function(dados) {
                                        if (!("erro" in dados)) {
                                          $('#endereco_pessoal').val(dados.logradouro);
                                          $('#bairro_pessoal').val(dados.bairro);
                                          $('#cidade_pessoal').val(dados.localidade);
                                          $('#uf_pessoal').val(dados.uf);
                                        } else {
                                          alert("CEP não encontrado.");
                                        }
                                      });
                                    }
                                  });
                                });
                              </script>
                              <h3 class="kt-portlet__head-title">Endereço</h3>
                              <div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">
                              <label for="cep_pessoal">CEP</label>
                              <input name="cep_pessoal" type="tel" maxlength="10" oninput="cep(this)" id="cep_pessoal"  class="aspNetDisabled form-control form-control-sm"/>
                              <label for="logradouro_pessoal">Logradouro</label>
                              <select name="logradouro_pessoal" id="logradouro_pessoal"  class="aspNetDisabled form-control form-control-sm" placeholder="Logradouro">
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
                              <label for="endereco_pessoal">Endereço</label>
                              <input name="endereco_pessoal" type="text" maxlength="60" id="endereco_pessoal"  class="aspNetDisabled form-control form-control-sm" placeholder="Endereço" MinLength="5" />
                              <label for="complemento_pessoal">Complemento</label>
                              <input name="complemento_pessoal" type="text" maxlength="20" id="complemento_pessoal"  class="aspNetDisabled form-control form-control-sm" placeholder="Complemento" MinLength="2" />

                              <label for="bairro_pessoal">Bairro</label>
                              <input name="bairro_pessoal" type="text" maxlength="30" id="bairro_pessoal"  class="aspNetDisabled form-control form-control-sm" placeholder="Bairro" MinLength="3" />
                              <label for="uf_pessoal">UF</label>
                              <input name="uf_pessoal" type="text" id="uf_pessoal"  class="aspNetDisabled form-control form-control-sm" placeholder="Cidade" onkeydown="change_ContentPlaceHolder1_iAcCidade()" data-bv-callback="true" data-bv-callback-message="Valor selecionado de forma incorreta" data-bv-callback-callback="acBootstrapValidadorCheck_ContentPlaceHolder1_iAcCidade" />
                              <label for="cidade_pessoal">Cidade</label>
                              <input name="cidade_pessoal" type="text" id="cidade_pessoal"  class="aspNetDisabled form-control form-control-sm" placeholder="Cidade" onkeydown="change_ContentPlaceHolder1_iAcCidade()" data-bv-callback="true" data-bv-callback-message="Valor selecionado de forma incorreta" data-bv-callback-callback="acBootstrapValidadorCheck_ContentPlaceHolder1_iAcCidade" />
                            </div>
                              -->
                            
                            <input type="submit" class="btn btn-success" value="SALVAR">
                          
                            </form>
                          </div>
                          <?php
                          
                          if (isset($_POST['cpf_pessoal']))
                          {
                            $foto_pessoal = addslashes($_POST['foto_pessoal']);
                            $pnome_pessoal = addslashes($_POST['pnome_pessoal']);
                            $snome_pessoal = addslashes($_POST['snome_pessoal']);
                            $cpf_pessoal = addslashes($_POST['cpf_pessoal']);
                            $rg_pessoal = addslashes($_POST['rg_pessoal']);
                            $cnh_pessoal = addslashes($_POST['cnh_pessoal']);
                            $carttrabalho_pessoal = addslashes($_POST['carttrabalho_pessoal']);
                            $pis_pessoal = addslashes($_POST['pis_pessoal']);
                            $dtnasc_pessoal = addslashes($_POST['dtnasc_pessoal']);
                            $sexo_pessoal = addslashes($_POST['sexo_pessoal']);
                            $ecivil_pessoal = addslashes($_POST['ecivil_pessoal']);
                            $obs_pessoal = addslashes($_POST['obs_pessoal']);
                            $tel1_pessoal = addslashes($_POST['tel1_pessoal']);
                            $obs_tel1_pessoal = addslashes($_POST['obs_tel1_pessoal']);
                            $tel2_pessoal = addslashes($_POST['tel2_pessoal']);
                            $obs_tel2_pessoal = addslashes($_POST['obs_tel2_pessoal']);
                            $email_pessoal = addslashes($_POST['email_pessoal']);
                            $dtentrada_pessoal = addslashes($_POST['dtentrada_pessoal']);
                            $funcao_pessoal = addslashes($_POST['funcao_pessoal']);
                            $meta_pessoal = addslashes($_POST['meta_pessoal']);

                            $endereco_pessoal = addslashes($_POST['endereco_pessoal']);
                            
                            $senha_pessoal = "1";
                            $confSenha_pessoal = "1";
                            //$confSenha_pessoal = addslashes($_POST['confSenha_pessoal']);
                            //verificar se tem algum campo vazio
                            
                            if (!empty($cpf_pessoal))
                            //if (!empty($pnome_pessoal) && !empty($cpf_pessoal) && !empty($senha_pessoal)) 
                            {
                              $u->conectar(); 
                              if ($u-> $msgErro == "")
                              {
                                if($senha_pessoal == $confSenha_pessoal)
                                {
                                  //$pnome_pessoal, $snome_pessoal, $cpf_pessoal, $rg_pessoal, $cnh_pessoal, $carttrabalho_pessoal, $pis_pessoal, $dtnasc_pessoal, $sexo_pessoal, $tel1_pessoal, $obs_tel1_pessoal, $tel2_pessoal, $obs_tel2_pessoal, $email_pessoal, $senha_pessoal

                                  //dtentrada_pessoal, funcao_pessoal, meta_pessoal,
                                  //endereco_pessoal, foto_pessoal

                                  if($u->cadPessoal($foto_pessoal, $pnome_pessoal, $snome_pessoal, $cpf_pessoal, $rg_pessoal, $cnh_pessoal, $carttrabalho_pessoal, $pis_pessoal, $dtnasc_pessoal, $sexo_pessoal, $ecivil_pessoal, $obs_pessoal, $tel1_pessoal, $obs_tel1_pessoal, $tel2_pessoal, $obs_tel2_pessoal, $email_pessoal, $dtentrada_pessoal, $funcao_pessoal, $meta_pessoal, $endereco_pessoal, $senha_pessoal)) 
                                  //if($u->cadPessoal1($pnome_pessoal, $snome_pessoal, $cpf_pessoal, $rg_pessoal, $cnh_pessoal, $carttrabalho_pessoal, $pis_pessoal, $dtnasc_pessoal, $sexo_pessoal, $tel1_pessoal, $obs_tel1_pessoal, $tel2_pessoal, $obs_tel2_pessoal, $email_pessoal, $senha_pessoal)) 
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
                                    <script>window.alert("Edição de dados cadastrais!");</script>
                                    <div class="msg-erro">Edição de dados cadastrais!</div>
                                    <?php
                                  }
                                }
                                else
                                {
                                  ?>
                                  <div class="msg-erro">Confirmação de senha não correspondem!</div>
                                  <?php
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
                              <script>window.alert("CPF em branco!");</script>
                              <div class="msg-erro">CPF em branco!!</div>
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