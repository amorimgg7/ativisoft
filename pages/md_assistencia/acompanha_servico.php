<?php
session_start();

//http://arteliemalu.lovestoblog.com/?cnpj=123
// Função para pegar parâmetros da URL
// Função para pegar parâmetros da URL
function getParameterByName($name, $url = null) {
    if ($url === null) {
        $url = $_SERVER['REQUEST_URI'];
    }

    $name = preg_quote($name);
    if (preg_match("/[?&]$name=([^&]+)/", $url, $matches)) {
        return urldecode($matches[1]);
    } else {
        return null;
    }
}

$cnpj = getParameterByName('cnpj');
$tel = getParameterByName('tel');

if ($cnpj && $tel) {
    // Armazenar o CNPJ na variável de sessão
    $_SESSION['cnpj_empresa'] = $cnpj;
    
    // Você pode fazer qualquer outra coisa com o telefone aqui
    $_SESSION['contel_cliente'] = $tel;
    
    
    
    // Redirecionar para onde desejar ou exibir uma mensagem de sucesso
    //header('Location: pagina_anterior.php');
    //exit;
} else {
    // Trate o caso em que os valores não foram fornecidos na URL
    //echo "Parâmetros de CNPJ e telefone não encontrados na URL.";
}
?>






<?php 
    session_start();  
