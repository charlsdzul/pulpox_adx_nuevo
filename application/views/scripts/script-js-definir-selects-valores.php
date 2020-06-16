<script>
    function definirSelectsYValores(modalidad,estado,ciudad,seccion,apartado){
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
                $('#estado').val(estado) 
                $('#estado').change()                    
        });        

        $('#estado').change(function(){
            let estado = $('#estado').val();
            $('#ciudad').find('option').remove() //Remover options actuales
            $.get( BASE_URL+"General/obtenerCiudades",{estado}, function( response ) {      
                response = JSON.parse(response);
                let lista_ciudades='';
                    $.each(response, function(key, value){
                        lista_ciudades += `<option value="${value.nombre}">${value.nombre}</option>`;
                    }); 
                    $('#ciudad').children().remove();
                    $('#ciudad').append(lista_ciudades) //Asignar lista de apartado correspondiente según la sección elegida.
                    if(ciudad!=''){
                    $('#ciudad').val(ciudad)
                    ciudad=''
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
            $('#modalidad').val(modalidad)              
        });  

        $.get( BASE_URL+"General/obtenerSecciones", function( response ) {       
            response = JSON.parse(response);
            let lista_secciones='<option value="" disabled selected>Selecciona</option>';
            $.each(response, function(key, value){
                lista_secciones += `<option value="${value.nombre}">${value.nombre}</option>`;
            });
            $('#seccion').children().remove(); 
            $('#seccion').append(lista_secciones) 
            $('#seccion').val(seccion) 
            $('#seccion').change()   

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
                    if(apartado!=''){
                    $('#apartado').val(apartado)
                    apartado=''
                  } 
            });                     
        })  
        
            
    }  
</script>