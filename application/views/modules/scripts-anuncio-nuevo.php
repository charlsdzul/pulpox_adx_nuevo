<script src="<?php echo base_url();?>assets/util/estados.js"></script>
<script src="<?php echo base_url();?>assets/util/ciudades.js"></script>
<script src="<?php echo base_url();?>assets/util/secciones.js"></script>
<script src="<?php echo base_url();?>assets/util/apartados.js"></script>

<script>
    var anuncio_id = <?php echo $anuncio_id?>; //Variable pasada a al view

/**
* Validación para el formulario 
* Valida elementos con la clase 'pulpox-validar'
*/

    $('#boton_previzualizar').click(function(){

            /** VALIDA CAMPOS OBLIGATORIOS 
            * Titulos, Anuncio, Estado, Ciudad,Seccion, Apartado */
            let elementos_validados = 0; 
            $('.pulpox-validar').each(function(i){
                //Se validan 6 elementos, los que tienen clase .pulpox-validar
                if($(this).val()==''){
                    $(this).css('border-color','red')
                    $(this).next().show()  //Muestra el div con mensaje de error                   
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


                if(elementos_validados==9){      

                        sessionStorage.setItem(`titulo_${anuncio_id}`, $('#titulo').val())
                        sessionStorage.setItem(`anuncio_${anuncio_id}`, $('#anuncio').val())
                        sessionStorage.setItem(`estado_${anuncio_id}`, $('#estado').val())
                        sessionStorage.setItem(`estado_text_${anuncio_id}`, $('#estado option:selected').text())
                        sessionStorage.setItem(`ciudad_${anuncio_id}`, $('#ciudad').val())
                        sessionStorage.setItem(`ciudad_text_${anuncio_id}`, $('#ciudad option:selected').text())
                        sessionStorage.setItem(`seccion_${anuncio_id}`, $('#seccion').val())
                        sessionStorage.setItem(`seccion_text_${anuncio_id}`, $('#seccion option:selected').text())
                        sessionStorage.setItem(`apartado_${anuncio_id}`, $('#apartado').val())
                        sessionStorage.setItem(`apartado_text_${anuncio_id}`, $('#apartado option:selected').text())
                        sessionStorage.setItem(`telefono_${anuncio_id}`, $('#telefono').val())
                        sessionStorage.setItem(`celular_${anuncio_id}`, $('#celular').val())
                        sessionStorage.setItem(`correo_${anuncio_id}`, $('#correo').val())   
                             

                    if($('#telefono').val()=='' && $('#celular').val()=='' && $('#correo').val()==''){

                            $.confirm({
                            icon: 'fas fa-exclamation-circle',
                            title: 'Aviso',
                            type: 'orange',
                            content: 'No pusiste ningún medio de contacto ¿Así lo quieres publicar?',
                            closeIcon:false,
                            buttons: {
                            nuevoAnuncio: {
                                text: 'No, editar.',
                                btnClass: 'btn-pulpox-primary',
                                keys: ['enter', 'shift'],
                                action: function(){
                                }
                            },
                            misAnuncios: {
                                text: 'Sí',
                                btnClass: 'btn-pulpox-primary',
                                keys: ['enter', 'shift'],
                                action: function(){
                                    location.href = "<?php echo base_url() . 'index.php/' .'anuncio/preview/' . $anuncio_id; ?>" 
                                }
                            }
                            }
                            });

                    }else{
                        window.location.href =  "<?php echo base_url() . 'index.php/' .'anuncio/preview/' . $anuncio_id; ?>"   
                    }
                }       

               
    })



/**
* Asigna lista de Estados a 'Estado'. Inicia en 'Chihuahua'
* Asigna lista de ciudades correspondientes a 'Chihuahua'. Inicia en 'Juárez'
* Al cambiar el Estado, se asignan sus ciudades correspondientes
*/

    var lista_estados='';
        $.each(estados, function(key, value){
        lista_estados += '<option value=' + key + '>' + value + '</option>';
        });
            $('#estado').append(lista_estados)

    var lista_ciudades='';
        $.each(ciudades_CHH, function(key, value){
            lista_ciudades += '<option value=' + key + '>' + value + '</option>';
        });
            $('#ciudad').append(lista_ciudades)

    var lista_secciones='';
        $.each(secciones, function(key, value){
            lista_secciones += '<option value=' + key + '>' + value + '</option>';
        });
            $('#seccion').append(lista_secciones)

    var lista_apartados='';
        $.each(apartados_BIR, function(key, value){
            lista_apartados += '<option value=' + key + '>' + value + '</option>';
        });
        
    $('#apartado').append(lista_apartados)

    $('#seccion').change(function(){
        let seleccionado = $(this).val();

        $('#apartado').find('option').remove() //Remover options actuales

        //Asignar lista de apartado correspondiente según la sección elegida.
        let lista_apartados='';
            
        if(seleccionado=='SER'){
            $.each(apartados_SER, function(key, value){
                lista_apartados += '<option value=' + key + '>' + value + '</option>';
            });                       
        }

        if(seleccionado=='AUT'){
            $.each(apartados_AUT, function(key, value){
                lista_apartados += '<option value=' + key + '>' + value + '</option>';
            });
        }

        if(seleccionado=='BIR'){
            $.each(apartados_BIR, function(key, value){
                lista_apartados += '<option value=' + key + '>' + value + '</option>';
            });
        }

        $('#apartado').append(lista_apartados)            
    })


/**
 * Funciones para selects e inputs
*/
        var patt = /<script>/gi; 
        $('#titulo').maxlength({
          alwaysShow: true,
         // threshold: 10,
          warningClass: "label label-success",
          limitReachedClass: "label label-danger",
          separator: ' de',
          preText: ' ',
          postText: ' caracteres restantes',
          validate: true,
        });

        $("#titulo").keyup(function() {
        let titulo_ingresado = $(this).val();            
        var titulo_limpio = titulo_ingresado.replace(patt,'');
        $(this).val(titulo_limpio)       
        });

        $('#anuncio').maxlength({
          alwaysShow: true,
          //threshold: 10,
          warningClass: "label label-success",
          limitReachedClass: "label label-danger",
          separator: ' de',
          preText: ' ',
          postText: ' caracteres restantes',
          validate: true
        });

        $("#anuncio").keyup(function() {
        let titulo_ingresado = $(this).val();            
        var titulo_limpio = titulo_ingresado.replace(patt,'');
        $(this).val(titulo_limpio)       
        });
        
        $("#telefono").keyup(function() {
        let telefono_ingresado = $(this).val();
        var patt = /[^1-9]/g;        
        var telefono_limpio = telefono_ingresado.replace(patt,'');
        $(this).val(telefono_limpio)       
        });

        $("#celular").keyup(function() {
        let telefono_ingresado = $(this).val();
        var patt = /[^1-9]/g;        
        var telefono_limpio = telefono_ingresado.replace(patt,'');
        $(this).val(telefono_limpio)       
        });
        

/**
 * Asignar valores previamente almacenados*/        

        $('#titulo').val(sessionStorage.getItem(`titulo_${anuncio_id}`))
        $('#anuncio').val(sessionStorage.getItem(`anuncio_${anuncio_id}`))
        $('#telefono').val(sessionStorage.getItem(`telefono_${anuncio_id}`))
        $('#celular').val(sessionStorage.getItem(`celular_${anuncio_id}`))
        $('#correo').val(sessionStorage.getItem(`correo_${anuncio_id}`))  
        if(sessionStorage.getItem(`estado_${anuncio_id}`)){
            $('#estado').val(sessionStorage.getItem(`estado_${anuncio_id}`));
        }
        if(sessionStorage.getItem(`ciudad_${anuncio_id}`)){
            $('#ciudad').val(sessionStorage.getItem(`ciudad_${anuncio_id}`));
        }
        if(sessionStorage.getItem(`seccion_${anuncio_id}`)){
            $('#seccion').val(sessionStorage.getItem(`seccion_${anuncio_id}`));
        }       
        if(sessionStorage.getItem(`apartado_${anuncio_id}`)){
            $('#apartado').val(sessionStorage.getItem(`apartado_${anuncio_id}`));
        }


</script>  

<script>

    function deleteImage(imagen){       

        let numero_imagen = imagen.getAttribute("data-numero-imagen");
        let path_imagen = $(`#img-${numero_imagen}`).attr('src')
       
            var fd = new FormData();        
            fd.append('numero', numero_imagen); 
            fd.append('path_imagen', path_imagen); 
       
                $.ajax({ 
                    url: "<?php echo base_url() . 'index.php/' .'anuncio/eliminarImagenTemporal/' . $anuncio_id; ?>" , 
                    type: 'post', 
                    data: fd, 
                    contentType: false, 
                    processData: false,                 
                    beforeSend: function() { 
                        //Antes de iniciar el proceso de eliminación                        
                        $(`#panel-image--div_icon-${numero_imagen}`).show()                    
                        $(`#icon-${numero_imagen}`).removeClass( "fa fa-camera fa-3x" ).addClass("fas fa-spinner fa-3x fa-spin");
                    },
                    success: function(response){ 
                        var data = $.parseJSON(response)  
                        if(data.codigo == 0){
                            $(`#img-${numero_imagen}`).attr('src', '')
                            $(`#panel-image--div_progreso-${numero_imagen}`).remove()
                            $(`#panel-image--div-delete-${numero_imagen}`).remove()
                            $(`#icon-${numero_imagen}`).removeClass( "fas fa-spinner fa-3x fa-spin" ).addClass("fa fa-camera fa-3x");
                        }else{

                        }
                    }   
                }); 
    }


    function uploadImage(imagen){

        var numero_imagen = imagen.getAttribute("data-numero-imagen");  

        $(`#panel-image-${numero_imagen}`).after(`
        <div id='panel-image--div_progreso-${numero_imagen}' class='panel-image--div_progreso'> 
            <div id='panel-image--bar_progreso-${numero_imagen}' class='panel-image--bar_progreso'> 
                </div>
        </div>  
        <div id='panel-image--div-delete-${numero_imagen}' class='panel-image--div-delete'> 
            <i id='icon-delete-${numero_imagen}' class="material-icons icon-delete" onclick='deleteImage(this)' data-numero-imagen='${numero_imagen}'>delete_forever</i>
        </div>   
        
        `)

      
                var fd = new FormData(); 
                var image = imagen.files[0]; 
                fd.append('imagen', image); 
                fd.append('numero', numero_imagen); 
       
                $.ajax({ 
                    url: "<?php echo base_url() . 'index.php/' .'anuncio/subirImagenTemporal/' . $anuncio_id; ?>" , 
                    type: 'post', 
                    data: fd, 
                    contentType: false, 
                    processData: false, 
                    xhr: function() {
                        //Esto pasa durante la subida de la imágen
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                console.log(evt.loaded / evt.total)
                                var percentComplete = ((evt.loaded / evt.total) * 100);
                                $(`#panel-image--bar_progreso-${numero_imagen}`).css('width',percentComplete);
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
                        var data = $.parseJSON(response)
                        var url = "<?php echo base_url();?>";                     

                        if(data.codigo == 0){
                            $(`#panel-image--div_icon-${numero_imagen}`).hide() 
                            $(`#img-${numero_imagen}`).attr('src', url+data.mensaje);
                        }else{
                            $(`#icon-${numero_imagen}`).removeClass( "fas fa-spinner fa-3x fa-spin" ).addClass("fa fa-camera fa-3x");
                            $(`#panel-image--div_progreso-${numero_imagen}`).remove()
                            $(`#panel-image--div-delete-${numero_imagen}`).remove()

                            $.alert({
                                title: 'Detectamos un problema.',
                                content: data.mensaje,
                                type: 'red',
                            });
                        }
               
                    
                    }, 
                }); 


    }

    //$(`.panel-image-progress`).draggable();
    //$(".panel-image-progress").draggable({ axis: "x" });
    //$(".panel-upload-images").sortable();
    //$( ".panel-upload-images" ).disableSelection();
    //$( ".panel-upload-images" ).disableSelection();
           


/* CÓDIGO PREVIEW SIN SUBIR A SERVIDOR


var reader = new FileReader();        
reader.onload = function (img) {
    $(`#img-${imagen.alt}`).attr('src', img.target.result);
    $(`#panel-image--div_icon-${imagen.alt}`).hide()      
}
reader.readAsDataURL(imagen.files[0]);   

*/

</script>

