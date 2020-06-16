<script>

    $(document).ready(function() {   
        definirSelectsYValores(datos_anuncio.modalidad,datos_anuncio.estado,datos_anuncio.ciudad,datos_anuncio.seccion,datos_anuncio.apartado);     
        asignaValidacionesInputs();
        asignaValoresPrevios(datos_anuncio);   
        asignarImagenes(datos_anuncio) 
        $('#boton_guardar').click(function(){
            validaFormulario(datos_anuncio.public_id)          
        }) 
        
    });

    function asignaValoresPrevios() {     

        $('#titulo').val(datos_anuncio.titulo)    
        $('#mensaje').html(datos_anuncio.mensaje)
        $('#telefono').val(datos_anuncio.telefono)
        $('#celular').val(datos_anuncio.celular)
        $('#correo').val(datos_anuncio.correo) 
    }
</script>