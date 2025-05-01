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

    public function logar($email_pessoa, $id_google) 
    {
        global $pdo;
        $loginPessoa = $pdo->prepare("SELECT * FROM tb_pessoa WHERE email_pessoa = (:emp) AND key_google = (:idg)");
        $loginPessoa->bindValue(":emp", $email_pessoa);
        $loginPessoa->bindValue(":idg", $id_google);
        $loginPessoa->execute();
        //echo "<script>window.alert('Area do cliente');</script>";
        if($loginPessoa->rowCount() > 0){
            $pessoa = $loginPessoa->fetch();
            $_SESSION['id_pessoa'] = $pessoa['id_pessoa'];
            $_SESSION['email_pessoa'] = $pessoa['email_pessoa'];
            $_SESSION['nome_pessoa'] = $pessoa['nome_pessoa'];
            $_SESSION['tel_pessoa'] = $pessoa['tel_pessoa'];
            //echo "<script>window.alert('Area do cliente');</script>";
            return true;
        }else{
            echo json_encode(["success" => false, "message" => "Erro ao realizar login"]);
        }
    }
    
    ///////////////////////////////////////////////////////////////////////
    //////////////////CADASTROS ESSENCIAIS/////////////////////////////////
    ///////////////////////////////////////////////////////////////////////

    public function cadPessoa($nome_pessoa, $email_pessoa, $tel_pessoa, $id_google)
    //public function cadPessoal1($pnome_pessoal, $snome_pessoal, $cpf_pessoal, $rg_pessoal, $cnh_pessoal, $carttrabalho_pessoal, $pis_pessoal, $dtnasc_pessoal, $sexo_pessoal, $ecivil_pessoal, $tel1_pessoal, $obs_tel1_pessoal, $tel2_pessoal, $obs_tel2_pessoal, $email_pessoal, $senha_pessoal)
    {
        global $pdo;
        //verificar se ja está cadastrado
        $selectPessoa = $pdo->prepare("SELECT * FROM tb_pessoa WHERE key_google = :idg");
        $selectPessoa->bindValue(":idg", $id_google);
        $selectPessoa->execute();
        if($selectPessoa->rowCount() > 0)
        {session_start();//se ja estiver cadastrado
            //$_SESSION['concd_colab'];
            $rowPessoa = $selectPessoa->fetch();
            echo "<script>window.alert('Pessoa jà cadastrado para o email ".$rowPessoa['email_pessoa']."!');</script>";
            return false; //ja está cadastrado  
        }
        else
        {//não cadastrado, cadastrando agora
            if($id_google == ''){
                $id_google = 'N';
            }
            $insertPessoa = $pdo->prepare("INSERT INTO tb_pessoa(nome_pessoa, email_pessoa, tel_pessoa, key_google) VALUES (:nmp, :emp, :tlp, :idg)");
            $insertPessoa->bindValue(":nmp", $nome_pessoa);
            $insertPessoa->bindValue(":emp", $email_pessoa);
            $insertPessoa->bindValue(":tlp", $tel_pessoa);
            $insertPessoa->bindValue(":idg", $id_google);
            $insertPessoa->execute();
            $selectcdPessoa = $pdo->prepare("SELECT * FROM tb_pessoa WHERE email_pessoa = :emc");
            $selectcdPessoa->bindValue(":emc", $email_pessoa);
            $selectcdPessoa->execute();
            if($selectcdPessoa->rowCount() > 0)
            {
                echo "<script>window.alert('Login criado com sucesso');</script>";
                session_start();
                $rowPessoa = $selectcdPessoa->fetch();
                $_SESSION['id_pessoa'] = $rowPessoa['id_pessoa'];
                $_SESSION['email_pessoa'] = $rowPessoa['email_pessoa'];
                $_SESSION['tel_pessoa'] = $rowPessoa['tel_pessoa'];
                return true;
            }else{
                echo "<script>window.alert('Falha - Usuario');</script>";
            }
        }
        //se não estiver cadastrado, vamos fazer o cadastro
    }
}

function loggout(){
    //session_start();
    $_SESSION['id_pessoa'] = '';
    session_destroy();
    echo '<script>location.href="'.$_SESSION['dominio'].'index2.php";</script>';
    echo "<script>window.close();</script>";
}


?>

