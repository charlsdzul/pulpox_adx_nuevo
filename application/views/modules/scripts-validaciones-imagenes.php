<script>

function validarExtensionImagen(imagen_nombre){
        /**Valida la extensión de la imágen */
        if (!(/\.(jpg|jpeg|png|gif)$/i).test(imagen_nombre)) {
            return false
        }else{
            return true
        }
    }

    function validarTamanoImagen(imagen_tamano){
        /**Valida el tamaño de la imágen */
        if(imagen_tamano<=5000000){
            return true
        }else{
            return false
        }    
    }

</script>

