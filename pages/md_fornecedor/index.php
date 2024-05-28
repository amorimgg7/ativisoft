



            <?php
            
              $sql_cliente_novo = "SELECT * FROM tb_cliente_comercial where cd_matriz_comercial IS NULL";
              $resulta_cliente_novo = $conn->query($sql_cliente_novo);
              if ($resulta_cliente_novo->num_rows > 0){
                while ( $cliente_novo = $resulta_cliente_novo->fetch_assoc()){
                    echo '<div class="col-lg-12 grid-margin stretch-card" data-toggle="collapse" href="#cliente_'.$cliente_novo['cd_cliente_comercial'].'" aria-expanded="false" aria-controls="os_afaser">';
                    echo '<div class="card" '.$_SESSION['c_card'].'>';
                    echo '<div class="card-body">';
                    echo '<div class="grid-margin stretch-card">';
                    echo '<h6 style="display: inline-block; margin-left: 10px;">'. $cliente_novo['rsocial_cliente_comercial'] .'</br>'. $cliente_novo['cnpj_cliente_comercial'] .'</h6>';
                    echo '<div style="position: absolute; right: 10px; text-align: right;">';
                    echo '</br></br><i id="status_cd_cliente_comercial_'.$cliente_novo['cd_cliente_comercial'].'"></i>';
                    echo '<i style="margin: auto;" id="statusfinanceiro_cd_cliente_comercial_'.$cliente_novo['cd_cliente_comercial'].'"></i>';
                    echo '</div>';
                    echo '<i class="btn btn-warning" style=" display:block;" id="parahojeafaser">Criar ambiente</i>';
                    echo '</div>';
                    echo '<div class="collapse table-responsive" id="cliente_'.$cliente_novo['cd_cliente_comercial'].'">';
                    echo '<table class="table" '.$_SESSION['c_card'].'>';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th>Código</th>';
                    echo '<th>Razão Social</th>';
                    echo '<th>Data de Cadastro</th>';
                    echo '<th>Vencimento do Contrato</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                    
                    
                            echo '<tr>';
                            echo '<form method="POST" action="../../pages/md_fornecedor/consultar_cliente_comercial.php">';
                            echo '<td style="display: none;"><input type="tel" id="concnpj_cliente_comercial" name="concnpj_cliente_comercial" value="'.$cliente_novo['cnpj_cliente_comercial'].'"></td>';
                            echo '<td><button type="submit" class="btn btn-info" name="btn_cnpj_'.$cliente_novo['cnpj_cliente_comercial'].'" id="btn_cd_'.$cliente_novo['cnpj_cliente_comercial'].'">'.$cliente_novo['cnpj_cliente_comercial'].'</button></td>';
                            echo '<td><button type="submit" class="btn btn-info" name="btn_cnpj_'.$cliente_novo['cnpj_cliente_comercial'].'" id="btn_cd_'.$cliente_novo['cnpj_cliente_comercial'].'">'.$cliente_novo['cnpj_cliente_comercial'].'</button></td>';
                            echo '</form>';
                            echo '<td><p>'.$cliente_novo['rsocial_cliente_comercial'].'</p></td>';
                            echo '<td><p>'.date('d/m/y', strtotime($cliente_novo['dtcadastro_cliente_comercial'])).'</p></td>';
                            echo '<td><p>'.date('d/m/y', strtotime($cliente_novo['dtvalidlicenca_cliente_comercial'])).'</p></td>';
                            $data_fornecida = $cliente_novo['dtvalidlicenca_cliente_comercial'];
                            $diferenca_dias = round((strtotime($data_fornecida) - time()) / (60 * 60 * 24));
                            if($diferenca_dias >= 0){
                              echo '<script>document.getElementById("status_cd_cliente_comercial_'.$cliente_novo['cd_cliente_comercial'].'").innerHTML = "<td><p>Expira em: '.$diferenca_dias.' dia(s).</p></td>"; document.getElementById("status_cd_cliente_comercial_'.$cliente_novo['cd_cliente_comercial'].'").style.display = "block";</script>';
                            }else{
                              echo '<script>document.getElementById("status_cd_cliente_comercial_'.$cliente_novo['cd_cliente_comercial'].'").innerHTML = "<p class=\"badge badge-danger\">Expirado a: '.-$diferenca_dias.' dia(s).</p><br><p>Tolerância de 10 dias para multa estipulada em contrato</p>"; document.getElementById("status_cd_cliente_comercial_'.$cliente_novo['cd_cliente_comercial'].'").style.display = "block";</script>';
                            }
                            if($diferenca_dias >= 0){
                              echo '<script>document.getElementById("statusfinanceiro_cd_cliente_comercial_'.$cliente_novo['cd_cliente_comercial'].'").innerHTML = "Prevista: R$:'. $cliente_novo['fatura_prevista_cliente_fiscal'] .'"; document.getElementById("statusfinanceiro_cd_cliente_comercial_'.$cliente_novo['cd_cliente_comercial'].'").style.display = "block";</script>';
                            }else if($diferenca_dias < 0 && $diferenca_dias > -10){
                              echo '<script>document.getElementById("statusfinanceiro_cd_cliente_comercial_'.$cliente_novo['cd_cliente_comercial'].'").innerHTML = "Prevista com atraso: R$:'. $cliente_novo['fatura_prevista_cliente_fiscal'] .'"; document.getElementById("statusfinanceiro_cd_cliente_comercial_'.$cliente_novo['cd_cliente_comercial'].'").style.display = "block";</script>';
                            }else{
                              $fatura_prevista = isset($cliente_novo['fatura_prevista_cliente_fiscal']) && is_numeric($cliente_novo['fatura_prevista_cliente_fiscal']) ? $cliente_novo['fatura_prevista_cliente_fiscal'] : 0;
                              $fatura_devida = isset($cliente_novo['fatura_devida_cliente_fiscal']) && is_numeric($cliente_novo['fatura_devida_cliente_fiscal']) ? $cliente_novo['fatura_devida_cliente_fiscal'] : 0;
                              echo '<script>document.getElementById("statusfinanceiro_cd_cliente_comercial_'.$cliente_novo['cd_cliente_comercial'].'").innerHTML = "Vencida com juros: R$:' . ($fatura_prevista - $diferenca_dias) . '"; document.getElementById("statusfinanceiro_cd_cliente_comercial_'.$cliente_novo['cd_cliente_comercial'].'").style.display = "block";</script>';
                            }
                            echo '</tr>';
                        
                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';
                    }
                  }   
                    
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                
              



              $sql_cliente_matriz = "SELECT * FROM tb_cliente_comercial where cd_cliente_comercial = cd_matriz_comercial order by dtvalidlicenca_cliente_comercial ASC";
              $resulta_cliente_matriz = $conn->query($sql_cliente_matriz);
              if ($resulta_cliente_matriz->num_rows > 0){
                while ( $cliente_matriz = $resulta_cliente_matriz->fetch_assoc()){
                    echo '<div class="col-lg-12 grid-margin stretch-card" data-toggle="collapse" href="#cliente_'.$cliente_matriz['cd_cliente_comercial'].'" aria-expanded="false" aria-controls="os_afaser">';
                    echo '<div class="card" '.$_SESSION['c_card'].'>';
                    echo '<div class="card-body">';
                    echo '<div class="grid-margin stretch-card">';
                    echo '<h6 style="display: inline-block; margin-left: 10px;">'. $cliente_matriz['rsocial_cliente_comercial'] .'</br>'. $cliente_matriz['cnpj_cliente_comercial'] .'</h6>';
                    echo '<div style="position: absolute; right: 10px; text-align: right;">';
                    echo '</br></br><i id="status_cd_cliente_comercial_'.$cliente_matriz['cd_cliente_comercial'].'"></i>';
                    echo '<i style="margin: auto;" id="statusfinanceiro_cd_cliente_comercial_'.$cliente_matriz['cd_cliente_comercial'].'"></i>';
                    echo '</div>';
                    echo '<i class="btn btn-warning" style=" display:none;" id="parahojeafaser"></i><i class="btn btn-danger" style="margin:auto; display:none;" id="extrapoladoafaser"></i>';
                    echo '</div>';
                    echo '<div class="collapse table-responsive" id="cliente_'.$cliente_matriz['cd_cliente_comercial'].'">';
                    echo '<table class="table" '.$_SESSION['c_card'].'>';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th>Código</th>';
                    echo '<th>Razão Social</th>';
                    echo '<th>Data de Cadastro</th>';
                    echo '<th>Vencimento do Contrato</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                    $sql_cliente_filial = "SELECT * FROM tb_cliente_comercial where cd_matriz_comercial = ".$cliente_matriz['cd_cliente_comercial'];
                    $resulta_cliente_filial = $conn->query($sql_cliente_filial);
                    if ($resulta_cliente_filial->num_rows > 0){
                        while ( $cliente_filial = $resulta_cliente_filial->fetch_assoc()){
                            echo '<tr>';
                            echo '<form method="POST" action="../../pages/md_fornecedor/consultar_cliente_comercial.php">';
                            echo '<td style="display: none;"><input type="tel" id="concnpj_cliente_comercial" name="concnpj_cliente_comercial" value="'.$cliente_filial['cnpj_cliente_comercial'].'"></td>';
                            echo '<td><button type="submit" class="btn btn-info" name="btn_cnpj_'.$cliente_filial['cnpj_cliente_comercial'].'" id="btn_cd_'.$cliente_filial['cnpj_cliente_comercial'].'">'.$cliente_filial['cnpj_cliente_comercial'].'</button></td>';
                            echo '</form>';
                            echo '<td><p>'.$cliente_filial['rsocial_cliente_comercial'].'</p></td>';
                            echo '<td><p>'.date('d/m/y', strtotime($cliente_filial['dtcadastro_cliente_comercial'])).'</p></td>';
                            echo '<td><p>'.date('d/m/y', strtotime($cliente_filial['dtvalidlicenca_cliente_comercial'])).'</p></td>';
                            $data_fornecida = $cliente_filial['dtvalidlicenca_cliente_comercial'];
                            $diferenca_dias = round((strtotime($data_fornecida) - time()) / (60 * 60 * 24));
                            if($diferenca_dias >= 0){
                              echo '<script>document.getElementById("status_cd_cliente_comercial_'.$cliente_filial['cd_cliente_comercial'].'").innerHTML = "<td><p>Expira em: '.$diferenca_dias.' dia(s).</p></td>"; document.getElementById("status_cd_cliente_comercial_'.$cliente_filial['cd_cliente_comercial'].'").style.display = "block";</script>';
                            }else{
                              echo '<script>document.getElementById("status_cd_cliente_comercial_'.$cliente_filial['cd_cliente_comercial'].'").innerHTML = "<p class=\"badge badge-danger\">Expirado a: '.-$diferenca_dias.' dia(s) .</p><br><p>Tolerância de 10 dias para multa estipulada em contrato</p>"; document.getElementById("status_cd_cliente_comercial_'.$cliente_filial['cd_cliente_comercial'].'").style.display = "block";</script>';
                            }
                            if($diferenca_dias >= 0){
                              echo '<script>document.getElementById("statusfinanceiro_cd_cliente_comercial_'.$cliente_filial['cd_cliente_comercial'].'").innerHTML = "Prevista: R$:'. $cliente_filial['fatura_prevista_cliente_fiscal'] .'"; document.getElementById("statusfinanceiro_cd_cliente_comercial_'.$cliente_filial['cd_cliente_comercial'].'").style.display = "block";</script>';
                            }else if($diferenca_dias < 0 && $diferenca_dias > -10){
                              echo '<script>document.getElementById("statusfinanceiro_cd_cliente_comercial_'.$cliente_filial['cd_cliente_comercial'].'").innerHTML = "Prevista com atraso: R$:'. $cliente_filial['fatura_prevista_cliente_fiscal'] .'"; document.getElementById("statusfinanceiro_cd_cliente_comercial_'.$cliente_filial['cd_cliente_comercial'].'").style.display = "block";</script>';
                            }else{
                              $fatura_prevista = isset($cliente_filial['fatura_prevista_cliente_fiscal']) && is_numeric($cliente_filial['fatura_prevista_cliente_fiscal']) ? $cliente_filial['fatura_prevista_cliente_fiscal'] : 0;
                              $fatura_devida = isset($cliente_filial['fatura_devida_cliente_fiscal']) && is_numeric($cliente_filial['fatura_devida_cliente_fiscal']) ? $cliente_filial['fatura_devida_cliente_fiscal'] : 0;
                              echo '<script>document.getElementById("statusfinanceiro_cd_cliente_comercial_'.$cliente_filial['cd_cliente_comercial'].'").innerHTML = "Vencida com juros: R$:' . ($fatura_prevista - $diferenca_dias) . '"; document.getElementById("statusfinanceiro_cd_cliente_comercial_'.$cliente_filial['cd_cliente_comercial'].'").style.display = "block";</script>';
                            }
                            echo '</tr>';
                        }
                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';
                    }
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
              }
            ?>