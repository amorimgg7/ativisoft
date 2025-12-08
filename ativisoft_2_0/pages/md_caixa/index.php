<?php //Gadget caixa
  $dia_hoje = date('Y-m-d'); // Formatando a data de hoje para o formato do banco de dados (ano-mês-dia)
  $dia_ontem = date('Y-m-d', strtotime('-1 day'));
  //$dia_hoje = date('Y-m-d H:i', strtotime('+1 hour'));

  
  //echo '<h1>'.$dia_hoje = date('Y-m-d H:i').'</h1>';
  

  

  $select_caixa_anterior = "SELECT * FROM tb_caixa WHERE status_caixa = 0 AND DATE(dt_abertura) < '".$dia_ontem."' AND cd_filial = '".$_SESSION['cd_empresa']."'";
  $resulta_caixa_anterior = $conn->query($select_caixa_anterior);
  if ($resulta_caixa_anterior->num_rows > 0){ $_SESSION['dt_caixa'] = "ANTERIOR";
    //echo '<div class="col-lg-6 grid-margin stretch-card" style="background-color: #FF0000;">';//dia anterior aberto
    echo '<div class="col-lg-12 grid-margin stretch-card btn-danger">';//
    echo '<div class="card" '.$_SESSION['c_card'].'>';
    echo '<div class="card-body">';
    echo '<h4 class="card-title">Caixa Aberto a muitos dias - Feche agora o dia Fiscal</h4>';
                
    echo '<div class="table-responsive">';
    echo '<table class="table">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Abertura</th>';
    echo '<th>Responsável</th>';
    echo '<th>Saldo Abertura</th>';
                
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    while ( $row_caixa_anterior = $resulta_caixa_anterior->fetch_assoc()){ $_SESSION['cd_caixa'] = $row_caixa_anterior['cd_caixa'];
      echo '<tr>';
      echo '<td>'.date('d/m/y H:i', strtotime($row_caixa_anterior['dt_abertura'])).'</td>';
      //echo '<td>'.$row_caixa['dt_abertura'].'/'.$row_caixa['dt_fechamento'].'</td>';
      $select_responsavel_anterior = "SELECT * FROM tb_pessoa WHERE cd_pessoa = '".$row_caixa_anterior['cd_colab_abertura']."'";

      //insert into tb_caixa(dt_abertura, cd_colab_abertura, saldo_abertura, status_caixa) VALUES('2023-08-12T13:00','1','15','0')
      $resulta_responsavel_anterior = $conn->query($select_responsavel_anterior);
      while ($row_responsavel_anterior = $resulta_responsavel_anterior->fetch_assoc()){
        echo '<td>'.$row_responsavel_anterior['pnome_pessoa'].' '.$row_responsavel_anterior['snome_pessoa'].'</td>';
      }
                  
      echo '<td>R$: '.$row_caixa_anterior['saldo_abertura'].'</td>';

    }
    echo '</tbody>';
    echo '</table>';
    echo '<form action="../../pages/md_caixa/fechamento_caixa.php" method="POST">';
    echo '<button type="submit" class="btn btn-lg btn-block btn-danger"><i class="mdi mdi-file-check"></i>Fechar Caixa</button>';
    echo '</form>';//fechamentoNormalCaixa
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';  
  }else{
    $select_caixa_ontem = "SELECT * FROM tb_caixa WHERE status_caixa = 0 AND DATE(dt_abertura) = '".$dia_ontem."' AND cd_filial = '".$_SESSION['cd_empresa']."'";
    $resulta_caixa_ontem = $conn->query($select_caixa_ontem);
    if ($resulta_caixa_ontem->num_rows > 0){ $_SESSION['dt_caixa'] = "ONTEM";
      //echo '<div class="col-lg-6 grid-margin stretch-card" style="background-color: #FF0000;">';//dia anterior aberto
      echo '<div class="col-12 grid-margin stretch-card btn-warning">';//
        echo '<div class="card" '.$_SESSION['c_card'].'>';
        echo '<div class="card-body">';
        //echo '<h4 class="card-title">Caixa Aberto - Tudo pronto</h4>';
        echo '<h4 class="card-title">Feche o dia Fiscal de ontem( '.date('d/m/y H:i', strtotime($dia_ontem)).' )</h4>';

                
        echo '<div class="table-responsive">';
        echo '<table class="table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Abertura</th>';
        echo '<th>Responsável</th>';
        echo '<th>Saldo Abertura</th>';
                
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while ( $row_caixa_ontem = $resulta_caixa_ontem->fetch_assoc()){ $_SESSION['cd_caixa'] = $row_caixa_ontem['cd_caixa'];
          echo '<tr>';
          echo '<td>'.date('d/m/y H:i', strtotime($row_caixa_ontem['dt_abertura'])).'</td>';
          //echo '<td>'.$row_caixa['dt_abertura'].'/'.$row_caixa['dt_fechamento'].'</td>';
          $select_responsavel_ontem = "SELECT * FROM tb_pessoa WHERE cd_pessoa = '".$row_caixa_ontem['cd_colab_abertura']."'";
        //insert into tb_caixa(dt_abertura, cd_colab_abertura, saldo_abertura, status_caixa) VALUES('2023-08-12T13:00','1','15','0')
        $resulta_responsavel_ontem = $conn->query($select_responsavel_ontem);
        while ($row_responsavel_ontem = $resulta_responsavel_ontem->fetch_assoc()){
          echo '<td>'.$row_responsavel_ontem['pnome_pessoa'].' '.$row_responsavel_ontem['snome_pessoa'].'</td>';
        }    
          echo '<td>R$: '.$row_caixa_ontem['saldo_abertura'].'</td>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
        echo '<form action="../../pages/md_caixa/fechamento_caixa.php" method="POST">';
        echo '<button type="submit" class="btn btn-lg btn-block btn-warning" style="margin: 5px;"><i class="mdi mdi-file-check"></i>Fechar Caixa</button>';
        echo '</form>';//fechamentoNormalCaixa
        ////echo '<form action="pages/md_caixa/fechamento_caixa.php" method="POST">';
        ////echo '<button type="submit" class="btn btn-lg btn-block btn-outline-danger" style="margin: 5px;"><i class="mdi mdi-file-check"></i>Fechar Caixa</button>';
        ////echo '</form>';//fechamentoNormalCaixa
        echo '</div>';
        echo '</div>';
        echo '</div>';  
    }else{
      if($_SESSION['cd_colab'] == 1){
        $select_caixa_hoje = "SELECT * FROM tb_caixa WHERE status_caixa = 0 AND DATE(dt_abertura) = '".$dia_hoje."' AND cd_filial = '".$_SESSION['cd_empresa']."'";
      }else{
        $select_caixa_hoje = "SELECT * FROM tb_caixa WHERE status_caixa = 0 AND cd_colab_abertura = '".$_SESSION['cd_colab']."' AND DATE(dt_abertura) = '".$dia_hoje."' AND cd_filial = '".$_SESSION['cd_empresa']."'";
      }
      $resulta_caixa_hoje = $conn->query($select_caixa_hoje);
      if ($resulta_caixa_hoje->num_rows > 0){ $_SESSION['dt_caixa'] = "HOJE";
        echo '<div class="col-12 grid-margin stretch-card btn-success" '.$_SESSION['c_card'].'>';//
        echo '<div class="card" '.$_SESSION['c_card'].'>';
        echo '<div class="card-body" '.$_SESSION['c_card'].'>';
        echo '<h4 class="card-title" '.$_SESSION['c_card'].'>Caixa Aberto - Tudo pronto</h4>';
                
        echo '<div class="table-responsive">';
        echo '<table class="table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Abertura</th>';
        echo '<th>Responsável</th>';
        echo '<th>Saldo Abertura</th>';
                
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while ( $row_caixa_hoje = $resulta_caixa_hoje->fetch_assoc()){ $_SESSION['cd_caixa'] = $row_caixa_hoje['cd_caixa'];
          echo '<tr>';
          echo '<td>'.date('d/m/y H:i', strtotime($row_caixa_hoje['dt_abertura'])).'</td>';
          //echo '<td>'.$row_caixa['dt_abertura'].'/'.$row_caixa['dt_fechamento'].'</td>';
          $select_responsavel_hoje = "SELECT * FROM tb_pessoa WHERE cd_pessoa = '".$row_caixa_hoje['cd_colab_abertura']."'";

          //insert into tb_caixa(dt_abertura, cd_colab_abertura, saldo_abertura, status_caixa) VALUES('2023-08-12T13:00','1','15','0')
          $resulta_responsavel_hoje = $conn->query($select_responsavel_hoje);
          while ($row_responsavel_hoje = $resulta_responsavel_hoje->fetch_assoc()){
            echo '<td>'.$row_responsavel_hoje['pnome_pessoa'].' '.$row_responsavel_hoje['snome_pessoa'].'</td>';
          }     
          echo '<td>R$: '.$row_caixa_hoje['saldo_abertura'].'</td>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
        echo '<form action="../../pages/md_caixa/abertura_caixa.php" method="POST">';
        //echo '<button type="submit" class="btn btn-lg btn-block btn-outline-success" style="margin: 5px;"><i class="mdi mdi-file-check"></i>Operações de Caixa</button>';
        echo $u->retPermissaoBtn('106', 'submit', 'btn btn-lg btn-block btn-outline-success', '', '', 'margin: 5px;', 'Operações de Caixa', '', '', '', '<i class="mdi mdi-file-check"></i>');
        
        echo '</form>';//fechamentoNormalCaixa
        ////echo '<form action="pages/md_caixa/fechamento_caixa.php" method="POST">';
        ////echo '<button type="submit" class="btn btn-lg btn-block btn-outline-danger" style="margin: 5px;"><i class="mdi mdi-file-check"></i>Fechar Caixa</button>';
        ////echo '</form>';//fechamentoNormalCaixa
        echo '</div>';
        echo '</div>';
        echo '</div>';  
      }else{ $_SESSION['dt_caixa'] = FALSE;
        echo '<div class="col-12 grid-margin stretch-card btn-info">';//
        echo '<div class="card" '.$_SESSION['c_card'].'>';
        echo '<div class="card-body">';

        echo '<h4 class="card-title">Nenhum caixa aberto</h4>';
                
        echo '<div class="table-responsive">';
        echo '</div>';
        echo '<form action="../../pages/md_caixa/abertura_caixa.php" method="POST">';
        echo $u->retPermissaoBtn('101', 'submit', 'btn btn-lg btn-block btn-outline-info', '', '', 'margin: 5px;', 'Abra já seu caixa', '', '', '', '<i class="mdi mdi-file-check"></i>');
        
        //echo '<button type="submit" class="btn btn-lg btn-block btn-outline-info" style="margin: 5px;"><i class="mdi mdi-file-check"></i>Abra já seu caixa</button>';
        echo '</form>';
        echo '</div>';
        echo '</div>';     
        echo '</div>'; 
      }
    }
  }
?>