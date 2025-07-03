<script>
  var timeout;
  function resetTimer() {
    clearTimeout(timeout);
  	timeout = setTimeout(function() {
  	//window.alert("Você ficou inativo por 1 Minuto!");
    //window.alert("Acesse novamente para continuar!");
    location.href="<?php echo $_SESSION['dominio'].'pages/samples/lock-screen.php'; ?>";
  }, 600000); // 5 segundos
}
</script>
<style>
  <?php //echo $_SESSION['c_sidebar']?>
  /*
  #sidebar #sidebar-offcanvas{
    style="background-color: #a7dbfb; color: #044167;"
  }
  */
</style>

<nav class="sidebar sidebar-offcanvas " id="sidebar" <?php echo $_SESSION['c_sidebar']?>>
        <div class="user-profile" <?php echo $_SESSION['c_sidebar']?>>
          <!--<div class="user-image">
            <img src="<?php //echo $_SESSION['foto_pessoal'];?>">
          </div>-->
          <div class="user-image">
            <?php
            /*
              if(isset($_SESSION['cnpj_empresa'])){
                $caminho_pasta_empresa = "../web/imagens/".$_SESSION['cnpj_empresa']."//logos/";
                $foto_empresa = "LogoEmpresa.jpg"; // Nome do arquivo que será salvo
                $caminho_foto_empresa = $caminho_pasta_empresa . $foto_empresa;

                if (file_exists($caminho_foto_empresa)) {
                  $tipo_foto_empresa = mime_content_type($caminho_foto_empresa);
                    echo '<img src="'.$caminho_foto_empresa. '">';
                }else{
                  echo '<img src="https://lh3.googleusercontent.com/pw/AP1GczOReqQClzL-PZkykfOwgmMyVzQgx27DTp783MI7iwKuKSv-6P6V7KOEbCC74sGdK3DEV3O88CsBLeIvOaQwGT3x4bqCTPRtyV9zcODbYVDRxAF8zf8Uev7geh4ONPdl3arNhnSDPvbQfMdpFRPM263V9A=w250-h250-s-no-gm?authuser=0">';
                }
              }
                */
            ?>
          </div>
          <div class="user-name" id="user_name">
            <?php echo 'Olá, '.$_SESSION['pnome_colab'].' '.$_SESSION['snome_colab']?>
          </div>

          <div class="user-designation">
            <!--<p>CNPJ: <?php //echo $_SESSION['cnpj_empresa'];?></p>-->
            <!--<p>CPF: <?php //echo $_SESSION['cpf_colab'];?></p>-->
            <!--<p>Senha Pessoal: <?php //echo $_SESSION['senha_pessoal'];?></p>-->
            <!--<p>Segurança: <?php //echo $_SESSION['cd_seg'];?></p>-->
            <!--<p>Estilo: <?php //echo $_SESSION['cd_estilo'];?></p>-->
            <!--<p <?php //echo $_SESSION['c_sidebar'];?>>c_sidebar:</p>
            <p <?php //echo $_SESSION['t_sidebar'];?>>t_sidebar:</p>

            <p <?php //echo $_SESSION['c_navbar'];?>>c_navbar:</p>
            <p <?php //echo $_SESSION['t_navbar'];?>>t_navbar:</p>

            <p <?php //echo $_SESSION['c_font'];?>>c_font:</p>
            <p <?php //echo $_SESSION['t_font'];?>>t_font:</p>

            <p>patrimonio: <?php //echo $_SESSION['md_patrimonio'];?></p>
            <p>Folha de ponto<?php //echo $_SESSION['md_fponto'];?></p>
            <p>Assistente <?php //echo $_SESSION['md_assistencia'];?></p>
            <p>Cliente <?php //echo $_SESSION['md_cliente'];?></p>
            <p>Fornecedor <?php //echo $_SESSION['md_venda'];?></p>-->


            <!--<p>Pessoal: <?php //echo $_SESSION['cd_colab'];?></p>-->
            <!--<p>Empresa: <?php //echo $_SESSION['cd_empresa'];?></p>-->
            <!--<p>Setor: <?php //echo $_SESSION['cd_setor'];?></p>-->
            <!--<p>Função: <?php //echo $_SESSION['cd_funcao'];?></p>-->
          </div>

        </div>
        <ul class="nav" id="sidebar_geral">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $_SESSION['dominio'];?>/pages/dashboard">
              <i class="icon-box menu-icon" <?php echo $_SESSION['c_sidebar']?>></i>
              <span class="menu-title" <?php echo $_SESSION['c_sidebar']?>>Dashboard</span>
            </a>
          </li>

