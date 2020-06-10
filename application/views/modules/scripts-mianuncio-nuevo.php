<script>

    const BASE_URL = "<?php echo base_url();?>index.php/";
    var anuncio_id = "<?php echo $anuncio_id?>"; 

    $(document).ready(function() {   
        asignaListasSelects();     
        asignaValidacionesInputs();
        asignaValoresPrevios(anuncio_id);    

        $('#boton_previzualizar').click(function(){
            validaFormulario(anuncio_id)          
        }) 
    });

    function asignaListasSelects(){
        /**Define lista de datos a los inputs ESTADO, CIUDAD, SECCION, APARTADO    
        * Asigna lista de Estados a 'Estado'. Inicia en 'Chihuahua'
        * Asigna lista de ciudades correspondientes a 'Chihuahua'. Inicia en 'Juárez'
        * Al cambiar el Estado, se asignan sus ciudades correspondientes
        */             


        $.get( BASE_URL+"General/obtenerEstados", function( response ) {       
            response = JSON.parse(response);
            let lista_estados='';

            $.each(response, function(key, value){
                lista_estados += `<option value="${value.nombre}">${value.nombre}</option>`;
            });
                $('#estado').children().remove();
                $('#estado').append(lista_estados)  

                if(sessionStorage.getItem(`estado_${anuncio_id}`)!=null && sessionStorage.getItem(`estado_${anuncio_id}`)!=''){
                    $('#estado').val(sessionStorage.getItem(`estado_${anuncio_id}`)) 
                    $('#estado').change() 
                }else{
                    $('#estado').val('Chihuahua') 
                    $('#estado').change() 
                }                      
        });        

        $('#estado').change(function(){
            let estado = $('#estado').val();
            $('#ciudad').find('option').remove() //Remover options actuales
            $.get( BASE_URL+"General/obtenerCiudades",{estado}, function( response ) {      
                response = JSON.parse(response);
                var lista_ciudades='';
                    $.each(response, function(key, value){
                        lista_ciudades += `<option value="${value.nombre}">${value.nombre}</option>`;
                    }); 

                    $('#ciudad').children().remove();
                    $('#ciudad').append(lista_ciudades) //Asignar lista de apartado correspondiente según la sección elegida.

                    if(sessionStorage.getItem(`ciudad_${anuncio_id}`)!=null && sessionStorage.getItem(`ciudad_${anuncio_id}`)!=''){
                        $('#ciudad').val(sessionStorage.getItem(`ciudad_${anuncio_id}`)) 
                    }else{
                        $('#ciudad').val('Juárez');
                    }
            });                                   
        })

        $.get( BASE_URL+"General/obtenerModalidades", function( response ) {       
            response = JSON.parse(response);
            let lista_modalidades='<option value="" disabled selected>Selecciona</option>';

            $.each(response, function(key, value){
                lista_modalidades += `<option value="${value.nombre}">${value.nombre}</option>`;
            });

                $('#modalidad').children().remove();
                $('#modalidad').append(lista_modalidades)  

                if(sessionStorage.getItem(`modalidad_${anuncio_id}`)!=null && sessionStorage.getItem(`modalidad_${anuncio_id}`)!=''){
                    $('#modalidad').val(sessionStorage.getItem(`modalidad_${anuncio_id}`)) 
                }                  
        });  

        $.get( BASE_URL+"General/obtenerSecciones", function( response ) {       
            response = JSON.parse(response);
            let lista_secciones='<option value="" disabled selected>Selecciona</option>';
            $.each(response, function(key, value){
                lista_secciones += `<option value="${value.nombre}">${value.nombre}</option>`;
            });

            $('#seccion').children().remove(); 
            $('#seccion').append(lista_secciones) 

            if(sessionStorage.getItem(`seccion_${anuncio_id}`)!=null && sessionStorage.getItem(`seccion_${anuncio_id}`)!=''){
                    $('#seccion').val(sessionStorage.getItem(`seccion_${anuncio_id}`)) 
                    $('#seccion').change() 
            } 
        });

        $('#seccion').change(function(){
            let seccion = $(this).val();
            $('#apartado').find('option').remove() //Remover options actuales
            $.get( BASE_URL+"General/obtenerApartados",{seccion}, function( response ) {      
                response = JSON.parse(response);
                
                    let lista_apartados='<option value="" disabled selected>Selecciona</option>';
                    $.each(response, function(key, value){
                        lista_apartados += `<option value="${value.nombre}">${value.nombre}</option>`;
                    }); 

                    $('#apartado').children().remove();
                    $('#apartado').append(lista_apartados) //Asignar lista de apartado correspondiente según la sección elegida.
                    $('#apartado').prop( "disabled", false );
                    $('#apartado').val('');                 

                    if(sessionStorage.getItem(`apartado_${anuncio_id}`)!=null && sessionStorage.getItem(`apartado_${anuncio_id}`)!=''){
                        $('#apartado').val(sessionStorage.getItem(`apartado_${anuncio_id}`)) 
                    } 
            });                     
        })      
    }   

    function asignaValoresPrevios(anuncio_id) {
        /**
        * En caso de regresar al formulario para editarlo, se asignan los valores que
        anteriormente han sido guardados. Están en sessionStorages
        */           

        $('#titulo').val(sessionStorage.getItem(`titulo_${anuncio_id}`))    
        $('#mensaje').html(sessionStorage.getItem(`mensaje_${anuncio_id}`))
        $('#telefono').val(sessionStorage.getItem(`telefono_${anuncio_id}`))
        $('#celular').val(sessionStorage.getItem(`celular_${anuncio_id}`))
        $('#correo').val(sessionStorage.getItem(`correo_${anuncio_id}`)) 

        // Los datos de ESTADO-CIUDAD-SECICON-APARTADO, se asignan en la funcion asignaListasSelects
          
        for (let index = 1; index < 11; index++) {              

                if((sessionStorage.getItem(`img_${index}_${anuncio_id}`))!=null && (sessionStorage.getItem(`img_${index}_${anuncio_id}`))!=''){
                    $(`#panel-image--div_icon-${index}`).hide() 
                    $(`#img-${index}`).attr('src',sessionStorage.getItem(`img_${index}_${anuncio_id}`)) 
                    $(`#panel-image-${index}`).after(`
                        <div id='panel-image--div-delete-${index}' class='panel-image--div-delete'> 
                            <i id='icon-delete-${index}' class="material-icons icon-delete" onclick='deleteImage(this)' data-numero-imagen='${index}'>delete_forever</i>
                        </div>
                    `)
                    $(`#pulpox-message-principal-${index}`).hide() 
                }                
            }       
    }

    function deleteImage(imagen){   
        /**Elimina imágen de servidor */    

        let numero_imagen = imagen.getAttribute("data-numero-imagen");
        let path_imagen = $(`#img-${numero_imagen}`).attr('src')
       
            var fd = new FormData();        
            fd.append('numero', numero_imagen); 
            fd.append('path_imagen', path_imagen); 
       
                $.ajax({ 
                    url: BASE_URL+'mianuncio/eliminarImagenTemporal/'+anuncio_id , 
                    type: 'post', 
                    data: fd, 
                    contentType: false, 
                    processData: false,                 
                    beforeSend: function() { 
                        //Antes de iniciar el proceso de eliminación    
                        $(`#icon-${numero_imagen}`).removeClass( "fa fa-camera fa-3x" ).addClass("fas fa-spinner fa-3x fa-spin");
                        $(`#panel-image--div_icon-${numero_imagen}`).show()                    
                        
                    },
                    success: function(response){ 
                        var data = $.parseJSON(response)  
                        if(data.codigo == 0){
                            $(`#img-${numero_imagen}`).attr('src', '')
                            $(`#panel-image--div_progreso-${numero_imagen}`).remove()
                            $(`#panel-image--div-delete-${numero_imagen}`).remove()
                            $(`#icon-${numero_imagen}`).removeClass( "fas fa-spinner fa-3x fa-spin" ).addClass("fa fa-camera fa-3x");
                           
                            sessionStorage.setItem(`img_${numero_imagen}_${anuncio_id}`, '')
                            if(numero_imagen==1){
                                $(`#pulpox-message-principal-1`).show() 
                            }

                        }else{

                        }
                    }   
                }); 
    }

    function uploadImage(imagen){
        /* Ejecutya funciones de validaciones */
        
        var numero_imagen = imagen.getAttribute("data-numero-imagen");  

        if(validarExtensionImagen(imagen.files[0].name)){ 
            $(`#pulpox-invalid-feedback-${numero_imagen}`).html('');
            $(`#pulpox-invalid-feedback-${numero_imagen}`).hide();
           if(validarTamanoImagen(imagen.files[0].size)){
                $(`#pulpox-invalid-feedback-${numero_imagen}`).html('')
                $(`#pulpox-invalid-feedback-${numero_imagen}`).hide()
                uploadImageAjax(imagen,numero_imagen,anuncio_id)
            }else{
                $(`#pulpox-invalid-feedback-${numero_imagen}`).show();    
                $(`#pulpox-invalid-feedback-${numero_imagen}`).html('La imágen es demasiado grande. Máximo 5 MB')       
            }
        }else{
            $(`#pulpox-invalid-feedback-${numero_imagen}`).html('Elige una imágen con extensión JPG, JPEG, PNG, GIF.')
            $(`#pulpox-invalid-feedback-${numero_imagen}`).show()
        }    
    }

    function uploadImageAjax(imagen,numero_imagen,anuncio_id){
        /** Sube imágen a servidor. */

        $(`#panel-image-${numero_imagen}`).after(`
        <div id='panel-image--div_progreso-${numero_imagen}' class='panel-image--div_progreso'> 
            <div id='panel-image--bar_progreso-${numero_imagen}' class='panel-image--bar_progreso'> 
                </div>
        </div>  
        <div id='panel-image--div-delete-${numero_imagen}' class='panel-image--div-delete'> 
            <i id='icon-delete-${numero_imagen}' class="material-icons icon-delete" onclick='deleteImage(this)' data-numero-imagen='${numero_imagen}'>delete_forever</i>
        </div>`)

            var fd = new FormData(); 
            var image = imagen.files[0]; 
            fd.append('imagen', image); 
            fd.append('numero', numero_imagen); 
            fd.append('anuncio_id', anuncio_id); 

            $.ajax({ 
                url: BASE_URL+'mianuncio/subirImagenTemporal/' , 
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
                    $(`#icon-${numero_imagen}`).removeClass( "fa fa-camera fa-3x" ).addClass("fas fa-spinner fa-3x fa-spin");
                },
                success: function(response){ 
                    let data = JSON.parse(response)
                    let url = "<?php echo base_url();?>";                     

                    if(data.codigo == 0){
                        $(`#panel-image--div_icon-${numero_imagen}`).hide() 
                        $(`#img-${numero_imagen}`).attr('src', url+data.mensaje+ "?timestamp=" + new Date().getTime());
                        $(`#pulpox-invalid-feedback-${numero_imagen}`).html('')
                        $(`#pulpox-invalid-feedback-${numero_imagen}`).hide()
                        sessionStorage.setItem(`img_${numero_imagen}_${anuncio_id}`, $(`#img-${numero_imagen}`).attr('src'))
                    }else{
                        $(`#icon-${numero_imagen}`).removeClass( "fas fa-spinner fa-3x fa-spin" ).addClass("fa fa-camera fa-3x");
                        $(`#panel-image--div_progreso-${numero_imagen}`).remove()
                        $(`#panel-image--div-delete-${numero_imagen}`).remove()

                        $(`#pulpox-invalid-feedback-${numero_imagen}`).html(data.mensaje)
                        $(`#pulpox-invalid-feedback-${numero_imagen}`).show()
                    }                   
                }, 
            }); 
    }

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

    function validaFormulario(anuncio_id){
        /* Valida campos obligatorios: Titulo, Anuncio, Estado, Ciudad,Seccion, Apartado 
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
        var telefono = $('#telefono')
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
            elementos_validados++;                   
        }

        /**VALIDA LONGITUD DE CELULAR */ 
        var celular = $('#celular')
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
            elementos_validados++;                   
        }

        /**VALIDA EMAIL*/ 
        var email_regex= new RegExp(/^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i);
        var correo = $('#correo')

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

        var validation = 1;

        if (elementos_validados == 10){
            if($('#telefono').val()=='' && $('#celular').val()=='' && $('#correo').val()==''){
                $.confirm({
                    icon: 'fas fa-exclamation-circle',
                    title: 'Aviso',
                    type: 'orange',
                    content: 'No pusiste ningún medio de contacto ¿Así lo quieres publicar?',
                    closeIcon:false,
                    buttons: {
                        misAnuncios: {
                            text: 'Sí',
                            btnClass: 'btn-pulpox-secondary--line',
                            keys: ['enter', 'shift'],
                            action: function(){
                                almacenaDatosEnSessionStorage(anuncio_id)
                            }
                        },
                        nuevoAnuncio: {
                            text: 'No, editar.',
                            btnClass: 'btn-pulpox-secondary',
                            keys: ['enter', 'shift'],
                            action: function(){                              
                            }
                        },                      
                    }
                });
            }else{
                almacenaDatosEnSessionStorage(anuncio_id)
            }
        }
    }

    function almacenaDatosEnSessionStorage(anuncio_id){
       /** Si validaFormulario es true, se ejecuta esta función.
        * Almacenaa en sessionStorage la información para mostrarla en el preview
        * Redirige a la página de Preview de Anuncio
        */ 
        
       // let anuncio_preformat = '<pre>'+$('#anuncio').val()+'</pre>'
        let anuncio_preformat = $('#mensaje').val()
        sessionStorage.setItem(`titulo_${anuncio_id}`, $('#titulo').val())
        sessionStorage.setItem(`mensaje_${anuncio_id}`, anuncio_preformat)
        sessionStorage.setItem(`estado_${anuncio_id}`, $('#estado').val())
        sessionStorage.setItem(`ciudad_${anuncio_id}`, $('#ciudad').val())
        sessionStorage.setItem(`modalidad_${anuncio_id}`, $('#modalidad').val())
        sessionStorage.setItem(`seccion_${anuncio_id}`, $('#seccion').val())
        sessionStorage.setItem(`apartado_${anuncio_id}`, $('#apartado').val())      
        sessionStorage.setItem(`telefono_${anuncio_id}`, $('#telefono').val())
        sessionStorage.setItem(`celular_${anuncio_id}`, $('#celular').val())
        sessionStorage.setItem(`correo_${anuncio_id}`, $('#correo').val())   

        for (let index = 1; index < 11; index++) {
                sessionStorage.setItem(`img_${index}_${anuncio_id}`, $(`#img-${index}`).attr('src'))
            }
     
        location.href = BASE_URL + 'mianuncio/preview/'+anuncio_id;
    }

</script>