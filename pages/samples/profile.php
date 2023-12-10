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
  <title>Perfil</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="<?php echo $_SESSION['logo_empresa']; ?>" />
  <script src="../../js/functions.js"></script>
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
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="kt-portlet__body kt-portlet__body--fit">
                                        <ul class="kt-nav kt-nav--bold kt-nav--md-space kt-nav--v3 kt-margin-t-20 kt-margin-b-20 nav nav-tabs" role="tablist">	    
                                            <li class="kt-nav__item">
                                                <button onclick="abrirInfoPessoal()" class="btn btn-outline-secondary btn-lg btn-block" data-toggle="tab" href="#kt_profile_tab_personal_information" role="tab">
                                                    Informações Pessoais
                                                </button>
                                            </li>
											<li class="kt-nav__item">
                                                <button onclick="abrirContatos()" class="btn btn-outline-secondary btn-lg btn-block" data-toggle="tab" href="#contatos" role="tab">
                                                    Contatos
                                                </button>
                                            </li>
                                            <li class="kt-nav__item">
                                                <button onclick="abrirPreferencias()" class="btn btn-outline-secondary btn-lg btn-block" data-toggle="tab" href="#kt_profile_tab_account_information" role="tab">
                                                    Preferências
                                                </button>
                                            </li>
                                            <li class="kt-nav__item">
                                                <button onclick="abrirAlterSenha()" class="btn btn-outline-secondary btn-lg btn-block" data-toggle="tab" href="#kt_profile_change_password" role="tab">
                                                    Alterar Senha
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>


					<script>
              		  	function abrirInfoPessoal() {
                			document.getElementById("infoPessoal").style.display = "block";
                			document.getElementById("infoContatos").style.display = "none";
                    		document.getElementById("infoPreferencias").style.display = "none";
							document.getElementById("infoAlterSenha").style.display = "none";
                		}

						function abrirContatos() {
                			document.getElementById("infoPessoal").style.display = "none";
                			document.getElementById("infoContatos").style.display = "block";
                    		document.getElementById("infoPreferencias").style.display = "none";
							document.getElementById("infoAlterSenha").style.display = "none";
                		}

						function abrirPreferencias() {
                			document.getElementById("infoPessoal").style.display = "none";
                			document.getElementById("infoContatos").style.display = "none";
                    		document.getElementById("infoPreferencias").style.display = "block";
							document.getElementById("infoAlterSenha").style.display = "none";
                		}

						function abrirAlterSenha() {
                			document.getElementById("infoPessoal").style.display = "none";
                			document.getElementById("infoContatos").style.display = "none";
                    		document.getElementById("infoPreferencias").style.display = "none";
							document.getElementById("infoAlterSenha").style.display = "block";
                		}
                	</script>


                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="kt-portlet__body kt-portlet__body--fit">
                                        <div class="col-lg-8 col-xl-9">
                                    	    <div class="tab-content">


                                    		    <!--begin: Personal Information-->
                                			    <div class="tab-pane fade show active" id="infoPessoal" style="display:block;">
                                				    <div class="kt-portlet">
                            	    				    <div class="kt-portlet__head">
                            		    				    <div class="kt-portlet__head-label">
                            			    				    <h3 class="kt-portlet__head-title">Informações Pessoais</h3>
                            				    			</div>															
                                						</div>
                                						<div class="kt-form kt-form--label-right">

															<!--<form method="post" action="../../classes/salvar-imagem.php" enctype="multipart/form-data">
																<input type="file" name="imagem">
																<input type="submit" value="Enviar">
															</form>
															<img src="caminho/para/salvar/nome_do_arquivo.jpg" alt="Imagem do perfil">
															
															<?php
															//	if ($_FILES["imagem"]["error"] == UPLOAD_ERR_OK) {
															//	    $nome_arquivo = $_FILES["imagem"]["name"];
															//	    $caminho_arquivo = "../../images/perfil" . $nome_arquivo;
															//    	move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminho_arquivo);
															//	    // aqui você pode salvar o caminho do arquivo no banco de dados do usuário
															//	}
															?>
															-->
															<form method="POST">
																<div class="kt-portlet__body">
																	<div class="kt-section kt-section--first">
                                								    	<div class="kt-section__body">
																			<!--
																			<div class="form-group row">
		    																	<label class="col-xl-3 col-lg-3 col-form-label text-center">Foto <br />(tamanho max. 2MB)</label>
																			    <div class="col-lg-9 col-xl-6">
																			        <div class="kt-avatar kt-avatar--outline kt-avatar--circle" id="kt_profile_avatar">
																			            <div id="ContentPlaceHolder1_DivFoto" class="kt-avatar__holder"></div>
																				        <img src="<?php //echo $_SESSION['dominio'];?>images/foto/logo/<?php echo $_SESSION['cd_pessoal'];?>.jpg" alt="" style="width:100px; height:100px;">
																				        <label class="kt-avatar__upload" data-toggle="kt-tooltip" title="Altere sua foto">
																				            <i class="fa fa-pen"></i>
																				            <input type="file" name="profile_avatar" class="kt-avatarinputfile" />
																				            <input type="hidden" name="ctl00$ContentPlaceHolder1$hfImgUsuario" id="hfImgUsuario" />
																				            <input type="text" name="editfoto_pessoal" id="editfoto_pessoal" />
																				            <button type="submit" name="salvar_imagem" class="btn btn-primary">Salvar</button>
																				        </label>
																				        <span class="kt-avatar__cancel" data-toggle="kt-tooltip" title="Cancelar foto">
																			                <i class="fa fa-times"></i>
																			            </span>
																			        </div>
																			    </div>
																			</div>
																			-->
																			<div class="form-group row" style="display: none;">
                                        										<label class="col-xl-3 col-lg-3 col-form-label">CD</label>
                                    	        								<div class="col-lg-9 col-xl-6">
    	                                    								        <input type="rel" name="editcd_colab" id="editcd_colab" class="form-control" readonly/>																				
	                                            								</div>
        	                                    							</div>
                                                                    	    <div class="form-group row">
                                        										<label class="col-xl-3 col-lg-3 col-form-label">Nome</label>
                                    	        								<div class="col-lg-9 col-xl-6">
    	                                    								        <input type="text" name="editpnome_colab" id="editpnome_colab" class="form-control" />																				
	                                            								</div>
        	                                    							</div>
																			<div class="form-group row">
                	                        									<label class="col-xl-3 col-lg-3 col-form-label">Sobrenome</label>
                    	                	        							<div class="col-lg-9 col-xl-6">
                        	                								        <input type="text" name="editsnome_colab" id="editsnome_colab" class="form-control" />																				
                            	                								</div>
                                	            							</div>
																			<div class="form-group row">
                                        										<label class="col-xl-3 col-lg-3 col-form-label">CPF</label>
                                    	    	    							<div class="col-lg-9 col-xl-6">
                                        									        <input type="text" name="editcpf_colab" id="editcpf_colab" class="form-control" readonly/>																				
                                            									</div>
                                            								</div>
																			<!--<div class="form-group row">
                                        										<label class="col-xl-3 col-lg-3 col-form-label">RG</label>
                                    	        								<div class="col-lg-9 col-xl-6">
                                        									        <input type="text" name="editrg_colab" id="editrg_colab" oninput="rg(this)" class="form-control" />																				
                                            									</div>
	                                            							</div>
																			<div class="form-group row">
        	                                									<label class="col-xl-3 col-lg-3 col-form-label">CNH</label>
            	                        	        							<div class="col-lg-9 col-xl-6">
                	                        								        <input type="text" name="editcnh_colab" id="editcnh_colab" oninput="cnh(this)" class="form-control" />																				
                    	                        								</div>
                        	                    							</div>
																			<div class="form-group row">
                                	        									<label class="col-xl-3 col-lg-3 col-form-label">Carteira de Trabalho</label>
                                    		        							<div class="col-lg-9 col-xl-6">
                                        									        <input type="text" name="editcarttrabalho_colab" id="editcarttrabalho_colab" oninput="cartTrabalho(this)" class="form-control" />																				
                                            									</div>
                                            								</div>
																			<div class="form-group row">
                                        										<label class="col-xl-3 col-lg-3 col-form-label">PIS</label>
                                    	        								<div class="col-lg-9 col-xl-6">
                                        									        <input type="text" name="editpis_colab" id="editpis_colab" oninput="pis(this)" class="form-control" />																				
                                            									</div>
                                            								</div>-->
																			<div class="form-group row">
    	                                    									<label class="col-xl-3 col-lg-3 col-form-label">Data de Nascimento</label>
        	                            	        							<div class="col-lg-9 col-xl-6">
            	                            								        <input type="date" name="editdtnasc_colab" id="editdtnasc_colab" class="form-control" readonly/>																				
                	                            								</div>
                    	                        							</div>
																			<!--<div class="form-group row">
                            	            									<label class="col-xl-3 col-lg-3 col-form-label">Sexo</label>
                                	    	        							<div class="col-lg-9 col-xl-6">
																					<select name="editsexo_colab" id="editsexo_colab" class="form-control">
														                                <option value="M">Masculino</option>
													                                	<option value="F">Feminino</option>
																						<option value="O">Outros</option>
																					</select>																				
                                        	    								</div>
                                            								</div>
																			<div class="form-group row">
                                        										<label class="col-xl-3 col-lg-3 col-form-label">Estado Civil</label>
                                    	        								<div class="col-lg-9 col-xl-6">
																					<select name="editecivil_colab" id="editecivil_colab" class="form-control">
														                                <option value="S">Solteiro(a)</option>
													                                	<option value="C">Casado(a)</option>
																						<option value="D">Divorciado(a)</option>
																					</select>																				
                                            									</div>
                                            								</div>-->
																			<div class="form-group row">
	                                        									<label class="col-xl-3 col-lg-3 col-form-label">Observações</label>
    	                                	        							<div class="col-lg-9 col-xl-6">
        	                                								        <input type="text" name="editobs_colab" id="editobs_colab" class="form-control" />																				
            	                                								</div>
                	                            							</div>
                    	                                                </div>
                        	                                        </div>
                            	                                </div>
										                        <div class="kt-portlet__foot">
                       							    				<div>
                       								    				<div class="row">
                      									    				<div class="col-lg-3 col-xl-3">
                       										    			</div>
                  											    			<div class="col-lg-9 col-xl-9">
																				<input type="submit" value="Confirmar" class="btn btn-success" id="atualizarIPessoal" name="atualizarIPessoal">
																				&nbsp;
                                                                    	        <a id="ContentPlaceHolder1_iBtCancelar" class="btn btn-secondary" href="javascript:__doPostBack(&#39;ctl00$ContentPlaceHolder1$iBtCancelar&#39;,&#39;&#39;)"> Cancelar </a>
																			</div>
	    										                        </div>
    	                            								</div>
        	                        							</div>
															</form>

															<?php
																//if(isset($_POST['concpf_pessoal'])) {
                    											// Consulta o usuário pelo CPF
													            $query = "SELECT * FROM tb_colab WHERE cd_colab = '".$_SESSION['cd_colab']."'";
													            $result = mysqli_query($conn, $query);
													            $row = mysqli_fetch_assoc($result);
													            // Exibe as informações do usuário no formulário
													            if($row) {
														        	echo '<script>document.getElementById("editcd_colab").value = "'.$row['cd_colab'].'"</script>';
														            //echo '<script>document.getElementById("editfoto_colab").value = "'.$_SESSION['dominio'].'images/foto/logo/'.$_SESSION['cd_pessoal'].'.jpg"</script>';
														            //echo '<script>document.getElementById("foto_pessoal").value = "'.$_SESSION['dominio'].'images/foto/logo/'.$_SESSION['cd_pessoal'].'.jpg"</script>';
																	echo '<script>document.getElementById("editpnome_colab").value = "'.$row['pnome_colab'].'"</script>';
														            echo '<script>document.getElementById("editsnome_colab").value = "'.$row['snome_colab'].'"</script>';
														            echo '<script>document.getElementById("editcpf_colab").value = "'.$row['cpf_colab'].'"</script>';
														            //echo '<script>document.getElementById("editrg_colab").value = "'.$row['rg_colab'].'"</script>';
														            //echo '<script>document.getElementById("editcnh_colab").value = "'.$row['cnh_colab'].'"</script>';
														            //echo '<script>document.getElementById("editpis_colab").value = "'.$row['pis_colab'].'"</script>';
														            //echo '<script>document.getElementById("editcarttrabalho_colab").value = "'.$row['carttrabalho_colab'].'"</script>';
														            echo '<script>document.getElementById("editdtnasc_colab").value = "'.$row['dtnasc_colab'].'"</script>';
														            //echo '<script>document.getElementById("editsexo_colab").value = "'.$row['sexo_colab'].'"</script>';
														            //echo '<script>document.getElementById("editecivil_colab").value = "'.$row['ecivil_colab'].'"</script>';
														            echo '<script>document.getElementById("editobs_colab").value = "'.$row['obs_colab'].'"</script>';
																}
																//}
																// Verifica se o formulário foi enviado
													            if(isset($_POST['atualizarIPessoal'])) {
													                // Atualiza as informações do usuário no banco de dados
													                $query = "UPDATE tb_colab SET
														            pnome_colab = '".$_POST['editpnome_colab']."',
														            snome_colab = '".$_POST['editsnome_colab']."',
																	obs_colab = '".$_POST['editobs_colab']."'
																	WHERE cd_colab = '".$_POST['editcd_colab']."'";
																	mysqli_query($conn, $query);
																	//echo "<script>window.alert('Usuário atualizado com sucesso!');</script>";
																	?>
																		<script>// Limpa os cookies
									                                    // Remove as informações do formulário do histórico de navegação';
									                                    history.replaceState({}, document.title, window.location.href.split('?')[0]);

									                                    // Recarrega a página
                                    									window.location.reload();
										                                </script>
																	<?php
																}
															?>
														</div>
        	                        				</div>
            	                    			</div>

												<div class="tab-pane fade show active" id="infoContatos" style="display:none;">
                                				    <div class="kt-portlet">
                            	    				    <div class="kt-portlet__head">
                            		    				    <div class="kt-portlet__head-label">
                            			    				    <h3 class="kt-portlet__head-title">Contatos</h3>
                            				    			</div>															
                                						</div>
                                						<div class="kt-form kt-form--label-right">
															<form method="POST">
																<div class="kt-portlet__body">
																	<div class="kt-section kt-section--first">
                                								    	<div class="kt-section__body">
																			<div class="form-group row">
        	                                									<label class="col-xl-3 col-lg-3 col-form-label">E-mail</label>
            	                        	        							<div class="col-lg-9 col-xl-6">
                	                        								        <input type="text" name="editemail_colab" id="editemail_colab" class="form-control" readonly />																				
                    	                        								</div>
                        	                    							</div>
                                                                    	    <div class="form-group row">
                                        										<label class="col-xl-3 col-lg-3 col-form-label">Telefone</label>
                                    	        								<div class="col-lg-9 col-xl-6">
    	                                    								        <input type="text" name="edittel_colab" id="edittel_colab" class="form-control" />																				
	                                            								</div>
        	                                    							</div>
																			<div class="form-group row">
                	                        									<label class="col-xl-3 col-lg-3 col-form-label">Obs Telefone</label>
                    	                	        							<div class="col-lg-9 col-xl-6">
                        	                								        <input type="text" name="editobstel_colab" id="editobstel_colab" class="form-control" />																				
                            	                								</div>
                                	            							</div>
                    	                                                </div>
                        	                                        </div>
                            	                                </div>
										                        <div class="kt-portlet__foot">
                       							    				<div>
                       								    				<div class="row">
                      									    				<div class="col-lg-3 col-xl-3">
                       										    			</div>
                  											    			<div class="col-lg-9 col-xl-9">
																				<input type="submit" value="Confirmar" class="btn btn-success" id="atualizar_contatos" name="atualizar_contatos">
																				&nbsp;
                                                                    	        <a id="ContentPlaceHolder1_iBtCancelar" class="btn btn-secondary" href="javascript:__doPostBack(&#39;ctl00$ContentPlaceHolder1$iBtCancelar&#39;,&#39;&#39;)"> Cancelar </a>
																			</div>
	    										                        </div>
    	                            								</div>
        	                        							</div>
															</form>
															
															<?php
																//if(isset($_POST['concpf_pessoal'])) {
                    											// Consulta o usuário pelo CPF
													            $query = "SELECT * FROM tb_colab WHERE cd_colab = '".$_SESSION['cd_colab']."'";
													            $result = mysqli_query($conn, $query);
													            $row = mysqli_fetch_assoc($result);
													            // Exibe as informações do usuário no formulário
													            if($row) {
														        	echo '<script>document.getElementById("editemail_colab").value = "'.$row['email_colab'].'"</script>';
														            echo '<script>document.getElementById("edittel_colab").value = "'.$row['tel_colabl'].'"</script>';
														            echo '<script>document.getElementById("editobstel_colab").value = "'.$row['obs_tel_colab'].'"</script>';
														        }
																//}
																// Verifica se o formulário foi enviado
													            if(isset($_POST['atualizar_contatos'])) {
													                // Atualiza as informações do usuário no banco de dados
													                $query = "UPDATE tb_colab SET
														            email_colab = '".$_POST['editemail_colab']."',
														            tel_colab = '".$_POST['edittel_colab']."',
														            obs_tel_colab = '".$_POST['editobstel_colab']."'
														            WHERE cd_colab = '".$_SESSION['cd_colab']."'";
																	mysqli_query($conn, $query);
																	//echo "<script>window.alert('Usuário atualizado com sucesso!');</script>";
																	?>
																		<script>// Limpa os cookies
									                                    // Remove as informações do formulário do histórico de navegação';
									                                    history.replaceState({}, document.title, window.location.href.split('?')[0]);

									                                    // Recarrega a página
                                    									window.location.reload();
										                                </script>
																	<?php
																}
															?>
														</div>
        	                        				</div>
            	                    			</div>
		
												<!--end: Personal Information-->
												<div class="tab-pane fade show active" id="infoPreferencias" style="display:none;">
    				                            	<div class="kt-portlet">
                    				            		<div class="kt-portlet__head">
                                							<div class="kt-portlet__head-label">
                                								<h3 class="kt-portlet__head-title">Modifique suas preferências</h3>
				                                			</div>
														</div>
                                						<div class="kt-form kt-form--label-right">
															<form method="POST">
																<div class="kt-portlet__body">
					                                				<div class="kt-section kt-section--first">
					                                					<div class="kt-section__body">
					                                						<!--<div class="row">
					                                							<label class="col-xl-3"></label>
					                                							<div class="col-lg-9 col-xl-6">
									    			                            	<h3 class="kt-section__title kt-section__title-sm">Preferências</h3>
            					                    							</div>
                            					    						</div>-->
																			<div class="form-group row">
                                												<!--
																					Paletas de cores:  https://color.adobe.com/pt/create/color-wheel
																				-->
																				<?php
																					$sql_estilo = "SELECT * FROM tb_estilo"; 
																        	        $resulta = $conn->query($sql_estilo);
																	                if ($resulta->num_rows > 0){
																						echo '<label class="col-xl-3 col-lg-3 col-form-label">Tema do Sistema</label>';
																						echo '<div class="col-lg-9 col-xl-6">';
                    	                        	                                	echo '<select name="editcd_estilo" id="editcd_estilo" class="form-control">';
																						echo '<option value="">Selecione Tema</option>';
                    																	while ( $row = $resulta->fetch_assoc()){
                      																		echo '<option value="'.$row['cd_estilo'].'">'.$row['titulo_estilo'].'</option>';
                    																	}
																						echo '</select>';
																						echo '</div>';
																					}
																					$sql_estilo = "SELECT * FROM tb_seguranca"; 
																        	        $resulta = $conn->query($sql_estilo);
																	                if ($resulta->num_rows > 0){
																						echo '<label class="col-xl-3 col-lg-3 col-form-label">Perfil de Permissões</label>';
																						echo '<div class="col-lg-9 col-xl-6">';
                	                            	                                	echo '<select name="editcd_seg" id="editcd_seg" class="form-control">';
																						echo '<option value="">Selecione Permissão</option>';
                    																	while ( $row = $resulta->fetch_assoc()){
                      																		echo '<option value="'.$row['cd_seg'].'">'.$row['titulo_seg'].'</option>';
                    																	}
																						echo '</select>';
																						echo '</div>';
																					}
																					$sql_funcao = "SELECT * FROM tb_funcao"; 
																        	        $resulta = $conn->query($sql_funcao);
																	                if ($resulta->num_rows > 0){
																						echo '<label class="col-xl-3 col-lg-3 col-form-label">Função</label>';
																						echo '<div class="col-lg-9 col-xl-6">';
                	                            	                                	echo '<select name="editcd_funcao" id="editcd_funcao" class="form-control">';
																						echo '<option value="">Selecione Função</option>';
                    																	while ( $row = $resulta->fetch_assoc()){
                      																		echo '<option value="'.$row['cd_funcao'].'">'.$row['titulo_funcao'].'</option>';
                    																	}
																						echo '</select>';
																						echo '</div>';
																					}
																				?>
                                											</div>
                                                                        	<div>
	                                                                        	<div class="float-left">
    	                                                                        	<span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--danger kt-switch--xs">
        	                        						                    	    <label class="mb-0 pb-0">
            	            	        						                    		<input id="ContentPlaceHolder1_iCkTemaFontBold" type="checkbox" name="ctl00$ContentPlaceHolder1$iCkTemaFontBold" /> 
                	        		        					                    		<span></span>
	                	            			    			                        </label>
							                                                        </span>   
                            	                                                </div>   
                                	                                            <div  class="float-left pl-2" style="padding-top: 0.15rem !important;">
                                    	                                        	<label>Usar Font Bold</label>
                                        	                                    </div>
                                            	                            </div>
                                                	                    </div>
                                                    	            </div>
                                                        	    </div>
                                                            	<div class="kt-portlet__foot">
	                                								<div class="kt-form__actions">
    	                            									<div class="row">
        	                        										<div class="col-lg-3 col-xl-3">
            	                       										</div>
	            	                    									<div class="col-lg-9 col-xl-9">
																				<input type="submit" value="Confirmar" class="btn btn-success" id="atualizar_preferencias" name="atualizar_preferencias">
																				&nbsp;
   	                                                                	        <a id="ContentPlaceHolder1_iBtCancelar" class="btn btn-secondary" href="javascript:__doPostBack(&#39;ctl00$ContentPlaceHolder1$iBtCancelar&#39;,&#39;&#39;)"> Cancelar </a>
					        			    								</div>
							        	                        		</div>
                            					    				</div>
                            						    		</div>
															</form>
															<?php
																//if(isset($_POST['concpf_pessoal'])) {
                    											// Consulta o usuário pelo CPF
													            $query = "SELECT * FROM rel_user WHERE cd_colab = '".$_SESSION['cd_colab']."' AND cd_empresa = '".$_SESSION['cd_empresa']."'";
													            $result = mysqli_query($conn, $query);
													            $row = mysqli_fetch_assoc($result);
													            // Exibe as informações do usuário no formulário
													            if($row) {
														        	echo '<script>document.getElementById("editcd_estilo").value = "'.$row['cd_estilo'].'"</script>';
														            echo '<script>document.getElementById("editcd_seg").value = "'.$row['cd_seg'].'"</script>';
																	echo '<script>document.getElementById("editcd_funcao").value = "'.$row['cd_funcao'].'"</script>';
																}
																//}
																// Verifica se o formulário foi enviado
													            if(isset($_POST['atualizar_preferencias'])) {
													                // Atualiza as informações do usuário no banco de dados
													                $query = "UPDATE rel_user SET
														            cd_estilo = '".$_POST['editcd_estilo']."',
														            cd_seg = '".$_POST['editcd_seg']."',
																	cd_funcao = '".$_POST['editcd_funcao']."'
																	WHERE cd_colab = '".$_SESSION['cd_colab']."';";
																	mysqli_query($conn, $query);
																	//echo "<script>window.alert('Usuário atualizado com sucesso!');</script>";
																	?>
																		<script>// Limpa os cookies
									                                    // Remove as informações do formulário do histórico de navegação';
									                                    history.replaceState({}, document.title, window.location.href.split('?')[0]);

									                                    // Recarrega a página
                                    									window.location.reload();
										                                </script>
																	<?php
																} 
															?>


                            							</div>
                            						</div>
	                            				</div>

												<!--begin: Change Password -->
                                				<div class="tab-pane fade show active" id="infoAlterSenha" style="display:none;">
                            	    				<div class="kt-portlet">
                            		    				<div class="kt-portlet__head">
                                							<div class="kt-portlet__head-label">
                                								<h3 class="kt-portlet__head-title">Altere sua senha</h3>
                                							</div>
	                                					</div>
                                						<div class="kt-form kt-form--label-right">
															<form method="POST">
                                								<div class="kt-portlet__body">
	                                								<div class="kt-section kt-section--first">
    	                            									<div class="kt-section__body">
        	                        										<div class="form-group row">
            	                    											<label class="col-xl-3 col-lg-3 col-form-label">Senha atual</label>
                	                											<div class="col-lg-9 col-xl-6">
                    	                            								<input name="senha_atual" id="senha_atual" class="form-control" type="text" />
                        	                                                    </div>
                            	    										</div>
                                											<div class="form-group row">
                                												<label class="col-xl-3 col-lg-3 col-form-label">Nova senha</label>
                                												<div class="col-lg-9 col-xl-6">
                                            	                                	<input name="senha_nova1" id="senha_nova1" class="form-control" type="password" />
                                												</div>
                                											</div>
                                											<div class="form-group form-group-last row">
                                												<label class="col-xl-3 col-lg-3 col-form-label">Confirme a nova senha</label>
                                												<div class="col-lg-9 col-xl-6">
                                                                    	        	<input name="senha_nova2" id="senha_nova2" class="form-control" type="password" />
                                												</div>
	                                										</div>
    	                            									</div>
	    	                            							</div>
            	                    							</div>
                	                							<div class="kt-portlet__foot">
	                                								<div class="kt-form__actions">
    	                            									<div class="row">
        	                        										<div class="col-lg-3 col-xl-3">
            	                       										</div>
	            	                    									<div class="col-lg-9 col-xl-9">
																				<input type="submit" value="Confirmar" class="btn btn-success" id="atualizar_senha" name="atualizar_senha">
																				&nbsp;
   	                                                                	        <a id="ContentPlaceHolder1_iBtCancelar" class="btn btn-secondary" href="javascript:__doPostBack(&#39;ctl00$ContentPlaceHolder1$iBtCancelar&#39;,&#39;&#39;)"> Cancelar </a>
					        			    								</div>
							        	                        		</div>
                            					    				</div>
                            						    		</div>
															</form>
															<?php
																//if(isset($_POST['concpf_pessoal'])) {
                    											// Consulta o usuário pelo CPF
																if(isset($_POST['atualizar_senha'])){			//atualizar_senha						
														            $query = "SELECT * FROM tb_colab WHERE cd_colab = '".$_SESSION['cd_colab']."'";
														            $result = mysqli_query($conn, $query);
														            $row = mysqli_fetch_assoc($result);
														            // Exibe as informações do usuário no formulário
														            if($row['senha_colab'] == $_POST['senha_atual']) {
																		echo "<script>window.alert('Senha certa');</script>";
																		if($_POST['senha_nova1'] == $_POST['senha_nova2']){
																			echo "<script>window.alert('Confirmação de senha certa');</script>";
																			$query = "UPDATE tb_colab SET
														        			    senha_colab = '".$_POST['senha_nova2']."'
																	        	WHERE cd_colab = '".$_SESSION['cd_colab']."';
																			";
																			mysqli_query($conn, $query);
																			//echo "<script>window.alert('Usuário atualizado com sucesso!');</script>";
																			?>
																				<script>// Limpa os cookies
												                                	// Remove as informações do formulário do histórico de navegação';
												                                	history.replaceState({}, document.title, window.location.href.split('?')[0]);
												                                    // Recarrega a página
		                                    										window.location.reload();
												                                </script>
																			<?php
																		}
																		else{
																			echo "<script>window.alert('CONFIRMAÇÃO DE SENHA ERRADA!');</script>";
																		}
															        	//echo '<script>document.getElementById("editcd_estilo").value = "'.$row['cd_estilo'].'"</script>';
															            //echo '<script>document.getElementById("editcd_seg").value = "'.$row['cd_seg'].'"</script>';
																		//echo '<script>document.getElementById("editcd_funcao").value = "'.$row['cd_funcao'].'"</script>';
																		//echo "<script>window.alert('Senha certa');</script>";
																	}else{
																		echo "<script>window.alert('SENHA ERRADA!');</script>";
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
                        </div>
			</div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
        	<div class="d-sm-flex justify-content-center justify-content-sm-between">
            	<span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Erp-NuvemSoft</span>
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
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <!-- endinject -->
  <!-- plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <!-- End custom js for this page-->
</body>

</html>