<?php 
if($_SESSION['cd_acesso'] == 1){
  echo '
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#cliente_comercial" aria-expanded="false" aria-controls="cliente_comercial">
              <i class="icon-disc menu-icon" '.$_SESSION['c_sidebar'].'></i>
              <span class="menu-title" '.$_SESSION['c_sidebar'].'>Cliente Comercial</span>
              <i class="menu-arrow" '.$_SESSION['c_sidebar'].'></i>
            </a>
            
            <div class="collapse" id="cliente_comercial">
            
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a '.$_SESSION['c_sidebar'].' class="nav-link" href="'.$_SESSION['dominio'].'/pages/md_fornecedor/listar_cliente_comercial.php">Listar</a></li>
                <li class="nav-item"><a '.$_SESSION['c_sidebar'].' class="nav-link" href="'.$_SESSION['dominio'].'/pages/md_fornecedor/cadastrar_cliente_comercial.php">Cadastrar</a></li>
                <li class="nav-item"><a '.$_SESSION['c_sidebar'].' class="nav-link" href="'.$_SESSION['dominio'].'/pages/md_fornecedor/consultar_cliente_comercial.php">Consultar</a></li>
              </ul>
            </div> 
          </li>
          ';
}

?>

          
          <li class="nav-item" <?php echo $_SESSION['cad_geral'];?>>
            <a class="nav-link" data-toggle="collapse" href="#cadastros" aria-expanded="false" aria-controls="cadastros">
              <i class="icon-disc menu-icon" <?php echo $_SESSION['c_sidebar']?>></i>
              <span class="menu-title" <?php echo $_SESSION['c_sidebar']?>>Cadastros</span>
              <i class="menu-arrow" <?php echo $_SESSION['c_sidebar']?>></i>
            </a>
            
            <div class="collapse" id="cadastros">
            
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a <?php echo $_SESSION['c_sidebar']?>class="nav-link" href="<?php echo $_SESSION['dominio'];?>/pages/cad_geral/unidade_operacional.php">Empresa</a></li>
                <li class="nav-item"><a <?php echo $_SESSION['c_sidebar']?>class="nav-link" href="<?php echo $_SESSION['dominio'];?>/pages/cad_geral/cadastro_colaborador.php">Funcionario</a></li>
                <li class="nav-item"><a <?php echo $_SESSION['c_sidebar']?>class="nav-link" href="<?php echo $_SESSION['dominio'];?>/pages/cad_geral/consulta_cliente.php">Cliente</a></li>
                <li class="nav-item" <?php echo $_SESSION['md_venda'];?>><a <?php echo $_SESSION['c_sidebar']?>class="nav-link" href="<?php echo $_SESSION['dominio'];?>/pages/cad_geral/cadastro_produto.php">Produtos</a></li>
                <!--<li class="nav-item" <?php //echo $_SESSION['md_patrimonio'];?>><a <?php //echo $_SESSION['c_sidebar']?>class="nav-link" href="<?php //echo $_SESSION['dominio'];?>/pages/md_patrimonio/cadastro_patrimonio.php">Patrimônio</a></li>-->
                <!--<li class="nav-item" <?php //echo $_SESSION['md_hospedagem'];?>><a <?php //echo $_SESSION['c_sidebar']?>class="nav-link" href="<?php //echo $_SESSION['dominio'];?>/pages/md_hospedagem/editar_casa.php">Imóvel</a></li>-->
              </ul>
            </div>
          
          </li>

          <li class="nav-item" <?php echo $_SESSION['md_assistencia'];?>>
            
            <a class="nav-link" data-toggle="collapse" href="#os_assistencia" aria-expanded="false" aria-controls="os_assistencia">
              <i class="icon-disc menu-icon" <?php echo $_SESSION['c_sidebar']?>></i>
              <span class="menu-title" <?php echo $_SESSION['c_sidebar']?>>Serviços</span>
              <i class="menu-arrow" <?php echo $_SESSION['c_sidebar']?>></i>
            </a>
            
            <div class="collapse" id="os_assistencia">
            
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a <?php echo $_SESSION['c_sidebar']?>class="nav-link" href="<?php echo $_SESSION['dominio'];?>/pages/md_assistencia/cadastro_servico.php">Novo</a></li>
                <li class="nav-item"><a <?php echo $_SESSION['c_sidebar']?>class="nav-link" href="<?php echo $_SESSION['dominio'];?>/pages/md_assistencia/consulta_servico.php">Consultar</a></li>
                <li class="nav-item"><a <?php echo $_SESSION['c_sidebar']?>class="nav-link" href="<?php echo $_SESSION['dominio'];?>/pages/md_assistencia/acompanha_servico.php">Acompanhar</a></li>
              </ul>
            </div> 
          </li>


          <li class="nav-item" <?php echo $_SESSION['md_venda'];?>>
            <a class="nav-link" data-toggle="collapse" href="#vendas" aria-expanded="false" aria-controls="vendas">
              <i class="icon-disc menu-icon" <?php echo $_SESSION['c_sidebar']?>></i>
              <span class="menu-title" <?php echo $_SESSION['c_sidebar']?>>Vendas</span>
              <i class="menu-arrow" <?php echo $_SESSION['c_sidebar']?>></i>
            </a>
            
            <div class="collapse" id="vendas">
            
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a <?php echo $_SESSION['c_sidebar']?>class="nav-link" href="<?php echo $_SESSION['dominio'];?>/pages/md_vendas/nova_venda.php">Nova Venda</a></li>
                <li class="nav-item"><a <?php echo $_SESSION['c_sidebar']?>class="nav-link" href="<?php echo $_SESSION['dominio'];?>/pages/md_vendas/historico_vendas.php">Histórico</a></li>
                <li class="nav-item"><a <?php echo $_SESSION['c_sidebar']?>class="nav-link" href="<?php echo $_SESSION['dominio'];?>/pages/md_lanchonete/nova_conta.php">Fiado</a></li>
              </ul>
            </div> 
          </li>

          <li class="nav-item" <?php echo $_SESSION['md_assistencia'];?>>
            <a class="nav-link" data-toggle="collapse" href="#relatorios" aria-expanded="false" aria-controls="relatorios">
              <i class="icon-disc menu-icon" <?php echo $_SESSION['c_sidebar']?>></i>
              <span class="menu-title" <?php echo $_SESSION['c_sidebar']?>>Caixas</span>
              <i class="menu-arrow" <?php echo $_SESSION['c_sidebar']?>></i>
            </a>
            
            <div class="collapse" id="relatorios">
            
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a <?php echo $_SESSION['c_sidebar']?>class="nav-link" href="<?php echo $_SESSION['dominio'];?>/pages/md_caixa/conferencia_caixa.php">Conferencia</a></li>
                <li class="nav-item"><a <?php echo $_SESSION['c_sidebar']?>class="nav-link" href="<?php echo $_SESSION['dominio'];?>/pages/md_caixa/relatorios_caixa.php">Relatórios</a></li>
              </ul>
            </div> 
          </li>


          

