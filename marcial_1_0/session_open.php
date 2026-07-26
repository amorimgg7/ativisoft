<?php
    session_start();
    require_once 'classes/conn.php';
    $cd_filial = isset($_GET['cd_filial']) ? intval($_GET['cd_filial']) : 0;
        if ($cd_filial > 0) {
            $response = [];
            // 1. Pega todas as tabelas do banco
            $tablesResult = $conn->query("SHOW TABLES");
            if ($tablesResult->num_rows > 0) {
                while ($tableRow = $tablesResult->fetch_array()) {
                    $tableName = $tableRow[0];
                    // 2. Monta SELECT
                    if ($cd_filial > 0 && in_array($tableName, ['tb_pessoa','tb_empresa'])) {
                        // se a tabela tiver campo cd_filial, filtra
                        $sql = "SELECT * FROM $tableName";
                        //$sql = "SELECT * FROM $tableName WHERE cd_filial = $cd_filial ";
                    } else if($cd_filial > 0 && in_array($tableName, ['tb_empresa','tb_reserva'])){
                        //$sql = "SELECT * FROM $tableName WHERE cd_empresa = $cd_filial ";
                        $sql = "SELECT * FROM $tableName";
                    }else {
                        $sql = "SELECT * FROM $tableName";
                    }

                    $result = $conn->query($sql);
                    $tableData = [];

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // opcional: adiciona timestamp de sync em todas as linhas
                            $row['dt_sync'] = date('Y-m-d H:i:s');
                            $tableData[] = $row;
                        }
                    }

                    // adiciona os dados da tabela no response
                    $response[$tableName] = $tableData;
                }
            }

            // Retorna JSON
            //echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_INVALID_UTF8_SUBSTITUTE);
            //echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT, 512);


            //header('Content-Type: application/json; charset=utf-8');
            //echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

            //echo json_last_error_msg();

            //exit;



            // Garante cabeçalho
header('Content-Type: application/json; charset=utf-8');

// Converte em JSON
$json = json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_INVALID_UTF8_SUBSTITUTE);

