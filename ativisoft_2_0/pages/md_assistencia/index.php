<div class="col-lg-12 grid-margin stretch-card">
<i type="submit" class="btn btn-success"style="margin:auto; display:none;"id="noprazo">No prazo</i>
<i type="submit" class="btn btn-warning"style="margin:auto; display:none;"id="parahoje">Previsto para hoje</i>
<i type="submit" class="btn btn-danger"style="margin:auto; display:none;" id="extrapolado">Prazo extrapolado</i>
</div>

            <?php //Financeiro
              //"SELECT marca_patrimonio, modelo_patrimonio, COUNT(*) AS total FROM tb_patrimonio WHERE tipo_patrimonio = 'Impressora' GROUP BY marca_patrimonio, modelo_patrimonio";
              //$sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 0";
              /*
              $sql_devendo = "  SELECT 
                  CONCAT(c.pnome_cliente, ' ', c.snome_cliente, ' ', c.tel1_pessoa) AS full_cliente,
                  c.tel1_pessoa, 
                  SUM(s.orcamento_servico) AS total_orcamento, 
                  SUM(COALESCE(s.vpag_servico, 0)) AS total_pago, 
                  SUM(s.orcamento_servico) - SUM(COALESCE(s.vpag_servico, 0)) AS saldo_faltante
              FROM 
                  tb_servico s
              JOIN 
                  tb_cliente c 
              ON 
                  s.cd_cliente = c.cd_cliente
              WHERE 
                  s.status_servico != 4
              GROUP BY 
                  c.cd_cliente, c.pnome_cliente, c.snome_cliente, c.tel1_pessoa
              HAVING 
                  saldo_faltante > 0
              ORDER BY 
                  saldo_faltante DESC;";
              */

              $sql_devendo = "SELECT 
                  CONCAT(c.pnome_pessoa, ' ', c.snome_pessoa, ' ', c.tel1_pessoa) AS full_cliente,
                  c.tel1_pessoa, 
                  SUM(s.orcamento_servico) AS total_orcamento, 
                  SUM(COALESCE(s.vpag_servico, 0)) AS total_pago, 
                  SUM(s.orcamento_servico) - SUM(COALESCE(s.vpag_servico, 0)) AS saldo_faltante
              FROM 
                  tb_servico s
              JOIN 
                  tb_pessoa c 
              ON 
                  s.cd_cliente = c.cd_pessoa
              WHERE 
                  s.status_servico != 4 and
                  s.cd_filial = '".$_SESSION['cd_empresa']."'
              GROUP BY 
                  c.cd_pessoa, c.pnome_pessoa, c.snome_pessoa, c.tel1_pessoa
              HAVING 
                  SUM(s.orcamento_servico) - SUM(COALESCE(s.vpag_servico, 0)) > 0
              ORDER BY 
                  saldo_faltante DESC;
              ";
              $resulta_devendo = $conn->query($sql_devendo);
              if ($resulta_devendo->num_rows > 0){
                echo '<div class="col-lg-12 grid-margin stretch-card" data-toggle="collapse" href="#clientes_devendo" aria-expanded="false" aria-controls="clientes_devendo">';
                echo '<div class="card" '.$_SESSION['c_card'].'>';
                
                echo '<div class="card-body">';
                echo '<div class="grid-margin stretch-card">';
                echo '<h4 id="qtdValClientesDevendo">?</h4>';
                //echo '<i class="btn btn-success" style="margin:auto; display:none;" id="qtdClientesDevendo"></i><i class="btn btn-danger" style="margin:auto; display:none;" id="vtotalClientesDevendo"></i>';
                
                echo '</div>';

                
                echo '<div class="collapse table-responsive" id="clientes_devendo">';
                
                echo '<table class="table" '.$_SESSION['c_card'].'>';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Cliente</th>';
                echo '<th>Total Pago</th>';
                echo '<th>Devendo</th>';
                
                
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                $qtdClientesDevendo = 0;
                $vtotalClientesDevendo = 0;
                while ( $devendo = $resulta_devendo->fetch_assoc()){
                  echo '<tr>';
                 
                  echo "<td><a class='btn btn-danger' style='margin: 5px;' href='".$_SESSION['dominio']."pages/md_assistencia/acompanha_servico.php?cnpj=".$_SESSION['cnpj_empresa']."&tel=".$devendo['tel1_pessoa']."'>".$devendo['full_cliente']."</td>";
                  echo "<td>R$:".number_format($devendo['total_pago'], 2, ',', '.')."</td>";
                  echo "<td>R$:".number_format($devendo['saldo_faltante'], 2, ',', '.')."</td>";
                  
                  
                  $qtdClientesDevendo ++;
                  
                  $vtotalClientesDevendo += $devendo['saldo_faltante'];

		              
                }
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                
                if($qtdClientesDevendo > 0){
                  echo '<script>document.getElementById("qtdClientesDevendo").innerHTML = " ('.$qtdClientesDevendo.') ";</script>';
                  echo '<script>document.getElementById("obsQtdClientesDevendo").innerHTML = "Clientes Devendo: '.$qtdClientesDevendo.'";</script>';
                  echo '<script>document.getElementById("qtdClientesDevendo").style.display = "block";</script>';
                  echo '<script>document.getElementById("obsQtdClientesDevendo").style.display = "block";</script>';
                }
                if($vtotalClientesDevendo > 0){
                  echo '<script>document.getElementById("vtotalClientesDevendo").innerHTML = " (R$:'.number_format($vtotalClientesDevendo, 2, ',', '.').') ";</script>';
                  echo '<script>document.getElementById("obsVtotalClientesDevendo").innerHTML = "Total a Receber R$:'.number_format($vtotalClientesDevendo, 2, ',', '.').'";</script>';
                  echo '<script>document.getElementById("vtotalClientesDevendo").style.display = "block";</script>';
                  echo '<script>document.getElementById("obsVtotalClientesDevendo").style.display = "block";</script>';
                }

                echo '<script>document.getElementById("qtdValClientesDevendo").innerHTML = " Total de dívida ativa R$:'.number_format($vtotalClientesDevendo, 2, ',', '.').' ";</script>';
                echo '<script>document.getElementById("qtdValClientesDevendo").style.display = "block";</script>';

                
              }
            ?>


            <?php //À FAZER
              $extrapolado = 0;
              $extrapoladoafaser = 0;
              $parahoje = 0;
              $parahojeafazer = 0;
              $noprazo = 0;
              $noprazoafaser = 0;
              $extrapoladoemandamento = 0;
              $parahojeemandamento = 0;
              $noprazoemandamento = 0;



              //"SELECT marca_patrimonio, modelo_patrimonio, COUNT(*) AS total FROM tb_patrimonio WHERE tipo_patrimonio = 'Impressora' GROUP BY marca_patrimonio, modelo_patrimonio";
              //$sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 0";
              $sql_servico = "SELECT 
                  s.*, 
                  c.vl_comissao AS comissao_lancada
              FROM tb_servico s
              LEFT JOIN tb_comissao c 
                  ON c.cd_servico = s.cd_servico
              WHERE s.status_servico = 0 
                AND s.cd_filial = '".$_SESSION['cd_empresa']."'
              ORDER BY 
                  CASE 
                      WHEN s.prioridade_servico = 'U' THEN 1
                      WHEN s.prioridade_servico = 'A' THEN 2
                      WHEN s.prioridade_servico = 'M' THEN 3 
                      ELSE 4
                  END, 
                  s.cd_servico;";

              $resulta_servico = $conn->query($sql_servico);
              if ($resulta_servico->num_rows > 0){
                echo '<div class="col-lg-12 grid-margin stretch-card" data-toggle="collapse" href="#os_afaser" aria-expanded="false" aria-controls="os_afaser">';
                echo '<div class="card" '.$_SESSION['c_card'].'>';
                
                echo '<div class="card-body">';
                echo '<div class="grid-margin stretch-card">';
                echo '<h4 style="display: inline-block; margin-left: 10px;">À FAZER</h4>';
                echo '<i class="btn btn-success" style="margin:auto; display:none;" id="noprazoafaser"></i><i class="btn btn-warning" style="margin:auto; display:none;" id="parahojeafaser"></i><i class="btn btn-danger" style="margin:auto; display:none;" id="extrapoladoafaser"></i>';
                echo '</div>';

                
                echo '<div class="collapse table-responsive" id="os_afaser">';
                
                echo '<table class="table" '.$_SESSION['c_card'].'>';
                echo '<thead>';
                echo '<tr>';
                echo '<th>OS</th>';
                echo '<th>Financeiro</th>';
                echo '<th>Prioridade</th>';
                echo '<th>Prazo</th>';
                
                
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                
                while ( $servico = $resulta_servico->fetch_assoc()){
                  echo '<tr>';
                  echo '<form method="POST" action="../../pages/md_assistencia/consulta_servico.php">';
                  echo '<td style="display: none;"><input type="tel" id="conos_servico" name="conos_servico" value="'.$servico['cd_servico'].'"></td>';
                  echo '<td><button type="submit" class="btn btn-danger" name="btn_cd_'.$servico['cd_servico'].'" id="btn_cd_'.$servico['cd_servico'].'">'.$servico['cd_servico'].'</button></td>';
                  echo '</form>';

                  if($servico['orcamento_servico'] == 0){
                    echo '<td><label class="badge badge-secondary">FREE / Garantia</label>';
                  }else{
                    if($servico['orcamento_servico'] == $servico['vpag_servico']){
                      echo '<td><label class="badge badge-success">Liquidado: R$:'. $servico['vpag_servico'] .'</label>';
                    }else{
                      $orcamento_servico = isset($servico['orcamento_servico']) && is_numeric($servico['orcamento_servico']) ? $servico['orcamento_servico'] : 0;
                      $vpag_servico = isset($servico['vpag_servico']) && is_numeric($servico['vpag_servico']) ? $servico['vpag_servico'] : 0;
                      echo '<td><label class="badge badge-danger">Falta pagar: R$:' . ($orcamento_servico - $vpag_servico) . ' de R$:' . $orcamento_servico . '</label>';
                    }
                  }
                  if($servico['comissao_lancada'] > 0){
                      echo '</br><label class="badge badge-warning">Comissão Lançada: R$:'. $servico['comissao_lancada'] .'</label></td>';
                  }else{
                      echo '</br><label class="badge badge-light">Sem Comissão</label></td>';
                  }
                  
                                    
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

                  
                  echo '<td name="btn_dt_'.$servico['cd_servico'].'" id="btn_dt_'.$servico['cd_servico'].'">'.date('d/m/y', strtotime($servico['prazo_servico'])).'</td>';

                  

		              if(date('Y-m-d', strtotime('+1 hour')) > date('Y-m-d', strtotime($servico['prazo_servico']))){
                    echo '<script>document.getElementById("btn_cd_'.$servico['cd_servico'].'").className = "btn btn-danger";</script>';
                    //echo '<script>document.getElementById("btn_dt_'.$servico['cd_servico'].'").className = "badge badge-danger";</script>';
                    $extrapolado = $extrapolado+1;
                    $extrapoladoafaser = $extrapoladoafaser+1;
                  }else{
                    if(date('Y-m-d', strtotime('+1 hour')) == date('Y-m-d', strtotime($servico['prazo_servico']))){
                      echo '<script>document.getElementById("btn_cd_'.$servico['cd_servico'].'").className = "btn btn-warning";</script>';
                      //echo '<script>document.getElementById("btn_dt_'.$servico['cd_servico'].'").className = "badge badge-warning";</script>';
                      $parahoje = $parahoje+1;
                      $parahojeafazer = $parahojeafazer + 1;
                    }else{
                      if(date('Y-m-d', strtotime('+1 hour')) < date('Y-m-d', strtotime($servico['prazo_servico']))){
                        echo '<script>document.getElementById("btn_cd_'.$servico['cd_servico'].'").className = "btn btn-success";</script>';
                        //echo '<script>document.getElementById("btn_dt_'.$servico['cd_servico'].'").className = "badge badge-success";</script>';
                        $noprazo = $noprazo+1;
                        $noprazoafaser = $noprazoafaser+1;
                      }
                    }
                  }
                }
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                
                if($noprazoafaser > 0){
                  echo '<script>document.getElementById("noprazoafaser").innerHTML = "'.$noprazoafaser.'";</script>';
                  echo '<script>document.getElementById("noprazoafaser").style.display = "block";</script>';
                }
                if($parahojeafazer > 0){
                  echo '<script>document.getElementById("parahojeafaser").innerHTML = "'.$parahojeafazer.'";</script>';
                  echo '<script>document.getElementById("parahojeafaser").style.display = "block";</script>';
                }
                if($extrapoladoafaser > 0){
                  echo '<script>document.getElementById("extrapoladoafaser").innerHTML = "'.$extrapoladoafaser.'";</script>';
                  echo '<script>document.getElementById("extrapoladoafaser").style.display = "block";</script>';
                }
              }
            ?>

            <?php //EM ANDAMENTO
              //"SELECT marca_patrimonio, modelo_patrimonio, COUNT(*) AS total FROM tb_patrimonio WHERE tipo_patrimonio = 'Impressora' GROUP BY marca_patrimonio, modelo_patrimonio";
              //$sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 0";
              $sql_servico = "SELECT 
                  s.*, 
                  c.vl_comissao AS comissao_lancada
              FROM tb_servico s
              LEFT JOIN tb_comissao c 
                  ON c.cd_servico = s.cd_servico
              WHERE s.status_servico = 1 
                AND s.cd_filial = '".$_SESSION['cd_empresa']."'
              ORDER BY 
                  CASE 
                      WHEN s.prioridade_servico = 'U' THEN 1
                      WHEN s.prioridade_servico = 'A' THEN 2
                      WHEN s.prioridade_servico = 'M' THEN 3 
                      ELSE 4
                  END, 
                  s.cd_servico;";

              $resulta_servico = $conn->query($sql_servico);
              if ($resulta_servico->num_rows > 0){
                echo '<div class="col-lg-12 grid-margin stretch-card" data-toggle="collapse" href="#os_emandamento" aria-expanded="false" aria-controls="os_emandamento">';
                echo '<div class="card" '.$_SESSION['c_card'].'>';
                echo '<div class="card-body">';

                echo '<div class="grid-margin stretch-card">';
                echo '<h4 style="display: inline-block; margin-left: 10px;">EM ANDAMENTO</h4>';
                echo '<i class="btn btn-success" style="margin:auto; display:none;" id="noprazoemandamento"></i><i class="btn btn-warning" style="margin:auto; display:none;" id="parahojeemandamento"></i><i class="btn btn-danger" style="margin:auto; display:none;" id="extrapoladoemandamento"></i>';
                echo '</div>';
                echo '<h4 ></h4>';
                
                echo '<div class="collapse table-responsive" id="os_emandamento">';
                
                echo '<table class="table" '.$_SESSION['c_card'].'>';
                echo '<thead>';
                echo '<tr>';
                echo '<th>OS</th>';
                echo '<th>Financeiro</th>';
                echo '<th>Prioridade</th>';
                echo '<th>Prazo</th>';
                
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                
                while ( $servico = $resulta_servico->fetch_assoc()){
                  echo '<tr>';
                  echo '<form method="POST" action="../../pages/md_assistencia/consulta_servico.php">';
                  echo '<td style="display: none;"><input type="tel" id="conos_servico" name="conos_servico" value="'.$servico['cd_servico'].'"></td>';
                  echo '<td><button type="submit" class="btn btn-danger" name="btn_cd_'.$servico['cd_servico'].'" id="btn_cd_'.$servico['cd_servico'].'">'.$servico['cd_servico'].'</button></td>';
                  echo '</form>';

                  if($servico['orcamento_servico'] == 0){
                    echo '<td><label class="badge badge-secondary">FREE / Garantia</label>';
                  }else{
                    if($servico['orcamento_servico'] == $servico['vpag_servico']){
                      echo '<td><label class="badge badge-success">Liquidado: R$:'. $servico['vpag_servico'] .'</label>';
                    }else{
                      $orcamento_servico = isset($servico['orcamento_servico']) && is_numeric($servico['orcamento_servico']) ? $servico['orcamento_servico'] : 0;
                      $vpag_servico = isset($servico['vpag_servico']) && is_numeric($servico['vpag_servico']) ? $servico['vpag_servico'] : 0;
                      echo '<td><label class="badge badge-danger">Falta pagar: R$:' . ($orcamento_servico - $vpag_servico) . ' de R$:' . $orcamento_servico . '</label>';
                    }
                  }

                  if($servico['comissao_lancada'] > 0){
                      echo '</br><label class="badge badge-warning">Comissão Lançada: R$:'. $servico['comissao_lancada'] .'</label></td>';
                  }else{
                      echo '</br><label class="badge badge-light">Sem Comissão</label></td>';
                  }

                  if(date('Y-m-d', strtotime('+1 hour')) > date('Y-m-d', strtotime($servico['prazo_servico']))){
                    echo '<script>document.getElementById("btn_cd_'.$servico['cd_servico'].'").className = "btn btn-danger";</script>';
                    $extrapolado = $extrapolado+1;
                    $extrapoladoemandamento = $extrapoladoemandamento+1;
                  }else{
                    if(date('Y-m-d', strtotime('+1 hour')) == date('Y-m-d', strtotime($servico['prazo_servico']))){
                    echo '<script>document.getElementById("btn_cd_'.$servico['cd_servico'].'").className = "btn btn-warning";</script>';
                    $parahoje = $parahoje+1;
                    $parahojeemandamento = $parahojeemandamento+1;
                    }else{
                      if(date('Y-m-d', strtotime('+1 hour')) < date('Y-m-d', strtotime($servico['prazo_servico']))){
                        echo '<script>document.getElementById("btn_cd_'.$servico['cd_servico'].'").className = "btn btn-success";</script>';
                        $noprazo = $noprazo+1;
                        $noprazoemandamento = $noprazoemandamento+1;
                      }
                    }
                  }

                  
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
                  echo '<td>'.date('d/m/y', strtotime($servico['prazo_servico'])).'</td>';

                }
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                
                if($parahojeemandamento > 0){
                  echo '<script>document.getElementById("parahojeemandamento").innerHTML = "'.$parahojeemandamento.'";</script>';
                  echo '<script>document.getElementById("parahojeemandamento").style.display = "block";</script>';
                }
                if($noprazoemandamento > 0){
                  echo '<script>document.getElementById("noprazoemandamento").innerHTML = "'.$noprazoemandamento.'";</script>';
                  echo '<script>document.getElementById("noprazoemandamento").style.display = "block";</script>';
                }
                if($extrapoladoemandamento > 0){
                  echo '<script>document.getElementById("extrapoladoemandamento").innerHTML = "'.$extrapoladoemandamento.'";</script>';
                  echo '<script>document.getElementById("extrapoladoemandamento").style.display = "block";</script>';
                }
              }
            ?>

            <?php //LIBERADO
            
              $sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 2 and cd_filial = '".$_SESSION['cd_filial']."'
                ORDER BY 
                CASE 
                    WHEN prioridade_servico = 'U' THEN 1
                    WHEN prioridade_servico = 'A' THEN 2
                    WHEN prioridade_servico = 'M' THEN 3
                    ELSE 4
                END, cd_servico";

              $resulta_servico = $conn->query($sql_servico);
              if ($resulta_servico->num_rows > 0){
                echo '<div class="col-lg-12 grid-margin stretch-card"  data-toggle="collapse" href="#os_liberado" aria-expanded="false" aria-controls="os_liberado">';
                echo '<div class="card" '.$_SESSION['c_card'].'>';
                echo '<div class="card-body">';
                echo '<h4>LIBERADO</h4>';
              
                echo '<div class="collapse table-responsive" id="os_liberado">';
        
                //echo '<a href="../md_assistencia/painel_01.php" class="btn btn-lg btn-block btn-outline-info">VER MAIS</a>';

                echo '<form method="POST" action="../md_assistencia/painel_01.php">';
                echo '<input value="2" name="tipo_card" id="tipo_card" type="hidden">';
                echo '<td><button type="submit" name="con_edit_os" id="con_edit_os" class="btn btn-lg btn-block btn-outline-info">VER MAIS</button></td>';
                echo '</form>';

                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';  
              }              
            ?>

            <?php //RETIRADO / DEVOLVIDO
            
              $sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 3 and cd_filial = '".$_SESSION['cd_empresa']."'
                ORDER BY 
                CASE 
                    WHEN prioridade_servico = 'U' THEN 1
                    WHEN prioridade_servico = 'A' THEN 2
                    WHEN prioridade_servico = 'M' THEN 3
                    ELSE 4
                END, cd_servico";

              $resulta_servico = $conn->query($sql_servico);
              if ($resulta_servico->num_rows > 0){
                echo '<div class="col-lg-12 grid-margin stretch-card"  data-toggle="collapse" href="#os_retirado" aria-expanded="false" aria-controls="os_retirado">';
                echo '<div class="card" '.$_SESSION['c_card'].'>';
                echo '<div class="card-body">';
                echo '<h4>ENTREGUE / DEVOLVIDO</h4>';
                
                echo '<div class="collapse table-responsive" id="os_retirado">';
                //echo '<a href="../md_assistencia/painel_01.php" class="btn btn-lg btn-block btn-outline-info">VER MAIS</a>';

                echo '<form method="POST" action="../md_assistencia/painel_01.php">';
                echo '<input value="3" name="tipo_card" id="tipo_card" type="hidden">';
                echo '<td><button type="submit" name="con_edit_os" id="con_edit_os" class="btn btn-lg btn-block btn-outline-info">VER MAIS</button></td>';
                echo '</form>';

                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';  
              }              
            ?>
            
            
            <?php //ARQUIVADO
              $sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 4 and cd_filial = '".$_SESSION['cd_empresa']."'
                ORDER BY 
                CASE 
                    WHEN prioridade_servico = 'U' THEN 1
                    WHEN prioridade_servico = 'A' THEN 2
                    WHEN prioridade_servico = 'M' THEN 3
                    WHEN prioridade_servico = 'M' THEN 4
                    ELSE 5
                END, cd_servico";

              $resulta_servico = $conn->query($sql_servico);
              if ($resulta_servico->num_rows > 0){
                echo '<div class="col-lg-12 grid-margin stretch-card"  data-toggle="collapse" href="#os_arquivado" aria-expanded="false" aria-controls="os_arquivado">';
                echo '<div class="card" '.$_SESSION['c_card'].'>';
                echo '<div class="card-body">';
                echo '<h4>ARQUIVADO</h4>';
                
                echo '<div class="collapse table-responsive" id="os_arquivado">';
                

                
                //echo '<a href="../md_assistencia/painel_01.php" class="btn btn-lg btn-block btn-outline-info">VER MAIS</a>';

                echo '<form method="POST" action="../md_assistencia/painel_01.php">';
                echo '<input value="4" name="tipo_card" id="tipo_card" type="hidden">';
                echo '<td><button type="submit" name="con_edit_os" id="con_edit_os" class="btn btn-lg btn-block btn-outline-info">VER MAIS</button></td>';
                echo '</form>';
                
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';  
              }

              if($parahoje > 0){
                echo '<script>document.getElementById("parahoje").innerHTML = "Para Hoje</br>'.$parahoje.'";</script>';
                echo '<script>document.getElementById("parahoje").style.display = "block";</script>';
              }
              if($noprazo > 0){
                echo '<script>document.getElementById("noprazo").innerHTML = "No Prazo</br>'.$noprazo.'";</script>';
                echo '<script>document.getElementById("noprazo").style.display = "block";</script>';
              }
              if($extrapolado > 0){
                echo '<script>document.getElementById("extrapolado").innerHTML = "Prazo Extrapolado</br>'.$extrapolado.'";</script>';
                echo '<script>document.getElementById("extrapolado").style.display = "block";</script>';
              }
              
            ?>