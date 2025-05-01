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
                                            
											<?php
												if(isset($_POST['tabInfoPessoal'])){
													$_SESSION['opcaoMenu'] = 1;
												}else if(isset($_POST['tabInfoContatos'])){
													$_SESSION['opcaoMenu'] = 2;
												}else if(isset($_POST['tabInfoPreferencias'])){
													$_SESSION['opcaoMenu'] = 3;
												}else if(isset($_POST['tabInfoSenha'])){
													$_SESSION['opcaoMenu'] = 4;
												}else
											?>
											
											<style>
												form {
													display: inline-block 0px; /* Torna o formulário um elemento em linha */
													vertical-align: top; /* Alinha o topo do formulário com o topo dos botões */
												}
												.kt-nav__item {
													display: inline-block;
													margin-right: 10px; /* ajuste conforme necessário */
												}
											</style>

											<form method="POST">
												<ul class="button-list">
													<li class="kt-nav__item">
														<input type="submit" id="tabInfoPessoal" name="tabInfoPessoal" class="btn btn-outline-secondary btn-lg btn-block" value="Informações Pessoais">
													</li>
													<li class="kt-nav__item">
														<input type="submit" id="tabInfoContatos" name="tabInfoContatos" class="btn btn-outline-secondary btn-lg btn-block" value="Contatos">
													</li>
													<li class="kt-nav__item">
														<input type="submit" id="tabInfoPreferencias" name="tabInfoPreferencias" class="btn btn-outline-secondary btn-lg btn-block" value="Preferências">    
													</li>
													<li class="kt-nav__item">
														<input type="submit" id="tabInfoSenha" name="tabInfoSenha" class="btn btn-outline-secondary btn-lg btn-block" value="Alterar Senha">
													</li>
												</ul>
											</form>



                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>


					


                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="kt-portlet__body kt-portlet__body--fit">
                                        <div class="col-lg-8 col-xl-9">
                                    	    <div class="tab-content">
												<?php
												
													if(!isset($_SESSION['opcaoMenu'])){
														$_SESSION['opcaoMenu'] = 1;
													}

													if(isset($_POST['gravaInfoPessoal_Funcao'])) {
														// Atualiza as informações do usuário no banco de dados
														$query = "UPDATE tb_pessoa SET
														pnome_pessoa = '".$_POST['editpnome_colab']."',
														snome_pessoa = '".$_POST['editsnome_colab']."',
														obs_pessoa = '".$_POST['editobs_colab']."'
														WHERE cd_pessoa = '".$_POST['editcd_colab']."'";
														if(mysqli_query($conn, $query)){
															echo "<script>window.alert('Cadastro Atualizado com sucesso!');</script>";
														}else{
															echo "<script>window.alert('Erro ao atualizar Cadastro!');</script>";
														}
														?>
															<script>// Limpa os cookies
												        		// Remove as informações do formulário do histórico de navegação';
														        ////history.replaceState({}, document.title, window.location.href.split('?')[0]);
														        // Recarrega a página
				                                    			////window.location.reload();
													        </script>
														<?php
													}

													if(isset($_POST['gravaInfoContatos_Funcao'])) {
														// Atualiza as informações do usuário no banco de dados
														$query = "UPDATE tb_pessoa SET
														email_pessoa = '".$_POST['editemail_colab']."',
														tel1_pessoa = '".$_POST['edittel_colab']."',
														obs_tel1_pessoa = '".$_POST['editobstel_colab']."'
														WHERE cd_pessoa = '".$_SESSION['cd_colab']."'";
														if(mysqli_query($conn, $query)){
															echo "<script>window.alert('Cadastro Atualizado com sucesso!');</script>";
														}else{
															echo "<script>window.alert('Erro ao atualizar Cadastro!');</script>";
														}
														?>
															<script>// Limpa os cookies
												        		// Remove as informações do formulário do histórico de navegação';
														        history.replaceState({}, document.title, window.location.href.split('?')[0]);
														        // Recarrega a página
				                                    			window.location.reload();
													        </script>
														<?php
													}

													if(isset($_POST['gravaInfoPreferencias_Funcao'])) {
														// Atualiza as informações do usuário no banco de dados
														$query = "UPDATE rel_master SET
														cd_estilo = '".$_POST['editcd_estilo']."', ";
														if($_POST['editcd_acesso'] != "0"){
															$query =$query." cd_acesso = '".$_POST['editcd_acesso']."', ";
														}
														$query =$query." status_rel = 'ativo' ";
														$query = $query." WHERE cd_pessoa = '".$_SESSION['cd_colab']."';";
														if(mysqli_query($conn, $query)){
															$select_estilo = "SELECT * FROM tb_estilo WHERE cd_estilo = '".$_POST['editcd_estilo']."'";
															$result_estilo = mysqli_query($conn, $select_estilo);
													    	$row_estilo = mysqli_fetch_assoc($result_estilo);
													        // Exibe as informações do usuário no formulário
												            if($row_estilo) {
																
																$_SESSION['t_sidebar'] = $row_estilo['t_sidebar'];
																$_SESSION['c_sidebar'] = $row_estilo['c_sidebar'];
												
																$_SESSION['t_navbar'] = $row_estilo['t_navbar'];
																$_SESSION['c_navbar'] = $row_estilo['c_navbar'];
												
																$_SESSION['t_font'] = $row_estilo['t_font'];
																$_SESSION['c_font'] = $row_estilo['c_font'];
												
																$_SESSION['c_body'] = $row_estilo['c_body'];
																$_SESSION['c_card'] = $row_estilo['c_card'];

															}

         
			
															echo "<script>window.alert('Cadastro Atualizado com sucesso!');</script>";
														}else{
															echo "<script>window.alert('Erro ao atualizar Cadastro!');</script>";
														}
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

													if(isset($_POST['gravaInfoSenha_Funcao'])){			//atualizar_senha						
														$query = "SELECT * FROM tb_pessoa WHERE cd_pessoa = '".$_SESSION['cd_colab']."'";
														$result = mysqli_query($conn, $query);
														$row = mysqli_fetch_assoc($result);
														// Exibe as informações do usuário no formulário
														if($row['senha_pessoa'] == $_POST['senha_atual']) {
															echo "<script>window.alert('Senha certa');</script>";
															if($_POST['senha_nova1'] == $_POST['senha_nova2']){
																echo "<script>window.alert('Confirmação de senha certa');</script>";
																$query = "UPDATE tb_pessoa SET
														        	senha_pessoa = '".$_POST['senha_nova2']."'
																	WHERE cd_pessoa = '".$_SESSION['cd_colab']."';
																";
																if(mysqli_query($conn, $query)){
																	echo "<script>window.alert('Cadastro Atualizado com sucesso!');</script>";
																}else{
																	echo "<script>window.alert('Erro ao atualizar Cadastro!');</script>";
																}
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
															else
															{
																echo "<script>window.alert('CONFIRMAÇÃO DE SENHA ERRADA!');</script>";
															}
															//echo '<script>document.getElementById("editcd_estilo").value = "'.$row['cd_estilo'].'"</script>';
															//echo '<script>document.getElementById("editcd_acesso").value = "'.$row['cd_acesso'].'"</script>';
															//echo '<script>document.getElementById("editcd_funcao").value = "'.$row['cd_funcao'].'"</script>';
															//echo "<script>window.alert('Senha certa');</script>";
														}
														else
														{
															echo "<script>window.alert('SENHA ERRADA!');</script>";
														}
													}

													if($_SESSION['opcaoMenu'] == 1){
														echo ' <!--begin: Personal Information-->';
														echo ' <div class="tab-pane fade show active" id="infoPessoal">';
														echo ' <div class="kt-portlet">';
														echo ' <div class="kt-portlet__head">';
														echo ' <div class="kt-portlet__head-label">';
														echo ' <h3 class="kt-portlet__head-title">Informações Pessoais</h3>';
														echo ' </div>															';
														echo ' </div>';
														echo ' <div class="kt-form kt-form--label-right">';

														echo ' <form method="POST">';
														echo ' <div class="kt-portlet__body">';
														echo ' <div class="kt-section kt-section--first">';
														echo ' <div class="kt-section__body">';


														$query = "SELECT * FROM tb_pessoa WHERE cd_pessoa = '".$_SESSION['cd_colab']."'";
														$result = mysqli_query($conn, $query);
														$row = mysqli_fetch_assoc($result);
														// Exibe as informações do usuário no formulário
														if($row) {
															echo ' <div class="form-group row" style="display: block;">';
															echo ' <label class="col-xl-3 col-lg-3 col-form-label">CD</label>';
															echo ' <div class="col-lg-9 col-xl-6">';
															echo ' <input type="tel" name="editcd_colab" id="editcd_colab" class="form-control" value="'.$row['cd_pessoa'].'" readonly/>																				';
															echo ' </div>';
															echo ' </div>';

															echo ' <div class="form-group row">';
															echo ' <label class="col-xl-3 col-lg-3 col-form-label">Nome</label>';
															echo ' <div class="col-lg-9 col-xl-6">';
															echo ' <input type="text" name="editpnome_colab" id="editpnome_colab" value = "'.$row['pnome_pessoa'].'" class="form-control" />																				';
															echo ' </div>';
															echo ' </div>';

															echo ' <div class="form-group row">';
															echo ' <label class="col-xl-3 col-lg-3 col-form-label">Sobrenome</label>';
															echo ' <div class="col-lg-9 col-xl-6">';
															echo ' <input type="text" name="editsnome_colab" id="editsnome_colab" value = "'.$row['snome_pessoa'].'" class="form-control" />																				';
															echo ' </div>';
															echo ' </div>';

															echo ' <div class="form-group row">';
															echo ' <label class="col-xl-3 col-lg-3 col-form-label">CPF</label>';
															echo ' <div class="col-lg-9 col-xl-6">';
															echo ' <input type="text" name="editcpf_colab" id="editcpf_colab" class="form-control" value = "'.$row['cpf_pessoa'].'" readonly/>																				';
															echo ' </div>';
															echo ' </div>';

															echo ' <div class="form-group row">';
															echo ' <label class="col-xl-3 col-lg-3 col-form-label">Data de Nascimento</label>';
															echo ' <div class="col-lg-9 col-xl-6">';
															echo ' <input type="date" name="editdtnasc_colab" id="editdtnasc_colab" class="form-control" value = "'.$row['dtnasc_pessoa'].'" readonly/>																				';
															echo ' </div>';
															echo ' </div>';

															echo ' <div class="form-group row">';
															echo ' <label class="col-xl-3 col-lg-3 col-form-label">Observações</label>';
															echo ' <div class="col-lg-9 col-xl-6">';
															echo ' <input type="text" name="editobs_colab" id="editobs_colab" value = "'.$row['obs_pessoa'].'" class="form-control" />																				';
															echo ' </div>';
															echo ' </div>';			
														}
														
														echo ' </div>';
														echo ' </div>';
														echo ' </div>';
														echo ' <div class="kt-portlet__foot">';
														echo ' <div>';
														echo ' <div class="row">';
														echo ' <div class="col-lg-3 col-xl-3">';
														echo ' </div>';
														echo ' <div class="col-lg-9 col-xl-9">';
														echo ' <input type="submit" value="Confirmar" class="btn btn-success" id="gravaInfoPessoal_Funcao" name="gravaInfoPessoal_Funcao">';
														echo ' &nbsp;';
														echo ' <a id="ContentPlaceHolder1_iBtCancelar" class="btn btn-secondary" href="javascript:__doPostBack(&#39;ctl00$ContentPlaceHolder1$iBtCancelar&#39;,&#39;&#39;)"> Cancelar </a>';
														echo ' </div>';
														echo ' </div>';
														echo ' </div>';
														echo ' </div>';
														echo ' </form>';

													}else if($_SESSION['opcaoMenu'] == 2){
														echo ' <!--begin: Personal Information-->';
														echo ' <div class="tab-pane fade show active" id="infoPessoal" style="display:block;">';
														echo ' <div class="kt-portlet">';
														echo ' <div class="kt-portlet__head">';
														echo ' <div class="kt-portlet__head-label">';
														echo ' <h3 class="kt-portlet__head-title">Contatos</h3>';
														echo ' </div>															';
														echo ' </div>';

														echo ' <div class="kt-form kt-form--label-right">';
														echo ' <form method="POST">';
														echo ' <div class="kt-portlet__body">';
														echo ' <div class="kt-section kt-section--first">';
                                						echo ' <div class="kt-section__body">';

														$query = "SELECT * FROM tb_pessoa WHERE cd_pessoa = '".$_SESSION['cd_colab']."'";
													    $result = mysqli_query($conn, $query);
													    $row = mysqli_fetch_assoc($result);
													    // Exibe as informações do usuário no formulário

													    if($row) {
															echo ' <div class="form-group row">';
															echo ' <label class="col-xl-3 col-lg-3 col-form-label">E-mail</label>';
															echo ' <div class="col-lg-9 col-xl-6">';
															echo ' <input type="text" name="editemail_colab" id="editemail_colab" class="form-control" value = "'.$row['email_pessoa'].'" readonly />																				';
															echo ' </div>';
															echo ' </div>';

															echo ' <div class="form-group row">';
															echo ' <label class="col-xl-3 col-lg-3 col-form-label">Telefone</label>';
															echo ' <div class="col-lg-9 col-xl-6">';
															echo ' <input type="text" name="edittel_colab" id="edittel_colab" value = "'.$row['tel1_pessoa'].'" class="form-control" />																				';
															echo ' </div>';
															echo ' </div>';

															echo ' <div class="form-group row">';
															echo ' <label class="col-xl-3 col-lg-3 col-form-label">Obs Telefone</label>';
															echo ' <div class="col-lg-9 col-xl-6">';
															echo ' <input type="text" name="editobstel_colab" id="editobstel_colab" value = "'.$row['obs_tel1_pessoa'].'" class="form-control" />																				';
															echo ' </div>';
															echo ' </div>';


														        
														}
														
                    	                                echo ' </div>';
                        	                            echo ' </div>';
                            	                        echo ' </div>';
										                echo ' <div class="kt-portlet__foot">';
														echo ' <div>';
														echo ' <div class="row">';
														echo ' <div class="col-lg-3 col-xl-3">';
														echo ' </div>';
														echo ' <div class="col-lg-9 col-xl-9">';
														echo ' <input type="submit" value="Confirmar" class="btn btn-success" id="gravaInfoContatos_Funcao" name="gravaInfoContatos_Funcao">';
														echo ' &nbsp;';
                                                        echo ' <a id="ContentPlaceHolder1_iBtCancelar" class="btn btn-secondary" href="javascript:__doPostBack(&#39;ctl00$ContentPlaceHolder1$iBtCancelar&#39;,&#39;&#39;)"> Cancelar </a>';
														echo ' </div>';
	    										        echo ' </div>';
    	                            					echo ' </div>';
        	                        					echo ' </div>';
														echo ' </form>';
														

													}else if($_SESSION['opcaoMenu'] == 3){
														echo ' <!--begin: Personal Information-->';
														echo ' <div class="tab-pane fade show active" id="infoPessoal">';
														echo ' <div class="kt-portlet">';
														echo ' <div class="kt-portlet__head">';
														echo ' <div class="kt-portlet__head-label">';
														echo ' <h3 class="kt-portlet__head-title">Preferências</h3>';
														echo ' </div>';
														echo ' </div>';
														echo ' <div class="kt-form kt-form--label-right">';
														echo ' <form method="POST">';
														echo ' <div class="kt-portlet__body">';
					                                	echo ' <div class="kt-section kt-section--first">';
					                                	echo ' <div class="kt-section__body">';
					                                	echo ' <!--<div class="row">';
					                                	echo ' <label class="col-xl-3"></label>';
					                                	echo ' <div class="col-lg-9 col-xl-6">';
									    			    echo ' <h3 class="kt-section__title kt-section__title-sm">Preferências</h3>';
            					                    	echo ' </div>';
                            					    	echo ' </div>-->';
														echo ' <div class="form-group row">';
                                						echo ' <!--';
														echo ' Paletas de cores:  https://color.adobe.com/pt/create/color-wheel';
														echo ' -->';
															
														
														//if(isset($_POST['concpf_pessoal'])) {
                    									// Consulta o usuário pelo CPF
													    $query_rel_user = "SELECT * FROM rel_master WHERE cd_pessoa = '".$_SESSION['cd_colab']."'";
													    $result_rel_user = mysqli_query($conn, $query_rel_user);
													    $row_rel_user = mysqli_fetch_assoc($result_rel_user);
												        // Exibe as informações do usuário no formulário
											            if($row_rel_user) {
												        	echo "<script>document.getElementById('editcd_estilo').value = '".$row_rel_user['cd_estilo']."';</script>";
												            //$sql_estilo = "SELECT * FROM tb_estilo";
															$sql_estilo = "SELECT * FROM tb_estilo ORDER BY CASE WHEN cd_estilo = '".$row_rel_user['cd_estilo']."' THEN 0 ELSE 1 END, cd_estilo;";
															$resulta_estilo = $conn->query($sql_estilo);

															if ($resulta_estilo->num_rows > 0){
																echo ' <label class="col-xl-3 col-lg-3 col-form-label">Tema do Sistema</label>';
																echo ' <div class="col-lg-9 col-xl-6">';
																echo ' <select name="editcd_estilo" id="editcd_estilo" class="form-control">';
																//echo ' <option value="">Selecione Tema</option>';
																while ( $row_estilo = $resulta_estilo->fetch_assoc()){
																	echo ' <option value="'.$row_estilo['cd_estilo'].'">'.$row_estilo['titulo_estilo'].'</option>';
																}
																echo ' </select>';
																echo ' </div>';
															}

															echo '<script>document.getElementById("editcd_acesso").value = "'.$row_rel_user['cd_acesso'].'"</script>';
															//$sql_estilo = "SELECT * FROM tb_seguranca";
															if($row_rel_user['cd_acesso'] != ""){
																$sql_seg = "SELECT * FROM tb_acesso ORDER BY CASE WHEN cd_acesso = '".$row_rel_user['cd_acesso']."' THEN 0 ELSE 1 END, cd_acesso;";	
																$resulta_seg = $conn->query($sql_seg);
																if ($resulta_seg->num_rows > 0){
																	echo ' <label class="col-xl-3 col-lg-3 col-form-label">Perfil de Permissões</label>';
																	echo ' <div class="col-lg-9 col-xl-6">';
																	echo ' <select name="editcd_acesso" id="editcd_acesso" class="form-control">';
																	//echo ' <option value="">Selecione Permissão</option>';
																	while ( $row_seg = $resulta_seg->fetch_assoc()){
																		echo ' <option value="'.$row_seg['cd_acesso'].'">'.$row_seg['titulo_acesso'].'</option>';
																	}
																	echo ' </select>';
																	echo ' </div>';
																}
															}else{
																
																echo ' <input type="text" style="display:none;"name="editcd_acesso" id="editcd_acesso" value="0">';
																


																echo '<div class=" text-center">';
                      echo "<h3>Escolha seu plano de acesso - ".$_SESSION['cd_empresa']."</h3>";
                      echo '<div>';
                      echo '<div class="card-deck">';

                      echo '<div class="card text-center">';
  
                        echo '<div class="card-header">R$: 50,00 por Mês ou 450 por Ano</div>';
                      
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">Vantagens</h5>';
                        echo '<p class="card-text"><i class="icon-circle-check"></i> Controle de Caixa</p>';
                        echo '<p class="card-text"><i class="icon-circle-check"></i> Ordem de serviço</p>';
                        echo '<p class="card-text"><i class="icon-circle-check"></i> Folha de Ponto</p>';
                        echo '<h5 class="card-title">Desvantagens</h5>';
                        echo '<p class="card-text"><i class="icon-circle-cross"></i> PIX Dinâmico</p>';
                        echo '<p class="card-text"><i class="icon-circle-cross"></i> Site</p>';
                        echo '<p class="card-text"><i class="icon-circle-cross"></i> Loja</p>';
                        echo '</div>';

                        echo '<div class="card-footer text-muted">';
                        echo '<form method="post" action="../cad_geral/unidade_operacional.php">';
                        echo '<input class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" type="submit" value="Plano Básico" >';
                        echo '</form>';
                        echo '</div>';

                      echo '</div>';


                      echo '<div class="card text-center">';
  
                        echo '<div class="card-header">R$: 80,00 por Mês ou 750 por Ano</div>';

                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">Vantagens</h5>';
                        echo '<p class="card-text"><i class="icon-circle-check"></i> Controle de Caixa</p>';
                        echo '<p class="card-text"><i class="icon-circle-check"></i> Ordem de serviço</p>';
                        echo '<p class="card-text"><i class="icon-circle-check"></i> Folha de Ponto</p>';
                        echo '<p class="card-text"><i class="icon-circle-cross"></i> Site</p>';
                        echo '<p class="card-text"><i class="icon-circle-cross"></i> Loja</p>';
                        echo '<h5 class="card-title">Desvantagens</h5>';
                        echo '<p class="card-text"><i class="icon-circle-cross"></i> PIX Dinâmico</p>';
                        echo '</div>';

                        echo '<div class="card-footer text-muted">';
                        echo '<form method="post" action="../cad_geral/unidade_operacional.php">';
                        echo '<input class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" type="submit" value="Plano Intermediário" >';
                        echo '</form>';
                        echo '</div>';
                        
                      echo '</div>';

                      

                      

                     

                      

                      echo '</div>';

					  
															}
															

															
														}
																
														echo ' </div>';
														echo ' <div>';
														echo ' <div class="float-left">';
														echo ' <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--danger kt-switch--xs">';
														echo ' <label class="mb-0 pb-0">';
														echo ' <input id="ContentPlaceHolder1_iCkTemaFontBold" type="checkbox" name="ctl00$ContentPlaceHolder1$iCkTemaFontBold" /> ';
														echo ' <span></span>';
														echo ' </label>';
														echo ' </span>   ';
														echo ' </div>   ';
														echo ' <div  class="float-left pl-2" style="padding-top: 0.15rem !important;">';
														echo ' <label>Usar Font Bold</label>';
														echo ' </div>';
														echo ' </div>';
														echo ' </div>';
														echo ' </div>';
														echo ' </div>';
														echo ' <div class="kt-portlet__foot">';
														echo ' <div class="kt-form__actions">';
														echo ' <div class="row">';
														echo ' <div class="col-lg-3 col-xl-3">';
														echo ' </div>';
														echo ' <div class="col-lg-9 col-xl-9">';
														echo ' <input type="submit" value="Confirmar" class="btn btn-success" id="gravaInfoPreferencias_Funcao" name="gravaInfoPreferencias_Funcao">';
														echo ' &nbsp;';
														echo ' <a id="ContentPlaceHolder1_iBtCancelar" class="btn btn-secondary" href="javascript:__doPostBack(&#39;ctl00$ContentPlaceHolder1$iBtCancelar&#39;,&#39;&#39;)"> Cancelar </a>';
														echo ' </div>';
														echo ' </div>';
														echo ' </div>';
														echo ' </div>';
														echo ' </form>';
														                            							
													}else if($_SESSION['opcaoMenu'] == 4){
														echo ' <!--begin: Personal Information-->';
														echo ' <div class="tab-pane fade show active">';
														echo ' <div class="kt-portlet">';
														echo ' <div class="kt-portlet__head">';
														echo ' <div class="kt-portlet__head-label">';
														echo ' <h3 class="kt-portlet__head-title">Alterar Senha</h3>';
														echo ' </div>';
														echo ' </div>';

														echo ' <div class="kt-form kt-form--label-right">';
														echo ' <form method="POST">';
                                						echo ' <div class="kt-portlet__body">';
	                                					echo ' <div class="kt-section kt-section--first">';
    	                            					echo ' <div class="kt-section__body">';
        	                        					echo ' <div class="form-group row">';
            	                    					echo ' <label class="col-xl-3 col-lg-3 col-form-label">Senha atual</label>';
                	                					echo ' <div class="col-lg-9 col-xl-6">';
                    	                            	echo ' <input name="senha_atual" id="senha_atual" class="form-control" type="text" />';
                        	                            echo ' </div>';
                            	    					echo ' </div>';
                                						echo ' <div class="form-group row">';
                                						echo ' <label class="col-xl-3 col-lg-3 col-form-label">Nova senha</label>';
                                						echo ' <div class="col-lg-9 col-xl-6">';
                                            	        echo ' <input name="senha_nova1" id="senha_nova1" class="form-control" type="password" />';
                                						echo ' </div>';
                                						echo ' </div>';
                                						echo ' <div class="form-group form-group-last row">';
                                						echo ' <label class="col-xl-3 col-lg-3 col-form-label">Confirme a nova senha</label>';
                                						echo ' <div class="col-lg-9 col-xl-6">';
                                                        echo ' <input name="senha_nova2" id="senha_nova2" class="form-control" type="password" />';
                                						echo ' </div>';
	                                					echo ' </div>';
    	                            					echo ' </div>';
	    	                            				echo ' </div>';
            	                    					echo ' </div>';
                	                					echo ' <div class="kt-portlet__foot">';
	                                					echo ' <div class="kt-form__actions">';
    	                            					echo ' <div class="row">';
        	                        					echo ' <div class="col-lg-3 col-xl-3">';
														echo ' </div>';
	            	                    				echo ' <div class="col-lg-9 col-xl-9">';
														echo ' <input type="submit" value="Confirmar" class="btn btn-success" id="gravaInfoSenha_Funcao" name="gravaInfoSenha_Funcao">';
														echo ' &nbsp;';
														echo ' <a id="ContentPlaceHolder1_iBtCancelar" class="btn btn-secondary" href="javascript:__doPostBack(&#39;ctl00$ContentPlaceHolder1$iBtCancelar&#39;,&#39;&#39;)"> Cancelar </a>';
					        			    			echo ' </div>';
							        	                echo ' </div>';
                            					    	echo ' </div>';
                            						    echo ' </div>';
														echo ' </form>';

															
																
															
													}

												?>

												
		
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
																					$sql_acesso = "SELECT * FROM tb_acesso"; 
																        	        $resulta = $conn->query($sql_acesso);
																	                if ($resulta->num_rows > 0){
																						echo '<label class="col-xl-3 col-lg-3 col-form-label">Perfil de Permissões</label>';
																						echo '<div class="col-lg-9 col-xl-6">';
                	                            	                                	echo '<select name="editcd_acesso" id="editcd_acesso" class="form-control">';
																						echo '<option value="">Selecione Permissão</option>';
                    																	while ( $row = $resulta->fetch_assoc()){
                      																		echo '<option value="'.$row['cd_acesso'].'">'.$row['titulo_acesso'].'</option>';
                    																	}
																						echo '</select>';
																						echo '</div>';
																					}else{


																						echo '<div class=" text-center">';
                      echo "<h3>Escolha seu plano de acesso - ".$_SESSION['cd_empresa']."</h3>";
                      echo '<div>';
                      echo '<div class="card-deck">';

                      echo '<div class="card text-center">';
  
                        echo '<div class="card-header">R$: 50,00 por Mês ou 450 por Ano</div>';
                      
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">Vantagens</h5>';
                        echo '<p class="card-text"><i class="icon-circle-check"></i> Controle de Caixa</p>';
                        echo '<p class="card-text"><i class="icon-circle-check"></i> Ordem de serviço</p>';
                        echo '<p class="card-text"><i class="icon-circle-check"></i> Folha de Ponto</p>';
                        echo '<h5 class="card-title">Desvantagens</h5>';
                        echo '<p class="card-text"><i class="icon-circle-cross"></i> PIX Dinâmico</p>';
                        echo '<p class="card-text"><i class="icon-circle-cross"></i> Site</p>';
                        echo '<p class="card-text"><i class="icon-circle-cross"></i> Loja</p>';
                        echo '</div>';

                        echo '<div class="card-footer text-muted">';
                        echo '<form method="post" action="../cad_geral/unidade_operacional.php">';
                        echo '<input class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" type="submit" value="Plano Básico" >';
                        echo '</form>';
                        echo '</div>';

                      echo '</div>';


                      echo '<div class="card text-center">';
  
                        echo '<div class="card-header">R$: 80,00 por Mês ou 750 por Ano</div>';

                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">Vantagens</h5>';
                        echo '<p class="card-text"><i class="icon-circle-check"></i> Controle de Caixa</p>';
                        echo '<p class="card-text"><i class="icon-circle-check"></i> Ordem de serviço</p>';
                        echo '<p class="card-text"><i class="icon-circle-check"></i> Folha de Ponto</p>';
                        echo '<p class="card-text"><i class="icon-circle-cross"></i> Site</p>';
                        echo '<p class="card-text"><i class="icon-circle-cross"></i> Loja</p>';
                        echo '<h5 class="card-title">Desvantagens</h5>';
                        echo '<p class="card-text"><i class="icon-circle-cross"></i> PIX Dinâmico</p>';
                        echo '</div>';

                        echo '<div class="card-footer text-muted">';
                        echo '<form method="post" action="../cad_geral/unidade_operacional.php">';
                        echo '<input class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" type="submit" value="Plano Intermediário" >';
                        echo '</form>';
                        echo '</div>';
                        
                      echo '</div>';

                      

                      

                     

                      

                      echo '</div>';


																					}
																					
																				?>
                                											</div>
                                                                        	<div>
	                                                                        	<div class="float-left">
    	                                                                        	<span class="">
        	                        						                    	    <label class="mb-0 pb-0">
            	            	        						                    		<input  type="checkbox"  /> 
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
													            $query = "SELECT * FROM rel_master WHERE cd_pessoa = '".$_SESSION['cd_pessoa']."' AND cd_empresa = '".$_SESSION['cd_empresa']."'";
													            $result = mysqli_query($conn, $query);
													            $row = mysqli_fetch_assoc($result);
													            // Exibe as informações do usuário no formulário
													            if($row) {
														        	echo '<script>document.getElementById("editcd_estilo").value = "'.$row['cd_estilo'].'"</script>';
														            echo '<script>document.getElementById("editcd_acesso").value = "'.$row['cd_acesso'].'"</script>';
																	//echo '<script>document.getElementById("editcd_funcao").value = "'.$row['cd_funcao'].'"</script>';
																}
																//}
																// Verifica se o formulário foi enviado
													            if(isset($_POST['atualizar_preferencias'])) {
													                // Atualiza as informações do usuário no banco de dados
													                $query = "UPDATE rel_user SET
														            cd_estilo = '".$_POST['editcd_estilo']."',
														            cd_acesso = '".$_POST['editcd_acesso']."'
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
															            //echo '<script>document.getElementById("editcd_acesso").value = "'.$row['cd_acesso'].'"</script>';
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










