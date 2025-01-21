<?php
class Usuario  
{
    //public function conectar($cnpj_empresa)
//////////////////////////////////////////////////////////////////
//////////////////ESSENCIAIS//////////////////////////////////////
/////////////////////////////////////////////////////////////////
    public function conectar()
    {
        include("../../classes/conn.php");
        global $pdo;
        global $msgErro;
        try {
            $pdo = new PDO("mysql:dbname=".$nome.";host=".$host, $usuario, $senha);
        } catch (PDOException $e) {
            $msgErro = $e->getMessage();
        }
    }
    public function logar($cnpj_empresa, $email_colab, $senha_colab) 
    {
        
        global $pdo;
        $sql = $pdo->prepare("SELECT * FROM tb_colab WHERE email_colab = :emc AND senha_colab = :sn");
        $sql->bindValue(":emc", $email_colab);
        $sql->bindValue(":sn", $senha_colab);
        $sql->execute();
        if($sql->rowCount() > 0)
        {
            $colab = $sql->fetch();
            session_start();
            $_SESSION['cd_colab'] = $colab['cd_colab'];
            $_SESSION['email_colab'] = $colab['email_colab'];
            $_SESSION['senha_colab'] = $colab['senha_colab'];
            $_SESSION['pnome_colab'] = $colab['pnome_colab'];
            $_SESSION['snome_colab'] = $colab['snome_colab'];
            $_SESSION['foto_colab'] = $colab['foto_colab'];
            $_SESSION['cnpj_empresa'] = $cnpj_empresa;
            $sql1 = $pdo->prepare("SELECT * FROM rel_user WHERE cd_colab = ".$_SESSION['cd_colab']."");
            $sql1->execute();

            if($sql1->rowCount() == 0){
                $sql2 = $pdo->prepare("INSERT INTO rel_user(cd_seg, cd_colab, cd_estilo, cd_funcao, cd_empresa) VALUES (1, :cdp, 1, 1, 1)");
                $sql2->bindValue(":cdp", $_SESSION['cd_colab']);
                $sql2->execute();
            }
            if($sql1->rowCount() > 0)
            {
                
                //entrar no sistema(sessão)
                $rel_user = $sql1->fetch();
                //session_start();
                $_SESSION['cd_seg'] = $rel_user['cd_seg'];
                $_SESSION['cd_estilo'] = $rel_user['cd_estilo'];
                 
                $_SESSION['cd_empresa'] = $rel_user['cd_empresa'];
                $_SESSION['cd_funcao'] = $rel_user['cd_funcao'];
                       
           


                $sql3 = $pdo->prepare("SELECT * FROM tb_empresa WHERE cnpj_empresa = ".$_SESSION['cnpj_empresa']."");
                $sql3->execute();
                if($sql3->rowCount() > 0)
                {
                    //entrar no sistema(sessão)
                    $tb_empresa = $sql3->fetch();
                    //session_start();
                    //$_SESSION['logo_empresa'] = $tb_empresa['logo_empresa']; 
                }

                $selectFilial = $pdo->prepare("SELECT * FROM tb_filial WHERE cd_empresa = ".$_SESSION['cd_empresa']."");
                $selectFilial->execute();
                if($selectFilial->rowCount() > 0)
                {
                    //entrar no sistema(sessão)
                    $filial = $selectFilial->fetch();
                    $_SESSION['nfantasia_filial'] = utf8_encode($filial['nfantasia_filial']);
                    $_SESSION['cnpj_filial'] = $filial['cnpj_filial'];
                    $_SESSION['endereco_filial'] = utf8_encode($filial['endereco_filial']);
                    //$_SESSION['saudacoes_filial'] = $filial['saudacoes_filial'];
                    $_SESSION['saudacoes_filial'] = utf8_encode($filial['saudacoes_filial']);
                    //session_start();
                    //$_SESSION['logo_empresa'] = $tb_empresa['logo_empresa']; 
                }

                
                $sql4 = $pdo->prepare("SELECT * FROM tb_funcao WHERE cd_funcao = ".$_SESSION['cd_funcao']."");
                $sql4->execute();
                if($sql4->rowCount() > 0)
                {
                    //entrar no sistema(sessão)
                    $tb_funcao = $sql4->fetch();
                    //session_start();
                   
                    $_SESSION['md_fponto'] = $tb_funcao['md_fponto'];
                    $_SESSION['md_assistencia'] = $tb_funcao['md_assistencia'];
                    $_SESSION['md_cliente'] = $tb_funcao['md_cliente'];
                    $_SESSION['md_fornecedor'] = $tb_funcao['md_fornecedor'];
                    $_SESSION['md_clientefornecedor'] = $tb_funcao['md_clientefornecedor'];
                    $_SESSION['md_patrimonio'] = $tb_funcao['md_patrimonio'];
                    $_SESSION['md_hospedagem'] = $tb_funcao['md_hospedagem'];
                }
                
            }
            else{
                
                //entrar no sistema(sessão)
                //$seg_pessoal_empresa_estilo = $sql1->fetch();
                //session_start();
                //$_SESSION['cd_seg'] = 0;
                //$_SESSION['cd_estilo'] = 0;
                 
                //$_SESSION['cd_empresa'] = 0; 
                //$_SESSION['cd_setor'] = 0; 
            }



            $sql4 = $pdo->prepare("SELECT * FROM tb_estilo WHERE cd_estilo = ".$_SESSION['cd_estilo']."");
            $sql4->execute();

            if($sql4->rowCount() > 0)
            {
                //entrar no sistema(sessão)
                $tb_estilo = $sql4->fetch();
                //session_start();
                $_SESSION['t_sidebar'] = $tb_estilo['t_sidebar'];
                $_SESSION['c_sidebar'] = $tb_estilo['c_sidebar'];

                $_SESSION['t_navbar'] = $tb_estilo['t_navbar'];
                $_SESSION['c_navbar'] = $tb_estilo['c_navbar'];

                $_SESSION['t_font'] = $tb_estilo['t_font'];
                $_SESSION['c_font'] = $tb_estilo['c_font'];

                $_SESSION['c_body'] = $tb_estilo['c_body'];
                $_SESSION['c_card'] = $tb_estilo['c_card'];

                


            }
            //echo '<script>location.href="'.$_SESSION['dominio'].'pages/dashboard/index.php";</script>';
            echo '<script>location.href="../../pages/dashboard/index.php";</script>';
            return true;
        }
        else
        {
            //não foi possivel logar
            return false;
        }
    }
///////////////////////////////////////////////////////////////////////
//////////////////CADASTROS ESSENCIAIS/////////////////////////////////
///////////////////////////////////////////////////////////////////////


