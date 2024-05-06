<?php 
session_start();
    //session_start();  
//    if(!isset($_SESSION['cd_colab']))
//    {
//        header("location: ../../pages/samples/login.php");
//        exit;
//    }


function getParameterByName($name, $url = null) {
    if ($url === null) {
        $url = $_SERVER['REQUEST_URI'];
    }

    $name = preg_quote($name);
    if (preg_match("/[?&]$name=([^&]+)/", $url, $matches)) {
        return urldecode($matches[1]);
    } else {
        return null;
    }
}

$cnpj = getParameterByName('cnpj');
$cd_pais = getParameterByName('cd_pais');
$tel = getParameterByName('tel');
$cd_prod_serv = getParameterByName('cd_prod_serv');
$carrinho = getParameterByName('carrinho');
$cadastro = getParameterByName('cadastro');

if ($cnpj || $tel || $cd_prod_serv || $carrinho || $cadastro) {
    // Armazenar o CNPJ na variável de sessão
    $_SESSION['cnpj_empresa'] = $cnpj;
    
    // Você pode fazer qualquer outra coisa com o telefone aqui
    if(isset($cd_pais)){
        $_SESSION['contel_cliente'] = $cd_pais.$tel;
        $_SESSION['cadtel_cliente'] = $tel;
    }else{
        $_SESSION['contel_cliente'] = $tel;
    }
    
    $_SESSION['cd_prod_serv'] = $cd_prod_serv;
    
    if($cd_prod_serv != null){
        echo '<style>.column{display: none;}</style>';
    }
    if($carrinho == true){
        echo '<style>.column{display: none;}</style>';
        //echo '<style>.column{display: none;}</style>';
        $_SESSION['carrinho'] = $carrinho;
    }else{
        $_SESSION['carrinho'] = $carrinho;
    }

    if($cadastro == true){
        echo '<style>.column{display: none;}</style>';
        //echo '<style>.column{display: none;}</style>';
        $_SESSION['cadastro'] = $cadastro;
    }else{
        $_SESSION['cadastro'] = $cadastro;
    }
    //Redirecionar para onde desejar ou exibir uma mensagem de sucesso
    //header('Location: pagina_anterior.php');
    //exit;
}
else {
    //Trate o caso em que os valores não foram fornecidos na URL
    //echo "Parâmetros de CNPJ e telefone não encontrados na URL.";
}



    require_once '../../classes/conn.php';
    include("../../classes/functions.php");
    $u = new Usuario;
?><!--Validar sessão aberta, se usuário está logado.-->



<?php
    //AREA DE GRAVAR DADOS

    if(isset($_POST['add_carrinho'])){
        if(isset($_SESSION['cd_cliente'])){
            $query = "INSERT INTO tb_carrinho(cd_prod_serv_carrinho, qtd_prod_serv_carrinho, cd_cliente_carrinho, dt_add_carrinho, dt_status_carrinho, status_carrinho) VALUES(
                '".$_POST['cd_prod_serv']."',
                '".$_POST['qtd_prod_serv_carrinho']."',
                '".$_POST['cd_cliente']."',
                '".$_POST['dt_add_carrinho']."',
                '".$_POST['dt_add_carrinho']."',
                '".$_POST['status_carrinho']."')
            ";
            if(mysqli_query($conn, $query)){
                //echo "<script>window.alert('Produto adicionado ao carrinho!');</script>";
                $_SESSION['vl_carrinho'] += $_POST['preco_prod_serv'];
            }else{
                echo "<script>window.alert('Nada feito...');</script>";
            }

            $update_prod_serv = "UPDATE tb_prod_serv SET
                estoque_prod_serv = '" . $_SESSION['estoque_prod_serv'] - $_POST['qtd_prod_serv_carrinho'] . "'
                WHERE cd_prod_serv = " . $_SESSION['cd_prod_serv'];
                if(mysqli_query($conn, $update_prod_serv)){
                    //echo "<script>window.alert('Nada feito...');</script>";
                }else{
                    echo "<script>window.alert('Nada feito...');</script>";
                }
        }else{
            echo "<script>window.alert('Entre com seu login ou cadastre-se...');</script>";
        }
    }

    if(isset($_POST['rm_ItemCarrinho'])){
        //cd_prod_serv_carrinho
        $query = "DELETE FROM tb_carrinho WHERE cd_carrinho = ".$_POST['cd_carrinho']."";
        if(mysqli_query($conn, $query)){
            //echo "<script>window.alert('Item removido do carrinho!');</script>";
        }else{
            echo "<script>window.alert('Nada feito...');</script>";
        }
        $select_prod_serv = "SELECT * FROM tb_prod_serv WHERE cd_prod_serv = '".$_POST['cd_prod_serv_carrinho']."'";
        $result_prod_serv = mysqli_query($conn, $select_prod_serv);
        $row_prod_serv = mysqli_fetch_assoc($result_prod_serv);
        // Exibe as informações do usuário no formulário
        if($row_prod_serv) {
            $_SESSION['estoque_prod_serv'] = $row_prod_serv['estoque_prod_serv'];
        }

        $update_prod_serv = "UPDATE tb_prod_serv SET
            estoque_prod_serv = '" . $_SESSION['estoque_prod_serv'] + $_POST['qtd_prod_serv_carrinho'] . "'
            WHERE cd_prod_serv = " . $_POST['cd_prod_serv_carrinho'];
        if(mysqli_query($conn, $update_prod_serv)){
            //echo "<script>window.alert('Nada feito...');</script>";
        }else{
            echo "<script>window.alert('Nada feito...');</script>";
        }
    }

    if(isset($_POST['rm_all_ItemCarrinho'])){
        //cd_prod_serv_carrinho
        $query = "DELETE FROM tb_carrinho WHERE cd_cliente_carrinho = ".$_SESSION['cd_cliente']."";
        if(mysqli_query($conn, $query)){
            //echo "<script>window.alert('Carrinho limpo com sucesso!');</script>";
        }else{
            echo "<script>window.alert('Nada feito...');</script>";
        }
    }

    if(isset($_POST['cad_cliente'])){
        if(strlen($_SESSION['cadtel_cliente']) == 11){
            $query = "INSERT INTO tb_cliente(pnome_cliente, snome_cliente, tel_cliente, obs_tel_cliente) VALUES(
                '".$_POST['cad_cliente_nome']."',
                '".$_POST['cad_cliente_sobrenome']."',
                '".$_POST['cd_pais'].$_POST['cad_cliente_tel']."',
                'Cliente cadastrado através da loja virtual')
            ";
            if(mysqli_query($conn, $query)){
                echo "<script>window.alert('Cadastro realizado com sucesso!');</script>";
                echo '<script>window.location.href = "index.php?cnpj='.$_SESSION['cnpj_empresa'].'&tel='.$_POST['cd_pais'].$_POST['cad_cliente_tel'].'";</script>';//index.php?cnpj='.$_SESSION['cnpj_empresa'].'
            }else{
                echo "<script>window.alert('Nada feito...');</script>";
            }
        }
    }

