<?php
session_start();
// Tempo máximo da prova (em segundos)
// CONFIGURAÇÕES DO SIMULADO
$_SESSION['quantidadeQuestoes'] = 3;     // Quantas questões serão sorteadas
$tempoTotalProva = 5 * 60;   // Tempo total da prova (5 minutos)
$tempoMaximo = $tempoTotalProva;


// Inicia o cronômetro apenas na primeira pergunta
if (!isset($_SESSION['inicio_prova'])) {
    $_SESSION['inicio_prova'] = time();
}

$tempoRestante = $tempoMaximo - (time() - $_SESSION['inicio_prova']);

if ($tempoRestante <= 0) {
    header("Location: resultado.php");
    exit;
}

if (!isset($_SESSION['prova'])) {
    header('Location:index.php');
    exit;
}


$indice = $_SESSION['indice'];


if ($indice >= count($_SESSION['prova'])) {
    header('Location:resultado.php');
    exit;
}


$questao = $_SESSION['prova'][$indice];

echo '

';
// ===============================
// NOME DO SIMULADO PELO JSON
// ===============================

function gerarNomeSimulado()
{

    if (!isset($_SESSION['arquivo_simulado'])) {

        return "Simulado Taekwon-Do";

    }


    $nomeArquivo = $_SESSION['arquivo_simulado'];


    // remove extensão
    $nomeArquivo = str_replace(".json", "", $nomeArquivo);


    // separa faixas
    $faixas = explode("_", $nomeArquivo);



    foreach ($faixas as &$faixa) {

        $faixa = ucfirst(strtolower($faixa));

    }



    return "Simulado (" . implode(" → ", $faixas) . ")";

}



$nomeSimulado = gerarNomeSimulado();





// ===============================
// EMBARALHAR OPÇÕES
// MANTENDO A CORRETA
// ===============================

$opcoesEmbaralhadas = [];


foreach ($questao['opcoes'] as $index => $texto) {


    $opcoesEmbaralhadas[] = [

        "indice_original" => $index,

        "texto" => $texto

    ];

}



shuffle($opcoesEmbaralhadas);


?>



<!doctype html>

<html lang="pt-br">


<head>


<meta charset="utf-8">


<meta name="viewport" content="width=device-width, initial-scale=1">


<title>

<?= htmlspecialchars($nomeSimulado) ?>

</title>



<!-- Bootstrap -->

<link 
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">



<!-- Seu CSS -->

<link rel="stylesheet" href="assets/style.css">



</head>



<body>

<div id="barraTempo" class="bg-primary text-white shadow-sm sticky-top">
    <div class="container d-flex justify-content-center align-items-center" style="height:40px;">
        <span class="me-2">⏱</span>
        <span id="cronometro" style="font-size:20px;font-weight:700;">
            00:00
        </span>
    </div>
</div>


<div class="container py-4">

<h6 class="titulo-simulado text-center mb-1">

                <?= htmlspecialchars($nomeSimulado) ?>

            </h6>

    <div class="card shadow-lg border-0 rounded-4 mx-auto prova-card">



        <div class="card-body">



            <!-- NOME DO SIMULADO -->

            





            <!-- CONTADOR -->

            <h2 class="text-center text-secondary mb-1">

                Pergunta 

                <?= $indice + 1 ?>

                de 

                <?= count($_SESSION['prova']) ?>


            </h2>





            <!-- CATEGORIA -->

            <div class="categoria mb-4">


                <?= htmlspecialchars($questao['categoria']) ?>


            </div>





            <!-- PERGUNTA -->


            <h3 class="mb-4">


                <?= htmlspecialchars($questao['pergunta']) ?>


            </h3>







            <form action="resultado.php" method="post">





                <?php foreach ($opcoesEmbaralhadas as $opcao): ?>



                    <label class="opcao d-flex align-items-start">



                        <input

                            class="form-check-input me-3 mt-1"

                            type="radio"

                            name="resposta"

                            value="<?= $opcao['indice_original'] ?>"

                            required

                        >



                        <span>


                            <?= htmlspecialchars($opcao['texto']) ?>


                        </span>



                    </label>




                <?php endforeach; ?>







                <button 

                    type="submit"

                    class="btn btn-primary btn-lg w-100 rounded-3 mt-3"

                >

                    Próxima

                </button>





            </form>





        </div>



    </div>




</div>





<script 

src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">

</script>


<script>
let tempo = <?= $tempoRestante ?>;

const cronometro = document.getElementById("cronometro");
const barra = document.getElementById("barraTempo");

function atualizarRelogio() {

    let minutos = Math.floor(tempo / 60);
    let segundos = tempo % 60;

    cronometro.textContent =
        String(minutos).padStart(2, "0") + ":" +
        String(segundos).padStart(2, "0");

    // Remove todas as cores
    barra.classList.remove("bg-success", "bg-warning", "bg-danger");

    // Define a cor conforme o tempo restante
    if (tempo > 30) {
        barra.classList.add("bg-success"); // Verde
    } else if (tempo > 10) {
        barra.classList.add("bg-warning"); // Amarelo
    } else {
        barra.classList.add("bg-danger"); // Vermelho
    }

    if (tempo <= 0) {
        alert("Tempo encerrado!");
        document.querySelector("form").submit();
        return;
    }

    tempo--;
}

atualizarRelogio();

setInterval(atualizarRelogio, 1000);
</script>


</body>


</html>