    public function cadColab($pnome_colab, $snome_colab, $cpf_colab, $tel_colab, $email_colab, $cd_funcao)
    //public function cadPessoal1($pnome_pessoal, $snome_pessoal, $cpf_pessoal, $rg_pessoal, $cnh_pessoal, $carttrabalho_pessoal, $pis_pessoal, $dtnasc_pessoal, $sexo_pessoal, $ecivil_pessoal, $tel1_pessoal, $obs_tel1_pessoal, $tel2_pessoal, $obs_tel2_pessoal, $email_pessoal, $senha_pessoal)
    {
        global $pdo;
        //verificar se ja está cadastrado
        $selectColab = $pdo->prepare("SELECT cd_colab FROM tb_colab WHERE email_colab = :amc");
        $selectColab->bindValue(":emc", $email_colab);
        $selectColab->execute();
        if($selectColab->rowCount() > 0)
        {session_start();//se ja estiver cadastrado
            $_SESSION['concd_colab'];
            $rowColab = $selectColab->fetch();
            echo "<script>window.alert('Funcionário jà cadastrado para o email ".$email_colab."!');</script>";
            return false; //ja está cadastrado  
        }
        else
        {//não cadastrado, cadastrando agora
            $insertColab = $pdo->prepare("INSERT INTO tb_colab(pnome_colab, snome_colab, tel_colab, email_colab) VALUES (:pnc, :snc, t1c, :emc)");
            $insertColab->bindValue(":pnc", $pnome_colab);
            $insertColab->bindValue(":snc", $snome_colab);
            $insertColab->bindValue(":t1c", $tel_colab);
            $insertColab->bindValue(":emc", $email_colab);
            $insertColab->execute();

            $selectcdColab = $pdo->prepare("SELECT * FROM tb_colab WHERE email_colab = :emc");
            $selectcdColab->bindValue(":emc", $email_colab);
            $selectcdColab->execute();
            if($selectcdColab->rowCount() > 0)
            { session_start();
                echo "<script>window.alert('A senha padrão para novos usuários é: 1');</script>";
                $rowColab = $selectcdColab->fetch();
                $_SESSION['concd_colab'];
                $insertRel = $pdo->prepare("INSERT INTO rel_user(cd_seg, cd_colab, cd_estilo, cd_funcao, cd_empresa, cd_status) VALUES (1, :cdp, 1, :cdf, :cfl, 1)");
                $insertRel->bindValue(":cdp", $rowColab['cd_colab']);
                $insertRel->bindValue(":cdf", $cd_funcao);
                $insertRel->bindValue(":cfl", $_SESSION['cd_empresa']);
                $insertRel->execute();
            }else{
                echo "<script>window.alert('não cadastrado neste momento do código!');</script>";
            }
        }
        //se não estiver cadastrado, vamos fazer o cadastro
        
    }

