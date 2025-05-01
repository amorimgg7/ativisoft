<!DOCTYPE html>


<?php
// Verifica se o formulário foi enviado
session_start();


$response = '';
if (isset($_POST['localiza_posto'])) {
    $idInstance = '7105223939';
    $apiTokenInstance = '3f53385e2ead46cbbca3b7bdebec958e9ef4a63ba0c9437289';
    $apiUrl = "https://7105.api.greenapi.com";
    $cnpj_posto = $_POST['cnpj_posto'];
    $cep_posto = $_POST['cep_posto'];
    $endereco_posto = $_POST['endereco_posto'];
    $produto_posto = $_POST['produto_posto'];
    $preco_posto = $_POST['preco_posto'];
    //$pago_posto = $_POST['pago_posto'];
    
    //echo '<h1>'.$cnpj_posto.'</h1>';
    //echo '<h1>'.$endereco_posto.'</h1>';
    //echo '<h1>'.$produto_posto.'</h1>';
    //echo '<h1>'.$preco_posto.'</h1>';

    $phone = preg_replace('/\D/', '', $_SESSION['tel_pessoa']); // Remove tudo que não for número
    $message = 'Olá, você comprou o produto ('.$produto_posto.') pelo preço ('.$preco_posto.') no endereço ('.$endereco_posto.')?

        Responda clicando em uma das opções abaixo:
        ✅ Sim: http://localhost/ondeabastecer_1_0/pages/pesquisas/produto_preco_revenda.php?resposta=sim&revenda='.urlencode($cnpj_posto).'&produto='.urlencode($produto_posto).'&preco='.urlencode($preco_posto).'


        ❌ Não: https://ondeabastecer.ativisoft.com.br/pages/pesquisas/produto_preco_revenda.php?resposta=nao&produto='.urlencode($produto_posto).'
    ';



    //https://ondeabastecer.ativisoft.com.br/pages/pesquisas/produto_preco_revenda.php?resposta=sim&produto='.urlencode($produto_posto).'


    //https://ondeabastecer.ativisoft.com.br/pages/pesquisas/produto_preco_revenda.php?resposta=nao&produto='.urlencode($produto_posto).'


    //http://ondeabastecer.ativisoft.com.br/pages/pesquisas/produto_preco_revenda.php?id_pessoa&revenda=123&produto=gasolina&venda=6&data_hora_compra=
    $url = "$apiUrl/waInstance$idInstance/sendMessage/$apiTokenInstance";

    $data = [
        "chatId" => $phone . "@c.us",
        "message" => $message
    ];

    $options = [
        'http' => [
            'header'  => "Content-Type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data)
        ]
    ];

    $context = stream_context_create($options);
    if($result = file_get_contents($url, false, $context)){
        $response = $result ? json_decode($result, true)['idMessage'] ?? 'Enviado com sucesso!' : 'Erro ao enviar';
        echo '<script>window.alert("'.$response.'('.$message.') !");</script>';
    }else{
        echo '<script>window.alert("Não enviada!");</script>';

    }
    


    


    //echo "<script>location.href='geo:0,0?q=" . urlencode($cep_posto) . "';</script>";

    ////echo "<script>location.href='https://www.google.com/maps/dir/?api=1&destination=" . urlencode($cep_posto) . "';</script>";
    //echo "<a href='https://www.google.com/maps/dir/?api=1&destination=" . urlencode($cep_posto) . "'>Abrir no Google Maps</a>";

    //echo "<script>window.open('https://www.google.com/maps/dir/?api=1&destination=" . urlencode($cep_posto) . "', '_blank');</script>";

}

?>




