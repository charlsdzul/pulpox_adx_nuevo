<script>

/**
 * Asignar valores a anuncio-nuevo-preview
*/
let anuncio_id = <?php echo $anuncio_id?>; //Variable pasada a al view
$('#titulo_preview').text(sessionStorage.getItem(`titulo_${anuncio_id}`))
$('#anuncio_preview').text(sessionStorage.getItem(`anuncio_${anuncio_id}`))

let estado_ciudad = sessionStorage.getItem(`estado_text_${anuncio_id}`) + ' / ' + sessionStorage.getItem(`ciudad_text_${anuncio_id}`)
let seccion_apartado =  sessionStorage.getItem(`seccion_text_${anuncio_id}`) + ' / ' + sessionStorage.getItem(`apartado_text_${anuncio_id}`)
$('#estado_ciudad').text(estado_ciudad)
$('#seccion_apartado').text(seccion_apartado)


if(sessionStorage.getItem(`telefono_${anuncio_id}`)!=''){
  $('#telefono_preview').text(sessionStorage.getItem(`telefono_${anuncio_id}`))
  $('#div_telefono_preview').css('display', 'inline-block')
}

if(sessionStorage.getItem(`celular_${anuncio_id}`)!=''){
  $('#celular_preview').text(sessionStorage.getItem(`celular_${anuncio_id}`))
  $('#div_celular_preview').css('display', 'inline-block')
}

if(sessionStorage.getItem(`correo_${anuncio_id}`)!=''){
  $('#correo_preview').text(sessionStorage.getItem(`correo_${anuncio_id}`))
  $('#div_correo_preview').css('display', 'inline-block')
}


/**
 * Guardar anuncio
*/

  $(document).ready(function() {    

      $('#boton_publicar').click(function(){

        let dialog_publicando = $.dialog({
            icon: 'fa fa-spinner fa-spin',
            title: 'Publicando...',
            type: 'green',
            content: 'Estamos publicando tu anuncio!',
            closeIcon:false,
        });       
    
        var nuevo_anuncio={}
        nuevo_anuncio['titulo'] = sessionStorage.getItem(`titulo_${anuncio_id}`)
        nuevo_anuncio['anuncio']  = sessionStorage.getItem(`anuncio_${anuncio_id}`)
        nuevo_anuncio['estado'] = sessionStorage.getItem(`estado_${anuncio_id}`)
        nuevo_anuncio['ciudad'] = sessionStorage.getItem(`ciudad_${anuncio_id}`)
        nuevo_anuncio['seccion']  = sessionStorage.getItem(`seccion_${anuncio_id}`)
        nuevo_anuncio['apartado']  = sessionStorage.getItem(`apartado_${anuncio_id}`)
        nuevo_anuncio['telefono']  = sessionStorage.getItem(`telefono_${anuncio_id}`)
        nuevo_anuncio['celular']  = sessionStorage.getItem(`celular_${anuncio_id}`)
        nuevo_anuncio['correo'] = sessionStorage.getItem(`correo_${anuncio_id}`)
        nuevo_anuncio['id'] = sessionStorage.getItem(`correo_${anuncio_id}`)

        $.post("<?php echo base_url().'index.php/anuncio/publicar/'?>",  nuevo_anuncio)   
        .done(function(response) { 

            dialog_publicando.close();
            response = JSON.parse(response);
              if(response.codigo!=0){
                $.confirm({
                title: 'Detectamos un problema.',
                content: response.mensaje,
                type: 'orange',
                typeAnimated: true,
                buttons: {               
                    close: function () {
                    }                }
                });
              }else{
                $.confirm({
                icon: 'fas fa-check-circle',
                title: 'Publicado',
                type: 'green',
                content: 'Tú anuncio ya se publicó. ¿A dónde quieres ir?',
                closeIcon:false,
                buttons: {
                  nuevoAnuncio: {
                      text: 'Nuevo Anuncio',
                      btnClass: 'btn-pulpox-primary',
                      keys: ['enter', 'shift'],
                      action: function(){
                        location.href = "<?php echo base_url() . 'index.php/anuncio/nuevo'; ?>" 
                      }
                  },
                  misAnuncios: {
                      text: 'mis Anuncios',
                      btnClass: 'btn-pulpox-primary',
                      keys: ['enter', 'shift'],
                      action: function(){
                        location.href = "<?php echo base_url() . 'index.php/misanuncios'; ?>" 
                      }
                  }
                }
                });        
              }        
        })
      .fail(function() {

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
      })
});

</script>