    public function cadFilial($rsocial_empresa, $nfantasia_empresa, $cnpj_empresa, $iestadual_empresa, $imunicipal_empresa, $dtabertura_empresa, $obs_empresa, $tel1_empresa, $obs_tel1_empresa, $tel2_empresa, $obs_tel2_empresa, $email_empresa)
    {
        global $pdo;
        //verificar se ja está cadastrado
        $sql = $pdo->prepare("SELECT cd_empresa FROM tb_empresa WHERE cnpj_empresa = :cn");
        $sql->bindValue(":cn", $cnpj_empresa);
        $sql->execute();
        
        if($sql->rowCount() > 0)
        {
            return false; //ja está cadastrado
        }
        else
        {//não cadastrado, cadastrando agora
            $sql = $pdo->prepare("INSERT INTO tb_empresa(rsocial_empresa, nfantasia_empresa, cnpj_empresa, iestadual_empresa, imunicipal_empresa, dtabertura_empresa, obs_empresa, tel1_empresa, obs_tel1_empresa, tel2_empresa, obs_tel2_empresa, email_empresa, logo_empresa) VALUES (:rse, :nfe, :cje, :iee, :ime, :dae, :obe, :t1e, :o1e, :t2e, :o2e, :eme, :lge)");
            

            //$logo_empresa, $rsocial_empresa, $nfantasia_empresa, $cnpj_empresa, $iestadual_empresa, $imunicipal_empresa, $dtabertura_empresa,$obs_empresa, $tel1_empresa, $obs_tel1_empresa, $tel2_empresa, $obs_tel2_empresa, $email_empresa, $meta_empresa, $endereco_empresa

            //:lge, :rse, :nfe, :cje, :iee, :ime, :dae, :obe, :t1e, :o1e, :t2e, :o2e, :eme, :mte, :ene

            
            $sql->bindValue(":rse", $rsocial_empresa);
            $sql->bindValue(":nfe", $nfantasia_empresa);
            $sql->bindValue(":cje", $cnpj_empresa);
            $sql->bindValue(":iee", $iestadual_empresa);
            $sql->bindValue(":ime", $imunicipal_empresa);
            $sql->bindValue(":dae", $dtabertura_empresa);
            $sql->bindValue(":obe", $obs_empresa);
            $sql->bindValue(":t1e", $tel1_empresa);
            $sql->bindValue(":o1e", $obs_tel1_empresa);
            $sql->bindValue(":t2e", $tel2_empresa);
            $sql->bindValue(":o2e", $obs_tel2_empresa);
            $sql->bindValue(":eme", $email_empresa);
            $sql->bindValue(":lge", $logo_empresa);
            $sql->execute();
           
            return true;
        }
        //se não estiver cadastrado, vamos fazer o cadastro

    }

    
    public function cadCliente($pnome_cliente, $snome_cliente, $tel_cliente)
    {
        global $pdo;
        //verificar se ja está cadastrado
        $sql = $pdo->prepare("SELECT cd_cliente FROM tb_cliente WHERE tel_cliente = :tlc");
        $sql->bindValue(":tlc", $tel_cliente);
        $sql->execute();
        if($sql->rowCount() > 0)
        {
            //echo '<script>location.href="../../index.php";</script>';
            return false; //ja está cadastrado
        }
        else
        {//não cadastrado, cadastrando agora
            $sql = $pdo->prepare("INSERT INTO tb_cliente(pnome_cliente, snome_cliente, tel_cliente) VALUES (:pnc, :snc, :tlc)");
            $sql->bindValue(":pnc", $pnome_cliente);
            $sql->bindValue(":snc", $snome_cliente);
            $sql->bindValue(":t1c", $tel_cliente);
            $sql->execute();
            return true;
        }
    //se não estiver cadastrado, vamos fazer o cadastro 
    }

///////////////////////////////////////////////////////////////////////
//////////////////EDIÇÃO CADASTRAL/////////////////////////////////////
///////////////////////////////////////////////////////////////////////
    public function editColab($editfoto_colab, $editpnome_colab, $editsnome_colab, $editcpf_colab, $editrg_colab, $editcnh_pessoal, $editcarttrabalho_pessoal, $editpis_pessoal, $editdtnasc_pessoal, $editsexo_pessoal, $editecivil_pessoal, $editobs_pessoal, $edittel1_pessoal, $editobs_tel1_pessoal, $edittel2_pessoal, $editobs_tel2_pessoal, $editemail_pessoal, $editdtentrada_pessoal, $editfuncao_pessoal, $editmeta_colab, $editendereco_colab, $editsenha_colab)
    {
        global $pdo;
        //verificar se ja está cadastrado
        $sql = $pdo->prepare("SELECT * FROM tb_pessoal WHERE cpf_pessoal = :cpf");
        $sql->bindValue(":cpf", $editcpf_pessoal);
        $sql->execute();
        if($sql->rowCount() == 1)
        {

            $sql = $pdo->prepare("UPDATE tb_pessoal SET foto_pessoal = 'testado' WHERE cpf_pessoal = '1'");
            $sql->bindValue(":ftp", $editfoto_pessoal);
            $sql->bindValue(":pnp", $editpnome_pessoal);
            $sql->bindValue(":snp", $editsnome_pessoal);
            $sql->bindValue(":cfp", $editcpf_pessoal);
            $sql->bindValue(":rgp", $editrg_pessoal);
            $sql->bindValue(":cnp", $editcnh_pessoal);
            $sql->bindValue(":ctp", $editcarttrabalho_pessoal);
            $sql->bindValue(":pip", $editpis_pessoal);
            $sql->bindValue(":dnp", $editdtnasc_pessoal);
            $sql->bindValue(":sxp", $editsexo_pessoal);
            $sql->bindValue(":ecp", $editecivil_pessoal);
            $sql->bindValue(":obp", $editobs_pessoal);
            $sql->bindValue(":t1p", $edittel1_pessoal);
            $sql->bindValue(":o1p", $editobs_tel1_pessoal);
            $sql->bindValue(":t2p", $edittel2_pessoal);
            $sql->bindValue(":o2p", $editobs_tel2_pessoal);
            $sql->bindValue(":emp", $editemail_pessoal);
            $sql->bindValue(":dep", $editdtentrada_pessoal);
            $sql->bindValue(":fup", $editfuncao_pessoal);
            $sql->bindValue(":mtp", $editmeta_pessoal);
            $sql->bindValue(":enp", $editendereco_pessoal);
            $sql->bindValue(":sep", $editsenha_pessoal);//md5($senha_morador);
            $sql->execute();

            echo '<script>location.href="../../index.php";</script>';
            return true; //Editando dados
            

            
        }
        else
        {//não cadastrado, cadastrando agora
            //$sql = $pdo->prepare("INSERT INTO tb_pessoal(pnome_pessoal, snome_pessoal, cpf_pessoal, email_pessoal, tel1_pessoal, dtnasc_pessoal, senha_pessoal) VALUES (:pnp, :snp, :cfp, :emp, :t1p, :dnp, :snp)");

            return false;
        }
        //se não estiver cadastrado, vamos fazer o cadastro
    }

    
    
    
    
    


    

    