?>
<?php
    //http://arteliemalu.lovestoblog.com/?cnpj=123&tel=null&cd_prod_serv=1
    // AREA DE CARREGAR DADOS
    
    if(isset($_SESSION['contel_cliente'])){
        if(strlen($_SESSION['cadtel_cliente']) == 11 && ctype_digit($_SESSION['contel_cliente'])){
            $query_select_cliente = "SELECT * FROM tb_cliente WHERE tel_cliente = '".$_SESSION['contel_cliente']."'";
            $result_select_cliente = mysqli_query($conn, $query_select_cliente);
            $row_select_cliente = mysqli_fetch_assoc($result_select_cliente);
            // Exibe as informações do usuário no formulário
            if($row_select_cliente) {
                $_SESSION['cd_cliente'] = $row_select_cliente['cd_cliente'];
                $_SESSION['pnome_cliente'] = $row_select_cliente['pnome_cliente'];
                $_SESSION['snome_cliente'] = $row_select_cliente['snome_cliente'];
                $_SESSION['foto_cliente'] = $row_select_cliente['foto_cliente'];
            }else{
                //$_SESSION['cadtel_cliente'] = $_SESSION['contel_cliente'];
                echo '<script>window.location.href = "index.php?cnpj='.$_SESSION['cnpj_empresa'].'&cadastro=true";</script>';//index.php?cnpj='.$_SESSION['cnpj_empresa'].'
            }
        }else{
            echo "<script>window.alert('Digite um número de telefone válido');</script>";
            echo '<script>window.location.href = "index.php?cnpj='.$_SESSION['cnpj_empresa'].'&carrinho=true";</script>';//index.php?cnpj='.$_SESSION['cnpj_empresa'].'
        }
        echo '<script>document.getElementById("consulta").style.display = "none";</script>';
    }
?>












<?php
    //session_start();

    
    ////if(isset($_SESSION['cd_colab']))
    ////{
        //header("location: http://amorimgg77.lovestoblog.com/pages/samples/login.php");
        //echo '<script>location.href="'.$_SESSION['dominio'].'pages/samples/login.php";</script>';
    ////    echo '<script>location.href="'.$_SESSION['dominio'].'pages/dashboard/index.php";</script>';   
        //echo '<script>location.href="'.$_SESSION['dominio'].'pages/samples/login.php";</script>';    
        ////exit;
    ////}else{
        //echo '<script>location.href="'.$_SESSION['dominio'].'pages/dashboard/index.php";</script>';    
        //exit;
    ////}
    //require_once 'classes/conn.php';
    
    //include("classes/functions.php");
    //conectar($_SESSION['cnpj_empresa']);

    //$u = new Usuario;
    
    
?><!--Validar sessão aberta, se usuário está logado.-->


