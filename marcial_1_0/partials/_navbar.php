
  <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row" >
    <div id="load" class="" style="z-index: 1050; dosplay:none;">
    <?php include("../../partials/load.html");?>
  </div>
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center" style="background-color:#36433c; color:#fff;">
        <a class="navbar-brand brand-logo" href="<?php $_SESSION['dominio'];?>"><img src="<?php $_SESSION['dominio'];?>images/logo-mini.svg" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="<?php $_SESSION['dominio'];?>"><img src="<?php $_SESSION['dominio'];?>images/logo-mini.svg" alt="logo"/></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end" style="background-color:#424d47; color:#fff;">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav mr-lg-2">
          <li class="nav-item nav-search d-none d-lg-block">
          </li>
        </ul>
        <form method="post">
          <ul class="navbar-nav navbar-nav-right">
            </li>
            <li class="nav-item dropdown d-flex mr-4 ">
              <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center" id="notificationDropdown" href="#" data-toggle="dropdown">
                <i class="icon-cog"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown" style="background-color:#36433c; color:#fff;">
                <p class="mb-0 font-weight-normal float-left dropdown-header">Settings</p>
                

                <!--<a class="dropdown-item preview-item" >
                <i class="icon-head"></i>
                  <input type="submit" id="profile" name="profile" class="dropdown-item preview-item" value="Perfil"></input>
                  <?php 
                    if(isset($_POST['profile'])) {
                      //header("location: http://amorimgg77.lovestoblog.com/pages/samples/profile.php");
                      //echo '<script>location.href="'.$_SESSION['dominio'].'pages/samples/profile.php";</script>';
                    }
                  ?>    
                </a>-->

                <a class="dropdown-item preview-item">
                <i class="icon-unlock"></i>
                  <input type="submit" id="loggout" name="loggout" class="dropdown-item preview-item" value="Loggout"></input>
                  <?php 
                    if(isset($_POST['loggout'])) {
                      //$u->loggout();
                      loggout();
                    }
                  ?>    
                </a>
              </div>
            </li>
            <li class="nav-item dropdown mr-4 d-lg-flex d-none">
              <a class="nav-link count-indicatord-flex align-item s-center justify-content-center" href="#">
                <i class="icon-grid"></i>
              </a>
            </li>
          </ul>
        </form>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </div>
    </nav>
    <style>
section {
    display: none;
}

section.active {
    display: block;
}
</style>