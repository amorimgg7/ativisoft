<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="user-profile">
          <div class="user-image">
            <img src="<?php echo $_SESSION['foto_pessoal'];?>">
          </div>
          <div class="user-name">
            <?php echo $_SESSION['pnome_pessoal'].' '.$_SESSION['snome_pessoal']?>
          </div>
          <div class="user-designation">
            <p>Empresa: <?php echo $_SESSION['cd_empresa'];?></p>
            <p>Setor: <?php echo $_SESSION['cd_setor'];?></p>
            <p>Segurança: <?php echo $_SESSION['cd_seg'];?></p>
            <p>Estilo: <?php echo $_SESSION['cd_estilo'];?></p>
            <p>Empresa: <?php echo $_SESSION['cd_empresa'];?></p>
            <!--<p>Opa: <?php //echo $_SESSION['logo_empresa']; ?></p>-->
          </div>
        </div>
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="../../../_1_1_sistema">
              <i class="icon-box menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#painel-geral" aria-expanded="false" aria-controls="painel-geral">
              <i class="icon-disc menu-icon"></i>
              <span class="menu-title">Painel Geral</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="painel-geral">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="../../../_1_1_sistema/pages/painel-geral/pessoas.php">Pessoas</a></li>
                <li class="nav-item"> <a class="nav-link" href="../../../_1_1_sistema/pages/painel-geral/empresas.php">Empresas</a></li>
                <li class="nav-item"> <a class="nav-link" href="../../../_1_1_sistema/pages/painel-geral/patrimonios.php">Patrimonios</a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#cad-geral" aria-expanded="false" aria-controls="cad-geral">
              <i class="icon-disc menu-icon"></i>
              <span class="menu-title">Cadastro Geral</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="cad-geral">


              <a class="nav-link" data-toggle="collapse" href="#cad-basico" aria-expanded="false" aria-controls="cad-basico">
                <i class="icon-disc menu-icon"></i>
                <span class="menu-title">Basicos</span>
                <i class="menu-arrow"></i>
              </a>
              <!--
              <a class="nav-link" data-toggle="collapse" href="#cad-avancado" aria-expanded="false" aria-controls="cad-avancado">
                <i class="icon-disc menu-icon"></i>
                <span class="menu-title">Avançados</span>
                <i class="menu-arrow"></i>
              </a>
              -->
            </div>
            <div class="collapse" id="cad-basico">
            
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="../../../_1_1_sistema/pages/cad-basico/pessoal.php">Pessoal</a></li>
                <li class="nav-item"> <a class="nav-link" href="../../../_1_1_sistema/pages/cad-basico/empresa.php">Empresa</a></li>
                <li class="nav-item"> <a class="nav-link" href="../../../_1_1_sistema/pages/cad-basico/patrimonio.php">Patrimonio</a></li>
              </ul>
            </div>
            <!--
              <div class="collapse" id="cad-avancado">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="../../../_1_1_patrimonio/pages/forms/pessoas.php">Pessoas</a></li>
                <li class="nav-item"> <a class="nav-link" href="../../../_1_1_patrimonio/pages/painel-geral/empresas.php">Empresas</a></li>
                <li class="nav-item"> <a class="nav-link" href="../../../_1_1_patrimonio/pages/painel-geral/patrimonio.php">Patrimonios</a></li>
              </ul>
            </div>
            -->
          </li>
          
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
          <!--
          <li class="nav-item">
            <a class="nav-link" href="pages/forms/basic_elements.html">
              <i class="icon-file menu-icon"></i>
              <span class="menu-title">Form elements</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages/charts/chartjs.html">
              <i class="icon-pie-graph menu-icon"></i>
              <span class="menu-title">Charts</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages/tables/basic-table.html">
              <i class="icon-command menu-icon"></i>
              <span class="menu-title">Tables</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages/icons/feather-icons.html">
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
                <li class="nav-item"> <a class="nav-link" href="pages/samples/login.php"> Login </a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/samples/login-2.php"> Login 2 </a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/samples/register.php"> Register </a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/samples/register-2.php"> Register 2 </a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/samples/lock-screen.php"> Lockscreen </a></li>
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