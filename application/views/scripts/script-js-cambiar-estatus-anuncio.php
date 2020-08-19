<script>  
    function cambiarEstatusDeAnuncio(id,estatus){
    let estatus_actual = estatus
    let estatus_boton = ''
    let clase_boton =''
    let type_confirm = ''
    if(estatus== 'ACTIVO' ){
      estatus_boton = 'Sí, quiero suspenderlo'
      clase_boton = 'plpx-btn plpx-btn-info'
      type_confirm = 'blue'
    }
    if(estatus== 'SUSPENDIDO' ){
      estatus_boton =  'Sí, quiero activarlo'
      clase_boton = 'plpx-btn plpx-btn-info'
      type_confirm = 'blue'
    }           
      $.confirm({
        icon: 'fas fa-info-circle',
        title: '<span class="titulo-confirm">Cambio de estatus</span>',
        type: type_confirm,
        columnClass: 'large',
        backgroundDismiss: true,
        content: `<div class='contenido-confirm'>
          El estatus actual del anuncio es <b>${estatus}</b> ¿Realmente desea cambiarlo?<br><br>Recuerde: 
          <label><b>ACTIVO:</b> El anuncio es visible para todo el mundo. Puedes Suspenderlo después.</label>  
          <label><b>SUSPENDIDO:</b> El anuncio nadie lo verá. Puedes Activarlo después.</label>          
        </div>`,
        buttons: {
          cerrar: {
            text: 'Cancelar',
              btnClass: 'plpx-btn plpx-btn-danger-line',
              keys: ['escape'],           
          },
          cambiarEstatus:{
            text: estatus_boton,
            btnClass: clase_boton,
            keys: ['enter'],
            action:function(){                  
              let dialog_cambiando_estatus = $.dialog({
                icon: 'fa fa-spinner fa-spin',
                title: '<span class="titulo-confirm">Cambio de estatus</span>',
                type: 'blue',
                content: "<div class='contenido-confirm'>Estamos cambiando el estatus de tu anuncio...</div>",                    
              });   

              $.post(BASE_URL+'mianuncio/cambiarEstatus/', {id,estatus_actual})
                .done(function(response){
                  dialog_cambiando_estatus.close(); 
                  let data = JSON.parse(response)  
                  if(data.codigo == 0){
                    $.confirm({
                      icon: 'fas fa-check-circle',
                      title: '<span class="titulo-confirm">Cambio de estatus</span>',
                      type: 'green',
                      columnClass: 'large',
                      content: `<div class='contenido-confirm'>${data.mensaje}</div>`,
                      buttons: {
                        ok: {
                          text: 'Ok',
                            btnClass: 'plpx-btn plpx-btn-success',
                            keys: ['enter'],
                            action: function(){
                              window.location.replace(window.location.href);
                            }
                        },                  
                      }
                    });
                  }else{
                    $.confirm({
                      icon: 'fas fa-exclamation-circle',
                      title: '<span class="titulo-confirm">Cambio de estatus</span>',
                      type: 'red',
                      columnClass: 'large',
                      content: `<div class='contenido-confirm'>${data.mensaje}</div>`,
                      closeIcon:true,
                      buttons: {
                        ok: {
                          text: 'Ok',
                            btnClass: 'plpx-btn plpx-btn-danger',
                            keys: ['enter'],              
                        },                  
                      }
                    }); 
                  }
                })     
                .fail(function() {
                  dialog_cambiando_estatus.close();   
                  $.confirm({
                    title: response_fail.titulo,
                    content: response_fail.mensaje,
                    type: 'red',
                    typeAnimated: true,
                    backgroundDismiss: true, 
                    buttons: {
                    cerrarVerAnuncio: {
                        text: 'Cerrar',
                        btnClass: 'plpx-btn plpx-btn-danger',
                        keys: ['enter'],        
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