    //public //function baterPonto($cdpessoal_ponto, $cdempresa_ponto, $pais_ponto, $estado_ponto, $cidade_ponto, $bairro_ponto, $data_ponto, $hora_ponto)
    public function baterPonto($cdpessoal_ponto, $cdempresa_ponto, $pais_ponto, $estado_ponto, $cidade_ponto, $bairro_ponto, $data_ponto, $hora_ponto)
    {
        global $pdo;
        //verificar se ja está cadastrado
        $sql = $pdo->prepare("SELECT * FROM fl_ponto WHERE cdpessoal_ponto = :cpp AND hora_ponto = :hap");
        $sql->bindValue(":cpp", $cdpessoal_ponto);
        $sql->bindValue(":hap", $hora_ponto);
        $sql->execute();
        if($sql->rowCount() > 1)
        {
            echo 'Acabou de bater ponto!';
            return false; //ja está cadastrado
        }
        else
        {//não cadastrado, cadastrando agora
            $sql = $pdo->prepare("INSERT INTO fl_ponto(cdpessoal_ponto, cdempresa_ponto, pais_ponto, estado_ponto, cidade_ponto, bairro_ponto, data_ponto, hora_ponto) VALUES (:cpp, :cep, :psp, :eop, :cip, :bop, :dap, :hap)");
            $sql->bindValue(":cpp", $cdpessoal_ponto); //:cpp, :cep, :psp. :eop, :cip, :bop, :dap, :hap
            $sql->bindValue(":cep", $cdempresa_ponto);
            $sql->bindValue(":psp", $pais_ponto);
            $sql->bindValue(":eop", $estado_ponto);
            $sql->bindValue(":cip", $cidade_ponto);
            $sql->bindValue(":bop", $bairro_ponto);
            $sql->bindValue(":dap", $data_ponto);
            $sql->bindValue(":hap", $hora_ponto);
            $sql->execute();
            return true;
        }
        //se não estiver cadastrado, vamos fazer o cadastro
    }

    


