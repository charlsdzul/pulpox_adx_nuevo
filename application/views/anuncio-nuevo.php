<body  class=' row justify-content-center'>

    <form  id='nuevo_anuncio_form' class='col-10 col-sm-10 col-md-8 col-lg-8 col-xl-5' >
      
        <div class="form-row justify-content-center">
            <div class="form-group col-10 col-sm-10 col-md-12 col-lg-12 col-xl-12">
                <label for="titulo">Título</label>
                <input type="text" id='titulo' class="form-control pulpox-validar"  maxlength="50" >
                <div class="pulpox-invalid-feedback">
                        Elije un título
                </div>
            </div>
        </div>

        <div class="form-row justify-content-center">
            <div class="form-group col-10 col-sm-10 col-md-12 col-lg-12 col-xl-12">
                <label for="anuncio">Anuncio</label>
                 <textarea id='anuncio' class="form-control pulpox-validar" aria-label="With textarea" rows="10" maxlength="1000"> <pre></pre></textarea>
                <div class="pulpox-invalid-feedback">
                        Escribe tu anuncio
                </div>
            </div>
        </div>

        <div class="form-row form-row justify-content-center">
            <div class="form-group col-10 col-sm-5 col-md-3 col-lg-6 col-xl-6">
                <label for="estado">Estado*</label>
                <select id="estado" class="form-control pulpox-validar"  >                 
                </select>   
                <div class="pulpox-invalid-feedback">
                       Elije un Estado
                </div>
            </div>

            <div class="form-group col-10 col-sm-5 col-md-3 col-lg-6 col-xl-6">
                <label for="ciudad">Ciudad</label>
                <select id="ciudad" class="form-control pulpox-validar" >
                    
                </select>  
                <div class="pulpox-invalid-feedback">
                        Elije una ciudad
                </div>
            </div>

            <div class="form-group col-10 col-sm-5 col-md-3 col-lg-6 col-xl-6">
                <label for="seccion">Sección</label>
                <select id="seccion" class="form-control pulpox-validar" >
                </select>  
                <div class="pulpox-invalid-feedback">
                        Elije una sección
                </div>
            </div>

         

            <div class="form-group col-10 col-sm-5 col-md-3 col-lg-6 col-xl-6">
                <label for="apartado">Apartado</label>
                <select id="apartado" class="form-control pulpox-validar" >
                </select>  
                <div class="pulpox-invalid-feedback">
                        Elije un apartado
                </div>
            </div>
        </div>

        <div class="form-row justify-content-center">
            <div class="form-group col-5 col-sm-5 col-md-3 col-lg-3 col-xl-3">
                <label for="telefono">Tel (opcional)</label>
                <input id='telefono' type="text" class="form-control" maxlength="10">
                <div class="pulpox-invalid-feedback">
                        Deben ser 10 dígitos.
                </div>
                <small  class="form-text text-muted">Ej. 6561234567</small>                
            </div>

            <div class="form-group col-5 col-sm-5 col-md-3 col-lg-3 col-xl-3">
                <label for="celular">Cel (opcional)</label>
                <input id="celular" type="email" class="form-control" maxlength="10">
                <div class="pulpox-invalid-feedback">
                        Deben ser 10 dígitos.
                </div>
                <small class="form-text text-muted">Ej. 6561234567</small>
            </div>

            <div class="form-group col-10 col-sm-10 col-md-6 col-lg-6 col-xl-6">
                <label for="correo">Correo (opcional)</label>
                <input id="correo" type="email" class="form-control"  >
                <div class="pulpox-invalid-feedback">
                        Correo inválido
                </div>
            </div>
      
        </div>

        <div class="form-row panel-upload-images mb-5">

            <div id='panel-image-progress-1' class='panel-image-progress'> 
                <div id='panel-image-1' class='panel-image'>
                    <img id='img-1' class='imagen_preview' src=""/>
                    <div id='panel-image--div_icon-1' class='panel-image--div_icon'> 
                        <label for="input-image-1">
                        <i id='icon-1' class="fa fa-camera fa-3x panel-image--icon" aria-hidden="true"></i>  
                        </label>
                    </div>                     
                    <input id='input-image-1' type="file" style='display:none;' onchange='uploadImage(this)'data-numero-imagen='1'>
                </div>  
                       
            </div> 

            <div id='panel-image-progress-2' class='panel-image-progress'> 
                <div id='panel-image-2' class='panel-image'>
                    <img id='img-2' class='imagen_preview' src=""/>
                    <div id='panel-image--div_icon-2' class='panel-image--div_icon'> 
                        <label for="input-image-2">
                        <i id='icon-2' class="fa fa-camera fa-3x panel-image--icon" aria-hidden="true"></i>  
                        </label>
                    </div>                     
                    <input id='input-image-2' type="file" style='display:none;' onchange='uploadImage(this)' data-numero-imagen='2'>
                </div>                 
            </div> 



        </div>

        
                    
        
       

    </form>    

    <div class="row justify-content-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <button id='boton_previzualizar' class="btn btn-pulpox-primary">Previsualizar</button>
             

    </div>



</body>


