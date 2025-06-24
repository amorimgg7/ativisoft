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
  <title>Fechar Caixa</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <!-- endinject -->
  <script src="../../js/functions.js"></script>
  <link rel="shortcut icon" href="<?php //echo $_SESSION['logo_empresa']; ?>" />
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
                                    if($_SESSION['dt_caixa'] == FALSE)
                                    {
                                        //$dataHoraAtual = date('Y-m-d H:i');
                                        $dataHoraAtual = date('Y-m-d H:i', strtotime('+1 hour'));
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
                                        echo '<input name="saldo_abertura" id="saldo_abertura" type="tel" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" placeholder="Valor de abertura de caixa" required>';
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
                                    }
                                    if($_SESSION['dt_caixa'] == "HOJE")
                                    {
                                        echo '<h1>Fechar Caixa (Normal)</h1>';

                                        //$dataHoraAtual = date('Y-m-d H:i');
                                        $dataHoraAtual = date('Y-m-d H:i', strtotime('+1 hour'));

                                        

                                       
                                        echo '<div class="col-12 grid-margin stretch-card btn-success">';
                                        
                                        echo '<div class="card" '.$_SESSION['c_card'].'>';
                                        echo '<form method="POST">';
                                        echo '<div class="card-body">';

                                        echo '<h4 class="card-title">Dados do Caixa</h4>';

                                        $select_caixa = "SELECT * FROM tb_caixa WHERE cd_filial = ".$_SESSION['cd_empresa']." AND cd_caixa = '".$_SESSION['cd_caixa']."'";
                                            $resulta_caixa = $conn->query($select_caixa);
                                            $total_caixa = 0;
                                            while ( $row_caixa = $resulta_caixa->fetch_assoc()){
                                                echo '<div style="display: none;">';
                                                echo '<label for="cd_caixa">cd_caixa</label>';
                                                echo '<input type="text" name="cd_caixa" id="cd_caixa" value="'.$row_caixa['cd_caixa'].'" class="aspNetDisabled form-control form-control-sm" placeholder="Título do serviço" readonly>';
                            
                                                echo '<label for="dt_abertura">abertura</label>';
                                                echo '<input type="text" name="dt_abertura" id="dt_abertura" value="'.$row_caixa['dt_abertura'].'" class="aspNetDisabled form-control form-control-sm" placeholder="Título do serviço" readonly>';

                                                echo '<label for="cd_colab_abertura">Responsável</label>';
                                                echo '<input type="text" name="cd_colab_abertura" id="cd_colab_abertura" value="'.$row_caixa['cd_colab_abertura'].'" class="aspNetDisabled form-control form-control-sm" placeholder="Título do serviço" readonly>';
                                                echo '</div>';

                                                echo '<label for="show_dt_abertura">abertura</label>';
                                                echo '<input type="text" name="show_dt_abertura" id="show_dt_abertura" value="'.date('d/m/y H:i', strtotime($row_caixa['dt_abertura'])).'" class="aspNetDisabled form-control form-control-sm" placeholder="Título do serviço" readonly>';
                                                
                                                
                                                $select_caixa_colab = "SELECT * FROM tb_pessoa WHERE cd_pessoa = '".$row_caixa['cd_colab_abertura']."'";
                                                $resulta_caixa_colab = $conn->query($select_caixa_colab);
                                                
                                                while ( $row_caixa_colab = $resulta_caixa_colab->fetch_assoc()){
                                                    echo '<label for="show_nome_colab_abertura">Responsável</label>';
                                                    echo '<input type="text" name="show_nome_colab_abertura" id="show_nome_colab_abertura" value="'.$row_caixa_colab['pnome_pessoa'].' '.$row_caixa_colab['snome_colab'].'" class="aspNetDisabled form-control form-control-sm" placeholder="Título do serviço" readonly>';
                                                }
                                                $total_abertura_caixa = $row_caixa['saldo_abertura'];
                                            }
                                            echo '<h4 class="card-title">Fechar Caixa - Conferência de Caixa</h4>';
                                        
                                            echo '<div style="display: none;">';
                                            echo '<input value="'.$_SESSION['cd_colab'].'" name="cd_colab_fechamento" id="cd_colab_fechamento" type="text" class="aspNetDisabled form-control form-control-sm"/>';
                                            echo '<input value="'.$dataHoraAtual.'" name="dt_fechamento" id="dt_fechamento" type="text" class="aspNetDisabled form-control form-control-sm"/>';
                                        
                                            echo '</div>';
                                            echo '<div>';
                                            echo '<input value="'.$_SESSION['pnome_colab'].' '.$_SESSION['snome_colab'].'" name="show_nome_colab_fechamento" id="show_nome_colab_fechamento" class="form-control mb-2 mr-sm-2" readonly>';

                                            echo '<input value="'.date('d/m/y H:i', strtotime($dataHoraAtual)).'" name="show_dt_fechamento" id="show_dt_fechamento" type="text"  class="aspNetDisabled form-control form-control-sm" readonly/>';
                                        
                                        
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

                                            //$total_tudo = $total_debito + $total_credito + $total_pix + $total_dinheiro;
                                            
                                            $total_tudo = ($total_debito + $total_credito + $total_pix + $total_dinheiro + $total_suprimento_caixa) - $total_sangria_caixa;
                                            



                                            


                                            echo '<div name="analitico" style="display:block;">';
                                            echo '<h4 class="card-title">Caixa Analítico</h4>';
                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">ABERTURA:</span>';
                                            echo '</div>'; 
                                            echo '<input type="tel" id="suprimento_analitico" name="suprimento_analitico" value="'.$total_abertura_caixa.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" oninput="calculateTotal()" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">ANALÍTICO</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">DEBITO:</span>';
                                            echo '</div>'; 
                                            echo '<input type="tel" id="debito_analitico" name="debito_analitico" value="'.$total_debito.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" oninput="calculateTotal()" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">ANALÍTICO</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">CREDITO:</span>';
                                            echo '</div>'; 
                                            echo '<input type="tel" id="credito_analitico" name="credito_analitico" value="'.$total_credito.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" oninput="calculateTotal()" readonly>'; 
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">ANALÍTICO</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">PIX:</span>';
                                            echo '</div>'; 
                                            echo '<input type="tel" id="pix_analitico" name="pix_analitico" value="'.$total_pix.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" oninput="calculateTotal()" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">ANALÍTICO</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">DINHEIRO:</span>';
                                            echo '</div>';
                                            //$total_dinheiro = $total_abertura_caixa + $total_dinheiro;
                                            echo '<input type="tel" id="dinheiro_analitico" name="dinheiro_analitico" value="'.$total_dinheiro.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" oninput="calculateTotal()" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">ANALÍTICO</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">COFRE:</span>';
                                            echo '</div>';
                                            //$total_dinheiro = $total_abertura_caixa + $total_dinheiro;
                                            echo '<input type="tel" id="cofre_analitico" name="cofre_analitico" value="'.$total_cofre.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" oninput="calculateTotal()" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">ANALÍTICO</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">SUPRIMENTO:</span>';
                                            echo '</div>'; 
                                            echo '<input id="total_suprimento_analitico" name="total_suprimento_analitico" type="tel" value="'.$total_suprimento_caixa.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" placeholder="Valor de abertura de caixa" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">ANALÍTICO</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">SANGRIA:</span>';
                                            echo '</div>'; 
                                            echo '<input id="total_sangria_analitico" name="total_sangria_analitico" type="tel" value="'.$total_sangria_caixa.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" placeholder="Valor de abertura de caixa" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">ANALÍTICO</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">MOVIMENTO</span>';
                                            echo '</div>'; 
                                            echo '<input id="total_movimento_analitico" name="total_movimento_analitico" type="tel" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" placeholder="Valor de abertura de caixa" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">DIFERENÇA</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                            

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">TOTAL:</span>';
                                            echo '</div>'; 
                                            echo '<input id="total_caixa_analitico" name="total_caixa_analitico" type="tel" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" placeholder="Valor de abertura de caixa" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">ANALÍTICO</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';



                                            echo '<div name="caixa_conferido" style="display: block">';
                                            echo '<h4 class="card-title">Caixa Conferido</h4>';
                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">DEBITO:</span>';
                                            echo '</div>'; 
                                            echo '<input type="tel" id="debito_conferido" name="debito_conferido"value="'.$total_debito.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" oninput="calculateTotal()" required>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">CONFIRA</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">CREDITO:</span>';
                                            echo '</div>'; 
                                            echo '<input type="tel" id="credito_conferido" name="credito_conferido" value="'.$total_credito.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" oninput="calculateTotal()" required>'; 
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">CONFIRA</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">PIX:</span>';
                                            echo '</div>';
                                            echo '<input type="tel" id="pix_conferido" name="pix_conferido" value="'.$total_pix.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" oninput="calculateTotal()" required>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">CONFIRA</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">DINHEIRO:</span>';
                                            echo '</div>'; 
                                            echo '<input type="tel" id="dinheiro_conferido" name="dinheiro_conferido" value="'.$total_dinheiro.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" oninput="calculateTotal()" required>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">CONFIRA</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">COFRE:</span>';
                                            echo '</div>'; 
                                            echo '<input type="tel" id="cofre_conferido" name="cofre_conferido" value="'.$total_cofre.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" oninput="calculateTotal()" required>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">CONFIRA</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">MOVIMENTO</span>';
                                            echo '</div>'; 
                                            echo '<input id="total_movimento_conferido" name="total_movimento_conferido" type="tel" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" placeholder="Valor de abertura de caixa" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">CONFERIDO</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">TOTAL:</span>';
                                            echo '</div>'; 
                                            echo '<input type="tel" id="total_caixa_conferido" name="total_caixa_conferido" value="'.$total_tudo.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">CONFERIDO</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">R$:</span>';
                                            echo '</div>'; 
                                            echo '<input id="total_caixa_diferenca" name="total_caixa_diferenca" type="tel" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" placeholder="Valor de abertura de caixa" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">DIFERENÇA</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<script>document.getElementById("total_caixa_analitico").value = '.($total_tudo + $total_abertura_caixa).';</script>';
                                            echo '<script>document.getElementById("total_movimento_analitico").value = '.($total_tudo).';</script>';
                                            echo '<script>document.getElementById("total_caixa_conferido").value = '.($total_tudo + $total_abertura_caixa).';</script>';
                                            echo '<script>document.getElementById("total_movimento_conferido").value = '.($total_tudo).';</script>';
                                            echo '<script>document.getElementById("total_caixa_diferenca").value = '.($total_tudo - $total_tudo).';</script>';
                                            ?>
                                            <script>
                                                function calculateTotal() {
                                                    var debito_analitico = parseFloat(document.getElementById('debito_analitico').value);
                                                    var debito_conferido = parseFloat(document.getElementById('debito_conferido').value);
                                                    var credito_analitico = parseFloat(document.getElementById('credito_analitico').value);
                                                    var credito_conferido = parseFloat(document.getElementById('credito_conferido').value);//suprimento_analitico
                                                    var pix_analitico = parseFloat(document.getElementById('pix_analitico').value);
                                                    var pix_conferido = parseFloat(document.getElementById('pix_conferido').value);
                                                    //var dinheiro_analitico = parseFloat(document.getElementById('dinheiro_analitico').value) + parseFloat(document.getElementById('suprimento_analitico').value);//suprimento_analitico + dinheiro
                                                    var dinheiro_analitico = parseFloat(document.getElementById('dinheiro_analitico').value) ;//suprimento_analitico + dinheiro
                                                    var dinheiro_conferido = parseFloat(document.getElementById('dinheiro_conferido').value);//suprimento_analitico + dinheiro
                                                    var cofre_analitico = parseFloat(document.getElementById('cofre_analitico').value) ;//suprimento_analitico + dinheiro
                                                    var cofre_conferido = parseFloat(document.getElementById('cofre_conferido').value);//suprimento_analitico + dinheiro
                                                    
                                                    var total_analitico = debito_analitico + credito_analitico + pix_analitico + dinheiro_analitico + cofre_analitico + <?php echo $total_abertura_caixa + ($total_suprimento_caixa - $total_sangria_caixa);?>;
                                                    var total_conferido = debito_conferido + credito_conferido + pix_conferido + dinheiro_conferido + cofre_conferido + <?php echo $total_abertura_caixa + ($total_suprimento_caixa - $total_sangria_caixa);?>;//$total_abertura_caixa
                                                    var total_movimento = debito_conferido + credito_conferido + pix_conferido + dinheiro_conferido + cofre_conferido;
                                                    var diferenca = total_conferido - total_analitico;
                                                    document.getElementById('total_caixa_analitico').value = total_analitico;
                                                    document.getElementById('total_caixa_conferido').value = total_conferido;
                                                    document.getElementById('total_caixa_diferenca').value = diferenca;
                                                }
                                            </script>
                                            <?php
                                        echo '</div>';
                                        
                                        echo '<button type="submit" name="saidaOperadorCaixa" id="saidaOperadorCaixa" class="btn btn-lg btn-block btn-outline-success" style="margin: 5px;"><i class="mdi mdi-file-check"></i>Saída de Operador</button>';
        
                                        echo '<button type="submit" name="fechamentoDiaFiscalCaixa" id="fechamentoDiaFiscalCaixa" class="btn btn-lg btn-block btn-success" style="margin: 5px;"><i class="mdi mdi-file-check"></i>Fechar Dia Fiscal</button>';
                                        
                                        echo '</div>';
                                        echo '</form>';
                                        echo '</div>';     
                                        echo '</div>';


                                        if(isset($_POST['fechamentoDiaFiscalCaixa'])){

                                        
                                            $fechar_caixa = "UPDATE tb_caixa SET
                                            dt_fechamento = '".$_POST['dt_fechamento']."',
                                            cd_colab_fechamento = '".$_POST['cd_colab_fechamento']."',
                                            total_movimento = '".$_POST['total_movimento_analitico']."',
                                            saldo_fechamento = '".$_POST['total_caixa_analitico']."',
                                            diferenca_caixa = '".$_POST['total_caixa_diferenca']."',
                                            fpag_dinheiro = '".$_POST['dinheiro_analitico']."',
                                            fpag_debito = '".$_POST['debito_analitico']."',
                                            fpag_credito = '".$_POST['credito_analitico']."',
                                            fpag_pix = '".$_POST['pix_analitico']."',
                                            status_caixa = 1
                                            WHERE cd_caixa = ".$_POST['cd_caixa']."";
                                            mysqli_query($conn, $fechar_caixa);
                                            //echo "<script>window.alert('Caixa Fechado!');</script>";
    
                                            //colher valores
                                            //$select_caixa_dia_fiscal;
    
                                            $select_caixa = "SELECT * FROM tb_caixa WHERE cd_filial = ".$_SESSION['cd_empresa']." AND cd_caixa = '".$_SESSION['cd_caixa']."'";
                                            $result_caixa = mysqli_query($conn, $select_caixa);
                                            $row_caixa = mysqli_fetch_assoc($result_caixa);
                                            if($row_caixa) {
                                                $dt_caixa_anterior = $row_caixa['dt_abertura'];
                                                
                                                //echo "<script>window.alert('Fechamento".$dt_caixa_anterior."');</script>";
    
    
                                                //$select_caixa_aberto = "SELECT COUNT(*) as total_linhas FROM tb_caixa WHERE status_caixa = '0' AND DATE(dt_abertura) = '".date('Y-m-d', strtotime($dataHoraAtual))."'";//dt_caixa_anterior
                                                //$result_caixa_aberto = mysqli_query($conn, $select_caixa_aberto);
                                                //$row_caixa_aberto = mysqli_fetch_assoc($result_caixa_aberto);
                                                //if($row_caixa_aberto['total_linhas'] > 0) {
                                                //    echo "<script>window.alert('Fechamento do caixa realizado, Restam outros caixas abertos!');</script>";
                                                //}else{
                                                    $select_caixa_dia_fiscal = "SELECT * FROM tb_caixa_dia_fiscal WHERE cd_filial = ".$_SESSION['cd_empresa']." AND DATE(dt_abertura_dia_fiscal) = '".date('Y-m-d', strtotime($dataHoraAtual))."'";
                                                    $result_caixa_dia_fiscal = mysqli_query($conn, $select_caixa_dia_fiscal);
                                                    $row_caixa_dia_fiscal = mysqli_fetch_assoc($result_caixa_dia_fiscal);
                                                    if($row_caixa_dia_fiscal) {
                                                        $select_movimento_analitico = $row_caixa_dia_fiscal['movimento_analitico_dia_fiscal'];
                                                        $select_movimento_conferido = $row_caixa_dia_fiscal['movimento_conferido_dia_fiscal'];
                                                        $select_total_analitico = $row_caixa_dia_fiscal['total_analitico_dia_fiscal'];
                                                        $select_total_conferido = $row_caixa_dia_fiscal['total_conferido_dia_fiscal'];
                                                        $select_diferenca_total = $row_caixa_dia_fiscal['diferenca_caixa_dia_fiscal'];
                                                        //echo "<script>window.alert('Valores do dia fiscal colhidos para soma!');</script>";              
                                                    }else{
                                                        echo "<script>window.alert('Dia fiscal não aberto, abra agora!');</script>";
                                                        $aberturaNormalCaixaDiaFiscal = "INSERT INTO tb_caixa_dia_fiscal(cd_filial, dt_abertura_dia_fiscal, status_caixa_dia_fiscal) VALUES(
                                                        '".$_SESSION['cd_empresa']."',
                                                        '".$_POST['dt_abertura']."',
                                                        '0')
                                                        ";
                                                        mysqli_query($conn, $aberturaNormalCaixaDiaFiscal);
                                                        echo "<script>window.alert('Acabo de abrir dia fiscal!');</script>";             
                                                    }
                                                    $update_caixa_dia_fiscal = "UPDATE tb_caixa_dia_fiscal SET 
                                                    dt_fechamento_dia_fiscal = '".($_POST['dt_fechamento'])."',
                                                    movimento_analitico_dia_fiscal = '".($select_movimento_analitico + $_POST['total_movimento_analitico'])."',
                                                    movimento_conferido_dia_fiscal = '".($select_movimento_conferido + $_POST['total_movimento_conferido'])."',
                                                    total_analitico_dia_fiscal = '".($select_total_analitico + $_POST['total_caixa_analitico'])."',
                                                    total_conferido_dia_fiscal = '".($select_total_conferido + $_POST['total_caixa_conferido'])."',
                                                    diferenca_caixa_dia_fiscal = '".($select_diferenca_total + $_POST['total_caixa_diferenca'])."',
                                                    status_caixa_dia_fiscal = 2
                                                    WHERE cd_filial = ".$_SESSION['cd_empresa']." AND DATE(dt_abertura_dia_fiscal) = '".date('Y-m-d', strtotime($dataHoraAtual))."'";//WHERE dt_abertura_dia_fiscal = '".date('Y-m-d')."";
                                                    mysqli_query($conn, $update_caixa_dia_fiscal);
                                                    //echo "<script>window.alert('Encerramento do Dia Fiscal!');</script>";
                                                //}
    
                                            }else{
                                                echo "<script>window.alert('NADA FEITO!');</script>";                                           
                                            }
    
                                            $insert_conferencia = "INSERT INTO tb_caixa_conferido(cd_filial, cd_caixa_analitico, dt_conferencia, cd_colab_conferencia, saldo_abertura_conferido, saldo_fechamento_conferido, diferenca_caixa_conferido, saldo_movimento_conferido, fpag_dinheiro_conferido, fpag_debito_conferido, fpag_credito_conferido, fpag_pix_conferido, fpag_cofre_conferido, obs_conferencia) VALUES(
                                                '".$_SESSION['cd_empresa']."',
                                                '".$_POST['cd_caixa']."',
                                                '".$_POST['dt_fechamento']."',
                                                '".$_POST['cd_colab_fechamento']."',
                                                '".$_POST['suprimento_analitico']."',
                                                '".$_POST['total_caixa_conferido']."',
                                                '".$_POST['total_caixa_diferenca']."',
                                                '".$_POST['total_movimento_conferido']."',
                                                '".$_POST['dinheiro_conferido']."',
                                                '".$_POST['debito_conferido']."',
                                                '".$_POST['credito_conferido']."',
                                                '".$_POST['pix_conferido']."',
                                                '".$_POST['cofre_conferido']."',
                                                'Fechamento de Caixa (Normal)'
                                                 )
                                             ";
                                            mysqli_query($conn, $insert_conferencia);
                                            //echo "<script>window.alert('Caixa Conferido foi lançado!');</script>";
                                            //echo '<script>location.href="../../index.php";</script>';
                                            echo '<script>location.href="'.$_SESSION['dominio'].'/pages/dashboard/index.php";</script>';

                                        }


                                    }
                                    if($_SESSION['dt_caixa'] == "ONTEM")
                                    {
                                        echo '<h1>Fechar Caixa (Auditar)</h1>';
                                        //$dataHoraAtual = date('Y-m-d H:i');
                                        $dataHoraAtual = date('Y-m-d H:i', strtotime('+1 hour'));
                                        echo '<div class="col-12 grid-margin stretch-card btn-warning">';
                                        
                                        echo '<div class="card" '.$_SESSION['c_card'].'>';
                                        echo '<form method="POST">';
                                        echo '<div class="card-body">';

                                        echo '<h4 class="card-title">Dados do Caixa</h4>';

                                        $select_caixa = "SELECT * FROM tb_caixa WHERE cd_filial = ".$_SESSION['cd_empresa']." AND cd_caixa = '".$_SESSION['cd_caixa']."'";
                                            $resulta_caixa = $conn->query($select_caixa);
                                            $total_caixa = 0;
                                            while ( $row_caixa = $resulta_caixa->fetch_assoc()){
                                                echo '<div style="display: none;">';
                                                echo '<label for="cd_caixa">cd_caixa</label>';
                                                echo '<input type="text" name="cd_caixa" id="cd_caixa" value="'.$row_caixa['cd_caixa'].'" class="aspNetDisabled form-control form-control-sm" placeholder="Título do serviço" readonly>';
                            
                                                echo '<label for="dt_abertura">abertura</label>';
                                                echo '<input type="text" name="dt_abertura" id="dt_abertura" value="'.$row_caixa['dt_abertura'].'" class="aspNetDisabled form-control form-control-sm" placeholder="Título do serviço" readonly>';

                                                echo '<label for="cd_colab_abertura">Responsável</label>';
                                                echo '<input type="text" name="cd_colab_abertura" id="cd_colab_abertura" value="'.$row_caixa['cd_colab_abertura'].'" class="aspNetDisabled form-control form-control-sm" placeholder="Título do serviço" readonly>';
                                                echo '</div>';

                                                //echo '<label for="show_dt_abertura">abertura</label>';
                                                //echo '<input type="text" name="show_dt_abertura" id="show_dt_abertura" value="'.date('d/m/y H:i', strtotime($row_caixa['dt_abertura'])).'" class="aspNetDisabled form-control form-control-sm" placeholder="Título do serviço" readonly>';
                                                
                                                echo '<div class="form-group">';
                                                    echo '<div class="input-group">';
                                                    echo '<div class="input-group-prepend">';
                                                    echo '<span class="btn btn-info">ABERTURA:</span>';
                                                    echo '</div>';
                                                    //$total_dinheiro = $total_abertura_caixa + $total_dinheiro;
                                                echo '<input type="text" name="show_dt_abertura" id="show_dt_abertura" value="'.date('d/m/y H:i', strtotime($row_caixa['dt_abertura'])).'" class="aspNetDisabled form-control form-control-sm" placeholder="Título do serviço" readonly>';
                                                    //echo '<div class="input-group-append">';
                                                    //echo '<span class="input-group-text">LLL</span>';
                                                    //echo '</div>';
                                                    echo '</div>';
                                                    echo '</div>';

                                                
                                                $select_caixa_colab = "SELECT * FROM tb_pessoa WHERE cd_pessoa = '".$row_caixa['cd_colab_abertura']."'";
                                                $resulta_caixa_colab = $conn->query($select_caixa_colab);
                                                
                                                while ( $row_caixa_colab = $resulta_caixa_colab->fetch_assoc()){
                                                    //echo '<label for="show_nome_colab_abertura">Responsável</label>';
                                                    //echo '<input type="text" name="show_nome_colab_abertura" id="show_nome_colab_abertura" value="'.$row_caixa_colab['pnome_colab'].' '.$row_caixa_colab['snome_colab'].'" class="aspNetDisabled form-control form-control-sm" placeholder="Título do serviço" readonly>';
                                                    
                                                    echo '<div class="form-group">';
                                                    echo '<div class="input-group">';
                                                    echo '<div class="input-group-prepend">';
                                                    echo '<span class="btn btn-info">ABERTO POR:</span>';
                                                    echo '</div>';
                                                    //$total_dinheiro = $total_abertura_caixa + $total_dinheiro;
                                                    echo '<input type="text" name="show_nome_colab_abertura" id="show_nome_colab_abertura" value="'.$row_caixa_colab['pnome_pessoa'].' '.$row_caixa_colab['snome_pessoa'].'" class="aspNetDisabled form-control form-control-sm" placeholder="Título do serviço" readonly>';
                                                    //echo '<div class="input-group-append">';
                                                    //echo '<span class="input-group-text">LLL</span>';
                                                    //echo '</div>';
                                                    echo '</div>';
                                                    echo '</div>';
                                                }
                                                $total_abertura_caixa = $row_caixa['saldo_abertura'];
                                            }
                                            echo '<h4 class="card-title">Fechar Caixa - Conferência de Caixa</h4>';
                                        
                                            echo '<div style="display: none;">';
                                            echo '<input value="'.$_SESSION['cd_colab'].'" name="cd_colab_fechamento" id="cd_colab_fechamento" type="text" class="aspNetDisabled form-control form-control-sm"/>';
                                            echo '<input value="'.$dataHoraAtual.'" name="dt_fechamento" id="dt_fechamento" type="text" class="aspNetDisabled form-control form-control-sm"/>';
                                        
                                            echo '</div>';
                                            echo '<div>';
                                            //echo '<input value="'.$_SESSION['pnome_colab'].' '.$_SESSION['snome_colab'].'" name="show_nome_colab_fechamento" id="show_nome_colab_fechamento" class="form-control mb-2 mr-sm-2" readonly>';

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="btn btn-warning">FECHAMENTO:</span>';
                                            echo '</div>';
                                            //$total_dinheiro = $total_abertura_caixa + $total_dinheiro;
                                            echo '<input value="'.$_SESSION['pnome_colab'].' '.$_SESSION['snome_colab'].'" name="show_nome_colab_fechamento" id="show_nome_colab_fechamento" class="aspNetDisabled form-control form-control-sm" readonly>';
                                            //echo '<div class="input-group-append">';
                                            //echo '<span class="input-group-text">LLL</span>';
                                            //echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="btn btn-warning">FECHADO POR:</span>';
                                            echo '</div>';
                                            //$total_dinheiro = $total_abertura_caixa + $total_dinheiro;
                                            echo '<input value="'.date('d/m/y H:i', strtotime($dataHoraAtual)).'" name="show_dt_fechamento" id="show_dt_fechamento" type="text"  class="aspNetDisabled form-control form-control-sm" readonly/>';
                                            echo '<div class="input-group-append">';
                                            //echo '<span class="btn btn-danger">LLL</span>';
                                            echo '<span class="btn btn-warning"><i class="mdi mdi-file-check"></i></span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                            
                                        
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

                                            //$total_tudo = $total_debito + $total_credito + $total_pix + $total_dinheiro;
                                            
                                            $total_tudo = ($total_debito + $total_credito + $total_pix + $total_dinheiro + $total_suprimento_caixa) - $total_sangria_caixa;
                                            



                                            


                                            echo '<div name="analitico" style="display:block;">';
                                            echo '<h4 class="card-title">Caixa Analítico</h4>';
                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">ABERTURA:</span>';
                                            echo '</div>'; 
                                            echo '<input type="tel" id="suprimento_analitico" name="suprimento_analitico" value="'.$total_abertura_caixa.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" oninput="calculateTotal()" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">ANALÍTICO</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">DEBITO:</span>';
                                            echo '</div>'; 
                                            echo '<input type="tel" id="debito_analitico" name="debito_analitico" value="'.$total_debito.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" oninput="calculateTotal()" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">ANALÍTICO</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">CREDITO:</span>';
                                            echo '</div>'; 
                                            echo '<input type="tel" id="credito_analitico" name="credito_analitico" value="'.$total_credito.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" oninput="calculateTotal()" readonly>'; 
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">ANALÍTICO</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">PIX:</span>';
                                            echo '</div>'; 
                                            echo '<input type="tel" id="pix_analitico" name="pix_analitico" value="'.$total_pix.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" oninput="calculateTotal()" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">ANALÍTICO</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">DINHEIRO:</span>';
                                            echo '</div>';
                                            //$total_dinheiro = $total_abertura_caixa + $total_dinheiro;
                                            echo '<input type="tel" id="dinheiro_analitico" name="dinheiro_analitico" value="'.$total_dinheiro.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" oninput="calculateTotal()" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">ANALÍTICO</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">COFRE:</span>';
                                            echo '</div>';
                                            //$total_dinheiro = $total_abertura_caixa + $total_dinheiro;
                                            echo '<input type="tel" id="cofre_analitico" name="cofre_analitico" value="'.$total_cofre.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" oninput="calculateTotal()" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">ANALÍTICO</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">SUPRIMENTO:</span>';
                                            echo '</div>'; 
                                            echo '<input id="total_suprimento_analitico" name="total_suprimento_analitico" type="tel" value="'.$total_suprimento_caixa.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" placeholder="Valor de abertura de caixa" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">ANALÍTICO</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">SANGRIA:</span>';
                                            echo '</div>'; 
                                            echo '<input id="total_sangria_analitico" name="total_sangria_analitico" type="tel" value="'.$total_sangria_caixa.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" placeholder="Valor de abertura de caixa" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">ANALÍTICO</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">MOVIMENTO</span>';
                                            echo '</div>'; 
                                            echo '<input id="total_movimento_analitico" name="total_movimento_analitico" type="tel" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" placeholder="Valor de abertura de caixa" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">DIFERENÇA</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                            

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">TOTAL:</span>';
                                            echo '</div>'; 
                                            echo '<input id="total_caixa_analitico" name="total_caixa_analitico" type="tel" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" placeholder="Valor de abertura de caixa" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">ANALÍTICO</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';



                                            echo '<div name="caixa_conferido" style="display: block">';
                                            echo '<h4 class="card-title">Caixa Conferido</h4>';
                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">DEBITO:</span>';
                                            echo '</div>'; 
                                            echo '<input type="tel" id="debito_conferido" name="debito_conferido"value="'.$total_debito.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" oninput="calculateTotal()" required>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">CONFIRA</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">CREDITO:</span>';
                                            echo '</div>'; 
                                            echo '<input type="tel" id="credito_conferido" name="credito_conferido" value="'.$total_credito.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" oninput="calculateTotal()" required>'; 
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">CONFIRA</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">PIX:</span>';
                                            echo '</div>';
                                            echo '<input type="tel" id="pix_conferido" name="pix_conferido" value="'.$total_pix.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" oninput="calculateTotal()" required>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">CONFIRA</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">DINHEIRO:</span>';
                                            echo '</div>'; 
                                            echo '<input type="tel" id="dinheiro_conferido" name="dinheiro_conferido" value="'.$total_dinheiro.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" oninput="calculateTotal()" required>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">CONFIRA</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">COFRE:</span>';
                                            echo '</div>'; 
                                            echo '<input type="tel" id="cofre_conferido" name="cofre_conferido" value="'.$total_cofre.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" oninput="calculateTotal()" required>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">CONFIRA</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">MOVIMENTO</span>';
                                            echo '</div>'; 
                                            echo '<input id="total_movimento_conferido" name="total_movimento_conferido" type="tel" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" placeholder="Valor de abertura de caixa" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">CONFERIDO</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">TOTAL:</span>';
                                            echo '</div>'; 
                                            echo '<input type="tel" id="total_caixa_conferido" name="total_caixa_conferido" value="'.$total_tudo.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">CONFERIDO</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">R$:</span>';
                                            echo '</div>'; 
                                            echo '<input id="total_caixa_diferenca" name="total_caixa_diferenca" type="tel" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" placeholder="Valor de abertura de caixa" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">DIFERENÇA</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<script>document.getElementById("total_caixa_analitico").value = '.($total_tudo + $total_abertura_caixa).';</script>';
                                            echo '<script>document.getElementById("total_movimento_analitico").value = '.($total_tudo).';</script>';
                                            echo '<script>document.getElementById("total_caixa_conferido").value = '.($total_tudo + $total_abertura_caixa).';</script>';
                                            echo '<script>document.getElementById("total_movimento_conferido").value = '.($total_tudo).';</script>';
                                            echo '<script>document.getElementById("total_caixa_diferenca").value = '.($total_tudo - $total_tudo).';</script>';
                                            ?>
                                            <script>
                                                function calculateTotal() {
                                                    var debito_analitico = parseFloat(document.getElementById('debito_analitico').value);
                                                    var debito_conferido = parseFloat(document.getElementById('debito_conferido').value);
                                                    var credito_analitico = parseFloat(document.getElementById('credito_analitico').value);
                                                    var credito_conferido = parseFloat(document.getElementById('credito_conferido').value);//suprimento_analitico
                                                    var pix_analitico = parseFloat(document.getElementById('pix_analitico').value);
                                                    var pix_conferido = parseFloat(document.getElementById('pix_conferido').value);
                                                    //var dinheiro_analitico = parseFloat(document.getElementById('dinheiro_analitico').value) + parseFloat(document.getElementById('suprimento_analitico').value);//suprimento_analitico + dinheiro
                                                    var dinheiro_analitico = parseFloat(document.getElementById('dinheiro_analitico').value) ;//suprimento_analitico + dinheiro
                                                    var dinheiro_conferido = parseFloat(document.getElementById('dinheiro_conferido').value);//suprimento_analitico + dinheiro
                                                    var cofre_analitico = parseFloat(document.getElementById('cofre_analitico').value) ;//suprimento_analitico + dinheiro
                                                    var cofre_conferido = parseFloat(document.getElementById('cofre_conferido').value);//suprimento_analitico + dinheiro
                                                    var total_analitico = debito_analitico + credito_analitico + pix_analitico + dinheiro_analitico + cofre_analitico + <?php echo $total_abertura_caixa + ($total_suprimento_caixa - $total_sangria_caixa);?>;
                                                    var total_conferido = debito_conferido + credito_conferido + pix_conferido + dinheiro_conferido + cofre_conferido + <?php echo $total_abertura_caixa + ($total_suprimento_caixa - $total_sangria_caixa);?>;//$total_abertura_caixa
                                                    var total_movimento = debito_conferido + credito_conferido + pix_conferido + dinheiro_conferido + cofre_conferido;
                                                    var diferenca = total_conferido - total_analitico;
                                                    document.getElementById('total_caixa_analitico').value = total_analitico;
                                                    document.getElementById('total_caixa_conferido').value = total_conferido;
                                                    document.getElementById('total_caixa_diferenca').value = diferenca;
                                                }
                                            </script>
                                            <?php
                                        echo '</div>';
                                        
                                        //echo '<button type="submit" name="saidaOperadorCaixa" id="saidaOperadorCaixa" class="btn btn-lg btn-block btn-outline-danger" style="margin: 5px;"><i class="mdi mdi-file-check"></i>Saída de Operador</button>';
        
                                        echo '<button type="submit" name="fechamentoDiaFiscalCaixa" id="fechamentoDiaFiscalCaixa" class="btn btn-lg btn-block btn-warning" style="margin: 5px;"><i class="mdi mdi-file-check"></i>Fechar Dia Fiscal</button>';
                                        
                                        echo '</div>';
                                        echo '</form>';
                                        echo '</div>';     
                                        echo '</div>';

                                        if(isset($_POST['fechamentoDiaFiscalCaixa'])){

                                        
                                            $fechar_caixa = "UPDATE tb_caixa SET
                                            dt_fechamento = '".$_POST['dt_fechamento']."',
                                            cd_colab_fechamento = '".$_POST['cd_colab_fechamento']."',
                                            total_movimento = '".$_POST['total_movimento_analitico']."',
                                            saldo_fechamento = '".$_POST['total_caixa_analitico']."',
                                            diferenca_caixa = '".$_POST['total_caixa_diferenca']."',
                                            fpag_dinheiro = '".$_POST['dinheiro_analitico']."',
                                            fpag_debito = '".$_POST['debito_analitico']."',
                                            fpag_credito = '".$_POST['credito_analitico']."',
                                            fpag_pix = '".$_POST['pix_analitico']."',
                                            fpag_cofre = '".$_POST['cofre_analitico']."',
                                            status_caixa = 1
                                            WHERE cd_filial = ".$_SESSION['cd_empresa']." AND cd_caixa = ".$_POST['cd_caixa']."";
                                            mysqli_query($conn, $fechar_caixa);
                                            //echo "<script>window.alert('Caixa Fechado!');</script>";
    
                                            //colher valores
                                            //$select_caixa_dia_fiscal;
    
                                            $select_caixa = "SELECT * FROM tb_caixa WHERE cd_filial = ".$_SESSION['cd_empresa']." AND cd_caixa = '".$_SESSION['cd_caixa']."'";
                                            $result_caixa = mysqli_query($conn, $select_caixa);
                                            $row_caixa = mysqli_fetch_assoc($result_caixa);
                                            if($row_caixa) {
                                                $dt_caixa_anterior = $row_caixa['dt_abertura'];
                                                
                                                //echo "<script>window.alert('Fechamento".$dt_caixa_anterior."');</script>";
    
    
                                                //$select_caixa_aberto = "SELECT COUNT(*) as total_linhas FROM tb_caixa WHERE status_caixa = 0 AND DATE(dt_abertura) = '".date('Y-m-d', strtotime($dt_caixa_anterior))."'";//dt_caixa_anterior
                                                //$result_caixa_aberto = mysqli_query($conn, $select_caixa_aberto);
                                                //$row_caixa_aberto = mysqli_fetch_assoc($result_caixa_aberto);
                                                //if($row_caixa_aberto['total_linhas'] > 0) {
                                                //    echo "<script>window.alert('Fechamento do caixa realizado, Restam outros caixas abertos!');</script>";
                                                //}else{
                                                    $select_caixa_dia_fiscal = "SELECT * FROM tb_caixa_dia_fiscal WHERE cd_filial = ".$_SESSION['cd_empresa']." AND DATE(dt_abertura_dia_fiscal) = '".date('Y-m-d', strtotime($dt_caixa_anterior))."'";
                                                    $result_caixa_dia_fiscal = mysqli_query($conn, $select_caixa_dia_fiscal);
                                                    $row_caixa_dia_fiscal = mysqli_fetch_assoc($result_caixa_dia_fiscal);
                                                    if($row_caixa_dia_fiscal) {
                                                        $select_movimento_analitico = $row_caixa_dia_fiscal['movimento_analitico_dia_fiscal'];
                                                        $select_movimento_conferido = $row_caixa_dia_fiscal['movimento_conferido_dia_fiscal'];
                                                        $select_total_analitico = $row_caixa_dia_fiscal['total_analitico_dia_fiscal'];
                                                        $select_total_conferido = $row_caixa_dia_fiscal['total_conferido_dia_fiscal'];
                                                        $select_diferenca_total = $row_caixa_dia_fiscal['diferenca_caixa_dia_fiscal'];
                                                        //echo "<script>window.alert('Valores do dia fiscal colhidos para soma!');</script>";              
                                                    }else{
                                                        echo "<script>window.alert('Dia fiscal não aberto, abra agora!');</script>";
                                                        $aberturaNormalCaixaDiaFiscal = "INSERT INTO tb_caixa_dia_fiscal(cd_filial, dt_abertura_dia_fiscal, status_caixa_dia_fiscal) VALUES(
                                                        '".$_SESSION['cd_empresa']."',
                                                        '".$_POST['dt_abertura']."',
                                                        '0')
                                                        ";
                                                        mysqli_query($conn, $aberturaNormalCaixaDiaFiscal);
                                                        echo "<script>window.alert('Acabo de abrir dia fiscal!');</script>";             
                                                    }
                                                    $update_caixa_dia_fiscal = "UPDATE tb_caixa_dia_fiscal SET 
                                                    dt_fechamento_dia_fiscal = '".($_POST['dt_fechamento'])."',
                                                    movimento_analitico_dia_fiscal = '".($select_movimento_analitico + $_POST['total_movimento_analitico'])."',
                                                    movimento_conferido_dia_fiscal = '".($select_movimento_conferido + $_POST['total_movimento_conferido'])."',
                                                    total_analitico_dia_fiscal = '".($select_total_analitico + $_POST['total_caixa_analitico'])."',
                                                    total_conferido_dia_fiscal = '".($select_total_conferido + $_POST['total_caixa_conferido'])."',
                                                    diferenca_caixa_dia_fiscal = '".($select_diferenca_total + $_POST['total_caixa_diferenca'])."',
                                                    status_caixa_dia_fiscal = 2
                                                    WHERE cd_filial = ".$_SESSION['cd_empresa']." AND DATE(dt_abertura_dia_fiscal) = '".date('Y-m-d', strtotime($dt_caixa_anterior))."'";//WHERE dt_abertura_dia_fiscal = '".date('Y-m-d')."";
                                                    mysqli_query($conn, $update_caixa_dia_fiscal);
                                                    echo "<script>window.alert('Encerramento do Dia Fiscal!');</script>";
                                                //}
    
                                            }else{
                                                echo "<script>window.alert('NADA FEITO!');</script>";                                           
                                            }
    
                                            $insert_conferencia = "INSERT INTO tb_caixa_conferido(cd_filial, cd_caixa_analitico, dt_conferencia, cd_colab_conferencia, saldo_abertura_conferido, saldo_fechamento_conferido, diferenca_caixa_conferido, saldo_movimento_conferido, fpag_dinheiro_conferido, fpag_debito_conferido, fpag_credito_conferido, fpag_pix_conferido, fpag_cofre_conferido, obs_conferencia) VALUES(
                                                '".$_SESSION['cd_empresa']."',
                                                '".$_POST['cd_caixa']."',
                                                '".$_POST['dt_fechamento']."',
                                                '".$_POST['cd_colab_fechamento']."',
                                                '".$_POST['suprimento_analitico']."',
                                                '".$_POST['total_caixa_conferido']."',
                                                '".$_POST['total_caixa_diferenca']."',
                                                '".$_POST['total_movimento_conferido']."',
                                                '".$_POST['dinheiro_conferido']."',
                                                '".$_POST['debito_conferido']."',
                                                '".$_POST['credito_conferido']."',
                                                '".$_POST['pix_conferido']."',
                                                '".$_POST['cofre_conferido']."',
                                                'Fechamento de Caixa (Auditoria do dia anterior)'
                                                 )
                                             ";
                                            mysqli_query($conn, $insert_conferencia);
                                            //echo "<script>window.alert('Caixa Conferido foi lançado!');</script>";
                                            //echo '<script>location.href="../../index.php";</script>';
                                            echo '<script>location.href="'.$_SESSION['dominio'].'/pages/dashboard/index.php";</script>';

                                        }

                                    }
                                    if($_SESSION['dt_caixa'] == "ANTERIOR")
                                    {
                                        echo '<h1>Fechar Caixa (Auditar)</h1>';
                                        //$dataHoraAtual = date('Y-m-d H:i');
                                        $dataHoraAtual = date('Y-m-d H:i', strtotime('+1 hour'));
                                        echo '<div class="col-12 grid-margin stretch-card btn-danger">';
                                        
                                        echo '<div class="card" '.$_SESSION['c_card'].'>';
                                        echo '<form method="POST">';
                                        echo '<div class="card-body">';

                                        echo '<h4 class="card-title">Dados do Caixa</h4>';

                                        $select_caixa = "SELECT * FROM tb_caixa WHERE cd_filial = ".$_SESSION['cd_empresa']." AND cd_caixa = '".$_SESSION['cd_caixa']."'";
                                        $resulta_caixa = $conn->query($select_caixa);
                                        $total_caixa = 0;
                                        while ( $row_caixa = $resulta_caixa->fetch_assoc()){
                                            echo '<div style="display: none;">';
                                            echo '<label for="cd_caixa">cd_caixa</label>';
                                            echo '<input type="text" name="cd_caixa" id="cd_caixa" value="'.$row_caixa['cd_caixa'].'" class="aspNetDisabled form-control form-control-sm" placeholder="Título do serviço" readonly>';
                            
                                            echo '<label for="dt_abertura">abertura</label>';
                                                echo '<input type="text" name="dt_abertura" id="dt_abertura" value="'.$row_caixa['dt_abertura'].'" class="aspNetDisabled form-control form-control-sm" placeholder="Título do serviço" readonly>';

                                                echo '<label for="cd_colab_abertura">Responsável</label>';
                                                echo '<input type="text" name="cd_colab_abertura" id="cd_colab_abertura" value="'.$row_caixa['cd_colab_abertura'].'" class="aspNetDisabled form-control form-control-sm" placeholder="Título do serviço" readonly>';
                                                echo '</div>';

                                                //echo '<label for="show_dt_abertura">abertura</label>';
                                                //echo '<input type="text" name="show_dt_abertura" id="show_dt_abertura" value="'.date('d/m/y H:i', strtotime($row_caixa['dt_abertura'])).'" class="aspNetDisabled form-control form-control-sm" placeholder="Título do serviço" readonly>';
                                                

                                                echo '<div class="form-group">';
                                                    echo '<div class="input-group">';
                                                    echo '<div class="input-group-prepend">';
                                                    echo '<span class="btn btn-info">ABERTURA:</span>';
                                                    echo '</div>';
                                                    //$total_dinheiro = $total_abertura_caixa + $total_dinheiro;
                                                    echo '<input type="text" name="show_dt_abertura" id="show_dt_abertura" value="'.date('d/m/y H:i', strtotime($row_caixa['dt_abertura'])).'" class="aspNetDisabled form-control form-control-sm" placeholder="Título do serviço" readonly>';
                                                    //echo '<div class="input-group-append">';
                                                    //echo '<span class="input-group-text">LLL</span>';
                                                    //echo '</div>';
                                                    echo '</div>';
                                                    echo '</div>';
                                                

                                                
                                                $select_caixa_colab = "SELECT * FROM tb_pessoa WHERE cd_pessoa = '".$row_caixa['cd_colab_abertura']."'";
                                                $resulta_caixa_colab = $conn->query($select_caixa_colab);
                                                
                                                while ( $row_caixa_colab = $resulta_caixa_colab->fetch_assoc()){
                                                    //echo '<label for="show_nome_colab_abertura">Responsável</label>';
                                                    //echo '<input type="text" name="show_nome_colab_abertura" id="show_nome_colab_abertura" value="'.$row_caixa_colab['pnome_colab'].' '.$row_caixa_colab['snome_colab'].'" class="aspNetDisabled form-control form-control-sm" placeholder="Título do serviço" readonly>';
                                                    
                                                    echo '<div class="form-group">';
                                                    echo '<div class="input-group">';
                                                    echo '<div class="input-group-prepend">';
                                                    echo '<span class="btn btn-info">ABERTO POR:</span>';
                                                    echo '</div>';
                                                    //$total_dinheiro = $total_abertura_caixa + $total_dinheiro;
                                                    echo '<input type="text" name="show_nome_colab_abertura" id="show_nome_colab_abertura" value="'.$row_caixa_colab['pnome_pessoa'].' '.$row_caixa_colab['snome_pessoa'].'" class="aspNetDisabled form-control form-control-sm" placeholder="Título do serviço" readonly>';
                                                    //echo '<div class="input-group-append">';
                                                    //echo '<span class="input-group-text">LLL</span>';
                                                    //echo '</div>';
                                                    echo '</div>';
                                                    echo '</div>';
                                                }
                                                $total_abertura_caixa = $row_caixa['saldo_abertura'];
                                            }
                                            echo '<h4 class="card-title">Fechar Caixa - Conferência de Caixa</h4>';
                                        
                                            echo '<div style="display: none;">';
                                            echo '<input value="'.$_SESSION['cd_colab'].'" name="cd_colab_fechamento" id="cd_colab_fechamento" type="text" class="aspNetDisabled form-control form-control-sm"/>';
                                            echo '<input value="'.$dataHoraAtual.'" name="dt_fechamento" id="dt_fechamento" type="text" class="aspNetDisabled form-control form-control-sm"/>';
                                        
                                            echo '</div>';
                                            echo '<div>';
                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="btn btn-danger">FECHADO POR:</span>';
                                            echo '</div>';
                                            echo '<input value="'.$_SESSION['pnome_colab'].' '.$_SESSION['snome_colab'].'" name="show_nome_colab_fechamento" id="show_nome_colab_fechamento" class="aspNetDisabled form-control form-control-sm" readonly>';
                                            //echo '<div class="input-group-append">';
                                            //echo '<span class="input-group-text">LLL</span>';
                                            //echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                            

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="btn btn-danger">FECHAMENTO:</span>';
                                            echo '</div>';
                                            echo '<input value="'.date('d/m/y H:i', strtotime($dataHoraAtual)).'" name="show_dt_fechamento" id="show_dt_fechamento" type="text"  class="aspNetDisabled form-control form-control-sm" readonly/>';
                                            echo '<div class="input-group-append">';
                                            //echo '<span class="btn btn-danger">LLL</span>';
                                            echo '<span class="btn btn-danger"><i class="mdi mdi-file-check"></i></span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                        
                                        
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

                                            //$total_tudo = $total_debito + $total_credito + $total_pix + $total_dinheiro;
                                            
                                            $total_tudo = ($total_debito + $total_credito + $total_pix + $total_dinheiro + $total_suprimento_caixa) - $total_sangria_caixa;
                                            



                                            


                                            echo '<div name="analitico" style="display:block;">';
                                            echo '<h4 class="card-title">Caixa Analítico</h4>';
                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';

                                            


                                            echo '<span class="input-group-text btn-outline-info">ABERTURA:</span>';
                                            echo '</div>'; 
                                            echo '<input type="tel" id="suprimento_analitico" name="suprimento_analitico" value="'.$total_abertura_caixa.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" oninput="calculateTotal()" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">ANALÍTICO</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">DEBITO:</span>';
                                            echo '</div>'; 
                                            echo '<input type="tel" id="debito_analitico" name="debito_analitico" value="'.$total_debito.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" oninput="calculateTotal()" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">ANALÍTICO</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">CREDITO:</span>';
                                            echo '</div>'; 
                                            echo '<input type="tel" id="credito_analitico" name="credito_analitico" value="'.$total_credito.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" oninput="calculateTotal()" readonly>'; 
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">ANALÍTICO</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">PIX:</span>';
                                            echo '</div>'; 
                                            echo '<input type="tel" id="pix_analitico" name="pix_analitico" value="'.$total_pix.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" oninput="calculateTotal()" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">ANALÍTICO</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">DINHEIRO:</span>';
                                            echo '</div>';
                                            //$total_dinheiro = $total_abertura_caixa + $total_dinheiro;
                                            echo '<input type="tel" id="dinheiro_analitico" name="dinheiro_analitico" value="'.$total_dinheiro.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" oninput="calculateTotal()" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">ANALÍTICO</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">SUPRIMENTO:</span>';
                                            echo '</div>'; 
                                            echo '<input id="total_suprimento_analitico" name="total_suprimento_analitico" type="tel" value="'.$total_suprimento_caixa.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" placeholder="Valor de abertura de caixa" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">ANALÍTICO</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">SANGRIA:</span>';
                                            echo '</div>'; 
                                            echo '<input id="total_sangria_analitico" name="total_sangria_analitico" type="tel" value="'.$total_sangria_caixa.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" placeholder="Valor de abertura de caixa" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">ANALÍTICO</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">MOVIMENTO</span>';
                                            echo '</div>'; 
                                            echo '<input id="total_movimento_analitico" name="total_movimento_analitico" type="tel" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" placeholder="Valor de abertura de caixa" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">DIFERENÇA</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                            

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">TOTAL:</span>';
                                            echo '</div>'; 
                                            echo '<input id="total_caixa_analitico" name="total_caixa_analitico" type="tel" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" placeholder="Valor de abertura de caixa" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">ANALÍTICO</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';



                                            echo '<div name="caixa_conferido" style="display: none">';
                                            echo '<h4 class="card-title">Caixa Conferido</h4>';
                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">DEBITO:</span>';
                                            echo '</div>'; 
                                            echo '<input type="tel" id="debito_conferido" name="debito_conferido"value="'.$total_debito.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" oninput="calculateTotal()" required>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">CONFIRA</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">CREDITO:</span>';
                                            echo '</div>'; 
                                            echo '<input type="tel" id="credito_conferido" name="credito_conferido" value="'.$total_credito.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" oninput="calculateTotal()" required>'; 
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">CONFIRA</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">PIX:</span>';
                                            echo '</div>';
                                            echo '<input type="tel" id="pix_conferido" name="pix_conferido" value="'.$total_pix.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" oninput="calculateTotal()" required>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">CONFIRA</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">DINHEIRO:</span>';
                                            echo '</div>'; 
                                            echo '<input type="tel" id="dinheiro_conferido" name="dinheiro_conferido" value="'.$total_dinheiro.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" oninput="calculateTotal()" required>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">CONFIRA</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">MOVIMENTO</span>';
                                            echo '</div>'; 
                                            echo '<input id="total_movimento_conferido" name="total_movimento_conferido" type="tel" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" placeholder="Valor de abertura de caixa" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">CONFERIDO</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">TOTAL:</span>';
                                            echo '</div>'; 
                                            echo '<input type="tel" id="total_caixa_conferido" name="total_caixa_conferido" value="'.$total_tudo.'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">CONFERIDO</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            

                                            echo '<div class="form-group">';
                                            echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text btn-outline-info">R$:</span>';
                                            echo '</div>'; 
                                            echo '<input id="total_caixa_diferenca" name="total_caixa_diferenca" type="tel" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" placeholder="Valor de abertura de caixa" readonly>';
                                            echo '<div class="input-group-append">';
                                            echo '<span class="input-group-text">DIFERENÇA</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                            echo '<script>document.getElementById("total_caixa_analitico").value = '.($total_tudo + $total_abertura_caixa).';</script>';
                                            echo '<script>document.getElementById("total_movimento_analitico").value = '.($total_tudo).';</script>';
                                            echo '<script>document.getElementById("total_caixa_conferido").value = '.($total_tudo + $total_abertura_caixa).';</script>';
                                            echo '<script>document.getElementById("total_movimento_conferido").value = '.($total_tudo).';</script>';
                                            echo '<script>document.getElementById("total_caixa_diferenca").value = '.($total_tudo - $total_tudo).';</script>';
                                            ?>
                                            <script>
                                                function calculateTotal() {
                                                    var debito_analitico = parseFloat(document.getElementById('debito_analitico').value);
                                                    var debito_conferido = parseFloat(document.getElementById('debito_conferido').value);
                                                    var credito_analitico = parseFloat(document.getElementById('credito_analitico').value);
                                                    var credito_conferido = parseFloat(document.getElementById('credito_conferido').value);//suprimento_analitico
                                                    var pix_analitico = parseFloat(document.getElementById('pix_analitico').value);
                                                    var pix_conferido = parseFloat(document.getElementById('pix_conferido').value);
                                                    //var dinheiro_analitico = parseFloat(document.getElementById('dinheiro_analitico').value) + parseFloat(document.getElementById('suprimento_analitico').value);//suprimento_analitico + dinheiro
                                                    var dinheiro_analitico = parseFloat(document.getElementById('dinheiro_analitico').value) ;//suprimento_analitico + dinheiro
                                                    var dinheiro_conferido = parseFloat(document.getElementById('dinheiro_conferido').value);//suprimento_analitico + dinheiro
                                                    var total_analitico = debito_analitico + credito_analitico + pix_analitico + dinheiro_analitico + <?php echo $total_abertura_caixa + ($total_suprimento_caixa - $total_sangria_caixa);?>;
                                                    var total_conferido = debito_conferido + credito_conferido + pix_conferido + dinheiro_conferido + <?php echo $total_abertura_caixa + ($total_suprimento_caixa - $total_sangria_caixa);?>;//$total_abertura_caixa
                                                    var total_movimento = debito_conferido + credito_conferido + pix_conferido + dinheiro_conferido;
                                                    var diferenca = total_conferido - total_analitico;
                                                    document.getElementById('total_caixa_analitico').value = total_analitico;
                                                    document.getElementById('total_caixa_conferido').value = total_conferido;
                                                    document.getElementById('total_caixa_diferenca').value = diferenca;
                                                }
                                            </script>
                                            <?php
                                        echo '</div>';
                                        
                                        //echo '<button type="submit" name="saidaOperadorCaixa" id="saidaOperadorCaixa" class="btn btn-lg btn-block btn-outline-danger" style="margin: 5px;"><i class="mdi mdi-file-check"></i>Saída de Operador</button>';
        
                                        echo '<button type="submit" name="fechamentoDiaFiscalCaixa" id="fechamentoDiaFiscalCaixa" class="btn btn-lg btn-block btn-danger" style="margin: 5px;"><i class="mdi mdi-file-check"></i>Fechar Dia Fiscal</button>';
                                        
                                        echo '</div>';
                                        echo '</form>';
                                        echo '</div>';     
                                        echo '</div>';





                                        if(isset($_POST['fechamentoDiaFiscalCaixa'])){

                                        
                                            $fechar_caixa = "UPDATE tb_caixa SET
                                            dt_fechamento = '".$_POST['dt_fechamento']."',
                                            cd_colab_fechamento = '".$_POST['cd_colab_fechamento']."',
                                            total_movimento = '".$_POST['total_movimento_analitico']."',
                                            saldo_fechamento = '".$_POST['total_caixa_analitico']."',
                                            diferenca_caixa = '".$_POST['total_caixa_diferenca']."',
                                            fpag_dinheiro = '".$_POST['dinheiro_analitico']."',
                                            fpag_debito = '".$_POST['debito_analitico']."',
                                            fpag_credito = '".$_POST['credito_analitico']."',
                                            fpag_pix = '".$_POST['pix_analitico']."',
                                            status_caixa = 1
                                            WHERE cd_filial = ".$_SESSION['cd_empresa']." AND cd_caixa = ".$_POST['cd_caixa']."";
                                            mysqli_query($conn, $fechar_caixa);
                                            //echo "<script>window.alert('Caixa Fechado!');</script>";
    
                                            //colher valores
                                            //$select_caixa_dia_fiscal;
    
                                            $select_caixa = "SELECT * FROM tb_caixa WHERE cd_filial = ".$_SESSION['cd_empresa']." AND cd_caixa = '".$_SESSION['cd_caixa']."'";
                                            $result_caixa = mysqli_query($conn, $select_caixa);
                                            $row_caixa = mysqli_fetch_assoc($result_caixa);
                                            if($row_caixa) {
                                                $dt_caixa_anterior = $row_caixa['dt_abertura'];
                                                
                                                echo "<script>window.alert('Fechamento".$dt_caixa_anterior."');</script>";
    
    
                                                $select_caixa_aberto = "SELECT * FROM tb_caixa WHERE cd_filial = ".$_SESSION['cd_empresa']." AND DATE(dt_abertura) = '".date('Y-m-d', strtotime($dt_caixa_anterior))."'";//dt_caixa_anterior
                                                $result_caixa_aberto = mysqli_query($conn, $select_caixa_aberto);
                                                $row_caixa_aberto = mysqli_fetch_assoc($result_caixa_aberto);
                                                if($row_caixa_aberto['cd_caixa'] > 1) {
                                                    echo "<script>window.alert('Fechamento do caixa realizado, Restam outros caixas abertos!');</script>";
                                                }else{
                                                    $select_caixa_dia_fiscal = "SELECT * FROM tb_caixa_dia_fiscal WHERE cd_filial = ".$_SESSION['cd_empresa']." AND DATE(dt_abertura_dia_fiscal) = '".date('Y-m-d', strtotime($dt_caixa_anterior))."'";
                                                    $result_caixa_dia_fiscal = mysqli_query($conn, $select_caixa_dia_fiscal);
                                                    $row_caixa_dia_fiscal = mysqli_fetch_assoc($result_caixa_dia_fiscal);
                                                    if($row_caixa_dia_fiscal) {
                                                        $select_movimento_analitico = $row_caixa_dia_fiscal['movimento_analitico_dia_fiscal'];
                                                        $select_movimento_conferido = $row_caixa_dia_fiscal['movimento_conferido_dia_fiscal'];
                                                        $select_total_analitico = $row_caixa_dia_fiscal['total_analitico_dia_fiscal'];
                                                        $select_total_conferido = $row_caixa_dia_fiscal['total_conferido_dia_fiscal'];
                                                        $select_diferenca_total = $row_caixa_dia_fiscal['diferenca_caixa_dia_fiscal'];
                                                        echo "<script>window.alert('Valores do dia fiscal colhidos para soma!');</script>";              
                                                    }else{
                                                        echo "<script>window.alert('Dia fiscal não aberto, abra agora!');</script>";
                                                        $aberturaNormalCaixaDiaFiscal = "INSERT INTO tb_caixa_dia_fiscal(cd_filial, dt_abertura_dia_fiscal, status_caixa_dia_fiscal) VALUES(
                                                        '".$_SESSION['cd_empresa']."',
                                                        '".$_POST['dt_abertura']."',
                                                        '0')
                                                        ";
                                                        mysqli_query($conn, $aberturaNormalCaixaDiaFiscal);
                                                        echo "<script>window.alert('Acabo de abrir dia fiscal!');</script>";             
                                                    }
                                                    $update_caixa_dia_fiscal = "UPDATE tb_caixa_dia_fiscal SET 
                                                    dt_fechamento_dia_fiscal = '".($_POST['dt_fechamento'])."',
                                                    movimento_analitico_dia_fiscal = '".($select_movimento_analitico + $_POST['total_movimento_analitico'])."',
                                                    movimento_conferido_dia_fiscal = '".($select_movimento_conferido + $_POST['total_movimento_conferido'])."',
                                                    total_analitico_dia_fiscal = '".($select_total_analitico + $_POST['total_caixa_analitico'])."',
                                                    total_conferido_dia_fiscal = '".($select_total_conferido + $_POST['total_caixa_conferido'])."',
                                                    diferenca_caixa_dia_fiscal = '".($select_diferenca_total + $_POST['total_caixa_diferenca'])."',
                                                    status_caixa_dia_fiscal = 2
                                                    WHERE cd_filial = ".$_SESSION['cd_empresa']." AND DATE(dt_abertura_dia_fiscal) = '".date('Y-m-d', strtotime($dt_caixa_anterior))."'";//WHERE dt_abertura_dia_fiscal = '".date('Y-m-d')."";
                                                    mysqli_query($conn, $update_caixa_dia_fiscal);
                                                    echo "<script>window.alert('Encerramento do Dia Fiscal!');</script>";
                                                }
    
                                            }else{
                                                echo "<script>window.alert('NADA FEITO!');</script>";                                           
                                            }
    
                                            $insert_conferencia = "INSERT INTO tb_caixa_conferido(cd_filial, cd_caixa_analitico, dt_conferencia, cd_colab_conferencia, saldo_abertura_conferido, saldo_fechamento_conferido, diferenca_caixa_conferido, saldo_movimento_conferido, fpag_dinheiro_conferido, fpag_debito_conferido, fpag_credito_conferido, fpag_pix_conferido, obs_conferencia) VALUES(
                                                '".$_SESSION['cd_empresa']."',
                                                '".$_POST['cd_caixa']."',
                                                '".$_POST['dt_fechamento']."',
                                                '".$_POST['cd_colab_fechamento']."',
                                                '".$_POST['suprimento_analitico']."',
                                                '".$_POST['total_caixa_conferido']."',
                                                '".$_POST['total_caixa_diferenca']."',
                                                '".$_POST['total_movimento_conferido']."',
                                                '".$_POST['dinheiro_conferido']."',
                                                '".$_POST['debito_conferido']."',
                                                '".$_POST['credito_conferido']."',
                                                '".$_POST['pix_conferido']."',
                                                'Fechamento de Caixa (Auditoria por vários dias aberto)'
                                                 )
                                             ";
                                            mysqli_query($conn, $insert_conferencia);
                                            echo "<script>window.alert('Caixa Conferido foi lançado!');</script>";
                                            //echo '<script>location.href="../../index.php";</script>';
                                            echo '<script>location.href="'.$_SESSION['dominio'].'/pages/dashboard/index.php";</script>';

                                        }
                                    }
                                ?>
                                
                                <?php
                                
                                    if(isset($_POST['saidaOperadorCaixa'])){
                                        $fechar_caixa = "UPDATE tb_caixa SET
                                        dt_fechamento = '".$_POST['dt_fechamento']."',
                                        cd_colab_fechamento = '".$_POST['cd_colab_fechamento']."',
                                        total_movimento = '".$_POST['total_movimento_analitico']."',
                                        saldo_fechamento = '".$_POST['total_caixa_analitico']."',
                                        diferenca_caixa = '".$_POST['total_caixa_diferenca']."',
                                        fpag_dinheiro = '".$_POST['dinheiro_analitico']."',
                                        fpag_debito = '".$_POST['debito_analitico']."',
                                        fpag_credito = '".$_POST['credito_analitico']."',
                                        fpag_pix = '".$_POST['pix_analitico']."',
                                        fpag_cofre = '".$_POST['cofre_analitico']."',
                                        status_caixa = 1
                                        WHERE cd_filial = ".$_SESSION['cd_empresa']." AND cd_caixa = ".$_POST['cd_caixa']."";
                                        mysqli_query($conn, $fechar_caixa);
                                        echo "<script>window.alert('Caixa Fechado!');</script>";

                                        //colher valores
                                        //$select_caixa_dia_fiscal;

                                        $select_caixa_dia_fiscal = "SELECT * FROM tb_caixa_dia_fiscal WHERE cd_filial = ".$_SESSION['cd_empresa']." AND DATE(dt_abertura_dia_fiscal) = '".date('Y-m-d')."'";
                                        $result_caixa_dia_fiscal = mysqli_query($conn, $select_caixa_dia_fiscal);
                                        $row_caixa_dia_fiscal = mysqli_fetch_assoc($result_caixa_dia_fiscal);
                                        if($row_caixa_dia_fiscal) {
                                            $select_movimento_analitico = $row_caixa_dia_fiscal['movimento_analitico_dia_fiscal'];
                                            $select_movimento_conferido = $row_caixa_dia_fiscal['movimento_conferido_dia_fiscal'];
                                            $select_total_analitico = $row_caixa_dia_fiscal['total_analitico_dia_fiscal'];
                                            $select_total_conferido = $row_caixa_dia_fiscal['total_conferido_dia_fiscal'];
                                            $select_diferenca_total = $row_caixa_dia_fiscal['diferenca_caixa_dia_fiscal'];
                                            echo "<script>window.alert('Valores do dia fiscal colhidos para soma!');</script>";              
                                        }


                                        $update_caixa_dia_fiscal = "UPDATE tb_caixa_dia_fiscal SET
                                        movimento_analitico_dia_fiscal = '".($select_movimento_analitico + $_POST['total_movimento_analitico'])."',
                                        movimento_conferido_dia_fiscal = '".($select_movimento_conferido + $_POST['total_movimento_conferido'])."',
                                        total_analitico_dia_fiscal = '".($select_total_analitico + $_POST['total_caixa_analitico'])."',
                                        total_conferido_dia_fiscal = '".($select_total_conferido + $_POST['total_caixa_conferido'])."',
                                        diferenca_caixa_dia_fiscal = '".($select_diferenca_total + $_POST['total_caixa_diferenca'])."',
                                        status_caixa_dia_fiscal = 1
                                        WHERE cd_filial = ".$_SESSION['cd_empresa']." AND DATE(dt_abertura_dia_fiscal) = '".date('Y-m-d')."'";//WHERE dt_abertura_dia_fiscal = '".date('Y-m-d')."";
                                        mysqli_query($conn, $update_caixa_dia_fiscal);
                                        echo "<script>window.alert('Atualizar dia Fiscal!');</script>";
                                        

                                        $insert_conferencia = "INSERT INTO tb_caixa_conferido(cd_filial, cd_caixa_analitico, dt_conferencia, cd_colab_conferencia, saldo_abertura_conferido, saldo_fechamento_conferido, diferenca_caixa_conferido, saldo_movimento_conferido, fpag_dinheiro_conferido, fpag_debito_conferido, fpag_credito_conferido, fpag_pix_conferido, fpag_cofre_conferido, obs_conferencia) VALUES(
                                            '".$_SESSION['cd_empresa']."',
                                            '".$_POST['cd_caixa']."',
                                            '".$_POST['dt_fechamento']."',
                                            '".$_POST['cd_colab_fechamento']."',
                                            '".$_POST['suprimento_analitico']."',
                                            '".$_POST['total_caixa_conferido']."',
                                            '".$_POST['total_caixa_diferenca']."',
                                            '".$_POST['total_movimento_conferido']."',
                                            '".$_POST['dinheiro_conferido']."',
                                            '".$_POST['debito_conferido']."',
                                            '".$_POST['credito_conferido']."',
                                            '".$_POST['pix_conferido']."',
                                            '".$_POST['cofre_conferido']."',
                                            'Fechamento de Caixa (Normal)'
                                             )
                                         ";
                                        mysqli_query($conn, $insert_conferencia);
                                        echo "<script>window.alert('Caixa Conferido foi lançado!');</script>";
                                        //echo '<script>location.href="../../index.php";</script>';
                                        echo '<script>location.href="'.$_SESSION['dominio'].'/pages/dashboard/index.php";</script>';


                                    }
                                    

                                    
                                    
                                /*if(isset($_POST['fechamentoNormalCaixa'])){
                                        $query3 = "INSERT INTO tb_caixa_conferido(cd_caixa_conferido) VALUES(
                                           '".$_POST['cd_caixa']."',
                                            )
                                        ";
                                      mysqli_query($conn, $query3);
                                      echo "<script>window.alert('Caixa Fechado!');</script>";
                                      echo '<script>location.href="../../index.php";</script>';

                                      
                                    }*/

                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 grid-margin">
                            <div class="card">

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