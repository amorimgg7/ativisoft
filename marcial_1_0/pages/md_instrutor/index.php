<?php
    $totalAlunos = $pdo->query("SELECT COUNT(*) FROM tb_vinculo WHERE tipo_vinculo='ALUNO'")->fetchColumn();
                                $totalInstrutores = $pdo->query("SELECT COUNT(*) FROM tb_vinculo WHERE tipo_vinculo='INSTRUTOR'")->fetchColumn();
                                $totalTreinos = $pdo->query("SELECT COUNT(*) FROM tb_treino")->fetchColumn();
                                $totalExames = $pdo->query("SELECT COUNT(*) FROM tb_exame_graduacao")->fetchColumn();

                                echo '
                                    <h1>Perfil de Instrutor</h1>
                                    <div class="row">
                                        <div class="col-6 col-md-3">
                                            <div class="card-box bg-aluno">
                                                <h3>'.$totalAlunos.'</h3>
                                                <p>Alunos</p>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="card-box bg-arte">
                                                <h3>'.$totalInstrutores.'</h3>
                                                <p>Instrutores</p>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="card-box bg-treino">
                                                <h3>'.$totalTreinos.'</h3>
                                                <p>Treinos</p>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="card-box bg-exame">
                                                <h3>'.$totalExames.'</h3>
                                                <p>Exames de Faixa</p>
                                            </div>
                                        </div>
                                    </div>
                                ';
?>