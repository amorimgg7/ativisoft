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
    if(isset($_SESSION['orcamento_cliente'])){
      echo '<script>document.getElementById("abrirOrcamento").style.display = "block";</script>';      
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
  <title>Iniciar Venda</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <?php
  		$caminho_pasta_empresa = "../web/imagens/".$_SESSION['cnpj_empresa']."//logos/";
		$foto_empresa = "LogoEmpresa.jpg"; // Nome do arquivo que será salvo
		$caminho_foto_empresa = $caminho_pasta_empresa . $foto_empresa;

		if (file_exists($caminho_foto_empresa)) {
			$tipo_foto_empresa = mime_content_type($caminho_foto_empresa);
  			echo "<link rel='shortcut icon' href='data:$tipo_foto_empresa;base64," . base64_encode(file_get_contents($caminho_foto_empresa)) . "' />";
		}else{
			echo "<link rel='shortcut icon' href='https://lh3.googleusercontent.com/pw/AP1GczOReqQClzL-PZkykfOwgmMyVzQgx27DTp783MI7iwKuKSv-6P6V7KOEbCC74sGdK3DEV3O88CsBLeIvOaQwGT3x4bqCTPRtyV9zcODbYVDRxAF8zf8Uev7geh4ONPdl3arNhnSDPvbQfMdpFRPM263V9A=w250-h250-s-no-gm?authuser=0' />";
		}
	?>
  <!-- endinject -->
  <script src="../../js/functions.js"></script>
  <link rel="shortcut icon" href="<?php echo $_SESSION['logo_empresa']; ?>" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>




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

                <?php
                  if(isset($_POST['limparOS'])){
                    //echo "<script>window.alert('Mostrar botão de limpar OS!');</script>";
                    ////session_start();
                    $_SESSION['os_cliente'] = 0;
                    $_SESSION['os_servico'] = 0;
                    $_SESSION['servico'] = 0;
                    $_SESSION['cd_cliente_comercial'] = 0;
                    $_SESSION['vtotal_orcamento'] = 0;
                    $_SESSION['vpag_servico'] = 0;
                  
                    echo '<script>document.getElementById("consulta").style.display = "block";</script>';//botoes
                    echo '<script>document.getElementById("cadOs").style.display = "none";</script>';//
                    echo '<script>document.getElementById("cadastroCliente").style.display = "none";</script>';
                  }
                ?>
                



                <div class="card-body" id="cadastroCliente" style="display:none;">
                  <h3 class="kt-portlet__head-title">Dados do cliente</h3>
                  <div class="kt-portlet__body">
                    <div class="row">
                      <div class="col-12 col-md-12">
                        <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                          <form method="POST">
                            <div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">
                              <label for="pnome_cliente">Nome</label>
                              <input name="pnome_cliente" type="text" id="pnome_cliente" maxlength="40"   class="aspNetDisabled form-control form-control-sm" required/>
                              
                              <label for="snome_cliente">sobrenome</label>
                              <input name="snome_cliente" type="text" id="snome_cliente" maxlength="40"   class="aspNetDisabled form-control form-control-sm" />
                              <label for="tel_cliente">Telefone</label>
                              <input name="tel_cliente" type="tel" <?php //session_start(); echo $_SESSION['contel_cliente'];?> id="tel_cliente" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" readonly/>
                              <!--<input type="submit" class="btn btn-success" value="Salvar">-->
                            </div>
                            <button type="submit" name="cad_cliente" class="btn btn-success" >Salvar</button>
                          </form>
                          <form method="post">
                            <button type="submit" class="btn btn-danger" name="limparOS" style="margin: 5px;">Refazer</button>';
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>


                        <?php //cadastra cliente e consulta para abrir ordem de serviço
                          if(isset($_POST['cad_cliente'])) {
                          //include("../../partials/load.html");
                          // Atualiza as informações do usuário no banco de dados
                          $query = "INSERT INTO tb_cliente(pnome_cliente, snome_cliente, tel_cliente) VALUES(
                            '".$_POST['pnome_cliente']."',
                            '".$_POST['snome_cliente']."',
                            '".$_POST['cd_pais'].$_POST['tel_cliente']."')
                          ";
                          mysqli_query($conn, $query);
                              
                          $query = "SELECT * FROM tb_cliente WHERE tel_cliente = '".$_POST['cd_pais'].$_POST['tel_cliente']."'";
                          $result = mysqli_query($conn, $query);
                          $row = mysqli_fetch_assoc($result);

                          // Exibe as informações do usuário no formulário
                          if($row) {
                            $_SESSION['os_cliente'] = $row['cd_cliente'];
                            $_SESSION['pnome_cliente'] = $row['pnome_cliente'];
                            $_SESSION['snome_cliente'] = $row['snome_cliente'];
                            $_SESSION['tel_cliente'] = $row['tel_cliente'];                
                          }
                          }
                        ?>


                    


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
                                    <option selected="selected"value='55'>+55 Brasil</option>
                                    <option value='93'>93 Afeganistão</option>
                                    <option value='355'>355 Albânia</option>
                                    <option value='213'>213 Argélia</option>
                                    <option value='376'>376 Andorra</option>
                                    <option value='244'>244 Angola</option>
                                    <option value='1264'>1264 Anguila</option>
                                    <option value='1268'>1268 Antígua e Barbuda</option>
                                    <option value='54'>54 Argentina</option>
                                    <option value='374'>374 Armênia</option>
                                    <option value='297'>297 Aruba</option>
                                    <option value='247'>247 Ascensão</option>
                                    <option value='61'>61 Austrália</option>
                                    <option value='672'>672 Ilha Christmas</option>
                                    <option value='43'>43 Áustria</option>
                                    <option value='994'>994 Azerbaijão</option>
                                    <option value='1242'>1242 Bahamas</option>
                                    <option value='973'>973 Bahrain</option>
                                    <option value='880'>880 Bangladesh</option>
                                    <option value='1246'>1246 Barbados</option>
                                    <option value='375'>375 Belarus</option>
                                    <option value='32'>32 Bélgica</option>
                                    <option value='501'>501 Belize</option>
                                    <option value='229'>229 Benin</option>
                                    <option value='1441'>1441 Bermuda</option>
                                    <option value='975'>975 Butão</option>
                                    <option value='591'>591 Bolívia</option>
                                    <option value='387'>387 Bósnia e Herzegovina</option>
                                    <option value='267'>267 Botsuana</option>
                                    
                                    <option value='246'>246 Território Britânico do Oceano Índico</option>
                                    <option value='673'>673 Brunei</option>
                                    <option value='359'>359 Bulgária</option>
                                    <option value='226'>226 Burkina Faso</option>
                                    <option value='257'>257 Burundi</option>
                                    <option value='238'>238 Cabo Verde</option>
                                    <option value='855'>855 Camboja</option>
                                    <option value='237'>237 Camarões</option>
                                    <option value='1'>1 Canadá</option>
                                    <option value='238'>238 Cabo Verde</option>
                                    
                                    <option value='345'>345 Ilhas Cayman</option>
                                    <option value='236'>236 República Centro-Africana</option>
                                    <option value='235'>235 Chade</option>
                                    <option value='56'>56 Chile</option>
                                    <option value='86'>86 China</option>
                                    <option value='61'>61 Ilha Cocos (Keeling)</option>
                                    <option value='57'>57 Colômbia</option>
                                    <option value='269'>269 Comores</option>
                                    <option value='242'>242 Congo</option>
                                    <option value='243'>243 República Democrática do Congo</option>
                                    <option value='682'>682 Ilhas Cook</option>
                                    <option value='506'>506 Costa Rica</option>
                                    <option value='225'>225 Costa do Marfim</option>
                                    <option value='385'>385 Croácia</option>
                                    <option value='53'>53 Cuba</option>
                                    <option value='599'>599 Curaçao</option>
                                    <option value='357'>357 Chipre</option>
                                    <option value='420'>420 República Tcheca</option>
                                    <option value='45'>45 Dinamarca</option>
                                    <option value='253'>253 Djibuti</option>
                                    <option value='1767'>1767 Dominica</option>
                                    <option value='1809'>1809 República Dominicana</option>
                                    <option value='593'>593 Equador</option>
                                    <option value='20'>20 Egito</option>
                                    <option value='503'>503 El Salvador</option>
                                    <option value='240'>240 Guiné Equatorial</option>
                                    <option value='291'>291 Eritreia</option>
                                    <option value='372'>372 Estônia</option>
                                    <option value='251'>251 Etiópia</option>
                                    <option value='500'>500 Ilhas Malvinas</option>
                                    <option value='298'>298 Ilhas Faroe</option>
                                    <option value='679'>679 Fiji</option>
                                    <option value='358'>358 Finlândia</option>
                                    <option value='33'>33 França</option>
                                    <option value='596'>596 Martinica</option>
                                    <option value='594'>594 Guiana Francesa</option>
                                    <option value='689'>689 Polinésia Francesa</option>
                                    <option value='241'>241 Gabão</option>
                                    <option value='220'>220 Gâmbia</option>
                                    <option value='995'>995 Geórgia</option>
                                    <option value='49'>49 Alemanha</option>
                                    <option value='233'>233 Gana</option>
                                    <option value='350'>350 Gibraltar</option>
                                    <option value='30'>30 Grécia</option>
                                    <option value='299'>299 Groênlandia</option>
                                    <option value='1473'>1473 Granada</option>
                                    <option value='590'>590 Guadalupe</option>
                                    <option value='1671'>1671 Guam</option>
                                    <option value='502'>502 Guatemala</option>
                                    <option value='44'>44 Guernsey</option>
                                    <option value='224'>224 Guiné</option>
                                    <option value='245'>245 Guiné-Bissau</option>
                                    <option value='592'>592 Guiana</option>
                                    <option value='509'>509 Haiti</option>
                                    <option value='379'>379 Santa Sé (Cidade do Vaticano)</option>
                                    <option value='504'>504 Honduras</option>
                                    <option value='852'>852 Hong Kong</option>
                                    <option value='36'>36 Hungria</option>
                                    <option value='354'>354 Islândia</option>
                                    <option value='91'>91 Índia</option>
                                    <option value='62'>62 Indonésia</option>
                                    <option value='98'>98 Irã</option>
                                    <option value='964'>964 Iraque</option>
                                    <option value='353'>353 Irlanda</option>
                                    <option value='44'>44 Ilha de Man</option>
                                    <option value='972'>972 Israel</option>
                                    <option value='39'>39 Itália</option>
                                    <option value='1876'>1876 Jamaica</option>
                                    <option value='81'>81 Japão</option>
                                    <option value='44'>44 Jersey</option>
                                    <option value='962'>962 Jordânia</option>
                                    <option value='7'>7 Cazaquistão</option>
                                    <option value='254'>254 Quênia</option>
                                    <option value='686'>686 Kiribati</option>
                                    <option value='850'>850 Coreia do Norte</option>
                                    <option value='82'>82 Coreia do Sul</option>
                                    <option value='965'>965 Kuwait</option>
                                    <option value='996'>996 Quirguistão</option>
                                    <option value='856'>856 Laos</option>
                                    <option value='371'>371 Letônia</option>
                                    <option value='961'>961 Líbano</option>
                                    <option value='266'>266 Lesoto</option>
                                    <option value='231'>231 Libéria</option>
                                    <option value='218'>218 Líbia</option>
                                    <option value='423'>423 Liechtenstein</option>
                                    <option value='370'>370 Lituânia</option>
                                    <option value='352'>352 Luxemburgo</option>
                                    <option value='853'>853 Macau</option>
                                    <option value='389'>389 Macedônia do Norte</option>
                                    <option value='261'>261 Madagascar</option>
                                    <option value='265'>265 Malawi</option>
                                    <option value='60'>60 Malásia</option>
                                    <option value='960'>960 Maldivas</option>
                                    <option value='223'>223 Mali</option>
                                    <option value='356'>356 Malta</option>
                                    <option value='692'>692 Ilhas Marshall</option>
                                    <option value='596'>596 Martinica</option>
                                    <option value='222'>222 Mauritânia</option>
                                    <option value='230'>230 Maurício</option>
                                    <option value='262'>262 Reunião</option>
                                    <option value='52'>52 México</option>
                                    <option value='691'>691 Micronésia</option>
                                    <option value='373'>373 Moldávia</option>
                                    <option value='377'>377 Mônaco</option>
                                    <option value='976'>976 Mongólia</option>
                                    <option value='382'>382 Montenegro</option>
                                    <option value='1664'>1664 Montserrat</option>
                                    <option value='212'>212 Marrocos</option>
                                    <option value='258'>258 Moçambique</option>
                                    <option value='95'>95 Mianmar</option>
                                    <option value='264'>264 Namíbia</option>
                                    <option value='674'>674 Nauru</option>
                                    <option value='977'>977 Nepal</option>
                                    <option value='31'>31 Países Baixos</option>
                                    <option value='687'>687 Nova Caledônia</option>
                                    <option value='64'>64 Nova Zelândia</option>
                                    <option value='505'>505 Nicarágua</option>
                                    <option value='227'>227 Níger</option>
                                    <option value='234'>234 Nigéria</option>
                                    <option value='683'>683 Niue</option>
                                    <option value='672'>672 Ilha Norfolk</option>
                                    <option value='1670'>1670 Ilhas Marianas do Norte</option>
                                    <option value='47'>47 Noruega</option>
                                    <option value='968'>968 Omã</option>
                                    <option value='92'>92 Paquistão</option>
                                    <option value='680'>680 Palau</option>
                                    <option value='970'>970 Palestina</option>
                                    <option value='507'>507 Panamá</option>
                                    <option value='675'>675 Papua Nova Guiné</option>
                                    <option value='595'>595 Paraguai</option>
                                    <option value='51'>51 Peru</option>
                                    <option value='63'>63 Filipinas</option>
                                    <option value='48'>48 Polônia</option>
                                    <option value='351'>351 Portugal</option>
                                    <option value='974'>974 Catar</option>
                                    <option value='262'>262 Reunião</option>
                                    <option value='40'>40 Romênia</option>
                                    <option value='7'>7 Rússia</option>
                                    <option value='250'>250 Ruanda</option>
                                    <option value='590'>590 São Bartolomeu</option>
                                    <option value='290'>290 Santa Helena</option>
                                    <option value='1869'>1869 São Cristóvão e Nevis</option>
                                    <option value='1758'>1758 Santa Lúcia</option>
                                    <option value='590'>590 São Martinho</option>
                                    <option value='508'>508 São Pedro e Miquelão</option>
                                    <option value='1784'>1784 São Vicente e Granadinas</option>
                                    <option value='685'>685 Samoa</option>
                                    <option value='378'>378 San Marino</option>
                                    <option value='239'>239 São Tomé e Príncipe</option>
                                    <option value='966'>966 Arábia Saudita</option>
                                    <option value='221'>221 Senegal</option>
                                    <option value='381'>381 Sérvia</option>
                                    <option value='248'>248 Seychelles</option>
                                    <option value='232'>232 Serra Leoa</option>
                                    <option value='65'>65 Cingapura</option>
                                    <option value='1721'>1721 Sint Maarten</option>
                                    <option value='421'>421 Eslováquia</option>
                                    <option value='386'>386 Eslovênia</option>
                                    <option value='677'>677 Ilhas Salomão</option>
                                    <option value='252'>252 Somália</option>
                                    <option value='27'>27 África do Sul</option>
                                    <option value='500'>500 Geórgia do Sul e Ilhas Sandwich do Sul</option>
                                    <option value='211'>211 Sudão do Sul</option>
                                    <option value='34'>34 Espanha</option>
                                    <option value='94'>94 Sri Lanka</option>
                                    <option value='249'>249 Sudão</option>
                                    <option value='597'>597 Suriname</option>
                                    <option value='47'>47 Svalbard e Jan Mayen</option>
                                    <option value='268'>268 Suazilândia</option>
                                    <option value='46'>46 Suécia</option>
                                    <option value='41'>41 Suíça</option>
                                    <option value='963'>963 Síria</option>
                                    <option value='886'>886 Taiwan</option>
                                    <option value='992'>992 Tajiquistão</option>
                                    <option value='255'>255 Tanzânia</option>
                                    <option value='66'>66 Tailândia</option>
                                    <option value='670'>670 Timor-Leste</option>
                                    <option value='228'>228 Togo</option>
                                    <option value='690'>690 Tokelau</option>
                                    <option value='676'>676 Tonga</option>
                                    <option value='1868'>1868 Trinidad e Tobago</option>
                                    <option value='216'>216 Tunísia</option>
                                    <option value='90'>90 Turquia</option>
                                    <option value='993'>993 Turcomenistão</option>
                                    <option value='1649'>1649 Ilhas Turcas e Caicos</option>
                                    <option value='688'>688 Tuvalu</option>
                                    <option value='256'>256 Uganda</option>
                                    <option value='380'>380 Ucrânia</option>
                                    <option value='971'>971 Emirados Árabes Unidos</option>
                                    <option value='44'>44 Reino Unido</option>
                                    <option value='1'>1 Estados Unidos</option>
                                    <option value='598'>598 Uruguai</option>
                                    <option value='998'>998 Uzbequistão</option>
                                    <option value='678'>678 Vanuatu</option>
                                    <option value='39'>39 Cidade do Vaticano</option>
                                    <option value='58'>58 Venezuela</option>
                                    <option value='84'>84 Vietnã</option>
                                    <option value='1284'>1284 Ilhas Virgens Britânicas</option>
                                    <option value='1340'>1340 Ilhas Virgens Americanas</option>
                                    <option value='681'>681 Wallis e Futuna</option>
                                    <option value='967'>967 Iêmen</option>
                                    <option value='260'>260 Zâmbia</option>
                                    <option value='263'>263 Zimbábue</option>
                                  </select>  
                                </div>
                                <input placeholder="Telefone do Cliente" type="tel" name="contel_cliente" id="contel_cliente" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" required oninput="validateInput(this)">
                            
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
                  if(isset($_POST['contel_cliente'])) { //CHAMAR CLIENTE CADASTRADO PARA SESSION
                    echo '<script>document.getElementById("pergunta1").style.display = "none";</script>';
                    //session_start();
                    $_SESSION['contel_cliente'] = $_POST['contel_cliente'];
                    $select_cliente = "SELECT * FROM tb_cliente WHERE tel_cliente = '".$_POST['cd_pais'].$_POST['contel_cliente']."'";
                    $result = mysqli_query($conn, $select_cliente);
                    $row = mysqli_fetch_assoc($result);
                    if($row) {
                      $_SESSION['os_cliente'] = $row['cd_cliente'];
                      $_SESSION['pnome_cliente'] = $row['pnome_cliente'];
                      $_SESSION['snome_cliente'] = $row['snome_cliente'];
                      $_SESSION['tel_cliente'] = $row['tel_cliente'];
                          
                      
                      /*
                       SELECT 
                            cd_cliente,
                            SUM(orcamento_servico) AS total_orcamento,
                            SUM(vpag_servico) AS total_pago,
                            SUM(orcamento_servico) - SUM(vpag_servico) AS saldo_faltante
                        FROM 
                            tb_servico
                        WHERE 
                            cd_cliente = 1
                        GROUP BY 
                            cd_cliente;
                       */
                      $select_divida = "SELECT SUM(orcamento_servico) AS total_orcamento, SUM(vpag_servico) AS total_pago, SUM(orcamento_servico) - SUM(vpag_servico) AS saldo_faltante FROM tb_servico WHERE cd_cliente = ".$row['cd_cliente']." GROUP BY cd_cliente HAVING saldo_faltante > 0;";
                      $result_divida = mysqli_query($conn, $select_divida);
                      $row_divida = mysqli_fetch_assoc($result_divida);
                      if($row_divida) {
                        $_SESSION['divida_cliente'] = "Dívida ativa de R$: ".number_format($row_divida['saldo_faltante'], 2, ',', '.')." <a class='btn btn-block btn-lg btn-warning' style='margin: 5px;' href='".$_SESSION['dominio']."pages/md_assistencia/acompanha_servico.php?cnpj=".$_SESSION['cnpj_empresa']."&tel=".$row['tel_cliente']."'>Saiba Mais</a>";
                        echo "<script>window.alert('A L E R T A ! \\nO cliente ".$row['pnome_cliente']." ".$row['snome_cliente']." está com uma dívida ativa de R$:".number_format($row_divida['saldo_faltante'], 2, ',', '.')."');</script>";
                      }else{
                        $_SESSION['divida_cliente'] = "0";
                      }
                    }else{
                      echo '<script>document.getElementById("consulta").style.display = "none";</script>';
                      echo '<script>document.getElementById("cadastroCliente").style.display = "block";</script>';
                      echo '<script>document.getElementById("tel_cliente").value = "'.$_POST['cd_pais'].$_POST['contel_cliente'].'"</script>';
                    }
                  }
                ?>
                
                <?php
                  if(isset($_SESSION['os_cliente'])){

                    if($_SESSION['os_cliente'] > 0 && (!isset($_SESSION['os_servico']) || $_SESSION['os_servico'] == 0)){
                      echo '<script>document.getElementById("pergunta1").style.display = "none";</script>';
                      echo '<div class="card-body" id="cadOs"><!--FORMULÁRIO PARA CRIAR OS-->';
                      echo '<div class="kt-portlet__body">';
                      echo '<div class="row">';
                      echo '<div class="col-12 col-md-12">';
                      echo '<div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">';
                      echo '<script>document.getElementById("consulta").style.display = "none";</script>';
                              
                      echo '<form method="POST">';
                      echo '<h3 class="kt-portlet__head-title">Dados do Cliente</h3> ';
                      echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">';
                      echo '<input value="'.$_SESSION['os_cliente'].'" name="showcd_cliente" type="text" id="showcd_cliente" class="aspNetDisabled form-control form-control-sm" style="display: none;"/>';
                      echo '<label for="showpnome_cliente">Nome</label>';
                      echo '<input value="'.$_SESSION['pnome_cliente'].'" name="showpnome_cliente" type="text" id="showpnome_cliente" maxlength="40"   class="aspNetDisabled form-control form-control-sm" readonly/>';
                      echo '<label for="showsnome_cliente">sobrenome</label>';
                      echo '<input value="'.$_SESSION['snome_cliente'].'" name="showsnome_cliente" type="text" id="showsnome_cliente" maxlength="40"   class="aspNetDisabled form-control form-control-sm" readonly/>';
                      echo '<label for="showtel_cliente">Telefone</label>';
                      echo '<input value="'.$_SESSION['tel_cliente'].'" name="showtel_cliente" type="tel"  id="showtel_cliente" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" readonly/>';

                      if($_SESSION['divida_cliente'] > 0){
                        echo '<h5 style="color:#f00;" id="divida_cliente">'.$_SESSION['divida_cliente'].'</h5>';
                      }
                      
                      echo '</div>';
                              
                      echo '<h3 class="kt-portlet__head-title">Dados do serviço</h3>';
                      echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">';
                      echo '<input type="tel" name="os_servico" id="os_servico" style="display: none;">';
                      echo '<label for="obs_servico">Descrição Geral</label>';
                      echo '<input type="text" name="obs_servico" maxlength="999" id="obs_servico"  class="aspNetDisabled form-control form-control-sm" placeholder="Caracteristica geral do serviço" required>';
                      echo '<!--<textarea name="obs_servico" maxlength="999" id="obs_servico"  class="aspNetDisabled form-control form-control-sm" placeholder="Oque o cliente pediu pra fazer?" ></textarea>-->';
                              
                      echo '<label for="prioridade_servico">Prioridade</label>';
                      echo '<select name="prioridade_servico" id="prioridade_servico"  class="aspNetDisabled form-control form-control-sm" required>';
                      echo '<option selected="selected" value=""></option>';
                      echo '<option value="B">Baixa</option>';
                      echo '<option value="M">Média</option>';
                      echo '<option value="A">Alta</option>';
                      echo '<option value="U">Urgente</option>';
                      echo '</select>';
                      echo '<!--<label for="showprazo_servico">Entrada</label>-->';
                      echo '<input name="data_hora_ponto" type="datetime-local" id="data_hora_ponto" placeholder="Data" class="aspNetDisabled form-control form-control-sm" style="display: none;" />';
                      echo '<label for="prazo_servico">Prazo</label>';
                      echo '<input name="prazo_servico" type="datetime-local" id="prazo_servico" placeholder="Data" class="aspNetDisabled form-control form-control-sm" value="16:"/>';
                      echo '</div>';
                      echo '<button type="submit" name="lancar" class="btn btn-block btn-lg btn-success" onclick="fechacadServico()">Lançar</button>';
                      echo '</form>';
                              
                      echo '</form>';
                      echo '<form method="post">';//echo '<button type="submit" class="btn btn-danger" name="limparOS" style="margin: 5px;">Nova Consulta</button>';
                      echo '<button type="submit" class="btn btn-block btn-lg btn-danger" name="limparOS" style="margin: 5px;">Refazer</button>';
                      echo '</form>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                    }
                  }
                          
                ?>
                          
                <?php
                  if(isset($_POST['lancar'])) { //CADASTRAR SERVICO E CHAMAR SERVICO CADASTRADO PARA SESSION
                    //include("../../partials/load.html");
                    // Atualiza as informações do usuário no banco de dados
                    $insert_servico = "INSERT INTO tb_servico(cd_cliente, obs_servico, prioridade_servico, entrada_servico, prazo_servico, status_servico) VALUES(
                      '".$_SESSION['os_cliente']."',
                              
                      '".$_POST['obs_servico']."',
                      '".$_POST['prioridade_servico']."',
                      '".$_POST['data_hora_ponto']."',
                      '".$_POST['prazo_servico']."',
                      '0')
                    ";
                    mysqli_query($conn, $insert_servico);
                    //echo "<script>window.alert('Ordem de Serviço criada com sucesso!');</script>";
                    echo '<script>document.getElementById("cadOs").style.display = "none";</script>';
                    //echo "<script>window.alert('Usuário atualizado com sucesso!');</script>";
                    $select_servico = "SELECT * FROM tb_servico WHERE cd_cliente = '".$_SESSION['os_cliente']."' AND status_servico = 0 ORDER BY cd_servico DESC LIMIT 1";
                    $result_servico = mysqli_query($conn, $select_servico);
                    $row_servico = mysqli_fetch_assoc($result_servico);
                    // Exibe as informações do usuário no formulário
                    if($row_servico) {
                      $_SESSION['os_servico'] = $row_servico['cd_servico'];
                      //$_SESSION['os_servico'] = $row_servico['cd_servico'];
                      $_SESSION['servico'] = $row_servico['cd_servico'];
                      $_SESSION['titulo_servico'] = $row_servico['titulo_servico'];
                      $_SESSION['obs_servico'] = $row_servico['obs_servico'];
                      $_SESSION['prioridade_servico'] = $row_servico['prioridade_servico'];
                      $_SESSION['entrada_servico'] = $_POST['data_hora_ponto'];
                      $_SESSION['prazo_servico'] = $row_servico['prazo_servico'];
                      $_SESSION['orcamento_servico'] = $row_servico['orcamento_servico'];
                      $_SESSION['vpag_servico'] = $row_servico['vpag_servico'];
        
                      $insert_atividade = "INSERT INTO tb_atividade(cd_servico, titulo_atividade, obs_atividade, cd_colab, inicio_atividade, fim_atividade) VALUES(
                        '".$row_servico['cd_servico']."',
                        'A',
                        '".$row_servico['obs_servico']."',
                        '".$_SESSION['cd_colab']."',
                        '".$_POST['data_hora_ponto']."',
                        '".$_POST['data_hora_ponto']."')
                      ";
                      mysqli_query($conn, $insert_atividade);
                      //echo "<script>window.alert('Atividade Lançada!');</script>";
                      }
                      //echo "<script>window.alert('Usuário atualizado com sucesso!');</script>";
                    }
                    ?>
                
                <?php
                    if(isset($_POST['con_edit_os'])) {
                      $query = "SELECT * FROM tb_servico WHERE cd_servico = '".$_POST['btncd_servico']."'";
                      $result = mysqli_query($conn, $query);
                      $row = mysqli_fetch_assoc($result);

                      // Exibe as informações do usuário no formulário
                      if($row) {
                        $_SESSION['os_servico'] = $row['cd_servico'];
                        $_SESSION['os_cliente'] = $row['cd_cliente'];
                                
                                
                        $_SESSION['titulo_servico'] = $row['titulo_servico'];
                        $_SESSION['obs_servico'] = $row['obs_servico'];
                        $_SESSION['prioridade_servico'] = $row['prioridade_servico'];
                        $_SESSION['entrada_servico'] = $row['entrada_servico'];
                        $_SESSION['prazo_servico'] = $row['prazo_servico'];
                        $_SESSION['orcamento_servico'] = $row['orcamento_servico'];
                        $_SESSION['vpag_servico'] = $row['vpag_servico'];
                      }
                              
                      $select_cliente = "SELECT * FROM tb_cliente WHERE cd_cliente = '".$_SESSION['os_cliente']."'";
                      $result_cliente = mysqli_query($conn, $select_cliente);
                      $row_cliente = mysqli_fetch_assoc($result_cliente);
                      if($row_cliente) {
                        $_SESSION['pnome_cliente'] = $row_cliente['pnome_cliente'];
                        $_SESSION['snome_cliente'] = $row_cliente['snome_cliente'];
                        $_SESSION['tel_cliente'] = $row_cliente['tel_cliente'];                
                      }


                    }


                    if(isset($_POST['edit_os'])) {
                      $edit_os = "UPDATE tb_servico SET
                        obs_servico = '".$_POST['editobs_servico']."',
                        prioridade_servico = '".$_POST['editprioridade_servico']."',
                        prazo_servico = '".$_POST['editprazo_servico']."'
                        WHERE cd_servico = '".$_POST['editos_servico']."'";
                        mysqli_query($conn, $edit_os);
                        echo "<script>window.alert('Servico editado!');</script>";

                        $query = "SELECT * FROM tb_servico WHERE cd_servico = '".$_POST['editos_servico']."'";
                        $result = mysqli_query($conn, $query);
                        $row = mysqli_fetch_assoc($result);
                        // Exibe as informações do usuário no formulário
                        if($row) {
                          $_SESSION['os_servico'] = $row['cd_servico'];
                          $_SESSION['os_cliente'] = $row['cd_cliente'];
                                
                                
                          $_SESSION['titulo_servico'] = $row['titulo_servico'];
                          $_SESSION['obs_servico'] = $row['obs_servico'];
                          $_SESSION['prioridade_servico'] = $row['prioridade_servico'];
                          $_SESSION['entrada_servico'] = $row['entrada_servico'];
                          $_SESSION['prazo_servico'] = $row['prazo_servico'];
                          $_SESSION['orcamento_servico'] = $row['orcamento_servico'];
                          $_SESSION['vpag_servico'] = $row['vpag_servico'];
                        }
                      }

                      if(isset($_POST['lancarOrcamento'])) {
                              
                        if($_POST['titulo_orcamento']==false){
                          $_SESSION['titulo_orcamento'] = $_POST['titulo_orcamento'];
                          $_SESSION['vcusto_orcamento'] = $_POST['vcusto_orcamento'];
                          echo "<script>window.alert('Descreva o Orcamento!');</script>"; 
                        }elseif($_POST['vcusto_orcamento']==false){
                          $_SESSION['titulo_orcamento'] = $_POST['titulo_orcamento'];
                          $_SESSION['vcusto_orcamento'] = $_POST['vcusto_orcamento'];
                          echo "<script>window.alert('Insira o Valor do Orcamento!');</script>";  
                        }else{
                          $_SESSION['titulo_orcamento'] = false;
                          $_SESSION['vcusto_orcamento'] = false;
                          $insertOrcamento = "INSERT INTO tb_orcamento_servico(cd_cliente, cd_servico, titulo_orcamento, vcusto_orcamento, status_orcamento) VALUES(
                            '".$_SESSION['os_cliente']."',
                            '".$_SESSION['os_servico']."',
                            '".$_POST['titulo_orcamento']."',
                            '".$_POST['vcusto_orcamento']."',
                            '0')
                          ";
                          mysqli_query($conn, $insertOrcamento);
                          $_SESSION['vtotal_orcamento'] = $_SESSION['vtotal_orcamento'] + $_POST['vcusto_orcamento'];
                              
                          $updateOrcamentoServico = "UPDATE tb_servico SET
                            orcamento_servico = ".$_SESSION['vtotal_orcamento']."
                            WHERE cd_servico = ".$_SESSION['os_servico']."";
                            mysqli_query($conn, $updateOrcamentoServico);
                          }            
                        }
                        ?>
                
                <?php
                          if(isset($_SESSION['os_servico'])){
                            if($_SESSION['os_servico'] > 0){
                              echo '<script>document.getElementById("pergunta1").style.display = "none";</script>';
                              echo '<script>document.getElementById("cadOs").style.display = "none";</script>';
                              echo '<form method="POST">';
                              echo '<div class="card-body" id="abrirOS2"><!--FORMULÁRIO PARA CRIAR OS-->';
                              echo '<div class="kt-portlet__body">';
                              echo '<div class="row">';
                              echo '<div class="col-12 col-md-12">';
                              echo '<div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">';
                              
                              echo '<script>document.getElementById("consulta").style.display = "none";</script>';
                              echo '<script>document.getElementById("abrirOS").style.display = "block";</script>';
                              //echo '<h3 class="kt-portlet__head-title">Dados do Cliente</h3> ';
                              echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" style="display:none;">';
                              echo '<input value="'.$_SESSION['os_cliente'].'" name="showcd_cliente" type="text" id="showcd_cliente" class="aspNetDisabled form-control form-control-sm" style="display: none;"/>';
                              echo '<label for="showpnome_cliente">Nome</label>';
                              echo '<input value="'.$_SESSION['pnome_cliente'].'" name="editpnome_cliente" type="text" id="showpnome_cliente" maxlength="40"   class="aspNetDisabled form-control form-control-sm" readonly/>';
                              echo '<label for="showsnome_cliente">sobrenome</label>';
                              echo '<input value="'.$_SESSION['snome_cliente'].'" name="showsnome_cliente" type="text" id="showsnome_cliente" maxlength="40"   class="aspNetDisabled form-control form-control-sm" readonly/>';
                              echo '<label for="showtel_cliente">Telefone</label>';
                              echo '<input value="'.$_SESSION['tel_cliente'].'" name="showtel_cliente" type="tel"  id="showtel_cliente" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" readonly/>';
                              echo '</div>';
                              
                              echo '<h3 class="kt-portlet__head-title">Dados do serviço</h3>';
                              echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">';
                              echo '<label for="editos_servico">OS</label>';
                              echo '<input value="'.$_SESSION['os_servico'].'" type="tel" name="editos_servico" id="editos_servico" class="aspNetDisabled form-control form-control-sm" readonly>';
                              echo '<label for="editobs_servico">Descrição Geral</label>';
                              echo '<input value="'.$_SESSION['obs_servico'].'" type="text" name="editobs_servico" maxlength="999" id="editobs_servico"  class="aspNetDisabled form-control form-control-sm" placeholder="Caracteristica geral do serviço">';
                              
                              
                              echo '<label for="editprioridade_servico">Prioridade</label>';
                              echo '<select name="editprioridade_servico" id="editprioridade_servico"  class="aspNetDisabled form-control form-control-sm">';
                              
                              if($_SESSION['prioridade_servico'] == "U"){
                                echo '<option selected="selected" value="'.$_SESSION['prioridade_servico'].'" >Urgente</option>';
                              }
                              if($_SESSION['prioridade_servico'] == "A"){
                                echo '<option selected="selected" value="'.$_SESSION['prioridade_servico'].'" >Alta</option>';
                              }
                              if($_SESSION['prioridade_servico'] == "M"){
                                echo '<option selected="selected" value="'.$_SESSION['prioridade_servico'].'" >Média</option>';
                              }
                              if($_SESSION['prioridade_servico'] == "B"){
                                echo '<option selected="selected" value="'.$_SESSION['prioridade_servico'].'" >Baixa</option>';
                              }
                              echo '<option value="U" >Urgente</option>';
                              echo '<option value="A" >Alta</option>';
                              echo '<option value="M" >Média</option>';
                              echo '<option value="B" >Baixa</option>';
                              echo '</select>';
                              echo '<label>Entrada</label>';
                              echo '<input value="'.$_SESSION['entrada_servico'].'" type="datetime-local" class="aspNetDisabled form-control form-control-sm" style="display: block; " readonly/>';
                              echo '<label for="editprazo_servico">Prazo</label>';
                              echo '<input value="'.$_SESSION['prazo_servico'].'" name="editprazo_servico" type="datetime-local" id="editprazo_servico" class="aspNetDisabled form-control form-control-sm"/>';
                              echo '<td><button type="submit" name="edit_os" id="edit_os" class="btn btn-block btn-outline-success"><i class="icon-cog"></i>Salvar</button></td>';
                              
                              echo '</div>';
                              
                              echo '</div>';
                              echo '</div>';
                              echo '</div>';
                              echo '</div>';
                              echo '</div>';
                              ////echo '</div>';
                              
                              echo '<style>';
                              echo '.horizontal-form {';
                              echo 'display: table;';
                              echo 'width: 100%;';
                              echo '}';
                              echo '.form-group {';
                              echo 'display: table-row;';
                              echo '}';
                              echo '.form-group label,';
                              echo '.form-group input {';
                              echo 'display: table-cell;';
                              echo 'padding: 5px;';
                              echo '}';
                              echo '</style>';
                              
                              echo '<h3 class="kt-portlet__head-title">Adicionar Serviço</h3>';
                              echo '<script>document.getElementById("listaOrcamento").style.display = "block";</script>';
                              echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" style="background-color: #C6C6C6;">';
                              echo '<div class="horizontal-form">';
                              echo '<div class="form-group">';
                              echo '<label for="titulo_orcamento"></label>';
                              echo '<input type="text" name="titulo_orcamento" id="titulo_orcamento" class="aspNetDisabled form-control form-control-sm" placeholder="Título do serviço">';
                              echo '<label for="vcusto_orcamento"></label>';
                              echo '<input type="tel" id="vcusto_orcamento" name="vcusto_orcamento" class="aspNetDisabled form-control form-control-sm" placeholder="Quanto custa este serviço?">';
                              echo '<label for="lancarOrcamento"></label>';
                              echo '<button type="submit" name="lancarOrcamento" id="lancarOrcamento" class="btn btn-success">Enviar</button>';
                              echo '</div>';
                              echo '</div>';
                              echo '</div>';
                              
                              //echo '<button type="submit" name="lancarOrcamento" class="btn btn-success">LançarOrcamento</button>';
                              //echo '<button type="submit" name="imprimir_os" class="btn btn-success">Imprimir OS</button>';
                              //echo '<button type="submit" name="via_cliente" class="btn btn-success">Via do Cliente (Impressão)</button>';
                              //echo '<button type="button" class="btn btn-success" onclick="enviarMensagemWhatsApp()">Via do Cliente (Whatsapp)</button>';
                              
                              echo '</form>';
                              //echo '</div>';
                            }
                          }
                          ?>
                
                <?php
                  if(isset($_POST['limparOS'])){
                    //echo "<script>window.alert('Mostrar botão de limpar OS!');</script>";
                    ////session_start();
                    $_SESSION['os_cliente'] = 0;
                    $_SESSION['os_servico'] = 0;
                    $_SESSION['vtotal_orcamento'] = 0;
                    $_SESSION['vpag_servico'] = 0;
                    
                    echo '<script>document.getElementById("consulta").style.display = "block";</script>';//botoes
                    echo '<script>document.getElementById("botoes").style.display = "none";</script>';//
                    
                    
                }
                ?>


                <?php

                  if(isset($_POST['lancar1'])) { //CADASTRAR SERVICO E CHAMAR SERVICO CADASTRADO CADASTRADOS
                    //include("../../partials/load.html");
                    // Atualiza as informações do usuário no banco de dados
                    $insert_servico = "INSERT INTO tb_servico(cd_cliente, titulo_servico, obs_servico, prioridade_servico, entrada_servico, prazo_servico, orcamento_servico, vpag_servico, status_servico) VALUES(
                      '".$_POST['os_cliente']."',
                      '".$_POST['titulo_servico']."',
                      '".$_POST['obs_servico']."',
                      '".$_POST['prioridade_servico']."',
                      '".$_POST['data_hora_ponto']."',
                      '".$_POST['prazo_servico']."',
                      '".$_POST['orcamento_servico']."',
                      '".$_POST['vpag_servico']."',
                      '0')
                    ";
                    mysqli_query($conn, $insert_servico);
                    echo "<script>window.alert('Ordem de Serviço criada com sucesso!');</script>";
                    //echo "<script>window.alert('Usuário atualizado com sucesso!');</script>";
                    $select_servico = "SELECT * FROM tb_servico WHERE cd_cliente = '".$_POST['os_cliente']."' AND status_servico = 0 ORDER BY cd_servico DESC LIMIT 1";
                    $result = mysqli_query($conn, $select_servico);
                    $row = mysqli_fetch_assoc($result);
                    // Exibe as informações do usuário no formulário
                    if($row) {
                      echo "<script>window.alert('OS: ".$row['cd_servico']." Prioridade: ".$row['prioridade_servico'].", cadastrado com sucesso!');</script>";
                      
                      $_SESSION['os_servico'] = $row['cd_servico'];
                      
                      $_SESSION['titulo_servico'] = $row['titulo_servico'];
                      $_SESSION['obs_cliente'] = $row['obs_cliente'];
                      $_SESSION['prioridade_cliente'] = $row['prioridade_cliente'];
                      $_SESSION['prazo_servico'] = $row['prazo_servico'];
                      $_SESSION['orcamento_servico'] = $row['orcamento_servico'];
                      $_SESSION['vpag_servico'] = $row['vpag_servico'];

                      $query3 = "INSERT INTO tb_atividade(cd_servico, titulo_atividade, obs_atividade, cd_colab, inicio_atividade, fim_atividade) VALUES(
                        '".$row['cd_servico']."',
                        'A',
                        '".$row['obs_servico']."',
                        '".$_SESSION['cd_colab']."',
                        '".$_POST['data_hora_ponto']."',
                        '".$_POST['data_hora_ponto']."')
                      ";
                      mysqli_query($conn, $query3);
                      echo "<script>window.alert('Atividade Lançada!');</script>";           

                      $_SESSION['tel_cliente'] = $row['tel_cliente'];
                      header("Location: ".$_SERVER['REQUEST_URI']); // Redireciona para a mesma página
                       
                    }
                    
                  }
                  
                  if(isset($_POST['pagar_servico'])){
                    $insert_pagar_servico = "INSERT INTO tb_movimento_financeiro(tipo_movimento, cd_caixa_movimento, cd_cliente_movimento, cd_colab_movimento, cd_os_movimento, fpag_movimento, valor_movimento, data_movimento, obs_movimento) VALUES(
                        1,
                        '".$_SESSION['cd_caixa']."',
                        '".$_SESSION['os_cliente']."',
                        '".$_SESSION['cd_colab']."',
                        '".$_SESSION['os_servico']."',
                        '".$_POST['fpag_movimento']."',
                        '".$_POST['vpag_movimento']."',
                        '".date('Y-m-d H:i', strtotime('+1 hour'))."',
                        'PAGAMENTO DA OS: ".$_SESSION['os_servico']."'
                         )
                     ";
                    mysqli_query($conn, $insert_pagar_servico);
                    //echo "<script>window.alert('Movimento Financeiro Lançado!');</script>";
                    
        
                    $fechar_caixa = "UPDATE tb_servico SET
                        vpag_servico = '".($_POST['vpag_movimento'] + $_SESSION['vpag_servico'])."'
                        WHERE cd_servico = ".$_SESSION['os_servico']."";
                        mysqli_query($conn, $fechar_caixa);
                        //echo "<script>window.alert('Pagamento do Serviço Lançado!');</script>";
                        $_SESSION['vpag_servico'] = $_POST['vpag_movimento'] + $_SESSION['vpag_servico'];
                        $_SESSION['falta_pagar_servico'] = $_SESSION['vtotal_orcamento'] - $_SESSION['vpag_servico'];
                        echo  '<script>document.getElementById("btn_falta_pagar_orcamento").value = "'.$_SESSION['falta_pagar_servico'].'";</script>';
        
                        if($_SESSION['falta_pagar_servico'] == 0){
                            echo '<script>document.getElementById("tela_pagamento").style.display = "none";</script>';//tela_pagamento
                        }
                        //$_SESSION['cd_servico'] = 0;
                        //$_SESSION['cd_servico'] = 0;
                        //$_SESSION['cd_cliente'] = 0;
                        //echo '<script>location.href="../../index.php";</script>';
                  }

                  if(isset($_POST['lancarPagamento'])) {
                    $updateVpagServico = "UPDATE tb_servico SET
                    vpag_servico = ".$_POST['btnvpag_orcamento']."
                    WHERE cd_servico = ".$_SESSION['os_servico']."";
                    mysqli_query($conn, $updateVpagServico);
                    $_SESSION['vpag_servico'] = $_POST['btnvpag_orcamento'];
                    
                    echo  '<script>document.getElementById("btnvpag_orcamento").value = "'.$_POST['btnvpag_orcamento'].'";</script>';
                  }

                  if(isset($_SESSION['os_servico'])){
                    if($_SESSION['os_servico'] > 0){
                      $select_orcamento = "SELECT * FROM tb_orcamento_servico WHERE cd_servico = '".$_SESSION['os_servico']."' ORDER BY cd_orcamento ASC";
                      $result_orcamento = mysqli_query($conn, $select_orcamento);
                      //$row_atividade = mysqli_fetch_assoc($result_atividade);
          
                      // Exibe as informações do usuário no formulário
                      echo '<style>';
                      echo '.horizontal-form {';
                      echo 'display: table;';
                      echo 'width: 100%;';
                      echo '}';
                      echo '.form-group {';
                      echo 'display: table-row;';
                      echo '}';
                                
                      echo '.form-group label,';
                      echo '.form-group input {';
                      echo 'display: table-cell;';
                      echo 'padding: 5px;';
                      echo '}';
                      echo '</style>';
                      echo '';
                      //echo '<h3 class="kt-portlet__head-title">Serviços adicionados</h3>';
                      $_SESSION['vtotal_orcamento'] = 0;
                      $count = 0;
                      $vtotal = 0;
                      while($row_orcamento = $result_orcamento->fetch_assoc()) {
                        echo '<div name="listaOrcamento" id="listaOrcamento" class="typeahead">';
                        echo '<form method="POST">';
                        echo '<div class="horizontal-form">';
                        echo '<div class="form-group">';
                        $count = $count + 1;
                        
                        echo '<input value="'.$row_orcamento['cd_orcamento'].'" name="listaid_orcamento" id="listaid_orcamento" class="aspNetDisabled form-control form-control-sm" style="display:none;">';
                        echo '<label for="listatitulo_orcamento">'.$count.'</label>';
                        echo '<input value="'.$row_orcamento['titulo_orcamento'].'" name="listatitulo_orcamento" id="listatitulo_orcamento" type="text" class="aspNetDisabled form-control form-control-sm" readonly>';
                        echo '<label for="listavalor_orcamento">R$: </label>';
                        echo '<input value="'.$row_orcamento['vcusto_orcamento'].'" name="listavalor_orcamento" id="listavalor_orcamento" type="tel" class="aspNetDisabled form-control form-control-sm" placeholder="" readonly>';
                        echo '<label for="listaremover_orcamento"></label>';
                        //echo '<input type="submit" value="X" onclick="location.reload()" name="listaremover_orcamento" id="listaremover_orcamento" class="btn btn-danger">';
                        echo '<input type="submit" value="X" name="listaremover_orcamento" id="listaremover_orcamento" class="btn btn-danger">';
                        
                        $vtotal = $vtotal + $row_orcamento['vcusto_orcamento'];
                        $_SESSION['vtotal_orcamento'] = $vtotal;
                        echo '</div>';
                        echo '</div>';
                        echo '</form>';
                        echo '</div>';
                        $i = 0;
                      }
                      
                      if(isset($_POST['listaremover_orcamento'])) {//DELETE FROM `tb_orcamento_servico` WHERE `tb_orcamento_servico`.`cd_orcamento` = 198
                        if(($_SESSION['vtotal_orcamento'] - $_POST['listavalor_orcamento'])>=$_SESSION['vpag_servico']){
                          //echo "<script>window.alert('OK, pode remover');</script>";
                          $vtotal = $vtotal - $_POST['listavalor_orcamento'];
                          $removeOrcamento = "DELETE FROM `tb_orcamento_servico` WHERE `tb_orcamento_servico`.`cd_orcamento` = ".$_POST['listaid_orcamento']."";
                          mysqli_query($conn, $removeOrcamento);
                          
                          $updateVtotalServico = "UPDATE tb_servico SET
                            orcamento_servico = ".$vtotal."
                            WHERE cd_servico = ".$_SESSION['os_servico']."";
                            mysqli_query($conn, $updateVtotalServico);
                            echo '<script>location.href="'.$_SESSION['dominio'].'pages/md_assistencia/cadastro_servico.php";</script>';             
                        }else{
                          echo "<script>window.alert('Valor pago não pode ser maior que o total do serviço!');</script>";  
                        }
                      }
                      echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" style="background-color: #C6C6C6; display:none;">';
                      echo '<div class="horizontal-form">';
                      echo '<div class="form-group">';
                      
                      //$_SESSION['falta_pagar_servico'] = $_SESSION['vtotal_orcamento'] - $_SESSION['vpag_servico'];
                        echo '<label for="showobs_servico">Total:</label>';
                        echo '<input value="'.$_SESSION['vtotal_orcamento'].'" type="tel" name="btnvtotal_orcamento" id="btnvtotal_orcamento" class="aspNetDisabled form-control form-control-sm" readonly>';
                        echo '<label for="showobs_servico">Pago:</label>';
                        echo '<input value="'.$_SESSION['vpag_servico'].'" type="tel" name="btnvpag_orcamento" id="btnvpag_orcamento" class="aspNetDisabled form-control form-control-sm" readonly>';
                        echo '<label for="showobs_servico">Falta:</label>';
                        echo '<input value="'.$_SESSION['falta_pagar_servico'].'" type="tel" name="btn_falta_pagar_orcamento" id="btn_falta_pagar_orcamento" class="aspNetDisabled form-control form-control-sm" readonly>';
                        
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
  
                      
                      
                      
  
                      if($_SESSION['vtotal_orcamento'] == 0){
                      }else{
                        echo '<form method="POST">';
                        echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" id="totalizador" name="totalizador" style="display: none;">';
                        echo '<label for="btncd_servico">OS</label>';
                        echo '<input value="'.$_SESSION['os_servico'].'" type="tel" name="btncd_servico" id="btncd_servico" class="aspNetDisabled form-control form-control-sm">';
                        echo '</div>';
                        echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" style="background-color: #C6C6C6;">';
                        echo '<div class="horizontal-form">';
                        echo '<div class="form-group">';
                        if($_SESSION['vpag_servico'] == $_SESSION['vtotal_orcamento']){
                          echo '<label for="showobs_servico">Total Pago:</label>';
                          echo '<input value="'.$_SESSION['vpag_servico'].'" type="tel" name="btnvpag_orcamento" id="btnvpag_orcamento" class="aspNetDisabled form-control form-control-sm" readonly>';
                        }else{
                          $_SESSION['falta_pagar_servico'] = $_SESSION['vtotal_orcamento'] - $_SESSION['vpag_servico'];
                          echo '<label for="showobs_servico">Total:</label>';
                          echo '<input value="'.$_SESSION['vtotal_orcamento'].'" type="tel" name="btnvtotal_orcamento" id="btnvtotal_orcamento" class="aspNetDisabled form-control form-control-sm" readonly>';
                          echo '<label for="showobs_servico">Pago:</label>';
                          echo '<input value="'.$_SESSION['vpag_servico'].'" type="tel" name="btnvpag_orcamento" id="btnvpag_orcamento" class="aspNetDisabled form-control form-control-sm" readonly>';
                          echo '<label for="showobs_servico">Falta:</label>';
                          echo '<input value="'.$_SESSION['falta_pagar_servico'].'" type="tel" name="btn_falta_pagar_orcamento" id="btn_falta_pagar_orcamento" class="aspNetDisabled form-control form-control-sm" readonly>';
                          //echo '<label for="lancarPagamento"></label>';
                          //echo '<input type="submit" name="lancarPagamento" id="lancarPagamento" class="btn btn-success"">';
                        }
                      }
                      
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                      echo '</form>';
  
                      
  
  
                      
  
  
  
                      
                        $_SESSION['tela_movimento_financeiro'] = "VENDA_SERVICO";
                        echo '<div class="col-12 grid-margin stretch-card btn-success">';//
                        echo '<div class="card">';
                        
                        include("../md_caixa/movimento_financeiro.php");
                        
                        echo '</div>';
                        echo '</div>';
                      
  
                      ?>
  
  
                      <?php
                      echo '<form action="impresso.php" method="POST" target="_blank">';
                      
                      echo '<div class="card-body" id="formBtn"><!--FORMULÁRIO DOS BOTOES-->';
                      echo '<div class="kt-portlet__body">';
                      echo '<div class="row">';
                      echo '<div class="col-12 col-md-12">';
                      echo '<div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">';
                      
                      
  
  
  
  
                      //echo '<h3 class="kt-portlet__head-title">Dados do Cliente</h3> ';
                      echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" id="botoes" name="botoes" style="display:none;">';
                      echo '<input value="'.$_SESSION['os_cliente'].'" name="btncd_cliente" type="text" id="showcd_cliente" class="aspNetDisabled form-control form-control-sm" style="display: none;"/>';
                      echo '<label for="btnpnome_cliente">Nome</label>';
                      echo '<input value="'.$_SESSION['pnome_cliente'].'" name="btnpnome_cliente" type="text" id="btnpnome_cliente" maxlength="40"   class="aspNetDisabled form-control form-control-sm"/>';
                      echo '<label for="btnsnome_cliente">sobrenome</label>';
                      echo '<input value="'.$_SESSION['snome_cliente'].'" name="btnsnome_cliente" type="text" id="btnsnome_cliente" maxlength="40"   class="aspNetDisabled form-control form-control-sm"/>';
                      echo '<label for="btntel_cliente">Telefone</label>';
                      echo '<input value="'.$_SESSION['tel_cliente'].'" name="btntel_cliente" type="tel"  id="btntel_cliente" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm"/>';
                      echo '</div>';
                              
                      //echo '<h3 class="kt-portlet__head-title">Dados do serviço</h3>';
                      echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" style="display: none;">';
                      echo '<label for="btncd_servico">OS</label>';
                      echo '<input value="'.$_SESSION['os_servico'].'" type="tel" name="btncd_servico" id="btncd_servico" class="aspNetDisabled form-control form-control-sm">';
                      echo '<label for="btnobs_servico">Descrição Geral</label>';
                      echo '<input value="'.$_SESSION['obs_servico'].'" type="text" name="btnobs_servico" maxlength="999" id="btnobs_servico"  class="aspNetDisabled form-control form-control-sm" placeholder="Caracteristica geral do serviço">';
                      echo '<label for="btnprioridade_servico">Prioridade</label>';
                      echo '<select name="btnprioridade_servico" id="btnprioridade_servico"  class="aspNetDisabled form-control form-control-sm">';
                      echo '<option selected="selected" value="'.$_SESSION['prioridade_servico'].'" >'.$_SESSION['prioridade_servico'].'</option>';
                      echo '</select>';
                      echo '<!--<label for="btnprazo_servico">Entrada</label>-->';
                      echo '<input value="'.$_SESSION['entrada_servico'].'" name="btnentrada_servico" type="datetime-local" id="btnentrada_servico" class="aspNetDisabled form-control form-control-sm" />';
                      echo '<label for="btnprazo_servico">Prazo</label>';
                      echo '<input value="'.$_SESSION['prazo_servico'].'" name="btnprazo_servico" type="datetime-local" id="btnprazo_servico" class="aspNetDisabled form-control form-control-sm"/>';
                      echo '</div>';
                      
                      echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" style="background-color: #C6C6C6; display:none;">';
                      echo '<div class="horizontal-form">';
                      echo '<div class="form-group">';
                      echo '<label for="showobs_servico">Total</label>';
                      echo '<input value="'.$_SESSION['vtotal_orcamento'].'" type="tel" name="btnvtotal_orcamento" id="btnvtotal_orcamento" class="aspNetDisabled form-control form-control-sm" readonly>';
                      echo '<label for="showobs_servico">Pago</label>';
                      echo '<input value="'.$_SESSION['vpag_servico'].'" type="tel" name="btnvpag_orcamento" id="btnvpag_orcamento" class="aspNetDisabled form-control form-control-sm" placeholder="Valor Pago">';
                      echo '<label for="lancarPagamento"></label>';
                      echo '<input type="submit" name="lancarPagamento" id="lancarPagamento" class="btn btn-success"">';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                      
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>'; 
                      
                              
                              
                              //echo '<button type="submit" name="lancarOrcamento" class="btn btn-success">LançarOrcamento</button>';
                      echo '<button type="submit" name="imprimir_os" class="btn btn-block btn-lg btn-info" style="margin-top: 20px; margin-bottom: 20px;">Imprimir OS</button>';
                      echo '<button type="submit" name="via_cliente" class="btn btn-block btn-lg btn-info" style="margin-top: 20px; margin-bottom: 20px;">Via do Cliente (Impressão)</button>';
                      echo '<button type="button" class="btn btn-block btn-lg btn-success" onclick="enviarMensagemWhatsApp()" style="margin-top: 20px; margin-bottom: 20px;">Via do Cliente (Whatsapp)</button>';
                      //echo '<button type="submit" class="btn btn-danger" name="limparOS" style="margin: 5px;">Novo Serviço</button>';
                              
                      
                      echo '</div>';
                      echo '</form>';
                      echo '<form method="post">';
                      echo '<button type="submit" class="btn btn-block btn-lg btn-danger" name="limparOS" style="margin-top: 20px; margin-bottom: 20px;">Novo Serviço</button>';
                      echo '</form>';
  
                      
                    }
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

                

              </div>
            </div>
          </div>
        
          <?php

?>

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

  var vtotalServico = document.getElementById("btnvtotal_orcamento").value;
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
  

  $select_orcamento_whatsapp = "SELECT * FROM tb_orcamento_servico WHERE cd_servico = '".$_SESSION['os_servico']."' ORDER BY cd_orcamento ASC";
  $result_orcamento_whatsapp = mysqli_query($conn, $select_orcamento_whatsapp);
  echo 'mensagem += "*Lista detalhada*\n";';
                        
  while($row_orcamento_whatsapp = $result_orcamento_whatsapp->fetch_assoc()) {
    $counter = $counter + 1;
    //echo 'mensagem += count + " - '.$row_orcamento_whatsapp['titulo_orcamento'].' - '.$row_orcamento_whatsapp['vcusto_orcamento'].'"\n";';
    ?>mensagem += "<?php echo '*'.$counter.'* - '.$row_orcamento_whatsapp['titulo_orcamento'].' - R$:'.$row_orcamento_whatsapp['vcusto_orcamento']; ?>\n";<?php
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
    var data = new Date();
    var mes = data.getMonth() + 1;
    var dia = data.getDate();
    var ano = data.getFullYear();
    var hora = data.getHours();
    var minuto = data.getMinutes();

    document.getElementById("data_hora_ponto").value = `${ano}-${mes.toString().padStart(2, '0')}-${dia.toString().padStart(2, '0')}T${hora.toString().padStart(2, '0')}:${minuto.toString().padStart(2, '0')}`;
</script>


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