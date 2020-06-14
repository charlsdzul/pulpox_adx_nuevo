<script>
    function validaFormulario(anuncio_id){
        /* 
        ARGS:
            * anuncio_id : ID público del anuncio

        FUNCTION:
            * Valida campos obligatorios: Titulo, Anuncio, Estado, Ciudad,Seccion, Apartado, Modalidad
            * Valida campos no obligatorios, en caso de no estar vacíos.
            * Muestra aviso en caso de no escribir Telefono, Celular o Correo.       
        */        

        let elementos_validados = 0; 
        let num_error = 0 ;

        $('.pulpox-validar').each(function(i){
            //Se validan 6 elementos, los que tienen clase .pulpox-validar
            
            if($(this).val()==''){
                $(this).css('border-color','red')
                $(this).next().show()  //Muestra el div con mensaje de error  
                $(this).focus();

            }else{
                $(this).css('border-color','')
                $(this).next().hide() 
                elementos_validados++;
            }             
        });    

        $('.pulpox-validar-select').each(function(i){
            //Se validan 6 elementos, los que tienen clase .pulpox-validar
            if($(this).find('option:selected').val()==''){
                $(this).css('border-color','red')
                $(this).next().show()  //Muestra el div con mensaje de error   
                $(this).focus();                
            }else{
                $(this).css('border-color','')
                $(this).next().hide() 
                elementos_validados++;
            }             
        });  

        /**VALIDA LONGITUD DE TELEFONO */
        let telefono = $('#telefono')
        if(telefono.val().length>0 && telefono.val().length<10){
            telefono.css('border-color','red');
            telefono.next().show() ; //Muestra el div con mensaje de error  
        }
        if(telefono.val().length==10){
            telefono.css('border-color','');
            telefono.next().hide() ;
            elementos_validados++;
        }
        if(telefono.val()==''){
            telefono.next().hide() ;
            elementos_validados++;                   
        }

        /**VALIDA LONGITUD DE CELULAR */ 
        let celular = $('#celular')
        if(celular.val().length>0 && celular.val().length<10){
            celular.css('border-color','red');
            celular.next().show() ; //Muestra el div con mensaje de error  
        }
        if(celular.val().length==10){
            celular.css('border-color','');
            celular.next().hide() ;
            elementos_validados++;  
        }
        if(celular.val()==''){
            celular.next().hide() ;
            elementos_validados++;                   
        }

        /**VALIDA EMAIL*/ 
        let email_regex= new RegExp(/^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i);
        let correo = $('#correo')

        if(correo.val()==''){
            elementos_validados++; 
            correo.css('border-color','');
            correo.next().hide() ;
        }else{
            if(email_regex.test(correo.val())){
                correo.css('border-color','');
                correo.next().hide() ;
                elementos_validados++; 
            }else{
                correo.css('border-color','red');
                correo.next().show() ; //Muestra el div con mensaje de error  
            }
        }    

        let validation = 1;

        if (elementos_validados == 10){
            if($('#telefono').val()=='' && $('#celular').val()=='' && $('#correo').val()==''){
                $.confirm({
                    icon: 'fas fa-exclamation-circle',
                    title: '<span class="titulo-confirm">Aviso</span>',
                    type: 'orange',
                    content: "<div class='contenido-confirm'>No pusiste ningún medio de contacto ¿Así lo quieres publicar?</div>",
                    closeIcon:false,
                    backgroundDismiss: true,  
                    buttons: {
                        misAnuncios: {
                            text: 'Sí',
                            btnClass: 'btn-pulpox-warning--line',
                            keys: ['enter'],
                            action: function(){
                               guardarEdicion(anuncio_id)
                            }
                        },
                        nuevoAnuncio: {
                            text: 'No, editar',
                            btnClass: 'btn-pulpox-warning',
                            keys: ['escape'],
                            action: function(){                              
                            }
                        },                      
                    }
                });
            }else{
               guardarEdicion(anuncio_id)
            }
        }
    }
</script>