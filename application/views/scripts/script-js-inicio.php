<script> 
    /**
        Scripts para Inicio.
    */

    $(document).ready(function() { 
        
        $.when(asignaListasSelects())
        .done(buscarAnunciosGeneral());         

        $("#btnBuscar").click(function(){
            buscarAnuncios();
        });
    });

    function asignaListasSelects(){
        /**Define lista de datos a los inputs ESTADO, CIUDAD, SECCION, APARTADO    
        * Asigna lista de Estados a 'Estado'. Inicia en 'Chihuahua'
        * Asigna lista de ciudades correspondientes a 'Chihuahua'. Inicia en 'Juárez'
        * Al cambiar el Estado, se asignan sus ciudades correspondientes
        */    

        $.get( BASE_URL+"General/obtenerModalidadesFrase", function( response ) {       
            response = JSON.parse(response);
            let lista_modalidades='<option value="Todas" selected>Todas</option>';
            $.each(response, function(key, value){
                lista_modalidades += `<option value="${value.frase}">${value.frase}</option>`;
            });
                $('#slctModalidad').children().remove();
                $('#slctModalidad').append(lista_modalidades)    
        });    

        $.get( BASE_URL+"General/obtenerEstados", function( response ) {       
            response = JSON.parse(response);
            let lista_estados='';
            $.each(response, function(key, value){
                lista_estados += `<option value="${value.nombre}">${value.nombre}</option>`;
            });
                $('#slctEstado').children().remove();
                $('#slctEstado').append(lista_estados)    
                $('#slctEstado').val("Todo México")    
                $('#slctEstado').change()    
        });        

        $('#slctEstado').change(function(){
            let estado = $('#slctEstado').val();           
                $('#slctCiudad').find('option').remove() //Remover options actuales
            $.get( BASE_URL+"General/obtenerCiudades",{estado}, function( response ) {      
                response = JSON.parse(response);
                let lista_ciudades='<option value="Todas">Todas</option>';
                    $.each(response, function(key, value){
                        lista_ciudades += `<option value="${value.nombre}">${value.nombre}</option>`;
                    }); 
                    $('#slctCiudad').children().remove();
                    $('#slctCiudad').append(lista_ciudades) //Asignar lista de apartado correspondiente según la sección elegida.           
                    $('#slctCiudad').val("Todas")      
            });    

            
                                       
        })

        $.get(BASE_URL+"General/obtenerSecciones", function( response ) {       
            response = JSON.parse(response);
            let lista_secciones='';
            $.each(response, function(key, value){
                lista_secciones += `<option value="${value.nombre}">${value.nombre}</option>`;
            });
            $('#slctSeccion').children().remove(); 
            $('#slctSeccion').append(lista_secciones) 
            $('#slctSeccion').val("Todas")    
            $('#slctSeccion').change()    

        });

        $('#slctSeccion').change(function(){
            let seccion = $(this).val();
            $('#slctApartado').find('option').remove() //Remover options actuales
            $.get( BASE_URL+"General/obtenerApartados",{seccion}, function( response ) {      
                response = JSON.parse(response);  
                let lista_apartados='<option value="Todos">Todas</option>'; 
                    $.each(response, function(key, value){
                        lista_apartados += `<option value="${value.nombre}">${value.nombre}</option>`;
                    }); 
                    $('#slctApartado').children().remove();
                    $('#slctApartado').append(lista_apartados) //Asignar lista de apartado correspondiente según la sección elegida.
                    $
                  
            });                     
        })   
        
        $.get(BASE_URL+"General/obtenerAnunciosCantidad", function( response ) {       
            response = JSON.parse(response);
            let lista_cantidades='';
            $.each(response, function(key, value){
                lista_cantidades += `<option value="${value.cantidad}">${value.cantidad}</option>`;
            });
            $('#slctMostrar').children().remove(); 
            $('#slctMostrar').append(lista_cantidades);
           // $('#slctMostrar').val(lista_cantidades) 
            $('#slctMostrar').val($('#slctMostrar').find('option').first().val());

        });
    }     
        
    function buscarAnunciosGeneral(){   

        $.get((BASE_URL+'inicio/buscarAnunciosGeneral' ), function(response){
            response = JSON.parse(response);      
            $("tr").remove();
            $("#pulpox_pagination li").remove();

            if(response.codigo==1){
            } else {               
                let lista_anuncios= "";
                let total_paginas = "";
                Object.values(response).forEach(val  => {       
                    total_paginas = val.total_paginas;          
                    lista_anuncios += ` 
                    <tr>
                        <td>
                        <a href="${val.public_id}" target="#_blank" class="link_anuncio"> ${val.titulo} </a>
                        <span class="modalidad_anuncio">${val.modalidad}</span> 
                        <span class="datos_anuncio">| ${val.estado} > ${val.ciudad} 
                        > ${val.seccion} > ${val.apartado} |
                        (${val.renovado})</span>
                        </td>
                    </tr>`; 
                });      
                    
                $("#anuncios_table").append(lista_anuncios);
                                  
                let lista_paginas= "";
                for (let index = 1; index <= total_paginas; index++) {
                    lista_paginas += `<li class="page-item"><button class="page-link" onclick="buscarAnuncios(${index})">${index}</button></li>`;                 
                }                            
                    
                $("#pulpox_pagination").append(lista_paginas);  


            }
        })
    }  

    function buscarAnuncios(pagina = 1){  
        let datosBusqueda = {
            "textoBuscar": $("#txtBusqueda").val(),
            "modalidad": $("#slctModalidad").val(),
            "estado": $("#slctEstado").val(),
            "ciudad": $("#slctCiudad").val(),
            "seccion": $("#slctSeccion").val(),
            "apartado": $("#slctApartado").val(),
            "estado": $("#slctEstado").val(),
            "numeroMostrar": $("#slctMostrar").val(),
            "paginaSeleccionada" : pagina,
        }
        console.log(datosBusqueda);

        $.get((BASE_URL+'inicio/buscarAnuncios/' ), datosBusqueda, function(response){

            response = JSON.parse(response);      
            $("tr").remove();
            $("#pulpox_pagination li").remove();
            if(response.codigo==1){
            } else {                
                let lista_anuncios= "";
                let total_paginas = "";
                Object.values(response).forEach(val  => {       
                    total_paginas = val.total_paginas;          
                    lista_anuncios += ` 
                    <tr>
                        <td>
                        <a href="${val.public_id}" target="#_blank" class="link_anuncio"> ${val.titulo} </a>
                        <span class="modalidad_anuncio">${val.modalidad}</span> 
                        <span class="datos_anuncio">| ${val.estado} > ${val.ciudad} 
                        > ${val.seccion} > ${val.apartado} |
                        (${val.renovado})</span>
                        </td>
                    </tr>`; 
                });     

                $("#anuncios_table").append(lista_anuncios);

                let lista_paginas= "";
                for (let index = 1; index <= total_paginas; index++) {
                    lista_paginas += `<li class="page-item"><button class="page-link" onclick="buscarAnuncios(${index})">${index}</button></li>`;                 
                }                            
                    
                $("#pulpox_pagination").append(lista_paginas);                          
        
            }
        }) 
    }

</script>