<body class='container-fluid p-0'>   
     
  <div class='row justify-content-center m-0'>  

    <div class="mt-2 col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"> 
      <div class='row justify-content-center m-0'>  
         <h1>PULPOX</h1>
      </div> 
    </div> 

    <div class="mt-2 col-5 col-sm-5 col-md-4 col-lg-3 col-xl-3" style='background-color:'> 
      <div class='row justify-content-center m-0'>  
        <div class="mt-2 col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="background-color:">  

          <div class="form-row">
            <div class="form-group col-12">
              <label for="inputEmail4">¿Qué buscas?</label>
              <input  id="txtBusqueda" type="text" name="" id="" class="form-control" >
            </div>
            <div class="form-group col-md-12">
              <label for="inputEmail4">Estado</label>
              <select id="slctEstado" class="form-control pulpox-validar-select"></select> 
            </div>
            <div class="form-group col-12">
              <label for="inputPassword4">Ciudad</label>
              <select id="slctCiudad" class="form-control pulpox-validar-select" ></select> 
            </div>
            <div class="form-group col-12">
              <label for="inputPassword4">Sección</label>
              <select id="slctSeccion" class="form-control pulpox-validar-select" ></select> 
            </div>
            <div class="form-group col-12">
              <label for="inputPassword4">Apartado</label>
              <select id="slctApartado" class="form-control pulpox-validar-select"  ></select> 
            </div>
          </div>

          <div class="form-row">
           
            <div class="form-group col-12">
              <label for="inputPassword4">Personas o negocios que..</label>
              <select id="slctModalidad" class="form-control pulpox-validar-select"></select> 
            </div>
            <div class="form-group col-12">
              <label for="inputPassword4">Mostrar</label>
              <select id="slctMostrar" class="form-control pulpox-validar-select" ></select>  
            </div>
            <div class="form-group col-12">   
            <label for="btnBuscar"> </label>    
              <button id="btnBuscar" class="form-control btn btn-pulpox-primary">Buscar</button>
            </div>
          </div>

        </div>
      </div>  
    </div> 

    <div class="     col-7 col-sm-7 col-md-7 col-lg-7 col-xl-6" style='background-color:'> 
      <div class='row justify-content-center m-0'>
        <div class="mt-2 col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">  

            <H1>Resultados</H1>
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

  </div>
  
</body>