<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Onde Abastecer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="js/gtag.js"></script>

 
    

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3996853854538676"
     crossorigin="anonymous"></script>

     
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
        
        function detectarOS() {
            let userAgent = navigator.userAgent || navigator.vendor || window.opera;
            let sistema = "Desconhecido";

            if (/android/i.test(userAgent)) {
                sistema = "Android";
                document.getElementById("localizacao_obs").textContent = "";
                document.getElementById("div_municipio_posto").style.display = "none";
                document.getElementById("div_bairro_posto").style.display = "none";
                obterLocalizacao();
            } else 
            if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
                sistema = "iOS";
                document.getElementById("localizacao_obs").textContent = "";
                document.getElementById("div_municipio_posto").style.display = "none";
                document.getElementById("div_bairro_posto").style.display = "none";
                obterLocalizacao();
            } else 
            if (/Win/i.test(userAgent)) {
                sistema = "Windows";
                document.getElementById("localizacao_obs").innerHTML = "<b>Sua Localização pode não estar precisa</b>";
                document.getElementById("div_municipio_posto").style.display = "block";
                document.getElementById("div_bairro_posto").style.display = "block";
                obterLocalizacao();
            } else 
            if (/Mac/i.test(userAgent)) {
                sistema = "MacOS";
                document.getElementById("localizacao_obs").innerHTML = "<b>Sua Localização pode não estar precisa</b>";
                document.getElementById("div_municipio_posto").style.display = "block";
                        document.getElementById("div_bairro_posto").style.display = "block";

                obterLocalizacao();
            } else 
            if (/Linux/i.test(userAgent)) {
                sistema = "Linux";
                document.getElementById("localizacao_obs").innerHTML = "<b>Sua Localização pode não estar precisa</b>";
                document.getElementById("div_municipio_posto").style.display = "block";
                document.getElementById("div_bairro_posto").style.display = "block";

                obterLocalizacao();
            }
            else{
                sistema = "Outros";
                document.getElementById("localizacao_obs").innerHTML = "<b>Sua Localização pode não estar precisa</b>";
                document.getElementById("div_municipio_posto").style.display = "block";
                document.getElementById("div_bairro_posto").style.display = "block";

                obterLocalizacao();
            }
            
            document.getElementById("resultado").innerText = "Sistema Operacional: " + sistema;
            
        }

        function obterLocalizacaoPorIP() {
            document.getElementById("localizacao_obs").innerHTML = "<b>Obtendo localização por IP...</b>";
            fetch('https://ipwho.is/')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const ip = data.ip;
                    const latitude = data.latitude;
                    const longitude = data.longitude;
                    const cidade = data.city;
                    const estado = data.region;
                    const pais = data.country;
                    document.getElementById("localizacao").innerHTML =
                        `Localização aproximada por IP: ${ip}<br>
                        Cidade: ${cidade}<br>
                        Estado: ${estado}<br>
                        País: ${pais}<br>
                        Coordenadas: (Lat: ${latitude}, Lng: ${longitude})`
                    ;
                    document.getElementById("localizacao_obs").innerHTML = "<b>Sua Localização pode não estar precisa</b>";
                    obterCEP(latitude, longitude); // se quiser seguir com isso
                } else {
                    document.getElementById("localizacao_obs").innerHTML = "<b>Não foi possível determinar a localização via IP.</b>";
                    mostrarCamposAlternativos();
                }
            })
            .catch(() => {
                document.getElementById("localizacao_obs").innerHTML = "<b>Erro ao tentar localizar via IP.</b>";
             document.getElementById("localizacao").textContent =
                    "Erro ao tentar localizar via IP.";
                mostrarCamposAlternativos();
            });
        }

        function obterLocalizacao() {

            document.getElementById("localizacao_obs").textContent = "Localizando, aguarde...";
            document.getElementById("localizacao_obs").style.display = "block";
            document.getElementById("localizacao_btn").style.display = "none";


            if (!navigator.geolocation) {
                document.getElementById("localizacao_obs").textContent = "<b>Geolocalização não suportada pelo navegador.</b>";
                document.getElementById("localizacao_btn").style.display = "block";
                //mostrarCamposAlternativos();
                obterLocalizacaoPorIP();
                return;
            }
            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    const { latitude, longitude } = pos.coords;
                    document.getElementById("localizacao").textContent = `Localização: Lat ${latitude}, Lng ${longitude}`;
                    document.getElementById("localizacao_obs").textContent = "GPS";
                    document.getElementById("localizacao_btn").style.display = "none";
                    obterCEP(latitude, longitude);
                },
                (erro) => {
                    console.warn("Erro ao obter geolocalização:", erro.message);
                    document.getElementById("localizacao_obs").textContent = "<b>Não foi possível obter a localização.</b>";
                    document.getElementById("localizacao_btn").style.display = "block";
                    
                    mostrarCamposAlternativos();
                    obterLocalizacaoPorIP();
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }
            );
        }

        function mostrarCamposAlternativos() {
            document.getElementById("div_municipio_posto").style.display = "block";
            document.getElementById("div_bairro_posto").style.display = "block";
        }




        function obterCEP(latitude, longitude) {
            console.log("Chamando função obterCEP com:", latitude, longitude);
            const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}`;
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const cep = data.address.postcode || "Não encontrado";
                    const cidade = data.address.city || "Não encontrado";
                    const bairro = data.address.suburb || "Não encontrado";
                    //console.log(data.address);
                    document.getElementById("cep").innerHTML = `CEP: ${cep} </br>Municipio: ${cidade} </br>Bairro: ${bairro}`;
                    document.getElementById("cep_posto").value = `${cep}`;
                    selecionar(cidade, bairro);
                })
                .catch(() => {
                    document.getElementById("cep_posto").value = "";
                    document.getElementById("cep").textContent = "Erro ao obter o CEP.";
                    document.getElementById("div_municipio_posto").style.display = "block";
                    document.getElementById("div_bairro_posto").style.display = "block";
                });
        }

        function selecionar(cidade, bairro) {
            const select_municipio = document.getElementById("municipio_posto");
            
            //document.getElementById("municipio_posto").disabled = true;
            //document.getElementById("div_municipio_posto").style.display = "none";
            //document.getElementById("div_municipio_posto").hidden = true;



            let municipioEncontrado = false;
            for (let option of select_municipio.options) {
                if (option.text.includes(cidade)) {
                    option.selected = true;
                    municipioEncontrado = true;
                    break;
                }
            }
            if (!municipioEncontrado) {
                let newOption = document.createElement("option");
                newOption.value = cidade;
                newOption.text = cidade;
                select_municipio.appendChild(newOption);
                newOption.selected = true;
            }

            const select_bairro = document.getElementById("bairro_posto");
            
           //document.getElementById("bairro_posto").disabled = true;
            //document.getElementById("div_bairro_posto").style.display = "none";
            //document.getElementById("div_bairro_posto").hidden = true;


            let bairroEncontrado = false;
            for (let option of select_bairro.options) {
                if (option.text.includes(bairro)) {
                    option.selected = true;
                    bairroEncontrado = true;
                    break;
                }
            }
            if (!bairroEncontrado) {
                let newOption = document.createElement("option");
                newOption.value = bairro;
                newOption.text = bairro;
                select_bairro.appendChild(newOption);
                newOption.selected = true;
            }

        }

    </script>




</head>
<body class="container mt-4" onload="detectarOS()">
    <h2 class="mb-4">Consulta de Postos e Combustiveis</h2>
    
    <a href="index.php" class="btn btn-danger rounded-pill position-fixed bottom-0 end-0 m-4 shadow" style="z-index: 1055;">
    Ir para V1
</a>



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
        $municipio = $_POST['municipio_posto'] ?? '';
        $bairro = $_POST['bairro_posto'] ?? '';
        $produto = $_POST['produto_posto'] ?? '';
        $cep = $_POST['cep_posto'] ?? '';

        // Mantém apenas os 5 primeiros dígitos do CEP
        $cepBase = substr($cep, 0, 5);
        $cepSubSetor = substr($cep, 0, 4);
        $cepSetor = substr($cep, 0, 3);
        $cepSubRegiao = substr($cep, 0, 2);

        $queryBase = "WITH dados_filtrados AS (
            SELECT 
                nome_estabelecimento,
                bandeira_revenda,
                cep_revenda, 
                endereco_revenda,
                cnpj_revenda, 
                bairro_revenda, 
                produto, 
                FORMAT_TIMESTAMP('%d/%m/%Y', data_coleta) AS DIA, 
                'ANP' AS FONTE, 
                preco_venda,
                CONCAT(PRECO_venda,' (', unidade_medida,')') As VENDA, 
                data_coleta,
                SAFE_CAST(LEFT(cep_revenda, 5) AS INT64) AS cep_numerico,
                ABS(SAFE_CAST(LEFT(cep_revenda, 5) AS INT64) - $cepBase) AS proximidade,
                ROW_NUMBER() OVER (
                    PARTITION BY endereco_revenda, produto 
                    ORDER BY data_coleta DESC, preco_venda ASC
                ) AS ranking
            FROM `basedosdados.br_anp_precos_combustiveis.microdados` 
            WHERE data_coleta >= '" . date('Y-m-01', strtotime('-2 months')) . "'";

        $resultados = [];
        $queryFinal = "";
                
        if (!empty($cep)) {
            $query = $queryBase . " AND (cep_revenda LIKE '$cep%' OR cep_revenda LIKE '$cepSubSetor%' OR cep_revenda LIKE '$cepSetor%' OR cep_revenda LIKE '$cepSubRegiao%')";

            if (!empty($produto)) {
                $query .= " AND UPPER(produto) = UPPER('$produto')";
            }

            $query .= ") 
                SELECT 
                    --nome_estabelecimento AS NOME,  
                    cep_revenda AS MAPA,
                    endereco_revenda AS ENDERECO, 
                    bandeira_revenda As BANDEIRA,
                    cnpj_revenda AS CNPJ, 
                    --cep_revenda AS CEP, 
                    produto AS PRODUTO,
                    preco_venda AS PRECO,
                    VENDA, 
                    DIA, 
                    FONTE,
                    proximidade
                FROM dados_filtrados
                WHERE ranking = 1
                ORDER BY proximidade ASC, PRECO ASC, data_coleta DESC
                LIMIT 20";

            $queryResults = $bigQuery->runQuery($bigQuery->query($query));

            if (!empty($queryResults->rows())) {
                $resultados = $queryResults->rows();
                $queryFinal = $query; 
            }
        } else {
            $query = $queryBase; // Começa com a base

            // Adiciona filtros conforme necessário
            $filtros = [];
            if (!empty($municipio)) {
                $filtros[] = "id_municipio LIKE '$municipio'";
            }
            if (!empty($bairro)) {
                $filtros[] = "bairro_revenda LIKE '$bairro'";
            }
            if (!empty($produto)) {
                $filtros[] = "UPPER(produto) = UPPER('$produto')";
            }

            // Se houver filtros, adicioná-los à query
            if (!empty($filtros)) {
                $query .= " AND " . implode(" AND ", $filtros);
            }
        
            $query .= ") 
                SELECT 
                    nome_estabelecimento AS NOME, 
                    cep_revenda AS MAPA, 
                    cep_revenda AS CEP,
                    --cnpj_revenda AS CNPJ, 
                    produto AS PRODUTO, 
                    DIA, 
                    FONTE,  
                    preco_venda AS preco_minimo
                FROM dados_filtrados
                WHERE ranking = 1
                ORDER BY preco_minimo ASC, data_coleta DESC
                LIMIT 10";
        
            $queryResults = $bigQuery->runQuery($bigQuery->query($query));
        
            if (!empty($queryResults->rows())) {
                $resultados = $queryResults->rows();
                $queryFinal = $query;
            }
        }


        // Se não encontrou nada, busca pelo município


    
        //echo "<p class='mb-4'><strong>Consulta SQL:</strong> <br><code>{$queryFinal}</code></p>";
        //echo "<button class='btn btn-lg btn-danger' onclick='history.back()'>Voltar</button>";
    
        
    

        echo '<div class="card text-center">';
        echo '  <div class="card-header"><button class="btn btn-lg btn-danger" onclick="history.back()">Voltar</button></div>';
        echo '  <div class="card-body">';
        //echo '    <h5 class="card-title">Special title treatment</h5>';
        //echo '    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>';
        //echo '    <a href="#" class="btn btn-primary">Go somewhere</a>';
        // Exibição da tabela
        echo '<div class="table-responsive">';
        echo "<table class='table table-striped mt-4'><thead><tr>";
        if ($queryResults->isComplete()) {
            echo '<div class="container mt-3">';
            echo '<div class="table-responsive">'; // Permite rolagem em telas pequenas
            echo '<table class="table table-striped table-bordered table-hover">'; // Tabela com Bootstrap
            echo '<thead class="table-dark">';
    
            // Inicializa a variável antes do loop
            $firstRow = true;
            
            // Verifica se houve resultados antes de exibir o cabeçalho
            if (iterator_count($queryResults) === 0) {
                echo "<tr><td colspan='5' class='text-center'>Nenhum dado encontrado</td></tr>";

                // Supondo que os dados venham via POST
                $municipio = isset($_POST['municipio_posto']) ? $_POST['municipio_posto'] : '';
                $bairro = isset($_POST['bairro_posto']) ? $_POST['bairro_posto'] : '';
                $produto = isset($_POST['produto_posto']) ? $_POST['produto_posto'] : '';
                $cep = isset($_POST['cep_posto']) ? $_POST['cep_posto'] : '';

                // Criando a mensagem formatada
                $mensagem = "Olá! Sem resultado para os dados informados:\n\n";
                $mensagem .= "Município: $municipio\n";
                $mensagem .= "Bairro: $bairro\n";
                $mensagem .= "Produto: $produto\n";
                $mensagem .= "CEP: $cep\n";

                // Criando a consulta SQL
                $sql = "$queryFinal";

                // Adicionando a consulta SQL na mensagem
                $mensagem .= "Consulta SQL:\n$sql";



                // Codificando a mensagem para URL
                $mensagem = urlencode($mensagem);

                // Número do WhatsApp
                $numero = "5521965543094";

                // Link do WhatsApp
                $link_whatsapp = "https://wa.me/$numero?text=$mensagem";


                echo "<tr><td><a class='btn  btn-warning btn-lg btn-block' href=".$link_whatsapp." target='_blank'>Reportar</a></td></tr>";
                //$municipio = $_POST['municipio_posto'];
                //$bairro = $_POST['bairro_posto'];
                //$produto = $_POST['produto_posto'];
                //$cep = $_POST['cep_posto'];
            } else {
                foreach ($queryResults as $row) {
                    if ($firstRow) {
                        foreach ($row as $key => $value) {
                            if($key === 'proximidade'){
                                echo "<th>Fator de Proximidade postal</th>";
                            }else if($key === 'PRECO'){

                            }else if($key === 'ENDERECO'){

                            }else if($key === 'CNPJ'){

                            }else{
                                echo "<th>$key</th>";
                            }
                        }
                        echo "</tr></thead><tbody>";
                        $firstRow = false;
                    }
                    if(isset($_SESSION['id_pessoa'])){//se o telefone estiver no cadastro, deve acessar o mapa instantaneamente
                        echo "<form method='POST'>";
                    }else{
                        //possivekmente pedir para cadastrar o telefone
                        echo "<form>";
                    }
                    echo "<tr>";
                    foreach ($row as $key => $value) {
                        if ($key === 'MAPA') {
                            if(isset($_SESSION['id_pessoa'])){
                                echo "<td>
                                    <input type='submit' class='btn btn-sm btn-success' id='localiza_posto' name='localiza_posto' value='Ir ao Posto'>
                                    <input type='hidden' id='cep_posto' name='cep_posto' value='$value'>
                                "; 
                            }else{
                                echo "<td>
                                    <a id='btn_maps' name='btn_maps' class='btn btn-sm btn-success' href='https://www.google.com/maps/dir/?api=1&destination=" . urlencode($value)  ."' target='_blank'>Google Maps</a>
                                ";
                            }
                        }else if($key === 'ENDERECO'){
                            echo "<span style='font-size: 10px;'>$value</span>
                                <input type='hidden' id='endereco_posto' name='endereco_posto' value='$value'>
                            </td>";
                        }else if($key === 'CNPJ'){
                            echo "<input type='hidden' id='cnpj_posto' name='cnpj_posto' value='$value'>";
                        }else if ($key === 'BANDEIRA') {
                            $bandeira = strtolower(trim($value));
                            $caminhoBase = "img/bandeiras/";
                            $extensoes = ['svg', 'png', 'jpg', 'jpeg', 'webp'];
                        
                            $arquivoImagem = null;
                        
                            // Verifica se existe o arquivo com alguma das extensões
                            foreach ($extensoes as $ext) {
                                //$possivelCaminho = $caminhoBase . $bandeira . '.' . $ext;

                                $possivelCaminho = strtolower($caminhoBase . $bandeira . '.' . $ext);

                                if (file_exists($possivelCaminho)) {
                                    $arquivoImagem = $possivelCaminho;
                                    break;
                                }
                            }
                        
                            echo "<td>";
                        
                            if ($arquivoImagem) {
                                echo "<img src='$arquivoImagem' alt='$value' style='height:40px; max-width:100px; vertical-align:middle;'>";
                            } else {
                                echo "<span>$value</span>";
                            }
                        
                            echo "</td>";
                        }else if($key === 'PRODUTO'){
                            if($value === 'Glp'){
                                echo "
                                    <td><span style='cursor: pointer; text-decoration: underline;' data-bs-toggle='modal' data-bs-target='#modalProdutoGlp'>
                                        $value<input type='hidden' id='produto_posto' name='produto_posto' value='$value'>
                                    </span></td>";
                            }else{
                                echo "<td>$value<input type='hidden' id='produto_posto' name='produto_posto' value='$value'></td>";
                            }
                        }else if($key === 'PRECO'){
                                
                        }else if($key === 'VENDA'){
                            echo "
                            <td><span style='cursor: pointer; text-decoration: underline;' data-bs-toggle='modal' data-bs-target='#modalPrecoLeitura'>
                                $value
                                </span> <input type='hidden' id='preco_posto' name='preco_posto' value='$value'></td>";
                        }else if($key === 'DIA') {
                            echo "
                                <td><span style='cursor: pointer; text-decoration: underline;' data-bs-toggle='modal' data-bs-target='#modalDataLeitura'>
                                    $value
                                </span></td>";
                        }else if($key === 'proximidade'){
                            echo "<td>".$value."</td>";
                        }else if($key === 'FONTE'){
                            if($value === 'ANP'){
                                echo "<td>
                                    <a style='text-decoration: none;' href='https://basedosdados.org/dataset/6ea3e28a-42be-401a-a066-ad87ca931e69?table=3a7cb29a-0bdf-4f44-bab1-d27872e565ff' target='_blank'>ANP</a>
                                    <!--<a style='text-decoration: none;' href='https://www.gov.br/anp/pt-br/centrais-de-conteudo/dados-abertos/criticas-sugestoes-reuso-dados-abertos' target='_blank'>ANP</a>-->
                                </td>";
                            }else{
                                echo "<td>$value</td>";
                            }
                        }else {
                            echo "<td>$value</td>";
                        }
                    }
                    echo "</tr>";
                    echo "</form>";
                }
            }
    
            echo "</tbody></table></div>"; // Fecha a tabela responsiva
        } else {
            echo "<div class='container mt-3'><p class='alert alert-danger'>A consulta não foi concluída.</p></div>";
            echo "</thead></table>";
        }
        echo '</div>';
    
        



        //echo '  </div>';
        //echo '  <div class="card-footer text-muted">Feito Por <b>Gabriel Amorim</b></div>';

        echo '<div class="card-footer text-muted"><span style="cursor: pointer; text-decoration: underline;" data-bs-toggle="modal" data-bs-target="#modalCurriculo">
                        Feito Por <b>Gabriel Amorim</b>
                      </span></div>';

        echo '
        <div class="card-footer text-muted">
                      <span style="cursor: pointer; text-decoration: underline;" data-bs-toggle="modal" data-bs-target="#modalPrivacidade">
                        Política de Privacidade
                      </span> &nbsp;|&nbsp;
                      <span style="cursor: pointer; text-decoration: underline;" data-bs-toggle="modal" data-bs-target="#modalTermos">
                        Termos e Condições
                      </span>
                    </div>
        ';

        echo '</div>';



        //echo "<p class='mb-4'><strong>Consulta SQL:</strong> <br><code>{$queryFinal}</code></p>";
    } else {
        //$query = "SELECT DISTINCT b.id_municipio, m.sigla_uf, m.nome AS nome_municipio FROM `basedosdados.br_anp_precos_combustiveis.microdados` AS b 
        //          JOIN `basedosdados.br_bd_diretorios_brasil.municipio` AS m ON b.id_municipio = m.id_municipio ORDER BY m.sigla_uf ASC, m.nome ASC";
        //$queryResults = $bigQuery->runQuery($bigQuery->query($query));
        ?>


        <div class="card text-center">
            <div class="card-header">
                <p id="localizacao_obs">...</p>
                <button id="localizacao_btn" class="btn btn-warning btn-lg btn-block" onclick="obterLocalizacao()">Obter Localização</button>
            </div>
            <div class="card-body">
                
                <div id="login_google">        
                    
                    <div class="text-center mt-3" style="display: flex; justify-content: center; align-items: center; height: 50px;" >
                        <div id="g_id_onload"
                            data-client_id="107976644534-8knc18ps4i830labkk0petk6a7doo3pa.apps.googleusercontent.com"
                            data-callback="handleCredentialResponse"
                            data-auto_prompt="false">
                        </div>
                        <div class="g_id_signin" data-type="standard"></div>
                    </div>

                    <script src="https://accounts.google.com/gsi/client" async defer></script>
                    <script>
                        function handleCredentialResponse(response) {
                            // Decodifica o JWT para obter informações do usuário
                            const data = parseJwt(response.credential);
                            console.log("Usuário logado:", data);
                        
                            // Exibir informações na tela (opcional)
                            //alert("id: " + data.sub + " Bem-vindo, " + data.name + "!\nEmail: " + data.email);
                        
                            // Enviar para o backend via AJAX (opcional)
                            fetch("pages/samples/login_google.php", {
                                method: "POST",
                                headers: { "Content-Type": "application/json" },
                                body: JSON.stringify({id: data.sub, email: data.email, name: data.name, picture: data.picture })
                            })

                            .then(response => response.json())

                            .then(result => {
                                if (result.success) {
                                    //window.location.href = "../dashboard/index.php"; // Redireciona após login
                                } else {
                                    //alert("Erro no login.");
                                    location.href = `pages/samples/register.php?id_google=${encodeURIComponent(data.sub)}&name=${encodeURIComponent(data.name)}&email=${encodeURIComponent(data.email)}`;
                                    //location.href="register.php";
                                }
                            });

                        }

                        // Função para decodificar JWT (JSON Web Token)
                        function parseJwt(token) {
                            var base64Url = token.split('.')[1];
                            var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
                            var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
                                return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
                            }).join(''));
                            return JSON.parse(jsonPayload);
                        }
                    </script>

                </div>

                <div style="display:none;">        
                    <h5 class="card-title" id="localizacao">Localização: Aguardando...</h5>
                    <p class="card-text" id="resultado">Detectando...</p>
                    <p class="card-text" id="cep">Obtendo CEP...</p>
                </div>
                <form method="POST">
                    <div class="col-auto" id="div_cep_posto" style="display: block;">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">CEP</div>
                            </div>
                            <input type="text" class="form-control" id="cep_posto" name="cep_posto">
                        </div>
                    </div>
                    <div class="form-group row" id="div_municipio_posto" style="display: block;">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Município</div>
                            </div>
                            <select id="municipio_posto" name="municipio_posto" class="form-select" onchange="atualizarBairros()">
                                <option value="">Selecione um município</option>
                                <option value="3304557">Rio de Janeiro RJ</option>
                                <?php //foreach ($queryResults as $row) {
                                    //echo "<option value='{$row['id_municipio']}'>{$row['nome_municipio']} ({$row['sigla_uf']})</option>";
                                //} ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="div_bairro_posto" style="display: block;">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Bairro</div>
                            </div>
                            <select id="bairro_posto" name="bairro_posto" class="form-select">
                                <option value="">Todos</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Produto</div>
                            </div>
                            <select id="produto_posto" name="produto_posto" class="form-select">
                                <option value="">Todos</option>
                                <option value="Gnv">Gnv</option>
                                <option value="Etanol">Etanol</option>
                                <option value="Gasolina">Gasolina</option>
                                <option value="Gasolina Aditivada">Gasolina Aditivada</option>
                                <option value="Diesel">Diesel</option>
                                <option value="Diesel S10">Diesel S10</option>
                                <option value="Glp">GLP - Gás de Cozinha</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" id="consulta_posto" name="consulta_posto" class="btn btn-success">Consultar</button>
                </form>
            </div>
            <!--<div class="card-footer text-muted">
                Feito Por <b>Gabriel Amorim</b>
            </div>-->


            <div class="card-footer text-muted">
                <!--<span style="cursor: pointer; text-decoration: underline;" data-bs-toggle="modal" data-bs-target="#modalCurriculo">-->
                    Feito Por <b>Gabriel Amorim</b>
                <!--</span>-->
            </div>
            


            <div class="card-footer text-muted">
              <span style="cursor: pointer; text-decoration: underline;" data-bs-toggle="modal" data-bs-target="#modalPrivacidade">
                Política de Privacidade
              </span> &nbsp;|&nbsp;
              <span style="cursor: pointer; text-decoration: underline;" data-bs-toggle="modal" data-bs-target="#modalTermos">
                Termos e Condições
              </span>
            </div>






            


        </div>


        




        
    <?php } ?>


    <?php
if (isset($_SESSION['id_pessoa'])) {
    echo '<script>
        document.getElementById("login_google").style.display = "none";
        
    </script>';
} else {
    echo '<script>
        document.getElementById("login_google").style.display = "block";
        
    </script>';
}
?>


    <div class="modal fade" id="modalCurriculo" aria-hidden="true" aria-labelledby="modalCurriculoLabel" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCurriculoLabel">Currículo - Gabriel Amorim</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body" style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
                <!--<h3>Gabriel Amorim</h3>-->
                <h5><strong>Área:</strong> Engenheiro Computacional</h5>
                <p><strong>Contato:</strong> <a href="mailto:amorimgg7@gmail.com">amorimgg7@gmail.com</a> | <a href="tel:+5521965543094">(21) 96554-3094</a></p>

                <h4>Formação Acadêmica</h4>
                <ul>
                    <li><b>Manutenção e Suporte em Informática</b> - FAETEC (Fundação de Apoio à Escola Técnica) - 2017 a 2019</li>
                    <li><b>Engenharia da Computação</b> - UVA (Universidade Veiga de Almeida) - Cursando desde 2023</li>
                </ul>

                <h4>Habilidades</h4>
                <ul>
                    <li>Suporte técnico, Sistemas ERP, Redes de Computadores, Programação em C/C++, PHP, SQL, Arduino, ESP32...</li>
                </ul>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <small class="text-muted">Atualizado em 10/04/2025</small>
                <button class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
    </div>





    <div class="modal fade" id="modalPrivacidade" aria-hidden="true" aria-labelledby="modalPrivacidadeLabel" tabindex="-1">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalPrivacidadeLabel">Política de Privacidade</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
          </div>
          <div class="modal-body" style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
          <h2>Privacidade em Primeiro Lugar</h2>
<p>No <strong>Onde Abastecer</strong>, levamos sua privacidade a sério. Quando você acessa o site, pedimos permissão para usar sua localização atual com o único propósito de mostrar os postos de combustível mais próximos. Essa informação <strong>não é armazenada</strong> e <strong>não é compartilhada</strong> com ninguém.</p>             

<h4>Coleta Temporária</h4>
<p>Seu navegador nos fornece a localização atual apenas enquanto você estiver no site. Assim que você fecha a aba ou sai da página, essa informação é automaticamente descartada.</p>

<h4>Login com Google</h4>
<p>Para facilitar o acesso, oferecemos a opção de login via Google. Ao fazer login, coletamos e armazenamos com segurança as seguintes informações fornecidas pela sua conta Google:</p>
<ul>
  <li>Nome</li>
  <li>Email</li>
  <li>Foto de perfil (opcional)</li>
  <li>Identificador único do Google (<em>key_google</em>)</li>
</ul>
<p>Essas informações são utilizadas exclusivamente para identificar você no sistema e permitir logins futuros com praticidade. Não utilizamos esses dados para nenhum outro fim e jamais os compartilhamos com terceiros.</p>

<h4>Cadastro Complementar</h4>
<p>Após o login, você pode complementar seu cadastro com dados como telefone, que também são armazenados com segurança e não são compartilhados.</p>

<h4>Cookies Essenciais</h4>
<p>Utilizamos apenas cookies básicos para garantir o funcionamento adequado do site. Não realizamos rastreamento de comportamento ou uso comercial de seus dados.</p>

<h4>Segurança</h4>
<p>Aplicamos boas práticas para garantir que nenhuma informação sensível seja exposta. Nosso foco é funcionalidade, não coleta de dados.</p>

<h4>Fale Conosco</h4>
<p>Para qualquer dúvida sobre os termos, entre em contato: <a href="mailto:amorimgg7@gmail.com">C O N T A T O</a></p>

          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modalTermos" aria-hidden="true" aria-labelledby="modalTermosLabel" tabindex="-1">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTermosLabel">Termos e Condições de Uso</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
          </div>
          <div class="modal-body" style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
          <h2>Bem-vindo ao Onde Abastecer</h2>
                <p>Ao utilizar este site, você concorda com os termos descritos abaixo. Nosso objetivo é fornecer informações atualizadas sobre postos de combustível próximos a você, de forma simples e gratuita.</p>                  

                <h4>Uso do Serviço</h4>
                <p>Este site é oferecido apenas para fins informativos. Os dados de localização e preços de combustível são aproximados e sujeitos a alterações. Não garantimos a disponibilidade ou precisão absoluta das informações exibidas.</p>

                <h4>Login e Cadastro</h4>
                <p>Oferecemos login via Google para sua conveniência. Ao autenticar-se, você autoriza o armazenamento seguro do seu nome, email e identificador Google (<em>key_google</em>) para fins exclusivos de autenticação. Você pode também fornecer voluntariamente seu telefone, que será armazenado para completar seu perfil. O uso dessas informações é restrito ao funcionamento do serviço, e não há compartilhamento com terceiros.</p>

                <h4>Limitação de Responsabilidade</h4>
                <p>Não nos responsabilizamos por decisões tomadas com base nas informações do site, como valores de combustível ou rotas sugeridas.</p>

                <h4>Alterações nos Termos</h4>
                <p>Estes termos podem ser atualizados periodicamente. Ao continuar utilizando o site, você aceita automaticamente os novos termos.</p>

                <h4>Contato</h4>
                <p>Para qualquer dúvida sobre os termos, entre em contato: <a href="mailto:amorimgg7@gmail.com">C O N T A T O</a></p>

          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          </div>
        </div>
      </div>
    </div>
<!--modalProdutoGlp-->

    <div class="modal fade" id="modalPrecoLeitura" aria-hidden="true" aria-labelledby="modalPrecoLeituraLabel" tabindex="-1">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalPrecoLeituraLabel">Preço Lido</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
          </div>
          <div class="modal-body" style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
            <h2>Ultima leitura de preço realizada</h2>
            <p>A coluna "DATA" da tabela mostra a ultima leitura realizada, acompanhando a coluna de fonte, mostra o responsável por fornecer a informação.</p>                  
            <h4>Fonte</h4>
            <p>Estamos limitados a receber informações apenas do ANP(Agencia Nacional de Petróleo e Gás)<!--, mas em breve será permitido voce informar a plataforma o preço praticado-->.</p>
            <p>Para qualquer dúvida sobre os termos, entre em contato: <a href="mailto:amorimgg7@gmail.com">C O N T A T O</a></p>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modalDataLeitura" aria-hidden="true" aria-labelledby="modalDataLeituraLabel" tabindex="-1">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalDataLeituraLabel">Data de Leitura</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
          </div>
          <div class="modal-body" style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
            <h2>Ultima leitura realizada</h2>
            <p>A coluna "DATA" da tabela mostra a ultima leitura realizada, acompanhando a coluna de fonte, mostra o responsável por fornecer a informação.</p>                  
            <h4>Fonte</h4>
            <p>Estamos limitados a receber informações apenas do ANP(Agencia Nacional de Petróleo e Gás)<!--, mas em breve será permitido voce informar a plataforma o preço praticado-->.</p>
            <p>Para qualquer dúvida sobre os termos, entre em contato: <a href="mailto:amorimgg7@gmail.com">C O N T A T O</a></p>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modalProdutoGlp" aria-hidden="true" aria-labelledby="modalProdutoGlpLabel" tabindex="-1">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalProdutoGlpLabel">GLP</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body" style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
              <h2>GLP – O famoso gás de cozinha</h2>
              <p>O GLP (Gás Liquefeito de Petróleo) é aquele gás usado no botijão pra cozinhar. Ele também é usado em aquecedores e alguns equipamentos industriais.</p>

              <p>Mas atenção: Usar GLP em carros é proibido no Brasil! A <strong><a href="https://www.planalto.gov.br/ccivil_03/leis/l8176.htm" target="_blank">Lei nº 8.176/1991</a></strong> considera isso crime contra a ordem econômica.</p>

              <h4>Sobre os dados</h4>
              <p>As informações de preço vêm da ANP (Agência Nacional do Petróleo). A coluna "DATA" mostra a última atualização e "FONTE" indica quem forneceu.</p>

              <p>Dúvidas ou sugestões? Fala com a gente: <a href="mailto:amorimgg7@gmail.com">C O N T A T O</a></p>
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
          </div>
        </div>
    </div>




   <!-- Full screen modal -->



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>