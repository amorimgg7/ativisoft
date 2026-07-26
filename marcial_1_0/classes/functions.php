<?php


// Ativa a exibição de erros (útil em ambiente de desenvolvimento)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ativa o registro de erros (útil para produção)
ini_set('log_errors', 1);

// Caminho absoluto e gravável pelo servidor web
ini_set('error_log', __DIR__ . '/logs/erro_php.log'); // Corrigido para caminho relativo ao script

//header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
//header("Pragma: no-cache");




class Usuario  
{
    public function conectar()
    {
        include("conn.php");

        global $pdo;
        global $msgErro;

        $msgErro = "";

        try {
            $pdo = new PDO("mysql:dbname=".$nome.";host=".$host, $usuario, $senha);
        } catch (PDOException $e) {
            $msgErro = $e->getMessage();
        }
    }

    //  LOGIN
    public function logar($login, $senha) 
    {
        $_SESSION['toEncoding'] = 'ISO-8859-1';
        $_SESSION['fromEncoding'] = 'UTF-8';
        
        global $pdo;
        $u = new Usuario();

        // remover espaços invisíveis
        $login = trim($login);
        $senha = trim($senha);

        $loginUsuario = $pdo->prepare("SELECT * FROM tb_pessoa WHERE email_pessoa = :login LIMIT 1");

        $loginUsuario->bindValue(":login", $login);
        $loginUsuario->execute();
        if($loginUsuario->rowCount() > 0)
        {
            
            $user = $loginUsuario->fetch();
            
            // COMPARAÇÃO SIMPLES (igual seu banco atual)
            $_SESSION['senha'] = $user['senha_pessoa'];
            if($senha === $user['senha_pessoa'])
            {
                
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                $_SESSION['cd_pessoa']      = $user['cd_pessoa'];
                $_SESSION['pnome_pessoa']   = $user['pnome_pessoa'];
                $_SESSION['snome_pessoa']   = $user['snome_pessoa'];
                $_SESSION['email_pessoa']   = $user['email_pessoa'];
                $_SESSION['ativo']          = $user['ativo'];
                $_SESSION['perfil']         = $user['perfil'];

                return true;
            }
//$_SESSION['passo'] = '6';
            // 👉 SE ESTIVER USANDO HASH (futuro)
            /*
            if(password_verify($senha, $user['senha_pessoa']))
            {
                session_start();
                $_SESSION['cd_pessoa'] = $user['cd_pessoa'];
                return true;
            }
            */
        }

        return false;
    }

    // 🔒 VERIFICAR LOGIN
    public function verificarLogin()
    {
        if(!isset($_SESSION['cd_usuario']))
        {
            echo '<script>location.href="'.$_SESSION['dominio'].'index.php";</script>';
            exit;
        }
    }

    // 🚪 LOGOUT
    public function logout()
    {
        session_start();
        session_destroy();

        echo '<script>location.href="'.$_SESSION['dominio'].'index.php";</script>';
    }
}

class Pessoa
{
    public function listar()
    {
        include("conn.php");

        $sql = $pdo->query("SELECT * FROM tb_pessoa ORDER BY pnome_pessoa");
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cadastrar($dados)
    {
        include("conn.php");

        $sql = $pdo->prepare("
            INSERT INTO tb_pessoa 
            (pnome_pessoa, snome_pessoa, email_pessoa, tel_pessoa)
            VALUES (:pnome, :snome, :email, :tel)
        ");

        $sql->bindValue(":pnome", $dados['pnome']);
        $sql->bindValue(":snome", $dados['snome']);
        $sql->bindValue(":email", $dados['email']);
        $sql->bindValue(":tel", $dados['tel']);

        return $sql->execute();
    }
}

class Vinculo
{
    public function criar($dados)
    {
        include("conn.php");

        $sql = $pdo->prepare("
            INSERT INTO tb_vinculo
            (cd_pessoa, cd_arte_marcial, cd_ct_marcial, tipo_vinculo, dt_inicio)
            VALUES (:pessoa, :arte, :ct, :tipo, NOW())
        ");

        $sql->bindValue(":pessoa", $dados['cd_pessoa']);
        $sql->bindValue(":arte", $dados['cd_arte']);
        $sql->bindValue(":ct", $dados['cd_ct']);
        $sql->bindValue(":tipo", $dados['tipo']);

        return $sql->execute();
    }

    public function listarPorPessoa($cd_pessoa)
    {
        include("conn.php");

        $sql = $pdo->prepare("
            SELECT v.*, a.nome_arte, ct.nome_ct
            FROM tb_vinculo v
            INNER JOIN tb_arte_marcial a ON a.cd_arte_marcial = v.cd_arte_marcial
            INNER JOIN tb_ct_marcial ct ON ct.cd_ct_marcial = v.cd_ct_marcial
            WHERE v.cd_pessoa = :pessoa
        ");

        $sql->bindValue(":pessoa", $cd_pessoa);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}