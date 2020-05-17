    <body>
        <div class='container mt-2 stock-container'>

            <div class='row justify-content-md-center stock-container__sections'>
                <div class="col stock-container__section">
                    <button type="button" id ='public-stock-filter__area--title--residencial' class="btn btn-primary btn-lg btn-block" onclick="getFilter('residencial','comercial','terreno')">Residencial</button>
                </div>

                <div class="col stock-container__section">
                    <button type="button" id ='public-stock-filter__area--title--comercial' class="btn btn-primary btn-lg btn-block" onclick="getFilter('comercial','residencial','terreno')">Comercial</button>
                </div>

                <div class="col stock-container__section">
                    <button type="button" id ='public-stock-filter__area--title--terreno' class="btn btn-primary btn-lg btn-block" onclick="getFilter('terreno','residencial','comercial')">Terrenos</button>
                </div>                        
            </div>         
                       
            <div class='row justify-content-md-center mt-1'>
                <div id='public-stock-filter__area-selected'  class="col-auto stock-container__filters--filter">
                </div> 
            </div>              
        
            <div id='public-stock-resultados' class='row justify-content-md-center mt-1 stock-container__results'>
            </div> 

        </div> 
    </body>






<!--

            <div class="public-stock-filter ">
                    <div class="public-stock-filter__area col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div id ='public-stock-filter__area--title--residencial' class='public-stock-filter__area--title '  onclick="getFilter('residencial','comercial','terreno')">
                            <h1>Residencial</h1>
                        </div>   
                        <div id ='public-stock-filter__area--title--comercial' class='public-stock-filter__area--title '  onclick="getFilter('comercial','residencial','terreno')">
                            <h1>Comercial</h1>
                        </div> 
                        <div id ='public-stock-filter__area--title--terreno' class='public-stock-filter__area--title '  onclick="getFilter('terreno','residencial','comercial')">
                            <h1>Terreno</h1>
                        </div> 
                    <div class="public-stock-filter__area-2" id='public-stock-filter__area-selected'>
                    </div>     
                </div>
            <div class="public-stock-resultados" id='public-stock-resultados'>
            </div>  


-->








<!--
    
    <body>
        <div class='public-stock'>
            <div class="public-stock-filter row">
                    <div class="public-stock-filter__area col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div id ='public-stock-filter__area--title--residencial' class='public-stock-filter__area--title '  onclick="getFilter('residencial','comercial','terreno')">
                            <h1>Residencial</h1>
                        </div>   
                        <div id ='public-stock-filter__area--title--comercial' class='public-stock-filter__area--title '  onclick="getFilter('comercial','residencial','terreno')">
                            <h1>Comercial</h1>
                        </div> 
                        <div id ='public-stock-filter__area--title--terreno' class='public-stock-filter__area--title '  onclick="getFilter('terreno','residencial','comercial')">
                            <h1>Terreno</h1>
                        </div> 
                    <div class="public-stock-filter__area-2" id='public-stock-filter__area-selected'>
                    </div>     
                </div>
            <div class="public-stock-resultados" id='public-stock-resultados'>
            </div>      
        </div>
    </body>
-->