    public function reviseUser2($id_morador, $foto_morador, $tel_morador, $dt_nasc_morador, $cpf_morador,$senha_morador)
    {
        global $pdo;
        $sql = $pdo->prepare("UPDATE moradores SET foto_morador = (:ftm), tel_morador = (:tl), dt_nasc_morador = (:dn), cpf_morador = (:cf), senha_morador = (:sn) WHERE id_morador = (:idm)");
        $sql->bindValue(":idm", $id_morador);
        $sql->bindValue(":ftm", $foto_morador);
        $sql->bindValue(":tl", $tel_morador);
        $sql->bindValue(":dn", $dt_nasc_morador);
        $sql->bindValue(":cf", $cpf_morador);
        $sql->bindValue(":sn", $senha_morador);//md5($senha_morador);
        $sql->execute();
        echo '<script>location.href="AreaPrivada.php";</script>'; 
        //se não estiver cadastrado, vamos fazer o cadastro
    }








    
    //public function cadPatrimonio($foto_patrimonio, $nserie_patrimonio, $tipo_patrimonio, $marca_patrimonio, $modelo_patrimonio, $versao_patrimonio, $vcompra_patrimonio, $obsvcompra_patrimonio, $vvenda_patrimonio, $obsvvenda_patrimonio, $obs_patrimonio, $nfgarantia_patrimonio, $dtinicialgarantia_patrimonio, $dtfinalgarantia_patrimonio, $obsgarantia_patrimonio)
    public function cadPatrimonio($nserie_patrimonio, $tipo_patrimonio, $marca_patrimonio, $modelo_patrimonio, $versao_patrimonio, $vcompra_patrimonio, $obsvcompra_patrimonio, $vvenda_patrimonio, $obsvvenda_patrimonio, $obs_patrimonio, $nfcompra_patrimonio)
    
