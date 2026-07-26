



<?php
            



            $sql_pedido_oracao = "SELECT p.cd_pessoa, concat(p.pnome_pessoa, ' ', p.snome_pessoa) as full_name, po.* FROM tb_pessoa p, tb_pedido_oracao po where po.cd_pessoa = p.cd_pessoa";

              $resulta_pedido_oracao = $conn->query($sql_pedido_oracao);
              if ($resulta_pedido_oracao->num_rows > 0){
                
                
                
                
                while ( $pedido_oracao = $resulta_pedido_oracao->fetch_assoc()){
                  echo '<div class="col-lg-12 grid-margin stretch-card" data-toggle="collapse" href="#cd_pessoa_'.$pedido_oracao['cd_pessoa'].'" aria-expanded="false" aria-controls="cd_pessoa_'.$pedido_oracao['cd_pessoa'].'">';

                  echo '<div class="card">';
                  echo '<div class="card-body">';
                  echo '<div class="grid-margin stretch-card">';
                  echo '<h4 style="display: inline-block; margin-left: 10px;">'.$pedido_oracao['full_name'].'</h4>';
                  echo '<i class="btn btn-success" style="margin:auto; display:none;" id="noprazoafaser"></i><i class="btn btn-warning" style="margin:auto; display:none;" id="parahojeafaser"></i><i class="btn btn-danger" style="margin:auto; display:none;" id="extrapoladoafaser"></i>';
                  echo '</div>';

                
                  echo '<div class="collapse table-responsive" id="cd_pessoa_'.$pedido_oracao['cd_pessoa'].'">';
                  
                  echo '<table class="table">';
                  echo '<thead>';
                  echo '<tr>';
                  echo '<th>Acessar</th>';
                  echo '<th>Data do Pedido</th>';
                  echo '<th>Primeiro Conferente</th>';
                  echo '<th>Último Conferente</th>';
                  ///echo '<th>Obs</th>';
                
                
                  echo '</tr>';
                  echo '</thead>';
                  echo '<tbody>';


                  echo '<tr>';
                  echo '<form method="POST" action="../../pages/md_assistencia/consulta_servico.php">';
                  echo '<td style="display: none;"><input type="tel" id="concd_pedido_oracao" name="concd_pedido_oracao" value="'.$pedido_oracao['cd_pedido_oracao'].'"></td>';
                  echo '<td><button type="submit" class="btn btn-danger" name="btn_cd_'.$pedido_oracao['cd_pedido_oracao'].'" id="btn_cd_'.$pedido_oracao['cd_pedido_oracao'].'">'.$pedido_oracao['cd_pedido_oracao'].'</button></td>';
                  echo '</form>';

                  echo '<td><p>'.date('d/m/y', strtotime($pedido_oracao['dt_pedido_oracao'])).'</p></td>';
                  echo '<td><p>'.$pedido_oracao['cd_quem_abriu_primeiro'].' - '.date('d/m/y', strtotime($pedido_oracao['dt_pedido_oracao'])).'</p></td>';
                  echo '<td><p>'.$pedido_oracao['cd_quem_abriu_ultimo'].' - '.date('d/m/y', strtotime($pedido_oracao['dt_ultima_abertura_pedido_oracao'])).'</p></td>';
                          
                  
                  
                  echo '</tbody>';
                  echo '</table>';
                  echo '</div>';
                  

                  echo '</div>';
                  echo '</div>';
                  echo '</div>';
                }
                
                
                
                
                
              }


