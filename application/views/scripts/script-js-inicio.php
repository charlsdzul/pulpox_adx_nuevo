<script> 
    /**
        Scripts para Inicio.
    */

    $(document).ready(function(){

        $("#btnBuscar").click(function(){ buscarAnuncios(); });
        $("#pulpox_btn_filtros").click(function(){ filtros() });

        if(window.innerWidth<960){
            $("#divFiltrosMovil").css("display","block");
            $("#divFiltrosDesktop").css("display","none");
            $("#divFiltrosDesktop").removeClass("col-7 col-sm-7 col-md-7 col-lg-7 col-xl-6");
            $("#divResultados").addClass("col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12");
            buscarAnunciosGeneral();
        }else{
            $("#divFiltrosMovil").css("display","none");
            $("#divFiltrosDesktop").css("display","block");
            $.when(asignaListasSelects()).done(buscarAnunciosGeneral());
        }
    });

    function filtros(){

    $.confirm({
      icon: 'fas fa-eye',
      title: '<span class="titulo-confirm">Filtros</span>',
      type: 'blue', 
      columnClass: 'large',          
      backgroundDismiss: true,    
      closeIcon: true, 
      content: `
        <div id="" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" > 
            <div class='row justify-content-center m-0'> 
                <div class="form-row">
                    <div class="form-group col-12">
                      <label class='pulpox-titulo-filtro'>¿Qué buscas?</label>
                      <input id="txtBusquedaM" type="text" class="form-control" >
                    </div>
                    <div class="form-group col-md-12">
                      <label class='pulpox-titulo-filtro'>Estado</label>
                      <select id="slctEstadoM" class="form-control pulpox-validar-select"></select> 
                    </div>
                    <div class="form-group col-12">
                      <label class='pulpox-titulo-filtro'>Ciudad</label>
                      <select id="slctCiudadM" class="form-control pulpox-validar-select" ></select> 
                    </div>
                    <div class="form-group col-12">
                      <label class='pulpox-titulo-filtro'>Sección</label>
                      <select id="slctSeccionM" class="form-control pulpox-validar-select" ></select> 
                    </div>
                    <div class="form-group col-12">
                      <label class='pulpox-titulo-filtro'>Apartado</label>
                      <select id="slctApartadoM" class="form-control pulpox-validar-select"  ></select> 
                    </div> 
                    <div class="form-group col-12">
                      <label class='pulpox-titulo-filtro'>Personas o negocios que..</label>
                      <select id="slctModalidadM" class="form-control pulpox-validar-select"></select> 
                    </div>
                    <div class="form-group col-12">
                      <label class='pulpox-titulo-filtro'>Mostrar</label>
                      <select id="slctMostrarM" class="form-control pulpox-validar-select" ></select>  
                    </div>
                </div>
            </div>  
        </div> 
      `,
      onContentReady:function(){
        asignaListasSelectsM();
      },
      buttons: {
        buscarAnuncios: {
          text: 'Buscar',
          btnClass: 'btn-pulpox-primary',   
          action: function(){
            buscarAnunciosM(pagina = 1);
          }              
        }, 
        cerrarFiltros: {
          text: 'Cerrar',
          btnClass: 'btn-pulpox-info--secondary',              
        },                 
      }
    });  

    }

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
            console.log(response['pulpox']); 
            $("tr").remove();
            $("#pulpox_pagination li").remove();

            if(response.codigo==1){
            } else {               
                let lista_anuncios= "";
                let total_paginas = response['pulpox'].total_paginas;
                Object.values(response).forEach(val  => {    
                    if(val.numero != null){ 
                        lista_anuncios += ` 
                        <tr>
                            <td>
                            <a href="${val.public_id}" target="#_blank" class="link_anuncio"> ${val.titulo} </a>
                            <span class="modalidad_anuncio">${val.modalidad}</span> 
                            <span class="datos_anuncio">| ${val.estado} > ${val.ciudad} 
                            > ${val.seccion} > ${val.apartado} |
                            ${val.renovado}</span>
                            </td>
                        </tr>`; 
                    }
                });      
                    
                $("#anuncios_table").append(lista_anuncios);
                                  
                let lista_paginas= "";
                for (let index = 1; index <= total_paginas; index++) {
                    lista_paginas += `<li class="page-item"><button class="page-link" onclick="buscarAnuncios(${index})">${index}</button></li>`;                 
                }                            
                    
                $("#pulpox_pagination").append(lista_paginas); 

                $('#resultadosNumero').text("Está viendo " + response['pulpox'].anuncios_mostrados +  " de " + response['pulpox'].total_anuncios + " anuncios.");

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

        $.get((BASE_URL+'inicio/buscarAnuncios/' ), datosBusqueda, function(response){
            response = JSON.parse(response);   
            console.log(response['pulpox']);   
            $("tr").remove();
            $("#pulpox_pagination li").remove();
            if(response.codigo==1){
            } else {                
                let lista_anuncios= "";
                let total_paginas = response['pulpox'].total_paginas;
                Object.values(response).forEach(val  => {    
                if(val.numero != null){
                    lista_anuncios += ` 
                    <tr>
                        <td>
                        <a href="${val.public_id}" target="#_blank" class="link_anuncio"> ${val.titulo} </a>
                        <span class="modalidad_anuncio">${val.modalidad}</span> 
                        <span class="datos_anuncio">| ${val.estado} > ${val.ciudad} 
                        > ${val.seccion} > ${val.apartado} |
                        ${val.renovado}</span>
                        </td>
                    </tr>`; 

                }
                    
                });     

                $("#anuncios_table").append(lista_anuncios);

                let lista_paginas= "";
                for (let index = 1; index <= total_paginas; index++) {
                    lista_paginas += `<li class="page-item"><button class="page-link" onclick="buscarAnuncios(${index})">${index}</button></li>`;                 
                }                            
                    
                $("#pulpox_pagination").append(lista_paginas);   

                $('#resultadosNumero').text("Está viendo " + response['pulpox'].anuncios_mostrados +  " de " + response['pulpox'].total_anuncios + " anuncios.");      
        
            }
        }) 
    }

    function asignaListasSelectsM(){
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
                $('#slctModalidadM').children().remove();
                $('#slctModalidadM').append(lista_modalidades)    
        });    

        

        $.get( BASE_URL+"General/obtenerEstados", function( response ) {       
            response = JSON.parse(response);
            let lista_estados='';
            $.each(response, function(key, value){
                lista_estados += `<option value="${value.nombre}">${value.nombre}</option>`;
            });
                $('#slctEstadoM').children().remove();
                $('#slctEstadoM').append(lista_estados);    
                $('#slctEstadoM').val("Todo México") ;   
                $('#slctEstadoM').change();
                console.log("asasa");
        });        

        $('#slctEstadoM').change(function(){
            let estado = $('#slctEstadoM').val();           
                $('#slctCiudadM').find('option').remove() //Remover options actuales
            $.get( BASE_URL+"General/obtenerCiudades",{estado}, function( response ) {      
                response = JSON.parse(response);
                let lista_ciudades='<option value="Todas">Todas</option>';
                    $.each(response, function(key, value){
                        lista_ciudades += `<option value="${value.nombre}">${value.nombre}</option>`;
                    }); 
                    $('#slctCiudadM').children().remove();
                    $('#slctCiudadM').append(lista_ciudades) //Asignar lista de apartado correspondiente según la sección elegida.           
                    $('#slctCiudadM').val("Todas")      
            });    

            
                                       
        })

        $.get(BASE_URL+"General/obtenerSecciones", function( response ) {       
            response = JSON.parse(response);
            let lista_secciones='';
            $.each(response, function(key, value){
                lista_secciones += `<option value="${value.nombre}">${value.nombre}</option>`;
            });
            $('#slctSeccionM').children().remove(); 
            $('#slctSeccionM').append(lista_secciones) 
            $('#slctSeccionM').val("Todas")    
            $('#slctSeccionM').change()    

        });

        $('#slctSeccionM').change(function(){
            let seccion = $(this).val();
            $('#slctApartadoM').find('option').remove() //Remover options actuales
            $.get( BASE_URL+"General/obtenerApartados",{seccion}, function( response ) {      
                response = JSON.parse(response);  
                let lista_apartados='<option value="Todos">Todas</option>'; 
                    $.each(response, function(key, value){
                        lista_apartados += `<option value="${value.nombre}">${value.nombre}</option>`;
                    }); 
                    $('#slctApartadoM').children().remove();
                    $('#slctApartadoM').append(lista_apartados) //Asignar lista de apartado correspondiente según la sección elegida.
                    $
                  
            });                     
        })   
        
        $.get(BASE_URL+"General/obtenerAnunciosCantidad", function( response ) {       
            response = JSON.parse(response);
            let lista_cantidades='';
            $.each(response, function(key, value){
                lista_cantidades += `<option value="${value.cantidad}">${value.cantidad}</option>`;
            });
            $('#slctMostrarM').children().remove(); 
            $('#slctMostrarM').append(lista_cantidades);
           // $('#slctMostrar').val(lista_cantidades) 
            $('#slctMostrarM').val($('#slctMostrarM').find('option').first().val());

        });
    }   
    
    function buscarAnunciosM(pagina = 1){  

        let datosBusqueda = {
            "textoBuscar": $("#txtBusquedaM").val(),
            "modalidad": $("#slctModalidadM").val(),
            "estado": $("#slctEstadoM").val(),
            "ciudad": $("#slctCiudadM").val(),
            "seccion": $("#slctSeccionM").val(),
            "apartado": $("#slctApartadoM").val(),
            "estado": $("#slctEstadoM").val(),
            "numeroMostrar": $("#slctMostrarM").val(),
            "paginaSeleccionada" : pagina,
        }      

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


    $('#slctEstado').change(function(){
        try {
            
        } catch (error) {
            buscarAnuncios(pagina = 1); 
        }
                                              
    })

    $('#slctCiudad').change(function(){
        try {
            
        } catch (error) {
            buscarAnuncios(pagina = 1); 
        }                                    
    })
        

    $('#slctSeccion').change(function(){
        try {
            
        } catch (error) {
            buscarAnuncios(pagina = 1); 
        }                                      
    })

    
    $('#slctApartado').change(function(){
        try {
            
        } catch (error) {
            buscarAnuncios(pagina = 1); 
        }                                      
    })

    
    $('#slctModalidad').change(function(){
        try {
            
        } catch (error) {
            buscarAnuncios(pagina = 1); 
        }                                      
    })
        
        
  

</script>