<div class="col-lg-12 grid-margin stretch-card">
<i type="submit" class="btn btn-success"style="margin:auto; display:none;"id="noprazo">Ativo</i>
<i type="submit" class="btn btn-warning"style="margin:auto; display:none;"id="parahoje">Devendo</i>
<i type="submit" class="btn btn-danger"style="margin:auto; display:none;" id="extrapolado">Licença Expirada</i>
</div>

            <?php //À FAZER
              //"SELECT marca_patrimonio, modelo_patrimonio, COUNT(*) AS total FROM tb_patrimonio WHERE tipo_patrimonio = 'Impressora' GROUP BY marca_patrimonio, modelo_patrimonio";
              //$sql_servico = "SELECT * FROM tb_servico WHERE status_servico = 0";
              $sql_cliente = "SELECT * FROM tb_cliente WHERE cnpj_cliente > 0";
              $resulta_cliente = $conn->query($sql_cliente);
              if ($resulta_cliente->num_rows > 0){
                $extrapolado = 0;
                $extrapoladoafaser = 0;
                $parahoje = 0;
                $parahojeafazer = 0;
                $noprazo = 0;
                $noprazoafaser = 0;
                while ( $cliente = $resulta_cliente->fetch_assoc()){
                    $sql_cliente_base = "SELECT * FROM tb_filial WHERE cnpj_cliente > 0";
                    $resulta_cliente_base = $conn_base.$cliente['cnpj_cliente']->query($sql_cliente_base);

                    echo '<div class="col-lg-12 grid-margin stretch-card" data-toggle="collapse" href="#cliente_'.$cliente['cd_cliente'].'" aria-expanded="false" aria-controls="os_afaser">';
                    echo '<div class="card" '.$_SESSION['c_card'].'>';
                    
                    echo '<div class="card-body">';
                    echo '<div class="grid-margin stretch-card">';
                    echo '<h4 style="display: inline-block; margin-left: 10px;">Razão Social - '. $cliente['cnpj_cliente'] .'</h4>';
                    echo '<i class="btn btn-success" style="margin:auto; display:none;" id="noprazoafaser"></i><i class="btn btn-warning" style="margin:auto; display:none;" id="parahojeafaser"></i><i class="btn btn-danger" style="margin:auto; display:none;" id="extrapoladoafaser"></i>';
                    echo '</div>';

                    
                    echo '<div class="collapse table-responsive" id="cliente_'.$cliente['cd_cliente'].'">';
                    
                    echo '<table class="table" '.$_SESSION['c_card'].'>';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th>CD</th>';
                    echo '<th>Financeiro</th>';
                    echo '<th>Prioridade</th>';
                    echo '<th>Prazo</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';

                    echo '<tr>';
                    echo '<form method="POST" action="../../pages/md_assistencia/consulta_servico.php">';
                    echo '<td style="display: none;"><input type="tel" id="conos_servico" name="conos_servico" value="'.$cliente['cd_cliente'].'"></td>';
                    echo '<td><button type="submit" class="btn btn-danger" name="btn_cd_'.$cliente['cd_cliente'].'" id="btn_cd_'.$cliente['cd_cliente'].'">'.$cliente['cd_cliente'].'</button></td>';
                    echo '</form>';
                    
                    echo '</tbody>';
                    echo '</table>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';

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
              }
            ?>