    {
        global $pdo;
        //verificar se ja está cadastrado
        $sql = $pdo->prepare("SELECT cd_patrimonio FROM tb_patrimonio WHERE nserie_patrimonio = :ns");
        $sql->bindValue(":ns", $nserie_patrimonio);
        $sql->execute();
        if($sql->rowCount() > 0)
        {
            echo 'Ja está cadastrado!';
            //return false; //ja está cadastrado
        }
        else
        {//não cadastrado, cadastrando agora
            $sql = $pdo->prepare("INSERT INTO tb_patrimonio(nserie_patrimonio, tipo_patrimonio, marca_patrimonio, modelo_patrimonio, versao_patrimonio, vcompra_patrimonio, obsvcompra_patrimonio, vvenda_patrimonio, obsvvenda_patrimonio, obs_patrimonio, nfcompra_patrimonio, status_patrimonio) VALUES (:nsp, :tpp, :mcp, :mdp, :vsp, :vcp, :ocp, :vvp, :ovp, :obp, :nfp, :stp)");
            
            $sql->bindValue(":nsp", $nserie_patrimonio);
            $sql->bindValue(":tpp", $tipo_patrimonio);
            $sql->bindValue(":mcp", $marca_patrimonio);
            $sql->bindValue(":mdp", $modelo_patrimonio);
            $sql->bindValue(":vsp", $versao_patrimonio);
            $sql->bindValue(":vcp", $vcompra_patrimonio);
            $sql->bindValue(":ocp", $obsvcompra_patrimonio);
            $sql->bindValue(":vvp", $vvenda_patrimonio);
            $sql->bindValue(":ovp", $obsvvenda_patrimonio);
            $sql->bindValue(":obp", $obs_patrimonio);
            $sql->bindValue(":nfp", $nfcompra_patrimonio);
            
            $sql->bindValue(":stp", 0);
            $sql->execute();
            return true;
        }
        //se não estiver cadastrado, vamos fazer o cadastro
    }

    
    public function vincule_dispositivo_casa($id_casa, $senha_casa, $mac_dispositivo){
        global $pdo;
        //verificar se ja está cadastrado
        $sql = $pdo->prepare("SELECT id_casa FROM casas WHERE id_casa = :idc");
        $sql->bindValue(":idc", $id_casa);
        $sql->execute();
        if($sql->rowCount() > 0){//Casa encontrada
            echo 'Casa Encontrada!    ';          
            $sql = $pdo->prepare("SELECT * FROM casas WHERE id_casa = :idc AND senha_casa = :snc");
            $sql->bindValue(":idc", $id_casa);
            $sql->bindValue(":snc", $senha_casa);//Verificar se status é igual
            $sql->execute();
            if($sql->rowCount() > 0){//vinculo de dispositivo permitido
                echo 'Vinculo de dispositivo permitido!    ';
                $sql = $pdo->prepare("UPDATE dispositivos SET id_casa = :idc WHERE mac_dispositivo = :mds");
                $sql->bindValue(":idc", $id_casa);
                $sql->bindValue(":mds", $mac_dispositivo);//Verificar se status é igual
                $sql->execute();
                return true;
            }else{
                echo 'Senha da casa errada';
            }
        }else{
            echo 'Casa não encontrada!  ';
        }
    }
    public function ver_dispositivo_casa($id_casa){
        global $pdo;
        //buscar casas vinculadas ao usuário logado
        $sql = $pdo->prepare("SELECT * FROM dispositivos WHERE id_casa = :idc");
        $sql->bindValue(":idc", $id_casa);
        $sql->execute();
        $casa = $sql->fetch();
        
        //$_SESSION['id_casa'] = $casa['id_casa'];
        //$_SESSION['fnome_morador'] = $casa['fnome_morador'];
        //$_SESSION['snome_morador'] = $casa['snome_morador'];
    }

    public function cadSetor($empresa_setor, $titulo_setor, $sala_setor, $obs_setor)
    {
        global $pdo;
        //verificar se ja está cadastrado
        $sql = $pdo->prepare("SELECT id_setor FROM setores WHERE sala_setor = :sst  AND empresa_setor = :est");
        $sql->bindValue(":est", $empresa_setor);
        $sql->bindValue(":sst", $sala_setor);
        $sql->execute();
        
        if($sql->rowCount() > 0)
        {
            ?>
                <div class="msg-erro">CNPJ já cadastrado!</div>
            <?php
            return false; //ja está cadastrado
        }
        else
        {//não cadastrado, cadastrando agora
            $sql = $pdo->prepare("INSERT INTO setores(id_empresa, titulo_setor, sala_setor, obs_setor) VALUES (:est, :tts, :sst, :obs)");
            
            $sql->bindValue(":est", $empresa_setor);
            $sql->bindValue(":tts", $titulo_setor);
            $sql->bindValue(":sst", $sala_setor);
            $sql->bindValue(":obs", $obs_setor);
            $sql->execute();
            //echo '<script>location.href="AreaPrivada.php";</script>';
            return true;
        }
        //se não estiver cadastrado, vamos fazer o cadastro

    }


