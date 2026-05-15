
<?php //Gadget caixa 
    require_once '../../classes/conn.php';

    $dia_hoje = date('Y-m-d'); // Formatando a data de hoje para o formato do banco de dados (ano-mês-dia)
    $dia_ontem = date('Y-m-d', strtotime('-1 day'));
    //$dia_hoje = date('Y-m-d H:i', strtotime('+1 hour'));

    
        

        if($_SESSION['cd_acesso'] != "0"){
            

$_SESSION['bloqueado'] = 0;
$hoje = date('Y-m-d');

/* =========================
   FUNÇÃO DE PRIORIDADE
   ========================= */
function aplicarBloqueio($nivel){
    if($nivel > $_SESSION['bloqueado']){
        $_SESSION['bloqueado'] = $nivel;
    }
}

/* ======================================================
   1) CONTRATOS  (MOSTRA SOMENTE SE <= 10 DIAS)
   ====================================================== */

$select_contrato = "
SELECT * 
FROM tb_contrato 
WHERE cd_empresa = ".$_SESSION['cd_empresa']." 
AND status_contrato IN('A','F')
";

$resulta_contrato = $conn->query($select_contrato);

if ($resulta_contrato->num_rows > 0){

    while ($row_contrato = $resulta_contrato->fetch_assoc()){

        $validade = $row_contrato['dt_validade'];

        $dias = floor((strtotime($validade) - strtotime($hoje)) / 86400);

        // NÃO mostra nada se estiver longe do vencimento
        if($dias > 10){
            continue;
        }

        echo '<div class="col-lg-12 grid-margin stretch-card '.($dias<0?'btn-danger':'btn-warning').'">';
        echo '<div class="card '.$_SESSION['c_card'].'">';
        echo '<div class="card-body">';

        echo '<h5 class="card-title">Contrato nº '.$row_contrato['cd_contrato'].'</h5>';
        echo '<h6 class="card-title">Validade: '.date("d/m/Y", strtotime($validade)).'</h6>';

        if($dias > 0){
            aplicarBloqueio(1);
            echo '<h6 class="card-title text-warning">Contrato expira em '.$dias.' dia(s)</h6>';
        }
        elseif($dias == 0){
            aplicarBloqueio(1);
            echo '<h6 class="card-title text-warning"><b>Contrato expira HOJE</b></h6>';
        }
        else{
            aplicarBloqueio(2);
            echo '<h6 class="card-title text-danger"><b>Contrato vencido há '.abs($dias).' dia(s)</b></h6>';
        }

        echo '<h6 class="card-title">Entre em contato: (21) 9 6554-3094</h6>';

        echo '</div></div></div>';
    }
}
else{
    aplicarBloqueio(0);

    echo '<div class="col-lg-12 grid-margin stretch-card btn-secondary">';
    echo '<div class="card '.$_SESSION['c_card'].'">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">sem contrato ativo</h5>';
    echo '</div></div></div>';
}

/* ======================================================
   2) FINANCEIRO (MOSTRA SOMENTE <= 10 DIAS)
   ====================================================== */

$select_financeiro = "
SELECT *
FROM tb_movimento_financeiro
WHERE cd_filial = '".$_SESSION['cd_empresa']."'
AND cd_cliente_comercial = '".$_SESSION['cd_empresa']."'
AND status_movimento = 'A'
ORDER BY data_movimento ASC
";

$resulta_financeiro = $conn->query($select_financeiro);

$count = 0;
$total = 0;
$linhas = '';

while ($row = $resulta_financeiro->fetch_assoc()){

    $venc = $row['data_movimento'];

    $dias = floor((strtotime($venc) - strtotime($hoje)) / 86400);

    // só 10 dias
    if($dias > 10){
        continue;
    }

    // STATUS + BLOQUEIO
    if($dias < 0){
        aplicarBloqueio(2);
        $status = "<span style='color:red;font-weight:bold'>Vencido há ".abs($dias)." dia(s)</span>";
    }
    elseif($dias == 0){
        aplicarBloqueio(1);
        $status = "<span style='color:orange;font-weight:bold'>Vence hoje</span>";
    }
    else{
        aplicarBloqueio(1);
        $status = "<span style='color:green;font-weight:bold'>Vence em ".$dias." dia(s)</span>";
    }

    $count++;
    $total += $row['valor_movimento'];

    $obs = trim($row['obs_movimento']);
    if($obs == '') $obs = '-';

    $linhas .= '
        <tr>
            <td>'.$count.'</td>
            <td>'.$obs.'</td>
            <td>'.$status.'</td>
        </tr>
    ';
}

/* ---------- MOSTRA O CARD SÓ SE EXISTIR PARCELA ---------- */

if($count > 0){

    echo '<div class="col-lg-12 grid-margin stretch-card btn-secondary">';
    echo '<div class="card '.$_SESSION['c_card'].'">';
    echo '<div class="card-body">';
    echo '<h6 class="card-title">Entre em contato: (21) 9 6554-3094</h6>';

    echo '<h5 class="card-title">Parcelas próximas do vencimento</h5>';

    echo '<table class="table table-striped">';
    echo '
    <thead>
        <tr>
            <th>#</th>
            <!--<th>Valor</th>-->
            <th>Observação</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>'.$linhas.'</tbody>
    </table>';

    //echo '<p>Total devido: R$ '.number_format($total,2,'.','.').'</p>';
    //echo "<p>BLOQUEIO FINAL: ".$_SESSION['bloqueado']."</p>";

    echo '</div></div></div>';
}

/* DEBUG (opcional remover) */


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