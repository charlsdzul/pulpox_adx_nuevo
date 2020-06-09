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
                          btnClass: 'btn-pulpox-success',                           
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
                    icon: 'fas fa-exclamation-circle',
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

  function cambiarEstatusDeAnuncio(id,estatus){
    let estatus_actual = estatus
    let estatus_boton = ''
    let clase_boton =''
    let type_confirm = ''
    if(estatus== 'ACTIVO' ){
      estatus_boton = 'Sí, quiero suspenderlo.'
      clase_boton = 'btn-pulpox-warning'
      type_confirm = 'orange'
    }
    if(estatus== 'SUSPENDIDO' ){
      estatus_boton =  'Sí, quiero activarlo.'
      clase_boton = 'btn-pulpox-success'
      type_confirm = 'green'
    }           
      $.confirm({
        icon: 'fas fa-info-circle',
        title: 'Cambiar Estatus del Anuncio',
        type: type_confirm,
        columnClass: 'medium',
        backgroundDismiss: true,
        content: `
          El <b>estatus actual del anuncio es ${estatus} ¿Realmente desea cambiarlo?</b><br><br>Recuerde: 
          <label><b>ACTIVO:</b> El anuncio es visible para todo el mundo. Puedes Suspenderlo después.</label>  
          <label><b>SUSPENDIDO:</b> El anuncio nadie lo verá. Puedes Activarlo después.</label>          
        `,
        closeIcon:true,
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
                    title: 'Estatus',
                    type: 'green',
                    content: 'Estamos cambiando el estatus de tu anuncio...',
                    closeIcon:false,
              });   
              $.post(BASE_URL+'mianuncio/cambiarEstatus/', {id,estatus_actual})
                .done(function(response){
                  dialog_cambiando_estatus.close(); 
                  var data = JSON.parse(response)  
                  if(data.codigo == 0){
                    $.confirm({
                      icon: 'fas fa-check-circle',
                      title:  'Estatus',
                      type: 'green',
                      columnClass: 'small',
                      content: data.mensaje,
                      closeIcon:true,
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
                      title: 'Estatus',
                      type: 'red',
                      columnClass: 'small',
                      content: data.mensaje,
                      closeIcon:true,
                      buttons: {
                        ok: {
                          text: 'Ok',
                            btnClass: 'btn-pulpox-danger',
                            keys: ['enter'],              
                        },                  
                      }
                    }); 
                  }
                })     
                .fail(function() {
                  dialog_cambiando_estatus.close();   
                  $.confirm({
                    title: 'Detectamos un problema.',
                    content: 'Nuestro servidor tiene problemas actualmente. Intente más tarde.',
                    type: 'red',
                    typeAnimated: true,
                    backgroundDismiss: true, 
                    buttons: {
                    cerrarVerAnuncio: {
                      text: 'Cerrar',
                      btnClass: 'btn-pulpox-secondary',
                      keys: ['escape'],        
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