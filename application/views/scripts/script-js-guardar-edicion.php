<script>
    function guardarEdicion(anuncio_public_id){
            let anuncio_editado = {
              'anuncio_public_id':anuncio_public_id,
              'titulo': $('#titulo').val(), 
              'mensaje': $('#mensaje').val(), 
              'estado': $('#estado').val(), 
              'ciudad': $('#ciudad').val(), 
              'modalidad': $('#modalidad').val(), 
              'seccion': $('#seccion').val(), 
              'apartado': $('#apartado').val(), 
              'telefono': $('#telefono').val(), 
              'celular': $('#celular').val(), 
              'correo': $('#correo').val(), 
            }
            $.post(BASE_URL+'mianuncio/editarAnuncio/', {anuncio_editado})
              .done(function(res){
                let response = JSON.parse(res)
                if(response.codigo==0){               
                  $.confirm({
                  icon: 'fas fa-check-circle',
                  title: `<span class="titulo-confirm">Editar Anuncio</span>`,
                  type: 'green',
                  content: `<div class='contenido-confirm'>${response.mensaje}</div>`,                  
                  buttons: {
                    OK: {
                        text: 'Ok',
                        btnClass: 'btn-pulpox-success',
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
                    title: `<span class="titulo-confirm">Editar Anuncio</span>`,
                    type: 'red',
                    content: `<div class='contenido-confirm'>${response.mensaje}</div>`,                   
                    buttons: {
                      OK: {
                          text: 'Ok',
                          btnClass: 'btn-pulpox-danger',
                          keys: ['enter'],       
                          action: function(){
                          $(`#${response.objeto}`).focus();                   
                        }                                  
                      },                                      
                    }
                  });
                }
              })
              .fail(function(){
                $.confirm({
                  icon: 'fas fa-exclamation-circle',
                  title: response_fail.titulo,
                  content: response_fail.mensaje,
                  type: 'red',                    
                    buttons: {
                      OK: {
                          text: 'Ok',
                          btnClass: 'btn-pulpox-danger',
                          keys: ['enter'],                   
                      },                                      
                    }
                });
              })
    }
</script>