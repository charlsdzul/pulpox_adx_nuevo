<script>
    function guardarEdicion(anuncio_public_id){
        let titulo_nuevo = $('#titulo').val()
            let mensaje_nuevo = $('#mensaje').val()
            let estado_nuevo = $('#estado').val()
            let ciudad_nuevo = $('#ciudad').val()
            let modalidad_nuevo = $('#modalidad').val()
            let seccion_nuevo = $('#seccion').val()
            let apartado_nuevo = $('#apartado').val()
            let telefono_nuevo = $('#telefono').val()
            let celular_nuevo = $('#celular').val()
            let correo_nuevo = $('#correo').val()

            let anuncio_editado = {
              'anuncio_public_id':anuncio_public_id,
              'titulo': titulo_nuevo, 
              'mensaje': mensaje_nuevo, 
              'estado': estado_nuevo, 
              'ciudad': ciudad_nuevo, 
              'modalidad': modalidad_nuevo, 
              'seccion': seccion_nuevo, 
              'apartado': apartado_nuevo, 
              'telefono': telefono_nuevo, 
              'celular': celular_nuevo, 
              'correo': correo_nuevo, 
            }
            $.post(BASE_URL+'mianuncio/editarAnuncio/', {anuncio_editado})
              .done(function(response){
                var response = JSON.parse(response)
                if(response.codigo==0){               
                  $.confirm({
                  icon: 'fas fa-check-circle',
                  title: '<span class="titulo-confirm">Confirmación',
                  type: 'green',
                  content: response.mensaje,
                  
                  buttons: {
                    OK: {
                        text: 'Ok',
                        btnClass: 'btn-pulpox-success',
                        keys: ['enter'],
                        action: function(){
                          window.location.replace(BASE_URL+'mianuncio/ver/'+anuncio_public_id);                        
                        }
                    },                                      
                  }
                });
                }else{
                  $.confirm({
                    icon: 'fas fa-exclamation-circle',
                    title: '<span class="titulo-confirm">Confirmación',
                    type: 'red',
                    content: response.mensaje,
                    
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
                    title: '<span class="titulo-confirm">Confirmación',
                    type: 'red',
                    content: response.mensaje,
                    
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