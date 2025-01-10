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
    public function logar($email_pessoa, $senha_pessoa) 
    {
        
        global $pdo;
        $sql = $pdo->prepare("SELECT * FROM tb_pessoa WHERE email_pessoa = :emc AND senha_pessoa = :sn");
        $sql->bindValue(":emc", $email_pessoa);
        $sql->bindValue(":sn", $senha_pessoa);
        $sql->execute();
        if($sql->rowCount() > 0)
        {
            $colab = $sql->fetch();
            session_start();
            $_SESSION['cd_pessoa'] = $colab['cd_pessoa'];
            $_SESSION['email_pessoa'] = $colab['email_pessoa'];
            $_SESSION['senha_pessoa'] = $colab['senha_pessoa'];
            $_SESSION['pnome_pessoa'] = $colab['pnome_pessoa'];
            $_SESSION['snome_pessoa'] = $colab['snome_pessoa'];
            $sql1 = $pdo->prepare("SELECT * FROM rel_user WHERE cd_pessoa = ".$_SESSION['cd_pessoa']."");
            $sql1->execute();

            if($sql1->rowCount() == 0){
                $sql2 = $pdo->prepare("INSERT INTO rel_user(cd_seg, cd_pessoa, cd_estilo, cd_funcao, cd_casa) VALUES (1, :cdp, 1, 1, 1)");
                $sql2->bindValue(":cdp", $_SESSION['cd_pessoa']);
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
                       
           
                $sql4 = $pdo->prepare("SELECT * FROM tb_funcao WHERE cd_funcao = ".$_SESSION['cd_funcao']."");
                $sql4->execute();
                if($sql4->rowCount() > 0)
                {
                    //entrar no sistema(sessão)
                    $tb_funcao = $sql4->fetch();
                    //session_start();
                   
                    $_SESSION['md_cadastro_hw'] = $tb_funcao['md_cadastro_hw'];
                    $_SESSION['md_edicao_hw'] = $tb_funcao['md_edicao_hw'];
                    $_SESSION['md_cadastro_pessoa'] = $tb_funcao['md_cadastro_pessoa'];
                    $_SESSION['md_edita_pessoa'] = $tb_funcao['md_edita_pessoa'];
                    $_SESSION['md_permite_pessoa'] = $tb_funcao['md_permite_pessoa'];
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

