<script src="<?php echo base_url();?>assets/util/estados.js"></script>
<script src="<?php echo base_url();?>assets/util/ciudades_CHH.js"></script>
<script src="<?php echo base_url();?>assets/util/secciones.js"></script>
<script src="<?php echo base_url();?>assets/util/apartados.js"></script>

<script>

/**
 * Validación para el formulario en generales
 */
    (function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
        });
    }, false);
    })();


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
 * Asignar valores previamente almacenados
*/
        let anuncio_id = <?php echo $anuncio_id?> //Variable pasada a al view

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

/**
 * Almacenar datos en sessionStorag        
* */
        $('#boton_previzualizar').click(function(){  
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
        }) 

</script>