<script> 
    /**
        Scripts para Inicio.
    */

    $(document).ready(function() {          
        asignaListasSelects();    
    });

    function asignaListasSelects(){
        /**Define lista de datos a los inputs ESTADO, CIUDAD, SECCION, APARTADO    
        * Asigna lista de Estados a 'Estado'. Inicia en 'Chihuahua'
        * Asigna lista de ciudades correspondientes a 'Chihuahua'. Inicia en 'Juárez'
        * Al cambiar el Estado, se asignan sus ciudades correspondientes
        */    

        $.get( BASE_URL+"General/obtenerEstados", function( response ) {       
            response = JSON.parse(response);
            let lista_estados='<option value="" disabled selected>Selecciona</option>';
            $.each(response, function(key, value){
                lista_estados += `<option value="${value.nombre}">${value.nombre}</option>`;
            });
                $('#slctEstado').children().remove();
                $('#slctEstado').append(lista_estados)    
        });        

        $('#slctEstado').change(function(){
            let estado = $('#slctEstado').val();
            $('#slctCiudad').find('option').remove() //Remover options actuales
            $.get( BASE_URL+"General/obtenerCiudades",{estado}, function( response ) {      
                response = JSON.parse(response);
                let lista_ciudades='<option value="" disabled selected>Ciudad</option>';
                    lista_ciudades+='<option value="Todas">Todas</option>';
                    $.each(response, function(key, value){
                        lista_ciudades += `<option value="${value.nombre}">${value.nombre}</option>`;
                    }); 
                    $('#slctCiudad').children().remove();
                    $('#slctCiudad').append(lista_ciudades) //Asignar lista de apartado correspondiente según la sección elegida.           
                    $('#slctCiudad').prop( "disabled", false );   
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
        });  

        $.get(BASE_URL+"General/obtenerSecciones", function( response ) {       
            response = JSON.parse(response);
            let lista_secciones='<option value="" disabled selected>Selecciona</option>';
            $.each(response, function(key, value){
                lista_secciones += `<option value="${value.nombre}">${value.nombre}</option>`;
            });
            $('#slctSeccion').children().remove(); 
            $('#slctSeccion').append(lista_secciones) 

        });

        $('#slctSeccion').change(function(){
            let seccion = $(this).val();
            $('#slctApartado').find('option').remove() //Remover options actuales
            $.get( BASE_URL+"General/obtenerApartados",{seccion}, function( response ) {      
                response = JSON.parse(response);                
                    let lista_apartados='<option value="Todos" selected>Todos</option>';
                    $.each(response, function(key, value){
                        lista_apartados += `<option value="${value.nombre}">${value.nombre}</option>`;
                    }); 
                    $('#slctApartado').children().remove();
                    $('#slctApartado').append(lista_apartados) //Asignar lista de apartado correspondiente según la sección elegida.
                    $('#slctApartado').prop( "disabled", false );
                    $('#slctApartado').val('');    
                  
            });                     
        })   
        
        $.get(BASE_URL+"General/obtenerAnunciosCantidad", function( response ) {       
            response = JSON.parse(response);
            let lista_cantidades='<option value="" disabled selected>Selecciona</option>';
            $.each(response, function(key, value){
                lista_cantidades += `<option value="${value.cantidad}">${value.cantidad}</option>`;
            });
            $('#slctMostrar').children().remove(); 
            $('#slctMostrar').append(lista_cantidades) 

        });
    }  

</script>