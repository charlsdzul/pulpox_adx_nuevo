<body  class=' row justify-content-center'>

    <form  id='nuevo_anuncio_form'class='needs-validation col-12' novalidate>
      
        <div class="form-row justify-content-center">
            <div class="form-group col-10 col-sm-10 col-md-8 col-lg-8 col-xl-4">
                <label for="titulo">Título*</label>
                <input type="text" id='titulo' class="form-control"  maxlength="50" required>
                <div class="invalid-feedback">
                        Elije un título
                </div>
            </div>
        </div>

        <div class="form-row justify-content-center">
            <div class="form-group col-10 col-sm-10 col-md-8 col-lg-8 col-xl-4">
                <label for="anuncio">Anuncio*</label>
                <textarea id='anuncio' class="form-control" aria-label="With textarea" rows="10" maxlength="1000" required></textarea>
                <div class="invalid-feedback">
                        Escribe tu anuncio
                </div>
            </div>
        </div>

        <div class="form-row form-row justify-content-center">
            <div class="form-group col-10 col-sm-5 col-md-4 col-lg-2 col-xl-2">
                <label for="estado">Estado*</label>
                <select id="estado" class="form-control"  >                 
                </select>   
                <div class="invalid-feedback">
                       Elije un Estado
                </div>
            </div>

            <div class="form-group col-10 col-sm-5 col-md-4 col-lg-2 col-xl-2">
                <label for="ciudad">Ciudad*</label>
                <select id="ciudad" class="form-control" required>
                    
                </select>  
                <div class="invalid-feedback">
                        Elije una ciudad
                </div>
            </div>

            <div class="form-group col-10 col-sm-5 col-md-4 col-lg-2 col-xl-2">
                <label for="seccion">Sección*</label>
                <select id="seccion" class="form-control" required>
                </select>  
                <div class="invalid-feedback">
                        Elije una sección
                </div>
            </div>

         

            <div class="form-group col-10 col-sm-5 col-md-4 col-lg-2 col-xl-2">
                <label for="apartado">Apartado*</label>
                <select id="apartado" class="form-control" required>
                </select>  
                <div class="invalid-feedback">
                        Elije un apartado
                </div>
            </div>
        </div>

        <div class="form-row form-row justify-content-center">
            <div class="form-group col-5 col-sm-5 col-md-2 col-lg-2 col-xl-1">
                <label for="telefono">Tel</label>
                <input id='telefono' type="text" class="form-control" maxlength="10">
                <small  class="form-text text-muted">Ej. 6561234567</small>
            </div>

            <div class="form-group col-5 col-sm-5 col-md-2 col-lg-2 col-xl-1">
                <label for="celular">Cel</label>
                <input id="celular" type="email" class="form-control" maxlength="10">
                <small class="form-text text-muted">Ej. 6561234567</small>
            </div>

            <div class="form-group col-10 col-sm-10 col-md-4 col-lg-4 col-xl-2">
                <label for="correo">Correo</label>
                <input id="correo" type="email" class="form-control"  >
                <div class="invalid-feedback">
                       Correo inválido
                </div>
            </div>
        </div>

    </form>    


    <div class="row justify-content-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <a href="<?php echo base_url() . 'index.php/' .'anuncio/preview/' . $anuncio_id; ?>" id='boton_previzualizar' class="btn btn-pulpox-primary ">Previsualizar</a>
    </div>
</body>


