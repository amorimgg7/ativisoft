
<?php 
    session_start();  
    
    require_once '../../classes/conn_revenda.php';
?><!--Validar sessão aberta, se usuário está logado.-->

<?php


    echo 'Atualizado em: '.date("d/m/Y H:i:s").' !';
    //echo "<meta http-equiv='refresh' content='1;url=".$_SESSION['dominio']."pages/dashboard/index.php'>";//<meta http-equiv="refresh" content="1;url=https://www.novapagina.com">


    $select_dispositivo = "SELECT * FROM tb_dispositivo WHERE cd_dispositivo = '".$_SESSION['dispositivo']."'";
    $result_dispositivo = mysqli_query($conn_revenda, $select_dispositivo);
    $row_dispositivo = mysqli_fetch_assoc($result_dispositivo);
    // Exibe as informações do usuário no formulário
    if($row_dispositivo) {
      $_SESSION['canal_1'] = $row_dispositivo['canal_1'];
      $_SESSION['canal_2'] = $row_dispositivo['canal_2'];
      $_SESSION['canal_3'] = $row_dispositivo['canal_3'];
      $_SESSION['canal_4'] = $row_dispositivo['canal_4'];
      $_SESSION['canal_5'] = $row_dispositivo['canal_5'];
      $_SESSION['canal_6'] = $row_dispositivo['canal_6'];
      $_SESSION['canal_7'] = $row_dispositivo['canal_7'];
      $_SESSION['canal_8'] = $row_dispositivo['canal_8'];                  
    }


      for ($i = 1; $i <= 8; $i++) {
        if (isset($_POST['btncanal_' . $i])) {
            $edit_canais = "UPDATE tb_dispositivo SET
                canal_" . $i . " = '" . $_POST['btncanal_' . $i] . "'
                WHERE cd_dispositivo = '" . $_SESSION['cd_dispositivo'] . "'";
            if (mysqli_query($conn_revenda, $edit_canais)) {
                //echo "<script>window.alert('Canal " . $i . " atualizado para " . $_POST['btncanal_' . $i] . "!');</script>";
                $select_dispositivo = "SELECT * FROM tb_dispositivo WHERE cd_dispositivo = '" . $_SESSION['cd_dispositivo'] . "'";
                $result_dispositivo = mysqli_query($conn_revenda, $select_dispositivo);
                $row_dispositivo = mysqli_fetch_assoc($result_dispositivo);
                // Atualiza a sessão com o novo valor do canal
                if ($row_dispositivo) {
                    $_SESSION['canal_' . $i] = $row_dispositivo['canal_' . $i];
                }
            } else {
                echo "<script>window.alert('Erro ao atualizar o canal " . $i . "!');</script>";
            }
        }
      }

      for ($i = 1; $i <= 8; $i++) {
        if ($_SESSION['canal_' . $i] > 0) {
          echo '<form method="POST">';
          echo '<div class="col">';
          echo '<p class="mb-2">Canal ' . $i . ' - ' . $_SESSION['canal_' . $i] . '</p>';
          if ($_SESSION['canal_' . $i] == 2) {
            echo '<input style="display:none;" type="text" id="btncanal_' . $i . '" name="btncanal_' . $i . '" value="1">';
            echo '<input type="submit" value="Canal ' . $i . '" class="btn btn-info">';
          } else {
            echo '<input style="display:none;" type="text" id="btncanal_' . $i . '" name="btncanal_' . $i . '" value="2">';
            echo '<input type="submit" value="Canal ' . $i . '" class="btn btn-dark">';
          }
          echo '</div>';
          echo '</form>';
        }
      } 
?>