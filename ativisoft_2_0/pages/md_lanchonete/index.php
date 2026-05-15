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
                echo '<th>Devendo</th>';
                echo '<th>Total Pago</th>';
                
                
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                $qtdClientesDevendo = 0;
                $vtotalClientesDevendo = 0;
                while ( $devendo = $resulta_devendo->fetch_assoc()){
                  echo '<tr>';
                 
                  echo "<td><a class='btn btn-danger' style='margin: 5px;' href='".$_SESSION['dominio']."pages/md_assistencia/acompanha_servico.php?cnpj=".$_SESSION['cnpj_empresa']."&tel=".$devendo['tel1_pessoa']."'>".$devendo['full_cliente']."</td>";
                  echo "<td>R$:".number_format($devendo['saldo_faltante'], 2, ',', '.')."</td>";
                  echo "<td>R$:".number_format($devendo['total_pago'], 2, ',', '.')."</td>";
                  
                  
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

                echo '<script>document.getElementById("qtdValClientesDevendo").innerHTML = " Contas em aberto R$:'.number_format($vtotalClientesDevendo, 2, ',', '.').' ";</script>';
                echo '<script>document.getElementById("qtdValClientesDevendo").style.display = "block";</script>';

                
              }
            ?>


            <?php //À FAZER
              

              //"SELECT marca_patrimonio, modelo_patrimonio, COUNT(*) AS total FROM tb_patrimonio WHERE tipo_patrimonio = 'Impressora' GROUP BY marca_patrimonio, modelo_patrimonio";
              //$sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 0";
              //$sql_venda = "SELECT * FROM tb_venda WHERE status_venda = 0 and cd_filial = '".$_SESSION['cd_empresa']."' ORDER BY cd_venda";

              $sql_venda = "
                  SELECT v.*, p.pnome_pessoa 
                  FROM tb_venda v
                  INNER JOIN tb_pessoa p ON v.cd_cliente = p.cd_pessoa
                  WHERE v.status_venda = 0 
                    AND v.cd_filial = '".$_SESSION['cd_empresa']."' 
                  ORDER BY v.cd_venda
              ";

              $resulta_venda = $conn->query($sql_venda);
              if ($resulta_venda->num_rows > 0){
                if ($resulta_venda->num_rows == 1){
                  echo '<div class="row row-cols-1 row-cols-md-1 g-4 justify-content-center">';
                }else if($resulta_venda->num_rows == 2){
                  echo '<div class="row row-cols-1 row-cols-md-2 g-4 justify-content-center">';
                }else if($resulta_venda->num_rows > 3){
                  echo '<div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">';
                }
                while ( $venda = $resulta_venda->fetch_assoc()){
                  echo '

                    <div class="col" style="margin: 10pt 0;">
                      <div class="card">
                        <div class="card-header bg-transparent">
                          <form method="POST" action="'.$_SESSION['dominio'].'/pages/md_lanchonete/consulta_venda.php">
                          <td style="display: none;"><input type="hidden" id="concd_venda" name="concd_venda" value="'.$venda['cd_venda'].'"></td>
                          <td><button type="submit" class="btn btn-lg btn-block btn-light" name="btn_cd_'.$venda['cd_venda'].'" id="btn_cd_'.$venda['cd_venda'].'">Conta Aberta: '.$venda['cd_venda'].'</button></td>
                          </form>
                        </div>
                        <div class="card-body">
                          <h5 class="card-title">'.$venda['pnome_pessoa'].'</h5>
                          <table class="table">
                            <tr><th scope="row">Abertura</th><td>'.date('d/m/Y', strtotime($venda['abertura_venda'])).'</td></tr>
                          </table>
                          <p class="card-text">'.$venda['titulo_venda'].'</p>
';
                          $sql_orcamento_venda = "SELECT * FROM tb_orcamento_venda WHERE cd_venda = '".$venda['cd_venda']."'";

                          $resulta_orcamento_venda = $conn->query($sql_orcamento_venda);
                          if ($resulta_orcamento_venda->num_rows > 0){

                            echo '
                            <table class="table">
                              <tr><th scope="col">#</th><th scope="col">Produto</th><th scope="col">Preço</th></tr>
                            ';
                            
                            
                            while ( $orcamento_venda = $resulta_orcamento_venda->fetch_assoc()){
                              echo '
                              <tr><th scope="row">1</th><td>'.$orcamento_venda['titulo_orcamento'].'</td><td>R$: '.$orcamento_venda['vcusto_orcamento'].'</td></tr>
                              ';
                            }
                            echo '
                            </table>
                            ';
                          }else{
                            echo '
                            <p class="card-text">Venda Limpa</p>
                            ';
                          }
                          echo '

                        </div>
                        <div class="card-footer bg-transparent border-success">
                        ';
                        if($venda['orcamento_venda'] == 0){
                          echo '
                          <td><label class="badge badge-secondary">R$: 0.00</label></td>
                          ';
                        }else{
                          if($venda['orcamento_venda'] == $venda['vpag_venda']){
                            echo '
                          <td><label class="badge badge-success">Liquidado: R$:'. $venda['vpag_venda'] .'</label></td>
                            ';
                          }else{
                            $orcamento_venda = isset($venda['orcamento_venda']) && is_numeric($venda['orcamento_venda']) ? $venda['orcamento_venda'] : 0;
                            $vpag_venda = isset($servico['vpag_venda']) && is_numeric($venda['vpag_venda']) ? $venda['vpag_venda'] : 0;
                            echo '
                          <td><label class="badge badge-danger">Falta pagar: R$:' . ($orcamento_venda - $vpag_venda) . ' de R$:' . $orcamento_venda . '</label></td>
                            ';
                          }
                        }
                        echo '
                        </div>
                      </div>
                    </div>
                  ';
                  //echo '<tr>';
                  //echo '<form method="POST" action="../../pages/md_assistencia/consulta_servico.php">';
                  //echo '<td style="display: none;"><input type="tel" id="conos_servico" name="conos_servico" value="'.$servico['cd_servico'].'"></td>';
                  //echo '<td><button type="submit" class="btn btn-danger" name="btn_cd_'.$servico['cd_servico'].'" id="btn_cd_'.$servico['cd_servico'].'">'.$servico['cd_servico'].'</button></td>';
                  //echo '</form>';

                }
                  
                                    
                  

                  
                  
                
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
              
              echo '</div>';
              }
            ?>

            