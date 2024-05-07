

            <?php //À FAZER
              //"SELECT marca_patrimonio, modelo_patrimonio, COUNT(*) AS total FROM tb_patrimonio WHERE tipo_patrimonio = 'Impressora' GROUP BY marca_patrimonio, modelo_patrimonio";
              //$sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 0";
              //$sql_loja_virtual = "SELECT ca.cd_cliente_carrinho, ca.cd_prod_serv_carrinho, count(ca.qtd_prod_serv_carrinho) as qtd_prod_serv_carrinho FROM tb_carrinho ca, tb_cliente cl, tb_prod_serv ps WHERE status_carrinho = 1 GROUP BY cd_cliente_carrinho ORDER BY cd_carrinho ASC";

              $sql_loja_virtual = "SELECT CONCAT(TRIM(cl.pnome_cliente), ' ', TRIM(cl.snome_cliente)) AS nome_completo, ca.cd_cliente_carrinho AS cd_cliente, cl.tel_cliente AS tel_cliente, ca.cd_prod_serv_carrinho AS cd_produto, SUM(ca.qtd_prod_serv_carrinho) AS qtde_total, SUM(ps.preco_prod_serv) AS valor_total " .
                                  "FROM tb_carrinho ca " .
                                  "JOIN tb_cliente cl ON ca.cd_cliente_carrinho = cl.cd_cliente ".
                                  "JOIN tb_prod_serv ps ON ca.cd_prod_serv_carrinho = ps.cd_prod_serv " .
                                  "WHERE status_carrinho = 1 " .
                                  "GROUP BY ca.cd_cliente_carrinho " .
                                  "ORDER BY cd_cliente_carrinho ASC;";

              $resulta_loja_virtual = $conn->query($sql_loja_virtual);
              if ($resulta_loja_virtual->num_rows > 0){
                echo '<div class="col-lg-12 grid-margin stretch-card" data-toggle="collapse" href="#os_afaser" aria-expanded="false" aria-controls="os_afaser">';
                echo '<div class="card" '.$_SESSION['c_card'].'>';
                
                echo '<div class="card-body">';
                echo '<div class="grid-margin stretch-card">';
                echo '<h4 style="display: inline-block; margin-left: 10px;">No Carrinho</h4>';
                echo '</div>';

                
                echo '<div class="collapse table-responsive" id="os_afaser">';
                
                echo '<table class="table" '.$_SESSION['c_card'].'>';
                echo '<thead>';
                echo '<tr>';
                echo '<th></th>';
                echo '<th>Cliente</th>';
                echo '<th>Tel</th>';
                echo '<th>Quantidade</th>'; 
                echo '<th>Valor</th>'; 
                
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while ( $loja_virtual = $resulta_loja_virtual->fetch_assoc()){
                  echo '<tr>';
                  echo '<form method="POST" action="../../pages/md_vendas/consulta_carrinho.php">';
                  //echo '<form method="POST">';
                  echo '<td style="display: none;"><input type="tel" id="concd_cliente_carrinho" name="concd_cliente_carrinho" value="'.$loja_virtual['cd_cliente'].'"></td>';
                  echo '<td style="display: none;"><input type="tel" id="contel_cliente_carrinho" name="contel_cliente_carrinho" value="'.$loja_virtual['tel_cliente'].'"></td>';
                  echo '<td><button type="submit" class="btn btn-warning" name="btn_cd_'.$loja_virtual['cd_cliente'].'" id="btn_cd_'.$loja_virtual['cd_cliente'].'">'.$loja_virtual['cd_cliente'].'</button></td>';
                  echo '</form>';
/*
                  if(date('Y-m-d', strtotime('+1 hour')) > date('Y-m-d', strtotime($loja_virtual['prazo_servico']))){
                    echo '<script>document.getElementById("btn_cd_'.$servico['cd_servico'].'").className = "btn btn-danger";</script>';
                    $extrapolado = $extrapolado+1;
                    $extrapoladoafaser = $extrapoladoafaser+1;
                  }else{
                    if(date('Y-m-d', strtotime('+1 hour')) == date('Y-m-d', strtotime($servico['prazo_servico']))){
                    echo '<script>document.getElementById("btn_cd_'.$servico['cd_servico'].'").className = "btn btn-warning";</script>';
                    $parahoje = $parahoje+1;
                    $parahojeafaser = $parahojeafaser+1;
                    }else{
                      if(date('Y-m-d', strtotime('+1 hour')) < date('Y-m-d', strtotime($servico['prazo_servico']))){
                        echo '<script>document.getElementById("btn_cd_'.$servico['cd_servico'].'").className = "btn btn-success";</script>';
                        $noprazo = $noprazo+1;
                        $noprazoafaser = $noprazoafaser+1;
                      }
                    }
                  }*/
                    
                  echo '<td>'.$loja_virtual['nome_completo'].'</td>';//tel_cliente
                  echo '<td>'.$loja_virtual['tel_cliente'].'</td>';
                  
                  echo '<td>'.$loja_virtual['qtde_total'].'</td>';
                  echo '<td>'.$loja_virtual['valor_total'].'</td>';

                }
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                
              }
            ?>