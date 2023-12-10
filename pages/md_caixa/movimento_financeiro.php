<?php
if($_SESSION['dt_caixa'] == FALSE){

    echo '<div class="col-12 grid-margin stretch-card btn-warning" '.$_SESSION['c_card'].'>';//
    echo '<div class="card" '.$_SESSION['c_card'].'>';
    //echo '<div class="card-body">';
    echo '<h1 class="card-title">Abra já seu caixa</h1>';
    echo '<p class="card-title">Para realizar movimento financeiro, o seu caixa deve estar devidamente aberto</p>';
    //echo '</div>';
    echo '</div>';
    echo '</div>';

    
}
if($_SESSION['dt_caixa'] == "HOJE"){
    echo '<div class="col-12 grid-margin stretch-card btn-success">';//
    echo '<div class="card" '.$_SESSION['c_card'].'>';
    echo '<div class="card-body">';
    
    echo '<h4 class="card-title" style="text-align: center;">ID Caixa:'.$_SESSION['cd_caixa'].'</h4>';
    echo '<div class="collapse" id="sangria_caixa">';//ferramentas_caixa
    
    echo '<h4 class="card-title">Sangria</h4>';
        echo '<form method="POST">';
        echo '<div class="form-group">';
        echo '<div class="input-group">';
        echo '<div class="input-group-prepend">';
        echo '<span class="input-group-text btn-outline-info">R$:</span>';
        echo '</div>';
        echo '<input type="tel" id="cd_caixa" name="cd_caixa" value="'.$_SESSION['cd_caixa'].'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" style="display:none;" required >';
        echo '<input type="tel" id="cd_colab" name="cd_colab" value="'.$_SESSION['cd_colab'].'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" style="display:none;" required>';
        echo '<input type="tel" id="valor_sangria" name="valor_sangria" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" required>';
        echo '<div class="input-group-prepend">';
        echo '<span class="input-group-text btn-outline-info">MOTIVO</span>';
        echo '</div>';
        echo '<input type="textarea" id="obs_sangria" name="obs_sangria" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" required>';
        echo '<div class="input-group-append">';
        //echo '<span class="input-group-text">SUPRIMENTO</span>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '<button type="submit" id="sangria_caixa" name="sangria_caixa" class="btn btn-lg btn-block btn-outline-danger btn-light" style="margin: 5px;"><i class="mdi mdi-file-check"></i>Sangria</button>';
        echo '</form>';
        
    
    echo '</div> ';


    echo '<div class="collapse" id="suprimento_caixa">';
    
    echo '<h4 class="card-title">Suprimento</h4>';
        echo '<form method="POST" action="abertura_caixa.php" >';
        echo '<div class="form-group">';
        echo '<div class="input-group">';
        echo '<div class="input-group-prepend">';
        echo '<span class="input-group-text btn-outline-info">R$:</span>';
        echo '</div>';
        echo '<input type="tel" id="cd_caixa" name="cd_caixa" value="'.$_SESSION['cd_caixa'].'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" style="display:none;" required >';
        echo '<input type="tel" id="cd_colab" name="cd_colab" value="'.$_SESSION['cd_colab'].'" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" style="display:none;" required>';
        echo '<input type="tel" id="valor_suprimento" name="valor_suprimento" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" required>';
        echo '<div class="input-group-prepend">';
        echo '<span class="input-group-text btn-outline-info">MOTIVO</span>';
        echo '</div>';
        echo '<input type="textarea" id="obs_suprimento" name="obs_suprimento" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" required>';
        echo '<div class="input-group-append">';
        //echo '<span class="input-group-text">SUPRIMENTO</span>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '<button type="submit" id="suprimento_caixa" name="suprimento_caixa" class="btn btn-lg btn-block btn-outline-success btn-light" style="margin: 5px;"><i class="mdi mdi-file-check"></i>Surimento</button>';
        echo '</form>';
        
    
    echo '</div> ';

    echo '<div class="collapse" id="ferramentas_caixa">';
    

        echo '<form action="impresso.php" method="POST" target="_blank">';
                                        

                                        echo '<h4 class="card-title">Ferramentas</h4>';
                                        
                                        echo '<div style="display: none;">';
                                        echo '<input value="'.$_SESSION['cd_colab'].'" name="cd_colab_abertura" id="cd_colab_abertura" type="text" class="aspNetDisabled form-control form-control-sm"/>';
                                        echo '<input value="'.$dataHoraAtual.'" name="dt_abertura" id="dt_abertura" type="text" class="aspNetDisabled form-control form-control-sm"/>';
                                        
                                        echo '</div>';
                                        echo '<div>';
                                        
                                        echo '<div class="form-group">';
                                        echo '<div class="input-group">';
                                        echo '<div class="input-group-prepend">';
                                        echo '<span class="input-group-text btn-outline-info">EMISSÃO</span>';
                                        echo '</div>'; 
                                        echo '<input value="'.date('d/m/Y H:i', strtotime('+1 hour')).'" name="dt_emissao" type="text" id="dt_emissao" class="aspNetDisabled form-control form-control-sm" readonly/>';
                                        echo '<div class="input-group-append">';
                                        //echo '<span class="input-group-text">.00</span>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '</div>';

                                        echo '<div class="form-group">';
                                        echo '<div class="input-group">';
                                        echo '<div class="input-group-prepend">';
                                        echo '<span class="input-group-text btn-outline-info">INÍCIO</span>';
                                        echo '</div>'; 
                                        echo '<input name="dt_inicio" type="date" id="dt_inicio" class="aspNetDisabled form-control form-control-sm" required/>';
                                        echo '<div class="input-group-append">';
                                        //echo '<span class="input-group-text">.00</span>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '</div>';

                                        echo '<div class="form-group">';
                                        echo '<div class="input-group">';
                                        echo '<div class="input-group-prepend">';
                                        echo '<span class="input-group-text btn-outline-info">FIM</span>';
                                        echo '</div>'; 
                                        echo '<input name="dt_fim" type="date" id="dt_fim" class="aspNetDisabled form-control form-control-sm"/>';
                                        echo '<div class="input-group-append">';
                                        //echo '<span class="input-group-text">.00</span>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '</div>';


                                        
                                        
                                        echo '</div>';
                                        
                                        echo '<button type="submit" name="rel_fechamento_caixa" id="rel_fechamento_caixa" class="btn btn-lg btn-block btn-outline-warning" style="margin: 5px;"><i class="mdi mdi-file-check"></i>Imprimir Relatório</button>';
        
                                        
                                        echo '</form>';


        
    
    echo '</div> ';

    
    if($_SESSION['tela_movimento_financeiro'] == "VENDA_SERVICO"){

        $select_vpag = "SELECT * FROM tb_movimento_financeiro WHERE cd_os_movimento = '".$_SESSION['servico']."' ORDER BY cd_movimento ASC";
        $result_vpag = mysqli_query($conn, $select_vpag);
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
        $count = 0;
        echo '<h4 class="card-title" style="text-align: center;">Histórico de Pagamento</h4>';
        while($row_vpag = $result_vpag->fetch_assoc()) {
            echo '<div class="typeahead" style="background-color: #C6C6C6;">';
            echo '<div class="horizontal-form">';
            echo '<div class="form-group">';
            $count = $count + 1;
                      
            //echo '<label for="listadt_movimento">#'.$count.'</label>';
            echo '<label for="listadt_movimento">CX'.$row_vpag['cd_caixa_movimento'].'</label>';
            echo '<input value="'.date('d/m/y', strtotime($row_vpag['data_movimento'])).'" name="listadt_movimento" id="listadt_movimento" type="text" class="aspNetDisabled form-control form-control-sm" readonly>';
            echo '<label for="listavalor_movimento"></label>';
            echo '<input value="'.$row_vpag['fpag_movimento'].'" name="listavalor_movimento" id="listavalor_movimento" type="tel" class="aspNetDisabled form-control form-control-sm" placeholder="" readonly>';
            echo '<label for="listavalor_movimento"></label>';
            echo '<input value="R$:'.$row_vpag['valor_movimento'].'" name="listavalor_movimento" id="listavalor_movimento" type="tel" class="aspNetDisabled form-control form-control-sm" placeholder="" readonly>';
            //echo '<label for="listaremover_orcamento"></label>';
            //echo '<input type="submit" value="X" onclick="location.reload()" name="listaremover_orcamento" id="listaremover_orcamento" class="btn btn-danger">';
            //echo '<input type="submit" value="X" name="listaremover_orcamento" id="listaremover_orcamento" class="btn btn-danger">';
            echo '</div>';
            echo '</div>';
            //echo '</form>';
            echo '</div>';
        }
        if($_SESSION['vpag_servico'] == $_SESSION['vtotal_orcamento']){
                    
        }else{
        echo '<form method="POST" id="tela_pagamento" name="tela_pagamento">';
        //echo '<div class="form-group btn-block">';
        echo '<div class="input-group">';
        echo '<div class="input-group-prepend">';
        echo '<span class="input-group-text btn-outline-success">FORMA DE PAGAMENTO:</span>';
        echo '</div>'; 
        echo '<select id="fpag_movimento" name="fpag_movimento" type="tel" class="form-control form-control-lg " required>';
        echo '<option selected value=""></option>';
        //echo '<option value="DINHEIRO">Dinheiro</option>';
        //echo '<option value="DEBITO">Débito</option>';
        //echo '<option value="CREDITO">Crédito</option>';
        //echo '<option value="PIX">PIX</option>';
        //echo '<option value="COFRE">COFRE</option>';
        //echo '<option value="BOLETO">Boleto</option>';


        $sql_describe = "DESCRIBE tb_caixa";
        $result_describe = mysqli_query($conn, $sql_describe);

        $found_start = false;

        if ($result_describe) {
            while ($row_describe = mysqli_fetch_assoc($result_describe)) {
                if ($row_describe['Field'] == 'diferenca_caixa') {
                    $found_start = true;
                    continue; // Começar a coleta após encontrar a coluna "diferenca_caixa"
                }

                if ($found_start && $row_describe['Field'] == 'fpag_boleto') {
                    break; // Parar a coleta após encontrar a coluna "status_caixa"
                }

                if ($found_start) {
                    $column_name = str_replace('fpag_', '', $row_describe['Field']);
                    //echo $column_name . "<br>";
                    echo '<option value="'.$column_name.'">'.$column_name.'</option>';

                }
            }
        } else {
            echo "Erro na consulta: " . mysqli_error($conn);
        }



        echo '</select>';
        echo '</div>';
        //echo '</div>';

        //echo '<div class="form-group">';
        echo '<div class="input-group">';
        echo '<div class="input-group-prepend">';
        echo '<span class="input-group-text btn-outline-info">R$:</span>';
        echo '</div>'; 
        echo '<input id="vpag_movimento" name="vpag_movimento" type="tel" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" required oninput="validateInput(this)">';
        echo '<span id="error-message" style="color: red;"></span>';

        echo '<script>';
        echo 'function validateInput(inputElement) {';
        echo 'var inputValue = inputElement.value;';
        echo 'var errorMessageElement = document.getElementById("error-message");';
        echo 'if (isNaN(inputValue) || inputValue < 0.1 || inputValue > '.$_SESSION['falta_pagar_servico'].') {';
        echo 'errorMessageElement.textContent = "O valor pago deve ser maior que 1 e menor ou igual a '.$_SESSION['falta_pagar_servico'].'.";';
        echo 'inputElement.setCustomValidity("O valor pago deve ser maior que 1 e menor ou igual a '.$_SESSION['falta_pagar_servico'].'.");';
        echo '} else {';
        echo 'errorMessageElement.textContent = "";';
        echo 'inputElement.setCustomValidity("");';
        echo '}';
        echo '}';
        echo '</script>';

        echo '</div>';
        //echo '</div>';

        echo '<button type="submit" name="pagar_servico" id="pagar_servico" class="btn btn-lg btn-block btn-outline-success btn-light"><i class="mdi mdi-file-check"></i>Lançar Pagamento</button>';
        echo '</form>';
        }
    echo '</div>';
    echo '</div>';
    echo '</div>';
        
    }
}

