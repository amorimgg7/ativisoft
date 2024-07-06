<?php 
    session_start(); 
    //if(!isset($_SESSION['cd_colab']))
    //{
    //    header("location: ../../pages/samples/login.php");
    //    exit;
    //}
    require_once '../../classes/conn.php';
    include("../../classes/functions.php");
    $u = new Usuario;
    
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
  <title>Abrir Caixa</title>
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
                        <div class="col-sm-12 mb-4 mb-xl-0">
                            <script>
                                document.getElementById("c_body").style = '<?php echo $_SESSION['c_body'];?>';
                                document.getElementById("c_card").style = '<?php echo $_SESSION['c_card'];?>';
                            </script>
                        <p><?php echo $_SESSION['c_body'];?></p>
                        <p><?php echo $_SESSION['c_card'];?></p>
                            <p class="font-weight-normal mb-2 text-muted"><span id="data-atual"></span></p>
                            <script>
                                var data = new Date();
                                var mesPorExtenso = new Intl.DateTimeFormat('pt-BR', { month: 'long' }).format(data).toUpperCase();
                                var dia = data.getDate();
                                var ano = data.getFullYear();
                                document.getElementById("data-atual").innerHTML = 'HOJE É '+dia + ' DE ' + mesPorExtenso + ', ' + ano;
                            </script>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-xl-3 flex-column d-flex grid-margin stretch-card">
                            <div class="row flex-grow">
                                <?php

                                    if(isset($_POST['suprimento_caixa'])){
                                        $insert_suprimento = "INSERT INTO tb_movimento_financeiro(tipo_movimento, cd_caixa_movimento, cd_colab_movimento, fpag_movimento, valor_movimento, data_movimento, obs_movimento) VALUES(
                                            2,
                                            '".$_POST['cd_caixa']."',
                                            '".$_POST['cd_colab']."',
                                            'DINHEIRO',
                                            '".$_POST['valor_suprimento']."',
                                            '".date('Y-m-d H:i')."',
                                            'SANGRIA: ".$_POST['obs_suprimento']."'
                                            )
                                        ";
                                        mysqli_query($conn, $insert_suprimento);
                                        echo "<script>window.alert('Lançar Suprimento!');</script>";
                                        header("location: abertura_caixa.php");
                                        //echo '<script>location.href="../../index.php";</script>';
                                    }

                                    if(isset($_POST['sangria_caixa'])){
                                        $insert_suprimento = "INSERT INTO tb_movimento_financeiro(tipo_movimento, cd_caixa_movimento, cd_colab_movimento, fpag_movimento, valor_movimento, data_movimento, obs_movimento) VALUES(
                                            3,
                                            '".$_POST['cd_caixa']."',
                                            '".$_POST['cd_colab']."',
                                            'DINHEIRO',
                                            '".$_POST['valor_sangria']."',
                                            '".date('Y-m-d H:i', strtotime('+1 hour'))."',
                                            'SANGRIA: ".$_POST['obs_sangria']."'
                                            )
                                        ";
                                        mysqli_query($conn, $insert_suprimento);
                                        echo "<script>window.alert('Lançar Sangria!');</script>";
                                        header("location: abertura_caixa.php");
                                        //echo '<script>location.href="../../index.php";</script>';
                                    }

                                    if($_SESSION['dt_caixa'] == FALSE)
                                    {

                                        // Definir o fuso horário para São Paulo
                                        date_default_timezone_set('America/Sao_Paulo');
                                        //$data_hora_atual = date('Y-m-d H:i:s');

                                        //$dataHoraAtual = date('Y-m-d H:i');
                                        $dataHoraAtual = date('Y-m-d H:i');
                                        echo '<h1>Abrir Caixa (Normal)</h1>';
                                        echo '<div class="col-12 grid-margin stretch-card btn-danger">';
                                        echo '<div class="card" '.$_SESSION['c_card'].'>';
                                        echo '<form method="POST">';
                                        echo '<div class="card-body">';
                                        echo '<h4 class="card-title">Abrir Caixa</h4>';
                                        echo '<div style="display: none;">';
                                        echo '<input value="'.$_SESSION['cd_colab'].'" name="cd_colab_abertura" id="cd_colab_abertura" type="text" class="aspNetDisabled form-control form-control-sm"/>';
                                        echo '<input value="'.$dataHoraAtual.'" name="dt_abertura" id="dt_abertura" type="text" class="aspNetDisabled form-control form-control-sm"/>';
                                        echo '</div>';
                                        echo '<div>';
                                        echo '<input value="'.$_SESSION['pnome_colab'].' '.$_SESSION['snome_colab'].'" class="form-control mb-2 mr-sm-2" readonly>';

                                        echo '<input value="'.date('d/m/y H:i', strtotime($dataHoraAtual)).'" name="btncd_cliente" type="text" id="showcd_cliente" class="aspNetDisabled form-control form-control-sm" readonly/>';
                                                                            
                                                                            
                                        echo '<div class="form-group">';
                                        echo '<div class="input-group">';
                                        echo '<div class="input-group-prepend">';
                                        echo '<span class="input-group-text btn-outline-info">R$:</span>';
                                        echo '</div>'; 
                                        echo '<input name="saldo_abertura" id="saldo_abertura" type="tel" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" placeholder="Valor de abertura de caixa" required oninput="validateInput(this)">';
                                        //echo '<input id="vpag_movimento" name="vpag_movimento" type="tel" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" required oninput="validateInput(this)">';
                                        echo '<span id="error-message" style="color: red;"></span>';

                                        echo '<script>';
                                        echo 'function validateInput(inputElement) {';
                                        echo 'var inputValue = inputElement.value;';
                                        echo 'var errorMessageElement = document.getElementById("error-message");';
                                        echo 'if (isNaN(inputValue) || inputValue < 0) {';
                                        echo 'errorMessageElement.textContent = "Digite um valor numérico maior que 0.";';
                                        echo 'inputElement.setCustomValidity("Digite um valor numérico maior que 0.");';
                                        echo '} else {';
                                        echo 'errorMessageElement.textContent = "";';
                                        echo 'inputElement.setCustomValidity("");';
                                        echo '}';
                                        echo '}';
                                        echo '</script>';
                                                                            
                                        echo '<div class="input-group-append">';
                                        //echo '<span class="input-group-text">.00</span>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '</div>';

                                        echo '</div>';
                                                                            
                                        echo '<button type="submit" name="aberturaNormalCaixa" id="aberturaNormalCaixa" class="btn btn-info btn-lg btn-block btn-danger" style="margin: 5px;"><i class="mdi mdi-file-check"></i>Abra já seu caixa</button>';
                                            
                                        echo '</div>';
                                        echo '</form>';
                                        echo '</div>';     
                                        echo '</div>';


                                        if(isset($_POST['aberturaNormalCaixa'])){
                                            $select_conferirDiaFiscal = "SELECT * FROM tb_caixa_dia_fiscal WHERE status_caixa_dia_fiscal = 2 AND DATE(dt_abertura_dia_fiscal) = '".date('Y-m-d', strtotime($dataHoraAtual))."'";
                                            $result_conferirDiaFiscal = mysqli_query($conn, $select_conferirDiaFiscal);
                                            $row_conferirDiaFiscal = mysqli_fetch_assoc($result_conferirDiaFiscal);
                                            //$row_conferirDiaFiscal = mysqli_fetch_assoc($result_conferirDiaFiscal);
                                            if($row_conferirDiaFiscal) {
                                                echo "<script>window.alert('O dia fiscal ja foi fechado!');</script>";              
                                            }else{
                                                                            
                                            $aberturaNormalCaixa = "INSERT INTO tb_caixa(dt_abertura, cd_colab_abertura, saldo_abertura, status_caixa) VALUES(
                                                '".$_POST['dt_abertura']."',
                                                '".$_POST['cd_colab_abertura']."',
                                                '".$_POST['saldo_abertura']."',
                                                '0')
                                            ";
                                            mysqli_query($conn, $aberturaNormalCaixa);
                                            //echo "<script>window.alert('Caixa Aberto!');</script>";
                                            //echo '<script>location.href="../../index.php";</script>';
                                            
                                            $select_caixa_dia_fiscal = "SELECT * FROM tb_caixa_dia_fiscal WHERE DATE(dt_abertura_dia_fiscal) = '".date('Y-m-d')."'";
                                            $result_caixa_dia_fiscal = mysqli_query($conn, $select_caixa_dia_fiscal);
                                            $row_caixa_dia_fiscal = mysqli_fetch_assoc($result_caixa_dia_fiscal);
                                            if($row_caixa_dia_fiscal) {
                                                //echo "<script>window.alert('Dia fiscal já aberto!');</script>";              
                                            }else{
                                                $aberturaNormalCaixaDiaFiscal = "INSERT INTO tb_caixa_dia_fiscal(dt_abertura_dia_fiscal, status_caixa_dia_fiscal) VALUES(
                                                    '".$_POST['dt_abertura']."',
                                                    '0')
                                                ";
                                                mysqli_query($conn, $aberturaNormalCaixaDiaFiscal);
                                                //echo "<script>window.alert('Acabo de abrir dia fiscal!');</script>";
                                            }
                                            //echo "<script>window.alert('Caixa Aberto!');</script>";
                                            echo '<script>location.href="../../index.php";</script>';
                                            }
                                        }
                                    }

                                    if($_SESSION['dt_caixa'] == "HOJE")
                                    {
                                        if(isset($_POST['listaremover_pagamento'])) {//DELETE FROM `tb_orcamento_servico` WHERE `tb_orcamento_servico`.`cd_orcamento` = 198
                                            //echo "<script>window.alert('OK, pode remover');</script>";
                                            $select_os_movimento = "SELECT * FROM tb_servico WHERE cd_servico = '".$_POST['cd_os_movimento']."'";
                                            $resulta_os_movimento = $conn->query($select_os_movimento);
                                            if ($resulta_os_movimento->num_rows > 0){
                                                while ( $row_os_movimento = $resulta_os_movimento->fetch_assoc()){
                                                $vpagtroco = $row_os_movimento['vpag_servico'] - $_POST['valor_servico'];                                              
                                                }
                                            }

                                            $update_os_movimento = "UPDATE tb_servico SET
                                                vpag_servico = '".$vpagtroco."'
                                            WHERE cd_servico = '".$_POST['cd_os_movimento']."'";
                                            mysqli_query($conn, $update_os_movimento);

                                                                                //cd_os_movimento
                                                                                //cd_movimento
                                                                                //valor_movimento
                                            $removeMovimento = "DELETE FROM tb_movimento_financeiro WHERE cd_movimento = ".$_POST['cd_movimento']."";
                                            mysqli_query($conn, $removeMovimento);
                                        }


                                        echo '<h1>Conferir Caixa (Normal)</h1>';

                                        $select_caixa_hoje = "SELECT * FROM tb_caixa WHERE cd_caixa = '".$_SESSION['cd_caixa']."'";
                                        //echo '<h3>'.$dia_hoje.'</h3>';
                                        //insert into tb_caixa(dt_abertura, cd_colab_abertura, saldo_abertura, status_caixa) VALUES('2023-08-12T13:00','1','15','0')
                                        $resulta_caixa_hoje = $conn->query($select_caixa_hoje);
                                        if ($resulta_caixa_hoje->num_rows > 0){ 
                                            //echo '<div class="col-lg-6 grid-margin stretch-card" style="background-color: #FF0000;">';//dia anterior aberto
                                            echo '<div class="col-12 grid-margin stretch-card btn-success">';//
                                            echo '<div class="card" '.$_SESSION['c_card'].'';
                                            echo '<div class="card-body">';
                                            
                                            echo '<h4 class="card-title">Caixa Aberto - Tudo pronto</h4>';
                                            echo '<div class="table-responsive">';
                                            echo '<table class="table">';
                                            echo '<thead>';
                                            echo '<tr>';
                                            echo '<th>Abertura</th>';
                                            echo '<th>Responsável</th>';
                                            echo '<th>Saldo Abertura</th>';
                                            echo '<th>Saldo Movimento</th>'; 
                                            echo '</tr>';
                                            echo '</thead>';
                                            echo '<tbody>';
                                            
                                            while ( $row_caixa_hoje = $resulta_caixa_hoje->fetch_assoc()){
                                                $_SESSION['cd_caixa'] = $row_caixa_hoje['cd_caixa'];
                                                echo '<tr>';
                                                echo '<td>'.date('d/m/y H:i', strtotime($row_caixa_hoje['dt_abertura'])).'</td>';
                                                //echo '<td>'.$row_caixa['dt_abertura'].'/'.$row_caixa['dt_fechamento'].'</td>';
                                                $select_responsavel_hoje = "SELECT * FROM tb_colab WHERE cd_colab = '".$row_caixa_hoje['cd_colab_abertura']."'";
                                                //insert into tb_caixa(dt_abertura, cd_colab_abertura, saldo_abertura, status_caixa) VALUES('2023-08-12T13:00','1','15','0')
                                                $resulta_responsavel_hoje = $conn->query($select_responsavel_hoje);
                                                while ($row_responsavel_hoje = $resulta_responsavel_hoje->fetch_assoc()){
                                                    echo '<td>'.$row_responsavel_hoje['pnome_colab'].' '.$row_responsavel_hoje['snome_colab'].'</td>';
                                                }
                                                $total_abertura_caixa = $row_caixa_hoje['saldo_abertura'];
                                                echo '<td>R$: '.$row_caixa_hoje['saldo_abertura'].'</td>';
                                            }

                                            echo '</tbody>';
                                            echo '</table>';
                                            echo '</div>';

                                            echo '<h4 class="card-title">Movimentação</h4>';
                                            echo '<div class="table-responsive">';
                                            echo '<table class="table">';
                                            echo '<thead>';
                                            echo '<tr>';
                                            echo '<th>Tipo</th>';
                                            echo '<th>Cliente</th>';
                                            echo '<th>Funcionário</th>';
                                            echo '<th>Valor Movimento</th>';
                                            echo '<th>Forma de Pagamento</th>';
                                            echo '<th>OBS</th>'; 
                                            echo '<th>Remover</th>'; 
                                            echo '</tr>';
                                            echo '</thead>';
                                            echo '<tbody>';
                                            $select_movimento_caixa = "SELECT * FROM tb_movimento_financeiro WHERE cd_caixa_movimento = '".$_SESSION['cd_caixa']."'";
                                            //insert into tb_caixa(dt_abertura, cd_colab_abertura, saldo_abertura, status_caixa) VALUES('2023-08-12T13:00','1','15','0')
                                            $resulta_movimento_caixa = $conn->query($select_movimento_caixa);
                                            while ( $row_movimento_caixa = $resulta_movimento_caixa->fetch_assoc()){
                                                echo '<tr>';
                                                if($row_movimento_caixa['tipo_movimento'] == 1){echo '<td>Receita</td>';}
                                                if($row_movimento_caixa['tipo_movimento'] == 2){echo '<td>Suprimento</td>';}
                                                if($row_movimento_caixa['tipo_movimento'] == 3){echo '<td>Sangria</td>';}
                                                $select_cliente_movimento = "SELECT * FROM tb_cliente WHERE cd_cliente = '".$row_movimento_caixa['cd_cliente_movimento']."'";
                                                $resulta_cliente_movimento = $conn->query($select_cliente_movimento);
                                                if ( $row_cliente_movimento = $resulta_cliente_movimento->fetch_assoc()){
                                                    echo '<td>'.$row_cliente_movimento['pnome_cliente'].' '.$row_cliente_movimento['snome_cliente'].'</td>';
                                                }else{echo '<td>- - - -</td>';}
                                                $select_colab_movimento = "SELECT * FROM tb_colab WHERE cd_colab = '".$row_movimento_caixa['cd_colab_movimento']."'";
                                                $resulta_colab_movimento = $conn->query($select_colab_movimento);
                                                while ( $row_colab_movimento = $resulta_colab_movimento->fetch_assoc()){
                                                    echo '<td>'.$row_colab_movimento['pnome_colab'].' '.$row_colab_movimento['snome_colab'].'</td>';
                                                }
                                                echo '<td>R$: '.$row_movimento_caixa['valor_movimento'].'</td>';
                                                echo '<td>'.$row_movimento_caixa['fpag_movimento'].'</td>';
                                                echo '<td>'.$row_movimento_caixa['obs_movimento'].'</td>';

                                                echo '<form method="POST">';
                                                echo '<td style="display:none;"><input type="tel" value="'.$row_movimento_caixa['cd_movimento'].'" id="cd_movimento" name="cd_movimento"></td>';
                                                echo '<td style="display:none;"><input type="tel" value="'.$row_movimento_caixa['cd_os_movimento'].'" id="cd_os_movimento" name="cd_os_movimento" ></td>';
                                                echo '<td style="display:none;"><input type="tel" value="'.$row_movimento_caixa['valor_movimento'].'" id="valor_servico" name="valor_servico"></td>';
                                                echo '<td><button type="submit" name="listaremover_pagamento" id="listaremover_pagamento" class="btn btn-danger">X</button></td>';
                                                echo '</form>';
                                            }
                                            echo '</tbody>';
                                            echo '</table>';
                                            echo '</div>';

                                            echo '<h4 class="card-title">Totalizadores</h4>';
                                            echo '<div class="table-responsive">';
                                            echo '<table class="table">';
                                            echo '<thead>';
                                            echo '<tr>';

                                            

                                            echo '<th>Débito</th>';
                                            echo '<th>Crédito</th>';
                                            echo '<th>Pix</th>';
                                            echo '<th>Dinheiro</th>';
                                            echo '<th>Cofre</th>';
                                            echo '<th>Suprimento</th>';
                                            echo '<th>Sangria</th>';
                                            echo '<th>Movimento</th>';
                                            echo '<th>Total</th>';
                                            
                                            echo '</tr>';
                                            echo '</thead>';
                                            echo '<tbody>';
                                            
                                            echo '<tr>';

                                            $select_debito_caixa = "SELECT * FROM tb_movimento_financeiro WHERE fpag_movimento = 'DEBITO' AND cd_caixa_movimento = '".$_SESSION['cd_caixa']."'";
                                            $resulta_debito_caixa = $conn->query($select_debito_caixa);
                                            $total_debito = 0;
                                            while ( $row_debito_caixa = $resulta_debito_caixa->fetch_assoc()){
                                                $total_debito = $row_debito_caixa['valor_movimento'] + $total_debito;
                                            }
                                            $select_credito_caixa = "SELECT * FROM tb_movimento_financeiro WHERE fpag_movimento = 'CREDITO' AND cd_caixa_movimento = '".$_SESSION['cd_caixa']."'";
                                            $resulta_credito_caixa = $conn->query($select_credito_caixa);
                                            $total_credito = 0;
                                            while ( $row_credito_caixa = $resulta_credito_caixa->fetch_assoc()){
                                                $total_credito = $row_credito_caixa['valor_movimento'] + $total_credito;
                                            }
                                            $select_pix_caixa = "SELECT * FROM tb_movimento_financeiro WHERE fpag_movimento = 'PIX' AND cd_caixa_movimento = '".$_SESSION['cd_caixa']."'";
                                            $resulta_pix_caixa = $conn->query($select_pix_caixa);
                                            $total_pix = 0;
                                            while ( $row_pix_caixa = $resulta_pix_caixa->fetch_assoc()){
                                                $total_pix = $row_pix_caixa['valor_movimento'] + $total_pix;
                                            }
                                            $select_dinheiro_caixa = "SELECT * FROM tb_movimento_financeiro WHERE fpag_movimento = 'DINHEIRO' AND tipo_movimento = '1' AND cd_caixa_movimento = '".$_SESSION['cd_caixa']."'";
                                            $resulta_dinheiro_caixa = $conn->query($select_dinheiro_caixa);
                                            $total_dinheiro = 0;
                                            while ( $row_dinheiro_caixa = $resulta_dinheiro_caixa->fetch_assoc()){
                                                $total_dinheiro = $row_dinheiro_caixa['valor_movimento'] + $total_dinheiro;
                                            }
                                            
                                            $select_cofre_caixa = "SELECT * FROM tb_movimento_financeiro WHERE fpag_movimento = 'COFRE' AND tipo_movimento = '1' AND cd_caixa_movimento = '".$_SESSION['cd_caixa']."'";
                                            $resulta_cofre_caixa = $conn->query($select_cofre_caixa);
                                            $total_cofre = 0;
                                            while ( $row_cofre_caixa = $resulta_cofre_caixa->fetch_assoc()){
                                                $total_cofre = $row_cofre_caixa['valor_movimento'] + $total_cofre;
                                            }


                                            $select_suprimento_caixa = "SELECT * FROM tb_movimento_financeiro WHERE fpag_movimento = 'DINHEIRO' AND tipo_movimento = '2' AND cd_caixa_movimento = '".$_SESSION['cd_caixa']."'";
                                            $resulta_suprimento_caixa = $conn->query($select_suprimento_caixa);
                                            $total_suprimento_caixa = 0;
                                            while ( $row_suprimento_caixa = $resulta_suprimento_caixa->fetch_assoc()){
                                                $total_suprimento_caixa = $row_suprimento_caixa['valor_movimento'] + $total_suprimento_caixa;
                                            }
                                            $select_sangria_caixa = "SELECT * FROM tb_movimento_financeiro WHERE fpag_movimento = 'DINHEIRO' AND tipo_movimento = '3' AND cd_caixa_movimento = '".$_SESSION['cd_caixa']."'";
                                            $resulta_sangria_caixa = $conn->query($select_sangria_caixa);
                                            $total_sangria_caixa = 0;
                                            while ( $row_sangria_caixa = $resulta_sangria_caixa->fetch_assoc()){
                                                $total_sangria_caixa = $row_sangria_caixa['valor_movimento'] + $total_sangria_caixa;
                                            }


                                            //echo '<td>R$: '.$total_fpag[''.$column_name.''].'</td>';
                                            echo '<td>R$: '.$total_debito.'</td>';
                                            echo '<td>R$: '.$total_credito.'</td>';
                                            echo '<td>R$: '.$total_pix.'</td>';
                                            echo '<td>R$: '.$total_dinheiro.'</td>';
                                            echo '<td>R$: '.$total_cofre.'</td>';
                                            echo '<td>R$: '.$total_suprimento_caixa.'</td>';
                                            echo '<td>R$: '.$total_sangria_caixa.'</td>';
                                            $total_tudo = ($total_debito + $total_credito + $total_pix + $total_dinheiro + $total_cofre + $total_suprimento_caixa) - $total_sangria_caixa;
                                            echo '<td>R$: '.$total_tudo.'</td>';
                                            echo '<td>R$: '.($total_tudo + $total_abertura_caixa).'</td>';


                                            echo '</tr>';
                                            echo '</tbody>';
                                            echo '</table>';
                                            echo '</div>';

                                            


                                            
                                            echo '<button type="button" class="btn btn-md btn-block btn-rounded btn-outline-danger" style="margin-top: 5px;" onclick="abrirSangria()"><i class="mdi mdi-upload btn-icon-prepend"></i>Sangria</button>';
                                            
                                            echo '<button type="button" class="btn btn-md btn-block btn-rounded btn-outline-success" style="margin-top: 5px;" onclick="abrirSuprimento()"><i class="mdi mdi-file-check btn-icon-append"></i>Suprimento</button>';
  
                                            ////echo '<button type="button" class="btn btn-md btn-block btn-rounded btn-outline-dark" style="margin-top: 5px;" onclick="abrirFerramentas()"><i class="mdi mdi-file-check btn-icon-append"></i>Ferramentas do Caixa</button>';

                                            echo '<form action="fechamento_caixa.php" method="POST">';
                                            echo '<button type="submit" class="btn btn-lg btn-block btn-danger" style="margin-top: 5px;"><i class="mdi mdi-file-check"></i>Fechar Caixa</button>';
                                            echo '</form>';
        
                                            echo '<script>';
                                            echo 'function abrirSangria() {';
                                            echo 'document.getElementById("sangria_caixa").style.display = "block";';
                                            echo 'document.getElementById("suprimento_caixa").style.display = "none";';
                                            ////echo 'document.getElementById("ferramentas_caixa").style.display = "none";';
                                            echo 'window.scrollTo(0, document.body.scrollHeight);';
                                            
                                            echo '}';
                                            echo 'function abrirSuprimento() {';
                                            echo 'document.getElementById("sangria_caixa").style.display = "none";';
                                            echo 'document.getElementById("suprimento_caixa").style.display = "block";';
                                            ////echo 'document.getElementById("ferramentas_caixa").style.display = "none";';
                                            echo 'window.scrollTo(0, document.body.scrollHeight);';

                                            
                                            echo '}';

                                            echo 'function abrirFerramentas() {';
                                            echo 'document.getElementById("sangria_caixa").style.display = "none";';
                                            echo 'document.getElementById("suprimento_caixa").style.display = "none";';
                                            ////echo 'document.getElementById("ferramentas_caixa").style.display = "block";';
                                            echo 'window.scrollTo(0, document.body.scrollHeight);';
    
                                                
                                                echo '}';
                                            echo '</script>';



                                            
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                        }
                                    }

                                    if($_SESSION['dt_caixa'] == "ONTEM")
                                    {
                                        echo '<h1 '.$_SESSION['c_card'].'>Fechar Caixa (Dia fiscal ontem)</h1>';
                                    }

                                    if($_SESSION['dt_caixa'] == "ANTERIOR")
                                    {
                                        echo '<h1 '.$_SESSION['c_card'].'>Fechar Caixa (Dia fiscal anterior)</h1>';
                                    }
                                ?>
                                
                                <?php
                                    $_SESSION['tela_movimento_financeiro'] = NULL;
                                    if(isset($_POST['show_suprimento_caixa'])){
                                        $_SESSION['tela_movimento_financeiro'] = "SUPRIMENTO";
                                    }
                                    if(isset($_POST['show_sangria_caixa'])){
                                        $_SESSION['tela_movimento_financeiro'] = "SANGRIA";
                                    }

                                    //echo '<div class="col-12 grid-margin stretch-card btn-success">';//
                                    //echo '<div class="card">';
                                    //echo '<div class="card-body">';
                                    
                                    include("../../pages/md_caixa/movimento_financeiro.php");
                                    //echo '</div>';
                                    //echo '</div>';
                                    //echo '</div>';

                                ?>
                                
                            </div>
                        </div>
                    </div>
                    
                </div>
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