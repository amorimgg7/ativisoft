<script>

  if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
        console.log("Histórico de formulário limpo, evitando duplicidade de informações.");
      }


  window.addEventListener('load', function () {
    document.getElementById('load').style.display = 'none';
  });

  // Garantia extra: esconde após 10 segundos no máximo
  setTimeout(function () {
    document.getElementById('load').style.display = 'none';
  }, 10000); // 10 segundos

</script>
<!--
<footer class="footer" <?php //echo $_SESSION['c_card'];?>>
  <div class="d-sm-flex justify-content-center justify-content-sm-between"<?php //echo $_SESSION['c_card'];?>> 
    <span class="text-muted d-block text-center text-sm-left d-sm-inline-block" <?php //echo $_SESSION['c_card'];?>>AtiviSoft © sistema.ativisoft.com.br 2025</span>
    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center" <?php //echo $_SESSION['c_card'];?>>Version 2.0 | Release: 0.00 | <?php //echo $_SESSION['nome_cliente']  ;?> <br><p><?php //echo "PHP:".phpversion();?></p><h3>B E T A</h3></span>
</div>





</footer>-->



<?php

// ========================================
// FOOTER - ATIVISOFT
// ========================================


// ========================================
// SESSÃO
// ========================================

$cCard = isset($_SESSION['c_card'])
    ? $_SESSION['c_card']
    : '';

$nomeCliente = isset($_SESSION['nome_cliente'])
    ? $_SESSION['nome_cliente']
    : '';


// ========================================
// VERSÃO
// ========================================

$versao = '2.0';
$release = '0.00';


// ========================================
// DESCOBRE A URL DO MONITOR
// ========================================
//
// Este arquivo está em:
//
// partials/_footer.php
//
// O endpoint está em:
//
// partials/footer_status.php
//
// O PHP descobre automaticamente
// o caminho correto.
//

$pastaPartials = __DIR__;

$documentRoot = realpath(
    $_SERVER['DOCUMENT_ROOT']
);

$urlStatus = '';

if ($documentRoot !== false) {

    $caminhoRelativo = str_replace(
        '\\',
        '/',
        str_replace(
            $documentRoot,
            '',
            $pastaPartials
        )
    );

    $urlStatus =
        $caminhoRelativo .
        '/footer_status.php';
}


// ========================================
// FALLBACK
// ========================================

if (empty($urlStatus)) {

    $urlStatus =
        './footer_status.php';

}

?>


<footer
    class="footer"
    <?php echo $cCard; ?>
>

    <div
        class="d-sm-flex justify-content-center justify-content-sm-between"
    >


        <!-- ========================================
             COPYRIGHT
        ========================================= -->

        <span
            class="text-muted d-block text-center text-sm-left d-sm-inline-block"
            <?php echo $cCard; ?>
        >

            AtiviSoft © sistema.ativisoft.com.br 2025

        </span>


        <!-- ========================================
             INFORMAÇÕES
        ========================================= -->

        <span
            class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"
            <?php echo $cCard; ?>
        >


            Version <?php
                echo htmlspecialchars(
                    $versao,
                    ENT_QUOTES,
                    'UTF-8'
                );
            ?>

            |

            Release: <?php
                echo htmlspecialchars(
                    $release,
                    ENT_QUOTES,
                    'UTF-8'
                );
            ?>

            |

            <?php
                echo htmlspecialchars(
                    $nomeCliente,
                    ENT_QUOTES,
                    'UTF-8'
                );
            ?>


            <br>


            <!-- ========================================
                 PHP
            ========================================= -->

            <small>

                PHP:
                <?php
                    echo htmlspecialchars(
                        phpversion(),
                        ENT_QUOTES,
                        'UTF-8'
                    );
                ?>

            </small>


            <br>


            <!-- ========================================
                 STATUS
            ========================================= -->

            <strong id="statusSistema">

                🔄 Verificando...

            </strong>


            <!-- ========================================
                 DETALHES DA ATUALIZAÇÃO
                 
                 Ficam escondidos normalmente.
            ========================================= -->

            <div
                id="detalhesAtualizacao"
                style="display:none;"
            >

                <small id="ultimoArquivo"></small>

                <br>

                <small id="dataAlteracao"></small>

                <br>

                <small id="tempoAlteracao"></small>

            </div>


            <br>


            <!-- ========================================
                 BETA
            ========================================= -->

            <span
                style="
                    font-size:18px;
                    font-weight:bold;
                    letter-spacing:5px;
                "
            >

                BETA

            </span>


        </span>

    </div>

</footer>


<script>

