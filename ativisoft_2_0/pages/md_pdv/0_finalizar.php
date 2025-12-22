<?php
session_start();

if (empty($_SESSION['carrinho'])) {
    header('Location: pdv_balcao.php');
    exit;
}

$carrinho = $_SESSION['carrinho'];
$desconto = $_SESSION['desconto'] ?? 0;

$subtotal = 0;
foreach ($carrinho as $item) {
    $subtotal += $item['price'] * $item['qtd_orcamento_venda'];
}
$total = max(0, $subtotal - $desconto);

/* AQUI você pode salvar no banco */

$_SESSION['ultima_venda'] = [
    'itens' => $carrinho,
    'subtotal' => $subtotal,
    'desconto' => $desconto,
    'total' => $total,
    'data' => date('d/m/Y H:i:s')
];


$query = "INSERT INTO tb_venda(cd_servico, titulo_atividade, obs_atividade, cd_colab, inicio_atividade, fim_atividade) VALUES(
                  '".$cd_servico."',
                  '".$flag_atividade."',
                  '".$obs_atividade."',
                  '".$cd_colab."',
                  NOW(),
                  NOW()
                  )
                ";
                if(mysqli_query($conn, $query)){
                    $id_atividade = mysqli_insert_id($conn);
                    //echo "<script>window.alert('".addslashes($query)."');</script>";
                    //echo "<script>window.alert('ATIVIDADE ARQUIVADA!');</script>";        
                }else{
                    echo "<script>window.alert('ERRO');</script>";
                    //echo "<script>window.alert('".addslashes($e->getMessage())."');</script>";
                }

                $update_orcamento_venda = "";
                //$update_reserva = "UPDATE tb_reserva";
                $u->inicioVenda($_POST['cd_cliente'], $_SESSION['cd_filial'], $_POST['cd_vendedor']);
                $u->addOrcamentoVenda('', '', '', '', '', '', '');
                $u->remOrcamentoVenda('', '');
                $u->finalVenda('', '', '', '');
                $update_venda = "UPDATE tb_venda SET
                    status_servico = '4'
                    WHERE cd_venda = '".$_POST['atividadecd_servico']."'
                ";
                if(mysqli_query($conn, $query)){
                    //echo "<script>window.alert('".addslashes($query)."');</script>"; 
                    //echo "<script>window.alert('SERVICO ARQUIVADO!');</script>";
                }else{
                  echo "<script>window.alert('ERRO');</script>";
                  //echo "<script>window.alert('".addslashes($e->getMessage())."');</script>";
                } 


/* LIMPA CARRINHO */
unset($_SESSION['carrinho'], $_SESSION['desconto']);

header('Location: 0_comprovante.php');
exit;
