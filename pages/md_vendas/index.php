<div class="col-lg-12 grid-margin stretch-card">
<i type="submit" class="btn btn-success"style="margin:auto; display:none;"id="noprazo">No prazo</i>
<i type="submit" class="btn btn-warning"style="margin:auto; display:none;"id="parahoje">Previsto para hoje</i>
<i type="submit" class="btn btn-danger"style="margin:auto; display:none;" id="extrapolado">Prazo extrapolado</i>
</div>

            <?php //À FAZER
              //"SELECT marca_patrimonio, modelo_patrimonio, COUNT(*) AS total FROM tb_patrimonio WHERE tipo_patrimonio = 'Impressora' GROUP BY marca_patrimonio, modelo_patrimonio";
              //$sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 0";
              $sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 0 
                ORDER BY 
                CASE 
                    WHEN prioridade_servico = 'U' THEN 1
                    WHEN prioridade_servico = 'A' THEN 2
                    WHEN prioridade_servico = 'M' THEN 3 
                    ELSE 4
                END, cd_servico";

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
                echo '<th>Prioridade</th>';
                echo '<th>Prazo</th>';
                
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while ( $servico = $resulta_servico->fetch_assoc()){
                  echo '<tr>';
                  echo '<form method="POST" action="pages/md_assistencia/consulta_servico.php">';
                  echo '<td style="display: none;"><input type="tel" id="conos_servico" name="conos_servico" value="'.$servico['cd_servico'].'"></td>';
                  echo '<td><button type="submit" class="btn btn-danger" name="btn_cd_'.$servico['cd_servico'].'" id="btn_cd_'.$servico['cd_servico'].'">'.$servico['cd_servico'].'</button></td>';
                  echo '</form>';

                  if(date('Y-m-d', strtotime('+1 hour')) > date('Y-m-d', strtotime($servico['prazo_servico']))){
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
                if($parahojeafaser > 0){
                  echo '<script>document.getElementById("parahojeafaser").innerHTML = "'.$parahojeafaser.'";</script>';
                  echo '<script>document.getElementById("parahojeafaser").style.display = "block";</script>';
                }
                if($noprazoafaser > 0){
                  echo '<script>document.getElementById("noprazoafaser").innerHTML = "'.$noprazoafaser.'";</script>';
                  echo '<script>document.getElementById("noprazoafaser").style.display = "block";</script>';
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
              $sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 1 
                ORDER BY 
                CASE 
                    WHEN prioridade_servico = 'U' THEN 1
                    WHEN prioridade_servico = 'A' THEN 2
                    WHEN prioridade_servico = 'M' THEN 3
                    ELSE 4
                END, cd_servico";

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
                echo '<th>Prioridade</th>';
                echo '<th>Prazo</th>';
                
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while ( $servico = $resulta_servico->fetch_assoc()){
                  echo '<tr>';
                  echo '<form method="POST" action="pages/md_assistencia/consulta_servico.php">';
                  echo '<td style="display: none;"><input type="tel" id="conos_servico" name="conos_servico" value="'.$servico['cd_servico'].'"></td>';
                  echo '<td><button type="submit" class="btn btn-danger" name="btn_cd_'.$servico['cd_servico'].'" id="btn_cd_'.$servico['cd_servico'].'">'.$servico['cd_servico'].'</button></td>';
                  echo '</form>';

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
              //"SELECT marca_patrimonio, modelo_patrimonio, COUNT(*) AS total FROM tb_patrimonio WHERE tipo_patrimonio = 'Impressora' GROUP BY marca_patrimonio, modelo_patrimonio";
              //$sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 0";
              $sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 2 
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
                echo '<table class="table" '.$_SESSION['c_card'].'>';
                echo '<thead>';
                echo '<tr>';
                echo '<th>OS</th>';
                echo '<th>Prioridade</th>';
                echo '<th>Prazo</th>';
                
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                
            
                  

                  
                while ( $servico = $resulta_servico->fetch_assoc()){
                  echo '<tr>';
                  echo '<form method="POST" action="pages/md_assistencia/consulta_servico.php">';
                  echo '<td style="display: none;"><input type="tel" id="conos_servico" name="conos_servico" value="'.$servico['cd_servico'].'"></td>';
                  echo '<td><button type="submit" class="btn btn-danger" name="btn_cd_'.$servico['cd_servico'].'" id="btn_cd_'.$servico['cd_servico'].'">'.$servico['cd_servico'].'</button></td>';
                
                  echo '</form>';
                  

                  if(date('Y-m-d', strtotime('+1 hour')) > date('Y-m-d', strtotime($servico['prazo_servico']))){
                    echo '<script>document.getElementById("btn_cd_'.$servico['cd_servico'].'").className = "btn btn-danger";</script>';
                    //$extrapolado = $extrapolado+1;
                  }else{
                    if(date('Y-m-d', strtotime('+1 hour')) == date('Y-m-d', strtotime($servico['prazo_servico']))){
                    echo '<script>document.getElementById("btn_cd_'.$servico['cd_servico'].'").className = "btn btn-warning";</script>';
                    //$parahoje = $parahoje+1;
                    }else{
                      if(date('Y-m-d', strtotime('+1 hour')) < date('Y-m-d', strtotime($servico['prazo_servico']))){
                        echo '<script>document.getElementById("btn_cd_'.$servico['cd_servico'].'").className = "btn btn-success";</script>';
                        //$noprazo = $noprazo+1;
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
                  
                  echo '</tr>';
                }
                
                 
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                echo '</li>';
                echo '</div>';
                echo '</div>';
                echo '</div>';  
              }
            ?>

            <?php //RETIRADO / DEVOLVIDO
              //"SELECT marca_patrimonio, modelo_patrimonio, COUNT(*) AS total FROM tb_patrimonio WHERE tipo_patrimonio = 'Impressora' GROUP BY marca_patrimonio, modelo_patrimonio";
              //$sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 0";
              $sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 3 
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
                
                echo '<table class="table" '.$_SESSION['c_card'].'>';
                echo '<thead>';
                echo '<tr>';
                echo '<th>OS</th>';
                echo '<th>Prioridade</th>';
                echo '<th>Prazo</th>';
                
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while ( $servico = $resulta_servico->fetch_assoc()){
                  echo '<tr>';
                  echo '<form method="POST" action="pages/md_assistencia/consulta_servico.php">';
                  echo '<td style="display: none;"><input type="tel" id="conos_servico" name="conos_servico" value="'.$servico['cd_servico'].'"></td>';
                  echo '<td><button type="submit" class="btn btn-danger" name="btn_cd_'.$servico['cd_servico'].'" id="btn_cd_'.$servico['cd_servico'].'">'.$servico['cd_servico'].'</button></td>';
                  echo '</form>';

                  if(date('Y-m-d', strtotime('+1 hour')) > date('Y-m-d', strtotime($servico['prazo_servico']))){
                    echo '<script>document.getElementById("btn_cd_'.$servico['cd_servico'].'").className = "btn btn-danger";</script>';
                    //$extrapolado = $extrapolado+1;
                  }else{
                    if(date('Y-m-d', strtotime('+1 hour')) == date('Y-m-d', strtotime($servico['prazo_servico']))){
                    echo '<script>document.getElementById("btn_cd_'.$servico['cd_servico'].'").className = "btn btn-warning";</script>';
                    //$parahoje = $parahoje+1;
                    }else{
                      if(date('Y-m-d', strtotime('+1 hour')) < date('Y-m-d', strtotime($servico['prazo_servico']))){
                        echo '<script>document.getElementById("btn_cd_'.$servico['cd_servico'].'").className = "btn btn-success";</script>';
                        //$noprazo = $noprazo+1;
                      }
                    }
                  }

              //    // Contagem de equipamentos em uso
              //    $sql_cliente = "SELECT * FROM tb_cliente WHERE cd_cliente = '".$servico['cd_cliente']."'"; 
              //    $resulta_cliente = $conn->query($sql_cliente);
              //    $cliente = $resulta_cliente->fetch_assoc();
                  
              //    echo '<td>'.$cliente['pnome_cliente'].'</td>';

              //    // Contagem de equipamentos fora de uso
                  
              //    echo '<td>'.$cliente['tel_cliente'].'</td>';

              //    //echo '<td><label class="badge badge-info">'.$qtd_uso.'</label></td>';
              //    //echo '<td><label class="badge badge-warning">'.$qtd_fora_de_uso.'</label></td>';
                  
                  


                  
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
                  echo '<script>document.getElementById("botoes").style.display = "none";</script>';//
                }
                echo '</tbody>';
                echo '</table>';
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