<div class="col-lg-12 grid-margin stretch-card">
<i type="submit" class="btn btn-success"style="margin:auto; display:none;"id="noprazo">Livre</i>
<i type="submit" class="btn btn-warning"style="margin:auto; display:none;"id="parahoje">Ocupado</i>
<i type="submit" class="btn btn-danger"style="margin:auto; display:none;" id="extrapolado">Em Preparação</i>
</div>




<?php



if(!isset($livre)){
  $livre = 0;
}
if(!isset($preparando)){
  $preparando = 0;
}
if(!isset($ocupado)){
  $ocupado = 0;
}

?>
<div class="row mt-3">
            <div class="col-xl-3 flex-column d-flex grid-margin stretch-card">
              <div class="row flex-grow">       
                <?php
                  $sql_casa = "SELECT * FROM tb_casa";
                  $resulta_casa = $conn->query($sql_casa);
                  if ($resulta_casa->num_rows > 0){
                    while ( $casas = $resulta_casa->fetch_assoc()){
                      echo '<div class="col">';
                      //echo '<a href="'.$_SESSION['dominio'].'/pages/filmes/index.php?cd_filme='.$casas['cd_casa'].'" title="'.$casas['titulo_casa'].'">';
                      

                      //class="card border-success mb-3" style="max-width: 18rem;"  livre       0 
                      //class="card border-info mb-3" style="max-width: 18rem;"     preparando  1
                      //class="card border-warning mb-3" style="max-width: 18rem;"  ocupado     2
                      

                      if($casas['status_casa'] == '0'){
                        echo '<div class="card border-success mb-3 shadow-sm align-items-center" style="max-width: 18rem;">';
                        echo '<div class="card-header bg-success">Livre</div>';

                      }else if($casas['status_casa'] == '1'){
                        echo '<div class="card border-info mb-3 shadow-sm align-items-center" style="max-width: 18rem;">';
                        echo '<div class="card-header bg-info">Reservado</div>';

                      }else if($casas['status_casa'] == '2'){
                        echo '<div class="card border-info mb-3 shadow-sm align-items-center" style="max-width: 18rem;">';
                        echo '<div class="card-header bg-info">Ocupado</div>';

                      }else if($casas['status_casa'] == '3'){
                        echo '<div class="card border-warning mb-3 shadow-sm align-items-center" style="max-width: 18rem;">';
                        echo '<div class="card-header bg-warning">Em preparação</div>';

                      }else{
                        echo '<div class="card border-danger mb-3 shadow-sm align-items-center" style="max-width: 18rem;">';
                        echo '<div class="card-header bg-danger">Sinistro</div>';

                      }


                      
                      echo '<div class="card-body">';

                      echo '<h5 class="card-title">'.$casas['titulo_casa'].'</h5>';

                      if($casas['tipo_exercicio'] == 'A'){
                        echo '<p class="card-text">ALUGA-SE - R$: '.$casas['valor_aluga'];
                      }else if($casas['tipo_exercicio'] == 'V'){
                        echo '<p class="card-text">VENDE-SE - R$: '.$casas['valor_venda'];
                      }else if($casas['tipo_exercicio'] == 'AV'){
                        echo '<p class="card-text">ALUGA-SE - R$: '.$casas['valor_aluga'];
                        echo '<p class="card-text">VENDE-SE - R$: '.$casas['valor_venda'];
                      }

                      //echo '<p class="card-text">'.$casas['obs_casa'].'</p>';
                      //echo '<img src="'.$casas['imagem_capa_casa'].'" width="180" height="240" class="img-responsive">';
                      echo '</div>';

                      echo '<div class="card-footer text-muted">';
                      //<a href="'.$_SESSION['dominio'].'/pages/filmes/index.php?cd_filme='.$casas['cd_casa'].'" title="'.$casas['titulo_casa'].'">
                      echo '<form method="post" action="'.$_SESSION['dominio'].'/pages/md_hospedagem/editar_casa.php">';

                      echo '<input type="text" id="concd_casa" name="concd_casa" value="'.$casas['cd_casa'].'" style="display:none;">';
                      echo '<input class="btn btn-outline-success btn-lg btn-block" type="submit" value="Parametros">';
                      echo '</form>';
                      //echo '<a href="'.$_SESSION['dominio'].'/pages/md_hospedagem/editar_casa.php?cd_casa='.$casas['cd_casa'].'" class="btn btn-outline-success btn-lg btn-block">Parametros</a>';
                      echo '</div>';

                      echo '</div>';
                      //echo '</a>';
                      echo '</div>';
                    }
                  }
                ?>
              </div>
            </div>
          </div>


          


<?php





              if(isset($livre) > 0){
                echo '<script>document.getElementById("livre").innerHTML = "Para Hoje</br>'.$livre.'";</script>';
                echo '<script>document.getElementById("livre").style.display = "block";</script>';
              }
              if($preparando > 0){
                echo '<script>document.getElementById("preparando").innerHTML = "No Prazo</br>'.$preparando.'";</script>';
                echo '<script>document.getElementById("preparando").style.display = "block";</script>';
              }
              if($ocupado > 0){
                echo '<script>document.getElementById("ocupado").innerHTML = "ocupado</br>'.$ocupado.'";</script>';
                echo '<script>document.getElementById("ocupado").style.display = "block";</script>';
              }
              
            ?>