<div class="col-lg-12 grid-margin stretch-card">
<i type="submit" class="btn btn-warning"style="margin:auto; display:none;" id="comissao_a_pagar">Comissões a Pagar</i>
</div>


            <?php


              $comissao_a_pagar = 0;

              $sql_comissao = "
                SELECT c.*, p.pnome_pessoa AS nome_colab, p.*
                FROM tb_comissao c
                JOIN tb_pessoa p ON p.cd_pessoa = c.cd_colab
                WHERE c.status_comissao = 0
                  AND c.cd_filial = '".$_SESSION['cd_filial']."'
                ORDER BY c.cd_comissao desc
                ";


              $resulta_comissao = $conn->query($sql_comissao);
              if ($resulta_comissao->num_rows > 0){
                echo '<div class="col-lg-12 grid-margin stretch-card" >';
                echo '<div class="card" '.$_SESSION['c_card'].'>';
                
                echo '<div class="card-body">';
                echo '<div class="grid-margin stretch-card">';
                echo '<h4 style="display: inline-block; margin-left: 10px;">COMISSÕES À PAGAR</h4>';
                echo '</div>';

                echo '<div class=" table-responsive">';
                
                echo '<table class="table" '.$_SESSION['c_card'].'>';
                echo '<thead>';
                echo '<tr>';
                echo '<th>CD</th>';
                echo '<th>Colaborador</th>';
                echo '<th>Obs</th>';
                echo '<th>valor</th>';
                //echo '<th>Prazo</th>';
                
                
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                
                while ( $comissao = $resulta_comissao->fetch_assoc()){
                  echo '<tr>';
                  echo '<form method="POST" action="../../pages/md_assistencia/consulta_servico.php">';
                  echo '<td style="display: none;"><input type="tel" id="conos_servico" name="conos_servico" value="'.$comissao['cd_comissao'].'"></td>';
                  echo '<td><button type="submit" class="btn btn-warning" name="btn_cd_'.$comissao['cd_comissao'].'" id="btn_cd_'.$comissao['cd_comissao'].'">'.$comissao['cd_comissao'].'</button></td>';
                  echo '</form>';
                  
                  echo '<td name="colab_'.$comissao['cd_colab'].'" id="colab_'.$comissao['cd_colab'].'">'.$comissao['nome_colab'].'</td>';
                  $obs_comissao = '';
                  if($comissao['cd_servico'] > 0){
                    $obs_comissao = $obs_comissao . 'Ordem de serviço: ' . $comissao['cd_servico'];
                  }
                  if($comissao['cd_venda'] > 0){
                    $obs_comissao = $obs_comissao . 'Venda de serviço: ' . $comissao['cd_venda'];
                  }
                  $obs_comissao = $obs_comissao . ' ('.$comissao['obs_comissao'].')';

                  echo '<td name="obs_'.$comissao['cd_comissao'].'" id="obs_'.$comissao['cd_comissao'].'">'.$obs_comissao.'</td>';
                  echo '<td name="vl_comissao_'.$comissao['cd_comissao'].'" id="vl_comissao_'.$comissao['cd_comissao'].'">R$: '.$comissao['vl_comissao'].'</td>';

                  echo '<form method="POST">';
                  echo '<td style="display: none;"><input type="tel" id="pagar_cd_comissao" name="pagar_cd_comissao" value="'.$comissao['cd_comissao'].'"></td>';
                  echo '<td><button type="submit" class="btn btn-warning" name="pagar_comissao" id="pagar_comissao">PAGAR ('.$comissao['cd_comissao'].')</button></td>';
                  echo '</form>';

                  $comissao_a_pagar = number_format($comissao_a_pagar + $comissao['vl_comissao'], 2, ',', '.');
                  echo '<script>document.getElementById("comissao_a_pagar").innerHTML = "R$: '.$comissao_a_pagar.'";</script>';
                  echo '<script>document.getElementById("comissao_a_pagar").style.display = "block";</script>';
                  
                }
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                
              }



            ?>

            