// Verifica se houve erro
if ($json === false) {
    echo json_encode([
        "error" => "Falha ao gerar JSON",
        "msg"   => json_last_error_msg()
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

echo $json;

exit;


        }else{
            //die(json_encode(["alert" => "Geral"]));
        }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv='refresh' content='2000'>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dados do Sistema</title>

    <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="vendors/feather/feather.css">
    <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
    <link rel="stylesheet" href="css/style.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center">Informações em Memória</h2>
            </div>
        </div>

        <?php
            //session_start(); // sempre comece com isso
            

            



            ksort($_SESSION); // ordena as chaves em ordem alfabética

            echo '<pre>';
            print_r($_SESSION);
            echo '</pre>';



            
            
            

           






    

        ?>



        <div class="row">

            <!-- Card OS Lista -->

            <div class="col-md-4">
                <div class="card">
                  <div class="card-header">Dados do Usuário</div>
                    <div class="card-body" id="colaborador">
                        <p>cd_pessoa: <?php echo $_SESSION['cd_pessoa']; ?></p>
                        <p>email_pessoa: <?php echo $_SESSION['email_pessoa']; ?></p>
                        <p>pnome_pessoa: <?php echo $_SESSION['pnome_pessoa']; ?></p>
                        <p>snome_pessoa: <?php echo $_SESSION['snome_pessoa']; ?></p>
                        <form method="post">
                            <input type="submit" name="limpaUsuario" class="btn btn-danger" value="Limpa Usuário">
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                <div class="card-header">Dados da Empresa</div>
                    <div class="card-body" id="empresa">
                        <p>cd_empresa: <?php echo $_SESSION['cd_empresa']; ?></p>
                        <p>CNPJ: <?php echo $_SESSION['cnpj_empresa']; ?></p>
                        <p>Nome Fantasia: <?php echo $_SESSION['nfantasia_empresa']; ?></p>
                        <p>Razão Social: <?php echo $_SESSION['rsocial_empresa']; ?></p>
                        <form method="post">
                            <input type="submit" name="limpaEmpresa" class="btn btn-danger" value="Limpa Empresa">
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                <div class="card-header">Dados da Filial</div>
                    <div class="card-body" id="filial">
                        <p>Nome Fantasia: <?php echo $_SESSION['nfantasia_filial']; ?></p>
                        <p>CNPJ: <?php echo $_SESSION['cnpj_filial']; ?></p>
                        <p>Email: <?php echo $_SESSION['email_filial']; ?></p>
                        <p>Endereço: <?php echo $_SESSION['endereco_filial']; ?></p>
                        <p>Saudações: <?php echo $_SESSION['saudacoes_filial']; ?></p> 
                        <form method="post">
                            <input type="submit" name="limpaFilial" class="btn btn-danger" value="Limpa Filial">
                        </form>
                    </div>
                </div>
            </div>
            
        
            <div class="col-md-4">
                <div class="card">
                <div class="card-header">Dados do Cliente</div>
                    <div class="card-body" id="cliente">
                        <p>cd_cliente: <?php echo $_SESSION['cd_cliente']; ?></p>
                        <p>Nome: <?php echo $_SESSION['pnome_cliente'] . ' ' . $_SESSION['snome_cliente']; ?></p>
                        <p>Telefone: <?php echo $_SESSION['tel_cliente']; ?></p>
                        <form method="post">
                            <input type="submit" name="limpaCliente" class="btn btn-danger" value="Limpa Cliente">
                        </form>
                    </div>
                </div>
            </div>

            
            <div class="col-md-4">
                <div class="card">
                <div class="card-header">Dados do Caixa</div>
                    <div class="card-body" id="caixa">
                        <p>cd_Caixa: <?php echo $_SESSION['cd_caixa']; ?></p>
                        <p>Abertura: <?php echo $_SESSION['dt_caixa']; ?></p>
                        <form method="post">
                            <input type="submit" name="limpaCaixa" class="btn btn-danger" value="Limpa Caixa">
                        </form>
                    </div>
                </div>
            </div>
       
            

            <div class="col-md-4">
                <div class="card">
                  <div class="card-header">Dados do Serviço</div>
                    <div class="card-body" id="servico">
                        <p>cd_servico: <?php echo $_SESSION['cd_servico']; ?></p>
                        <p>Título: <?php echo $_SESSION['titulo_servico']; ?></p>
                        <p>Prioridade: <?php echo $_SESSION['prioridade_servico']; ?></p>
                        <form method="post">
                            <input type="submit" name="limpaServico" class="btn btn-danger" value="Limpa Serviço">
                        </form>
                    </div>
                </div>
            </div>


<!--
            <div class="col-md-4">
                <div class="card">
                  <div class="card-header">Estilo</div>
                    <div class="card-body" id="estilo">
                        <p>cd_estilo: <?php //echo $_SESSION['cd_estilo']; ?></p>
                        <p>c_font: <?php //echo $_SESSION['c_font']; ?></p>
                        <p>c_nav: --<?php //echo $_SESSION['c_nav']; ?>--</p>
                        <p>c_sidebar: --<?php //echo $_SESSION['c_sidebar']; ?>--</p>
                        <p>titulo_estilo: --<?php //echo $_SESSION['titulo_estilo']; ?>--</p>
                        <p>t_font: <?php //echo $_SESSION['t_font']; ?></p>
                        <p>t_navbar: <?php //echo $_SESSION['t_navbar']; ?></p>
                        <p>t_sidebar: <?php //echo $_SESSION['t_sidebar']; ?></p>
                        <form method="post">
                            <input type="submit" name="limpaUsuario" class="btn btn-danger" value="Limpa Usuário">
                        </form>
                    </div>
                </div>
            </div>
-->

        </div>

        
        <div class="row mt-4">
            <div class="col-md-12 text-center">
                <form method="post">
                    <input type="submit" name="loggout" class="btn btn-warning" value="Logout">
                </form>
            </div>
        </div>
    </div>

    <?php
        if(isset($_POST['limpaUsuario'])) {
            $_SESSION['cd_pessoa'] = '';
            $_SESSION['email_pessoa'] = '';
            $_SESSION['pnome_pessoa'] = '';
            $_SESSION['snome_pessoa'] = '';
        }
        if(isset($_POST['limpaEmpresa'])) {
          $_SESSION['cd_empresa'] = '';
          $_SESSION['cnpj_empresa'] = '';
          $_SESSION['rsocial_empresa'] = '';
        }
        if(isset($_POST['limpaCliente'])) {
            $_SESSION['cd_cliente'] = '';
            $_SESSION['pnome_cliente'] = '';
            $_SESSION['snome_cliente'] = '';
            $_SESSION['tel_cliente'] = '';
        }
        if(isset($_POST['limpaFilial'])) {
            $_SESSION['nfantasia_filial'] = '';
            $_SESSION['cnpj_filial'] = '';
            $_SESSION['email_filial'] = '';
        }
        if(isset($_POST['limpaServico'])) {
            $_SESSION['cd_servico'] = '';
            $_SESSION['titulo_servico'] = '';
            $_SESSION['prioridade_servico'] = '';
        }
        if(isset($_POST['loggout'])) {
            session_destroy();
            header("Location: login.php");
        }

        echo '<script>';
        if(isset($_SESSION['cd_pessoa'])){
          echo 'document.getElementById("colaborador").style.display = "block";';
        }else{
          echo 'document.getElementById("colaborador").style.display = "none";';
        }

        if(isset($_SESSION['cd_caixa'])){
          echo 'document.getElementById("caixa").style.display = "block";';
        }else{
          echo 'document.getElementById("caixa").style.display = "none";';
        }

        if(isset($_SESSION['cd_cliente'])){
          echo 'document.getElementById("cliente").style.display = "block";';
        }else{
          echo 'document.getElementById("cliente").style.display = "none";';
        }

        if(isset($_SESSION['cd_empresa'])){
          echo 'document.getElementById("empresa").style.display = "block";';
        }else{
          echo 'document.getElementById("empresa").style.display = "none";';
        }

        if(isset($_SESSION['cd_filial'])){
          echo 'document.getElementById("filial").style.display = "block";';
        }else{
          echo 'document.getElementById("filial").style.display = "none";';
        }

        if(isset($_SESSION['cd_servico'])){
          echo 'document.getElementById("servico").style.display = "block";';
        }else{
          echo 'document.getElementById("servico").style.display = "none";';
        }
        echo '</script>';
    ?>
</body>
</html>
