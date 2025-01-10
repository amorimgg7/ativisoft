<?php
  session_start();
  if(!isset($_SESSION['cd_pessoa']))
  {
    echo '<script>location.href="'.$_SESSION['dominio'].'../samples/login.php";</script>';    
    exit; 
  }
  if($_SESSION['senha_pessoa'] == "")
  {
    echo '<script>location.href="'.$_SESSION['dominio'].'../../samples/lock-screen.php";</script>';  
    exit;
  }
  require_once '../../classes/conn.php';
  include("../../classes/functions.php");
  $u = new Usuario;    
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Casa</title>
    <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../vendors/feather/feather.css">
    <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
    <link rel="stylesheet" href="../../vendors/flag-icon-css/css/flag-icon.min.css"/>
    <link rel="stylesheet" href="../../vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../vendors/jquery-bar-rating/fontawesome-stars-o.css">
    <link rel="stylesheet" href="../../vendors/jquery-bar-rating/fontawesome-stars.css">
    <link rel="stylesheet" href="../../css/style.css">
  </head>

<body onmousemove="resetTimer()" onclick="resetTimer()" onkeypress="resetTimer()">
  <div class="container-scroller">
    <?php include ("../../partials/_navbar.php");?>
	<div>
		<?php include ("../../partials/_sidebar.php");?>
			<div>
                <div class="content-wrapper">
					<div class="row mt-3">
						<div class="col-xl-3 flex-column d-flex grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="kt-portlet__body kt-portlet__body--fit">
                                        <ul class="kt-nav kt-nav--bold kt-nav--md-space kt-nav--v3 kt-margin-t-20 kt-margin-b-20 nav nav-tabs" role="tablist">	    
                                            
											<?php
												if(isset($_POST['tabInfoCasa'])){
													$_SESSION['opcaoMenu'] = 1;
												}else if(isset($_POST['tabInfoMoradores'])){
													$_SESSION['opcaoMenu'] = 2;
												}else if(isset($_POST['tabInfoDispositivos'])){
													$_SESSION['opcaoMenu'] = 3;
												}else if(isset($_POST['tabInfoSenhaCasa'])){
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
														<input type="submit" id="tabInfoCasa" name="tabInfoCasa" class="btn btn-outline-secondary btn-lg btn-block" value="Dados da casa">
													</li>
													<li class="kt-nav__item">
														<input type="submit" id="tabInfoMoradores" name="tabInfoMoradores" class="btn btn-outline-secondary btn-lg btn-block" value="Moradores">
													</li>
													<li class="kt-nav__item">
														<input type="submit" id="tabInfoDispositivos" name="tabInfoDispositivos" class="btn btn-outline-secondary btn-lg btn-block" value="Dispositivos">    
													</li>
													<li class="kt-nav__item">
														<input type="submit" id="tabInfoSenhaCasa" name="tabInfoSenhaCasa" class="btn btn-outline-secondary btn-lg btn-block" value="Senha Geral">
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
													
													//if(isset($_POST['concpf_pessoal'])) {
                    								// Consulta o usuário pelo CPF
													if(isset($_POST['atualizar_senha'])){			//atualizar_senha						
														$query = "SELECT * FROM tb_pessoa WHERE cd_pessoa = '".$_SESSION['cd_pessoa']."'";
														$result = mysqli_query($conn, $query);
														$row = mysqli_fetch_assoc($result);
														// Exibe as informações do usuário no formulário
														if($row['senha_colab'] == $_POST['senha_atual']) {
															echo "<script>window.alert('Senha certa');</script>";
															if($_POST['senha_nova1'] == $_POST['senha_nova2']){
																echo "<script>window.alert('Confirmação de senha certa');</script>";
																$query = "UPDATE tb_pessoa SET
														        	senha_colab = '".$_POST['senha_nova2']."'
																	WHERE cd_pessoa = '".$_SESSION['cd_pessoa']."';
																";
																mysqli_query($conn, $query);
																//echo "<script>window.alert('Usuário atualizado com sucesso!');</script>";
																
																echo "<script>";// Limpa os cookies
												                // Remove as informações do formulário do histórico de navegação';
												                echo "history.replaceState({}, document.title, window.location.href.split('?')[0]);";
												                // Recarrega a página
		                                    					echo "window.location.reload();";
												                echo "</script>";
																
															}
															else
															{
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
															


													if(isset($_POST['gravaInfoCasa_Funcao'])) {
														// Atualiza as informações do usuário no banco de dados
														$query = "UPDATE tb_casa SET
														cd_anfitriao = 		'".$_POST['editanfitriao_casa']."',
														titulo_casa = 		'".$_POST['edittitulo_casa']."',
														obs_casa = 			'".$_POST['editobs_casa']."',
														iptu_casa = 		'".$_POST['editiptu_casa']."',
														cd_endereco = 		'".$_POST['editendereco_casa']."',
														status_casa = = 	'".$_POST['editstatus_casa']."'
														WHERE cd_pessoa = 	'".$_POST['editcd_casa']."'";
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
														email_pessoa = '".$_POST['editemail_pessoa']."',
														tel_pessoa = '".$_POST['edittel_pessoa']."',
														obs_tel_pessoa = '".$_POST['editobstel_pessoa']."'
														WHERE cd_pessoa = '".$_SESSION['cd_pessoa']."'";
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
														$query = "UPDATE rel_user SET
														cd_estilo = '".$_POST['editcd_estilo']."',
														cd_seg = '".$_POST['editcd_seg']."',
														cd_funcao = '".$_POST['editcd_funcao']."'
														WHERE cd_pessoa = '".$_SESSION['cd_pessoa']."';";
														if(mysqli_query($conn, $query)){
															echo "<script>window.alert('Cadastro Atualizado com sucesso!');</script>";
															$u = new Usuario;
															$u->conectar();
															if($u->logar($_SESSION['email_pessoa'], $_SESSION['senha_pessoa']))  
                    										  {
																echo "<script>window.alert('Sucesso!');</script>";

                    										  }
                    										  else
                    										  {
                    										    
                    										    echo "<script>setTimeout(function() { window.history.back(); }, 3000);</script>";
                    										    
															
                    										  }
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
														$query = "SELECT * FROM tb_pessoa WHERE cd_pessoa = '".$_SESSION['cd_pessoa']."'";
														$result = mysqli_query($conn, $query);
														$row = mysqli_fetch_assoc($result);
														// Exibe as informações do usuário no formulário
														if($row['senha_pessoa'] == $_POST['senha_atual']) {
															echo "<script>window.alert('Senha certa');</script>";
															if($_POST['senha_nova1'] == $_POST['senha_nova2']){
																echo "<script>window.alert('Confirmação de senha certa');</script>";
																$query = "UPDATE tb_pessoa SET
														        	senha_pessoa = '".$_POST['senha_nova2']."'
																	WHERE cd_pessoa = '".$_SESSION['cd_pessoa']."';
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
															//echo '<script>document.getElementById("editcd_seg").value = "'.$row['cd_seg'].'"</script>';
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
														echo ' </div>';
														echo ' </div>';
														echo ' <div class="kt-form kt-form--label-right">';

														echo ' <form method="POST">';
														echo ' <div class="kt-portlet__body">';
														echo ' <div class="kt-section kt-section--first">';
														echo ' <div class="kt-section__body">';
														
														//SELECT CONCAT(p.pnome_pessoa, " ", p.snome_pessoa) AS nm_anfitriao, c.* FROM tb_casa c JOIN tb_pessoa p ON p.cd_pessoa = c.cd_anfitriao WHERE c.cd_casa = '1';

														$query = "SELECT CONCAT(p.pnome_pessoa, ' ', p.snome_pessoa) AS nm_anfitriao, CONCAT(cep_endereco, ' - ', logradouro_endereco,', ', bairro_endereco,', ', complemento_endereco,', ', municipio_endereco,', ', estado_endereco,', (', pais_endereco, ') ') as full_endereco, E.cep_endereco, c.*  FROM tb_endereco E, tb_casa c JOIN tb_pessoa p ON p.cd_pessoa = c.cd_anfitriao WHERE c.cd_casa = '".$_SESSION['cd_casa']."' AND C.cd_endereco = E.cd_endereco;";
														//$query = "SELECT CONCAT(P.pnome_pessoa, ' ', P.snome_pessoa) AS nm_anfitriao, E.*, C.* FROM tb_casa C, tb_endereco E JOIN tb_pessoa P ON P.cd_pessoa = C.cd_anfitriao WHERE C.CD_ENDERECO = E.CD_ENDERECO AND C.cd_casa = '".$_SESSION['cd_casa']."'";
														$result = mysqli_query($conn, $query);
														$row = mysqli_fetch_assoc($result);
														// Exibe as informações do usuário no formulário
														if($row) {
															echo ' <div class="form-group row" style="display: block;">';
															echo ' <label class="col-xl-3 col-lg-3 col-form-label">Alertas</label>';
															echo ' <div class="col-lg-9 col-xl-6">';
															echo ' <input type="tel" name="editcd_casa" id="editcd_casa" class="form-control" value="CD: '.$row['cd_casa'].'. Status da Casa: '.$row['status_casa'].'" readonly/>																				';
															echo ' </div>';
															echo ' </div>';



															echo ' <div class="form-group row">';
															echo ' <label class="col-xl-3 col-lg-3 col-form-label">Status da Casa: '.$row['cd_endereco'].'</label>';
															echo ' </div>';

															echo ' <div class="form-group row">';
															echo ' <label class="col-xl-3 col-lg-3 col-form-label">Anfitrião</label>';
															echo ' <div class="col-lg-9 col-xl-6">';
															echo ' <input type="text" name="editanfitriao_casa" id="editanfitriao_casa" value = "'.$row['nm_anfitriao'].'" class="form-control" readonly/>																				';
															echo ' </div>';
															echo ' </div>';

															echo ' <div class="form-group row">';
															echo ' <label class="col-xl-3 col-lg-3 col-form-label">Título</label>';
															echo ' <div class="col-lg-9 col-xl-6">';
															echo ' <input type="text" name="edittitulo_casa" id="edittitulo_casa" value = "'.$row['titulo_casa'].'" class="form-control" />																				';
															echo ' </div>';
															echo ' </div>';

															echo ' <div class="form-group row">';
															echo ' <label class="col-xl-3 col-lg-3 col-form-label">Obs</label>';
															echo ' <div class="col-lg-9 col-xl-6">';
															echo ' <input type="text" name="editobs_casa" id="editobs_casa" class="form-control" value = "'.$row['obs_casa'].'" />';
															echo ' </div>';
															echo ' </div>';

															echo ' <div class="form-group row">';
															echo ' <label class="col-xl-3 col-lg-3 col-form-label">IPTU</label>';
															echo ' <div class="col-lg-9 col-xl-6">';
															echo ' <input type="text" name="editiptu_casa" id="editiptu_casa" class="form-control" value = "'.$row['iptu_casa'].'"/>';
															echo ' </div>';
															echo ' </div>';

															echo ' <div class="form-group row">';
															echo ' <label class="col-xl-3 col-lg-3 col-form-label">Endereço</label>';
															echo ' <div class="col-lg-9 col-xl-6">';
															echo ' <input type="text" name="editendereco_casa" id="editendereco_casa" value = "'.$row['cd_endereco'].'" class="form-control" />';
															echo '<p style="color:#aaa;">'.$row['full_endereco'].'</p>';
															echo ' </div>';
															echo ' </div>';


															
													    	$query_endereco = "SELECT CONCAT(cep_endereco, ' - ', estado_endereco, ' - ', bairro_endereco, ' - ', logradouro_endereco) as full_endereco, cd_endereco FROM tb_endereco where cd_endereco = '".$row['cd_endereco']."'";
													    	$result_endereco = mysqli_query($conn, $query_endereco);
													    	$resulta_endereco = $conn->query($query_endereco);
												        	// Exibe as informações do usuário no formulário
											            	echo '<script>document.getElementById("editcd_endereco").value = "'.$row['cd_endereco'].'"</script>';
												        	//$sql_estilo = "SELECT * FROM tb_estilo";
															

															if ($result_endereco->num_rows > 0){
																echo ' <div class="form-group row">';
																echo ' <label class="col-xl-3 col-lg-3 col-form-label">Endereços cadastrados</label>';
																echo ' <div class="col-lg-9 col-xl-6">';
																echo ' <select name="editcd_estilo" id="editcd_estilo" class="form-control">';
																//echo ' <option value="">Selecione um Endereço</option>';
																while ( $result_endereco = $result_endereco->fetch_assoc()){
																	echo ' <option value="'.$result_endereco['cd_endereco'].'">'.$result_endereco['full_endereco'].'</option>';
																}
																echo ' </select>';
																echo ' </div>';
																echo ' </div>';
															}

															//echo '<script>document.getElementById("editcd_seg").value = "'.$row_rel_user['cd_seg'].'"</script>';
															
														


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

														$query = "SELECT * FROM tb_pessoa WHERE cd_pessoa = '".$_SESSION['cd_pessoa']."'";
													    $result = mysqli_query($conn, $query);
													    $row = mysqli_fetch_assoc($result);
													    // Exibe as informações do usuário no formulário

													    if($row) {
															echo ' <div class="form-group row">';
															echo ' <label class="col-xl-3 col-lg-3 col-form-label">E-mail</label>';
															echo ' <div class="col-lg-9 col-xl-6">';
															echo ' <input type="text" name="editemail_pessoa" id="editemail_pessoa" class="form-control" value = "'.$row['email_pessoa'].'" readonly />																				';
															echo ' </div>';
															echo ' </div>';

															echo ' <div class="form-group row">';
															echo ' <label class="col-xl-3 col-lg-3 col-form-label">Telefone</label>';
															echo ' <div class="col-lg-9 col-xl-6">';
															echo ' <input type="text" name="edittel_pessoa" id="edittel_pessoa" value = "'.$row['tel_pessoa'].'" class="form-control" />																				';
															echo ' </div>';
															echo ' </div>';

															echo ' <div class="form-group row">';
															echo ' <label class="col-xl-3 col-lg-3 col-form-label">Obs Telefone</label>';
															echo ' <div class="col-lg-9 col-xl-6">';
															echo ' <input type="text" name="editobstel_pessoa" id="editobstel_pessoa" value = "'.$row['obs_tel_pessoa'].'" class="form-control" />																				';
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
													    $query_rel_user = "SELECT * FROM rel_user WHERE cd_pessoa = '".$_SESSION['cd_pessoa']."' AND cd_casa = '".$_SESSION['cd_casa']."'";
													    $result_rel_user = mysqli_query($conn, $query_rel_user);
													    $row_rel_user = mysqli_fetch_assoc($result_rel_user);
												        // Exibe as informações do usuário no formulário
											            if($row_rel_user) {
												        	echo '<script>document.getElementById("editcd_estilo").value = "'.$row_rel_user['cd_estilo'].'"</script>';
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

															echo '<script>document.getElementById("editcd_seg").value = "'.$row_rel_user['cd_seg'].'"</script>';
															//$sql_estilo = "SELECT * FROM tb_seguranca";
															$sql_seg = "SELECT * FROM tb_seguranca ORDER BY CASE WHEN cd_seg = '".$row_rel_user['cd_seg']."' THEN 0 ELSE 1 END, cd_seg;";

															$resulta_seg = $conn->query($sql_seg);

															if ($resulta_seg->num_rows > 0){
																echo ' <label class="col-xl-3 col-lg-3 col-form-label">Perfil de Permissões</label>';
																echo ' <div class="col-lg-9 col-xl-6">';
																echo ' <select name="editcd_seg" id="editcd_seg" class="form-control">';
																//echo ' <option value="">Selecione Permissão</option>';
																while ( $row_seg = $resulta_seg->fetch_assoc()){
																	echo ' <option value="'.$row_seg['cd_seg'].'">'.$row_seg['titulo_seg'].'</option>';
																}
																echo ' </select>';
																echo ' </div>';
															}

															echo '<script>document.getElementById("editcd_funcao").value = "'.$row_rel_user['cd_funcao'].'"</script>';
															//$sql_funcao = "SELECT * FROM tb_funcao";
															$sql_funcao = "SELECT * FROM tb_funcao ORDER BY CASE WHEN cd_funcao = '".$row_rel_user['cd_funcao']."' THEN 0 ELSE 1 END, cd_funcao;";

															$resulta_funcao = $conn->query($sql_funcao);

															if ($resulta_funcao->num_rows > 0){
																echo ' <label class="col-xl-3 col-lg-3 col-form-label">Função</label>';
																echo ' <div class="col-lg-9 col-xl-6">';
																echo ' <select name="editcd_funcao" id="editcd_funcao" class="form-control">';
																//echo ' <option value="">Selecione Função</option>';
																while ( $row_funcao = $resulta_funcao->fetch_assoc()){
																	echo ' <option value="'.$row_funcao['cd_funcao'].'">'.$row_funcao['titulo_funcao'].'</option>';
																}
																echo ' </select>';
																echo ' </div>';
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
													            $query = "SELECT * FROM rel_user WHERE cd_pessoa = '".$_SESSION['cd_pessoa']."' AND cd_empresa = '".$_SESSION['cd_empresa']."'";
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
																	WHERE cd_pessoa = '".$_SESSION['cd_pessoa']."';";
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
		<?php
          include("../../partials/_footer.php");
        ?>
      </div>
    </div>
  </div>
  <script src="../../vendors/base/vendor.bundle.base.js"></script>
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
</body>

</html>










