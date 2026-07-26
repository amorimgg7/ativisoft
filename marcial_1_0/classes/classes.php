<?php
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