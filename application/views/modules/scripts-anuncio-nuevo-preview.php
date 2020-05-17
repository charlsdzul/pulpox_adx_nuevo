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


$('#telefono_preview').text(sessionStorage.getItem(`telefono_${anuncio_id}`))
$('#celular_preview').text(sessionStorage.getItem(`celular_${anuncio_id}`))
$('#correo_preview').text(sessionStorage.getItem(`correo_${anuncio_id}`))

/**
 * Guardar anuncio
*/

  $(document).ready(function() {

      $('#boton_publicar').click(function(){
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
            console.log('Respuesta de servidor: ')
           console.dir(response)
        })
        .fail(function() {
            console.log('errorr!!!!')
        })    
     
        


      })








console.log(titulo)
    console.log(anuncio)
    console.log(estado)
    console.log(ciudad)
    console.log(seccion)
    console.log(apartado)
    console.log(telefono)
    console.log(celular)
    console.log(correo)
});
 


</script>