<script>

  const BASE_URL = "<?php echo base_url();?>index.php/";
  var datos_anuncio = <?php echo json_encode($datos_anuncio); ?>;

  $(document).ready(function() {  
    asignaValores(datos_anuncio)   
    creaCarousel(datos_anuncio) 
  }); 

  function eliminarAnuncio(){    
    id= datos_anuncio.public_id;
      $.confirm({
        icon: 'fas fa-info-circle',
        title: '<spam class="titulo-confirm">Eliminar Anuncio<spam>',
        type: 'blue',
        columnClass: 'medium',
        backgroundDismiss: true,
        content: `<div class='contenido-confirm'>
          <b>¿Realmente desea eliminarlo?</b><br><br>Recuerde: 
          <label>El anuncio se eliminará y nadie podrá verlo, aunque tú podrás verlo en 'Mis Anuncios'.</label></div>                       
        `,
        buttons: {
          cerrar: {
            text: 'Cancelar',
              btnClass: 'btn-pulpox-danger--line', 
              keys: ['escape'],  
          },
          eliminarAnuncio:{
            text: `Sí, eliminar este anuncio`,
            btnClass: 'btn-pulpox-info',
            keys: ['enter'], 
            action:function(){
              let dialog_eliminando = $.dialog({
                  icon: 'fa fa-spinner fa-spin',
                  title: '<spam class="titulo-confirm">Eliminar Anuncio<spam>',
                  type: 'blue',
                  content: "<div class='contenido-confirm'>Estamos eliminando tu anuncio...</div>",
                  closeIcon:false,
              }); 
              $.post(BASE_URL+'mianuncio/eliminar/', {id})
              .done(function(response){
                var data = JSON.parse(response) 
                dialog_eliminando.close();               
                if(data.codigo == 0){
                  $.confirm({
                    icon: 'fas fa-check-circle',
                    title: '<spam class="titulo-confirm">Eliminar Anuncio<spam>',
                    type: 'green',
                    columnClass: 'medium',
                    backgroundDismiss: true,
                    content: `<div class='contenido-confirm'>${data.mensaje}</div>`,
                    buttons: {
                      ok: {
                      text: 'Ok',
                        btnClass: 'btn-pulpox-success', 
                        keys: ['enter'],                          
                        action: function(){
                          window.location.replace(BASE_URL+'misanuncios/');
                         }
                      },                  
                    }
                });  
                }else{
                  $.confirm({
                    icon: 'fas fa-exclamation-circle',
                    title: '<spam class="titulo-confirm">Eliminar Anuncio<spam>',
                    type: 'red',
                    columnClass: 'medium',
                    content: `<div class='contenido-confirm'>${data.mensaje}</div>`,
                    backgroundDismiss: true,
                    buttons: {
                      ok: {
                        text: 'Ok',
                          btnClass: 'btn-pulpox-danger--line',
                          keys: ['enter'],
                      },                  
                    }
                  });  
                }               
              }) 
              .fail(function() {
                dialog_eliminando.close();   
                  $.confirm({
                    icon: 'fas fa-exclamation-circle',
                    title: '<spam class="titulo-confirm">Lo sentimos<spam>',
                    content: "<div class='contenido-confirm'>Nuestro servidor tiene problemas actualmente. Intente más tarde.</div>",
                    type: 'red',
                    backgroundDismiss: true,
                    typeAnimated: true,
                    buttons: {               
                      ok: {
                        text: 'Ok',
                          btnClass: 'btn-pulpox-danger--line',
                          keys: ['escape','enter'],
                      }, 
                    }
                  });
                }) 
            },
          },             
        }
      });
  }

  function cambiarEstatusDeAnuncio(id,estatus){
    let estatus_actual = estatus
    let estatus_boton = ''
    let clase_boton =''
    let type_confirm = ''
    if(estatus== 'ACTIVO' ){
      estatus_boton = 'Sí, quiero suspenderlo.'
      clase_boton = 'btn-pulpox-info'
      type_confirm = 'blue'
    }
    if(estatus== 'SUSPENDIDO' ){
      estatus_boton =  'Sí, quiero activarlo.'
      clase_boton = 'btn-pulpox-info'
      type_confirm = 'blue'
    }           
      $.confirm({
        icon: 'fas fa-info-circle',
        title: '<spam class="titulo-confirm">Cambio de estatus<spam>',
        type: type_confirm,
        columnClass: 'medium',
        backgroundDismiss: true,
        content: `
        <div class='contenido-confirm'>
          El estatus actual del anuncio es <b>${estatus}</b> ¿Realmente desea cambiarlo?<br><br>Recuerde: 
          <label><b>ACTIVO:</b> El anuncio es visible para todo el mundo. Puedes Suspenderlo después.</label>  
          <label><b>SUSPENDIDO:</b> El anuncio nadie lo verá. Puedes Activarlo después.</label></div>          
        `,
        buttons: {
          cerrar: {
            text: 'Cancelar',
              btnClass: 'btn-pulpox-danger--line',
              keys: ['escape'],           
          },
          cambiarEstatus:{
            text: estatus_boton,
            btnClass: clase_boton,
            keys: ['enter'],
            action:function(){    
              let dialog_cambiando_estatus = $.dialog({
                    icon: 'fa fa-spinner fa-spin',
                    title: '<spam class="titulo-confirm">Cambio de estatus<spam>',
                    type: 'blue',
                    content: "<div class='contenido-confirm'>Estamos cambiando el estatus de tu anuncio...</div>",
                    closeIcon:false,
              });   
              $.post(BASE_URL+'mianuncio/cambiarEstatus/', {id,estatus_actual})
                .done(function(response){
                  dialog_cambiando_estatus.close(); 
                  var data = JSON.parse(response)  
                  if(data.codigo == 0){
                    $.confirm({
                      icon: 'fas fa-check-circle',
                      title:  '<spam class="titulo-confirm">Cambio de estatus<spam>',
                      type: 'green',
                      columnClass: 'small',
                      content: `<div class='contenido-confirm'>${data.mensaje}</div>`,
                      buttons: {
                        ok: {
                          text: 'Ok',
                            btnClass: 'btn-pulpox-success',
                            keys: ['enter'],
                            action: function(){
                              window.location.replace(BASE_URL+'mianuncio/ver/'+id);
                            }
                        },                  
                      }
                  }); 

                  }else{
                    $.confirm({
                      icon: 'fas fa-exclamation-circle',
                      title: '<spam class="titulo-confirm">Cambio de estatus<spam>',
                      type: 'red',
                      columnClass: 'small',
                      content: `<div class='contenido-confirm'>${data.mensaje}</div>`,
                      closeIcon:true,
                      buttons: {
                        ok: {
                          text: 'Ok',
                            btnClass: 'btn-pulpox-danger',
                            keys: ['escape','enter'],              
                        },                  
                      }
                    }); 
                  }
                })     
                .fail(function() {
                  dialog_cambiando_estatus.close();   
                  $.confirm({
                    title: '<spam class="titulo-confirm">Detectamos un problema.<spam>',
                    content: "<div class='contenido-confirm'>Nuestro servidor tiene problemas actualmente. Intente más tarde.</div>",
                    type: 'red',
                    typeAnimated: true,
                    backgroundDismiss: true, 
                    buttons: {
                    cerrarVerAnuncio: {
                      text: 'Cerrar',
                      btnClass: 'btn-pulpox-danger',
                      keys: ['escape','enter'],        
                    },                 
                  }
                  });
                })  
            },
          },              
        }
      });
  }

</script>