if($_SESSION['dt_caixa'] == "ONTEM"){
    echo '<div class="col-12 grid-margin stretch-card btn-warning">';//
    echo '<div class="card" '.$_SESSION['c_card'].'>';
    //echo '<div class="card-body">';
    
    echo '<h4 class="card-title" style="text-align: center;">ID Caixa:'.$_SESSION['cd_caixa'].'</h4>';
    
    
    //echo '</div>';
    
    
    if($_SESSION['tela_movimento_financeiro'] == "VENDA_SERVICO"){

        $select_vpag = "SELECT * FROM tb_movimento_financeiro WHERE cd_os_movimento = '".$_SESSION['servico']."' ORDER BY cd_movimento ASC";
        $result_vpag = mysqli_query($conn, $select_vpag);
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
        $count = 0;
        echo '<h4 class="card-title" style="text-align: center;">Histórico de Pagamento</h4>';
        echo '<div class="card-body">';
        echo '<h1 class="card-title" style="text-align: center;">O Caixa de ontem está aberto</h1>';
        echo '<p class="card-title">Realize o correto fechamento do seu caixa de ontem e abra novamente, só assim poderá registrar movimentos financeiros</p>';
        echo '</div>';
        while($row_vpag = $result_vpag->fetch_assoc()) {
            echo '<div class="typeahead" style="background-color: #C6C6C6;">';
            echo '<div class="horizontal-form">';
            echo '<div class="form-group">';
            $count = $count + 1;
                      
            //echo '<label for="listadt_movimento">#'.$count.'</label>';
            echo '<label for="listadt_movimento">CX'.$row_vpag['cd_caixa_movimento'].'</label>';
            echo '<input value="'.date('d/m/y', strtotime($row_vpag['data_movimento'])).'" name="listadt_movimento" id="listadt_movimento" type="text" class="aspNetDisabled form-control form-control-sm" readonly>';
            echo '<label for="listavalor_movimento"></label>';
            echo '<input value="'.$row_vpag['fpag_movimento'].'" name="listavalor_movimento" id="listavalor_movimento" type="tel" class="aspNetDisabled form-control form-control-sm" placeholder="" readonly>';
            echo '<label for="listavalor_movimento"></label>';
            echo '<input value="R$:'.$row_vpag['valor_movimento'].'" name="listavalor_movimento" id="listavalor_movimento" type="tel" class="aspNetDisabled form-control form-control-sm" placeholder="" readonly>';
            //echo '<label for="listaremover_orcamento"></label>';
            //echo '<input type="submit" value="X" onclick="location.reload()" name="listaremover_orcamento" id="listaremover_orcamento" class="btn btn-danger">';
            //echo '<input type="submit" value="X" name="listaremover_orcamento" id="listaremover_orcamento" class="btn btn-danger">';
            echo '</div>';
            echo '</div>';
            //echo '</form>';
            echo '</div>';
        }
        if($_SESSION['vpag_servico'] == $_SESSION['vtotal_orcamento']){
                    
        }else{
            echo '<form method="POST" id="tela_pagamento" name="tela_pagamento">';
        //echo '<div class="form-group btn-block">';
        echo '<div class="input-group">';
        echo '<div class="input-group-prepend">';
        echo '<span class="input-group-text btn-outline-success">FORMA DE PAGAMENTO:</span>';
        echo '</div>'; 
        echo '<select id="fpag_movimento" name="fpag_movimento" type="tel" class="form-control form-control-lg " required>';
        echo '<option selected value=""></option>';
        //echo '<option value="DINHEIRO">Dinheiro</option>';
        //echo '<option value="DEBITO">Débito</option>';
        //echo '<option value="CREDITO">Crédito</option>';
        //echo '<option value="PIX">PIX</option>';
        //echo '<option value="COFRE">COFRE</option>';
        //echo '<option value="BOLETO">Boleto</option>';


        $sql_describe = "DESCRIBE tb_caixa";
        $result_describe = mysqli_query($conn, $sql_describe);

        $found_start = false;

        if ($result_describe) {
            while ($row_describe = mysqli_fetch_assoc($result_describe)) {
                if ($row_describe['Field'] == 'diferenca_caixa') {
                    $found_start = true;
                    continue; // Começar a coleta após encontrar a coluna "diferenca_caixa"
                }

                if ($found_start && $row_describe['Field'] == 'fpag_boleto') {
                    break; // Parar a coleta após encontrar a coluna "status_caixa"
                }

                if ($found_start) {
                    $column_name = str_replace('fpag_', '', $row_describe['Field']);
                    //echo $column_name . "<br>";
                    echo '<option value="'.$column_name.'">'.$column_name.'</option>';

                }
            }
        } else {
            echo "Erro na consulta: " . mysqli_error($conn);
        }



        echo '</select>';
        echo '</div>';
        //echo '</div>';

        //echo '<div class="form-group">';
        echo '<div class="input-group">';
        echo '<div class="input-group-prepend">';
        echo '<span class="input-group-text btn-outline-info">R$:</span>';
        echo '</div>'; 
        echo '<input id="vpag_movimento" name="vpag_movimento" type="tel" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" required oninput="validateInput(this)">';
        echo '<span id="error-message" style="color: red;"></span>';

        echo '<script>';
        echo 'function validateInput(inputElement) {';
        echo 'var inputValue = inputElement.value;';
        echo 'var errorMessageElement = document.getElementById("error-message");';
        echo 'if (isNaN(inputValue) || inputValue < 0.1 || inputValue > '.$_SESSION['falta_pagar_servico'].') {';
        echo 'errorMessageElement.textContent = "O valor pago deve ser maior que 1 e menor ou igual a '.$_SESSION['falta_pagar_servico'].'.";';
        echo 'inputElement.setCustomValidity("O valor pago deve ser maior que 1 e menor ou igual a '.$_SESSION['falta_pagar_servico'].'.");';
        echo '} else {';
        echo 'errorMessageElement.textContent = "";';
        echo 'inputElement.setCustomValidity("");';
        echo '}';
        echo '}';
        echo '</script>';

        echo '</div>';
        //echo '</div>';

        echo '<button type="submit" name="pagar_servico" id="pagar_servico" class="btn btn-lg btn-block btn-outline-success btn-light"><i class="mdi mdi-file-check"></i>Lançar Pagamento</button>';
        echo '</form>';

            
        }
        
    }


    echo '</div>';
    echo '</div>';


    

    
}