    public function cadEmpresaSetorPessoal($id_empresa, $id_setor, $id_pessoal)
    {
        global $pdo;
        //verificar se ja está cadastrado
        $sql = $pdo->prepare("SELECT id_setor FROM empresa_pessoal WHERE id_empresa = :ide AND id_setor = :ids AND id_pessoal = :idp");
        $sql->bindValue(":ide", $id_empresa);
        $sql->bindValue(":ids", $id_setor);
        $sql->bindValue(":idp", $id_pessoal);
        $sql->execute();
        
        if($sql->rowCount() > 0)
        {
            return false; //ja está cadastrado
        }
        else
        {//não cadastrado, cadastrando agora
            $sql = $pdo->prepare("INSERT INTO empresa_pessoal(id_empresa, id_setor, id_pessoal) VALUES (:ide, :ids, :idp)");
            $sql->bindValue(":ide", $id_empresa);
            $sql->bindValue(":ids", $id_setor);
            $sql->bindValue(":idp", $id_pessoal);
            $sql->execute();
            //echo '<script>location.href="AreaPrivada.php";</script>';
            return true;
        }
        //se não estiver cadastrado, vamos fazer o cadastro

    }
    public function movimentoPatrimonio($cd_pessoal, $nserie_patrimonio, $cd_empresa, $data_movimento, $hora_movimento)
    //public function cadPessoal1($pnome_pessoal, $snome_pessoal, $cpf_pessoal, $rg_pessoal, $cnh_pessoal, $carttrabalho_pessoal, $pis_pessoal, $dtnasc_pessoal, $sexo_pessoal, $ecivil_pessoal, $tel1_pessoal, $obs_tel1_pessoal, $tel2_pessoal, $obs_tel2_pessoal, $email_pessoal, $senha_pessoal)
    {
        global $pdo;
        //não cadastrado, cadastrando agora
        //$sql = $pdo->prepare("INSERT INTO tb_pessoal(pnome_pessoal, snome_pessoal, cpf_pessoal, rg_pessoal, cnh_pessoal, carttrabalho_pessoal, pis_pessoal, dtnasc_pessoal, sexo_pessoal, ecivil_pessoal, tel1_pessoal, obs_tel1_pessoal, tel2_pessoal, obs_tel2_pessoal, email_pessoal, dtentrada_pessoal, funcao_pessoal, meta_pessoal, endereco_pessoal, foto_pessoal, senha_pessoal) VALUES (:pnp, :snp, :cfp, :rgp, :cnp, :ctp, :pip, :dnp, :sxp, :t1p, :o1p, :t2p, :o2p, :emp, :dep, :fup, :mtp, :enp, :ftp, :snp)");
        $sql = $pdo->prepare("INSERT INTO movimento_patrimonio(cd_pessoal, nserie_patrimonio, cd_empresa, data_movimento, hora_movimento) VALUES (:cdp, :nsp, :cde, :dtm, :hrm)");
        //cd_pessoal, nserie_patrimonio, cd_empresa, data_movimento, hora_movimento
        //:cdp, :nsp, :cde, :dtm, :hrm
        $sql->bindValue(":cdp", $cd_pessoal);
        $sql->bindValue(":nsp", $nserie_patrimonio);
        $sql->bindValue(":cde", $cd_empresa);
        $sql->bindValue(":dtm", $data_movimento);
        $sql->bindValue(":hrm", $hora_movimento);
        
        $sql->execute();
        
        return true;
            
            
    }
        //se não estiver cadastrado, vamos fazer o cadastro
        
}

function loggout(){
    session_start();
    $_SESSION['cd_pessoal'] = '';
    session_destroy();
    echo '<script>location.href="'.$_SESSION['dominio'].'pages/samples/login.php";</script>';
    echo "<script>window.close();</script>";
}


?>

