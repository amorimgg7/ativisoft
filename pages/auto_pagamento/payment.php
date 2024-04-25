<h1>Hello World</h1>
<?php 
    foreach ($_POST as $key => $value) {
        $dados = $dados."Chave:".$key.", Valor: ".$value." \\n";
        echo "Chave: $key, Valor: $value <br>";
    }
    echo "<script>window.alert('".$dados."');</script>";  
?>
<?php


?>


<html>
<head>
    <script src="https://sdk.mercadopago.com/js/v2">
    </script>
</head>
<body>
    <div id="wallet_container">
    </div>
    <script>
      const mp = new MercadoPago('TEST-abb2c484-dca7-452e-a7b3-d885a4d828c2', {
        locale: 'pt-BR'
      });

      mp.bricks().create("wallet", "wallet_container", {
        initialization: {
            preferenceId: "<PREFERENCE_ID>",
        },
      });
  </script>

<table>
<th>
    <?php
        echo '<h1>Opção 1</h1><h2>Copiar Conteúdo '.$_POST['valor_pagamento'].'</h2>';
    ?>
    
    <textarea id="link1" rows="5" cols="50">00020101021126580014br.gov.bcb.pix01366f253057-2713-4a14-8076-7c8bdab319f7520400005303986540580.005802BR5920GABRIEL GOMES AMORIM6009SAO PAULO622905251HW9BJC9HWVN0HTT6CQDPC1SC6304D2C3</textarea><br>

    <button onclick="copiarTexto1()">Copiar</button>
    
    <script>
        function copiarTexto1() {
            var textarea = document.getElementById("link1");
            textarea.select();
            document.execCommand("copy");
            alert("Conteúdo copiado para a área de transferência!");
        }
    </script>
</th>
<th>
    <?php
        echo '<h1>Opção 2</h1><h2>Copiar Conteúdo '.$_POST['valor_pagamento'].'</h2>';
    ?>
    <textarea id="link2" rows="5" cols="50">00020101021126580014br.gov.bcb.pix01366f253057-2713-4a14-8076-7c8bdab319f7520400005303986540580.005802BR5920GABRIEL GOMES AMORIM6009SAO PAULO622905251HW9BMVAVD941FJY580TA9XM16304A243</textarea><br>
    <button onclick="copiarTexto2()">copiar</button>
    <script>
        function copiarTexto2() {
            var textarea = document.getElementById("link2");
            textarea.select();
            document.execCommand("copy");
            alert("Conteúdo copiado para a área de transferência!");
        }
    </script>
</th>

</table>
</body>
</html>
        



