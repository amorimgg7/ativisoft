

                <?php



if(isset($_POST['bt_casa_selecionada'])){
  $_SESSION['cd_casa_selecionada'] = $_POST['cd_casa_selecionada'];
}

                  $sql_casa = "SELECT * FROM tb_casa";
                  $resulta_casa = $conn->query($sql_casa);
                  if ($resulta_casa->num_rows == 1){
                    while ( $casa = $resulta_casa->fetch_assoc()){
                      $_SESSION['cd_casa'] = $casa['cd_casa'];
                      echo '<div class="card-deck">';
                      ?>
                      <script>
                        function updateContent1() {
                          fetch('../../partials/p2.php')
                          .then(response => response.text())
                          .then(data => {
                            document.getElementById('content1').innerHTML = data;
                          })
                          .catch(error => console.error('Erro:', error));
                        }
                        setInterval(updateContent1, 3000);
                        window.onload = updateContent1;
                      </script>
                      <div style="width:100" class="typeahead" id="content1" style="display: inline-block; column-break-inside: avoid;   "><h1>Carregando #1...</h1></div>
                    <?php

                      echo '</div>';
                    }
                  }
                  if ($resulta_casa->num_rows > 1){
                    echo '<div class="row">';
                    while ( $casas = $resulta_casa->fetch_assoc()){  
                      if($casas['status_casa'] == '0'){
                        echo '<div class="col-md-6">';
                        echo '<div class="card mb-3 border-success shadow-sm align-items-center" id="casa_'.$casas['cd_casa'].'">';
                        //echo '<div class="card-header bg-success" style="width: 100%; text-align:center;">Livre - '.$_SESSION['cd_casa_selecionada'].'</div>';
                        echo '<form method="POST">';
                        echo '<input type="text" value="'.$casas['cd_casa'].'" id="cd_casa_selecionada" name="cd_casa_selecionada" style="display:none;">';

                        
                        
                        echo '<div class="card-header bg-success" style="width: 100%; text-align:center;"><input class="btn btn-block btn-success" type="submit" id="bt_casa_selecionada" name="bt_casa_selecionada" value="Clique aqui - '.$casas['titulo_casa'].'"></div>'; 
                        echo '</form>'; 


                      }else if($casas['status_casa'] == '1'){
                        echo '<div class="card mb-3 border-info shadow-sm align-items-center">';
                        echo '<div class="card-header bg-info" style="width: 100%; text-align:center;">Reservado</div>';
                      }else if($casas['status_casa'] == '2'){
                        echo '<div class="card mb-3 border-info shadow-sm align-items-center">';
                        echo '<div class="card-header bg-info" style="width: 100%; text-align:center;">Ocupado</div>';
                      }else if($casas['status_casa'] == '3'){
                        echo '<div class="card mb-3 border-warning shadow-sm align-items-center">';
                        echo '<div class="card-header bg-warning" style="width: 100%; text-align:center;">Em preparação</div>';
                      }else{
                        echo '<div class="card mb-3 border-warning shadow-sm align-items-center">';
                        echo '<div class="card-header bg-danger" style="width: 100%; text-align:center;">Sinistro</div>';
                      }
                      echo '<div class="card-body">';
                      echo '<h5 class="card-title">'.$casas['titulo_casa'].'</h5>';
                      echo '<p class="card-text">'.$casas['obs_casa'].'</p>';
                      echo '</div>';
                      echo '<div class="card-footer text-muted" style="width: 100%; text-align:center;">';
                      
                      $sql_dispositivo = "SELECT * FROM tb_dispositivo where cd_casa_dispositivo = '".$casas['cd_casa']."' ";
                      $resulta_dispositivo = $conn->query($sql_dispositivo);
                      if ($resulta_dispositivo->num_rows > 0) {
                        while ($dispositivo = $resulta_dispositivo->fetch_assoc()) {
                          //echo '<p style="text-align: center;"> ';
                          $dataStatus = strtotime($dispositivo['dt_status_dispositivo']);
                          $dataAtual = time();
                          if (($dataAtual - $dataStatus) > 10) {
                            if($dispositivo['modelo_dispositivo'] == "Higrometro_1_0"){
                              echo ' <i style="color: #D00;" class="icon-thermometer"></i>';
                            }else if($dispositivo['modelo_dispositivo'] == 'Luzes_2_0'){
                              echo ' <i style="color: #D00;" class="icon-record"></i>';
                            }else if($dispositivo['modelo_dispositivo'] == 'PowerBalance_1_0'){
                              echo ' <i style="color: #D00;" class="icon-record"></i>';
                            }
                          }else{
                            if($dispositivo['modelo_dispositivo'] == "Higrometro_1_0"){
                              echo ' <i style="color: #0D0;" class="icon-thermometer"></i>';
                            }else if($dispositivo['modelo_dispositivo'] == 'Luzes_2_0'){
                              echo ' <i style="color: #0D0;" class="icon-record"></i>';
                            }else if($dispositivo['modelo_dispositivo'] == 'PowerBalance_1_0'){
                              echo ' <i style="color: #0D0;" class="icon-record"></i>';
                            }
                          }
                          //echo ' </p>';
                        }
                      }
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                      

                      
                      

                      if (isset($_SESSION['cd_casa_selecionada']) && $_SESSION['cd_casa_selecionada'] > 0) {
                        if ($_SESSION['cd_casa_selecionada'] == $casas['cd_casa']) {
                          $_SESSION['cd_casa'] = $casas['cd_casa'];
                            // Mostra a div se a casa selecionada corresponder
                            echo "<script>
                                document.getElementById('casa_".$casas['cd_casa']."').style.display = 'none';
                            </script>";

                            ?>
                      <script>
                        function updateContent1() {
                          fetch('../../partials/p2.php')
                          .then(response => response.text())
                          .then(data => {
                            document.getElementById('content1').innerHTML = data;
                          })
                          .catch(error => console.error('Erro:', error));
                        }
                        setInterval(updateContent1, 3000);
                        window.onload = updateContent1;
                      </script>
                      <div style="width:100" class="typeahead" id="content1" style="display: inline-block; column-break-inside: avoid;   "><h1>Carregando #1...</h1></div>
                    <?php


                        } else {
                            // A div permanece escondida
                            echo "<script>
                                document.getElementById('casa_".$casas['cd_casa']."').style.display = 'none';
                            </script>";
                        }
                      }else{
                        $_SESSION['cd_casa'] = 0;
                        echo  "<script>
                                document.getElementById('casa_".$casas['cd_casa']."').style.display = 'block';
                                document.getElementById('content1').style.display = 'none';
                              </script>";
                      }
                      


                      
                    }


                    echo '</div>';

                        
                  }

                  echo '<form method="POST">';
                  echo '<input type="text" value="0" id="cd_casa_selecionada" name="cd_casa_selecionada" style="display:none;">';
                  echo '<input class="m-3 btn btn-warning btn-rounded" type="submit" id="bt_casa_selecionada" name="bt_casa_selecionada" value="Voltar">'; 
                  echo '</form>';
                ?>
             
          </div>