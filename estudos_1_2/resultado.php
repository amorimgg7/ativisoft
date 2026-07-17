<?php

session_start();



if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $indice = $_SESSION['indice'];


    $q = $_SESSION['prova'][$indice];



    $resposta = intval($_POST['resposta']);



    if (!isset($_SESSION['categorias'][$q['categoria']])) {


        $_SESSION['categorias'][$q['categoria']] = [

            'acertos'=>0,

            'total'=>0

        ];

    }



    $_SESSION['categorias'][$q['categoria']]['total']++;





    if ($resposta == $q['correta']) {


        $_SESSION['acertos']++;


        $_SESSION['categorias'][$q['categoria']]['acertos']++;


    }

    else {


        $_SESSION['erros'][] = [


            'pergunta'=>$q['pergunta'],


            'resposta'=>$q['opcoes'][$q['correta']],


            'explicacao'=>$q['explicacao']


        ];


    }



    $_SESSION['indice']++;



    header('Location: prova.php');

    exit;


}




if (!isset($_SESSION['prova'])) {

    header('Location:index.php');

    exit;

}




$total = count($_SESSION['prova']);



$acertos = $_SESSION['acertos'] ?? 0;



$percentual = round(

    ($acertos/$total)*100,

    1

);



$nota = round(

    ($acertos/$total)*10,

    1

);



$erros = $total - $acertos;


?>



<!doctype html>

<html lang="pt-br">


<head>


<meta charset="utf-8">


<meta name="viewport" content="width=device-width, initial-scale=1">



<title>Resultado</title>



<link 
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">



<link rel="stylesheet" href="assets/style.css">


</head>




<body>



<div class="container py-4">





    <div class="card shadow-lg border-0 rounded-4 mb-4">



        <div class="card-body text-center">



            <h1 class="text-primary fw-bold mb-4">

                🥋 Resultado Final

            </h1>





            <div class="display-3 fw-bold text-primary">

                <?= $nota ?>

                <span class="fs-3">

                    /10

                </span>

            </div>





            <div class="row mt-4 g-3">



                <div class="col-12 col-md-4">

                    <div class="card bg-success text-white">

                        <div class="card-body">

                            <h3>

                                <?= $acertos ?>

                            </h3>


                            Acertos

                        </div>

                    </div>

                </div>





                <div class="col-12 col-md-4">

                    <div class="card bg-danger text-white">

                        <div class="card-body">


                            <h3>

                                <?= $erros ?>

                            </h3>


                            Erros


                        </div>

                    </div>

                </div>






                <div class="col-12 col-md-4">


                    <div class="card bg-primary text-white">


                        <div class="card-body">


                            <h3>

                                <?= $percentual ?>%

                            </h3>



                            Aproveitamento


                        </div>


                    </div>


                </div>



            </div>






            <div class="progress mt-4" style="height:25px;">



                <div 

                class="progress-bar"

                role="progressbar"

                style="width: <?= $percentual ?>%;"

                >

                    <?= $percentual ?>%

                </div>



            </div>



        </div>


    </div>








    <!-- CATEGORIAS -->

    <div class="card shadow-sm border-0 rounded-4 mb-4">


        <div class="card-body">



            <h2 class="text-primary mb-4">

                📚 Desempenho por categoria

            </h2>




            <?php foreach ($_SESSION['categorias'] as $titulo=>$c): ?>


                <?php

                $catPercentual = round(

                    ($c['acertos']/$c['total'])*100,

                    1

                );

                ?>



                <div class="mb-3">



                    <strong>

                        <?= htmlspecialchars($titulo) ?>

                    </strong>


                    <div class="progress mt-2">


                        <div 

                        class="progress-bar bg-info"

                        style="width:<?= $catPercentual ?>%;"

                        >

                            <?= $catPercentual ?>%

                        </div>


                    </div>


                </div>



            <?php endforeach; ?>



        </div>


    </div>









    <!-- ERROS -->

    <div class="card shadow-sm border-0 rounded-4 mb-4">


        <div class="card-body">



            <h2 class="text-danger mb-4">

                ❌ Questões para revisar

            </h2>





            <?php if(empty($_SESSION['erros'])): ?>



                <div class="alert alert-success">

                    Parabéns! Você acertou todas as questões.

                </div>



            <?php else: ?>





                <?php foreach ($_SESSION['erros'] as $e): ?>



                    <div class="alert alert-danger">



                        <h5 class="fw-bold">


                            <?= htmlspecialchars($e['pergunta']) ?>


                        </h5>




                        <p>

                            <b>

                            Resposta correta:

                            </b>


                            <?= htmlspecialchars($e['resposta']) ?>


                        </p>




                        <p>


                            <b>

                            Explicação:

                            </b>


                            <?= htmlspecialchars($e['explicacao']) ?>


                        </p>




                    </div>




                <?php endforeach; ?>




            <?php endif; ?>



        </div>


    </div>







    <a 

    class="btn btn-primary btn-lg w-100 rounded-3"

    href="index.php"

    >

        🔄 Novo Simulado

    </a>




</div>





<script 

src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">

</script>




</body>


</html>



<?php

session_destroy();

?>