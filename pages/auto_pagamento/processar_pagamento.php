<?php
require 'vendor/autoload.php';
// Processamento do pagamento
$payment = new MercadoPago\Payment();
$payment->transaction_amount = $_POST['transaction_amount'];
$payment->description = $_POST['description'];
$payment->payment_method_id = $_POST['payment_method_id'];
$payment->payer = array(
    "email" => "comprador@example.com"
);
$payment->save();
echo "Pagamento processado com sucesso! ID do pagamento: " . $payment->id;
?>
