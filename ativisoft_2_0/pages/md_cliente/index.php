<?php
    if($_SESSION['cd_empresa'] == 1)
    {
      echo '<h3>Sua empresa está cadastrada em nosso sistema?</h3>';
      echo '<div class="card-body">';
      echo '<div class="template-demo">';
      echo '<button type="button" class="btn btn-primary btn-icon-text" onclick="vincular()"><i class="mdi mdi-upload btn-icon-prepend"></i>Sim</button>';
      echo '<button type="button" class="btn btn-dark btn-icon-text" onclick="cadastrar()"><i class="mdi mdi-file-check btn-icon-append"></i>Não</button>';
      echo '</div>';
      echo '</div>';
      echo '<div class="card-body">';
      echo '<script>';
      echo 'function cadastrar() {';
      echo 'location.href="'.$_SESSION['dominio'].'pages/md_cliente/cadastro_empresa.php?";';
      echo 'document.getElementById("cadastrar").style.display = "block";';
      echo 'document.getElementById("vincular").style.display = "none";';
      echo '}';
      echo 'function vincular() {';
      echo 'document.getElementById("cadastrar").style.display = "none";';
      echo 'document.getElementById("vincular").style.display = "block";';
      echo '}';
      echo '</script>';
      echo '</div>';
    }
    else
    {
      $sql_tipo = "SELECT * FROM tb_empresa WHERE cd_empresa = ".$_SESSION['cd_empresa'].""; 
      $resulta = $conn->query($sql_tipo);
      if ($resulta->num_rows > 0)
      {
        echo '  <div class="col-xl-4 grid-margin stretch-card">';
        echo '<div class="card">';
        echo '  <div class="card-body">';
        echo '<h3>Total</h3>';
        while ( $row = $resulta->fetch_assoc()){
          echo '<h4 class="card-title mb-3">Empresa: '.$row['nfantasia_empresa'].' CNPJ: '.$row['cnpj_empresa'].'</h4>';
          echo '<div class="row">';
          echo '<div class="col-sm-12">';
          echo '<div class="text-dark">';
          echo '<div class="d-flex pb-3 border-bottom justify-content-between">';
          echo '<div class="mr-3"><i class="mdi mdi-signal-cellular-outline icon-md"></i></div>';
          echo '<div class="font-weight-bold mr-sm-4">';
          echo '<div>Dados gerais</div>';
          echo '<div class="text-muted font-weight-normal mt-1">São 3 salas com o total de 45 patrimonios cadastrados.</div>';
          echo '</div>';
          echo '<div><h6 class="font-weight-bold text-info ml-sm-2">R$: 0,00</h6></div>';
          echo '</div>';
        }
        $sql_tipo1 = "SELECT * FROM empresa_setor WHERE cd_empresa = ".$_SESSION['cd_empresa'].""; 
        $resulta1 = $conn->query($sql_tipo1);
        if ($resulta1->num_rows > 0)
        {
          echo '<h3>Setores</h3>';
          while ( $row1 = $resulta1->fetch_assoc())
          {
            echo '<div class="d-flex pb-3 pt-3 border-bottom justify-content-between">';
            echo '<div class="mr-3"><i class="mdi mdi-signal-cellular-outline icon-md"></i></div>';
            echo '<div class="font-weight-bold mr-sm-4">';
            echo '<div>'.$row1['titulo_setor'].'</div>';
            echo '<div class="text-muted font-weight-normal mt-1">Sala:'.$row1['local_setor'].', com 15 patrimonios cadastrados. OBS: '.$row1['obs_setor'].'</div>';
            echo '</div>';
            echo '<div><h6 class="font-weight-bold text-info ml-sm-2">R$: 0,00</h6></div>';
            echo '</div>';
            //echo '<button class="expand-button">'.$row2['id_setor'].' | '.$row2['titulo_setor'].' | '.$row2['sala_setor'].' | '.$row2['obs_setor'].'</button>';
          }  
        }
        else
        {
          echo '<h4>Nenhum setor cadastrado</h4>';
        }
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
      }
    }