//    if(!isset($_SESSION['cd_colab']))
//    {
//        header("location: ../../pages/samples/login.php");
//        exit;
//    }
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
  <title>Histórico de Serviços</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="shortcut icon" href="<?php echo $_SESSION['dominio'].'pages/web/imagens/'.$_SESSION['cnpj_empresa'].'/Logos/LogoEmpresa.jpg'; ?>" /><!--$_SESSION['dominio'].'pages/samples/lock-screen.php';-->

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
        <div class="content-wrapper" <?php echo $_SESSION['c_body'];?>>
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body" id="consulta" style="display: block;">
                  <h4 class="card-title">Acompanhe seu pedido</h4>
                  <p class="card-description">Consulte todos os serviços solicitados através do seu número de telefone!</p>
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
                          <input placeholder="Telefone do Cliente" type="tel" name="contel_cliente" id="contel_cliente" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" required oninput="validateInput(this)">
                          <div class="input-group-append">
                          <!--<span class="input-group-text">.00</span>';-->
                          </div>
                          </div>
                          </div>
                          <p id="error-message" style="color: #DDDDDD;"></p>
                          <script>
                            //function validateInput(inputElement) {
                            //  var inputValue = inputElement.value.replace(/\D/g, ''); // Remove caracteres não numéricos
                            //  var errorMessageElement = document.getElementById("error-message");

                            //  if (inputValue.length === 11) {
                            //    errorMessageElement.textContent = "";//+44 7999 386132
                            //    inputElement.setCustomValidity("");
                            //  } else if (inputValue.length === 10) {
                            //    errorMessageElement.textContent = "Insira um número válido com DDD.";
                            //    inputElement.setCustomValidity("Insira um número válido com DDD.");
                            //  } else if (inputValue.length === 9) {
                            //    errorMessageElement.textContent = "Insira o DDD e o número completo.";
                            //    inputElement.setCustomValidity("Insira o DDD e o número completo.");
                            //  } else {
                            //    errorMessageElement.textContent = "Insira um número válido.";
                            //    inputElement.setCustomValidity("Insira um número válido.");
                            //  }
                            //}

                            //var phoneInput = document.getElementById("contel_cliente");
                            //phoneInput.addEventListener("input", function () {
                            //  validateInput(phoneInput);
                            //});
                          </script>
                          <br>
                          <button type="submit" name="consulta" class="btn btn-block btn-success">Consulta</button>
                        </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php ////session_start();
            if(isset($_SESSION['contel_cliente'])){
              echo '<script>document.getElementById("consulta").style.display = "none";</script>';
            }
            if(isset($_POST['contel_cliente'])){
              $_SESSION['contel_cliente'] = $_POST['cd_pais'].$_POST['contel_cliente'];
            }
            if(isset($_SESSION['contel_cliente'])) {
              $query_select_cliente = "SELECT * FROM tb_cliente WHERE tel_cliente = '".$_SESSION['contel_cliente']."'";
              $result_select_cliente = mysqli_query($conn, $query_select_cliente);
              $row_select_cliente = mysqli_fetch_assoc($result_select_cliente);
              // Exibe as informações do usuário no formulário
              if($row_select_cliente) {
                $_SESSION['acompanha_cd_cliente'] = $row_select_cliente['cd_cliente'];
                $_SESSION['acompanha_pnome_cliente'] = $row_select_cliente['pnome_cliente'];
                $_SESSION['acompanha_snome_cliente'] = $row_select_cliente['snome_cliente'];
                $_SESSION['acompanha_tel_cliente'] = $row_select_cliente['tel_cliente'];
              }          
            }
            if(isset($_SESSION['acompanha_cd_cliente'])){
              echo '<div class="col-12 grid-margin stretch-card">';
              echo '<div class="card">';
              echo '<div class="card-body">';
              echo '<h4 class="card-title">Ficha do cliente</h4>';
                
              echo '<div class="table-responsive">';
              echo '<table class="table">';
              echo '<thead>';
              echo '<tr>';
              echo '<th>Nome completo</th>';
              echo '<th>Telefone</th>';
              echo '</tr>';
              echo '</thead>';
              echo '<tbody>';

              echo '<tr>';
              echo '<td>'.$_SESSION['acompanha_pnome_cliente'].' '.$_SESSION['acompanha_snome_cliente'].'</td>';
              echo '<form method="POST" target="_blank">';
              echo '<td><button type="button" class="btn btn-social-icon-text btn-success" onclick="enviarFichaWhatsApp()" style="margin: 5px;"><i class="mdi mdi-whatsapp"></i>'.$_SESSION['acompanha_tel_cliente'].'</button></td>';
              echo '</form>';
              echo '</tbody>';
              echo '</table>';
              echo '</div>';
              echo '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';

              //echo '<canvas id="pieChart" width="585" height="292" style="display: block; width: 585px; height: 292px;" class="chartjs-render-monitor"></canvas>';
              //echo '<canvas id="pieChart" width="585" height="292"></canvas>';

              //echo '<div class="col-lg-6 grid-margin grid-margin-lg-0 stretch-card">';
              //echo '<div class="card">';
              //echo '  <div class="card-body">';
              echo '    <h4 class="card-title">Gráfico de Serviços</h4>';
              echo '    <canvas id="pieChart"></canvas>';
              //echo '  </div>';
              //echo '</div>';
              //echo '</div>';
                                                                                                                                    //btn btn-lg btn-block btn-outline-info
              echo '<a href="../web/index.php?cnpj='.$_SESSION['cnpj_empresa'].'&tel='.$_SESSION['acompanha_tel_cliente'].'" class="btn btn-lg btn-block btn-social-icon-text btn-outline-success" style="margin: 5px;">Acesse o catálogo do seu prestador de serviços favorito</a>';
              echo '</div>';
              echo '</div>';
              echo '</div>';
            }
          ?>
          <?php
            if(isset($_SESSION['acompanha_cd_cliente'])) {
              //$query_count_0 = "SELECT * FROM tb_servico WHERE status_servico = '0' AND cd_cliente = '".$_SESSION['acompanha_cd_cliente']."'";
              $query_count_0 = "SELECT COUNT(*) as count0 FROM tb_servico WHERE status_servico = '0' AND cd_cliente = '".$_SESSION['acompanha_cd_cliente']."'";
              $query_count_1 = "SELECT COUNT(*) as count1 FROM tb_servico WHERE status_servico = '1' AND cd_cliente = '".$_SESSION['acompanha_cd_cliente']."'";
              $query_count_2 = "SELECT COUNT(*) as count2 FROM tb_servico WHERE status_servico = '2' AND cd_cliente = '".$_SESSION['acompanha_cd_cliente']."'";
              $query_count_3 = "SELECT COUNT(*) as count3 FROM tb_servico WHERE status_servico = '3' AND cd_cliente = '".$_SESSION['acompanha_cd_cliente']."'";

              $result_count_0 = mysqli_query($conn, $query_count_0);
              $result_count_1 = mysqli_query($conn, $query_count_1);
              $result_count_2 = mysqli_query($conn, $query_count_2);
              $result_count_3 = mysqli_query($conn, $query_count_3);

              $row_count_0 = mysqli_fetch_assoc($result_count_0);
              $row_count_1 = mysqli_fetch_assoc($result_count_1);
              $row_count_2 = mysqli_fetch_assoc($result_count_2);
              $row_count_3 = mysqli_fetch_assoc($result_count_3);
              
              // Exibe as informações do usuário no formulário
              ////session_start();
              if($row_count_0['count0'] > 0) {
                $_SESSION['count0'] = $row_count_0['count0'];
                //$_SESSION['count0'] = 25;
              }else{
                $_SESSION['count0'] = 0;
              }
              if($row_count_1['count1'] > 0) {
                $_SESSION['count1'] = $row_count_1['count1'];
                //$_SESSION['count1'] = 25;
              }else{
                $_SESSION['count1'] = 0;
              }
              if($row_count_2['count2'] > 0) {
                $_SESSION['count2'] = $row_count_2['count2'];
                //$_SESSION['count2'] = 25;
              }else{
                $_SESSION['count2'] = 0;
              }
              if($row_count_3['count3'] > 0) {
                $_SESSION['count3'] = $row_count_3['count3'];
                //$_SESSION['count3'] = 25;
                //echo '<script>var count3 = 25;</script>';
              }else{
                $_SESSION['count3'] = 0;
              }
              
              
            }
          ?>
          <script>
                          function enviarFichaWhatsApp() {
                            // Obter os valores dos campos do formulário
                            var nomeCliente = "<?php session_start(); echo $_SESSION['acompanha_pnome_cliente'];?>";
                            var telefoneCliente = "<?php echo $_SESSION['acompanha_tel_cliente'];?>";
                            
                            var count0 = "<?php echo $_SESSION['count0'];?>";
                            var count1 = "<?php echo $_SESSION['count1'];?>";
                            var count2 = "<?php echo $_SESSION['count2'];?>";
                            var count3 = "<?php echo $_SESSION['count3'];?>";
                            

                            
                            var mensagem = "*Olá, " + nomeCliente + "!*\n";
                            mensagem += "*Gráfico dos Serviços:*\n\n";
                            
                            mensagem += "__________________________________";
                            mensagem += "\n";

                            if(count0 > 0){
                              mensagem += "À Fazer:                   ";
                              for (var i = 0; i < count0; i++) {
                                mensagem += "█";
                              }
                              mensagem += count0 + "\n";
                            }

                            if(count1 > 0){
                              mensagem += "Em Andamento:     ";
                              for (var i = 0; i < count1; i++) {
                                mensagem += "█";
                              }
                              mensagem += count1 + "\n";
                            }

                            if(count2 > 0){
                              mensagem += "Finalizado:              ";
                              for (var i = 0; i < count2; i++) {
                                mensagem += "█";
                              }
                              mensagem += count2 + "\n";
                            }

                            if(count3 > 0){
                              mensagem += "Entregue:                ";
                              for (var i = 0; i < count3; i++) {
                                mensagem += "█";
                              }
                              mensagem += count3 + "\n";
                            }
                            
                            
                            
                            <?php
                              $select_entrada_servico = "SELECT * FROM tb_servico WHERE status_servico = 0 AND cd_cliente = '".$_SESSION['acompanha_cd_cliente']."'
                              ORDER BY 
                              CASE 
                              WHEN prioridade_servico = 'U' THEN 1
                              WHEN prioridade_servico = 'A' THEN 2
                              WHEN prioridade_servico = 'M' THEN 3
                              ELSE 4
                              END, cd_servico";
                              $result_entrada_servico = mysqli_query($conn, $select_entrada_servico);
                              $counter = 0;
                              while($row_entrada_servico = $result_entrada_servico->fetch_assoc()) {
                                $counter = $counter + 1;
                                if($counter == 1){
                                  echo 'mensagem += "\n";';
                                  echo 'mensagem += "__________________________________";';
                                  echo 'mensagem += "\n";';
                                  echo 'mensagem += "*Serviços À fazer*\n";';
                                  echo 'mensagem += "*|  OS  |Priori|           Entrada            |*\n";';
                                }
                                if($row_entrada_servico['prioridade_servico'] == "U"){$prioridade = "Urgen";}
                                if($row_entrada_servico['prioridade_servico'] == "A"){$prioridade = "Alta    ";}
                                if($row_entrada_servico['prioridade_servico'] == "M"){$prioridade = "Média";}
                                if($row_entrada_servico['prioridade_servico'] == "B"){$prioridade = "Baixa   ";}
                                //echo 'mensagem += count + " - '.$row_orcamento_whatsapp['titulo_orcamento'].' - '.$row_orcamento_whatsapp['vcusto_orcamento'].'"\n";';
                                ?>mensagem += "<?php echo '*| '.$row_entrada_servico['cd_servico'].'* |'.$prioridade.'| '.date('d/m/y', strtotime($row_entrada_servico['entrada_servico'])); ?>|\n";<?php
                              }
                            ?>

<?php
                              $select_andamento_servico = "SELECT * FROM tb_servico WHERE status_servico = 1 AND cd_cliente = '".$_SESSION['acompanha_cd_cliente']."'
                              ORDER BY 
                              CASE 
                              WHEN prioridade_servico = 'U' THEN 1
                              WHEN prioridade_servico = 'A' THEN 2
                              WHEN prioridade_servico = 'M' THEN 3
                              ELSE 4
                              END, cd_servico";
                              $result_andamento_servico = mysqli_query($conn, $select_andamento_servico);
                              $counter = 0;
                              while($row_andamento_servico = $result_andamento_servico->fetch_assoc()) {
                                $counter = $counter + 1;
                                if($counter == 1){
                                  echo 'mensagem += "\n";';
                                  echo 'mensagem += "__________________________________";';
                                  echo 'mensagem += "\n";';
                                  echo 'mensagem += "*Serviços Em Andamento*\n";';
                                  echo 'mensagem += "*|  OS  |Priori|           Entrada            |*\n";';
                                }
                                if($row_andamento_servico['prioridade_servico'] == "U"){$prioridade = "Urgen";}
                                if($row_andamento_servico['prioridade_servico'] == "A"){$prioridade = "Alta    ";}
                                if($row_andamento_servico['prioridade_servico'] == "M"){$prioridade = "Média";}
                                if($row_andamento_servico['prioridade_servico'] == "B"){$prioridade = "Baixa   ";}
                                //echo 'mensagem += count + " - '.$row_orcamento_whatsapp['titulo_orcamento'].' - '.$row_orcamento_whatsapp['vcusto_orcamento'].'"\n";';
                                ?>mensagem += "<?php echo '*| '.$row_andamento_servico['cd_servico'].'* |'.$prioridade.'| '.date('d/m/y', strtotime($row_andamento_servico['entrada_servico'])); ?>|\n";<?php
                              }
                            ?>
                            <?php
                              $select_finalizado_servico = "SELECT * FROM tb_servico WHERE status_servico = 2 AND cd_cliente = '".$_SESSION['acompanha_cd_cliente']."'
                              ORDER BY 
                              CASE 
                              WHEN prioridade_servico = 'U' THEN 1
                              WHEN prioridade_servico = 'A' THEN 2
                              WHEN prioridade_servico = 'M' THEN 3
                              ELSE 4
                              END, cd_servico";
                              $result_finalizado_servico = mysqli_query($conn, $select_finalizado_servico);
                              $counter = 0;
                              while($row_finalizado_servico = $result_finalizado_servico->fetch_assoc()) {
                                $counter = $counter + 1;
                                if($counter == 1){
                                  echo 'mensagem += "\n";';
                                  echo 'mensagem += "__________________________________";';
                                  echo 'mensagem += "\n";';
                                  echo 'mensagem += "*Serviços Finalizados*\n";';
                                  echo 'mensagem += "*|  OS  |Priori|           Entrada            |*\n";';
                                }
                                if($row_finalizado_servico['prioridade_servico'] == "U"){$prioridade = "Urgen";}
                                if($row_finalizado_servico['prioridade_servico'] == "A"){$prioridade = "Alta    ";}
                                if($row_finalizado_servico['prioridade_servico'] == "M"){$prioridade = "Média";}
                                if($row_finalizado_servico['prioridade_servico'] == "B"){$prioridade = "Baixa   ";}
                                //echo 'mensagem += count + " - '.$row_orcamento_whatsapp['titulo_orcamento'].' - '.$row_orcamento_whatsapp['vcusto_orcamento'].'"\n";';
                                ?>mensagem += "<?php echo '*| '.$row_finalizado_servico['cd_servico'].'* |'.$prioridade.'| '.date('d/m/y', strtotime($row_finalizado_servico['entrada_servico'])); ?>|\n";<?php
                              }
                            ?>
                            <?php
                              $select_entregue_servico = "SELECT * FROM tb_servico WHERE status_servico = 3 AND cd_cliente = '".$_SESSION['acompanha_cd_cliente']."'
                              ORDER BY 
                              CASE 
                              WHEN prioridade_servico = 'U' THEN 1
                              WHEN prioridade_servico = 'A' THEN 2
                              WHEN prioridade_servico = 'M' THEN 3
                              ELSE 4
                              END, cd_servico";
                              $result_entregue_servico = mysqli_query($conn, $select_entregue_servico);
                              $counter = 0;
                              while($row_entregue_servico = $result_entregue_servico->fetch_assoc()) {
                                $counter = $counter + 1;
                                if($counter == 1){
                                  echo 'mensagem += "\n";';
                                  echo 'mensagem += "__________________________________";';
                                  echo 'mensagem += "\n";';
                                  echo 'mensagem += "*Serviços Entregues*\n";';
                                  echo 'mensagem += "*|  OS  |Priori|           Entrada            |*\n";';
                                }
                                if($row_entregue_servico['prioridade_servico'] == "U"){$prioridade = "Urgen";}
                                if($row_entregue_servico['prioridade_servico'] == "A"){$prioridade = "Alta    ";}
                                if($row_entregue_servico['prioridade_servico'] == "M"){$prioridade = "Média";}
                                if($row_entregue_servico['prioridade_servico'] == "B"){$prioridade = "Baixa   ";}
                                //echo 'mensagem += count + " - '.$row_orcamento_whatsapp['titulo_orcamento'].' - '.$row_orcamento_whatsapp['vcusto_orcamento'].'"\n";';
                                ?>mensagem += "<?php echo '*| '.$row_entregue_servico['cd_servico'].'* |'.$prioridade.'| '.date('d/m/y', strtotime($row_entregue_servico['entrada_servico'])); ?>|\n";<?php
                              }
                              echo 'mensagem += "Acompanhe seu histórico pelo link: http://ativisoft.com.br/pages/md_assistencia/acompanha_servico.php?cnpj='.$_SESSION['cnpj_empresa'].'&tel='.$_SESSION['contel_cliente'].'";';
                            ?>


                            
                            
                            // Codificar a mensagem para uso na URL
                            var mensagemCodificada = encodeURIComponent(mensagem);
                            // Construir a URL do WhatsApp
                            var urlWhatsApp = "https://api.whatsapp.com/send?phone=55" + telefoneCliente + "&text=" + mensagemCodificada;
                            // Abrir a janela do WhatsApp com a mensagem preenchida
                            window.open(urlWhatsApp, "_blank");
                          }
                </script>

          <script>
        var ctx = document.getElementById('pieChart').getContext('2d');
        
        var aaa = 26;
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['À Fazer', 'Em Andamento', 'Liberado', 'Retirado / Devolvido'],
                datasets: [{
                    //data: [<?php //echo $_SESSION['count0'].','.$_SESSION['count1'].','.$_SESSION['count2'].','.$_SESSION['count3']?>], // 25% para cada valor
                    data: [<?php echo $_SESSION['count0'];?>,<?php echo $_SESSION['count1'];?>,<?php echo $_SESSION['count2'];?>,<?php echo $_SESSION['count3'];?>], // 25% para cada valor
                    
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)', // Cor para Valor 1
                        'rgba(54, 162, 235, 0.6)', // Cor para Valor 2
                        'rgba(255, 206, 86, 0.6)', // Cor para Valor 3
                        'rgba(75, 192, 192, 0.6)'  // Cor para Valor 4
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false, // Desabilitar responsividade
                maintainAspectRatio: false, // Manter proporção do canvas
                legend: {
                    position: 'bottom'
                }
            }
        });
    </script>
          <div class="row mt-3">
            <div class="col-xl-3 flex-column d-flex grid-margin stretch-card">
              <div class="row flex-grow">

                <?php //À FAZER
                  //"SELECT marca_patrimonio, modelo_patrimonio, COUNT(*) AS total FROM tb_patrimonio WHERE tipo_patrimonio = 'Impressora' GROUP BY marca_patrimonio, modelo_patrimonio";
                  //$sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 0";
                  if(isset($_SESSION['acompanha_cd_cliente'])) {
                    $sql_cliente = "SELECT * FROM tb_cliente WHERE tel_cliente = '".$_SESSION['acompanha_tel_cliente']."'";
                    $result_cliente = mysqli_query($conn, $sql_cliente);
                    $row_cliente = mysqli_fetch_assoc($result_cliente);
                    // Exibe as informações do usuário no formulário
                    if($row_cliente) {
                      echo '<script>document.getElementById("cd_cliente").value = "'.$row_cliente['cd_cliente'].'"</script>';
                      $sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 0 AND cd_cliente = '".$row_cliente['cd_cliente']."'
                        ORDER BY 
                        CASE 
                        WHEN prioridade_servico = 'U' THEN 1
                        WHEN prioridade_servico = 'A' THEN 2
                        WHEN prioridade_servico = 'M' THEN 3
                        ELSE 4
                        END, cd_servico";
                      $resulta_servico = $conn->query($sql_servico);
                      if ($resulta_servico->num_rows > 0){
                        echo '<div class="col-lg-6 grid-margin stretch-card">';
                        echo '<div class="card">';
                        echo '<div class="card-body">';
                        echo '<h4 class="card-title">À FAZER</h4>';
                        echo '<div class="table-responsive">';
                        echo '<table class="table">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th>OS</th>';
                        echo '<th>Prioridade</th>';
                        echo '<th>Prazo</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        while ( $servico = $resulta_servico->fetch_assoc()){
                          echo '<tr>';
                          echo '<td>'.$servico['cd_servico'].'</td>';
                          if($servico['prioridade_servico'] == "B"){
                            echo '<td><label class="badge badge-success">Baixa</label></td>';
                          }
                          if($servico['prioridade_servico'] == "M"){
                            echo '<td><label class="badge badge-info">Média</label></td>';
                          }
                          if($servico['prioridade_servico'] == "A"){
                            echo '<td><label class="badge badge-warning">Alta</label></td>';
                          }
                          if($servico['prioridade_servico'] == "U"){
                            echo '<td><label class="badge badge-danger">Urgente</label></td>';
                          }
                          echo '<td>'.$servico['prazo_servico'].'</td>';
                        }
                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';
                        echo '</div>';
                        //echo '<button type="button" class="btn btn-social-icon-text btn-success" style="margin: 5px;"><i class="mdi mdi-whatsapp"></i>Enviar</button>';
                        //echo '<button type="button" class="btn btn-social-icon-text btn-info" style="margin: 5px;"><i class="mdi mdi-printer"></i>Imprimir</button>';
                        echo '</div>';
                        echo '</div>';
                      }
                    }          
                  }
                ?>

                <?php //EM ANDAMENTO
                  //"SELECT marca_patrimonio, modelo_patrimonio, COUNT(*) AS total FROM tb_patrimonio WHERE tipo_patrimonio = 'Impressora' GROUP BY marca_patrimonio, modelo_patrimonio";
                  //$sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 0";
                  if(isset($_SESSION['acompanha_cd_cliente'])) {
                    $sql_cliente = "SELECT * FROM tb_cliente WHERE tel_cliente = '".$_SESSION['acompanha_tel_cliente']."'";
                    $result_cliente = mysqli_query($conn, $sql_cliente);
                    $row_cliente = mysqli_fetch_assoc($result_cliente);
                    // Exibe as informações do usuário no formulário
                    if($row_cliente) {
                      echo '<script>document.getElementById("cd_cliente").value = "'.$row_cliente['cd_cliente'].'"</script>';
                      $sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 1 AND cd_cliente = '".$row_cliente['cd_cliente']."'
                        ORDER BY 
                        CASE 
                        WHEN prioridade_servico = 'U' THEN 1
                        WHEN prioridade_servico = 'A' THEN 2
                        WHEN prioridade_servico = 'M' THEN 3
                        ELSE 4
                        END, cd_servico";
                      $resulta_servico = $conn->query($sql_servico);
                      if ($resulta_servico->num_rows > 0){
                        echo '<div class="col-lg-6 grid-margin stretch-card">';
                        echo '<div class="card">';
                        echo '<div class="card-body">';
                        echo '<h4 class="card-title">EM ANDAMENTO</h4>';
                        echo '<div class="table-responsive">';
                        echo '<table class="table">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th>OS</th>';
                        echo '<th>Prioridade</th>';
                        echo '<th>Prazo</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        while ( $servico = $resulta_servico->fetch_assoc()){
                          echo '<tr>';
                          echo '<td>'.$servico['cd_servico'].'</td>';
                          if($servico['prioridade_servico'] == "B"){
                            echo '<td><label class="badge badge-success">Baixa</label></td>';
                          }
                          if($servico['prioridade_servico'] == "M"){
                            echo '<td><label class="badge badge-info">Média</label></td>';
                          }
                          if($servico['prioridade_servico'] == "A"){
                            echo '<td><label class="badge badge-warning">Alta</label></td>';
                          }
                          if($servico['prioridade_servico'] == "U"){
                            echo '<td><label class="badge badge-danger">Urgente</label></td>';
                          }
                          echo '<td>'.$servico['prazo_servico'].'</td>';
                        }
                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';
                        echo '</div>';
                        //echo '<button type="button" class="btn btn-social-icon-text btn-success" style="margin: 5px;"><i class="mdi mdi-whatsapp"></i>Enviar</button>';
                        //echo '<button type="button" class="btn btn-social-icon-text btn-info" style="margin: 5px;"><i class="mdi mdi-printer"></i>Imprimir</button>';
                        echo '</div>';
                        echo '</div>';  
                      }
                    }          
                  }
                ?>

                <?php //LIBERADO
                  //"SELECT marca_patrimonio, modelo_patrimonio, COUNT(*) AS total FROM tb_patrimonio WHERE tipo_patrimonio = 'Impressora' GROUP BY marca_patrimonio, modelo_patrimonio";
                  //$sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 0";
                  if(isset($_SESSION['acompanha_cd_cliente'])) {
                    $sql_cliente = "SELECT * FROM tb_cliente WHERE tel_cliente = '".$_SESSION['acompanha_tel_cliente']."'";
                    $result_cliente = mysqli_query($conn, $sql_cliente);
                    $row_cliente = mysqli_fetch_assoc($result_cliente);
                    // Exibe as informações do usuário no formulário
                    if($row_cliente) {
                      echo '<script>document.getElementById("cd_cliente").value = "'.$row_cliente['cd_cliente'].'"</script>';
                      $sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 2 AND cd_cliente = '".$row_cliente['cd_cliente']."'
                        ORDER BY 
                        CASE 
                        WHEN prioridade_servico = 'U' THEN 1
                        WHEN prioridade_servico = 'A' THEN 2
                        WHEN prioridade_servico = 'M' THEN 3
                        ELSE 4
                        END, cd_servico";
                      $resulta_servico = $conn->query($sql_servico);
                      if ($resulta_servico->num_rows > 0){
                        echo '<div class="col-lg-6 grid-margin stretch-card">';
                        echo '<div class="card">';
                        echo '<div class="card-body">';
                        echo '<h4 class="card-title">LIBERADO PARA ENTREGA / DEVOLUÇÃO</h4>';
                        echo '<div class="table-responsive">';
                        echo '<table class="table">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th>OS</th>';
                        echo '<th>Prioridade</th>';
                        echo '<th>Prazo</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        while ( $servico = $resulta_servico->fetch_assoc()){
                          echo '<tr>';
                          echo '<td>'.$servico['cd_servico'].'</td>';
                          if($servico['prioridade_servico'] == "B"){
                            echo '<td><label class="badge badge-success">Baixa</label></td>';
                          }
                          if($servico['prioridade_servico'] == "M"){
                            echo '<td><label class="badge badge-info">Média</label></td>';
                          }
                          if($servico['prioridade_servico'] == "A"){
                            echo '<td><label class="badge badge-warning">Alta</label></td>';
                          }
                          if($servico['prioridade_servico'] == "U"){
                            echo '<td><label class="badge badge-danger">Urgente</label></td>';
                          }
                          echo '<td>'.$servico['prazo_servico'].'</td>';
                        }
                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';
                        echo '</div>';
                        //echo '<button type="button" class="btn btn-social-icon-text btn-success" style="margin: 5px;"><i class="mdi mdi-whatsapp"></i>Enviar</button>';
                        //echo '<button type="button" class="btn btn-social-icon-text btn-info" style="margin: 5px;"><i class="mdi mdi-printer"></i>Imprimir</button>';
                        echo '</div>';
                        echo '</div>';  
                      }
                    }          
                  }
                ?>

                <?php //RETIRADO / DEVOLVIDO
                  //"SELECT marca_patrimonio, modelo_patrimonio, COUNT(*) AS total FROM tb_patrimonio WHERE tipo_patrimonio = 'Impressora' GROUP BY marca_patrimonio, modelo_patrimonio";
                  //$sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 0";
                  if(isset($_SESSION['acompanha_cd_cliente'])) {
                    $sql_cliente = "SELECT * FROM tb_cliente WHERE tel_cliente = '".$_SESSION['acompanha_tel_cliente']."'";
                    $result_cliente = mysqli_query($conn, $sql_cliente);
                    $row_cliente = mysqli_fetch_assoc($result_cliente);
                    // Exibe as informações do usuário no formulário
                    if($row_cliente) {
                      echo '<script>document.getElementById("cd_cliente").value = "'.$row_cliente['cd_cliente'].'"</script>';
                      $sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 3 AND cd_cliente = '".$row_cliente['cd_cliente']."'
                        ORDER BY 
                        CASE 
                        WHEN prioridade_servico = 'U' THEN 1
                        WHEN prioridade_servico = 'A' THEN 2
                        WHEN prioridade_servico = 'M' THEN 3
                        ELSE 4
                        END, cd_servico";
                      $resulta_servico = $conn->query($sql_servico);
                      if ($resulta_servico->num_rows > 0){
                        echo '<div class="col-lg-6 grid-margin stretch-card">';
                        echo '<div class="card">';
                        echo '<div class="card-body">';
                        echo '<h4 class="card-title">RETIRADO / DEVOLVIDO</h4>';
                        
                        echo '<div class="table-responsive">';
                        echo '<table class="table">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th>OS</th>';
                        echo '<th>Prioridade</th>';
                        echo '<th>Prazo</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        while ( $servico = $resulta_servico->fetch_assoc()){
                          echo '<tr>';
                          echo '<td>'.$servico['cd_servico'].'</td>';
                          if($servico['prioridade_servico'] == "B"){
                            echo '<td><label class="badge badge-success">Baixa</label></td>';
                          }
                          if($servico['prioridade_servico'] == "M"){
                            echo '<td><label class="badge badge-info">Média</label></td>';
                          }
                          if($servico['prioridade_servico'] == "A"){
                            echo '<td><label class="badge badge-warning">Alta</label></td>';
                          }
                          if($servico['prioridade_servico'] == "U"){
                            echo '<td><label class="badge badge-danger">Urgente</label></td>';
                          }
                          echo '<td>'.$servico['prazo_servico'].'</td>';
                        }
                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';
                        echo '</div>';
                        //echo '<button type="button" class="btn btn-social-icon-text btn-success" style="margin: 5px;"><i class="mdi mdi-whatsapp"></i>Enviar</button>';
                        //echo '<button type="button" class="btn btn-social-icon-text btn-info" style="margin: 5px;"><i class="mdi mdi-printer"></i>Imprimir</button>';
                        echo '</div>';
                        echo '</div>';  
                      }
                    }          
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