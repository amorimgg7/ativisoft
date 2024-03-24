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
$tel = getParameterByName('tel');
$cd_prod_serv = getParameterByName('cd_prod_serv');
$carrinho = getParameterByName('carrinho');

if ($cnpj || $tel || $cd_prod_serv || $carrinho) {
    // Armazenar o CNPJ na variável de sessão
    $_SESSION['cnpj_empresa'] = $cnpj;
    
    // Você pode fazer qualquer outra coisa com o telefone aqui
    $_SESSION['contel_cliente'] = $tel;
    
    $_SESSION['cd_prod_serv'] = $cd_prod_serv;
    
    if($cd_prod_serv != null){
        echo '<style>.column{display: none;}</style>';
    }
    if($carrinho == true){
        echo '<style>.column{display: none;}</style>';
        $_SESSION['carrinho'] = $carrinho;
    }else{
        $_SESSION['carrinho'] = $carrinho;
    }
    // Redirecionar para onde desejar ou exibir uma mensagem de sucesso
    //header('Location: pagina_anterior.php');
    //exit;
}
else {
    // Trate o caso em que os valores não foram fornecidos na URL
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
        }else{
            echo "<script>window.alert('Entre com seu login ou cadastre-se...');</script>";
        }
    }

?>
<?php
    //http://arteliemalu.lovestoblog.com/?cnpj=123&tel=null&cd_prod_serv=1
    // AREA DE CARREGAR DADOS
    
    if(isset($_SESSION['contel_cliente'])){
        $query_select_cliente = "SELECT * FROM tb_cliente WHERE tel_cliente = '".$_SESSION['contel_cliente']."'";
        $result_select_cliente = mysqli_query($conn, $query_select_cliente);
        $row_select_cliente = mysqli_fetch_assoc($result_select_cliente);
        // Exibe as informações do usuário no formulário
        if($row_select_cliente) {
            $_SESSION['cd_cliente'] = $row_select_cliente['cd_cliente'];
            $_SESSION['pnome_cliente'] = $row_select_cliente['pnome_cliente'];
            $_SESSION['snome_cliente'] = $row_select_cliente['snome_cliente'];
            $_SESSION['foto_cliente'] = $row_select_cliente['foto_cliente'];
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

    <!-- Favicon
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link rel="icon" type="image/png" href="images/favicon.png">

</head>
<body>

    <!-- Primary Page Layout
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <div class="container simpleStore">
        <div class="row">
            
            <?php 
                if(isset($_SESSION['nfantasia_filial'])){
                    echo '<a class="brand" href="#">'.$_SESSION['nfantasia_filial'].'</a>';
                }else{
                    echo '<a class="brand" href="#">...</a>';
                }
            ?>
            <a class="button button-primary u-pull-right simpleStore_viewCart" href="<?php echo 'index.php?cnpj='.$_SESSION['cnpj_empresa'].'&carrinho=true';?>">
                <i class="fa fa-shopping-cart"></i> Carrinho 
                <?php
                    if(isset($_SESSION['cd_cliente'])){
                        $query_soma_carrinho = "SELECT SUM(ps.preco_prod_serv * c.qtd_prod_serv_carrinho) AS total_carrinho FROM tb_carrinho c, tb_prod_serv ps WHERE c.cd_prod_serv_carrinho = ps.cd_prod_serv and cd_cliente_carrinho = ".$_SESSION['cd_cliente']."";
                        $result_soma_carrinho = mysqli_query($conn, $query_soma_carrinho);
                        $row_soma_carrinho = mysqli_fetch_assoc($result_soma_carrinho);
                        
                        if($row_soma_carrinho) {
                            echo '<span class="simpleCart_total">R$: '.$row_soma_carrinho['total_carrinho'].'</span>';
                        }
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
                echo '        <img src="https://lh3.googleusercontent.com/pw/AL9nZEXZ-JzGGHj9AMS0wCkTnXEVE3xvMq9kccrXImkej82q9gAt4RdtZ7LUXe8Tcg1qIOnK2juVpQ7qeHQ7xw3-AadCxwpRIGq_3LW4ry5r940B1ArdZ6jovOZOdOn4olJYGUdTJbn1fAw5z-cWYjcxlaZT0Q=w272-h273-no?authuser=0" class="item_thumb">';
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
    <?php
        if($_SESSION['cd_prod_serv']){
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
                    echo '                <img src="http://upload.wikimedia.org/wikipedia/commons/c/c6/Grey_Tshirt.jpg" class="item_thumb">';
                    echo '            </div>';
                    echo '            <div class="eight columns">';
                    echo '                <h5 class="item_titulo_prod_serv"></h5>';
                    echo '                <p class="item_obs_prod_serv">'.$row_select_index_prod_serv['obs_prod_serv'].'</p>';
                    echo '                <span class="obs_prod_serv"></span>';
                    echo '                <div class="qty">';
                    echo '                    <label>Quantidade</label>';
                    echo '                    <input type="number" value="1" min="1" step="1" class="item_Quantity" id="qtd_prod_serv_carrinho" name="qtd_prod_serv_carrinho">';
                    echo '                </div>';
                    //echo '                <div class="simpleStore_options"><label>Size</label><select class="item_size"><option value="pequeno"> Pequeno </option><option value="médio"> Médio </option><option value="grande"> Grande </option></select></div>';
                    echo '                <div class="simpleStore_options"><label>R$: '.$row_select_index_prod_serv['preco_prod_serv'].'</label></div>';    
                    echo '                <input style="display:none;" type="tel" id="cd_prod_serv" name="cd_prod_serv" value="'.$row_select_index_prod_serv['cd_prod_serv'].'">';
                    echo '                <input style="display:none;" type="tel" id="cd_cliente" name="cd_cliente" value="'.$_SESSION['cd_cliente'].'">';
                    echo '                <input style="display:none;" type="text" id="dt_add_carrinho" name="dt_add_carrinho" value="'.date("d/m/Y:H.mm").'">';
                    echo '                <input style="display:none;" type="tel" id="status_carrinho" name="status_carrinho" value="1">';
                    echo '                <input style="display:none;" type="tel" id="preco_prod_serv" name="preco_prod_serv" value="'.$row_select_index_prod_serv['preco_prod_serv'].'">';
                    echo '                <input type="submit" id="add_carrinho" name="add_carrinho" class="item_add button u-pull-right" value="Add to Cart">';
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
    <script id="cart-template" type="x-template">
        <div class="simpleStore_cart">
            <h2>Cart</h2>
            <a href="#" class="close">&times;</a>

            <div class="row">
                <div class="eight columns">
                    <div class="simpleCart_items"></div>
                    <a href="javascript:;" class="simpleCart_empty u-pull-left">Empty Cart <i class="fa fa-trash-o"></i></a>
                </div>
                <div class="four columns">
                    <div class="cart_info">
                        <div class="cart_info_item cart_itemcount">Items:
                            <div class="simpleCart_quantity"></div>
                        </div>
                        <div class="cart_info_item cart_taxrate">Tax Rate:
                            <div class="simpleCart_taxRate"></div>
                        </div>
                        <div class="cart_info_item cart_tax">Tax:
                            <div class="simpleCart_tax"></div>
                        </div>
                        <div class="cart_info_item cart_shipping">Shipping:
                            <div class="simpleCart_shipping"></div>
                        </div>
                        <div class="cart_info_item cart_total"><b>Total:
                            <div class="simpleCart_grandTotal"></div>
                        </b></div>
                        <a href="javascript:;" class="button button-primary simpleStore_checkout u-pull-right">Checkout <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </script>
    <?php
        if($_SESSION['carrinho'] == true){
            if(isset($_SESSION['cd_cliente'])){
                echo '<div class="container simpleStore"><div class="simpleStore_container" style="display: block;"><div class="row simpleStore_row_1">';

                echo '<div class="simpleStore_cart_container carrinho" style="display: block;"><div class="simpleStore_cart">';
                echo '<h2>Cart</h2>';
                echo '<a href="index.php?cnpj='.$_SESSION['cnpj_empresa'].'" class="close">×</a>';


                echo '<div class="row">';
                echo '  <div class="eight columns">';
                echo '      <div class="simpleCart_items"> <div><div class="headerRow"><div class="item-name">Nome</div><div class="item-price">Preço</div><div class="item-decrement"></div><div class="item-quantity">Qtd</div><div class="item-increment"></div><div class="item-total">SubTotal</div><div class="item-remove"></div></div>';
                

                $select_prod_serv_carrinho = "SELECT c.*, ps.* FROM tb_carrinho c, tb_prod_serv ps WHERE c.cd_prod_serv_carrinho = ps.cd_prod_serv and cd_cliente_carrinho = ".$_SESSION['cd_cliente']."";
                $resulta_prod_serv_carrinho = $conn->query($select_prod_serv_carrinho);
                if ($resulta_prod_serv_carrinho->num_rows > 0){
                    while ( $row_prod_serv_carrinho = $resulta_prod_serv_carrinho->fetch_assoc()){
                        echo '<div class="itemRow row-'.$row_prod_serv_carrinho['cd_prod_serv_carrinho'].' odd" id="cartItem_SCI-1">';
                        echo '  <div class="item-name">'.$row_prod_serv_carrinho['cd_prod_serv_carrinho'].' - '.$row_prod_serv_carrinho['titulo_prod_serv'].'</div>';
                        echo '  <div class="item-price">'.$row_prod_serv_carrinho['preco_prod_serv'].'</div>';
                        echo '  <div class="item-decrement"><a href="javascript:;" class="simpleCart_decrement">-</a></div>';
                        echo '  <div class="item-quantity">'.$row_prod_serv_carrinho['qtd_prod_serv_carrinho'].'</div>';
                        echo '  <div class="item-increment"><a href="javascript:;" class="simpleCart_increment">+</a></div>';
                        echo '  <div class="item-total">R$'.$row_prod_serv_carrinho['preco_prod_serv']*$row_prod_serv_carrinho['qtd_prod_serv_carrinho'].'</div>';
                        echo '  <div class="item-remove"><a href="javascript:;" class="simpleCart_remove">Remove</a></div>';
                        echo '</div>';
                    }
                }

                echo '      </div>';
                echo '  </div>';
                echo '        <a href="javascript:;" class="simpleCart_empty u-pull-left">Empty Cart <i class="fa fa-trash-o"></i></a>';
                echo '</div>';
                echo '    <div class="four columns">';
                echo '        <div class="cart_info">';
                echo '            <div class="cart_info_item cart_itemcount">Items:';
                echo '                <div class="simpleCart_quantity">2</div>';
                echo '            </div>';
                echo '            <div class="cart_info_item cart_taxrate">Tax Rate:';
                echo '                <div class="simpleCart_taxRate">0</div>';
                echo '            </div>';
                echo '            <div class="cart_info_item cart_tax">Tax:';
                echo '                <div class="simpleCart_tax">R$0.00</div>';
                echo '            </div>';
                echo '            <div class="cart_info_item cart_shipping">Shipping:';
                echo '                <div class="simpleCart_shipping">R$0.00</div>';
                echo '            </div>';
                echo '            <div class="cart_info_item cart_total"><b>Total:';
                echo '                <div class="simpleCart_grandTotal">R$180.00</div>';
                echo '            </b></div>';
                echo '            <a href="javascript:;" class="button button-primary simpleStore_checkout u-pull-right">Checkout <i class="fa fa-arrow-right"></i></a>';
                echo '        </div>';
                echo '    </div>';
                echo '</div>';
                echo '</div></div>';
                echo '</div></div></div>';
            }else{
                echo "<script>window.alert('Entre com seu login ou cadastre-se...');</script>";
            }
            

        }
    ?>


    <!-- Error View -->
    <script id="error-template" type="x-template">
        <div class="error">
            <b>Sorry, something went wrong :(</b>
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