<!--
          <li class="nav-item" <?php //echo $_SESSION['md_cliente'];?>>
            <a class="nav-link" data-toggle="collapse" href="#md_cliente" aria-expanded="false" aria-controls="md_cliente">
              <i class="icon-disc menu-icon" <?php //echo $_SESSION['c_sidebar']?>></i>
              <span class="menu-title" <?php //echo $_SESSION['c_sidebar']?>>Cliente</span>
              <i class="menu-arrow" <?php //echo $_SESSION['c_sidebar']?>></i>
            </a>
            <div class="collapse" id="md_cliente">


              <a class="nav-link" data-toggle="collapse" href="#painel_cliente" aria-expanded="false" aria-controls="painel_cliente">
                <i class="icon-disc menu-icon" <?php //echo $_SESSION['c_sidebar']?>></i>
                <span class="menu-title" <?php //echo $_SESSION['c_sidebar']?>>Painel</span>
                <i class="menu-arrow" <?php //echo $_SESSION['c_sidebar']?>></i>
              </a>
              
              <a class="nav-link" data-toggle="collapse" href="#cadastro_cliente" aria-expanded="false" aria-controls="cadastro_cliente">
                <i class="icon-disc menu-icon" <?php //echo $_SESSION['c_sidebar']?>></i>
                <span class="menu-title" <?php //echo $_SESSION['c_sidebar']?>>Cadastro</span>
                <i class="menu-arrow" <?php //echo $_SESSION['c_sidebar']?>></i>
              </a>

              <a class="nav-link" data-toggle="collapse" href="#movimento_cliente" aria-expanded="false" aria-controls="movimento_cliente">
                <i class="icon-disc menu-icon" <?php //echo $_SESSION['c_sidebar']?>></i>
                <span class="menu-title" <?php //echo $_SESSION['c_sidebar']?>>Movimento</span>
                <i class="menu-arrow" <?php //echo $_SESSION['c_sidebar']?>></i>
              </a>
              
            </div>
            <div class="collapse" id="painel_cliente">
            
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a <?php //echo $_SESSION['c_sidebar']?>class="nav-link" href="<?php //echo $_SESSION['dominio'];?>pages/md_cliente/painel_pessoal.php">Funcionario</a></li>
                <li class="nav-item"> <a <?php //echo $_SESSION['c_sidebar']?>class="nav-link" href="<?php //echo $_SESSION['dominio'];?>pages/md_cliente/painel_patrimonio.php">Patrimonio</a></li>
                <li class="nav-item"> <a <?php //echo $_SESSION['c_sidebar']?>class="nav-link" href="<?php //echo $_SESSION['dominio'];?>pages/md_cliente/painel_empresa.php">Empresa</a></li>
              </ul>
            </div>
            
            <div class="collapse" id="cadastro_cliente">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a <?php //echo $_SESSION['c_sidebar']?>class="nav-link" href="<?php //echo $_SESSION['dominio'];?>pages/md_cliente/cadastro_pessoal.php">Funcionario</a></li>
                <li class="nav-item"> <a <?php //echo $_SESSION['c_sidebar']?>class="nav-link" href="<?php //echo $_SESSION['dominio'];?>pages/md_cliente/cadastro_patrimonio.php">Patrimonio</a></li>
                <li class="nav-item"> <a <?php //echo $_SESSION['c_sidebar']?>class="nav-link" href="<?php //echo $_SESSION['dominio'];?>pages/md_cliente/cadastro_empresa.php">Empresa/Filial</a></li>
              </ul>
            </div>
            
            <div class="collapse" id="movimento_cliente">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a <?php echo $_SESSION['c_sidebar']?>class="nav-link" href="<?php echo $_SESSION['dominio'];?>pages/md_cliente/movimento_patrimonio.php">Equipamento</a></li>
              </ul>
            </div>

          </li>
