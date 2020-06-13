<script>
    function guardarImagen(imagen,numero_imagen,anuncio_id){
        /** Sube imágen a servidor. */

        $(`#panel-image-${numero_imagen}`).after(`
        <div id='panel-image--div_progreso-${numero_imagen}' class='panel-image--div_progreso'> 
            <div id='panel-image--bar_progreso-${numero_imagen}' class='panel-image--bar_progreso'> 
            </div>
        </div>  
        <div id='panel-image--div-delete-${numero_imagen}' class='panel-image--div-delete'> 
            <i id='icon-delete-${numero_imagen}' class="material-icons icon-delete" onclick='eliminarImagen(this,"${anuncio_id}")' data-numero-imagen='${numero_imagen}'>delete_forever</i>
        </div>`)

            var fd = new FormData(); 
            var image = imagen.files[0]; 
            fd.append('imagen', image); 
            fd.append('numero', numero_imagen); 
            fd.append('anuncio_id', anuncio_id); 

            $.ajax({ 
                url: BASE_URL+'mianuncio/guardarImagen/' , 
                type: 'post', 
                data: fd, 
                contentType: false, 
                processData: false, 
                xhr: function() {
                    //Esto pasa durante la subida de la imágen
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = ((evt.loaded / evt.total) * 100);
                            $(`#panel-image--bar_progreso-${numero_imagen}`).css('width',percentComplete+'%');
                            $(`#panel-image--bar_progreso-${numero_imagen}`).html(percentComplete+'%');                               
                        }else{
                        }
                    }, false);
                    return xhr;
                },
                beforeSend: function() { 
                    //Antes de iniciar la subida, se muestra el icono loading                      
                    $(`#icon-${numero_imagen}`).removeClass("fa fa-camera fa-3x").addClass("fas fa-spinner fa-3x fa-spin");
                },
                success: function(response){ 
                    let data = JSON.parse(response)
                    let url = "<?php echo base_url();?>";                     

                    if(data.codigo == 0){
                        $(`#panel-image--div_icon-${numero_imagen}`).hide() 
                        $(`#img-${numero_imagen}`).attr('src', url+data.path+ "?timestamp=" + new Date().getTime());
                        $(`#pulpox-invalid-feedback-${numero_imagen}`).html('')
                        $(`#pulpox-invalid-feedback-${numero_imagen}`).hide()      
                        $.confirm({
                          icon: 'fas fa-check-circle',
                          title: '<span class="titulo-confirm">Actualizar Imágen</span>',
                          type: 'green',
                          content: `<div class='contenido-confirm'>${data.mensaje}</div>`,
                          buttons: {
                            OK: {
                                text: 'Ok',
                                btnClass: 'btn-pulpox-success',
                                keys: ['enter'],
                            },                                      
                          }
                      })                        
                    }else{
                        $(`#icon-${numero_imagen}`).removeClass( "fas fa-spinner fa-3x fa-spin" ).addClass("fa fa-camera fa-3x");
                        $(`#panel-image--div_progreso-${numero_imagen}`).remove()
                        $(`#panel-image--div-delete-${numero_imagen}`).remove()
                        $(`#pulpox-invalid-feedback-${numero_imagen}`).html(data.mensaje)
                        $(`#pulpox-invalid-feedback-${numero_imagen}`).show()
                    }                   
                }, 
                fail:function(){
                  $.confirm({
                          icon: 'fas fa-check-circle',
                          title: '<span class="titulo-confirm">Lo sentimos</span>',
                          type: 'red',
                          content: `<div class='contenido-confirm'>Hubo un problema a intenar actualizar tu imágen. Intenta más tarde.</div>`,
                          buttons: {
                            OK: {
                                text: 'Ok',
                                btnClass: 'btn-pulpox-danger',
                                keys: ['enter'],
                            },                                      
                          }
                      })  

                },
            }); 
    }
</script>