/*
            $sql_cliente_matriz = "SELECT p.cd_pessoa, concat(p.pnome_pessoa, ' ', p.snome_pessoa) as full_name, po.* FROM tb_pessoa p, tb_pedido_oracao po where p.cd_pessoa = po.cd_pessoa and dt_primeira_abertura_pedido_oracao IS NULL";
            $resulta_cliente_matriz = $conn->query($sql_cliente_matriz);
            if ($resulta_cliente_matriz->num_rows > 0){
              while ( $cliente_matriz = $resulta_cliente_matriz->fetch_assoc()){
                  
                echo '<div class="col-lg-12 grid-margin stretch-card" data-toggle="collapse" href="#pessoa_'.$cliente_matriz['cd_pessoa'].'" aria-expanded="false" aria-controls="pessoa_pedido">';
                echo '<div class="card">';
                
                echo '<div class="card-body">';
                echo '<div class="grid-margin stretch-card">';
                echo '<h4 style="display: inline-block; margin-left: 10px;">À FAZER</h4>';
                echo '<h6 style="display: inline-block; margin-left: 10px;">Pessoa: '. $cliente_matriz['full_name'] .'</br>Telefone: '. $cliente_matriz['tel_pedido_oracao'] .'</h6>';
                  
                  echo '<div style="position: absolute; right: 10px; text-align: right;">';
                  echo '</br></br><i id="status_#pessoa_'.$cliente_matriz['cd_pessoa'].'"></i>';
                  echo '<i style="margin: auto;" id="statusfinanceiro_cd_cliente_comercial_'.$cliente_matriz['cd_pedido_oracao'].'"></i>';
                  echo '</div>';

                  echo '<i class="btn btn-warning" style=" display:none;" id="parahojeafaser"></i><i class="btn btn-danger" style="margin:auto; display:none;" id="extrapoladoafaser"></i>';
                  echo '</div>';

                  echo '<div class="collapse table-responsive" id="cliente_'.$cliente_matriz['cd_pedido_oracao'].'">';
                  echo '<table class="table"';
                  echo '<thead>';
                  echo '<tr>';
                  echo '<th>Acessar</th>';
                  echo '<th>Data do Pedido</th>';
                  echo '<th>Primeiro Conferente</th>';
                  echo '<th>Último Conferente</th>';
                  ///echo '<th>Obs</th>';
                  echo '</tr>';
                  echo '</thead>';
                  echo '<tbody>';
                  $sql_cliente_filial = "SELECT * FROM tb_pedido_oracao where cd_pessoa = ".$cliente_matriz['cd_pessoa'];
                  $resulta_cliente_filial = $conn->query($sql_cliente_filial);
                  if ($resulta_cliente_filial->num_rows > 0){
                      while ( $cliente_filial = $resulta_cliente_filial->fetch_assoc()){
                          echo '<tr>';
                          echo '<form method="POST" action="../../pages/md_fornecedor/consultar_cliente_comercial.php">';
                          echo '<td style="display: none;"><input type="tel" id="concnpj_cliente_comercial" name="concnpj_cliente_comercial" value="'.$cliente_filial['cd_pedido_oracao'].'"></td>';
                          echo '<td><button type="submit" class="btn btn-info" name="btn_cnpj_'.$cliente_filial['cd_pedido_oracao'].'" id="btn_cd_'.$cliente_filial['cd_pedido_oracao'].'">'.$cliente_filial['cd_pedido_oracao'].'</button></td>';
                          echo '</form>';
                          echo '<td><p>'.date('d/m/y', strtotime($cliente_filial['dt_pedido_oracao'])).'</p></td>';
                          //echo '<td><p>'.$cliente_filial['cd_quem_abriu_primeiro'].' - '.date('d/m/y', strtotime($cliente_filial['dt_pedido_oracao'])).'</p></td>';
                          //echo '<td><p>'.$cliente_filial['cd_quem_abriu_ultimo'].' - '.date('d/m/y', strtotime($cliente_filial['dt_ultima_abertura_pedido_oracao'])).'</p></td>';
                          echo '</tr>';
                      }
                      
                  }
                  echo '</tbody>';
                  echo '</table>';
                  echo '</div>';

                  echo '</div>';
                  echo '</div>';
                  //echo '</div>';
              }
            }else{
              echo '<h4>Nenhum Pedido de Oração em Aberto</h4>';
            }
            */
          ?>