<script>

  const BASE_URL = "<?php echo base_url();?>" + "index.php/";
  var datos_anuncio = <?php echo json_encode($datos_anuncio); ?>;

  $(document).ready(function() {  
    asignaValores(datos_anuncio)   
    creaCarousel(datos_anuncio) 
  }); 

  function eliminarAnuncio(){    
    id= datos_anuncio.public_id;
      $.confirm({
        icon: 'fas fa-info-circle',
        title: 'Eliminar Anuncio',
        type: 'red',
        columnClass: 'medium',
        backgroundDismiss: true,
        content: `
          <b>¿Realmente desea eliminarlo?</b><br><br>Recuerde: 
          <label>El anuncio se eliminará y nadie podrá verlo, aunque tú podrás verlo en 'Mis Anuncios'.</label>                        
        `,
        closeIcon:true,
        buttons: {
          cerrar: {
            text: 'Cancelar',
              btnClass: 'btn-pulpox-danger--line',                 
              action: function(){
              }
          },
          eliminarAnuncio:{
            text: `Sí, eliminar este anuncio`,
            btnClass: 'btn-pulpox-danger',
            action:function(){
              let dialog_eliminando = $.dialog({
                  icon: 'fa fa-spinner fa-spin',
                  title: 'Eliminar Anuncio',
                  type: 'green',
                  content: 'Estamos eliminando tu anuncio...',
                  closeIcon:false,
              }); 
              $.post(BASE_URL+'mianuncio/eliminar/', {id})
              .done(function(response){
                var data = JSON.parse(response) 
                dialog_eliminando.close();               
                if(data.codigo == 0){
                  $.confirm({
                    icon: 'fas fa-check-circle',
                    title: 'Eliminar Anuncio',
                    type: 'green',
                    columnClass: 'medium',
                    content: data.mensaje,
                    closeIcon:true,
                    buttons: {
                      ok: {
                        text: 'Ok',
                          btnClass: 'btn-pulpox-secondary--line',                           
                          action: function(){
                            window.location.replace(BASE_URL+'misanuncios/');
                          }
                      },                  
                    }
                });  
                }else{
                  $.confirm({
                    icon: 'fas fa-exclamation-circle',
                    title: 'Eliminar Anuncio',
                    type: 'red',
                    columnClass: 'medium',
                    content: data.mensaje,
                    closeIcon:true,
                    buttons: {
                      ok: {
                        text: 'Ok',
                          btnClass: 'btn-pulpox-secondary--line',
                          keys: ['escape'],
                          action: function(){
                          }
                      },                  
                    }
                  });  
                }               
              }) 
              .fail(function() {
                dialog_eliminando.close();   
                  $.confirm({
                    title: 'Detectamos un problema.',
                    content: 'Nuestro servidor tiene problemas actualmente. Intente más tarde.',
                    type: 'red',
                    typeAnimated: true,
                    buttons: {               
                        close: function () {
                        }
                    }
                  });
                }) 
            },
          },             
        }
      });
  }

</script>