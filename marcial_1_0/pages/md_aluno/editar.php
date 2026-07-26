<?php
session_start();
require_once '../../classes/conn.php';

$id = $_GET['id'] ?? null;

if(!$id){
    echo "Aluno não informado";
    exit;
}

// ================= RESET SENHA =================
if(isset($_POST['reset_senha'])){
    $stmt = $pdo->prepare("UPDATE tb_pessoa SET senha_pessoa = ? WHERE cd_pessoa = ?");
    $stmt->execute([password_hash("1", PASSWORD_DEFAULT), $id]);

    header("Location: editar.php?id=".$id);
    exit;
}

// ================= SALVAR =================
if($_POST && !isset($_POST['reset_senha'])){

    $pdo->beginTransaction();

    try{

        $stmt = $pdo->prepare("
            UPDATE tb_pessoa SET
                pnome_pessoa = ?,
                snome_pessoa = ?,
                sexo_pessoa = ?,
                cpf_pessoa = ?,
                dt_nasc_pessoa = ?,
                tel_pessoa = ?,
                email_pessoa = ?
            WHERE cd_pessoa = ?
        ");

        $stmt->execute([
            $_POST['pnome'],
            $_POST['snome'],
            $_POST['sexo'],
            $_POST['cpf'],
            $_POST['dt_nasc'],
            $_POST['tel'],
            $_POST['email'],
            $id
        ]);

        // REMOVE VÍNCULOS
        $pdo->prepare("DELETE FROM tb_vinculo WHERE cd_pessoa = ?")->execute([$id]);

        // INSERE NOVOS
        if(isset($_POST['vinculos'])){
            foreach($_POST['vinculos'] as $v){

                if(empty($v['cd_ct_marcial'])) continue;

                $stmt = $pdo->prepare("
                    INSERT INTO tb_vinculo (
                        cd_pessoa, cd_ct_marcial, cd_arte_marcial, tipo_vinculo,
                        dt_inicio, ativo
                    ) VALUES (?, ?, ?, ?, ?, 'ATIVO')
                ");

                $stmt->execute([
                    $id,
                    $v['cd_ct_marcial'],
                    $v['cd_arte_marcial'],
                    $v['tipo'],
                    $v['dt_inicio']
                ]);
            }
        }

        $pdo->commit();
        header("Location: index.php");
        exit;

    } catch(Exception $e){
        $pdo->rollBack();
        echo "Erro: " . $e->getMessage();
    }
}

// ================= DADOS =================
$stmt = $pdo->prepare("SELECT * FROM tb_pessoa WHERE cd_pessoa = ?");
$stmt->execute([$id]);
$aluno = $stmt->fetch();

// VÍNCULOS
$vinculos = $pdo->prepare("SELECT * FROM tb_vinculo WHERE cd_pessoa = ?");
$vinculos->execute([$id]);
$vinculos = $vinculos->fetchAll();

// ACADEMIAS
$academias = $pdo->query("SELECT cd_ct_marcial, nome_ct FROM tb_ct_marcial")->fetchAll();

$artes_marciais = $pdo->query("SELECT cd_arte_marcial, nome_arte FROM tb_arte_marcial")->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Editar Aluno</title>

<link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
<link rel="stylesheet" href="../../vendors/feather/feather.css">
<link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
<link rel="stylesheet" href="../../vendors/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="../../css/style.css">

</head>

<body>

<div class="container-scroller">

<?php include("../../partials/_navbar.php"); ?>
<div class="container-fluid page-body-wrapper">
<?php include("../../partials/_sidebar.php"); ?>

<div class="main-panel">
<div class="content-wrapper">

<h3 class="mb-4">Editar Aluno</h3>

<form method="POST">

<!-- ================= DADOS ================= -->
<div class="card p-3 mb-3">
<h5>Dados do Aluno</h5>

<div class="row">

<div class="col-md-4">
<label>Primeiro Nome</label>
<input type="text" name="pnome" class="form-control" value="<?= $aluno['pnome_pessoa'] ?>">
</div>

<div class="col-md-4">
<label>Sobrenome</label>
<input type="text" name="snome" class="form-control" value="<?= $aluno['snome_pessoa'] ?>">
</div>

<div class="col-md-4">
<label>Sexo</label>
<select name="sexo" class="form-control">
<option <?= $aluno['sexo_pessoa']=='M'?'selected':'' ?>>M</option>
<option <?= $aluno['sexo_pessoa']=='F'?'selected':'' ?>>F</option>
</select>
</div>

<div class="col-md-4 mt-2">
<label>CPF</label>
<input type="text" name="cpf" class="form-control" value="<?= $aluno['cpf_pessoa'] ?>">
</div>

<div class="col-md-4 mt-2">
<label>Nascimento</label>
<input type="date" name="dt_nasc" class="form-control" value="<?= $aluno['dt_nasc_pessoa'] ?>">
</div>

<div class="col-md-4 mt-2">
<label>Telefone</label>
<input type="text" name="tel" class="form-control" value="<?= $aluno['tel_pessoa'] ?>">
</div>

<div class="col-md-6 mt-2">
<label>Email</label>
<input type="email" name="email" class="form-control" value="<?= $aluno['email_pessoa'] ?>">
</div>

<div class="col-md-6 mt-2">
<label>Senha</label><br>

<button type="submit" name="reset_senha" value="1" class="btn btn-warning">
<i class="fa fa-refresh"></i> Resetar para "1"
</button>
</div>

</div>
</div>

<!-- VINCULOS -->
<div class="card p-3 mb-3">

<table class="table" id="tabelaVinculos">
<thead>
<tr>
<th>Academia</th>
<th>Modalidade</th>
<th>Tipo</th>
<th>Início</th>
<th></th>
</tr>
</thead>

<tbody>

<?php foreach($vinculos as $i => $v): ?>
<tr>
<td>
<select name="vinculos[<?= $i ?>][cd_ct_marcial]" class="form-control">
<?php foreach($academias as $a): ?>
<option value="<?= $a['cd_ct_marcial'] ?>" <?= $a['cd_ct_marcial']==$v['cd_ct_marcial']?'selected':'' ?>>
<?= $a['nome_ct'] ?>
</option>
<?php endforeach; ?>
</select>
</td>

<td>
<select name="vinculos[<?= $i ?>][cd_arte_marcial]" class="form-control">
<?php foreach($artes_marciais as $am): ?>
<option value="<?= $am['cd_arte_marcial'] ?>" <?= $am['cd_arte_marcial']==$v['cd_arte_marcial']?'selected':'' ?>>
<?= $am['nome_arte'] ?>
</option>
<?php endforeach; ?>
</select>
</td>

<td>
<select name="vinculos[<?= $i ?>][tipo]" class="form-control">
<?php
$tipos = ["ALUNO","INSTRUTOR","AUXILIAR DE INSTRUTOR","MESTRE","COMPETIDOR"];
foreach($tipos as $t){
    $sel = ($t == $v['tipo_vinculo']) ? 'selected' : '';
    echo "<option $sel>$t</option>";
}
?>
</select>
</td>

<td>
<input type="date" 
name="vinculos[<?= $i ?>][dt_inicio]" 
class="form-control" 
value="<?= !empty($v['dt_inicio']) ? date('Y-m-d', strtotime($v['dt_inicio'])) : '' ?>">
</td>

<td>
<button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">
<i class="fa fa-trash"></i>
</button>
</td>
</tr>
<?php endforeach; ?>

</tbody>
</table>

<button type="button" class="btn btn-secondary" onclick="addVinculo()">
<i class="fa fa-plus"></i> Adicionar
</button>

</div>

<button class="btn btn-primary">Atualizar</button>

</form>

</div>

<!-- JS CORRETO -->
<script>
const academias = <?= json_encode($academias) ?>;
const artes_marciais = <?= json_encode($artes_marciais) ?>;

function addVinculo(){

    let tabela = document.querySelector("#tabelaVinculos tbody");
    let index = tabela.querySelectorAll("tr").length;

    // SELECT ACADEMIA
    let optAcademia = '<option value="">Selecione</option>';
    academias.forEach(a => {
        optAcademia += `<option value="${a.cd_ct_marcial}">${a.nome_ct}</option>`;
    });

    // SELECT MODALIDADE (ARTE MARCIAL)
    let optArte = '<option value="">Selecione</option>';
    artes_marciais.forEach(a => {
        optArte += `<option value="${a.cd_arte_marcial}">${a.nome_arte}</option>`;
    });

    let row = `
    <tr>

        <!-- ACADEMIA -->
        <td>
            <select name="vinculos[${index}][cd_ct_marcial]" class="form-control">
                ${optAcademia}
            </select>
        </td>

        <!-- MODALIDADE (ARTE MARCIAL) -->
        <td>
            <select name="vinculos[${index}][cd_arte_marcial]" class="form-control">
                ${optArte}
            </select>
        </td>

        <!-- TIPO -->
        <td>
            <select name="vinculos[${index}][tipo]" class="form-control">
                <option>ALUNO</option>
                <option>INSTRUTOR</option>
                <option>AUXILIAR DE INSTRUTOR</option>
                <option>MESTRE</option>
                <option>COMPETIDOR</option>
            </select>
        </td>

        <!-- DATA -->
        <td>
            <input type="date" name="vinculos[${index}][dt_inicio]" class="form-control">
        </td>

        <!-- REMOVER -->
        <td>
            <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">
                <i class="fa fa-trash"></i>
            </button>
        </td>

    </tr>
    `;

    tabela.insertAdjacentHTML('beforeend', row);
}
</script>


<?php
                    include("../../partials/_footer.php");
                ?>
           


    
  <!-- container-scroller -->

  <!-- base:js -->
  <script src="../../vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <!-- endinject -->
  <!-- plugin js for this page -->
  <script src="../../vendors/chart.js/Chart.min.js"></script>
  <script src="../../vendors/jquery-bar-rating/jquery.barrating.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="../../js/dashboard.js"></script>
  <!-- End custom js for this page-->


</body>
</html>