<head>
  <meta charset="utf-8">
  <meta http-equiv='refresh' content='2'>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>$_SESSION</title>
</head>
<body>
<?php
    session_start();
    echo '<h1>Sessão Aberta</h1>';
    echo '<h4>Dados do Usuário</h4>';
    echo '<p>cd_colab: '.$_SESSION['cd_colab'].'</p>';
    echo '<p>pnome_colab: '.$_SESSION['pnome_colab'].'</p>';
    echo '<p>snome_colab: '.$_SESSION['snome_colab'].'</p>';
  ?>
    <form method="post">
    <input type="submit" id="limpaUsuario" name="limpaUsuario" class="dropdown-item preview-item" value="Limpa Usuário"></input>
      
    </form>
  <?php
    echo '<h4>Dados da Matriz</h4>';
    echo '<p>cd_empresa: '.$_SESSION['cd_empresa'].'</p>';
    echo '<p>cnpj_empresa: '.$_SESSION['cnpj_empresa'].'</p>';
    echo '<p>rsocial_empresa: '.$_SESSION['rsocial_empresa'].'</p>';
    
    echo '<h4>Dados do cliente</h4>';
    echo '<p>cd_cliente: '.$_SESSION['cd_cliente'].'</p>';
    echo '<p>pnome_cliente: '.$_SESSION['pnome_cliente'].'</p>';
    echo '<p>snome_cliente: '.$_SESSION['snome_cliente'].'</p>';
    echo '<p>tel_cliente: '.$_SESSION['tel_cliente'].'</p>';
  ?>
    <form method="post">
      <input type="submit" id="limpaCliente" name="limpaCliente" class="dropdown-item preview-item" value="Limpa Cliente"></input>
    </form>
  <?php
    echo '<h4>Dados da Filial</h4>';
    echo '<p>nfantasia_filial: '.$_SESSION['nfantasia_filial'].'</p>';
    echo '<p>cnpj_filial: '.$_SESSION['cnpj_filial'].'</p>';
    echo '<p>endereco_filial: '.$_SESSION['endereco_filial'].'</p>';
    echo '<p>saudacoes_filial: '.$_SESSION['saudacoes_filial'].'</p>';
  ?>
    <form method="post">
    <input type="submit" id="limpaFilial" name="limpaFilial" class="dropdown-item preview-item" value="Limpa Filial"></input>
      
    </form>

  <?php

    echo '<h4>Dados do Serviço</h4>';
    echo '<p>cd_servico: '.$_SESSION['cd_servico'].'</p>';
    echo '<p>titulo_servico: '.$_SESSION['titulo_servico'].'</p>';
    echo '<p>obs_servico: '.$_SESSION['obs_servico'].'</p>';
    echo '<p>prioridade_servico: '.$_SESSION['prioridade_servico'].'</p>';
    echo '<p>entrada_servico: '.$_SESSION['entrada_servico'].'</p>';
    echo '<p>prazo_servico: '.$_SESSION['prazo_servico'].'</p>';
    echo '<p>orcamento_servico: '.$_SESSION['orcamento_servico'].'</p>';
    echo '<p>vpag_servico: '.$_SESSION['vpag_servico'].'</p>';
  ?>
    <form method="post">
    <input type="submit" id="limpaServico" name="limpaServico" class="dropdown-item preview-item" value="Limpa Servico"></input>
    </form>
  <?php
    


    if(isset($_POST['limpaUsuario'])) {
      $_SESSION['cd_colab'] = '';
      $_SESSION['pnome_colab'] = '';
      $_SESSION['snome_colab'] = '';
    }

    if(isset($_POST['limpaCliente'])) {
      $_SESSION['cd_cliente'] = '';
      $_SESSION['pnome_cliente'] = '';
      $_SESSION['snome_cliente'] = '';
      $_SESSION['tel_cliente'] = '';
    }

    if(isset($_POST['limpaFilial'])) {
      $_SESSION['nfantasia_filial'] = '';
      $_SESSION['cnpj_filial'] = '';
      $_SESSION['endereco_filial'] = '';
      $_SESSION['saudacoes_filial'] = ''; 
    }

    if(isset($_POST['limpaServico'])) {
      $_SESSION['cd_servico'] = '';
      $_SESSION['titulo_servico'] = '';
      $_SESSION['obs_servico'] = '';//_servico
      $_SESSION['prioridade_servico'] = '';
      $_SESSION['entrada_servico'] = '';
      $_SESSION['prazo_servico'] = '';
      $_SESSION['orcamento_servico'] = '';
      $_SESSION['vpag_servico'] = '';
    }
?>


<form method="post">
<input type="submit" id="loggout" name="loggout" class="dropdown-item preview-item" value="Loggout"></input>
                  <?php
                    if(isset($_POST['loggout'])) {
                        session_start();
                        $_SESSION['cd_pessoal'] = '';
                        session_destroy();
                    }
                  ?> 
</form>
</body>