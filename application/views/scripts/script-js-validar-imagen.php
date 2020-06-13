<script>
    function validarImagen(input_imagen,anuncio_public_id,numero_imagen){
        /* 
        ARGS:
            * input_imagen: input file de la imágen
            * anuncio_public_id: id público el anuncio (de 30 caracteres. Ej: 'ZJDURANkYItE92qSQ36zdcX0WGgwb7')
            * numero_imagen: número de la imágen (del 1 al 10)
        FUNCTION:
            * Se valida la extensión y tamaño. En caso de ser exitosos, se ejecuta guardarImagen()        
        */        

        if(validarExtensionImagen(input_imagen.files[0].name)){ 
            $(`#pulpox-invalid-feedback-${numero_imagen}`).html('');
            $(`#pulpox-invalid-feedback-${numero_imagen}`).hide();
           if(validarTamanoImagen(input_imagen.files[0].size)){
                $(`#pulpox-invalid-feedback-${numero_imagen}`).html('')
                $(`#pulpox-invalid-feedback-${numero_imagen}`).hide()
                guardarImagen(input_imagen,numero_imagen,anuncio_public_id)
            }else{
                $(`#pulpox-invalid-feedback-${numero_imagen}`).show();    
                $(`#pulpox-invalid-feedback-${numero_imagen}`).html('La imágen es demasiado grande. Máximo 5 MB')       
            }
        }else{
            $(`#pulpox-invalid-feedback-${numero_imagen}`).html('Elige una imágen con extensión JPG, JPEG, PNG.')
            $(`#pulpox-invalid-feedback-${numero_imagen}`).show()
        }    
    }

    function validarExtensionImagen(imagen_nombre){
        /**Valida la extensión de la imágen */
        return (!(/\.(jpg|jpeg|png)$/i).test(imagen_nombre)) == true ?  false :  true;    
    }

    function validarTamanoImagen(imagen_tamano){
        /**Valida el tamaño de la imágen */
        return imagen_tamano<=5000000?  true :  false;    
    }

</script>