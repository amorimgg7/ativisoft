

                        <input type="text" id="input1" value="Valor inicial">
                          <input type="text" id="input2" value="">

                          <button name="buscarr" onclick="atualizarInput()">Atualizar</button>

                          <script>
                            function atualizarInput() {
                              // Pegar o valor do primeiro input
                              const valorInput1 = document.getElementById("editcpf_pessoal").value;

                              // Atualizar o valor do segundo input
                              document.getElementById("input2").value = valorInput1;
                              document.getElementById("concpf_pessoal").value = valorInput1;
                            }
                          </script>


<div class="card">
    <div class="card-body" id="edita">
        <h4 class="card-title">Edição de cadastro</h4>
        <p class="card-description">Informações pessoais</p>
        <div class="kt-portlet__body">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                        <form method="POST">
                            <h3 class="kt-portlet__head-title">Dados pessoais</h3>
                            <div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">
                                <label for="editcd_pessoal">Código</label>
                                <input name="editcd_pessoal" type="text" id="editcd_pessoal" maxlength="10"   class="aspNetDisabled form-control form-control-sm" disabled="disabled"/>
                                <label for="editfoto_pessoal">Foto</label>
                                <input name="editfoto_pessoal" type="text" id="editfoto_pessoal" maxlength="500" class="aspNetDisabled form-control form-control-sm" placeholder="Cole o link da sua foto"/>
                                <label for="editpnome_pessoal">Nome</label>
                                <input name="editpnome_pessoal" type="text" id="editpnome_pessoal" maxlength="40"  class="aspNetDisabled form-control form-control-sm" />
                                <label for="editsnome_pessoal">sobrenome</label>
                                <input name="editsnome_pessoal" type="text" id="editsnome_pessoal" maxlength="40"   class="aspNetDisabled form-control form-control-sm" />
                                <label for="editcpf_pessoal">CPF</label>
                                <input name="editcpf_pessoal" type="tel" id="editcpf_pessoal" maxlength="10"  oninput="cpf(this)" class="aspNetDisabled form-control form-control-sm" disabled="disabled"/>
                                <label for="editrg_pessoal">RG</label>
                                <input name="editrg_pessoal" type="tel" id="editrg_pessoal" maxlength="10" oninput="rg(this)" class="aspNetDisabled form-control form-control-sm" />                       
                                <label for="cnh_pessoal">CNH</label>
                                <input name="editcnh_pessoal" type="tel" maxlength="10" oninput="cnh(this)" id="editcnh_pessoal"  class="aspNetDisabled form-control form-control-sm" />      
                                <label for="editcarttrabalho_pessoal">Cart. de Tragbalho</label>
                                <input name="editcarttrabalho_pessoal" type="tel" maxlength="15" oninput="cartTrabalho(this)" id="editcarttrabalho_pessoal"  class="aspNetDisabled form-control form-control-sm" placeholder="Carteira de Trabalho" onkeyup="WebChoice.Util.permiteSomente(this, &#39;0123456789./-&#39;, event);" />
                                <label for="editpis_pessoal">PIS</label>
                                <input name="editpis_pessoal" type="tel" maxlength="10" oninput="pis(this)" id="editpis_pessoal"  class="aspNetDisabled form-control form-control-sm" />
                                <label for="editdtnasc_pessoal">Nascimento</label>
                                <input name="editdtnasc_pessoal" type="text" id="editdtnasc_pessoal"  class="aspNetDisabled form-control" data-start="date-picker" data-cco-placeholder="Admissão" placeholder="  /  /    "  disabled="disabled"/><!--required="" data-required="true"-->
                                <label for="editsexo_pessoal">Sexo</label>
                                <select name="editsexo_pessoal" id="editsexo_pessoal"   class="aspNetDisabled form-control form-control-sm" placeholder="Sexo">
                                    <option selected="selected" value=""></option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Feminino</option>
                                    <option value="O">Outros</option>
                                </select>
                                <label for="editecivil_pessoal">Estado Civil</label>
                                <select name="editecivil_pessoal" id="editecivil_pessoal"   class="aspNetDisabled form-control form-control-sm" placeholder="Estado Civil">
                                    <option selected="selected" value=""></option>
                                    <option value="S">Solteiro</option>
                                    <option value="C">Casado</option>
                                    <option value="V">Viúvo</option>
                                    <option value="D">Divorciado</option>
                                </select>
                                <label for="editobs_pessoal">Observações</label>
                                <input name="edit" type="text" id="editobs_pessoal" value="'.$row['obs_pessoal'].'" class="aspNetDisabled form-control"/><!--required="" data-required="true"-->
                            </div>
                            <h3 class="kt-portlet__head-title">Contatos</h3>
                            <div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">
                                <label for="edittel1_pessoal">Telefone 1</label>
                                <input name="edittel1_pessoal" type="tel" id="edittel1_pessoal" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" data-cco-placeholder="Telefone 1" placeholder="(00)0000-0000" onkeyup="WebChoice.Util.formataTelefone(this, event);" MinLength="12" />
                                <label for="editobs_tel1_pessoal">Complemento do Telefone 1</label>
                                <input name="editobs_tel1_pessoal" type="text" maxlength="40" id="editobs_tel1_pessoal" class="aspNetDisabled form-control form-control-sm" placeholder="Complemento" />
                                <label for="edittel2_pessoal">Telefone 2</label>
                                <input name="edittel2_pessoal" type="tel" id="edittel2_pessoal" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" data-cco-placeholder="Telefone 2" placeholder="(00)0000-0000" onkeyup="WebChoice.Util.formataTelefone(this, event);" MinLength="12" />
                                <label for="editobs_tel2_pessoal">Complemento do Telefone 2</label>
                                <input name="editobs_tel2_pessoal" type="text" maxlength="40" id="editobs_tel2_pessoal" class="aspNetDisabled form-control form-control-sm" placeholder="Complemento" />
                                <label for="editemail_pessoal">E-Mail</label>
                                <input name="editemail_pessoal" maxlength="80" id="editemail_pessoal" class="aspNetDisabled form-control form-control-sm" data-cco-placeholder="E-Mail" placeholder="email@dominio.com.br" type="email" />
                            </div>
                            <h3 class="kt-portlet__head-title">Para empresa</h3>
                            <div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">
                                <label for="editdtentrada_pessoal">Admissão</label>
                                <input name="editdtentrada_pessoal" type="date" id="editdtentrada_pessoal" class="aspNetDisabled form-control" data-start="date-picker" data-cco-placeholder="Admissão" placeholder="  /  /    "  /><!--required="" data-required="true"-->
                                <label for="editfuncao_pessoal">Função</label>
                                <select name="editfuncao_pessoal" id="editfuncao_pessoal" class="aspNetDisabled form-control form-control-sm" placeholder="Tipo">
                                    <option selected="selected"></option>
                                    <option value="C">Consultor</option>
                                    <option value="T">T&#233;cnico</option>
                                    <option value="CT">Consultor e T&#233;cnico</option>
                                </select>
                                <label for="editmeta_pessoal">Meta de faturamento mensal</label>
                                <input name="editmeta_pessoal" type="tel" id="editmeta_pessoal" class="aspNetDisabled form-control"/>
                            </div>
                            <h3 class="kt-portlet__head-title">Endereço</h3>
                            <div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">
                                <label for="cep_pessoal">CEP</label>
                                <input name="cep_pessoal" type="tel" maxlength="10" id="cep_pessoal"  class="aspNetDisabled form-control form-control-sm"/>
                                <label for="logradouro_pessoal">Logradouro</label>
                                <select name="logradouro_pessoal" id="logradouro_pessoal" class="aspNetDisabled form-control form-control-sm" placeholder="Logradouro">
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
                </div>
            </div>
        </div>
    </div>