if($_SESSION['dt_caixa'] == "ANTERIOR"){
    echo '<div class="col-12 grid-margin stretch-card btn-danger">';//
    echo '<div class="card" '.$_SESSION['c_card'].'>';
    //echo '<div class="card-body">';
    
    echo '<h4 class="card-title" style="text-align: center;">ID Caixa:'.$_SESSION['cd_caixa'].'</h4>';
    
    
    //echo '</div>';


    if($_SESSION['tela_movimento_financeiro'] == "VENDA_SERVICO"){

        $select_vpag = "SELECT * FROM tb_movimento_financeiro WHERE cd_os_movimento = '".$_SESSION['servico']."' ORDER BY cd_movimento ASC";
        $result_vpag = mysqli_query($conn, $select_vpag);
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
        $count = 0;
        echo '<h4 class="card-title" style="text-align: center;">Histórico de Pagamento</h4>';
        while($row_vpag = $result_vpag->fetch_assoc()) {
            echo '<div class="typeahead" style="background-color: #C6C6C6;">';
            echo '<div class="horizontal-form">';
            echo '<div class="form-group">';
            $count = $count + 1;
                      
            //echo '<label for="listadt_movimento">#'.$count.'</label>';
            echo '<label for="listadt_movimento">CX'.$row_vpag['cd_caixa_movimento'].'</label>';
            echo '<input value="'.date('d/m/y', strtotime($row_vpag['data_movimento'])).'" name="listadt_movimento" id="listadt_movimento" type="text" class="aspNetDisabled form-control form-control-sm" readonly>';
            echo '<label for="listavalor_movimento"></label>';
            echo '<input value="'.$row_vpag['fpag_movimento'].'" name="listavalor_movimento" id="listavalor_movimento" type="tel" class="aspNetDisabled form-control form-control-sm" placeholder="" readonly>';
            echo '<label for="listavalor_movimento"></label>';
            echo '<input value="R$:'.$row_vpag['valor_movimento'].'" name="listavalor_movimento" id="listavalor_movimento" type="tel" class="aspNetDisabled form-control form-control-sm" placeholder="" readonly>';
            //echo '<label for="listaremover_orcamento"></label>';
            //echo '<input type="submit" value="X" onclick="location.reload()" name="listaremover_orcamento" id="listaremover_orcamento" class="btn btn-danger">';
            //echo '<input type="submit" value="X" name="listaremover_orcamento" id="listaremover_orcamento" class="btn btn-danger">';
            echo '</div>';
            echo '</div>';
            //echo '</form>';
            echo '</div>';
        }
        if($_SESSION['vpag_servico'] == $_SESSION['vtotal_orcamento']){
                    
        }else{
            
        }
        echo '<div class="card-body">';
        echo '<h1 class="card-title" style="text-align: center;">Caixa aberto a vários dias</h1>';
        echo '<p class="card-title">Realize o correto fechamento do seu caixa aberto a vários dias e abra novamente, só assim poderá registrar movimentos financeiros</p>';
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';
}


?>