<nav class="navbar navbar-expand-lg main-menu navbar-pulpox">
  <a class="navbar-brand" href="#">Pulpox Ads</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu-toggler" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class=" navbar-toggler-icon "></span>
  </button>
  <div class="collapse navbar-collapse" id="main-menu-toggler">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item active">
        <a class="nav-link" href="#">Inicio <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url() . 'index.php/' .'misanuncios'?>" >Mis Anuncios</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url() . 'index.php/' .'mianuncio/nuevo/'?>">Nuevo Anuncio</a>
      </li>
    </ul>


    <div class="dropdown" id='dropdown_menu'>
      <a  class="btn btn-secondary dropdown-toggle" id='boton-cuenta' href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      c.dzul
      </a>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
        <a class="dropdown-item" href="#">Mi Cuenta</a>
        <a class="dropdown-item" href="#">Salir</a>   
      </div>
    </div>





  </div>
</nav>

