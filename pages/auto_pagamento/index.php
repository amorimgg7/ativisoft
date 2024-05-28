
<?php //Gadget caixa 
    require_once '../../classes/conn_revenda.php';

  $dia_hoje = date('Y-m-d'); // Formatando a data de hoje para o formato do banco de dados (ano-mês-dia)
  $dia_ontem = date('Y-m-d', strtotime('-1 day'));
  //$dia_hoje = date('Y-m-d H:i', strtotime('+1 hour'));

  
    $select_cliente_comercial = "SELECT * FROM tb_cliente_comercial where cnpj_cliente_comercial = ".$_SESSION['cnpj_filial'];
    $resulta_cliente_comercial = $conn_revenda->query($select_cliente_comercial);
    if ($resulta_cliente_comercial->num_rows > 0){ 
        while ( $cliente_matriz = $resulta_cliente_comercial->fetch_assoc()){
        $data_fornecida = $cliente_matriz['dtvalidlicenca_cliente_comercial'];
        $diferenca_dias = round((strtotime($data_fornecida) - strtotime($dia_hoje)) / (60 * 60 * 24));
        if($diferenca_dias > 5){
            //echo '<div class="col-lg-12 grid-margin stretch-card btn-secondary">';//
            //echo '<div class="card" '.$_SESSION['c_card'].'>';
            //echo '<div class="card-body">';
            //echo '<h6 class="card-title">Sistema Licenciado.</h6>';
            //echo '</div>';
            //echo '</div>';
            //echo '</div>';
        }else if($diferenca_dias <= 5 && $diferenca_dias > 0){
            $_SESSION['bloqueado'] = 0;
            echo '<div class="col-lg-12 grid-margin stretch-card btn-secondary">';//
            echo '<div class="card" '.$_SESSION['c_card'].'>';
            echo '<div class="card-body">';
            //echo '<h6 class="card-title">Módulo Geral!</h6>';
            echo '<table class="table">';
            echo '<thead>';      
            echo '<th>';
            echo '<h6 class="card-title">Sistema Licenciado.</h6>';
            echo '<h6 class="card-title">Expira em: '.$diferenca_dias.' dia(s).</h6>';
            echo '</th>';
            echo '<th><form method="POST" action="'.$_SESSION['dominio'].'pages/auto_pagamento/payment.php">';
            echo '<input type="text" style="display: none;" readonly id="cd_cliente_comercial_pagamento" name="cd_cliente_comercial_pagamento" value="'.$_SESSION['cd_empresa'].'">';
            echo '<input type="text" style="display: none;" readonly id="cnpj_cliente_comercial_pagamento" name="cnpj_cliente_comercial_pagamento" value="'.$_SESSION['cnpj_empresa'].'">';
            echo '<input type="text" style="display: none;" readonly id="valor_pagamento" name="valor_pagamento" value="'.$cliente_matriz['fatura_prevista_cliente_fiscal'].'">';
            echo '<button type="submit" class="btn btn-secondary" name="pagar_pagamento" id="pagar_pagamento">Antecipar Renovação</button>';
            echo '</form></th>';
            echo '</thead>';
            echo '<tbody>';
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        } else if($diferenca_dias == 0){
            $_SESSION['bloqueado'] = 0;
            echo '<div class="col-lg-12 grid-margin stretch-card btn-success">';//
            echo '<div class="card" '.$_SESSION['c_card'].'>';
            echo '<div class="card-body">';
            //echo '<h6 class="card-title">Módulo Geral!</h6>';
            echo '<table class="table">';
            echo '<thead>';      
            echo '<th>';
            echo '<h6 class="card-title">Sua Licença Expira hoje.</h6>';
            echo '</th>';
            echo '<th><form method="POST" action="'.$_SESSION['dominio'].'pages/auto_pagamento/payment.php">';
            echo '<input type="text" style="display: none;" readonly id="cd_cliente_comercial_pagamento" name="cd_cliente_comercial_pagamento" value="'.$_SESSION['cd_empresa'].'">';
            echo '<input type="text" style="display: none;" readonly id="cnpj_cliente_comercial_pagamento" name="cnpj_cliente_comercial_pagamento" value="'.$_SESSION['cnpj_empresa'].'">';
            echo '<input type="text" style="display: none;" readonly id="valor_pagamento" name="valor_pagamento" value="'.$cliente_matriz['fatura_prevista_cliente_fiscal'].'">';
            echo '<button type="submit" class="btn btn-success" name="pagar_pagamento" id="pagar_pagamento">Antecipar Renovação</button>';
            echo '</form></th>';
            echo '</thead>';
            echo '<tbody>';
            echo '</tbody>';
            echo '</table>';
            
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }else if($diferenca_dias < 0 && $diferenca_dias > -10){
            $_SESSION['bloqueado'] = 1;
            echo '<div class="col-lg-12 grid-margin stretch-card btn-warning">';//
            echo '<div class="card" '.$_SESSION['c_card'].'>';
            echo '<div class="card-body">';

            echo '<div class="table-responsive">';
            echo '<table class="table">';
            echo '<thead>';      
            echo '<th>';
            echo '<h6 class="card-title">Licenciamento vencido a '.-$diferenca_dias.' dia(s)</h6>';
            echo '<label class="badge badge-warning">Parcela prevista: R$:'. $cliente_matriz['fatura_prevista_cliente_fiscal'] .'</label>';
            echo '</th>';
            echo '<th><form method="POST" action="'.$_SESSION['dominio'].'pages/auto_pagamento/payment.php">';
            echo '<input type="text" style="display: none;" readonly id="cd_cliente_comercial_pagamento" name="cd_cliente_comercial_pagamento" value="'.$_SESSION['cd_empresa'].'">';
            echo '<input type="text" style="display: none;" readonly id="cnpj_cliente_comercial_pagamento" name="cnpj_cliente_comercial_pagamento" value="'.$_SESSION['cnpj_empresa'].'">';
            echo '<input type="text" style="display: none;" readonly id="valor_pagamento" name="valor_pagamento" value="'.$cliente_matriz['fatura_prevista_cliente_fiscal'].'">';
            echo '<button type="submit" class="btn btn-warning" name="pagar_pagamento" id="pagar_pagamento">Renovar Licenciamento</button>';
            echo '</form></th>';
            echo '</thead>';
            echo '<tbody>';
            echo '</tbody>';
            echo '</table>';
            //echo '<td><p>Tolerância de 10 dias para multa prevista em contrato</p></td>';
            //echo '<td><label class="badge badge-warning">Parcela prevista: R$:'. $cliente_matriz['fatura_prevista_cliente_fiscal'] .'</label></td>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';  
        }else{
            $_SESSION['bloqueado'] = 2;
            echo '<div class="col-lg-12 grid-margin stretch-card btn-danger">';//
            echo '<div class="card" '.$_SESSION['c_card'].'>';
            echo '<div class="card-body">';
            
            echo '<div class="table-responsive">';
            echo '<table class="table">';
            echo '<thead>';
            echo '<th>';
            echo '<h6 class="card-title">Licenciamento vencido a '.-$diferenca_dias.' dia(s)</h6>';     
            echo '<h6 class="card-title">Tolerância de 10 dias para multa prevista em contrato</h6>';
            echo '<label class="badge badge-danger">Parcela prevista R$:' . ($cliente_matriz['fatura_prevista_cliente_fiscal'] + (-$diferenca_dias)) . '</label>';
            echo '</th>';
            echo '<th><form method="POST" action="'.$_SESSION['dominio'].'pages/auto_pagamento/payment.php">';
            echo '<input type="text" style="display: none;" readonly id="cd_cliente_comercial_pagamento" name="cd_cliente_comercial_pagamento" value="'.$_SESSION['cd_empresa'].'">';
            echo '<input type="text" style="display: none;" readonly id="cnpj_cliente_comercial_pagamento" name="cnpj_cliente_comercial_pagamento" value="'.$_SESSION['cnpj_empresa'].'">';
            echo '<input type="text" style="display: none;" readonly id="valor_pagamento" name="valor_pagamento" value="'.$cliente_matriz['fatura_prevista_cliente_fiscal'].'">';
            echo '<button type="submit" class="btn btn-danger" name="pagar_pagamento" id="pagar_pagamento">Renovar Licenciamento</button>';

            echo '';
            echo '</form></th>';
            
            echo '</thead>';
            echo '<tbody>';
            
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';  
        }
    } 
    }else{}

?>