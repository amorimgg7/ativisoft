



          <?php

              $sql_visita = "SELECT p.cd_pessoa, concat(p.pnome_pessoa) as full_name, v.* FROM tb_pessoa p, tb_visita v where p.cd_pessoa = v.cd_pessoa and obs_visita = 'Deu entrada mas não saiu ainda.'";
              $resulta_visita = $conn->query($sql_visita);
              if ($resulta_visita->num_rows > 0){
                echo '<div class="col-lg-12 grid-margin stretch-card" data-toggle="collapse" href="#visita" aria-expanded="false" aria-controls="visita">';
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<div class="grid-margin stretch-card">';
                echo '<h4 style="display: inline-block; margin-left: 10px;">Visitante que não fez seu pedido</h4>';
                echo '</div>';
                echo '<div class="collapse table-responsive" id="visita">';
                echo '<table class="table">';
                echo '<thead>';
                echo '<tr>';
                //echo '<th>Acessar</th>';
                echo '<th>Nome Pessoa</th>';
                echo '<th>Data da Visita</th>';
                echo '<th>Telefone</th>';
                echo '<th>Contato</th>';
                echo '</tr>';
                echo '</thead>';
                while ( $visita = $resulta_visita->fetch_assoc()){
                  echo '<tbody>';
                  echo '<tr>';
                  echo '<td><p>'.$visita['full_name'].'</p></td>';
                  echo '<td><p>'.date('d/m/y', strtotime($visita['dt_visita_entrada'])).'</p></td>';
                  echo '<td><p>'.$visita['tel_visita'].'</p></td>';
                  echo '<td><p><a href=https://wa.me/'.$visita['tel_visita'].'>Whatsapp</a></p></td>';
                  echo '</tbody>';
                }
                echo '</table>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
              }


              $sql_pedido_visita = "SELECT p.cd_pessoa, concat(p.pnome_pessoa) as full_name, pa.* FROM tb_pessoa p, tb_pedido_auxilio pa where p.cd_pessoa = pa.cd_pessoa and obs_pedido_auxilio = 'auxilio_visita'";
              $resulta_pedido_visita = $conn->query($sql_pedido_visita);
              if ($resulta_pedido_visita->num_rows > 0){
                echo '<div class="col-lg-12 grid-margin stretch-card" data-toggle="collapse" href="#pedido_vita" aria-expanded="false" aria-controls="pedido_vita">';
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<div class="grid-margin stretch-card">';
                echo '<h4 style="display: inline-block; margin-left: 10px;">Pedido de Visita</h4>';
                echo '<i class="btn btn-success" style="margin:auto; display:none;" id="noprazoafaser"></i><i class="btn btn-warning" style="margin:auto; display:none;" id="parahojeafaser"></i><i class="btn btn-danger" style="margin:auto; display:none;" id="extrapoladoafaser"></i>';
                echo '</div>';
                echo '<div class="collapse table-responsive" id="pedido_vita">';
                echo '<table class="table">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Acessar</th>';
                echo '<th>Nome Pessoa</th>';
                echo '<th>Data do Pedido</th>';
                echo '<th>Primeiro Conferente</th>';
                echo '<th>Último Conferente</th>';
                ///echo '<th>Obs</th>';
                echo '</tr>';
                echo '</thead>';
                while ( $pedido_visita = $resulta_pedido_visita->fetch_assoc()){
                  echo '<tbody>';
                  echo '<tr>';
                  echo '<form method="POST" action="../../pages/md_pedido_auxilio/consulta_pedido.php">';
                  echo '<td style="display: none;"><input type="tel" id="concd_pedido" name="concd_pedido" value="'.$pedido_visita['cd_pedido_auxilio'].'"></td>';
                  echo '<td><button type="submit" class="btn btn-danger" name="btn_cd_pedido_'.$pedido_visita['cd_pedido_auxilio'].'" id="btn_cd_pedido_'.$pedido_visita['cd_pedido_auxilio'].'">'.$pedido_visita['cd_pedido_auxilio'].'</button></td>';
                  echo '</form>';
                  echo '<td><p>'.$pedido_visita['full_name'].'</p></td>';
                  echo '<td><p>'.date('d/m/y', strtotime($pedido_visita['dt_pedido_auxilio'])).'</p></td>';
                  if($pedido_visita['cd_quem_abriu_primeiro'] = null){
                    echo '<td><p>'.$pedido_visita['cd_quem_abriu_primeiro'].' - '.date('d/m/y', strtotime($pedido_visita['dt_primeira_abertura_pedido_auxilio'])).'</p></td>';
                  }else{
                    echo '<td><p>.</p></td>';
                  }
                  if($pedido_visita['cd_quem_abriu_primeiro'] = null){
                    echo '<td><p>'.$pedido_visita['cd_quem_abriu_ultimo'].' - '.date('d/m/y', strtotime($pedido_visita['dt_ultima_abertura_pedido_auxilio'])).'</p></td>';
                  }else{
                    echo '<td><p>Ninguém conferiu.</p></td>';
                  }
                  echo '</tbody>';
                }
                echo '</table>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
              }

              $sql_pedido_alimento = "SELECT p.cd_pessoa, concat(p.pnome_pessoa) as full_name, pa.* FROM tb_pessoa p, tb_pedido_auxilio pa where p.cd_pessoa = pa.cd_pessoa and obs_pedido_auxilio = 'auxilio_alimento'";
              $resulta_pedido_alimento = $conn->query($sql_pedido_alimento);
              if ($resulta_pedido_alimento->num_rows > 0){
                echo '<div class="col-lg-12 grid-margin stretch-card" data-toggle="collapse" href="#pedido_alimento" aria-expanded="false" aria-controls="pedido_alimento">';
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<div class="grid-margin stretch-card">';
                echo '<h4 style="display: inline-block; margin-left: 10px;">Pedido de Alimento</h4>';
                echo '<i class="btn btn-success" style="margin:auto; display:none;" id="noprazoafaser"></i><i class="btn btn-warning" style="margin:auto; display:none;" id="parahojeafaser"></i><i class="btn btn-danger" style="margin:auto; display:none;" id="extrapoladoafaser"></i>';
                echo '</div>';
                echo '<div class="collapse table-responsive" id="pedido_alimento">';
                echo '<table class="table">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Acessar</th>';
                echo '<th>Nome Pessoa</th>';
                echo '<th>Data do Pedido</th>';
                echo '<th>Primeiro Conferente</th>';
                echo '<th>Último Conferente</th>';
                ///echo '<th>Obs</th>';
                echo '</tr>';
                echo '</thead>';
                while ( $pedido_alimento = $resulta_pedido_alimento->fetch_assoc()){
                  echo '<tbody>';
                  echo '<tr>';
                  echo '<form method="POST" action="../../pages/md_pedido_auxilio/consulta_pedido.php">';
                  echo '<td style="display: none;"><input type="tel" id="concd_pedido" name="concd_pedido" value="'.$pedido_alimento['cd_pedido_auxilio'].'"></td>';
                  echo '<td><button type="submit" class="btn btn-danger" name="btn_cd_pedido_'.$pedido_alimento['cd_pedido_auxilio'].'" id="btn_cd_pedido_'.$pedido_alimento['cd_pedido_auxilio'].'">'.$pedido_alimento['cd_pedido_auxilio'].'</button></td>';
                  echo '</form>';
                  echo '<td><p>'.$pedido_alimento['full_name'].'</p></td>';
                  echo '<td><p>'.date('d/m/y', strtotime($pedido_alimento['dt_pedido_auxilio'])).'</p></td>';
                  if($pedido_alimento['cd_quem_abriu_primeiro'] = null){
                    echo '<td><p>'.$pedido_alimento['cd_quem_abriu_primeiro'].' - '.date('d/m/y', strtotime($pedido_alimento['dt_primeira_abertura_pedido_auxilio'])).'</p></td>';
                  }else{
                    echo '<td><p>.</p></td>';
                  }
                  if($pedido_alimento['cd_quem_abriu_primeiro'] = null){
                    echo '<td><p>'.$pedido_alimento['cd_quem_abriu_ultimo'].' - '.date('d/m/y', strtotime($pedido_alimento['dt_ultima_abertura_pedido_auxilio'])).'</p></td>';
                  }else{
                    echo '<td><p>Ninguém conferiu.</p></td>';
                  }
                  echo '</tbody>';
                }
                echo '</table>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
              }

              $sql_pedido_estudo = "SELECT p.cd_pessoa, concat(p.pnome_pessoa) as full_name, pa.* FROM tb_pessoa p, tb_pedido_auxilio pa where p.cd_pessoa = pa.cd_pessoa and obs_pedido_auxilio = 'auxilio_estudo_biblico'";
              $resulta_pedido_estudo = $conn->query($sql_pedido_estudo);
              if ($resulta_pedido_estudo->num_rows > 0){
                echo '<div class="col-lg-12 grid-margin stretch-card" data-toggle="collapse" href="#pedido_estudo" aria-expanded="false" aria-controls="pedido_estudo">';
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<div class="grid-margin stretch-card">';
                echo '<h4 style="display: inline-block; margin-left: 10px;">Pedido de Estudo Bíblico</h4>';
                echo '<i class="btn btn-success" style="margin:auto; display:none;" id="noprazoafaser"></i><i class="btn btn-warning" style="margin:auto; display:none;" id="parahojeafaser"></i><i class="btn btn-danger" style="margin:auto; display:none;" id="extrapoladoafaser"></i>';
                echo '</div>';
                echo '<div class="collapse table-responsive" id="pedido_estudo">';
                echo '<table class="table">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Acessar</th>';
                echo '<th>Nome Pessoa</th>';
                echo '<th>Data do Pedido</th>';
                echo '<th>Primeiro Conferente</th>';
                echo '<th>Último Conferente</th>';
                ///echo '<th>Obs</th>';
                echo '</tr>';
                echo '</thead>';
                while ( $pedido_estudo = $resulta_pedido_estudo->fetch_assoc()){
                  echo '<tbody>';
                  echo '<tr>';
                  echo '<form method="POST" action="../../pages/md_pedido_auxilio/consulta_pedido.php">';
                  echo '<td style="display: none;"><input type="tel" id="concd_pedido" name="concd_pedido" value="'.$pedido_estudo['cd_pedido_auxilio'].'"></td>';
                  echo '<td><button type="submit" class="btn btn-danger" name="btn_cd_pedido_'.$pedido_estudo['cd_pedido_auxilio'].'" id="btn_cd_pedido_'.$pedido_estudo['cd_pedido_auxilio'].'">'.$pedido_estudo['cd_pedido_auxilio'].'</button></td>';
                  echo '</form>';
                  echo '<td><p>'.$pedido_estudo['full_name'].'</p></td>';
                  echo '<td><p>'.date('d/m/y', strtotime($pedido_estudo['dt_pedido_auxilio'])).'</p></td>';
                  if($pedido_estudo['cd_quem_abriu_primeiro'] = null){
                    echo '<td><p>'.$pedido_estudo['cd_quem_abriu_primeiro'].' - '.date('d/m/y', strtotime($pedido_estudo['dt_primeira_abertura_pedido_auxilio'])).'</p></td>';
                  }else{
                    echo '<td><p>.</p></td>';
                  }
                  if($pedido_estudo['cd_quem_abriu_primeiro'] = null){
                    echo '<td><p>'.$pedido_estudo['cd_quem_abriu_ultimo'].' - '.date('d/m/y', strtotime($pedido_estudo['dt_ultima_abertura_pedido_auxilio'])).'</p></td>';
                  }else{
                    echo '<td><p>Ninguém conferiu.</p></td>';
                  }
                  echo '</tbody>';
                }
                echo '</table>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
              }
          ?>