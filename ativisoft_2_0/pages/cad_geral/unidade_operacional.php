<?php 
    session_start(); 
    if(!isset($_SESSION['cd_colab'])) 
    {
        header("location: ../../pages/samples/login.php");
        exit;
    }
    require_once '../../classes/conn.php';
    include("../../classes/functions.php");
	include("../../classes/tools.php");
															

    $u = new Usuario;
	$t = new Tools;
?><!--Validar sessão aberta, se usuário está logado.-->

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Loja</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="stylesheet" href="../../css/custom.css">
  <!-- endinject -->
  <!--<link rel="shortcut icon" href="<?php //echo $_SESSION['dominio'].'pages/web/imagens/'.$_SESSION['cnpj_empresa'].'/Logos/LogoEmpresa.jpg'; ?>" />--><!--$_SESSION['dominio'].'pages/samples/lock-screen.php';-->
	
  <link rel='shortcut icon' href='https://lh3.googleusercontent.com/pw/AP1GczOReqQClzL-PZkykfOwgmMyVzQgx27DTp783MI7iwKuKSv-6P6V7KOEbCC74sGdK3DEV3O88CsBLeIvOaQwGT3x4bqCTPRtyV9zcODbYVDRxAF8zf8Uev7geh4ONPdl3arNhnSDPvbQfMdpFRPM263V9A=w250-h250-s-no-gm?authuser=0' />
		


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
                <div class="content-wrapper" <?php echo $_SESSION['c_body'];?>>
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card" <?php echo $_SESSION['c_card'];?>>
                                <div class="card-body">
                                    <div class="kt-portlet__body kt-portlet__body--fit">
                                        <ul class="kt-nav kt-nav--bold kt-nav--md-space kt-nav--v3 kt-margin-t-20 kt-margin-b-20 nav nav-tabs" role="tablist">	    
                                            
											<?php
												if(isset($_POST['tabInfoGeral'])){
													$_SESSION['opcaoMenu'] = 1;
												}else if(isset($_POST['tabInfoDadosFinanceiros'])){
													$_SESSION['opcaoMenu'] = 2;
												}else if(isset($_POST['tabInfoMensagens'])){
													$_SESSION['opcaoMenu'] = 3;
												}else if(isset($_POST['tabInfoImpressao'])){
													$_SESSION['opcaoMenu'] = 4;
												}else if(isset($_POST['tabInfoSite'])){
													$_SESSION['opcaoMenu'] = 5;
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
														<input type="submit" id="tabInfoGeral" name="tabInfoGeral" class="btn btn-outline-secondary btn-lg btn-block" value="Geral">
													</li>
													<li class="kt-nav__item">
														<input type="submit" id="tabInfoDadosFinanceiros" name="tabInfoDadosFinanceiros" class="btn btn-outline-secondary btn-lg btn-block" value="Financeiro">
													</li>
													<li class="kt-nav__item">
														<input type="submit" id="tabInfoMensagens" name="tabInfoMensagens" class="btn btn-outline-secondary btn-lg btn-block" value="Mensagens">
													</li>
													<li class="kt-nav__item">
														<input type="submit" id="tabInfoImpressao" name="tabInfoImpressao" class="btn btn-outline-secondary btn-lg btn-block" value="Impressões">    
													</li>
													<li class="kt-nav__item">
														<input type="submit" id="tabInfoSite" name="tabInfoSite" class="btn btn-outline-secondary btn-lg btn-block" value="Site">
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
                            <div class="card" <?php echo $_SESSION['c_card'];?>>
                                <div class="card-body">
                                    <div class="kt-portlet__body kt-portlet__body--fit">
                                        <div class="col-lg-8 col-xl-9">
                                    	    <div class="tab-content">
												<?php
													if(!isset($_SESSION['opcaoMenu'])){
														$_SESSION['opcaoMenu'] = 1;
													}

													if(isset($_POST['cad_unidade'])){
														$_SESSION['opcaoMenu'] = 1;
														$select_empresa = "SELECT * FROM tb_empresa WHERE cnpj_empresa = '".$_POST['cnpj_filial']."'";
														$result_empresa = mysqli_query($conn, $select_empresa);
														$count = 0;
														if($row_empresa = $result_empresa->fetch_assoc()) {
															echo "<script>window.alert('CNPJ ja foi cadastrado');</script>";
														}else{

															$retornaCadastro = $u->cadUnidadeOperacional(
																$_POST['cnpj_filial'],
																'matriz',
																$_SESSION['cd_colab'],
																$_POST['rsocial_filial'],
																$_POST['nfantasia_filial'],
																$_POST['telefone_filial'],
																$_POST['email_filial']
															);
															if($retornaCadastro['status'] == 'OK'){
																echo "<script>window.alert('".$retornaCadastro['status']."');</script>";
																$_SESSION['cd_empresa'] = $retornaCadastro['cd_empresa'];
																echo '<script>location.href="unidade_operacional.php";</script>';
															}else{
																echo "<script>window.alert('".$retornaCadastro['status']."');</script>";
															}															
															//echo "<script>window.alert('".$cd_empresa.": Empresa Cadastrada!');</script>";
														}
													}

													if(isset($_POST['gravaInfo_Geral'])) {
														$_SESSION['opcaoMenu'] = 1;

														$retornaEdicao = $u->editUnidadeOperacional(
																$_POST['cd_empresa'],
																$_POST['rsocial_empresa'],
																$_POST['nfantasia_empresa'],
																$_POST['cd_pais'].$_POST['tel1_empresa'],
																$_POST['email_empresa'],
																$_POST['endereco_empresa'],
																$_POST['saudacoes_empresa']
														);
														if($retornaEdicao['status'] == 'OK'){
															echo "<script>window.alert('".$retornaEdicao['status']."');</script>";
															$_SESSION['cd_empresa'] = $retornaEdicao['cd_empresa'];

															$_SESSION['nfantasia_empresa']		=	$retornaEdicao['cd_empresa'];
															$_SESSION['rsocial_empresa']		=	$retornaEdicao['rsocial_empresa'];
															$_SESSION['cnpj_empresa']			=	$retornaEdicao['cnpj_empresa'];
															$_SESSION['cnpj_filial']			=	$retornaEdicao['cnpj_empresa'];
															$_SESSION['email_empresa']			=	$retornaEdicao['nfantasia_empresa'];
															$_SESSION['endereco_empresa']		=	$retornaEdicao['tel1_empresa'];
															$_SESSION['saudacoes_empresa']		=	$retornaEdicao['email_empresa'];
															$_SESSION['endereco_empresa']		=	$retornaEdicao['endereco_empresa'];

															echo '<script>location.href="unidade_operacional.php";</script>';
														}else{
															echo "<script>window.alert('".json_encode($retornaEdicao['status'])."');</script>";
														}
													}

													if(isset($_POST['gravaInfo_Entidade_Financeira'])) {
														if(isset($_POST['certificadoProducao'])){
															if($_FILES["certificadoProducao"]["error"] == UPLOAD_ERR_OK){
																$caminho_pasta_empresa = "../charts/".$_SESSION['cnpj_empresa']."/";
																if (!file_exists($caminho_pasta_empresa)) {
																	mkdir($caminho_pasta_empresa, 0777, true);
																}
																$caminho_pasta_certificado = $caminho_pasta_empresa . "efi/";
																if (!file_exists($caminho_pasta_certificado)) {
																	mkdir($caminho_pasta_certificado, 0777, true);
																}
																$nome_certificado = "certificadoProducao.pfx"; 
																$caminho_certificado = $caminho_pasta_certificado . $nome_certificado;
														
																if (move_uploaded_file($_FILES["certificadoProducao"]["tmp_name"], $caminho_certificado)) {
																	echo "<script>window.alert('Certificado enviado com sucesso!');</script>";
																} else {
																	echo "<script>window.alert('Erro ao enviar o certificado!');</script>";
																}
															} else {
																//echo "<script>window.alert('Erro no upload do arquivo!');</script>";
															}
														}

														$query = "SELECT * FROM TB_ENTIDADE_FINANCEIRA WHERE CNPJ_ENTIDADE_FINANCEIRA = '".$_POST['cnpj_entidade_financeira']."'";
														$result = mysqli_query($conn, $query);
														$row = mysqli_fetch_assoc($result);

														// Exibe as informações do usuário no formulário
														if($_POST['cd_entidade_financeira'] > 0) {
															//$_SESSION['EDIT_CD_ENTIDADE_FINANCEIRA'] = $_SESSION['cd_entidade_financeira'];
															$query = "UPDATE TB_ENTIDADE_FINANCEIRA SET
																titulo_entidade_financeira = '".$_POST['titulo_entidade_financeira']."',
																obs_entidade_financeira = '".$_POST['obs_entidade_financeira']."',
																chave_client_id_entidade_financeira = '".$_POST['chave_client_id_entidade_financeira']."',
																chave_client_secret_entidade_financeira = '".$_POST['chave_client_secret_entidade_financeira']."',
																integra_pix_entidade_financeira = '".$_POST['integra_pix_entidade_financeira']."',
																Integra_boleto_entidade_financeira = '".$_POST['Integra_boleto_entidade_financeira']."'
																WHERE CD_ENTIDADE_FINANCEIRA = '".$_SESSION['EDIT_CD_ENTIDADE_FINANCEIRA']."'"
															;
															if(mysqli_query($conn, $query)){
																echo "<script>window.alert('Cadastro Atualizado com sucesso!');</script>";
															}else{
																echo "<script>window.alert('Erro ao atualizar Cadastro!');</script>";
															}

															if($_POST['entidade_financeira_principal'] == 'S' && $_POST['cd_entidade_financeira'] != $_SESSION['cd_entidade_financeira']){
																$query = "UPDATE tb_filial SET
																	cd_entidade_financeira = '".$_POST['cd_entidade_financeira']."'
																	WHERE cd_filial = '".$_SESSION['cd_filial']."'"
																;
																if(mysqli_query($conn, $query)){
																	$_SESSION['cd_entidade_financeira'] = $_POST['cd_entidade_financeira'];
																	echo "<script>window.alert('Entidade principal foi alterada!');</script>";
																}else{
																	echo "<script>window.alert('Erro ao atualizar Entidade principal!');</script>";
																}
															}
															
														}else{
															$cadentidade = "INSERT INTO TB_ENTIDADE_FINANCEIRA(TITULO_ENTIDADE_FINANCEIRA, OBS_ENTIDADE_FINANCEIRA, RSOCIAL_ENTIDADE_FINANCEIRA, CNPJ_ENTIDADE_FINANCEIRA, CHAVE_CLIENT_ID_ENTIDADE_FINANCEIRA, CHAVE_CLIENT_SECRET_ENTIDADE_FINANCEIRA, INTEGRA_PIX_ENTIDADE_FINANCEIRA, INTEGRA_BOLETO_ENTIDADE_FINANCEIRA) VALUES(
																'".$_POST['titulo_entidade_financeira']."',
																'".$_POST['obs_entidade_financeira']."',
																'".$_POST['rsocial_entidade_financeira']."',
																'".$_POST['cnpj_entidade_financeira']."',
																'".$_POST['chave_client_id_entidade_financeira']."',
																'".$_POST['chave_client_secret_entidade_financeira']."',
																'".$_POST['integra_pix_entidade_financeira']."',
																'".$_POST['Integra_boleto_entidade_financeira']."'
																)";
																if(mysqli_query($conn, $cadentidade)){
																	echo "<script>window.alert('Entidade configurada!');</script>";
																}else{
																	echo "<script>window.alert('Erro ao tentar cadastrar a Entidade Financeira!');</script>";

																}
														}

														
														
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
														
													}

													if(isset($_POST['gravaInfoMensagem_Funcao'])) {
														// Atualiza as informações do usuário no banco de dados
														$query = "UPDATE tb_empresa SET
														tipo_mensagem = '".$_POST['edittipo_mensagem']."'
														WHERE cd_empresa = '".$_POST['cd_empresa']."'";
														if(mysqli_query($conn, $query)){
															echo "<script>window.alert('Cadastro Atualizado com sucesso!');</script>";
															$_SESSION['tipo_mensagem'] = $_POST['edittipo_mensagem'];
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
													
													if(isset($_POST['gravaInfoImpressao_Funcao'])) {
														// Atualiza as informações do usuário no banco de dados
														$query = "UPDATE tb_empresa SET
														tipo_impressao = '".$_POST['edittipo_impressao']."'
														WHERE cd_empresa = '".$_POST['cd_empresa']."'";
														if(mysqli_query($conn, $query)){
															echo "<script>window.alert('Cadastro Atualizado com sucesso!');</script>";
															$_SESSION['tipo_impressao'] = $_POST['edittipo_impressao'];
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
														echo ' <div class="tab-pane fade show active" id="infoGeral">';
														echo ' <div class="kt-portlet">';
														echo ' <div class="kt-portlet__head">';
														echo ' <div class="kt-portlet__head-label">';
														echo ' <h3 class="kt-portlet__head-title">Geral</h3>';
														echo ' </div>															';
														echo ' </div>';
														echo ' <div class="kt-form kt-form--label-right">';
														echo ' <form method="POST" enctype="multipart/form-data">';
														echo ' <div class="kt-portlet__body">';
														echo ' <div class="kt-section kt-section--first">';
														echo ' <div class="kt-section__body">';

														$select_unidade = "SELECT * FROM tb_empresa WHERE cd_empresa = '".$_SESSION['cd_empresa']."'";
														$result_unidade = mysqli_query($conn, $select_unidade);
														$count = 0;
														
														while($row_unidade = $result_unidade->fetch_assoc()) {
															$count ++;
														}
														if($count == 0){

															echo '<h1>cadastre já</h1>';

															
															echo '<div class="card-body" id="consulta" >';
											                echo '<h4 class="card-title">Informe o CNPJ</h4>';
											                echo '<div class="kt-portlet__body">';
											                echo '<div class="row">';
											                echo '<div class="col-12 col-md-12">';
											                echo '<div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">';
											                echo '<form method="POST"> ';
											                echo '<div class="form-group" style="display: flex;">';
															$resultadoCNPJ = $t->validarCNPJ('');
															echo '<input value="'. $resultadoCNPJ['cnpj_formatado'] .'" oninput="cnpj(this)" name="cnpj_filial" type="tel"  id="cnpj_filial" class="aspNetDisabled form-control form-control-sm"/>';
															echo '<script>document.getElementById("cnpj_filial").style.border = "'.($resultadoCNPJ['valido'] ? '' : '2px solid red').'";</script>';
															echo '</div>';
											                echo '<br>';
											                echo '<button type="submit" name="cad_unidade" id="cad_unidade" class="btn btn-block btn-success">Consulta</button>';
											                echo '</form>';
											                echo '</div>';
											                echo '</div>';
											                echo '</div>';
											                echo '</div>';
											                echo '</div>';
														}
														if($count == 1){
															$_SESSION['cd_empresa_selecionada'] = $_SESSION['cd_empresa'];

															$sql_selecionada = "SELECT * FROM tb_empresa WHERE cd_empresa = '".$_SESSION['cd_empresa']."'";
															$result_selecionada = mysqli_query($conn, $sql_selecionada);
															$row_selecionada = mysqli_fetch_assoc($result_selecionada);

															//echo '<h1>... ... ... ... ...</h1>';
															//echo '<h1>Unidade: '.$row_selecionada['cd_empresa'].'</h1>';
															//echo '<h1>... ... ... ... ...</h1>';


															echo '<div class="form-group-custom">';
															echo '<label for="cd_empresa">Código</label>';
															echo '<input type="tel" value="'.$row_selecionada['cd_empresa'].'" class="form-control form-control-lg" name="cd_empresa" id="cd_empresa" placeholder="Filial" readonly require>';
															echo '</div>';

															echo '<div class="form-group-custom">';
															
															echo '<input type="tel" value="'.$row_selecionada['cd_matriz'].'" class="form-control form-control-lg" name="cd_matriz" id="cd_matriz" placeholder="Matriz" style="display:none;" readonly require>';
															echo '</div>';


															echo '<div class="form-group-custom">';
															echo '<label for="rsocial_empresa">Razão Social</label>';
															echo '<input type="text" value="'.$row_selecionada['rsocial_empresa'].'" class="form-control form-control-lg" name="rsocial_empresa" id="rsocial_empresa" placeholder="Razão Social" require>';
															echo '</div>';

															echo '<div class="form-group-custom">';
															echo '<label for="nfantasia_empresa">Nome Fantasia</label>';
															echo '<input type="text" value="'.$row_selecionada['nfantasia_empresa'].'" class="form-control form-control-lg" name="nfantasia_empresa" id="nfantasia_empresa" placeholder="Nome Fantasia" require>';
															echo '</div>';

															echo '<div class="form-group-custom">';
															echo '<label for="cnpj_empresa">CNPJ</label>';
															echo '<input type="tel" value="'.$row_selecionada['cnpj_empresa'].'" class="form-control form-control-lg" oninput="cpfcnpj(this)" name="cnpj_empresa" id="cnpj_empresa" readonly required>';
															echo '</div>';

 


															$resultado = $t->telefone($row_selecionada['tel1_empresa']);
															if($resultado['codigo_pais'] == ''){
																$codigo_pais = 55;
																$nome_pais = "+55 Brasil";
															}else{
																$codigo_pais = $resultado['codigo_pais'];
																$nome_pais = $resultado['nome_pais'];
															}
                                							echo '<div class="input-group form-group-custom">';
                                							echo '    <div class="input-group-prepend">';
                                							echo '      <select name="cd_pais" id="cd_pais"  class="input-group-text" required>';
                                							echo '      <option selected="selected" value="'.$codigo_pais.'">'.$nome_pais.'</option>';
                                							echo $resultado['lista_paises'];
                                							echo '      </select>  ';
                                							echo '    </div>';
                                							echo '    <input placeholder="Telefone" type="tel" value="'.$resultado['ddd'].$resultado['numero'].'" name="tel1_empresa" id="tel1_empresa" type="tel" class="form-control form-control-sm" required oninput="tel(this)">';
                                							//echo '    <div class="input-group-append">';
                                							//echo '    </div>';
                                							echo '    </div>';

															//echo '<div class="form-group">';
															//echo '<input type="tel" value="'.$row_selecionada['tel1_empresa'].'" class="form-control form-control-lg" name="tel1_empresa" id="tel1_empresa" placeholder="Telefone" require>';
															//echo '</div>';

															echo '<div class="form-group-custom">';
															echo '<label for="email_empresa">E-Mail</label>';
															echo '<input type="email" value="'.$row_selecionada['email_empresa'].'" class="form-control form-control-lg" name="email_empresa" id="email_empresa" placeholder="Email" require>';
															echo '</div>';

															echo '<div class="form-group-custom">';
															echo '<label for="endereco_empresa">Endereço da Empresa</label>';
															echo '<input type="text" value="'.$row_selecionada['endereco_empresa'].'" class="form-control form-control-lg" name="endereco_empresa" id="endereco_empresa" placeholder="Endereço" require>';
															echo '</div>';

															echo '<div class="form-group-custom">';
															echo '<label for="saudacoes_empresa">Lema da empresa / Saudações ao cliente</label>';
															echo '<input type="text" value="'.$row_selecionada['saudacoes_empresa'].'" class="form-control form-control-lg" name="saudacoes_empresa" id="saudacoes_empresa" placeholder="Lema da empresa / Saudações ao cliente" require>';
															echo '</div>';

															echo '<div class="mt-3">';
															echo '<input type="submit" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" name="gravaInfo_Geral" id="gravaInfo_Geral" value="Gravar">';
															echo '</div>';


														}
														if($count > 1){
															echo '<h1>... ... ... ... ...</h1>';
															echo '<h1>Escolha a unidade operacional</h1>';
															echo '<h1>... ... ... ... ...</h1>';
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
														//echo ' <input type="submit" value="Confirmar" class="btn btn-success" id="gravaInfo_Geral" name="gravaInfo_Geral">';
														echo ' &nbsp;';
														//echo ' <a id="ContentPlaceHolder1_iBtCancelar" class="btn btn-secondary" href="javascript:__doPostBack(&#39;ctl00$ContentPlaceHolder1$iBtCancelar&#39;,&#39;&#39;)"> Cancelar </a>';
														echo ' </div>';
														echo ' </div>';
														echo ' </div>';
														echo ' </div>';
														echo ' </form>';
													}else if($_SESSION['opcaoMenu'] == 2){
														echo ' <!--begin: Personal Information-->';
														echo ' <div class="tab-pane fade show active" id="infoDadosFinanceiros">';
														echo ' <div class="kt-portlet">';
														echo ' <div class="kt-portlet__head">';
														echo ' <div class="kt-portlet__head-label">';
														echo ' <h3 class="kt-portlet__head-title">Entidade Financeira</h3>';
														echo ' </div>';
														echo ' </div>';
														echo ' <div class="kt-form kt-form--label-right">';
														echo ' <div class="kt-portlet__body">';
														echo ' <div class="kt-section kt-section--first">';
														echo ' <div class="kt-section__body">'; 
														
														echo ' <h3 class="kt-portlet__head-title">Em Breve</h3>';
														echo '<form method="post">';
														echo ' <div class="form-group row">';
														echo ' <div class="col-lg-9 col-xl-6">';

														$sql_entidade_financeira = "SELECT * FROM tb_entidade_financeira ORDER BY CASE WHEN cd_filial = '".$_SESSION['cd_empresa']."' THEN 0 ELSE 1 END, cd_entidade_financeira;";
														$resulta_entidade_financeira = $conn->query($sql_entidade_financeira);
														if ($resulta_entidade_financeira->num_rows > 0){
															echo ' <label class="col-xl-3 col-lg-3 col-form-label">Entidade Principal</label>';
															echo ' <select name="entidade_financeira" id="entidade_financeira" class="form-control">';
															while ( $row_entidade_financeira = $resulta_entidade_financeira->fetch_assoc()){
																echo ' <option value="'.$row_entidade_financeira['cd_entidade_financeira'].'">'.$row_entidade_financeira['rsocial_entidade_financeira'].'</option>';
															}
															echo ' </select>';
														}


														echo ' <input type="submit" value="Seguir" class="btn btn-success" id="" name="">';
														echo ' </div>';
														echo ' </div>';
														echo '</form>';

														echo ' <form method="POST" enctype="multipart/form-data">';

														if(isset($_POST['entidade_financeira']) || isset($_SESSION['EDIT_CD_ENTIDADE_FINANCEIRA'])){

															if(isset($_POST['entidade_financeira'])){
																$_SESSION['EDIT_CD_ENTIDADE_FINANCEIRA'] = $_POST['entidade_financeira'];
															}
															


															$query = "SELECT * FROM TB_ENTIDADE_FINANCEIRA WHERE CD_ENTIDADE_FINANCEIRA = '".$_SESSION['EDIT_CD_ENTIDADE_FINANCEIRA']."'";
															$result = mysqli_query($conn, $query);
															$row = mysqli_fetch_assoc($result);

															// Exibe as informações do usuário no formulário
															if($row) {
																$_SESSION['EDIT_CD_ENTIDADE_FINANCEIRA'] = $row['cd_entidade_financeira'];
																//echo '<label for="certificadoProducao"></label>';
																echo "<div class='card' ".$_SESSION['c_card']." style='max-width: 100%; max-height: 50vh;'>";
																$caminho_certificado_producao_banco = "../charts/".$_SESSION['cnpj_empresa']."//efi/";
																$certificado_producao_banco = "certificadoProducao.pfx"; // Nome do arquivo que será salvo
																$caminho_certificado_producao_banco = $caminho_certificado_producao_banco . $certificado_producao_banco;

																echo '<div class="card-body text-center">';
																echo '<h1>Certificado do Banco</h1>';
																if (file_exists($caminho_certificado_producao_banco) && pathinfo($caminho_certificado_producao_banco, PATHINFO_EXTENSION) === 'pfx') {
																	$tipo_foto_empresa = mime_content_type($caminho_certificado_producao_banco);
																	//echo "<h4>".$caminho_certificado_producao_banco."</h4>";

																	echo '<h7>Produção</h7>';
																	echo '<label for="certificadoProducao" class="btn btn-block btn-lg btn-secondary">';
																	echo '<i class="bi bi-paperclip"></i> Arquivo Armazenado com Sucesso';
																	//echo '<input type="text" name="certificadoProducao" id="certificadoProducao" style="display: block;" value="'.$caminho_certificado_producao_banco.'" readonly>'; // Mude o estilo para "none"
																	echo '</label>';

																} else {
																	echo "<h1>Sem Certificado</h1>";
																	echo '<h7>Produção</h7>';
																	echo '<label for="certificadoProducao" class="btn btn-block btn-lg btn-outline-success">';
																	echo '<i class="bi bi-paperclip"></i> Escolher arquivo';
																	echo '<input type="file" name="certificadoProducao" id="certificadoProducao" style="display: block;">'; // Mude o estilo para "none"
																	echo '</label>';
																}
																
																echo '</div>';
																echo '</div>';

																
																

																echo ' <div class="form-group row">';
																//echo ' <label class="col-xl-3 col-lg-3 col-form-label">CD</label>';
																echo ' <div class="col-lg-9 col-xl-6">';
																echo ' <input value="'.$row['cd_entidade_financeira'].'" style="display:none;" type="text" name="cd_entidade_financeira" id="cd_entidade_financeira" class="form-control" placeholder="Código da Entidade Financeira" readonly/>';
																echo ' </div>';
																echo ' </div>';


																echo ' <div class="form-group row">';
																echo ' <label class="col-xl-3 col-lg-3 col-form-label">Principal</label>';
																echo ' <div class="col-lg-9 col-xl-6">';
																//echo ' <label class="col-xl-3 col-lg-3 col-form-label"></label>';
																echo ' <select name="entidade_financeira_principal" id="entidade_financeira_principal" class="form-control">';
															
																echo ' <option value="S" ' . ($row['cd_entidade_financeira'] != $_SESSION['cd_entidade_financeira'] ? ' selected' : '') . '>Sim</option>';
																echo ' <option value="N" ' . ($row['cd_entidade_financeira'] != $_SESSION['cd_entidade_financeira'] ? ' selected' : '') . '>Não</option>';
																
																echo ' </select>';

																echo ' </div>';
																echo ' </div>';
																echo ' <div class="form-group row">';
																echo ' <label class="col-xl-3 col-lg-3 col-form-label">Título</label>';
																echo ' <div class="col-lg-9 col-xl-6">';
																echo ' <input value="'.$row['titulo_entidade_financeira'].'" type="text" name="titulo_entidade_financeira" id="titulo_entidade_financeira" class="form-control" placeholder="Título"/>';
																echo ' </div>';
																echo ' </div>';

																echo ' <div class="form-group row">';
																echo ' <label class="col-xl-3 col-lg-3 col-form-label">Obs</label>';
																echo ' <div class="col-lg-9 col-xl-6">';
																echo ' <input value="'.$row['obs_entidade_financeira'].'" type="text" name="obs_entidade_financeira" id="obs_entidade_financeira" class="form-control" placeholder="Observação"/>';
																echo ' </div>';
																echo ' </div>';

																echo ' <div class="form-group row">';
																echo ' <label class="col-xl-3 col-lg-3 col-form-label">Razão Social</label>';
																echo ' <div class="col-lg-9 col-xl-6">';
																echo ' <input value="'.$row['rsocial_entidade_financeira'].'" type="text" name="rsocial_entidade_financeira" id="rsocial_entidade_financeira" class="form-control" value = "Efí S.A." readonly/>';
																echo ' </div>';
																echo ' </div>';

																echo ' <div class="form-group row">';
																echo ' <label class="col-xl-3 col-lg-3 col-form-label">CNPJ</label>';
																echo ' <div class="col-lg-9 col-xl-6">';
																echo ' <input value="'.$row['cnpj_entidade_financeira'].'" type="text" name="cnpj_entidade_financeira" id="cnpj_entidade_financeira" class="form-control" value = "09089356000118" readonly/>';
																echo ' </div>';
																echo ' </div>';

																echo ' <div class="form-group row">';
																echo ' <label class="col-xl-3 col-lg-3 col-form-label">Chave Client ID</label>';
																echo ' <div class="col-lg-9 col-xl-6">';
																echo ' <input value="'.$row['chave_client_id_entidade_financeira'].'" type="text" name="chave_client_id_entidade_financeira" id="chave_client_id_entidade_financeira" class="form-control" placeholder="Copie o seu CLIENT ID do seu banco e cole aqui."/>';
																echo ' </div>';
																echo ' </div>';

																echo ' <div class="form-group row">';
																echo ' <label class="col-xl-3 col-lg-3 col-form-label">Chave Client Secret</label>';
																echo ' <div class="col-lg-9 col-xl-6">';
																echo ' <input value="'.$row['chave_client_secret_entidade_financeira'].'" type="text" name="chave_client_secret_entidade_financeira" id="chave_client_secret_entidade_financeira" class="form-control" placeholder="Copie o seu CLIENT SECRET do seu banco e cole aqui."/>';
																echo ' </div>';
																echo ' </div>';

																echo ' <div class="form-group row">';
																echo ' <label class="col-xl-3 col-lg-3 col-form-label">Integra Pix?</label>';
																echo ' <div class="col-lg-9 col-xl-6">';
																echo ' <select name="integra_pix_entidade_financeira" id="integra_pix_entidade_financeira" class="form-control">';
																echo ' <option value="S"'. ($row['integra_pix_entidade_financeira'] == 'S' ? ' selected' : '') .'>Sim</option>';
																echo ' <option value="N"'. ($row['integra_pix_entidade_financeira'] == 'N' ? ' selected' : '') .' >Não</option>';
																echo ' </select>';
																//echo ' <input type="text" name="integra_pix_entidade_financeira" id="integra_pix_entidade_financeira" class="form-control"/>';
																echo ' </div>';
																echo ' </div>';

																echo ' <div class="form-group row">';
																echo ' <label class="col-xl-3 col-lg-3 col-form-label">Integra Boleto?</label>';
																echo ' <div class="col-lg-9 col-xl-6">';
																echo '<select name="Integra_boleto_entidade_financeira" id="Integra_boleto_entidade_financeira" class="form-control">';
																echo '<option value="S"' . ($row['Integra_boleto_entidade_financeira'] == 'S' ? ' selected' : '') . '>Sim</option>';
																echo '<option value="N"' . ($row['Integra_boleto_entidade_financeira'] == 'N' ? ' selected' : '') . '>Não</option>';
																echo '</select>';
																//echo ' <input type="text" name="Integra_boleto_entidade_financeira" id="Integra_boleto_entidade_financeira" class="form-control"/>';
																echo ' </div>';
																echo ' </div>';
																echo ' <input type="submit" value="Confirmar" class="btn btn-success" id="gravaInfo_Entidade_Financeira" name="gravaInfo_Entidade_Financeira">';
																echo ' &nbsp;';
																echo ' <a id="ContentPlaceHolder1_iBtCancelar" class="btn btn-secondary" href="javascript:__doPostBack(&#39;ctl00$ContentPlaceHolder1$iBtCancelar&#39;,&#39;&#39;)"> Cancelar </a>';
																
																echo ' </form>';
															}else{
																//echo '<label for="certificadoProducao"></label>';
																echo "<div class='card' ".$_SESSION['c_card']." style='max-width: 100%; max-height: 50vh;'>";
																$caminho_certificado_producao_banco = "../charts/".$_SESSION['cnpj_empresa']."//efi/";
																$certificado_producao_banco = "certificadoProducao.pfx"; // Nome do arquivo que será salvo
																$caminho_certificado_producao_banco = $caminho_certificado_producao_banco . $certificado_producao_banco;

																echo '<div class="card-body text-center">';
																echo '<h1>Certificado do Banco</h1>';
																if (file_exists($caminho_certificado_producao_banco) && pathinfo($caminho_certificado_producao_banco, PATHINFO_EXTENSION) === 'pfx') {
																	$tipo_foto_empresa = mime_content_type($caminho_certificado_producao_banco);
																	echo "<h4>".$caminho_certificado_producao_banco."</h4>";
																} else {
																	echo "<h1>Sem Certificado</h1>";
																}
																echo '<h7>Produção</h7>';
																echo '<label for="certificadoProducao" class="btn btn-block btn-lg btn-outline-success">';
																echo '<i class="bi bi-paperclip"></i> Escolher arquivo';
																echo '<input type="file" name="certificadoProducao" id="certificadoProducao" style="display: none;">'; // Mude o estilo para "none"
																echo '</label>';
																echo '</div>';
																echo '</div>';


																echo ' <div class="form-group row">';
																echo ' <label class="col-xl-3 col-lg-3 col-form-label">CD</label>';
																echo ' <div class="col-lg-9 col-xl-6">';
																echo ' <input type="text" name="cd_entidade_financeira" id="cd_entidade_financeira" class="form-control" placeholder="Código da Entidade Financeira" readonly/>';
																echo ' </div>';
																echo ' </div>';

																echo ' <div class="form-group row">';
																echo ' <label class="col-xl-3 col-lg-3 col-form-label">Título</label>';
																echo ' <div class="col-lg-9 col-xl-6">';
																echo ' <input type="text" name="titulo_entidade_financeira" id="titulo_entidade_financeira" class="form-control" placeholder="Título"/>';
																echo ' </div>';
																echo ' </div>';

																echo ' <div class="form-group row">';
																echo ' <label class="col-xl-3 col-lg-3 col-form-label">Obs</label>';
																echo ' <div class="col-lg-9 col-xl-6">';
																echo ' <input type="text" name="obs_entidade_financeira" id="obs_entidade_financeira" class="form-control" placeholder="Observação"/>';
																echo ' </div>';
																echo ' </div>';

																echo ' <div class="form-group row">';
																echo ' <label class="col-xl-3 col-lg-3 col-form-label">Razão Social</label>';
																echo ' <div class="col-lg-9 col-xl-6">';
																echo ' <input type="text" name="rsocial_entidade_financeira" id="rsocial_entidade_financeira" class="form-control" value = "Efí S.A." readonly/>';
																echo ' </div>';
																echo ' </div>';

																echo ' <div class="form-group row">';
																echo ' <label class="col-xl-3 col-lg-3 col-form-label">CNPJ</label>';
																echo ' <div class="col-lg-9 col-xl-6">';
																echo ' <input type="text" name="cnpj_entidade_financeira" id="cnpj_entidade_financeira" class="form-control" value = "09089356000118" readonly/>';
																echo ' </div>';
																echo ' </div>';

																echo ' <div class="form-group row">';
																echo ' <label class="col-xl-3 col-lg-3 col-form-label">Chave Client ID</label>';
																echo ' <div class="col-lg-9 col-xl-6">';
																echo ' <input type="text" name="chave_client_id_entidade_financeira" id="chave_client_id_entidade_financeira" class="form-control" placeholder="Copie o seu CLIENT ID do seu banco e cole aqui."/>';
																echo ' </div>';
																echo ' </div>';

																echo ' <div class="form-group row">';
																echo ' <label class="col-xl-3 col-lg-3 col-form-label">Chave Client Secret</label>';
																echo ' <div class="col-lg-9 col-xl-6">';
																echo ' <input type="text" name="chave_client_secret_entidade_financeira" id="chave_client_secret_entidade_financeira" class="form-control" placeholder="Copie o seu CLIENT SECRET do seu banco e cole aqui."/>';
																echo ' </div>';
																echo ' </div>';

																echo ' <div class="form-group row">';
																echo ' <label class="col-xl-3 col-lg-3 col-form-label">Integra Pix?</label>';
																echo ' <div class="col-lg-9 col-xl-6">';
																echo ' <select name="integra_pix_entidade_financeira" id="integra_pix_entidade_financeira" class="form-control">';
																echo ' <option value="S">Sim</option>';
																echo ' <option selected value="N">Não</option>';
																echo ' </select>';
																//echo ' <input type="text" name="integra_pix_entidade_financeira" id="integra_pix_entidade_financeira" class="form-control"/>';
																echo ' </div>';
																echo ' </div>';

																echo ' <div class="form-group row">';
																echo ' <label class="col-xl-3 col-lg-3 col-form-label">Integra Boleto?</label>';
																echo ' <div class="col-lg-9 col-xl-6">';
																echo ' <select name="Integra_boleto_entidade_financeira" id="Integra_boleto_entidade_financeira" class="form-control">';
																echo ' <option value="S">Sim</option>';
																echo ' <option selected value="N">Não</option>';
																echo ' </select>';
																//echo ' <input type="text" name="Integra_boleto_entidade_financeira" id="Integra_boleto_entidade_financeira" class="form-control"/>';
																echo ' </div>';
																echo ' </div>';

																echo ' <input type="submit" value="Confirmar" class="btn btn-success" id="gravaInfo_Entidade_Financeira" name="gravaInfo_Entidade_Financeira">';
																echo ' &nbsp;';
																echo ' <a id="ContentPlaceHolder1_iBtCancelar" class="btn btn-secondary" href="javascript:__doPostBack(&#39;ctl00$ContentPlaceHolder1$iBtCancelar&#39;,&#39;&#39;)"> Cancelar </a>';
																echo ' </form>';
															}
															//if($_POST['entidade_financeira'] == 1){
															//	$_SESSION['entidade_financeira'] = $_POST['entidade_financeira'];
															//}
														}
														
														if(isset($_SESSION['entidade_financeira'])){
															if($_SESSION['entidade_financeira'] == 1){

																


																
																
							
															}
														}
															

														echo ' </div>';
														echo ' </div>';
														echo ' </div>';
														
														
													}else if($_SESSION['opcaoMenu'] == 3){
														echo ' <!--begin: Personal Information-->';
														echo ' <div class="tab-pane fade show active" id="infoGeral" style="display:block;">';
														echo ' <div class="kt-portlet">';
														echo ' <div class="kt-portlet__head">';
														echo ' <div class="kt-portlet__head-label">';
														echo ' <h3 class="kt-portlet__head-title">Mensagens</h3>';
														echo ' </div>';
														echo ' </div>';

														echo ' <div class="kt-form kt-form--label-right">';
														//echo ' <h3 class="kt-portlet__head-title">Em Breve</h3>';
														//echo '<!--';
														echo ' <form method="POST">';
														echo ' <div class="kt-portlet__body">';
														echo ' <div class="kt-section kt-section--first">';
                                						echo ' <div class="kt-section__body">';

														echo ' <div class="form-group row">';
														
														echo '<input value="'. $_SESSION['cd_empresa'] .'" name="cd_empresa" type="hidden"  id="cd_empresa" class="form-control form-control-sm"/>';
														
														echo '<label class="col-2">Modelo</label>';
														echo '<div class="col-12">';
														if ($_SESSION['tipo_mensagem'] == ''){
															echo '<span>Selecione seu meio de mensagens</span>';
													  	}
														$opcoes = [
															"WHATSAPP" => "WhatsApp",
															"TELEGRAM" => "Telegram",
															"EMAIL" => "E-Mail"
														];
														$selecionado = $_SESSION['tipo_mensagem'] ?? '';
														echo '<select name="edittipo_mensagem" id="edittipo_mensagem" class="form-control">';
														if ($selecionado == '') {
															echo '<option value="" selected></option>';
														}
														if (array_key_exists($selecionado, $opcoes)) {
															echo '<option value="'.$selecionado.'" selected>'.$opcoes[$selecionado].'</option>';
															unset($opcoes[$selecionado]); // remove para não repetir
														}
														foreach ($opcoes as $valor => $texto) {
															echo '<option value="'.$valor.'">'.$texto.'</option>';
														}
														echo '</select>';
														echo '</div>';
														
														
														echo ' </div>';
														echo ' </div>';
														echo ' </div>';
														echo ' </div>';
														echo ' <div class="kt-portlet__foot">';
														echo ' <div class="kt-form__actions">';
														echo ' <div class="row">';
														
														echo '<div class="mt-3 col-lg-12 col-xl-12">';
														echo '<input type="submit" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" name="gravaInfoMensagem_Funcao" id="gravaInfoMensagem_Funcao" value="Gravar">';
														echo '</div>';
														//echo ' <div class="col-lg-9 col-xl-9">';
														//echo ' <input type="submit" value="Confirmar" class="btn btn-success" id="gravaInfoImpressao_Funcao" name="gravaInfoImpressao_Funcao">';
														//echo ' &nbsp;';
														//echo ' <a id="ContentPlaceHolder1_iBtCancelar" class="btn btn-secondary" href="javascript:__doPostBack(&#39;ctl00$ContentPlaceHolder1$iBtCancelar&#39;,&#39;&#39;)"> Cancelar </a>';
														//echo ' </div>';










														
														
                    	                                echo ' </div>';
                        	                            echo ' </div>';
                            	                        echo ' </div>';
														
														echo ' </form>';
														//echo '-->';
														

													}else if($_SESSION['opcaoMenu'] == 4){
														echo ' <!--begin: Personal Information-->';
														echo ' <div class="tab-pane fade show active" id="infoGeral">';
														echo ' <div class="kt-portlet">';
														echo ' <div class="kt-portlet__head">';
														echo ' <div class="kt-portlet__head-label">';
														echo ' <h3 class="kt-portlet__head-title">Impressões</h3>';
														echo ' </div>';
														echo ' </div>';
														echo ' <div class="kt-form kt-form--label-right">';
														//echo ' <h3 class="kt-portlet__head-title">Em Breve</h3>';
														//echo '<!--';
														echo ' <form method="POST">';
														echo ' <div class="kt-portlet__body">';
					                                	echo ' <div class="kt-section kt-section--first">';
					                                	echo ' <div class="kt-section__body">';
					                                	
														echo ' <div class="form-group row">';
                                						

														
														echo '<input value="'. $_SESSION['cd_empresa'] .'" name="cd_empresa" type="hidden"  id="cd_empresa" class="form-control form-control-sm"/>';
															


														
														echo '<label class="col-2">Modelo</label>';
														echo '<div class="col-12">';
														if ($_SESSION['tipo_impressao'] == ''){
															echo '<span>Selecione seu modelo de impressão</span>';
													  	}
														$opcoes = [
															"TERMICA1" => "Térmica 1",
															"TERMICA2" => "Térmica 2",
															"A4" => "A4"
														];
														$selecionado = $_SESSION['tipo_impressao'] ?? '';
														echo '<select name="edittipo_impressao" id="edittipo_impressao" class="form-control">';
														if ($selecionado == '') {
															echo '<option value="" selected></option>';
														}
														if (array_key_exists($selecionado, $opcoes)) {
															echo '<option value="'.$selecionado.'" selected>'.$opcoes[$selecionado].'</option>';
															unset($opcoes[$selecionado]); // remove para não repetir
														}
														foreach ($opcoes as $valor => $texto) {
															echo '<option value="'.$valor.'">'.$texto.'</option>';
														}
														echo '</select>';
														echo '</div>';
														
														
														echo ' </div>';
														echo ' </div>';
														echo ' </div>';
														echo ' </div>';
														echo ' <div class="kt-portlet__foot">';
														echo ' <div class="kt-form__actions">';
														echo ' <div class="row">';
														
														echo '<div class="mt-3 col-lg-12 col-xl-12">';
														echo '<input type="submit" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" name="gravaInfoImpressao_Funcao" id="gravaInfoImpressao_Funcao" value="Gravar">';
														echo '</div>';
														//echo ' <div class="col-lg-9 col-xl-9">';
														//echo ' <input type="submit" value="Confirmar" class="btn btn-success" id="gravaInfoImpressao_Funcao" name="gravaInfoImpressao_Funcao">';
														//echo ' &nbsp;';
														//echo ' <a id="ContentPlaceHolder1_iBtCancelar" class="btn btn-secondary" href="javascript:__doPostBack(&#39;ctl00$ContentPlaceHolder1$iBtCancelar&#39;,&#39;&#39;)"> Cancelar </a>';
														//echo ' </div>';
														echo ' </div>';
														echo ' </div>';
														echo ' </div>';
														echo ' </form>';
														//echo '-->';
														                            							
													}else if($_SESSION['opcaoMenu'] == 5){
														echo ' <!--begin: Personal Information-->';
														echo ' <div class="tab-pane fade show active">';
														echo ' <div class="kt-portlet">';
														echo ' <div class="kt-portlet__head">';
														echo ' <div class="kt-portlet__head-label">';
														echo ' <h3 class="kt-portlet__head-title">Site</h3>';
														echo ' </div>';
														echo ' </div>';

														echo ' <div class="kt-form kt-form--label-right">';
														echo ' <h3 class="kt-portlet__head-title">Em Breve</h3>';
														echo '<!--';
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
														echo '-->';

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
			</div>
        </div>
		</div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        
			<?php include("../../partials/_footer.php");?>
        
        <!-- partial -->
      
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