-->
          <li class="nav-item" <?php //echo $_SESSION['md_venda'];?> style="display: none;">1
            <a class="nav-link" data-toggle="collapse" href="#md_cliente" aria-expanded="false" aria-controls="md_cliente">
              <i class="icon-disc menu-icon" <?php echo $_SESSION['c_sidebar']?>></i>
              <span class="menu-title" <?php echo $_SESSION['c_sidebar']?>>Fornecedor</span>
              <i class="menu-arrow" <?php echo $_SESSION['c_sidebar']?>></i>
            </a>
            <div class="collapse" id="md_cliente">


              <a class="nav-link" data-toggle="collapse" href="#painel_cliente" aria-expanded="false" aria-controls="painel_cliente">
                <i class="icon-disc menu-icon" <?php echo $_SESSION['c_sidebar']?>></i>
                <span class="menu-title" <?php echo $_SESSION['c_sidebar']?>>Painel</span>
                <i class="menu-arrow" <?php echo $_SESSION['c_sidebar']?>></i>
              </a>
              
              <a class="nav-link" data-toggle="collapse" href="#cadastro_cliente" aria-expanded="false" aria-controls="cadastro_cliente">
                <i class="icon-disc menu-icon" <?php echo $_SESSION['c_sidebar']?>></i>
                <span class="menu-title" <?php echo $_SESSION['c_sidebar']?>>Cadastro</span>
                <i class="menu-arrow" <?php echo $_SESSION['c_sidebar']?>></i>
              </a>
              
            </div>
            <div class="collapse" id="painel_cliente">
            
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a <?php echo $_SESSION['c_sidebar']?>class="nav-link" href="<?php echo $_SESSION['dominio'];?>pages/paineis/basico-pessoal.php">Pessoal</a></li>
                <li class="nav-item"> <a <?php echo $_SESSION['c_sidebar']?>class="nav-link" href="<?php echo $_SESSION['dominio'];?>pages/paineis/basico-empresas.php">Empresa</a></li>
                <li class="nav-item"> <a <?php echo $_SESSION['c_sidebar']?>class="nav-link" href="<?php echo $_SESSION['dominio'];?>pages/paineis/basico-patrimonios.php">Patrimonio</a></li>
              </ul>
            </div>
            
              <div class="collapse" id="cadastro_cliente">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a <?php echo $_SESSION['c_sidebar']?>class="nav-link" href="<?php echo $_SESSION['dominio'];?>pages/paineis/complementar-pessoal.php">Pessoas</a></li>
                <li class="nav-item"> <a <?php echo $_SESSION['c_sidebar']?>class="nav-link" href="<?php echo $_SESSION['dominio'];?>pages/paineis/complementar-empresas.php">Empresas</a></li>
                <li class="nav-item"> <a <?php echo $_SESSION['c_sidebar']?>class="nav-link" href="<?php echo $_SESSION['dominio'];?>pages/paineis/complementar-patrimonios.php">Patrimonios</a></li>
              </ul>
            </div>  
          </li>






          <li class="nav-item" <?php //echo $_SESSION['md_venda'];?> style="display: block;">
            <a class="nav-link" data-toggle="collapse" href="#md_tools" aria-expanded="false" aria-controls="md_tools">
              <i class="icon-disc menu-icon" <?php echo $_SESSION['c_sidebar']?>></i>
              <span class="menu-title" <?php echo $_SESSION['c_sidebar']?>>Ferramentas</span>
              <i class="menu-arrow" <?php echo $_SESSION['c_sidebar']?>></i>
            </a>
            <div class="collapse" id="md_tools">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a <?php echo $_SESSION['c_sidebar']?>class="nav-link" href="<?php echo $_SESSION['dominio'];?>pages/tools/config-impressora.html">Impressora</a></li>
              </ul>
            </div>
          </li>


          
