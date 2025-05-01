<div class="card-body" id="cadastro" style="display:none;">
                  <h4 class="card-title">Cadastro de pessoal</h4>
                    <p class="card-description">Informações pessoais</p>
                    <div class="kt-portlet__body">
                      <div class="row">
                        <div class="col-12 col-md-12">
                          <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                            <form method="POST">
                              <h3 class="kt-portlet__head-title">Dados pessoais</h3> 
                              <div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">
                                <label for="cd_pessoal">Código</label>
                                <input name="cd_pessoal" type="text" maxlength="10" id="cd_pessoal"  class="aspNetDisabled form-control form-control-sm" disabled="disabled"/>                             
                                <!--
                                <div class="kt-portlet__body">
                                  <div class="row">
                                    <div class="col-12 col-md-12">
                                      <div class="form-group form-group-sm">
                                        <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                                          <h3 class="kt-portlet__head-title">FOTO</h3>
                                          <div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">
                                            <label>File upload</label>
                                            <input type="file" name="img[]" class="file-upload-default">
                                            <div class="input-group col-xs-12">
                                              <input type="text" class="form-control file-upload-info"  placeholder="Upload Image"disabled/>
                                              <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                              </span>
                                            </div>
                                          </div>
                                          <a id="ContentPlaceHolder1_iAcCidade_iLkBtActionPosSelect" href="javascript:__doPostBack(&#39;ctl00$ContentPlaceHolder1$iAcCidade$iLkBtActionPosSelect&#39;,&#39;&#39;)"></a>
                                        </div>  
      						  		              </div>
                                    </div>
                                  </div>
                                </div>
                                -->
                                
                                <label for="foto_pessoal">Foto</label>
                                <input name="foto_pessoal" type="text" maxlength="500" class="aspNetDisabled form-control form-control-sm" placeholder="Cole o link da sua foto"/>

                                
                                <label for="pnome_pessoal">Nome</label>
                                <input name="pnome_pessoal" type="text" id="pnome_pessoal" maxlength="40"   class="aspNetDisabled form-control form-control-sm" />
                              
                             
                                <label for="snome_pessoal">sobrenome</label>
                                <input name="snome_pessoal" type="text" id="snome_pessoal" maxlength="40"   class="aspNetDisabled form-control form-control-sm" />
                              
                                <label for="cpf_pessoal">CPF</label>
                                <input name="cpf_pessoal" type="tel"  oninput="cpf(this)" class="aspNetDisabled form-control form-control-sm" />

                                <label for="rg_pessoal">RG</label>
                                <input name="rg_pessoal" type="tel"   oninput="rg(this)" class="aspNetDisabled form-control form-control-sm" />
                              
                                <label for="cnh_pessoal">CNH</label>
                                <input name="cnh_pessoal" type="tel" value="000" oninput="cnh(this)" id="cnh_pessoal"  class="aspNetDisabled form-control form-control-sm" />

                                <label for="pis_pessoal">PIS</label>
                                <input name="pis_pessoal" type="tel" maxlength="10" oninput="pis(this)" id="pis_pessoal"  class="aspNetDisabled form-control form-control-sm" />

                                <label for="carttrabalho_pessoal">Cart. de Tragbalho</label>
                                <input name="carttrabalho_pessoal" type="text"  oninput="cartTrabalho(this)" id="carttrabalho_pessoal"  class="aspNetDisabled form-control form-control-sm" placeholder="Carteira de Trabalho" />
                                
                                <label for="dtnasc_pessoal">Nascimento</label>
                                <input name="dtnasc_pessoal" type="date" id="dtnasc_pessoal"  class="aspNetDisabled form-control" data-start="date-picker" data-cco-placeholder="Admissão" placeholder="  /  /    "  /><!--required="" data-required="true"-->
  
                                <label for="sexo_pessoal">Sexo</label>
                                <select name="sexo_pessoal" id="sexo_pessoal"  class="aspNetDisabled form-control form-control-sm" placeholder="Sexo">
                                  <option selected="selected" value=""></option>
                                  <option value="M">Masculino</option>
                                	<option value="F">Feminino</option>
                                </select>
                                <label for="ecivil_pessoal">Estado Civil</label>
                                <select name="ecivil_pessoal" id="ecivil_pessoal"  class="aspNetDisabled form-control form-control-sm" placeholder="Estado Civil">
                                  <option selected="selected" value=""></option>
                                  <option value="S">Solteiro</option>
                                  <option value="C">Casado</option>
                                  <option value="V">Viúvo</option>
                                  <option value="D">Divorciado</option>
                                </select>
  
                                <label for="obs_pessoal">Observações</label>
                                <input name="obs_pessoal" type="text" id="obs_pessoal"  class="aspNetDisabled form-control"/><!--required="" data-required="true"-->
  
                                
                                <!--<input type="submit" class="btn btn-success" value="Salvar">-->
                              </div>

                          
                            <h3 class="kt-portlet__head-title">Contatos</h3>
                            <div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">
									            <label for="tel1_pessoal">Telefone 1</label>
                              <input name="tel1_pessoal" type="tel" value="+" id="tel1_pessoal" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" data-cco-placeholder="Telefone 1" placeholder="(00)0000-0000" onkeyup="WebChoice.Util.formataTelefone(this, event);" MinLength="12" />
								                                                 
									            <label for="obs_tel1_pessoal">Complemento do Telefone 1</label>
                              <input name="obs_tel1_pessoal" type="text" maxlength="40" id="obs_tel1_pessoal"  class="aspNetDisabled form-control form-control-sm" placeholder="Complemento" />
								                                                   
									            <label for="tel2_pessoal">Telefone 2</label>
                              <input name="tel2_pessoal" type="tel" id="tel2_pessoal"  oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" data-cco-placeholder="Telefone 2" placeholder="(00)0000-0000" onkeyup="WebChoice.Util.formataTelefone(this, event);" MinLength="12" />
								                  
									            <label for="obs_tel2_pessoal">Complemento do Telefone 2</label>
                              <input name="obs_tel2_pessoal" type="text" maxlength="40" id="obs_tel2_pessoal"  class="aspNetDisabled form-control form-control-sm" placeholder="Complemento" />
								                  
									            <label for="email_pessoal">E-Mail</label>
                              <input name="email_pessoal" maxlength="80" id="email_pessoal"  class="aspNetDisabled form-control form-control-sm" data-cco-placeholder="E-Mail" placeholder="email@dominio.com.br" type="email" />

                            </div>
                          
                          
                            <h3 class="kt-portlet__head-title">Para empresa</h3>
                            <div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">
                              <label for="dtentrada_pessoal">Admissão</label>
                              <input name="dtentrada_pessoal" type="date" id="dtentrada_pessoal"  class="aspNetDisabled form-control" data-start="date-picker" data-cco-placeholder="Admissão" placeholder="  /  /    "  /><!--required="" data-required="true"-->
  						    	          
                              <label for="funcao_pessoal">Função</label>
                              <select name="funcao_pessoal" id="funcao_pessoal"  class="aspNetDisabled form-control form-control-sm" placeholder="Tipo">
				                        <option selected="selected" value=""></option>
                          		  <option value="C">Consultor</option>
                            		<option value="T">T&#233;cnico</option>
                            		<option value="CT">Consultor e T&#233;cnico</option>
                              </select>
                            
                            <label for="meta_pessoal">Meta de faturamento mensal</label>
                            <input name="meta_pessoal" type="tel" oninput="real(this)" id="meta_pessoal"  class="aspNetDisabled form-control"/>
                            </div>


                           
                              <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                              <script>
                                $(document).ready(function() {
                                  $('#cep_pessoal').blur(function() {
                                    var cep_pessoal = $(this).val().replace(/\D/g, '');
                                    if (cep_pessoal != "") {
                                      var url = "https://viacep.com.br/ws/" + cep_pessoal + "/json/";
                                      $.getJSON(url, function(dados) {
                                        if (!("erro" in dados)) {
                                          $('#endereco_pessoal').val(dados.logradouro);
                                          $('#bairro_pessoal').val(dados.bairro);
                                          $('#cidade_pessoal').val(dados.localidade);
                                          $('#uf_pessoal').val(dados.uf);
                                        } else {
                                          alert("CEP não encontrado.");
                                        }
                                      });
                                    }
                                  });
                                });
                              </script>
                              <h3 class="kt-portlet__head-title">Endereço</h3>
                              <div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">
                              <label for="cep_pessoal">CEP</label>
                              <input name="cep_pessoal" type="tel" maxlength="10" oninput="cep(this)" id="cep_pessoal"  class="aspNetDisabled form-control form-control-sm"/>
                              <label for="logradouro_pessoal">Logradouro</label>
                              <select name="logradouro_pessoal" id="logradouro_pessoal"  class="aspNetDisabled form-control form-control-sm" placeholder="Logradouro">
                                <option selected="selected" value=""></option>
                                <option value="Alameda">Alameda</option>
                                <option value="Avenida">Avenida</option>
                                <option value="Beco">Beco</option>
                                <option value="Estrada">Estrada</option>
                                <option value="Praça">Pra&#231;a</option>
                                <option value="Rodovia">Rodovia</option>
                                <option value="Rua">Rua</option>
                                <option value="Travessa">Travessa</option>
                                <option value="Outros">Outros</option>
                              </select>
                              <label for="endereco_pessoal">Endereço</label>
                              <input name="endereco_pessoal" type="text" maxlength="60" id="endereco_pessoal"  class="aspNetDisabled form-control form-control-sm" placeholder="Endereço" MinLength="5" />
                              <label for="complemento_pessoal">Complemento</label>
                              <input name="complemento_pessoal" type="text" maxlength="20" id="complemento_pessoal"  class="aspNetDisabled form-control form-control-sm" placeholder="Complemento" MinLength="2" />

                              <label for="bairro_pessoal">Bairro</label>
                              <input name="bairro_pessoal" type="text" maxlength="30" id="bairro_pessoal"  class="aspNetDisabled form-control form-control-sm" placeholder="Bairro" MinLength="3" />
                              <label for="uf_pessoal">UF</label>
                              <input name="uf_pessoal" type="text" id="uf_pessoal"  class="aspNetDisabled form-control form-control-sm" placeholder="Cidade" onkeydown="change_ContentPlaceHolder1_iAcCidade()" data-bv-callback="true" data-bv-callback-message="Valor selecionado de forma incorreta" data-bv-callback-callback="acBootstrapValidadorCheck_ContentPlaceHolder1_iAcCidade" />
                              <label for="cidade_pessoal">Cidade</label>
                              <input name="cidade_pessoal" type="text" id="cidade_pessoal"  class="aspNetDisabled form-control form-control-sm" placeholder="Cidade" onkeydown="change_ContentPlaceHolder1_iAcCidade()" data-bv-callback="true" data-bv-callback-message="Valor selecionado de forma incorreta" data-bv-callback-callback="acBootstrapValidadorCheck_ContentPlaceHolder1_iAcCidade" />
                            </div>
                            
                            
                            <input type="submit" class="btn btn-success" value="SALVAR">
                          
                            </form>
                          </div>
                          <?php
                          
                          if (isset($_POST['cpf_pessoal']))
                          {
                            $foto_pessoal = addslashes($_POST['foto_pessoal']);
                            $pnome_pessoal = addslashes($_POST['pnome_pessoal']);
                            $snome_pessoal = addslashes($_POST['snome_pessoal']);
                            $cpf_pessoal = addslashes($_POST['cpf_pessoal']);
                            $rg_pessoal = addslashes($_POST['rg_pessoal']);
                            $cnh_pessoal = addslashes($_POST['cnh_pessoal']);
                            $carttrabalho_pessoal = addslashes($_POST['carttrabalho_pessoal']);
                            $pis_pessoal = addslashes($_POST['pis_pessoal']);
                            $dtnasc_pessoal = addslashes($_POST['dtnasc_pessoal']);
                            $sexo_pessoal = addslashes($_POST['sexo_pessoal']);
                            $ecivil_pessoal = addslashes($_POST['ecivil_pessoal']);
                            $obs_pessoal = addslashes($_POST['obs_pessoal']);
                            $tel1_pessoal = addslashes($_POST['tel1_pessoal']);
                            $obs_tel1_pessoal = addslashes($_POST['obs_tel1_pessoal']);
                            $tel2_pessoal = addslashes($_POST['tel2_pessoal']);
                            $obs_tel2_pessoal = addslashes($_POST['obs_tel2_pessoal']);
                            $email_pessoal = addslashes($_POST['email_pessoal']);
                            $dtentrada_pessoal = addslashes($_POST['dtentrada_pessoal']);
                            $funcao_pessoal = addslashes($_POST['funcao_pessoal']);
                            $meta_pessoal = addslashes($_POST['meta_pessoal']);

                            $endereco_pessoal = addslashes($_POST['endereco_pessoal']);
                            
                            $senha_pessoal = "1";
                            $confSenha_pessoal = "1";
                            //$confSenha_pessoal = addslashes($_POST['confSenha_pessoal']);
                            //verificar se tem algum campo vazio
                            
                            if (!empty($cpf_pessoal))
                            //if (!empty($pnome_pessoal) && !empty($cpf_pessoal) && !empty($senha_pessoal)) 
                            {
                              $u->conectar(); 
                              if ($u-> $msgErro == "")
                              {
                                if($senha_pessoal == $confSenha_pessoal)
                                {
                                  //$pnome_pessoal, $snome_pessoal, $cpf_pessoal, $rg_pessoal, $cnh_pessoal, $carttrabalho_pessoal, $pis_pessoal, $dtnasc_pessoal, $sexo_pessoal, $tel1_pessoal, $obs_tel1_pessoal, $tel2_pessoal, $obs_tel2_pessoal, $email_pessoal, $senha_pessoal

                                  //dtentrada_pessoal, funcao_pessoal, meta_pessoal,
                                  //endereco_pessoal, foto_pessoal

                                  if($u->cadPessoal($foto_pessoal, $pnome_pessoal, $snome_pessoal, $cpf_pessoal, $rg_pessoal, $cnh_pessoal, $carttrabalho_pessoal, $pis_pessoal, $dtnasc_pessoal, $sexo_pessoal, $ecivil_pessoal, $obs_pessoal, $tel1_pessoal, $obs_tel1_pessoal, $tel2_pessoal, $obs_tel2_pessoal, $email_pessoal, $dtentrada_pessoal, $funcao_pessoal, $meta_pessoal, $endereco_pessoal, $senha_pessoal)) 
                                  //if($u->cadPessoal1($pnome_pessoal, $snome_pessoal, $cpf_pessoal, $rg_pessoal, $cnh_pessoal, $carttrabalho_pessoal, $pis_pessoal, $dtnasc_pessoal, $sexo_pessoal, $tel1_pessoal, $obs_tel1_pessoal, $tel2_pessoal, $obs_tel2_pessoal, $email_pessoal, $senha_pessoal)) 
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
                                    <script>window.alert("Edição de dados cadastrais!");</script>
                                    <div class="msg-erro">Edição de dados cadastrais!</div>
                                    <?php
                                  }
                                }
                                else
                                {
                                  ?>
                                  <div class="msg-erro">Confirmação de senha não correspondem!</div>
                                  <?php
                                }
                              }
                              else
                              {
                                ?>
                                <div class="msg-erro">
                                  <?php echo "Erro: ".$u->msgErro;?>
                                </div>
                                <?php
                              }
                            }
                            else
                            {
                              ?>
                              <script>window.alert("CPF em branco!");</script>
                              <div class="msg-erro">CPF em branco!!</div>
                              <?php
                            }
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>