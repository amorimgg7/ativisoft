<?php 
    session_start(); 
    if(!isset($_SESSION['cd_pessoa'])) 
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


														if($_FILES["fotoProduto"]["error"] == UPLOAD_ERR_OK){

															$caminho_pasta_produto = "../web/imagens/".$_SESSION['cnpj_filial']."/";
															if (!file_exists($caminho_pasta_produto)) {// Verificar se o diretório de destino existe, senão, criar
															  mkdir($caminho_pasta_produto, 0777, true);
															  echo "<script>window.alert('Criando diretório da Empresa! ".$caminho_pasta_produto."');</script>";
									  
															}
															$caminho_pasta_produto .= "produto/";
															if (!file_exists($caminho_pasta_produto)) {
															  mkdir($caminho_pasta_produto, 0777, true);
															  echo "<script>window.alert('Criando diretório dos produtos da empresa! ".$caminho_pasta_produto."');</script>";
									  
															}
															$foto_produto = "1-foto.jpg"; // Nome do arquivo que será salvo
																  
															$caminho_foto_produto = $caminho_pasta_produto . $foto_produto;
															
															$tipo_foto_produto = exif_imagetype($_FILES["fotoProduto"]["tmp_name"]);
										  
															$extensoes_permitidas = array(IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF);
									  
															if (in_array($tipo_foto_produto, $extensoes_permitidas)) {
																// Redimensionar a imagem para 100x100
																list($largura_orig, $altura_orig) = getimagesize($_FILES["fotoProduto"]["tmp_name"]);
																$nova_largura = 500;
																$nova_altura = 500;
																$imagem_redimensionada = imagecreatetruecolor(500, 500);
									  
																switch ($tipo_foto_produto) {
																	case IMAGETYPE_JPEG:
																		$imagem_orig = imagecreatefromjpeg($_FILES["fotoProduto"]["tmp_name"]);
																	break;
																	case IMAGETYPE_PNG:
																		$imagem_orig = imagecreatefrompng($_FILES["fotoProduto"]["tmp_name"]);
																	break;
																	case IMAGETYPE_GIF:
																		$imagem_orig = imagecreatefromgif($_FILES["fotoProduto"]["tmp_name"]);
																	break;
																}
									  
																imagecopyresampled($imagem_redimensionada, $imagem_orig, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura_orig, $altura_orig);
									  
																// Salvar a miniatura
																switch ($tipo_foto_produto) {
																	case IMAGETYPE_JPEG:
																	  //imagegif($imagem_redimensionada, $caminho_foto_produto);
																	  imagejpeg($imagem_redimensionada, $caminho_foto_produto);
																	break;
																	case IMAGETYPE_PNG:
																	  //imagegif($imagem_redimensionada, $caminho_foto_produto);
																	  imagepng($imagem_redimensionada, $caminho_foto_produto);
																	break;
																	case IMAGETYPE_GIF:
																	  //imagegif($imagem_redimensionada, $caminho_foto_produto);
																	  imagegif($imagem_redimensionada, $caminho_foto_produto);
																	break;
																}
									  
																imagedestroy($imagem_orig);
																imagedestroy($imagem_redimensionada);
															} else {
															  echo "<script>window.alert('Imagem não gravada\\nApenas arquivos JPEG, PNG e GIF são permitidos.');</script>";
															}
									  
														  }else{
															echo "<script>window.alert('Produto sem foto!');</script>";
														  }


														// Atualiza as informações do usuário no banco de dados
														$query = "UPDATE tb_colab SET
														pnome_colab = '".$_POST['editpnome_colab']."',
														snome_colab = '".$_POST['editsnome_colab']."',
														obs_colab = '".$_POST['editobs_colab']."'
														WHERE cd_colab = '".$_POST['editcd_colab']."'";
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
														$query = "UPDATE tb_colab SET
														email_colab = '".$_POST['editemail_colab']."',
														tel_colab = '".$_POST['edittel_colab']."',
														obs_tel_colab = '".$_POST['editobstel_colab']."'
														WHERE cd_colab = '".$_SESSION['cd_colab']."'";
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
														WHERE cd_colab = '".$_SESSION['cd_colab']."';";
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

													if(isset($_POST['gravaInfoSenha_Funcao'])){			//atualizar_senha						
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
														echo ' </div>															';
														echo ' </div>';
														echo ' <div class="kt-form kt-form--label-right">';

														echo ' <form method="POST">';
														echo ' <div class="kt-portlet__body">';
														echo ' <div class="kt-section kt-section--first">';
														echo ' <div class="kt-section__body">';


														$query = "SELECT * FROM tb_colab WHERE cd_colab = '".$_SESSION['cd_colab']."'";
														$result = mysqli_query($conn, $query);
														$row = mysqli_fetch_assoc($result);
														// Exibe as informações do usuário no formulário
														if($row) {
															echo ' <div class="form-group row" style="display: block;">';
															echo ' <label class="col-xl-3 col-lg-3 col-form-label">CD</label>';
															echo ' <div class="col-lg-9 col-xl-6">';
															echo ' <input type="tel" name="editcd_colab" id="editcd_colab" class="form-control" value="'.$row['cd_colab'].'" readonly/>																				';
															echo ' </div>';
															echo ' </div>';

															echo '<label for="imagem-preview-produto"></label>';
                echo "<div class='card' style='max-width: 100%; max-height: 50vh;'>";
                $caminho_pasta_produto = "../web/imagens/".$_SESSION['cnpj_filial']."//produto/";
                $foto_produto = "1-foto.jpg"; // Nome do arquivo que será salvo
                $caminho_foto_produto = $caminho_pasta_produto . $foto_produto;

                if (file_exists($caminho_foto_produto)) {
                  $tipo_foto_produto = mime_content_type($caminho_foto_produto);
                  echo "<img class='card-img-top img-thumbnail mx-auto' id='imagem-preview-produto' style='width: 200px; height: 200px;' src='data:$tipo_foto_produto;base64," . base64_encode(file_get_contents($caminho_foto_produto)) . "' alt='Imagem'>"; 
                }

                echo '<div class="card-body text-center">';
                echo '<label for="fotoProduto" class="btn btn-block btn-lg btn-outline-success">';
                echo '<i class="bi bi-paperclip"></i> Escolher arquivo';
                echo '<input type="file" name="fotoProduto" id="fotoProduto" style="display: none;">';
                echo '</label>';
                echo '</div>';
                echo '</div>';


                ?>
                <script>
                    const imagemInputCliente = document.getElementById('fotoProduto');
                    const imagemPreviewCliente = document.getElementById('imagem-preview-produto');

                    imagemInputCliente.addEventListener('change', function(event) {
                        const arquivo = event.target.files[0];
                        if (arquivo) {
                            const leitor = new FileReader();
                            leitor.onload = function(e) {
                                imagemPreviewCliente.src = e.target.result;
                            }
                            leitor.readAsDataURL(arquivo);
                        } else {
                            imagemPreviewCliente.src = '#';
                        }
                    });
                </script>
        
                <?php

															echo ' <div class="form-group row">';
															echo ' <label class="col-xl-3 col-lg-3 col-form-label">Nome</label>';
															echo ' <div class="col-lg-9 col-xl-6">';
															echo ' <input type="text" name="editpnome_colab" id="editpnome_colab" value = "'.$row['pnome_colab'].'" class="form-control" />																				';
															echo ' </div>';
															echo ' </div>';

															echo ' <div class="form-group row">';
															echo ' <label class="col-xl-3 col-lg-3 col-form-label">Sobrenome</label>';
															echo ' <div class="col-lg-9 col-xl-6">';
															echo ' <input type="text" name="editsnome_colab" id="editsnome_colab" value = "'.$row['snome_colab'].'" class="form-control" />																				';
															echo ' </div>';
															echo ' </div>';

															echo ' <div class="form-group row">';
															echo ' <label class="col-xl-3 col-lg-3 col-form-label">CPF</label>';
															echo ' <div class="col-lg-9 col-xl-6">';
															echo ' <input type="text" name="editcpf_colab" id="editcpf_colab" class="form-control" value = "'.$row['cpf_colab'].'" readonly/>																				';
															echo ' </div>';
															echo ' </div>';

															echo ' <div class="form-group row">';
															echo ' <label class="col-xl-3 col-lg-3 col-form-label">Data de Nascimento</label>';
															echo ' <div class="col-lg-9 col-xl-6">';
															echo ' <input type="date" name="editdtnasc_colab" id="editdtnasc_colab" class="form-control" value = "'.$row['dtnasc_colab'].'" readonly/>																				';
															echo ' </div>';
															echo ' </div>';

															echo ' <div class="form-group row">';
															echo ' <label class="col-xl-3 col-lg-3 col-form-label">Observações</label>';
															echo ' <div class="col-lg-9 col-xl-6">';
															echo ' <input type="text" name="editobs_colab" id="editobs_colab" value = "'.$row['obs_colab'].'" class="form-control" />																				';
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

														$query = "SELECT * FROM tb_colab WHERE cd_colab = '".$_SESSION['cd_colab']."'";
													    $result = mysqli_query($conn, $query);
													    $row = mysqli_fetch_assoc($result);
													    // Exibe as informações do usuário no formulário

													    if($row) {
															echo ' <div class="form-group row">';
															echo ' <label class="col-xl-3 col-lg-3 col-form-label">E-mail</label>';
															echo ' <div class="col-lg-9 col-xl-6">';
															echo ' <input type="text" name="editemail_colab" id="editemail_colab" class="form-control" value = "'.$row['email_colab'].'" readonly />																				';
															echo ' </div>';
															echo ' </div>';

															echo ' <div class="form-group row">';
															echo ' <label class="col-xl-3 col-lg-3 col-form-label">Telefone</label>';
															echo ' <div class="col-lg-9 col-xl-6">';
															echo ' <input type="text" name="edittel_colab" id="edittel_colab" value = "'.$row['tel_colab'].'" class="form-control" />																				';
															echo ' </div>';
															echo ' </div>';

															echo ' <div class="form-group row">';
															echo ' <label class="col-xl-3 col-lg-3 col-form-label">Obs Telefone</label>';
															echo ' <div class="col-lg-9 col-xl-6">';
															echo ' <input type="text" name="editobstel_colab" id="editobstel_colab" value = "'.$row['obs_tel_colab'].'" class="form-control" />																				';
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
													    $query_rel_user = "SELECT * FROM rel_user WHERE cd_colab = '".$_SESSION['cd_colab']."' AND cd_empresa = '".$_SESSION['cd_empresa']."'";
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










