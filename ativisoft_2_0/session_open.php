<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv='refresh' content='2'>
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
<?php
session_start();?>
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
            <div class="col-md-4">
                <div class="card">
                  <div class="card-header">Dados do Usuário</div>
                    <div class="card-body" id="colaborador">
                        <p>cd_colab: <?php echo $_SESSION['cd_colab']; ?></p>
                        <p>pnome_colab: <?php echo $_SESSION['pnome_colab']; ?></p>
                        <p>snome_colab: <?php echo $_SESSION['snome_colab']; ?></p>
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



            <div class="col-md-4">
                <div class="card">
                  <div class="card-header">Estilo</div>
                    <div class="card-body" id="estilo">
                        <p>cd_estilo: <?php echo $_SESSION['cd_estilo']; ?></p>
                        <p>c_font: <?php echo $_SESSION['c_font']; ?></p>
                        <p>c_nav: --<?php //echo $_SESSION['c_nav']; ?>--</p>
                        <p>c_sidebar: --<?php echo $_SESSION['c_sidebar']; ?>--</p>
                        <p>titulo_estilo: --<?php //echo $_SESSION['titulo_estilo']; ?>--</p>
                        <p>t_font: <?php echo $_SESSION['t_font']; ?></p>
                        <p>t_navbar: <?php echo $_SESSION['t_navbar']; ?></p>
                        <p>t_sidebar: <?php echo $_SESSION['t_sidebar']; ?></p>
                        <form method="post">
                            <input type="submit" name="limpaUsuario" class="btn btn-danger" value="Limpa Usuário">
                        </form>
                    </div>
                </div>
            </div>


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
            $_SESSION['cd_colab'] = '';
            $_SESSION['pnome_colab'] = '';
            $_SESSION['snome_colab'] = '';
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
        if(isset($_SESSION['cd_colab'])){
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
