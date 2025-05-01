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

        <div class="row">
            

            

            
            
        
            <div class="col-md-4">
                <div class="card">
                <div class="card-header">Dados da Pessoa</div>
                    <div class="card-body" id="pessoa" name="pessoa">
                        <p>id_pessoa: <?php echo $_SESSION['id_pessoa']; ?></p>
                        <p>Nome_pessoa: <?php echo $_SESSION['nome_pessoa']; ?></p>
                        <p>Tel_pessoa: <?php echo $_SESSION['tel_pessoa']; ?></p>
                        <form method="post">
                            <input type="submit" name="limpaPessoa" class="btn btn-danger" value="Limpa Pessoa">
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
        if(isset($_POST['limpaPessoa'])) {
            $_SESSION['id_pessoa'] = '';
            $_SESSION['nome_pessoa'] = '';
            $_SESSION['email_pessoa'] = '';
            $_SESSION['tel_pessoa'] = '';
        }
        
        echo '<script>';
        if(isset($_SESSION['id_pessoa'])){
          echo 'document.getElementById("pessoa").style.display = "block";';
        }else{
          echo 'document.getElementById("pessoa").style.display = "none";';
        }

        
        echo '</script>';

        if(isset($_POST['loggout'])) {
            session_destroy();
            header("Location: pages/samples/login.php");
        }

        
    ?>
</body>
</html>