<?php
    if(isset($_SESSION['cnpj_empresa'])){
        $query_select_empresa = "SELECT * FROM tb_filial WHERE cnpj_filial = '".$_SESSION['cnpj_empresa']."'";
        $result_select_empresa = mysqli_query($conn, $query_select_empresa);
        $row_select_empresa = mysqli_fetch_assoc($result_select_empresa);
        // Exibe as informações do usuário no formulário
        if($row_select_empresa) {
            $_SESSION['nfantasia_filial'] = $row_select_empresa['nfantasia_filial'];
        } 

/*
        // Consulta SQL para recuperar os dados
        $sql = "SELECT * FROM tb_prod_serv";
        $result = $conn->query($sql);

        // Array para armazenar os resultados
        $products = array();

        if ($result->num_rows > 0) {
            // Loop através dos resultados da consulta
            while ($row = $result->fetch_assoc()) {
                // Adicionar cada linha como um novo elemento no array
                $products[] = $row;
            }
        }

        // Criar o JSON
        $json_data = json_encode(array("products" => $products));

        // Escrever os dados JSON em um arquivo
        $file_path = "productsss.json";
        $file = fopen($file_path, "w") or die("Não foi possível abrir o arquivo.");
        fwrite($file, $json_data);
        fclose($file);

        echo "Arquivo JSON criado com sucesso em $file_path.";
*/

    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

   


    <!-- Basic Page Needs
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <meta charset="utf-8">
    <?php 
        if(isset($_SESSION['nfantasia_filial'])){
            echo '<title>'.$_SESSION['nfantasia_filial'].'</title>';
        }else{
            echo '<title>...</title>';
        }
    ?>
    <meta name="description" content="A clean, responsive storefront boilerplate with no database or backend">
    <meta name="author" content="">

    <!-- Mobile Specific Metas
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- FONT
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- CSS
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link rel="stylesheet" href="css/imports.min.css">
    <link rel="stylesheet" href="css/simpleStore.min.css">
<!--
    <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../vendors/feather/feather.css">
    <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
    <link rel="stylesheet" href="../../css/style.css">-->

    <!-- Favicon
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link rel="icon" type="image/png" href="images/favicon.png">
    <script src="../../js/functions.js"></script>

</head>
<body>

    <!-- Primary Page Layout
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <div class="container simpleStore">
        <div class="row">
            
            <?php 
                if(isset($_SESSION['nfantasia_filial'])){
                
                echo '<a style="margin:10px;" class="brand" href="index.php?cnpj='.$_SESSION['cnpj_empresa'].'">'.$_SESSION['nfantasia_filial'].'</a>';
                echo '<a style="margin:10px;" class="button button-primary u-pull-right simpleStore_viewCart" href="../md_assistencia/acompanha_servico.php?cnpj='.$_SESSION['cnpj_empresa'].'">Retorne aos Serviços</a>';
                }else{
                    echo '<a class="brand" href="#">...</a>';
                }
            ?>
            <a style="margin:10px;" class="button button-primary u-pull-right simpleStore_viewCart" href="<?php echo 'index.php?cnpj='.$_SESSION['cnpj_empresa'].'&carrinho=true';?>">
                 
                <?php
                    if(isset($_SESSION['cd_cliente'])){
                        $query_soma_carrinho = "SELECT SUM(ps.preco_prod_serv * c.qtd_prod_serv_carrinho) AS total_carrinho FROM tb_carrinho c, tb_prod_serv ps WHERE c.cd_prod_serv_carrinho = ps.cd_prod_serv and cd_cliente_carrinho = ".$_SESSION['cd_cliente']."";
                        $result_soma_carrinho = mysqli_query($conn, $query_soma_carrinho);
                        $row_soma_carrinho = mysqli_fetch_assoc($result_soma_carrinho);
                        
                        if($row_soma_carrinho) {
                            echo '<i class="fa fa-shopping-cart"></i> Carrinho <span class="simpleCart_total">R$: '.$row_soma_carrinho['total_carrinho'].'</span>';
                        }
                    }else{
                        echo '<i class="fa fa-shopping-cart"></i> Login / Cadastro';
                    }
                ?>
                
            </a>
        </div>
        <div class="simpleStore_container"></div>
        <div class="simpleStore_cart_container"></div>
    </div>

    <!-- Templates
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->

    <!-- Products View -->
    
    <?php
        if(isset($_SESSION['cnpj_empresa']) && $_SESSION['cnpj_empresa'] != null){
            $query_select_prod_serv = "SELECT * FROM tb_prod_serv WHERE status_prod_serv = 1";
            $result_select_prod_serv = mysqli_query($conn, $query_select_prod_serv);
            //$row_select_prod_serv = mysqli_fetch_assoc($result_select_prod_serv);
            // Exibe as informações do usuário no formulário
            echo '<div class="container simpleStore"><div class="simpleStore_container" style="display: block;"><div class="row simpleStore_row_1">';
            
            while($row_select_prod_serv = $result_select_prod_serv->fetch_assoc()) {
                echo '<div class="column one-third">';
                echo '    <div class="simpleCart_shelfItem">';
                $caminho_pasta_produto = "../web/imagens/".$_SESSION['cnpj_empresa']."//produto/";
                    $foto_produto = $row_select_prod_serv['cd_prod_serv']."-foto.jpg"; // Nome do arquivo que será salvo
                    $caminho_foto_produto = $caminho_pasta_produto . $foto_produto;
                    $tipo_foto_produto = mime_content_type($caminho_foto_produto);
                    
                echo "                <img src='data:$tipo_foto_produto;base64," . base64_encode(file_get_contents($caminho_foto_produto)) . "' class='item_thumb'>";

                //echo '        <img src="https://lh3.googleusercontent.com/pw/AL9nZEXZ-JzGGHj9AMS0wCkTnXEVE3xvMq9kccrXImkej82q9gAt4RdtZ7LUXe8Tcg1qIOnK2juVpQ7qeHQ7xw3-AadCxwpRIGq_3LW4ry5r940B1ArdZ6jovOZOdOn4olJYGUdTJbn1fAw5z-cWYjcxlaZT0Q=w272-h273-no?authuser=0" class="item_thumb">';
                echo '        <div class="row">';
                echo '            <h5 class="item_titulo_prod_serv">'.$row_select_prod_serv['titulo_prod_serv'].'</h5>';
                echo '            <div class="simpleStore_getDetail_container">';
                echo '                <span class="item_preco_prod_serv">'.$row_select_prod_serv['preco_prod_serv'].'</span>';
                echo '            </div>';
                echo '            <div class="simpleStore_getDetail_container">';
                
                echo '                  <a class="button u-pull-right simpleStore_getDetail" href="index.php?cnpj='.$_SESSION['cnpj_empresa'].'&cd_prod_serv='.$row_select_prod_serv['cd_prod_serv'].'">Detalhes</a>';
                echo '            </div>';
                echo '        </div>';
                echo '    </div>';
                echo '</div>';
            }
            echo '</div></div></div>';
        }

    ?>

    <!-- Product Detail View -->
    <?php if($_SESSION['cd_prod_serv']){
            if(isset($_SESSION['cnpj_empresa'])){
                $query_select_index_prod_serv = "SELECT * FROM tb_prod_serv WHERE cd_prod_serv = ".$_SESSION['cd_prod_serv']."";
                $result_select_index_prod_serv = mysqli_query($conn, $query_select_index_prod_serv);
                //$row_select_prod_serv = mysqli_fetch_assoc($result_select_prod_serv);
                // Exibe as informações do usuário no formulário
                echo '<div class="container simpleStore"><div class="simpleStore_container" style="display: block;"><div class="row simpleStore_row_1">';
                
                while($row_select_index_prod_serv = $result_select_index_prod_serv->fetch_assoc()) {
                    echo '<form method="POST">';
                    echo '<h1>'.$row_select_index_prod_serv['titulo_prod_serv'].'</h1>';
                    echo '<div class="simpleStore_container" style="display: block;">';
                    echo '    <div class="simpleCart_shelfItem simpleStore_detailView">';
                    echo '        <a href="index.php?cnpj='.$_SESSION['cnpj_empresa'].'" class="close view_close">×</a>';
                    echo '        <div class="row">';
                    echo '            <div class="four columns">';
                    $caminho_pasta_produto = "../web/imagens/".$_SESSION['cnpj_empresa']."//produto/";
                    $foto_produto = $row_select_index_prod_serv['cd_prod_serv']."-foto.jpg"; // Nome do arquivo que será salvo
                    $caminho_foto_produto = $caminho_pasta_produto . $foto_produto;
                    $tipo_foto_produto = mime_content_type($caminho_foto_produto);
                    //echo "<img class='card-img-top' id='imagem-preview-produto' src='data:$tipo_foto_produto;base64," . base64_encode(file_get_contents($caminho_foto_produto)) . "' alt='Imagem'>";

                    echo "                <img src='data:$tipo_foto_produto;base64," . base64_encode(file_get_contents($caminho_foto_produto)) . "' class='item_thumb'>";
                    echo '            </div>';
                    echo '            <div class="eight columns">';
                    echo '                <h5 class="item_titulo_prod_serv"></h5>';
                    echo '                <p class="item_obs_prod_serv">'.$row_select_index_prod_serv['obs_prod_serv'].'</p>';
                    $_SESSION['estoque_prod_serv'] = $row_select_index_prod_serv['estoque_prod_serv'];
                    echo '                <span class="obs_prod_serv"></span>';
                    
                    
                    if($row_select_index_prod_serv['estoque_prod_serv'] > 0){
                        echo '<div class="qty">';
                        echo '<label>Quantidade</label>';
                        echo '<input type="number" value="1" min="1" max="'.$row_select_index_prod_serv['estoque_prod_serv'].'" step="1" class="item_Quantity" id="qtd_prod_serv_carrinho" name="qtd_prod_serv_carrinho">';
                        echo '</br><p>Em estoque: '.$row_select_index_prod_serv['estoque_prod_serv'].'</p>';
                        echo '</div>';
                    }else{
                        echo '<div class="qty">';
                        echo '</br><p>Em estoque: '.$row_select_index_prod_serv['estoque_prod_serv'].'</p>';
                        echo '</div>';
                        //echo '<input type="number" value="0" min="0" max="0" step="0" class="item_Quantity" id="qtd_prod_serv_carrinho" name="qtd_prod_serv_carrinho" readonly>';
                    }
                    //echo '                    <input type="number" '. if($row_select_index_prod_serv['estoque_prod_serv'] > 0){.'value="1" min="1"';.}else{.'value="0" min="0"';.}.' max="'.$row_select_index_prod_serv['estoque_prod_serv'].'" step="1" class="item_Quantity" id="qtd_prod_serv_carrinho" name="qtd_prod_serv_carrinho">';
                    
                    //echo '                <div class="simpleStore_options"><label>Size</label><select class="item_size"><option value="pequeno"> Pequeno </option><option value="médio"> Médio </option><option value="grande"> Grande </option></select></div>';
                    echo '                <div class="simpleStore_options"><label>R$: '.$row_select_index_prod_serv['preco_prod_serv'].'</label></div>';    
                    echo '                <input style="display:none;" type="tel" id="cd_prod_serv" name="cd_prod_serv" value="'.$row_select_index_prod_serv['cd_prod_serv'].'">';
                    echo '                <input style="display:none;" type="tel" id="cd_cliente" name="cd_cliente" value="'.$_SESSION['cd_cliente'].'">';
                    echo '                <input style="display:none;" type="text" id="dt_add_carrinho" name="dt_add_carrinho" value="'.date("d/m/Y:H.mm").'">';
                    echo '                <input style="display:none;" type="tel" id="status_carrinho" name="status_carrinho" value="1">';
                    echo '                <input style="display:none;" type="tel" id="preco_prod_serv" name="preco_prod_serv" value="'.$row_select_index_prod_serv['preco_prod_serv'].'">';
                    if(isset($_SESSION['cd_cliente'])){

                        if($row_select_index_prod_serv['estoque_prod_serv'] > 0){
                            echo '                <input type="submit" id="add_carrinho" name="add_carrinho" class="item_add button u-pull-right" value="Adicionar ao Carrinho">';
                        }else{
                        }

                    }else{
                        echo '                <a class="button button-primary u-pull-right simpleStore_viewCart" href="index.php?cnpj='.$_SESSION['cnpj_empresa'].'&carrinho=true"><i class="fa fa-shopping-cart"></i>Acesse sua conta para comprar</a>';
                    }
                    echo '            </div>';
                    echo '        </div>';
                    echo '    </div>';
                    echo '</div>';
                    echo '</form>';
                }
            }
        }
    ?>

    <!-- Cart View -->
    <?php 
        if($_SESSION['carrinho'] == true){
            if(isset($_SESSION['cd_cliente'])){
                echo '<div class="container simpleStore"><div class="simpleStore_container" style="display: block;"><div class="row simpleStore_row_1">';

                echo '<div class="simpleStore_cart_container carrinho" style="display: block;"><div class="simpleStore_cart">';
                
                echo '<h2>Carrinho</h2>';
                echo '<a href="index.php?cnpj='.$_SESSION['cnpj_empresa'].'" class="close">×</a>';

                echo '<div class="row">';
                echo '<div class="eight columns">';
                
                echo '<table>';
                echo '<div class="simpleCart_items">';
                
                echo '<div class="headerRow">';
                //echo '<th style="width: 20px; background-color: #F00;">X</th>';
                echo '<th><div class="item-quantity"></div></th>';

                echo '<th><div class="item-name">Nome</div></th>';
                echo '<th><div class="item-price">Preço</div></th>';
                echo '<!--<th><div class="item-decrement"></div>--></th>';
                echo '<th><div class="item-quantity">Qtd</div></th>';
                echo '<!--<th><div class="item-increment"></div>--></th>';
                echo '<th><div class="item-total">SubTotal</div></th>';
                echo '</div>';
                
                $select_prod_serv_carrinho = "SELECT c.*, ps.* FROM tb_carrinho c, tb_prod_serv ps WHERE c.cd_prod_serv_carrinho = ps.cd_prod_serv and cd_cliente_carrinho = ".$_SESSION['cd_cliente']."";
                $resulta_prod_serv_carrinho = $conn->query($select_prod_serv_carrinho);
                if ($resulta_prod_serv_carrinho->num_rows > 0){
                    while ( $row_prod_serv_carrinho = $resulta_prod_serv_carrinho->fetch_assoc()){
                        echo '<tr>';
                        echo '<td>';
                        echo '<form method="POST">';
                        echo '<input style="display:none;" type="tel" id="cd_carrinho" name="cd_carrinho" value="'.$row_prod_serv_carrinho['cd_carrinho'].'">';
                        echo '<input style="display:none;" type="tel" id="cd_prod_serv_carrinho" name="cd_prod_serv_carrinho" value="'.$row_prod_serv_carrinho['cd_prod_serv_carrinho'].'">';
                        echo '<input style="display:none;" type="tel" id="qtd_prod_serv_carrinho" name="qtd_prod_serv_carrinho" value="'.$row_prod_serv_carrinho['qtd_prod_serv_carrinho'].'">';
                        echo '<input type="submit" id="rm_ItemCarrinho" name="rm_ItemCarrinho" value="X">';
                        echo '</form>';
                        echo '</div></td>';
                        echo '<div class="itemRow row-'.$row_prod_serv_carrinho['cd_prod_serv_carrinho'].' odd" id="cartItem_SCI-1">';
                        echo '<td><div class="item-name">'.$row_prod_serv_carrinho['cd_prod_serv_carrinho'].' - '.$row_prod_serv_carrinho['titulo_prod_serv'].'</div></td>';
                        echo '<td><div class="item-price">'.$row_prod_serv_carrinho['preco_prod_serv'].'</div></td>';
                        echo '<td><div class="item-quantity">'.$row_prod_serv_carrinho['qtd_prod_serv_carrinho'].'</div></td>';
                        echo '<td><div class="item-total">R$'.$row_prod_serv_carrinho['preco_prod_serv']*$row_prod_serv_carrinho['qtd_prod_serv_carrinho'].'';
                        echo '</div>';
                        echo '</tr>';
                    }
                }

                
                echo '<tr>';
                //echo '<form method="POST">';
                //echo '<td><input class="simpleCart_remove" type="submit" id="rm_all_ItemCarrinho" name="rm_all_ItemCarrinho" value="Limpar carrinho"></td>';
                //echo '</form>';
                //echo '<td><a href="javascript:;" class="simpleCart_empty u-pull-left">Empty Cart <i class="fa fa-trash-o"></i></a></td>';
                echo '</tr>';
                echo '</div>';
                echo '<div class="four columns">';
                echo '<div class="cart_info">';

                $query_totalizadores_carrinho = "SELECT SUM(ps.preco_prod_serv * c.qtd_prod_serv_carrinho) AS total_carrinho, SUM(c.qtd_prod_serv_carrinho) AS total_quantidade FROM tb_carrinho c, tb_prod_serv ps WHERE c.cd_prod_serv_carrinho = ps.cd_prod_serv and cd_cliente_carrinho = ".$_SESSION['cd_cliente']."";
                $result_totalizadores_carrinho = mysqli_query($conn, $query_totalizadores_carrinho);
                $row_totalizadores_carrinho = mysqli_fetch_assoc($result_totalizadores_carrinho);
                      
                if($row_totalizadores_carrinho) {
                    echo '<td><div class="cart_info_item cart_itemcount">Items:';
                    echo '<div class="simpleCart_quantity">'.$row_totalizadores_carrinho['total_quantidade'].'</div>';
                    echo '</div>';
                    //echo '<div class="cart_info_item cart_taxrate">Tax Rate:';
                    //echo '<div class="simpleCart_taxRate">0</div>';
                    //echo '</div>';
                    //echo '<div class="cart_info_item cart_tax">Tax:';
                    //echo '<div class="simpleCart_tax">R$0.00</div>';
                    //echo '</div>';
                    //echo '<div class="cart_info_item cart_shipping">Shipping:';
                    //echo '<div class="simpleCart_shipping">R$0.00</div>';
                    //echo '</div>';
                    echo '<div class="cart_info_item cart_total"><b>Total:';
                    echo '<div class="simpleCart_grandTotal">R$: '.$row_totalizadores_carrinho['total_carrinho'].'</div>';
                    echo '</b></div>';
                    echo '<a href="javascript:;" class="button button-primary simpleStore_checkout u-pull-right">Finalizar Compra <i class="fa fa-arrow-right"></i></a>';
                    echo '</div>';
                    echo '</td>';
                    
                }
                echo '</div>';
                echo '</div>';
                echo '</table>';
                
                echo '</div>';
                echo '</div>';
            }else{

                echo '<div class="container simpleStore">';
                echo '<div class="simpleStore_container" style="display: block;">';
                echo '<div class="row simpleStore_row_1">';
                echo '<div class="simpleStore_cart_container carrinho" style="display: block;"><div class="simpleStore_cart">';

                echo '<h2>Login</h2>';
                echo '<a href="index.php?cnpj='.$_SESSION['cnpj_empresa'].'" class="close">×</a>';

                echo '<div class="row">';
                echo '<div class="eight columns">';
                
                echo '<form method="GET" action="index.php">';
                echo '<input type="hidden" name="cnpj" value="'.$_SESSION['cnpj_empresa'].'">';
                echo '<div class="form-group row justify-content-center">';
                echo '<div class="input-group">';
                echo '<div class="input-group-prepend">';
                echo '<span class="input-group-text" style="width:150px;">Telefone: </span>';
                echo '</div>';
                echo '<select name="cd_pais" id="cd_pais" class="input-group-text" style="width: 150px;" required>';
                echo '<option selected="selected" value="55">+55 Brasil</option>';
                echo '<option value="93">93 Afeganistão</option>';
                echo '<option value="355">355 Albânia</option>';
                echo '<option value="213">213 Argélia</option>';
                echo '<option value="376">376 Andorra</option>';
                echo '<option value="244">244 Angola</option>';
                echo '<option value="1264">1264 Anguila</option>';
                echo '<option value="1268">1268 Antígua e Barbuda</option>';
                echo '<option value="54">54 Argentina</option>';
                echo '<option value="374">374 Armênia</option>';
                echo '<option value="297">297 Aruba</option>';
                echo '<option value="247">247 Ascensão</option>';
                echo '<option value="61">61 Austrália</option>';
                echo '<option value="672">672 Ilha Christmas</option>';
                echo '<option value="43">43 Áustria</option>';
                echo '<option value="994">994 Azerbaijão</option>';
                echo '<option value="1242">1242 Bahamas</option>';
                echo '<option value="973">973 Bahrain</option>';
                echo '<option value="880">880 Bangladesh</option>';
                echo '<option value="1246">1246 Barbados</option>';
                echo '<option value="375">375 Belarus</option>';
                echo '<option value="32">32 Bélgica</option>';
                echo '<option value="501">501 Belize</option>';
                echo '<option value="229">229 Benin</option>';
                echo '<option value="1441">1441 Bermuda</option>';
                echo '<option value="975">975 Butão</option>';
                echo '<option value="591">591 Bolívia</option>';
                echo '<option value="387">387 Bósnia e Herzegovina</option>';
                echo '<option value="267">267 Botsuana</option>';      
                echo '<option value="246">246 Território Britânico do Oceano Índico</option>';
                echo '<option value="673">673 Brunei</option>';
                echo '<option value="359">359 Bulgária</option>';
                echo '<option value="226">226 Burkina Faso</option>';
                echo '<option value="257">257 Burundi</option>';
                echo '<option value="238">238 Cabo Verde</option>';
                echo '<option value="855">855 Camboja</option>';
                echo '<option value="237">237 Camarões</option>';
                echo '<option value="1">1 Canadá</option>';
                echo '<option value="238">238 Cabo Verde</option>';
                echo '<option value="345">345 Ilhas Cayman</option>';
                echo '<option value="236">236 República Centro-Africana</option>';
                echo '<option value="235">235 Chade</option>';
                echo '<option value="56">56 Chile</option>';
                echo '<option value="86">86 China</option>';
                echo '<option value="61">61 Ilha Cocos (Keeling)</option>';
                echo '<option value="57">57 Colômbia</option>';
                echo '<option value="269">269 Comores</option>';
                echo '<option value="242">242 Congo</option>';
                echo '<option value="243">243 República Democrática do Congo</option>';
                echo '<option value="682">682 Ilhas Cook</option>';
                echo '<option value="506">506 Costa Rica</option>';
                echo '<option value="225">225 Costa do Marfim</option>';
                echo '<option value="385">385 Croácia</option>';
                echo '<option value="53">53 Cuba</option>';
                echo '<option value="599">599 Curaçao</option>';
                echo '<option value="357">357 Chipre</option>';
                echo '<option value="420">420 República Tcheca</option>';
                echo '<option value="45">45 Dinamarca</option>';
                echo '<option value="253">253 Djibuti</option>';
                echo '<option value="1767">1767 Dominica</option>';
                echo '<option value="1809">1809 República Dominicana</option>';
                echo '<option value="593">593 Equador</option>';
                echo '<option value="20">20 Egito</option>';
                echo '<option value="503">503 El Salvador</option>';
                echo '<option value="240">240 Guiné Equatorial</option>';
                echo '<option value="291">291 Eritreia</option>';
                echo '<option value="372">372 Estônia</option>';
                echo '<option value="251">251 Etiópia</option>';
                echo '<option value="500">500 Ilhas Malvinas</option>';
                echo '<option value="298">298 Ilhas Faroe</option>';
                echo '<option value="679">679 Fiji</option>';
                echo '<option value="358">358 Finlândia</option>';
                echo '<option value="33">33 França</option>';
                echo '<option value="596">596 Martinica</option>';
                echo '<option value="594">594 Guiana Francesa</option>';
                echo '<option value="689">689 Polinésia Francesa</option>';
                echo '<option value="241">241 Gabão</option>';
                           /* <option value='220'>220 Gâmbia</option>
                            <option value='995'>995 Geórgia</option>
                            <option value='49'>49 Alemanha</option>
                            <option value='233'>233 Gana</option>
                            <option value='350'>350 Gibraltar</option>
                            <option value='30'>30 Grécia</option>
                            <option value='299'>299 Groênlandia</option>
                            <option value='1473'>1473 Granada</option>
                            <option value='590'>590 Guadalupe</option>
                            <option value='1671'>1671 Guam</option>
                            <option value='502'>502 Guatemala</option>
                            <option value='44'>44 Guernsey</option>
                            <option value='224'>224 Guiné</option>
                            <option value='245'>245 Guiné-Bissau</option>
                            <option value='592'>592 Guiana</option>
                            <option value='509'>509 Haiti</option>
                            <option value='379'>379 Santa Sé (Cidade do Vaticano)</option>
                            <option value='504'>504 Honduras</option>
                            <option value='852'>852 Hong Kong</option>
                            <option value='36'>36 Hungria</option>
                            <option value='354'>354 Islândia</option>
                            <option value='91'>91 Índia</option>
                            <option value='62'>62 Indonésia</option>
                            <option value='98'>98 Irã</option>
                            <option value='964'>964 Iraque</option>
                            <option value='353'>353 Irlanda</option>
                            <option value='44'>44 Ilha de Man</option>
                            <option value='972'>972 Israel</option>
                            <option value='39'>39 Itália</option>
                            <option value='1876'>1876 Jamaica</option>
                            <option value='81'>81 Japão</option>
                            <option value='44'>44 Jersey</option>
                            <option value='962'>962 Jordânia</option>
                            <option value='7'>7 Cazaquistão</option>
                            <option value='254'>254 Quênia</option>
                            <option value='686'>686 Kiribati</option>
                            <option value='850'>850 Coreia do Norte</option>
                            <option value='82'>82 Coreia do Sul</option>
                            <option value='965'>965 Kuwait</option>
                            <option value='996'>996 Quirguistão</option>
                            <option value='856'>856 Laos</option>
                            <option value='371'>371 Letônia</option>
                            <option value='961'>961 Líbano</option>
                            <option value='266'>266 Lesoto</option>
                            <option value='231'>231 Libéria</option>
                            <option value='218'>218 Líbia</option>
                            <option value='423'>423 Liechtenstein</option>
                            <option value='370'>370 Lituânia</option>
                            <option value='352'>352 Luxemburgo</option>
                            <option value='853'>853 Macau</option>
                            <option value='389'>389 Macedônia do Norte</option>
                            <option value='261'>261 Madagascar</option>
                            <option value='265'>265 Malawi</option>
                            <option value='60'>60 Malásia</option>
                            <option value='960'>960 Maldivas</option>
                            <option value='223'>223 Mali</option>
                            <option value='356'>356 Malta</option>
                            <option value='692'>692 Ilhas Marshall</option>
                            <option value='596'>596 Martinica</option>
                            <option value='222'>222 Mauritânia</option>
                            <option value='230'>230 Maurício</option>
                            <option value='262'>262 Reunião</option>
                            <option value='52'>52 México</option>
                            <option value='691'>691 Micronésia</option>
                            <option value='373'>373 Moldávia</option>
                            <option value='377'>377 Mônaco</option>
                            <option value='976'>976 Mongólia</option>
                            <option value='382'>382 Montenegro</option>
                            <option value='1664'>1664 Montserrat</option>
                            <option value='212'>212 Marrocos</option>
                            <option value='258'>258 Moçambique</option>
                            <option value='95'>95 Mianmar</option>
                            <option value='264'>264 Namíbia</option>
                            <option value='674'>674 Nauru</option>
                            <option value='977'>977 Nepal</option>
                            <option value='31'>31 Países Baixos</option>
                            <option value='687'>687 Nova Caledônia</option>
                            <option value='64'>64 Nova Zelândia</option>
                            <option value='505'>505 Nicarágua</option>
                            <option value='227'>227 Níger</option>
                            <option value='234'>234 Nigéria</option>
                            <option value='683'>683 Niue</option>
                            <option value='672'>672 Ilha Norfolk</option>
                            <option value='1670'>1670 Ilhas Marianas do Norte</option>
                            <option value='47'>47 Noruega</option>
                            <option value='968'>968 Omã</option>
                            <option value='92'>92 Paquistão</option>
                            <option value='680'>680 Palau</option>
                            <option value='970'>970 Palestina</option>
                            <option value='507'>507 Panamá</option>
                            <option value='675'>675 Papua Nova Guiné</option>
                            <option value='595'>595 Paraguai</option>
                            <option value='51'>51 Peru</option>
                            <option value='63'>63 Filipinas</option>
                            <option value='48'>48 Polônia</option>
                            <option value='351'>351 Portugal</option>
                            <option value='974'>974 Catar</option>
                            <option value='262'>262 Reunião</option>
                            <option value='40'>40 Romênia</option>
                            <option value='7'>7 Rússia</option>
                            <option value='250'>250 Ruanda</option>
                            <option value='590'>590 São Bartolomeu</option>
                            <option value='290'>290 Santa Helena</option>
                            <option value='1869'>1869 São Cristóvão e Nevis</option>
                            <option value='1758'>1758 Santa Lúcia</option>
                            <option value='590'>590 São Martinho</option>
                            <option value='508'>508 São Pedro e Miquelão</option>
                            <option value='1784'>1784 São Vicente e Granadinas</option>
                            <option value='685'>685 Samoa</option>
                            <option value='378'>378 San Marino</option>
                            <option value='239'>239 São Tomé e Príncipe</option>
                            <option value='966'>966 Arábia Saudita</option>
                            <option value='221'>221 Senegal</option>
                            <option value='381'>381 Sérvia</option>
                            <option value='248'>248 Seychelles</option>
                            <option value='232'>232 Serra Leoa</option>
                            <option value='65'>65 Cingapura</option>
                            <option value='1721'>1721 Sint Maarten</option>
                            <option value='421'>421 Eslováquia</option>
                            <option value='386'>386 Eslovênia</option>
                            <option value='677'>677 Ilhas Salomão</option>
                            <option value='252'>252 Somália</option>
                            <option value='27'>27 África do Sul</option>
                            <option value='500'>500 Geórgia do Sul e Ilhas Sandwich do Sul</option>
                            <option value='211'>211 Sudão do Sul</option>
                            <option value='34'>34 Espanha</option>
                            <option value='94'>94 Sri Lanka</option>
                            <option value='249'>249 Sudão</option>
                            <option value='597'>597 Suriname</option>
                            <option value='47'>47 Svalbard e Jan Mayen</option>
                            <option value='268'>268 Suazilândia</option>
                            <option value='46'>46 Suécia</option>
                            <option value='41'>41 Suíça</option>
                            <option value='963'>963 Síria</option>
                            <option value='886'>886 Taiwan</option>
                            <option value='992'>992 Tajiquistão</option>
                            <option value='255'>255 Tanzânia</option>
                            <option value='66'>66 Tailândia</option>
                            <option value='670'>670 Timor-Leste</option>
                            <option value='228'>228 Togo</option>
                            <option value='690'>690 Tokelau</option>
                            <option value='676'>676 Tonga</option>
                            <option value='1868'>1868 Trinidad e Tobago</option>
                            <option value='216'>216 Tunísia</option>
                            <option value='90'>90 Turquia</option>
                            <option value='993'>993 Turcomenistão</option>
                            <option value='1649'>1649 Ilhas Turcas e Caicos</option>
                            <option value='688'>688 Tuvalu</option>
                            <option value='256'>256 Uganda</option>
                            <option value='380'>380 Ucrânia</option>
                            <option value='971'>971 Emirados Árabes Unidos</option>
                            <option value='44'>44 Reino Unido</option>
                            <option value='1'>1 Estados Unidos</option>
                            <option value='598'>598 Uruguai</option>
                            <option value='998'>998 Uzbequistão</option>
                            <option value='678'>678 Vanuatu</option>
                            <option value='39'>39 Cidade do Vaticano</option>
                            <option value='58'>58 Venezuela</option>
                            <option value='84'>84 Vietnã</option>
                            <option value='1284'>1284 Ilhas Virgens Britânicas</option>
                            <option value='1340'>1340 Ilhas Virgens Americanas</option>
                            <option value='681'>681 Wallis e Futuna</option>
                            <option value='967'>967 Iêmen</option>
                            <option value='260'>260 Zâmbia</option>
                            <option value='263'>263 Zimbábue</option>*/




                echo '</select>';  
                

                echo '<input id="tel" name="tel" type="text" class="input-group-text form-control form-control-lg" />';
                echo '<p id="error-message" style="color: red;"></p></br>';

                echo '<script>';
                echo 'document.getElementById("tel").addEventListener("input", function() {';
                echo '    var telInput = document.getElementById("tel");';
                echo '    var errorMessage = document.getElementById("error-message");';

                echo '    if (telInput.value.length !== 11) {';
                echo '        errorMessage.textContent = "Preencha o DDD, 9 e os oito digitos do telefone.";';
                echo '        errorMessage.style.display = "block";'; // Mostra a mensagem de erro
                echo '        errorMessage.style.color = "FF0000";'; // Mostra a mensagem de erro
                echo '    } else {';
                echo '        errorMessage.textContent = "Tudo Certo";';
                echo '        errorMessage.style.display = "block";'; // Mostra a mensagem de erro
                echo '        errorMessage.style.color = "00AA00";'; // Esconde a mensagem de erro
                echo '    }';
                echo '});';
                echo '</script>';
                
                echo '<input type="submit" value="Entrar"/>';
                echo '</form>';


                //$cnpj = getParameterByName('cnpj');
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        }

        if($_SESSION['cadastro'] == true){

            echo '<div class="container simpleStore">';
            echo '<div class="simpleStore_container" style="display: block;">';
            echo '<div class="row simpleStore_row_1">';
            echo '<div class="simpleStore_cart_container carrinho" style="display: block;"><div class="simpleStore_cart">';

            echo '<h2>Cadastre-se</h2>';
            echo '<a href="index.php?cnpj='.$_SESSION['cnpj_empresa'].'" class="close">×</a>';

            echo '<div class="row">';
            echo '<div class="eight columns">';
                
            echo '<form method="POST">';
            echo '<input type="hidden" name="cnpj" value="'.$_SESSION['cnpj_empresa'].'">';
            echo '<div class="form-group row justify-content-center">';
            
            echo '<div class="input-group">';
            echo '<div class="input-group-prepend">';
            echo '<span class="input-group-text" style="width:150px;">Nome: </span>';
            echo '</div>';
            echo '<input required id="cad_cliente_nome" name="cad_cliente_nome" type="text" placeholder="Nome" class="input-group-text form-control form-control-lg"/>';
            echo '</div>';
            
            echo '<div class="input-group">';
            echo '<div class="input-group-prepend">';
            echo '<span class="input-group-text" style="width:150px;">Sobrenome: </span>';
            echo '</div>';
            echo '<input required id="cad_cliente_sobrenome" name="cad_cliente_sobrenome" type="text" placeholder="Sobrenome" class="input-group-text form-control form-control-lg"/>';
            echo '</div>';
            
            
            echo '<div class="input-group">';
            echo '<div class="input-group-prepend">';
            echo '<span class="input-group-text" style="width:150px;">Telefone: </span>';
            echo '</div>';
            echo '<select name="cd_pais" id="cd_pais" class="input-group-text" style="width: 150px;" required>';
                echo '<option selected="selected" value="55">+55 Brasil</option>';
            echo '<input required value="'.$_SESSION['cadtel_cliente'].'" id="cad_cliente_tel" name="cad_cliente_tel" type="tel" class="input-group-text form-control form-control-lg"/>';
            echo '</div>';
            
            echo '<p id="error-message" style="color: red;"></p></br>';

                echo '<script>';
                echo 'document.getElementById("cad_cliente_tel").addEventListener("input", function() {';
                echo '    var telInput = document.getElementById("cad_cliente_tel");';
                echo '    var errorMessage = document.getElementById("error-message");';

                echo '    if (telInput.value.length !== 11) {';
                echo '        errorMessage.textContent = "Preencha o DDD, 9 e os oito digitos do telefone.";';
                echo '        errorMessage.style.display = "block";'; // Mostra a mensagem de erro
                echo '        errorMessage.style.color = "FF0000";'; // Mostra a mensagem de erro
                echo '    } else {';
                echo '        errorMessage.textContent = "Tudo Certo";';
                echo '        errorMessage.style.display = "block";'; // Mostra a mensagem de erro
                echo '        errorMessage.style.color = "00AA00";'; // Esconde a mensagem de erro
                echo '    }';
                echo '});';
                echo '</script>';

            echo '</div>';
            echo '<input type="submit" id="cad_cliente" name="cad_cliente" value="Cadastrar"/>';
            echo '</form>';


            //$cnpj = getParameterByName('cnpj');
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    ?>


    <!-- Error View -->
    <script id="error-template" type="x-template">
        <div class="error">
            <b>Sorry, something went wrong :</b>
			<p class="error_text"></p>
			<a href="#" class="close alert_close">&times;</a>
        </div>
    </script>

<!-- End Document
–––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>

<!-- Scripts
–––––––––––––––––––––––––––––––––––––––––––––––––– -->




</html>
