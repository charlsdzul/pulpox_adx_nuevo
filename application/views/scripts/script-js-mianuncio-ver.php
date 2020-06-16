<script>
  /**
    * Scripts para la sección Ver Anuncio: eliminar y cambiar estatus.
   */
  $(document).ready(function() {  
    let datos_anuncio = <?php echo json_encode($datos_anuncio); ?>;
    asignaValores(datos_anuncio)   
    creaCarousel(datos_anuncio) 
  }); 

</script>