<!--


          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#painel-geral" aria-expanded="false" aria-controls="painel-geral">
              <i class="icon-disc menu-icon" <?php //echo $_SESSION['c_sidebar']?>></i>
              <span class="menu-title" <?php //echo $_SESSION['c_sidebar']?>>Paineis</span>
              <i class="menu-arrow" <?php //echo $_SESSION['c_sidebar']?>></i>
            </a>
            <div class="collapse" id="painel-geral">


              <a class="nav-link" data-toggle="collapse" href="#painel-basico" aria-expanded="false" aria-controls="painel-basico">
                <i class="icon-disc menu-icon" <?php //echo $_SESSION['c_sidebar']?>></i>
                <span class="menu-title" <?php //echo $_SESSION['c_sidebar']?>>Basicos</span>
                <i class="menu-arrow" <?php //echo $_SESSION['c_sidebar']?>></i>
              </a>
              
              <a class="nav-link" data-toggle="collapse" href="#painel-complementar" aria-expanded="false" aria-controls="painel-complementar">
                <i class="icon-disc menu-icon" <?php //echo $_SESSION['c_sidebar']?>></i>
                <span class="menu-title" <?php //echo $_SESSION['c_sidebar']?>>Complementar</span>
                <i class="menu-arrow" <?php //echo $_SESSION['c_sidebar']?>></i>
              </a>
              
            </div>
            <div class="collapse" id="painel-basico">
            
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a <?php //echo $_SESSION['c_sidebar']?>class="nav-link" href="http://amorimgg77.lovestoblog.com/pages/paineis/basico-pessoal.php">Pessoal</a></li>
                <li class="nav-item"> <a <?php //echo $_SESSION['c_sidebar']?>class="nav-link" href="http://amorimgg77.lovestoblog.com/pages/paineis/basico-empresas.php">Empresa</a></li>
                <li class="nav-item"> <a <?php //echo $_SESSION['c_sidebar']?>class="nav-link" href="http://amorimgg77.lovestoblog.com/pages/paineis/basico-patrimonios.php">Patrimonio</a></li>
              </ul>
            </div>
            
              <div class="collapse" id="painel-complementar">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a <?php //echo $_SESSION['c_sidebar']?>class="nav-link" href="../../../_1_1_sistema/pages/paineis/complementar-pessoal.php">Pessoas</a></li>
                <li class="nav-item"> <a <?php //echo $_SESSION['c_sidebar']?>class="nav-link" href="../../../_1_1_sistema/pages/paineis/complementar-empresas.php">Empresas</a></li>
                <li class="nav-item"> <a <?php //echo $_SESSION['c_sidebar']?>class="nav-link" href="http://amorimgg77.lovestoblog.com/pages/paineis/complementar-patrimonios.php">Patrimonios</a></li>
              </ul>
            </div>
            
          </li>





          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#cad-geral" aria-expanded="false" aria-controls="cad-geral">
              <i class="icon-disc menu-icon" <?php echo $_SESSION['c_sidebar']?>></i>
              <span class="menu-title" <?php echo $_SESSION['c_sidebar']?>>Cadastros</span>
              <i class="menu-arrow" <?php echo $_SESSION['c_sidebar']?>></i>
            </a>
            <div class="collapse" id="cad-geral">


              <a class="nav-link" data-toggle="collapse" href="#cad-basico" aria-expanded="false" aria-controls="cad-basico">
                <i class="icon-disc menu-icon" <?php echo $_SESSION['c_sidebar']?>></i>
                <span class="menu-title" <?php echo $_SESSION['c_sidebar']?>>Basicos</span>
                <i class="menu-arrow" <?php echo $_SESSION['c_sidebar']?>></i>
              </a>
              <a class="nav-link" data-toggle="collapse" href="#cad-complementar" aria-expanded="false" aria-controls="cad-complementar">
                <i class="icon-disc menu-icon" <?php echo $_SESSION['c_sidebar']?>></i>
                <span class="menu-title" <?php echo $_SESSION['c_sidebar']?>>Complementar</span>
                <i class="menu-arrow" <?php echo $_SESSION['c_sidebar']?>></i>
              </a>
              
              <a class="nav-link" data-toggle="collapse" href="#cad-avancado" aria-expanded="false" aria-controls="cad-avancado">
                <i class="icon-disc menu-icon"></i>
                <span class="menu-title">Avançados</span>
                <i class="menu-arrow"></i>
              </a>

            </div>
            <div class="collapse" id="cad-basico">
            
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a <?php echo $_SESSION['c_sidebar']?> class="nav-link" href="http://amorimgg77.lovestoblog.com/pages/cad-geral/basico-pessoal.php">Pessoal</a></li>
                <li class="nav-item"> <a <?php echo $_SESSION['c_sidebar']?> class="nav-link" href="http://amorimgg77.lovestoblog.com/pages/cad-geral/basico-empresa.php">Empresa</a></li>
                <li class="nav-item"> <a <?php echo $_SESSION['c_sidebar']?> class="nav-link" href="http://amorimgg77.lovestoblog.com/pages/cad-geral/basico-patrimonio.php">Patrimonio</a></li>
              </ul>
            </div>
           
              <div class="collapse" id="cad-complementar">
              <ul class="nav flex-column sub-menu">
                
                <li class="nav-item"> <a class="nav-link" href="../../../_1_1_patrimonio/pages/forms/pessoas.php">Pessoas</a></li>
                <li class="nav-item"> <a class="nav-link" href="../../../_1_1_patrimonio/pages/painel-geral/empresas.php">Empresas</a></li>
                <li class="nav-item"> <a <?php echo $_SESSION['c_sidebar']?> class="nav-link" href="http://amorimgg77.lovestoblog.com/pages/cad-geral/complementar-setor.php">Setores</a></li>
              </ul>
            </div>

            
          </li>






          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#folhade-ponto" aria-expanded="false" aria-controls="folhade-ponto">
              <i class="icon-disc menu-icon" <?php echo $_SESSION['c_sidebar']?>></i>
              <span class="menu-title" <?php echo $_SESSION['c_sidebar']?>>Folha de Ponto</span>
              <i class="menu-arrow" <?php echo $_SESSION['c_sidebar']?>></i>
            </a>
            <div class="collapse" id="folhade-ponto">

              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a <?php echo $_SESSION['c_sidebar']?> class="nav-link" href="http://amorimgg77.lovestoblog.com/pages/folhade-ponto/bater-ponto.php">Bater Ponto</a></li>
              </ul>

            
              <a class="nav-link" data-toggle="collapse" href="#mapa" aria-expanded="false" aria-controls="mapa">
                <i class="icon-disc menu-icon" <?php echo $_SESSION['c_sidebar']?>></i>
                <span class="menu-title" <?php echo $_SESSION['c_sidebar']?>>Mapa</span>
                <i class="menu-arrow" <?php echo $_SESSION['c_sidebar']?>></i>
              </a>
   
              <a class="nav-link" data-toggle="collapse" href="#cad-avancado" aria-expanded="false" aria-controls="cad-avancado">
                <i class="icon-disc menu-icon"></i>
                <span class="menu-title">Avançados</span>
                <i class="menu-arrow"></i>
              </a>
            </div>
            <div class="collapse" id="mapa">
            
              <ul class="nav flex-column sub-menu">
                <li class="nav-item" <?php echo $_SESSION['c_sidebar']?>> <a <?php echo $_SESSION['c_sidebar']?> class="nav-link" href="../../../_1_1_sistema/pages/folhade-ponto/mapa1.php">Mapa 1</a></li>
                <li class="nav-item"> <a <?php echo $_SESSION['c_sidebar']?> class="nav-link" href="http://amorimgg77.lovestoblog.com/pages/folhade-ponto/mapa2.php">Mapa 2</a></li>
              </ul>
            </div>
            
              <div class="collapse" id="cad-avancado">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="../../../_1_1_patrimonio/pages/forms/pessoas.php">Pessoas</a></li>
                <li class="nav-item"> <a class="nav-link" href="../../../_1_1_patrimonio/pages/painel-geral/empresas.php">Empresas</a></li>
                <li class="nav-item"> <a class="nav-link" href="../../../_1_1_patrimonio/pages/painel-geral/patrimonio.php">Patrimonios</a></li>
              </ul>
            </div>

            
          </li>-->










          <!--
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="icon-disc menu-icon"></i>
              <span class="menu-title">UI Elements</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="../../../_1_1_sistema/pages/ui-features/buttons.html">Buttons</a></li>
                <li class="nav-item"> <a class="nav-link" href="../../../_1_1_sistema/pages/ui-features/typography.html">Typography</a></li>
              </ul>
            </div>
          </li>
         -- 
          <li class="nav-item">
            <a class="nav-link" href="../../../_1_1_sistema/pages/forms/basic_elements.html">
              <i class="icon-file menu-icon"></i>
              <span class="menu-title">Form elements</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../../_1_1_sistema/pages/charts/chartjs.html">
              <i class="icon-pie-graph menu-icon"></i>
              <span class="menu-title">Charts</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../../_1_1_sistema/pages/tables/basic-table.html">
              <i class="icon-command menu-icon"></i>
              <span class="menu-title">Tables</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../../_1_1_sistema/pages/icons/feather-icons.html">
              <i class="icon-help menu-icon"></i>
              <span class="menu-title">Icons</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
              <i class="icon-head menu-icon"></i>
              <span class="menu-title">User Pages</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="../../../_1_1_sistema/pages/samples/login.php"> Login </a></li>
                <li class="nav-item"> <a class="nav-link" href="../../../_1_1_sistema/pages/samples/login-2.php"> Login 2 </a></li>
                <li class="nav-item"> <a class="nav-link" href="../../../_1_1_sistema/pages/samples/register.php"> Register </a></li>
                <li class="nav-item"> <a class="nav-link" href="../../../_1_1_sistema/pages/samples/register-2.php"> Register 2 </a></li>
                <li class="nav-item"> <a class="nav-link" href="../../../_1_1_sistema/pages/samples/lock-screen.php"> Lockscreen </a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="docs/documentation.html">
              <i class="icon-book menu-icon"></i>
              <span class="menu-title">Documentation</span>
            </a>
          </li>
-->
        </ul>
      </nav>