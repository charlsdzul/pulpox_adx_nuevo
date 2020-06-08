<script>

  const BASE_URL = "<?php echo base_url();?>" + "index.php/";
  var datos_anuncio = <?php echo json_encode($datos_anuncio); ?>;

  $(document).ready(function() {  
    asignaValores(datos_anuncio)   
    creaCarousel(datos_anuncio) 
  }); 

</script>

