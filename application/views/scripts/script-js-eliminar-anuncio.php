<script>  
  function eliminarAnuncio(id){    
        $.confirm({
          icon: 'fas fa-info-circle',
          title: '<span class="titulo-confirm">Eliminar Anuncio</span>',
          type: 'blue',
          columnClass: 'medium',
          backgroundDismiss: true,
          content: `
          <div class='contenido-confirm'><b>¿Realmente desea eliminarlo?</b><br><br>Recuerde: 
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
                  title: '<span class="titulo-confirm">Eliminar Anuncio</span>',
                  type: 'blue',
                  content: "<div class='contenido-confirm'>Estamos eliminando tu anuncio...</div>",                  
                }); 
                $.post(BASE_URL+'mianuncio/eliminar/', {id})
                .done(function(response){
                  let data = JSON.parse(response) 
                  dialog_eliminando.close();               
                  if(data.codigo == 0){
                    $.confirm({
                      icon: 'fas fa-check-circle',
                      title: '<span class="titulo-confirm">Eliminar Anuncio',
                      type: 'green',
                      columnClass: 'medium',
                      backgroundDismiss: true,
                      content: `<div class='contenido-confirm'>${data.mensaje}</div>`,                   
                      buttons: {
                        ok_eliminado: {
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
                      title: '<span class="titulo-confirm">Eliminar Anuncio<span>',
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
                    title: response_fail.titulo,
                    content: response_fail.mensaje,
                    type: 'red',
                    backgroundDismiss: true,
                    typeAnimated: true,
                    buttons: {               
                      ok: {
                        text: 'Ok',
                          btnClass: 'btn-pulpox-danger--line',
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