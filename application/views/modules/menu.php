<nav class="navbar navbar-expand-lg main-menu navbar-pulpox">
  <a class="navbar-brand" href="#">Pulpox Ads</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu-toggler" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class=" navbar-toggler-icon "></span>
  </button>
  <div class="collapse navbar-collapse" id="main-menu-toggler">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item ">
        <a class="nav-link" href="<?php echo base_url() . 'index.php/inicio'?>">Inicio</a>
      </li>
      <?php if (isset($_SESSION['usuario_id'])) { ?> 
        <li class="nav-item ">
          <a class="nav-link active" href="<?php echo base_url() . 'index.php/misanuncios'?>" >Mis Anuncios</a>
        </li>
      <?php } ?> 
      <?php if (isset($_SESSION['usuario_id'])) { ?> 
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url() . 'index.php/mianuncio/nuevo/'?>">Nuevo Anuncio</a>
        </li>
      <?php } ?>  
    </ul>
    <div style=''>
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <?php if (!(isset($_SESSION['usuario_id']))) { ?> 
        <li class="nav-item btn-pulpox-login">
          <a class="nav-link btn-pulpox-login"  id='btn-pulpox-login' onclick="iniciarSesion()"><u>Ingresar</u></a>
        </li>
        <li class="nav-item btn-pulpox-singup">
          <a class="nav-link btn-pulpox-singup" id='btn-pulpox-singup' href="<?php echo base_url() . 'index.php/usuario/login/'?>">Crear Cuenta</a>
        </li>
      <?php } ?> 
      </ul>
    </div>
    <?php if (isset($_SESSION['usuario_id'])) { ?> 
      <div class="dropdown" id='dropdown_menu'>
        <a  class="dropdown-toggle pulpox-btn-white" id='boton-cuenta' href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php echo $_SESSION['usuario_usuario'] ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
          <a id='boton_micuenta' class="dropdown-item" href="#">Mi Cuenta</a>
          <a id='boton_salir' class="dropdown-item" >Salir</a>   
        </div>
      </div>
    <?php } ?>  

  </div>
</nav>

