
<?php //Gadget caixa 
    require_once '../../classes/conn.php';

    $dia_hoje = date('Y-m-d'); // Formatando a data de hoje para o formato do banco de dados (ano-mês-dia)
    $dia_ontem = date('Y-m-d', strtotime('-1 day'));
    //$dia_hoje = date('Y-m-d H:i', strtotime('+1 hour'));

    
        

        if($_SESSION['cd_acesso'] != "0"){
            
            $select_contrato = "SELECT * FROM tb_contrato where cd_empresa = ".$_SESSION['cd_empresa']." AND status_contrato = 'F'";
            $resulta_contrato = $conn->query($select_contrato);
            if ($resulta_contrato->num_rows > 0){ 
                while ( $row_contrato = $resulta_contrato->fetch_assoc()){
                    
                    $validade_contrato = $row_contrato['dt_validade'];
                    $diferenca_dias = round((strtotime($validade_contrato) - strtotime($dia_hoje)) / (60 * 60 * 24));
                    //echo '<h1>*'.$diferenca_dias.'*</h1>';
                    if($diferenca_dias > 5){
                        $_SESSION['bloqueado'] = 0;
                        //echo '<h1>*</h1>';
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
                echo '<h6 class="card-title">Contrato válido até: '.date("d/m/Y", strtotime($row_contrato['dt_validade'])).'.</h6>';
                echo '<h6 class="card-title">Expira em: '.$diferenca_dias.' dia(s).</h6>';
                echo '<h6 class="card-title">Entre em contato para renovar (21) 9 6554 3094</h6>';
                echo '</th>';
                echo '<th><form method="POST" action="'.$_SESSION['dominio'].'pages/auto_pagamento/payment.php">';
                echo '<input type="text" style="display: none;" readonly id="cd_cliente_comercial_pagamento" name="cd_cliente_comercial_pagamento" value="'.$_SESSION['cd_empresa'].'">';
                echo '<input type="text" style="display: none;" readonly id="cnpj_cliente_comercial_pagamento" name="cnpj_cliente_comercial_pagamento" value="'.$_SESSION['cnpj_empresa'].'">';
                //echo '<input type="text" style="display: none;" readonly id="valor_pagamento" name="valor_pagamento" value="'.$r['fatura_prevista_cliente_fiscal'].'">';
                //echo '<button type="submit" class="btn btn-secondary" name="pagar_pagamento" id="pagar_pagamento">Antecipar Renovação</button>';
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
                echo '<h6 class="card-title">Seu Contrato Expira hoje.</h6>';
                echo '<h6 class="card-title">Entre em contato para renovar (21) 9 6554 3094</h6>';
                echo '</th>';
                echo '<th><form method="POST" action="'.$_SESSION['dominio'].'pages/auto_pagamento/payment.php">';
                echo '<input type="text" style="display: none;" readonly id="cd_cliente_comercial_pagamento" name="cd_cliente_comercial_pagamento" value="'.$_SESSION['cd_empresa'].'">';
                echo '<input type="text" style="display: none;" readonly id="cnpj_cliente_comercial_pagamento" name="cnpj_cliente_comercial_pagamento" value="'.$_SESSION['cnpj_empresa'].'">';
                //echo '<input type="text" style="display: none;" readonly id="valor_pagamento" name="valor_pagamento" value="'.$cliente_matriz['fatura_prevista_cliente_fiscal'].'">';
                //echo '<button type="submit" class="btn btn-success" name="pagar_pagamento" id="pagar_pagamento">Antecipar Renovação</button>';
                echo '</form></th>';
                echo '</thead>';
                echo '<tbody>';
                echo '</tbody>';
                echo '</table>';
                
                echo '</div>';
                echo '</div>';
                echo '</div>';
                    }else if($diferenca_dias < 0 && $diferenca_dias > -10){
                        echo '<h1>*</h1>';
                $_SESSION['bloqueado'] = 1;
                echo '<div class="col-lg-12 grid-margin stretch-card btn-warning">';//
                echo '<div class="card" '.$_SESSION['c_card'].'>';
                echo '<div class="card-body">';

                echo '<div class="table-responsive">';
                echo '<table class="table">';
                echo '<thead>';      
                echo '<th>';
                echo '<h6 class="card-title">Contrato vencido a '.-$diferenca_dias.' dia(s)</h6>';
                echo '<h6 class="card-title">Entre em contato para renovar (21) 9 6554 3094</h6>';
                //echo '<label class="badge badge-warning">Parcela prevista: R$:'. $cliente_matriz['fatura_prevista_cliente_fiscal'] .'</label>';
                echo '</th>';
                echo '<th><form method="POST" action="'.$_SESSION['dominio'].'pages/auto_pagamento/payment.php">';
                echo '<input type="text" style="display: none;" readonly id="cd_cliente_comercial_pagamento" name="cd_cliente_comercial_pagamento" value="'.$_SESSION['cd_empresa'].'">';
                echo '<input type="text" style="display: none;" readonly id="cnpj_cliente_comercial_pagamento" name="cnpj_cliente_comercial_pagamento" value="'.$_SESSION['cnpj_empresa'].'">';
                //echo '<input type="text" style="display: none;" readonly id="valor_pagamento" name="valor_pagamento" value="'.$cliente_matriz['fatura_prevista_cliente_fiscal'].'">';
                //echo '<button type="submit" class="btn btn-warning" name="pagar_pagamento" id="pagar_pagamento">Renovar Licenciamento</button>';
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
                echo '<h6 class="card-title">Contrato vencido a '.-$diferenca_dias.' dia(s)</h6>';     
                echo '<h6 class="card-title">Entre em contato para renovar (21) 9 6554 3094</h6>';
                //echo '<h6 class="card-title">Renove já seu contrato e evite a interrupção do seu sistema</h6>';
                //echo '<label class="badge badge-danger">Parcela prevista R$:' . ($cliente_matriz['fatura_prevista_cliente_fiscal'] + (-$diferenca_dias)) . '</label>';
                echo '</th>';
                echo '<th><form method="POST" action="'.$_SESSION['dominio'].'pages/auto_pagamento/payment.php">';
                echo '<input type="text" style="display: none;" readonly id="cd_cliente_comercial_pagamento" name="cd_cliente_comercial_pagamento" value="'.$_SESSION['cd_empresa'].'">';
                echo '<input type="text" style="display: none;" readonly id="cnpj_cliente_comercial_pagamento" name="cnpj_cliente_comercial_pagamento" value="'.$_SESSION['cnpj_empresa'].'">';
                //echo '<input type="text" style="display: none;" readonly id="valor_pagamento" name="valor_pagamento" value="'.$cliente_matriz['fatura_prevista_cliente_fiscal'].'">';
                //echo '<button type="submit" class="btn btn-danger" name="pagar_pagamento" id="pagar_pagamento">Renovar Licenciamento</button>';
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
            }else{
                echo '<div class="col-lg-12 grid-margin stretch-card btn-secondary">';
                echo '<div class="card" '.$_SESSION['c_card'].'>';
                echo '<div class="card-body">';
                echo '<h6 class="card-title">Sem contrato.</h6>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        }else{
            if($_SESSION['cd_empresa'] != '0'){


                $sql_acesso = "SELECT * FROM tb_acesso WHERE cd_acesso = '2'"; 
                $resulta = $conn->query($sql_acesso);

                if ($resulta->num_rows > 0) {
                    echo '<div class="col-12 grid-margin stretch-card btn-success" ' . $_SESSION['c_card'] . '>';
                    echo '<div class="card" ' . $_SESSION['c_card'] . '>';
                    echo '<div class="card-body" ' . $_SESSION['c_card'] . '>';

                    $count = 0; // Contador de cards

                    echo '<div class="row">'; // Abre a primeira linha

                    while ($row = $resulta->fetch_assoc()) {

                        //$modulos_vantagens = []; // Inicia o array vazio
                        //$modulos_vantagens_str = ""; // Inicia a string vazia


                        if ($count > 0 && $count % 3 == 0) {
                            echo '</div><div class="row">'; // Fecha a linha atual e abre uma nova a cada 3 cards
                        }

                        echo '<div class="col-md-4 d-flex align-items-stretch" style="margin: 20px 0;">'; // Define 3 colunas por linha
                        echo '<div class="card text-center">';
                        if($row['vl_preco'] > 0){
                            echo '<div class="card-title">' . $row['cd_acesso'] . ' - ' . $row['titulo_acesso'] . '</br>R$: '.$row['vl_preco'].' por Mês ou R$: '.number_format(($row['vl_preco'] * 12) - $row['vl_desconto_ano'], 2, ',', '.').' por Ano</div>';
                        }else{
                            echo '<div class="card-title">' . $row['cd_acesso'] . ' - ' . $row['titulo_acesso'] . '</br>Free</div>';
                        }
                        echo '<div class="card-body">';
                        echo '<div class="table-responsive">';
                        echo '<table class="table table-sm"><tbody>';

                        // Consultar vantagens (módulos do cd_acesso = 1)
                        $acesso_modulo_vantagens = "SELECT ds_modulo FROM acesso_modulo WHERE cd_acesso = '". $row['cd_acesso']."'"; 
                        $resulta_acesso_vantagens = $conn->query($acesso_modulo_vantagens);

                        if ($resulta_acesso_vantagens->num_rows > 0) {
                            echo '<tr class="table-active"><td><p>Vantagens</p></td></tr>';

                            $modulos_vantagens = [];
                            while ($row_acesso_modulo = $resulta_acesso_vantagens->fetch_assoc()) {
                                $modulos_vantagens[] = "'" . $row_acesso_modulo['ds_modulo'] . "'"; // Salva os módulos para usar na consulta de desvantagens
                                echo '<tr class="table-info"><td><p class="card-text"><i class="icon-circle-check"></i> ' . $row_acesso_modulo['ds_modulo'] . '</p></td></tr>';
                            }
                        } else {
                            echo '<tr class="table-dark"><td><p class="card-text">Em Breve</p></td></tr>';
                        }

                        // Consultar desvantagens (módulos que NÃO estão na lista de vantagens)
                        if (!empty($modulos_vantagens)) {
                            $modulos_vantagens_str = implode(",", $modulos_vantagens);
                            $acesso_modulo_desvantagens = "
                                SELECT ds_modulo 
                                FROM acesso_modulo 
                                WHERE cd_acesso != '" . $row['cd_acesso'] . "'
                                AND ds_modulo NOT IN ($modulos_vantagens_str)
                                GROUP BY ds_modulo;
                            ";
                            $resulta_acesso_desvantagens = $conn->query($acesso_modulo_desvantagens);

                            if ($resulta_acesso_desvantagens->num_rows > 0) {
                                echo '<tr class="table-active"><td><p>Desvantagens</p></td></tr>';
                                while ($row_acesso_modulo = $resulta_acesso_desvantagens->fetch_assoc()) {
                                    echo '<tr class="table-warning"><td><p class="card-text"><i class="icon-circle-cross"></i> ' . $row_acesso_modulo['ds_modulo'] . '</p></td></tr>';
                                }
                            } else {
                                echo '<tr class="table-success"><td><p class="card-text">Plano Full Services</p></td></tr>';
                            }
                        }


                        echo '</tbody></table>';
                        echo '</div>'; // Fecha div table-responsive

                        echo '<div class="card-footer text-muted">';
                        echo '<form method="post" action="../cad_acesso/tratar_pagamento.php?id='.$row['cd_acesso'].'">';
                        echo '<input class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" type="submit" value="Plano Básico">';
                        echo '</form>';
                        echo '</div>'; // Fecha card-footer

                        echo '</div>'; // Fecha card-body
                        echo '</div>'; // Fecha card
                        echo '</div>'; // Fecha col-md-4

                        $count++;
                    }
                
                    //echo '<div class="card-title">Módulos Vantagens: </strong>' . implode(", ", array_keys($modulos_vantagens)) . '</div>';
                    //echo '<br><div class="card-title">Módulos Vantagens STR:' . $modulos_vantagens_str.'</div>';
                
                
                    echo '</div>'; // Fecha a última linha
                    echo '</div>'; // Fecha card-body
                    echo '</div>'; // Fecha card
                    echo '</div>'; // Fecha col-12 grid-margin
                }



            }else{
                echo '<div class="container text-center mt-5">';
                      echo '  <h1 class="mb-3">Vamos começar!</h1>';
                      echo '  <h4 class="mb-4">Conte um pouco sobre o seu negócio para que possamos te ajudar melhor.</h4>';
                      echo '  <form method="post" action="../cad_geral/unidade_operacional.php">';
                      echo '    <input class="btn btn-info btn-lg font-weight-medium" type="submit" value="Começar agora">';
                      echo '  </form>';
                      echo '</div>';
            }
        }

?>