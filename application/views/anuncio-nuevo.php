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

        <div class="form-row form-row justify-content-center">
            <div class="form-group col-5 col-sm-5 col-md-3 col-lg-3 col-xl-3">
                <label for="telefono">Tel</label>
                <input id='telefono' type="text" class="form-control" maxlength="10">
                <small  class="form-text text-muted">Ej. 6561234567</small>
            </div>

            <div class="form-group col-5 col-sm-5 col-md-3 col-lg-3 col-xl-3">
                <label for="celular">Cel</label>
                <input id="celular" type="email" class="form-control" maxlength="10">
                <small class="form-text text-muted">Ej. 6561234567</small>
            </div>

            <div class="form-group col-10 col-sm-10 col-md-6 col-lg-6 col-xl-6">
                <label for="correo">Correo</label>
                <input id="correo" type="email" class="form-control"  >
            </div>
      
        </div>

       

    </form>    

    <div class="row justify-content-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <button id='boton_previzualizar' class="btn btn-pulpox-primary">Previsualizar</button>
        
      

    </div>

    <button type="button" id='boton-modal' data-toggle="modal" data-target="#exampleModal" style='display:none'>
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirmación</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            No pusiste ningún teléfono o correo de contacto. ¿Así lo quieres publicar?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">No, editar.</button>
            <a href="<?php echo base_url() . 'index.php/' .'anuncio/preview/' . $anuncio_id; ?>" id='boton_previzualizar' class="btn btn-pulpox-primary">Sí, previzualizar.</a>
        </div>
        </div>
    </div>
    </div>

</body>


