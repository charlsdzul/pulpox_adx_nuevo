<script>
    function eliminarImagen(imagen,anuncio_id){   
      /**Elimina imágen de servidor */    
      let numero_imagen = imagen.getAttribute("data-numero-imagen");
      let path_imagen = $(`#img-${numero_imagen}`).attr('src');
      $.confirm({
              icon: 'fas fa-info-circle',
              title: '<span class="titulo-confirm">Eliminar Imágen</span>',
              type: 'blue',
              content: `<div class='contenido-confirm'>¿Estás seguro de eliminar esta imágen? <br> <img src='${path_imagen}'></div>`,
              backgroundDismiss: true,
              buttons: {
                nuevoAnuncio: {
                    text: 'Cancelar',
                    btnClass: 'btn-pulpox-danger--line',
                    keys: ['escape'],                   
                },
                misAnuncios: {
                    text: 'Sí, eliminar',
                    btnClass: 'btn-pulpox-info',
                    keys: ['enter'],
                    action: function(){   
                      var fd = new FormData();        
                      fd.append('numero', numero_imagen); 
                      fd.append('path_imagen', path_imagen);  
                      fd.append('anuncio_id', anuncio_id);         
                      $.ajax({ 
                          url: BASE_URL+'mianuncio/eliminarImagen/', 
                          type: 'post', 
                          data: fd, 
                          contentType: false, 
                          processData: false,                 
                          beforeSend: function() { 
                              //Antes de iniciar el proceso de eliminación   
                              $(`#img-${numero_imagen}`).attr('src', "")
                              $(`#icon-${numero_imagen}`).removeClass( "fa fa-camera fa-3x" ).addClass("fas fa-spinner fa-3x fa-spin");
                              $(`#panel-image--div_icon-${numero_imagen}`).show() 
                          },
                          success: function(response){ 
                              var data = JSON.parse(response)  
                              if(data.codigo == 0){
                                  $(`#img-${numero_imagen}`).attr('src', '')
                                  $(`#panel-image--div_progreso-${numero_imagen}`).remove()
                                  $(`#panel-image--div-delete-${numero_imagen}`).remove()
                                  $(`#icon-${numero_imagen}`).removeClass( "fas fa-spinner fa-3x fa-spin" ).addClass("fa fa-camera fa-3x");
                                  $.confirm({
                                      icon: 'fas fa-check-circle',
                                      title: '<span class="titulo-confirm">Eliminar Imágen</span>',
                                      type: 'green',
                                      content: `<div class='contenido-confirm'>${data.mensaje}</div>`,
                                      buttons: {
                                        OK: {
                                            text: 'Ok',
                                            btnClass: 'btn-pulpox-success',
                                            keys: ['enter'],
                                        },                                      
                                      }
                                  });                     
                                  if(numero_imagen==1){
                                      $(`#pulpox-message-principal-1`).show() 
                                  }
                              }else{
                                $(`#img-${numero_imagen}`).attr('src', path_imagen)
                                $(`#panel-image--div_icon-${numero_imagen}`).hide() 
                                $.confirm({
                                      icon: 'fas fa-exclamation-circle',
                                      title: '<span class="titulo-confirm">Lo sentimos.</span>',
                                      type: 'red',
                                      content: `<div class='contenido-confirm'>${data.mensaje}</div>`,
                                      buttons: {
                                        OK: {
                                            text: 'Ok',
                                            btnClass: 'btn-pulpox-danger',
                                            keys: ['enter'],
                                        },                                      
                                      }
                                });     
                              }
                          },   
                          fail:function(){
                            $(`#img-${numero_imagen}`).attr('src', path_imagen)
                            $(`#panel-image--div_icon-${numero_imagen}`).hide() 
                            $.confirm({
                                      icon: 'fas fa-exclamation-circle',
                                      title: '<span class="titulo-confirm">Lo sentimos.</span>',
                                      type: 'red',
                                      content: `Ocurrió un problema al eliminar la imágen. Intenta más tarde.`,
                                      buttons: {
                                        OK: {
                                            text: 'Ok',
                                            btnClass: 'btn-pulpox-danger',
                                            keys: ['escape','enter'],                                           
                                        },                                      
                                      }
                            });
                          }
                      });                  
                    }
                }
              }
              });
    }
</script>