<body class='container-fluid p-0'>   
     
  <div class='row justify-content-center m-0'>  

    <div class="mt-2 col-11 col-sm-11 col-md-11 col-lg-11 col-xl-11"> 
      <div class='row justify-content-center mt-4 mb-4'>  
        <img style='width:30em; 'src="../assets/images/pulpox_logo.png" alt="">
      </div> 
    </div> 

    <div id="divFiltrosDesktop" class="mt-2 col-11 col-sm-11 col-md-11 col-lg-10 col-xl-10" > 
      <div class='row justify-content-center m-0' style="background-color:hsl(341, 100%, 99%); padding:1em; border-radius: 4px; 	-webkit-box-shadow: 0px 10px 10px -5px rgba(0, 0, 0, 0.62);
	-moz-box-shadow: 0px 10px 10px -5px rgba(0, 0, 0, 0.62);
	box-shadow: 0px 10px 10px -5px rgba(0, 0, 0, 0.62);">          
        <div class="form-group col-11 col-sm-6 col-md-3 col-lg-3 col-xl-3">
              <label class='pulpox-titulo-filtro'>Estado</label>
              <select id="slctEstado" class="form-control pulpox-validar-select"></select> 
        </div>
        <div class="form-group col-11 col-sm-6 col-md-3 col-lg-3 col-xl-3">
              <label class='pulpox-titulo-filtro'>Ciudad</label>
              <select id="slctCiudad" class="form-control pulpox-validar-select" ></select> 
        </div>
        <div class="form-group col-11 col-sm-6 col-md-3 col-lg-3 col-xl-3">
              <label class='pulpox-titulo-filtro'>Sección</label>
              <select id="slctSeccion" class="form-control pulpox-validar-select" ></select> 
        </div>
        <div class="form-group col-11 col-sm-6 col-md-3 col-lg-3 col-xl-3">
              <label class='pulpox-titulo-filtro'>Apartado</label>
              <select id="slctApartado" class="form-control pulpox-validar-select"  ></select> 
        </div>            
        <div class="form-group col-11 col-sm-6 col-md-4 col-lg-4 col-xl-3">
              <label class='pulpox-titulo-filtro'>¿Qué buscas?</label>
              <input id="txtBusqueda" type="text" class="form-control" >
        </div>        
        <div class="form-group col-11 col-sm-6 col-md-4 col-lg-4 col-xl-3">
              <label class='pulpox-titulo-filtro'>Personas o negocios que..</label>
              <select id="slctModalidad" class="form-control pulpox-validar-select"></select> 
        </div>
        <div class="form-group col-11 col-sm-6 col-md-2 col-lg-2 col-xl-3">
              <label class='pulpox-titulo-filtro'>Mostrar</label>
              <select id="slctMostrar" class="form-control pulpox-validar-select" ></select>  
        </div>
        <div class="form-group col-11 col-sm-6 col-md-2 col-lg-2 col-xl-3">     
              <label></label>        
              <button id="btnBuscar" class="form-control btn btn-pulpox-primary">Buscar</button>
        </div>  
      </div>  
    </div> 

    <div id="divResultados" class="col-11 col-sm-11 col-md-11 col-lg-10 col-xl-10 mt-4"> 
      <div class='row justify-content-center m-0'>
        <div class="mt-2 col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">  

            <H4>Resultados</H4>
            <table id="anuncios_table" class="table table-striped table-sm table-hover" width="100%">
              <thead class='pulpox-table--thead' width="100%">
                <tr>        
                  <th class="th-sm d-none d-lg-table-cell"></th>        
            
              </thead>
              <tbody class='pulpox-table-tbody' style="">
              </tbody>
              <tfoot>
              </tfoot>
            </table>
            <nav aria-label="Page navigation example">
              <ul class="pagination" id="pulpox_pagination">
              </ul>
            </nav>

        </div>
      </div>
    </div> 

    <div id="divFiltrosMovil" class="mt-2 col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" > 
      <div class='row justify-content-center m-0'>  
        <div class="mt-2 col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">  

          <div class="form-row">
            <div class="form-group col-12">

            <button id="pulpox_btn_filtros">Filtros</button>



            </div>
          </div>

        </div>
      </div>  
    </div> 

    

  </div>
  
</body>
