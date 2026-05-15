<?php

function montarDanfeHTML($dados,$barcode, $qrCode, $linkConsulta){

$produtosHTML="";

foreach($dados["produtos"] as $p){

$produtosHTML.="
<tr>
<td>{$p['codigo']}</td>
<td>{$p['descricao']}</td>
<td>{$p['ncm']}</td>
<td>{$p['cfop']}</td>
<td>{$p['qtd']}</td>
<td>{$p['valor']}</td>
<td>{$p['total']}</td>
</tr>
";

}

$html="

<style>

body{font-family:Arial;font-size:10px}

table{width:100%;border-collapse:collapse}

th,td{border:1px solid #000;padding:4px}

.center{text-align:center}

.right{text-align:right}

</style>

<table>

<tr>

<td width='60%'>

<b>{$dados["emitente"]["nome"]}</b><br>
CNPJ: {$dados["emitente"]["cnpj"]}<br>
{$dados["emitente"]["endereco"]}

</td>

<td width='40%' class='center'>

<h2>DANFE</h2>

NF {$dados["nota"]["numero"]}<br>
Série {$dados["nota"]["serie"]}<br>
{$dados["nota"]["data"]}

</td>

</tr>

</table>

<br>

<table>

<tr>

<td class='center'>

<b>CHAVE DE ACESSO</b><br>

{$dados["nota"]["chave"]}

<br>

<img src='data:image/png;base64,$barcode'>

</td>

</tr>

</table>

<br>

<table>

<tr>
<td>

<b>Destinatário</b><br>

{$dados["dest"]["nome"]}<br>
Doc: {$dados["dest"]["doc"]}

</td>
</tr>

</table>

<br>

<table>

<tr>

<th>Código</th>
<th>Descrição</th>
<th>NCM</th>
<th>CFOP</th>
<th>Qtd</th>
<th>Valor</th>
<th>Total</th>

</tr>

$produtosHTML

</table>

<br>

<table>

<tr>

<td width='70%'></td>

<td width='30%'>

<table>

<tr>
<td>Total Produtos</td>
<td class='right'>R$ {$dados["totais"]["produtos"]}</td>
</tr>

<tr>
<td>ICMS</td>
<td class='right'>R$ {$dados["totais"]["icms"]}</td>
</tr>

<tr>
<td>PIS</td>
<td class='right'>R$ {$dados["totais"]["pis"]}</td>
</tr>

<tr>
<td>COFINS</td>
<td class='right'>R$ {$dados["totais"]["cofins"]}</td>
</tr>

<tr>
<td><b>Total NF</b></td>
<td class='right'><b>R$ {$dados["totais"]["nf"]}</b></td>
</tr>

</table>

</td>

</tr>

</table>

<br><br>

<div class='center'>

<img src='data:image/png;base64,$qrCode' width='150'>

</div>

<div class='center'>

<a href='$linkConsulta' target='_blank'>
$linkConsulta
</a>

</div>

";  

return $html;

}