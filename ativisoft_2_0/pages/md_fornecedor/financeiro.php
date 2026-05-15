<?php

$hoje      = date('Y-m-d');
$inicioMes = date('Y-m-01');
$fimMes    = date('Y-m-t');

/*
O que será mostrado:

1) parcelas do mês atual ainda abertas
2) parcelas vencidas (qualquer mês anterior)
*/

$sql = "
SELECT 
    f.cd_movimento,
    f.cd_filial,
    f.data_movimento,
    f.valor_movimento,
    f.status_movimento,
    f.obs_movimento,
    e.cd_empresa,
    e.rsocial_empresa,
    e.cnpj_empresa
FROM tb_movimento_financeiro f
JOIN tb_empresa e ON e.cd_empresa = f.cd_filial
WHERE
(
    (f.data_movimento BETWEEN '$inicioMes' AND '$fimMes' AND f.status_movimento = 'A')
    OR
    (f.data_movimento < '$hoje' AND f.status_movimento IN ('A','V'))
)
AND f.status_movimento <> 'F'
ORDER BY f.data_movimento ASC
";

$result = $conn->query($sql);
?>


<div class="col-12 grid-margin stretch-card btn-success">
                        <div class="card">
                            <div class="card-body">
                                <!--<h4 class="card-title" style="text-align: center;">Histórico de Pagamentos do contrato</h4>-->
                                <h4 class="card-title" style="text-align: center;">Contas a Receber</h4>

<h4>Contas a Receber</h4>

<table class="table table-striped">
<thead>
<tr>
<th>Cliente</th>
<!--<th>CNPJ</th>-->
<th>Vencimento</th>
<th>Valor</th>
<th>Status</th>
<!--<th>Observação</th>-->
<th>Cobrar</th>
</tr>
</thead>
<tbody>

<?php

$totalReceber = 0;

if($result->num_rows > 0){

while($row = $result->fetch_assoc()){

$data = $row['data_movimento'];
$status = $row['status_movimento'];

/* ========= calcula vencido automaticamente ========= */
if($status == 'A' && $data < $hoje){
    $status = 'V';
}

/* ========= badge ========= */
switch($status){
    case 'A':
        $badge = '<span class="badge badge-warning">A vencer</span>';
        break;

    case 'V':
        $badge = '<span class="badge badge-danger">Vencido</span>';
        break;

    case 'F':
        continue; // nunca mostra pago
}

/* ========= soma total ========= */
$totalReceber += $row['valor_movimento'];

/* ========= cor linha ========= */
$cor = '';
if($status == 'V'){
    $cor = 'style="background:#ffe6e6;"';
}
elseif($data == $hoje){
    $cor = 'style="background:#fff3cd;"'; // vence hoje
}

echo "<tr $cor>";
echo '<td>'.$row['cd_empresa'].' '.$row['rsocial_empresa'].'</td>';
//echo '<td>'.$row['cnpj_empresa'].'</td>';
echo '<td><b>'.date('d/m/Y', strtotime($data)).'</b></td>';
echo '<td>R$ '.number_format($row['valor_movimento'],2,'.','.').'</td>';
echo '<td>'.$badge.'</td>';
//echo '<td>'.$row['obs_movimento'].'</td>';
$result_mensagem = $u->mensagem1($_SESSION['tipo_mensagem'], 'CONTRATO', $row['cd_empresa'], '');
if($result_mensagem['status'] == 'OK'){
  echo '<td>'.$result_mensagem['partial_mensagem'].'</td>';
}else{
  echo '<td>'.$result_mensagem['status'].'</td>';
}

echo '</tr>';

}

}else{
echo '<tr><td colspan="6">Nenhuma cobrança pendente 🎉</td></tr>';
}

?>

</tbody>
</table>

<hr>

<h3 style="text-align:right;">
Total a receber: 
<span style="color:#28a745">
R$ <?= number_format($totalReceber,2,'.','.') ?>
</span>
</h3>
</div>
</div>
</div>








