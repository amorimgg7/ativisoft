<?php

$simulados = [];


foreach (glob('dados/*.json') as $arquivo)
{


    if (basename($arquivo) === 'simulados.json') {

        continue;

    }



    $perguntas = json_decode(

        file_get_contents($arquivo),

        true

    );



    if (!is_array($perguntas)) {

        continue;

    }



    $total = count($perguntas);



    $nomeArquivo = pathinfo(

        basename($arquivo),

        PATHINFO_FILENAME

    );



    $titulo = ucwords(

        str_replace(

            '_',

            ' → ',

            $nomeArquivo

        )

    );




    $simulados[] = [


        'id'=>$nomeArquivo,


        'titulo'=>$titulo,


        'total_perguntas'=>$total,


        'tempo_minutos'=>max(10,$total),


        'questoes_por_prova'=>$total


    ];


}


?>



<!doctype html>

<html lang="pt-br">


<head>


<meta charset="utf-8">


<meta name="viewport" content="width=device-width, initial-scale=1">



<title>

Simulados ITF

</title>



<link 

href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"

rel="stylesheet">



<link rel="stylesheet" href="assets/style.css">


</head>



<body>



<div class="container py-4">





    <!-- CABEÇALHO -->

    <div class="text-center mb-1">

<!--
        <h6 class="display-4 fw-bold text-primary">

            

        </h6>-->



        <p class="text-secondary fs-5">

            🥋 Simulados Taekwon-Do ITF</br>Escolha sua graduação e teste seus conhecimentos

        </p>



    </div>







    <?php if(empty($simulados)): ?>



        <div class="alert alert-warning text-center">

            Nenhum simulado encontrado.

        </div>



    <?php endif; ?>







    <!-- GRID RESPONSIVO -->


    <div class="row g-4">



    <?php foreach($simulados as $s): ?>



        <div class="col-12 col-md-6 col-lg-4">



            <div class="card shadow-sm border-0 rounded-4 h-100">



                <div class="card-body d-flex flex-column">





                    <h2 class="h4 text-primary fw-bold">

                        <?= htmlspecialchars($s['titulo']) ?>

                    </h2>





                    <hr>





                    <p class="mb-2">


                        📚

                        <strong>

                        <?= $s['total_perguntas'] ?>

                        </strong>

                        questões


                    </p>





                    <p class="mb-4">


                        ⏱️

                        <strong>

                        <?= $s['tempo_minutos'] ?>

                        </strong>

                        minutos


                    </p>






                    <a

                    class="btn btn-primary btn-lg rounded-3 mt-auto"

                    href="iniciar.php?id=<?= urlencode($s['id']) ?>"

                    >

                        🥋 Iniciar Simulado

                    </a>





                </div>


            </div>


        </div>





    <?php endforeach; ?>


    </div>





</div>






<script 

src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">

</script>



</body>


</html>