<?php
echo '<h1>Perfil de Aluno</h1>';
$stmt = $pdo->prepare("
    SELECT
        ct.*,
        v.tipo_vinculo,
        v.dt_inicio,
        v.dt_fim,
        v.ativo
    FROM tb_vinculo v
    INNER JOIN tb_ct_marcial ct
        ON ct.cd_ct_marcial = v.cd_ct_marcial
    WHERE v.cd_pessoa = :cd_pessoa
    ORDER BY ct.nome_ct
");

$stmt->execute([
    ':cd_pessoa' => $_SESSION['cd_pessoa']
]);

$academias = $stmt->fetchAll(PDO::FETCH_ASSOC);



if (count($academias) > 0) {

    echo '<div class="row">';

    foreach ($academias as $academia) {
      echo '<div class="col-md-4">';
      echo '<div class="card mb-3">';
      echo '<div class="card-body">';
      echo '<h5>'.$academia['nome_ct'].'</h5>';
      echo '<p><strong>Vínculo:</strong> '.$academia['tipo_vinculo'].'</p>';
      echo '<p><strong>Status:</strong> '.($academia['ativo'] ? 'Ativo' : 'Inativo').'</p>';
      if (!empty($academia['dt_inicio'])) {
        echo '<p><strong>Início:</strong> '.date('d/m/Y', strtotime($academia['dt_inicio'])).'</p>';
      }
      echo '</div>';
      // Botões
      echo '<div class="row justify-content-center">';
      echo ($academia['tipo_vinculo'] == 'ADMIN'                  ? '<div class="col-4"><a href="../md_admin/index.php" class="btn btn-warning w-100 mr-2">Admin</a></div>' : '');
      echo ($academia['tipo_vinculo'] == 'ALUNO'                  ? '<div class="col-4"><a href="../md_aluno/index.php" class="btn btn-warning w-100 mr-2">Aluno</a></div><div class="col-4"><a href="../md_simulado/index.php" class="btn bg-treino w-100 mr-2">Simulado</a></div>' : '');
      echo ($academia['tipo_vinculo'] == 'INSTRUTOR'              ? '<div class="col-4"><a href="../md_instrutor/index.php" class="btn bg-arte w-100 mr-2">Instrutor</a></div> <div class="col-4"><a href="../md_aluno/listar.php" class="btn bg-aluno w-100 mr-2">Gerenciar Alunos</a></div>' : '');
      echo ($academia['tipo_vinculo'] == 'AUXILIAR DE INSTRUTOR'  ? '<div class="col-4"><a href="../md_auxiliar_de_instrutor/index.php" class="btn btn-warning w-100 mr-2">Auxiliar de Instrutor</a></div>' : '');
      echo ($academia['tipo_vinculo'] == 'MESTRE'                 ? '<div class="col-4"><a href="../md_mestre/index.php" class="btn btn-warning w-100 mr-2">Mestre</a></div>' : '');
      echo ($academia['tipo_vinculo'] == 'GRÃO MESTRE'            ? '<div class="col-4"><a href="../md_grao_mestre/index.php" class="btn btn-warning w-100 mr-2">Grão Mestre</a></div>' : '');
      echo ($academia['tipo_vinculo'] == 'COMPETIDOR'             ? '<div class="col-4"><a href="../md_competidor/index.php" class="btn btn-warning w-100 mr-2">Competidor</a></div>' : '');
      echo '</div>';
      echo '</div>';
      echo '</div>';
    }

    echo '</div>';

} else {

    echo '<div class="alert alert-warning">';
    echo 'Você não possui vínculo com nenhuma academia.';
    echo '</div>';

}

?>