?>

                <div class="card-body" id="vincular" style="display:none;">
                  <h4 class="card-title">Cadastro de Patrimonio</h4>
                  
                    <p class="card-description">Informações patrimoniais</p>
                    <div class="kt-portlet__body">
                      <div class="row">
                        <div class="col-12 col-md-12">
                          <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                            <form method="POST">
                              <h3 class="kt-portlet__head-title">Dados do equipamento</h3> 
                              <div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">
                                <label for="cd_patrimonio">Código</label>
                                <input name="cd_patrimonio" type="text" maxlength="10" id="cd_patrimonio"  class="aspNetDisabled form-control form-control-sm" disabled="disabled"/>
                               
                                <label for="nserie_patrimonio">Numero de série</label>
                                <input name="nserie_patrimonio" type="text" maxlength="40"   class="aspNetDisabled form-control form-control-sm" />
                             
                                <label for="tipo_patrimonio">Tipo</label>
                                <select name="tipo_patrimonio" id="tipo_patrimonio"  class="aspNetDisabled form-control form-control-sm" placeholder="Estado Civil">
                                  <option selected="selected" value=""></option>
                                  <option value="DP">Desktop</option>
                                  <option value="NK">Notebook</option>
                                  <option value="MR">Monitor</option>
                                  <option value="IA">Impressora</option>
                                  <option value="SE">Smartphone</option>
                                </select>

                                <label for="marca_patrimonio">Marca</label>
                                <input name="marca_patrimonio" type="text" maxlength="40"   class="aspNetDisabled form-control form-control-sm" />
                              
                                <label for="modelo_patrimonio">Modelo</label>
                                <input name="modelo_patrimonio" type="text" maxlength="40"   class="aspNetDisabled form-control form-control-sm" />

                                <label for="versao_patrimonio">Versão</label>
                                <input name="versao_patrimonio" type="text" maxlength="40"   class="aspNetDisabled form-control form-control-sm" />
                              
                                <label for="vcompra_patrimonio">Valor de compra</label>
                                <input name="vcompra_patrimonio" type="tel" maxlength="40"   class="aspNetDisabled form-control form-control-sm" />
                              
                                <label for="obsvcompra_patrimonio">Detalhes de compra</label>
                                <input name="obsvcompra_patrimonio" type="text" class="aspNetDisabled form-control form-control-sm" />
                              
                                <label for="vvenda_patrimonio">Valor de venda</label>
                                <input name="vvenda_patrimonio" type="tel" class="aspNetDisabled form-control form-control-sm" />

                                <label for="obsvvenda_patrimonio">Detalhes de venda</label>
                                <input name="obsvvenda_patrimonio" type="text" class="aspNetDisabled form-control form-control-sm" />
                              
                                <label for="obs_patrimonio">Detalhes do equipamento</label>
                                <input name="obs_patrimonio" type="text" class="aspNetDisabled form-control form-control-sm" />

                                
                                <!--<input type="submit" class="btn btn-success" value="Salvar">-->
                              </div>

                          
                            <h3 class="kt-portlet__head-title">Garantia</h3>
                            <div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">
									            <label for="nfcompra_patrimonio">NF de compra</label>
                              <input name="nfcompra_patrimonio" type="text"  class="aspNetDisabled form-control form-control-sm"/>
								                                                 
									            <label for="dtinicialgarantia_patrimonio">data inicial</label>
                              <input name="dtinicialgarantia_patrimonio" type="date" maxlength="40" class="aspNetDisabled form-control form-control-sm"/>
								                                                   
									            <label for="dtfinalgarantia_patrimonio">Data final</label>
                              <input name="dtfinalgarantia_patrimonio"  type="date" class="aspNetDisabled form-control form-control-sm"/>
								              
									            <label for="obsgarantia_patrimonio">Contato com garantia</label>
                              <input name="obsgarantia_patrimonio" type="text"  class="aspNetDisabled form-control form-control-sm" placeholder="Link, Telefone ou email do prestador ou plataforma de garantia autorizada."/>
                            </div>                           
                            <input type="submit" class="btn btn-success" value="CADASTRAR">
                          
                            </form>
                          </div>
                          <?php
                          
                          if (isset($_POST['nserie_patrimonio']))
                          {
                            
                            $nserie_patrimonio = addslashes($_POST['nserie_patrimonio']);
                            $tipo_patrimonio = addslashes($_POST['tipo_patrimonio']);
                            $marca_patrimonio = addslashes($_POST['marca_patrimonio']);
                            $modelo_patrimonio = addslashes($_POST['modelo_patrimonio']);
                            $versao_patrimonio = addslashes($_POST['versao_patrimonio']);
                            $vcompra_patrimonio = addslashes($_POST['vcompra_patrimonio']);
                            $obsvcompra_patrimonio = addslashes($_POST['obsvcompra_patrimonio']);
                            $vvenda_patrimonio = addslashes($_POST['vvenda_patrimonio']);
                            $obsvvenda_patrimonio = addslashes($_POST['obsvvenda_patrimonio']);
                            $obs_patrimonio = addslashes($_POST['obs_patrimonio']);
                            $nfcompra_patrimonio = addslashes($_POST['nfcompra_patrimonio']);
                            
                            if (!empty($nserie_patrimonio))
                            //if (!empty($pnome_pessoal) && !empty($cpf_pessoal) && !empty($senha_pessoal)) 
                            {
                              $u->conectar(); 
                              if ($u-> $msgErro == "")
                              {
                                //$foto_patrimonio, $nserie_patrimonio, $tipo_patrimonio, $marca_patrimonio, $modelo_patrimonio, $versao_patrimonio, $vcompra_patrimonio, $obsvcompra_patrimonio, $vvenda_patrimonio, $obsvvenda_patrimonio, $obs_patrimonio, $nfgarantia_patrimonio, $dtinicialgarantia_patrimonio, $dtfinalgarantia_patrimonio, $obsgarantia_patrimonio
                                //if($u->cadPatrimonio($foto_patrimonio, $nserie_patrimonio, $tipo_patrimonio, $marca_patrimonio, $modelo_patrimonio, $versao_patrimonio, $vcompra_patrimonio, $obsvcompra_patrimonio, $vvenda_patrimonio, $obsvvenda_patrimonio, $obs_patrimonio, $nfgarantia_patrimonio, $dtinicialgarantia_patrimonio, $dtfinalgarantia_patrimonio, $obsgarantia_patrimonio)) 
                                if($u->cadPatrimonio($nserie_patrimonio, $tipo_patrimonio, $marca_patrimonio, $modelo_patrimonio, $versao_patrimonio, $vcompra_patrimonio, $obsvcompra_patrimonio, $vvenda_patrimonio, $obsvvenda_patrimonio, $obs_patrimonio, $nfcompra_patrimonio)) 
                                
                                {
                                  ?>
                                  <script>window.alert("Cadastro realizado com sucesso!");</script>
                                  <div id="msg-sucesso">Cadastrado com sucesso</div> 
                                  <?php
                                  //echo '<script>location.href="AreaPrivada.php";</script>';
                                }
                                else
                                {
                                  ?>
                                  <div class="msg-erro">Numero de série ja cadastrado!</div>
                                  <?php
                                }
                              }
                              else
                              {
                                ?>
                               
                                <?php
                              }
                            }
                            else
                            {
                              ?>
                              <script>window.alert("Preencha todos os campos!");</script>
                              <div class="msg-erro">Preencha todos os campos!</div>
                              <?php
                            }
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
<?php
    if (isset($_POST['bater_ponto']))
    {
        $cdpessoal_ponto = addslashes($_POST['cdpessoal_ponto']);
        $cdempresa_ponto = addslashes($_POST['cdempresa_ponto']);
        $pais_ponto = addslashes($_POST['pais_ponto']);
        $estado_ponto = addslashes($_POST['estado_ponto']);
        $cidade_ponto = addslashes($_POST['cidade_ponto']);
        $bairro_ponto = addslashes($_POST['bairro_ponto']);
        $data_ponto = addslashes($_POST['data_ponto']);
        $hora_ponto = addslashes($_POST['hora_ponto']);
                            
        $u->conectar(); 
        if ($u-> $msgErro == "")
        {
            //if($u->baterPonto($cdpessoal_ponto, $cdempresa_ponto, $pais_ponto, $estado_ponto, $cidade_ponto, $bairro_ponto, $data_ponto, $hora_ponto)) 
            if($u->baterPonto($cdpessoal_ponto, $cdempresa_ponto, $pais_ponto, $estado_ponto, $cidade_ponto, $bairro_ponto, $data_ponto, $hora_ponto)) 
            {
                ?>
                    <!--<script>window.alert("SUCESSO");</script>-->
                    <script>// Limpa os cookies
                        // Remove as informações do formulário do histórico de navegação
                        history.replaceState({}, document.title, window.location.href.split('?')[0]);
                        // Recarrega a página
                        window.location.reload();
                    </script>
                <?php
                //echo '<script>location.href="AreaPrivada.php";</script>';
            }
            else
            {
                ?>
                    <!--<script>window.alert("FALHA");</script>-->
                <?php
            }
        }
        else
        {
        }
    }
?>