<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Postos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function atualizarBairros() {
            var municipio = document.getElementById("municipio_posto").value;
            var bairroSelect = document.getElementById("bairro_posto");
            bairroSelect.innerHTML = "<option value=''>Selecione um bairro</option>";

            if (!municipio) return;

            fetch(`get_bairros.php?municipio=${municipio}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(function(bairro) {
                        var option = document.createElement("option");
                        option.value = bairro;
                        option.text = bairro;
                        bairroSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Erro ao carregar bairros:', error));
        }
    </script>
</head>
<body class="container mt-4">
    <h2 class="mb-4">TABELA LIVRE</h2>
    <?php
    require 'vendor/autoload.php';
    use Google\Cloud\BigQuery\BigQueryClient;
    
    if (!file_exists(__DIR__ . '/credentials.json')) {
        die('Arquivo de credenciais não encontrado!');
    } else {
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . __DIR__ . '/credentials.json');
    }
    
    $bigQuery = new BigQueryClient(['projectId' => 'ondeabastecer-455021']);
    
    if (isset($_POST['consulta_posto'])) {
        $municipio = $_POST['municipio_posto'];
        $bairro = $_POST['bairro_posto'];
        $produto = $_POST['produto_posto'];
        
        $query = "SELECT nome_estabelecimento AS NOME, cep_revenda as MAPA, cep_revenda as CEP, endereco_revenda As ENDERECO, bairro_revenda AS BAIRRO, produto AS PRODUTO, data_coleta AS DIA, 'IBGE' AS FONTE,  
                  MAX(preco_venda) AS preco_maximo FROM `basedosdados.br_anp_precos_combustiveis.microdados` WHERE data_coleta >= '2025-02-01'";
        if ($municipio) $query .= " AND id_municipio = '$municipio'";
        if ($bairro) $query .= " AND bairro_revenda = '$bairro'";
        if ($produto) $query .= " AND produto = '$produto'";
        $query .= " GROUP BY nome_estabelecimento, bairro_revenda, produto, data_coleta, cep_revenda, endereco_revenda ORDER BY preco_maximo ASC";

        $queryResults = $bigQuery->runQuery($bigQuery->query($query));
        echo "<table class='table table-striped mt-4'><thead><tr>";
        

        if ($queryResults->isComplete()) {
            echo '<div class="container mt-3">';
            echo '<div class="table-responsive">'; // Permite rolagem em telas pequenas
            echo '<table class="table table-striped table-bordered table-hover">'; // Tabela com Bootstrap
            echo '<thead class="table-dark"><tr>';
        
            // Inicializa a variável antes do loop
            $firstRow = true;
        
            // Verifica se não houve resultados
            if (iterator_count($queryResults) === 0) {
                echo "<tr><td colspan='5' class='text-center'>Nenhum dado encontrado</td></tr>";
            }
        
            // Pegando os nomes das colunas
            foreach ($queryResults as $row) {
                if ($firstRow) {
                    foreach ($row as $key => $value) {
                        echo "<th>$key</th>";
                    }
                    echo "</tr></thead><tbody>";
                    $firstRow = false;
                }
                echo "<tr>";
                foreach ($row as $key => $value) {
                    if ($key === 'MAPA') {
                        echo "<td>
                                <!--<button class='btn btn-sm btn-primary' onclick=\"updateMap('$value')\">Ver no Mapa</button>-->
                                <a class='btn btn-sm btn-success' href='https://www.google.com/maps/dir/?api=1&destination=" . urlencode($value) . "' target='_blank'>Google Maps</a>
                              </td>";
                    } else {
                        echo "<td>$value</td>";
                    }
                }
                echo "</tr>";
            }
        
            echo "</tbody></table></div></div>"; // Fecha a tabela responsiva
        } else {
            echo "<div class='container mt-3'><p class='alert alert-danger'>A consulta não foi concluída.</p></div>";
        }

        
        
        echo "</tbody></table>";
    } else {
        $query = "SELECT DISTINCT b.id_municipio, m.sigla_uf, m.nome AS nome_municipio FROM `basedosdados.br_anp_precos_combustiveis.microdados` AS b 
                  JOIN `basedosdados.br_bd_diretorios_brasil.municipio` AS m ON b.id_municipio = m.id_municipio ORDER BY m.sigla_uf ASC, m.nome ASC";
        $queryResults = $bigQuery->runQuery($bigQuery->query($query));
    ?>
        <form method="POST" class="mb-4">
            <div class="mb-3">
                <label for="municipio_posto" class="form-label">Município</label>
                <select id="municipio_posto" name="municipio_posto" class="form-select" onchange="atualizarBairros()">
                    <option value="">Selecione um município</option>
                    <option value="3304557">Rio de Janeiro RJ</option>
                    <?php foreach ($queryResults as $row) {
                        echo "<option value='{$row['id_municipio']}'>{$row['nome_municipio']} ({$row['sigla_uf']})</option>";
                    } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="bairro_posto" class="form-label">Bairro</label>
                <select id="bairro_posto" name="bairro_posto" class="form-select">
                    <option value="">Todos</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="produto_posto" class="form-label">Produto</label>
                <select id="produto_posto" name="produto_posto" class="form-select">
                    <option value="">Todos</option>
                    <option value="Gnv">Gnv</option>
                    <option value="Etanol">Etanol</option>
                    <option value="Gasolina">Gasolina</option>
                    <option value="Gasolina Aditivada">Gasolina Aditivada</option>
                    <option value="Diesel">Diesel</option>
                    <option value="Diesel S10">Diesel S10</option>
                </select>
            </div>
            <button type="submit" id="consulta_posto" name="consulta_posto" class="btn btn-success">Consultar</button>
        </form>
    <?php } ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>