</div>


<?php
/*
if (isset($_POST['buscarr']))
{
    echo '<script>window.alert("CPF não preenchido[138]");</script>';
    $editfoto_pessoal = addslashes($_POST['foto_pessoal']);
    $u->conectar(); 
    if ($u-> $msgErro == "")
    {
        //$pnome_pessoal, $snome_pessoal, $cpf_pessoal, $rg_pessoal, $cnh_pessoal, $carttrabalho_pessoal, $pis_pessoal, $dtnasc_pessoal, $sexo_pessoal, $tel1_pessoal, $obs_tel1_pessoal, $tel2_pessoal, $obs_tel2_pessoal, $email_pessoal, $senha_pessoal
        //dtentrada_pessoal, funcao_pessoal, meta_pessoal,
        //endereco_pessoal, foto_pessoal

        if($u->editPessoal($editfoto_pessoal, $editpnome_pessoal, $editsnome_pessoal, $editcpf_pessoal, $editrg_pessoal, $editcnh_pessoal, $editcarttrabalho_pessoal, $editpis_pessoal, $editdtnasc_pessoal, $editsexo_pessoal, $editecivil_pessoal, $editobs_pessoal, $edittel1_pessoal, $editobs_tel1_pessoal, $edittel2_pessoal, $editobs_tel2_pessoal, $editemail_pessoal, $editdtentrada_pessoal, $editfuncao_pessoal, $editmeta_pessoal, $editendereco_pessoal, $editsenha_pessoal)) 
        //if($u->cadPessoal1($pnome_pessoal, $snome_pessoal, $cpf_pessoal, $rg_pessoal, $cnh_pessoal, $carttrabalho_pessoal, $pis_pessoal, $dtnasc_pessoal, $sexo_pessoal, $tel1_pessoal, $obs_tel1_pessoal, $tel2_pessoal, $obs_tel2_pessoal, $email_pessoal, $senha_pessoal)) 
        {
            ?>
                <!--<script>window.alert("EDITADO COM SUCESSO!");</script>-->
            <?php
            echo '<script>location.href="AreaPrivada.php";</script>';
        }
        else
        {
            ?>
                <!--<script>window.alert("EDIÇÃO FALHA!");</script>
                <div class="msg-erro">Edição de dados cadastrais!</div>-->
            <?php
        }
    }
    else
    {
        ?>
            <!--<div class="msg-erro">
            <?// echo "Erro: ".$u->msgErro;?>
            </div>-->
        <?php
    }
}
else
{
    echo '<script>window.alert("CPF não preenchido[174]");</script>';                    
}
                  
*/
?>


