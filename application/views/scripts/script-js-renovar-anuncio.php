<script>

function renovarAnuncio(anuncio_id){
  /* 
  ARGS:
      * anuncio_id : ID público del anunc
  FUNCTION:
      * Renueva el anuncio  
  */    

    $.confirm({
        icon: 'fas fa-info-circle',
        title: '<span class="titulo-confirm">Renovar Anuncio<span>',
        type: 'blue',
        columnClass: 'medium',
        backgroundDismiss: true,
        content: `
        <div class='contenido-confirm'>Tu anunció se renovará. Esto significa que tu anuncio...¡se verá en el top de las búsquedas!<br><br>Recuerda:<br>
        <b>Cada 24 horas puedes renovar tu anuncio.</b></div>                   
        `,
        buttons: {
          cerrar: {
            text: 'Cancelar',
              btnClass: 'plpx-btn plpx-btn-danger-line',  
              keys: ['escape'], 
          },
          renovarAnuncio:{
            text: `Renovar`,
            btnClass: 'plpx-btn plpx-btn-info',
            keys: ['enter'], 
            action:function(){
              let dialog_renovando = $.dialog({
                  icon: 'fa fa-spinner fa-spin',
                  title: '<span class="titulo-confirm">Renovar Anuncio<span>',
                  type: 'blue',
                  content: "<div class='contenido-confirm'>Estamos renovando tu anuncio...</div>",
                  
              }); 
              $.post(BASE_URL+'mianuncio/renovar/', {anuncio_id})
              .done(function(response){
                let data = JSON.parse(response) 
                dialog_renovando.close();               
                if(data.codigo == 0){
                  $.confirm({
                    icon: 'fas fa-check-circle',
                    title: '<span class="titulo-confirm">Renovar Anuncio</span>',
                    type: 'green',
                    columnClass: 'medium',
                    backgroundDismiss: true,
                    content: `<div class='contenido-confirm'>${data.mensaje}</div>`,                   
                    buttons: {
                      ok_eliminado: {
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
                  dialog_renovando.close();   
                  $.confirm({
                    icon: 'fas fa-exclamation-circle',
                    title: '<span class="titulo-confirm">Renovar Anuncio</span>',
                    type: 'red',
                    columnClass: 'medium',
                    content: `<div class='contenido-confirm'>${data.mensaje}</div>`,
                    backgroundDismiss: true,
                    buttons: {
                      ok: {
                        text: 'Ok',
                          btnClass: 'plpx-btn plpx-btn-danger-line',
                          keys: ['enter'],                        
                      },                  
                    }
                  });  
                }               
              }) 
              .fail(function() {
                dialog_eliminando.close();   
                  $.confirm({
                    title: '<span class="titulo-confirm">Lo sentimos.</span>',
                    content: "<div class='contenido-confirm'>Nuestro servidor tiene problemas actualmente. Intente más tarde.</div>",
                    type: 'red',
                    backgroundDismiss: true,
                    typeAnimated: true,
                    buttons: {               
                      ok: {
                        text: 'Ok',
                          btnClass: 'plpx-btn plpx-btn-danger-line',
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