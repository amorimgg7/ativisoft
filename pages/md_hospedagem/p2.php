
<?php 
    session_start();  
    
    require_once '../../classes/conn.php';
?><!--Validar sessão aberta, se usuário está logado.-->


<?php
                   echo 'Atualizado em: '.date("d/m/Y H:i:s").' !';
                  $sql_casa = "SELECT * FROM tb_dispositivo where cd_casa_dispositivo = ".$_SESSION['cd_casa'];
                  $resulta_casa = $conn->query($sql_casa);
                  if ($resulta_casa->num_rows > 0){
                    while ( $casas = $resulta_casa->fetch_assoc()){
                      //echo '<div class="col">';

                      if (isset($casas['dt_status_dispositivo'])) {
                        $dataStatus = strtotime($casas['dt_status_dispositivo']);
                        $dataAtual = time();
                    
                        if (($dataAtual - $dataStatus) > 30) {
                            // A data e hora são maiores que 30 segundos
                          echo '<div class="card text-white border-danger mb-3 shadow-sm bg-secondary mb-3 align-items-center" style="margin: 10px; max-width: 18rem;">';
                          echo '<div class="card-header bg-danger">Offline</div>';    
                        } else {
                            // A data e hora não são maiores que 30 segundos
                          echo '<div class="card text-white border-success mb-3 bg-secondary mb-3 align-items-center" style="margin: 10px; max-width: 18rem;">';
                          echo '<div class="card-header bg-success">Online</div>'; 
                        }

                      }
                      
                      echo '<div class="card-body">';
                      echo '<h5 class="card-title">'.$casas['local_dispositivo'].'</h5>';
                      echo '<h5 class="card-title">'.$casas['marca_dispositivo'].' '.$casas['modelo_dispositivo'].' '.$casas['versao_dispositivo'].'</h5>';
                      echo '<p class="card-title">IP - '.$casas['ip_dispositivo'].'</p>';
                      echo '<p class="card-title">MAC - '.$casas['mac_dispositivo'].'</p>';
                      echo '</div>';
                      echo '<div class="card-footer text-muted">';
                      //<a href="'.$_SESSION['dominio'].'/pages/filmes/index.php?cd_filme='.$casas['cd_casa'].'" title="'.$casas['titulo_casa'].'">
                      echo '<form method="post" action="'.$_SESSION['dominio'].'/pages/md_hospedagem/editar_dispositivo.php">';
                      echo '<input type="text" id="concd_dispositivo" name="concd_dispositivo" value="'.$casas['cd_dispositivo'].'" style="display:none;">';
                      echo '<input class="btn btn-outline-success btn-lg btn-block" type="submit" value="Parametros">';
                      //echo '<input class="btn btn-outline-success btn-lg btn-block" type="submit" value="#2">';
                      echo '</form>';
                      //echo '<a href="'.$_SESSION['dominio'].'/pages/md_hospedagem/editar_casa.php?cd_casa='.$casas['cd_casa'].'" class="btn btn-outline-success btn-lg btn-block">Parametros</a>';
                      echo '</div>';
                      echo '</div>';
                      //echo '</a>';
                      //echo '</div>';
                    }
                  }
                  
                  
                  
                  
                  //echo '</div>';
                  //echo '</div>';
                  echo '</div>';
                  echo '</div>';
                  echo '</div>';
                ?>
                
