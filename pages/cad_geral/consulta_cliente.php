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
  <title>Consulta Cliente</title>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>
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
        <div class="content-wrapper" <?php echo $_SESSION['c_body'];?>>
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card" <?php echo $_SESSION['c_card'];?>>
                
                <div class="card-body" id="consulta" style="display: block;">
                  <h3 class="card-title">Consultar pelo telefone</h3>
                  <p class="card-description">Consulte o cliente que deseja atualizar os dados cadastrais pelo número de telefone cadastrado.</p>
                  <div class="kt-portlet__body">
                    <div class="row">
                      <div class="col-12 col-md-12">
                        <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                          <form method="POST">
                          
                          <div class="form-group" style="display: flex;">
                          <div class="input-group">
                          <div class="input-group-prepend">
                          <!--<span>-->
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
                          <!--</span>-->
                          </div>
                          <input placeholder="Telefone" type="tel" name="btntel_cliente" id="btntel_cliente" type="tel" class="aspNetDisabled form-control form-control-sm" required oninput="tel(this)">
                          <div class="input-group-append">
                          <!--<span class="input-group-text">.00</span>';-->
                          </div>
                          </div>
                          </div>
                          <p id="error-message" style="color: #DDDDDD;"></p>
                          



                            <br>
                            <button type="submit" class="btn btn-success"name="con_cliente" >Consulta</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
              <?php
                if(isset($_POST['con_cliente'])) {
                  
                  $query = "SELECT * FROM tb_cliente WHERE tel_cliente = '".$_POST['cd_pais'].$_POST['btntel_cliente']."'";
                  $result = mysqli_query($conn, $query);
                  $row = mysqli_fetch_assoc($result);

                  // Exibe as informações do usuário no formulário
                  if($row) {
                    $_SESSION['concd_cliente'] = $row['cd_cliente'];
                    
                    
                    
                  }      
                }
                
              ?>
              <?php
                if(isset($_POST['atualizaCliente'])) {
                  $updatecliente = "UPDATE tb_cliente SET
                  pnome_cliente = '".$_POST['btnpnome_cliente']."',
                  snome_cliente = '".$_POST['btnsnome_cliente']."',
                  tel_cliente = '".$_POST['btntel_cliente']."',
                  email_cliente = '".$_POST['btnemail_cliente']."'
                  WHERE cd_cliente = ".$_POST['btncd_cliente']."";
                  mysqli_query($conn, $updatecliente);
                }

                if(isset($_POST['outroCliente'])) { 
                  $_SESSION['concd_cliente'] = 0;
                }
              ?>
              <?php
                if($_SESSION['concd_cliente'] > 0){
                  echo '<script>document.getElementById("consulta").style.display = "none";</script>';
                  echo '<div class="col-12 grid-margin">';
                  echo '<div class="card" '.$_SESSION['c_card'].'>';
                  echo '<div class="card-body" id="editaCliente"><!--FORMULÁRIO PARA CRIAR OS-->';
                  echo '<div class="kt-portlet__body">';
                  echo '<div class="row">';
          
                  $select_cliente = "SELECT * FROM tb_cliente WHERE cd_cliente = '".$_SESSION['concd_cliente']."'";
                  $result_cliente = mysqli_query($conn, $select_cliente);
                  $row_cliente = mysqli_fetch_assoc($result_cliente);

                  // Exibe as informações do usuário no formulário
                  if($row_cliente) {
                      echo '<div class="col-12 col-md-12">';
                      echo '<div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">';
                      echo '<h3 class="card-title">Dados Pessoais</h3>';
                      echo '<form method="POST">';
                      //echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" id="botoes" name="botoes" style="display:block;">';
                      echo '<input value="'.$row_cliente['cd_cliente'].'" name="btncd_cliente" type="text" id="btncd_cliente" class="aspNetDisabled form-control form-control-sm" style="display: none;"/>';
                      echo '<label for="btnpnome_cliente">Nome</label>';
                      echo '<input value="'.$row_cliente['pnome_cliente'].'" name="btnpnome_cliente" type="text" id="btnpnome_cliente" maxlength="40"   class="aspNetDisabled form-control form-control-sm"/>';
                      echo '<label for="btnsnome_cliente">sobrenome</label>';
                      echo '<input value="'.$row_cliente['snome_cliente'].'" name="btnsnome_cliente" type="text" id="btnsnome_cliente" maxlength="40"   class="aspNetDisabled form-control form-control-sm"/>';
                      echo '<label for="btntel_cliente">Telefone</label>';
                      echo '<input value="'.$row_cliente['tel_cliente'].'" name="btntel_cliente" type="tel"  id="btntel_cliente" class="aspNetDisabled form-control form-control-sm"/>';
                      echo '<label for="btnemail_cliente">Email</label>';
                      echo '<input value="'.$row_cliente['email_cliente'].'" name="btnemail_cliente" type="email"  id="btnemail_cliente" maxlenth="40" class="aspNetDisabled form-control form-control-sm"/>';
                      
                      //echo '</div>';        
                      echo '<button type="submit" class="btn btn-block btn-lg btn-outline-success" name="atualizaCliente" id="atualizaCliente" style="margin-top: 20px; margin-bottom: 20px;">Atualizar cadastro</button>';
                      echo '<button type="submit" class="btn btn-block btn-lg btn-outline-warning" name="outroCliente" id="outroCliente" style="margin-top: 20px; margin-bottom: 20px;">Outro Cliente</button>';
                    
                      echo '</form>';
                      echo '</div>';
                      echo '</div>';
                      
                    }
                    ?>
                          
                          


                          <p id="error-message" style="color: #DDDDDD;"></p>
                      
                          <script>
                          //    function validateInput(inputElement) {
                          //        var inputValue = inputElement.value.replace(/\D/g, ''); // Remove caracteres não numéricos
                          //        var errorMessageElement = document.getElementById("error-message");
                      
                          //        if (inputValue.length === 11) {
                          //            errorMessageElement.textContent = "";
                          //            inputElement.setCustomValidity("");
                          //        } else if (inputValue.length === 10) {
                          //            errorMessageElement.textContent = "Insira um número válido com DDD.";
                          //            inputElement.setCustomValidity("Insira um número válido com DDD.");
                          //        } else if (inputValue.length === 9) {
                          //            errorMessageElement.textContent = "Insira o DDD e o número completo.";
                          //            inputElement.setCustomValidity("Insira o DDD e o número completo.");
                          //        } else {
                          //            errorMessageElement.textContent = "Insira um número válido.";
                          //            inputElement.setCustomValidity("Insira um número válido.");
                          //        }
                          //    }
                      
                          //    var phoneInput = document.getElementById("contel_cliente");
                          //    phoneInput.addEventListener("input", function () {
                          //        validateInput(phoneInput);
                          //    });
                          </script>
                    <?php
                    
                    
                    


                    //echo '<label for="lancarPagamento"></label>';
                    //echo '<input type="submit" name="lancarPagamento" id="lancarPagamento" class="btn btn-success"">';
                    
                    
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    
                    
                    
                   

                    
                    
                    
                      
                    

                    /*             


                    echo '<form action="impresso.php" method="POST" target="_blank">';
                    echo '<div style="display:none;">';
                    //echo '<h3 class="kt-portlet__head-title">Dados do Cliente</h3> ';
                    echo '<input value="'.$_SESSION['cd_cliente'].'" name="btncd_cliente" type="text" id="showcd_cliente" style="display: none;"/>';
                    //echo '<label for="btnpnome_cliente">Nome</label>';
                    echo '<input value="'.$_SESSION['pnome_cliente'].'" name="btnpnome_cliente" type="text" id="btnpnome_cliente" maxlength="40" readonly/>';
                    //echo '<label for="btnsnome_cliente">sobrenome</label>';
                    echo '<input value="'.$_SESSION['snome_cliente'].'" name="btnsnome_cliente" type="text" id="btnsnome_cliente" maxlength="40" readonly/>';
                    //echo '<label for="btntel_cliente">Telefone</label>';
                    echo '<input value="'.$_SESSION['tel_cliente'].'" name="btntel_cliente" type="tel"  id="btntel_cliente" oninput="tel(this)" readonly/>';
                    echo '<script>document.getElementById("showcd_cliente").value = "'.$_SESSION['cd_cliente'].'"</script>';
                    echo '<script>document.getElementById("btnpnome_cliente").value = "'.$_SESSION['pnome_cliente'].'"</script>';
                    echo '<script>document.getElementById("btnsnome_cliente").value = "'.$_SESSION['snome_cliente'].'"</script>';
                    echo '<script>document.getElementById("btntel_cliente").value = "'.$_SESSION['tel_cliente'].'"</script>';

                    //echo '<label for="btncd_servico">OS</label>';
                    echo '<input value="'.$_SESSION['cd_servico'].'" type="tel" name="btncd_servico" id="btncd_servico" readonly>';
                    //echo '<label for="btnobs_servico">Descrição Geral</label>';
                    echo '<input value="'.$_SESSION['obs_servico'].'" type="text" name="btnobs_servico" maxlength="999" id="btnobs_servico" placeholder="Caracteristica geral do serviço" readonly>';
                    //echo '<label for="btnprioridade_servico">Prioridade</label>';
                    echo '<select name="btnprioridade_servico" id="btnprioridade_servico">';
                    echo '<option selected="selected" value="'.$_SESSION['prioridade_servico'].'" >'.$_SESSION['prioridade_servico'].'</option>';
                    echo '</select>';
                    //echo '<!--<label for="btnprazo_servico">Entrada</label>-->';
                    echo '<input value="'.$_SESSION['entrada_servico'].'" name="btnentrada_servico" type="datetime-local" id="btnentrada_servico" readonly/>';
                    //echo '<label for="btnprazo_servico">Prazo</label>';
                    echo '<input value="'.$_SESSION['prazo_servico'].'" name="btnprazo_servico" type="datetime-local" id="btnprazo_servico" readonly/>';
                    
                    echo '<script>document.getElementById("btncd_servico").value = "'.$_SESSION['cd_servico'].'"</script>';
                    echo '<script>document.getElementById("btnobs_servico").value = "'.$_SESSION['obs_servico'].'"</script>';
                    echo '<script>document.getElementById("btnprioridade_servico").value = "'.$_SESSION['prioridade_servico'].'"</script>';
                    echo '<script>document.getElementById("btnentrada_servico").value = "'.$_SESSION['entrada_servico'].'"</script>';
                    echo '<script>document.getElementById("btnprazo_servico").value = "'.$_SESSION['prazo_servico'].'"</script>';

                    //echo '<label for="showobs_servico">Total</label>';
                    echo '<input value="'.$_SESSION['vtotal_orcamento'].'" type="tel" name="btnvtotal_orcamento" id="btnvtotal_orcamento" readonly>';
                    //echo '<label for="showobs_servico">Pago</label>';
                    echo '<input value="'.$_SESSION['vpag_servico'].'" type="tel" name="btnvpag_orcamento" id="btnvpag_orcamento" readonly>';
                    

                    echo '<script>document.getElementById("btnvtotal_orcamento").value = "'.$_SESSION['vtotal_orcamento'].'"</script>';
                    echo '<script>document.getElementById("btnvpag_orcamento").value = "'.$_SESSION['vpag_servico'].'"</script>';
                    echo '</div>';

                    
                    //echo '<button type="submit" name="lancarOrcamento" class="btn btn-success">LançarOrcamento</button>';
                    echo '<button type="submit" name="imprimir_os" class="btn btn-block btn-lg btn-info" style="margin-top: 20px; margin-bottom: 20px;">OS <i class="mdi mdi-printer btn-icon-append"></i></button>';
                    echo '<button type="submit" name="historico_os" class="btn btn-block btn-lg btn-info" style="margin-top: 20px; margin-bottom: 20px;">Histórico <i class="mdi mdi-printer btn-icon-append"></i></button>';
                    echo '<button type="submit" name="via_cliente" class="btn btn-block btn-lg btn-info" style="margin-top: 20px; margin-bottom: 20px;">Via do Cliente <i class="mdi mdi-printer btn-icon-append"></i></button>';
                    echo '<button type="button" class="btn btn-block btn-lg btn-success" onclick="enviarMensagemWhatsApp()" style="margin-top: 20px; margin-bottom: 20px;">Via do Cliente <i class="mdi mdi-whatsapp"></i></button>';
                    //echo '<button type="submit" class="btn btn-danger" name="limparOS-" style="margin: 5px;">Nova Consulta</button>';     
                    echo '</form>';
                    echo '<form method="post">';//echo '<button type="submit" class="btn btn-danger" name="limparOS" style="margin: 5px;">Nova Consulta</button>';
                    echo '<button type="submit" class="btn btn-block btn-lg btn-warning" name="editaOS" style="margin-top: 20px; margin-bottom: 20px;"><i class="mdi mdi-file-check btn-icon-append"></i> Editar</button>';
                    echo '<button type="submit" class="btn btn-block btn-lg btn-danger" name="limparOS" style="margin-top: 20px; margin-bottom: 20px;"><i class="mdi mdi-reload btn-icon-prepend"></i> Nova Consulta</button>';
                    //<i class="mdi mdi-alert btn-icon-prepend"></i>  
                    echo '</form>';
                    */

                  }

                  
                ?>
                </div>
              </div>
            </div>
          </div>
        
     
    
  

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