(function () {


    // ========================================
    // ELEMENTOS
    // ========================================

    const status =
        document.getElementById(
            'statusSistema'
        );

    const detalhes =
        document.getElementById(
            'detalhesAtualizacao'
        );

    const arquivo =
        document.getElementById(
            'ultimoArquivo'
        );

    const data =
        document.getElementById(
            'dataAlteracao'
        );

    const tempo =
        document.getElementById(
            'tempoAlteracao'
        );


    // ========================================
    // URL DO ENDPOINT
    // ========================================

    const urlStatus =
        <?php
            echo json_encode(
                $urlStatus
            );
        ?>;


    // ========================================
    // ÚLTIMO TIMESTAMP CONHECIDO
    // ========================================

    let ultimoTimestamp = null;


    // ========================================
    // VERIFICAR STATUS
    // ========================================

    async function verificarStatus()
    {

        try {


            // ========================================
            // CONSULTA SERVIDOR
            // ========================================

            const resposta =
                await fetch(
                    urlStatus +
                    '?nocache=' +
                    Date.now(),
                    {
                        method: 'GET',

                        cache: 'no-store',

                        headers: {
                            'Cache-Control':
                                'no-cache'
                        }
                    }
                );


            // ========================================
            // ERRO HTTP
            // ========================================

            if (!resposta.ok) {

                throw new Error(
                    'HTTP ' +
                    resposta.status
                );

            }


            // ========================================
            // JSON
            // ========================================

            const dados =
                await resposta.json();


            console.log(
                'AtiviSoft Monitor:',
                dados
            );


            // ========================================
            // TIMESTAMP
            // ========================================

            const timestamp =
                Number(
                    dados.timestamp
                );


            // ========================================
            // NOVA ALTERAÇÃO
            // ========================================

            const novaAlteracao =

                ultimoTimestamp !== null &&

                timestamp >
                ultimoTimestamp;


            // ========================================
            // SISTEMA ATUALIZANDO
            // ========================================

            if (
                dados.status ===
                'atualizando'
            ) {


                status.innerHTML =
                    '🔄 Atualizando...';


                detalhes.style.display =
                    'block';


                // ========================================
                // ARQUIVO
                // ========================================

                arquivo.innerHTML =
                    '📄 Último: ' +
                    '<strong>' +
                    dados.arquivo +
                    '</strong>';


                // ========================================
                // DATA
                // ========================================

                data.innerHTML =
                    '🕐 ' +
                    dados.data;


                // ========================================
                // TEMPO
                // ========================================

                const segundos =
                    Number(
                        dados.segundos
                    );


                if (
                    segundos <= 0
                ) {

                    tempo.innerHTML =
                        '⚡ Alterado agora';

                }

                else if (
                    segundos === 1
                ) {

                    tempo.innerHTML =
                        '⏱️ Há 1 segundo';

                }

                else {

                    tempo.innerHTML =
                        '⏱️ Há ' +
                        segundos +
                        ' segundos';

                }

            }


            // ========================================
            // SISTEMA ONLINE
            // ========================================

            else {

                status.innerHTML =
                    '🟢 Sistema online';


                detalhes.style.display =
                    'none';

            }


            // ========================================
            // NOVA ALTERAÇÃO DETECTADA
            // ========================================

            if (
                novaAlteracao
            ) {

                status.innerHTML =
                    '🚀 NOVA ATUALIZAÇÃO!';


                detalhes.style.display =
                    'block';


                arquivo.innerHTML =
                    '📄 Último: ' +
                    '<strong>' +
                    dados.arquivo +
                    '</strong>';


                data.innerHTML =
                    '🕐 ' +
                    dados.data;


                const segundos =
                    Number(
                        dados.segundos
                    );


                if (
                    segundos <= 0
                ) {

                    tempo.innerHTML =
                        '⚡ Alterado agora';

                }

                else if (
                    segundos === 1
                ) {

                    tempo.innerHTML =
                        '⏱️ Há 1 segundo';

                }

                else {

                    tempo.innerHTML =
                        '⏱️ Há ' +
                        segundos +
                        ' segundos';

                }

            }


            // ========================================
            // SALVA TIMESTAMP
            // ========================================

            ultimoTimestamp =
                timestamp;


        }

        catch (erro)
        {

            console.error(
                'AtiviSoft Monitor - erro:',
                erro
            );


            status.innerHTML =
                '🔴 Erro ao verificar';


            detalhes.style.display =
                'none';

        }

    }


    // ========================================
    // PRIMEIRA VERIFICAÇÃO
    // ========================================

    verificarStatus();


    // ========================================
    // MONITORAMENTO
    //
    // Verifica a cada 2 segundos.
    // ========================================

    setInterval(
        verificarStatus,
        2000
    );


})();

</script>