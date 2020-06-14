<script>
    var datos_anuncio = <?php echo json_encode($datos_anuncio); ?>;
</script>

<body class='container-fluid p-0'>
    <div class='row justify-content-center m-0'>    
        <div class="mt-2 col-10 col-sm-10 col-md-8 col-lg-8 col-xl-5 mt-3"> 
            <H1>Editar Anuncio</H1>
        </div> 
    </div>
    <div class='row justify-content-center m-0'>
     <div  id='nuevo_anuncio_form' class='col-10 col-sm-10 col-md-8 col-lg-8 col-xl-5 mt-3' >   
        
            <div class="form-row justify-content-center">
                <div class="form-group col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <label for="titulo">Título</label>
                    <input type="text" id='titulo' class="form-control pulpox-validar" maxlength="50" >
                    <div class="pulpox-invalid-feedback">
                            Elije un título
                    </div>
                </div>
            </div>

            <div class="form-row justify-content-center">
                <div class="form-group col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <label for="mensaje">Anuncio</label>
                    <textarea id='mensaje' class="form-control pulpox-validar" aria-label="With textarea" rows="10" maxlength="1000"></textarea>
                    <div class="pulpox-invalid-feedback">Escribe tu anuncio</div>
                </div>
            </div>

            <div class="form-row form-row justify-content-center">
                <div class="form-group col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <label for="estado">Estado*</label>
                    <select id="estado" class="form-control pulpox-validar-select">                 
                    </select>   
                    <div class="pulpox-invalid-feedback">
                        Elije un Estado
                    </div>
                </div>

                <div class="form-group col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <label for="ciudad">Ciudad</label>
                    <select id="ciudad" class="form-control pulpox-validar-select" >             
                    </select>  
                    <div class="pulpox-invalid-feedback">
                            Elije una ciudad
                    </div>
                </div>
            </div>
            
            <div class="form-row form-row justify-content-center">
                <div class="form-group col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                    <label for="modalidad">Modalidad</label>
                    <select id="modalidad" class="form-control pulpox-validar-select">                 
                    </select>  
                    <div class="pulpox-invalid-feedback">
                            Elije una modalidad
                    </div>
                </div>

                <div class="form-group col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                    <label for="seccion">Sección</label>
                    <select id="seccion" class="form-control pulpox-validar-select" >
                    </select>  
                    <div class="pulpox-invalid-feedback">
                            Elije una sección
                    </div>
                </div>         

                <div class="form-group col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                    <label for="apartado">Apartado</label>
                    <select id="apartado" class="form-control pulpox-validar-select" >                    
                    </select>  
                    <div class="pulpox-invalid-feedback">
                            Elije un apartado
                    </div>
                </div>
            </div>

            <div class="form-row justify-content-center">
                <div class="form-group col-6 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                    <label for="telefono">Tel (opcional)</label>
                    <input id='telefono' type="text" class="form-control" maxlength="10">
                    <div class="pulpox-invalid-feedback">
                            Deben ser 10 dígitos.
                    </div>
                    <small  class="form-text text-muted">Ej. 6561234567</small>                
                </div>

                <div class="form-group col-6 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                    <label for="celular">Cel (opcional)</label>
                    <input id="celular" type="email" class="form-control" maxlength="10">
                    <div class="pulpox-invalid-feedback">
                            Deben ser 10 dígitos.
                    </div>
                    <small class="form-text text-muted">Ej. 6561234567</small>
                </div>

                <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <label for="correo">Correo (opcional)</label>
                    <input id="correo" type="email" class="form-control"  >
                    <div class="pulpox-invalid-feedback">
                            Correo inválido
                    </div>
                </div>
        
            </div>

            <div class="form-row panel-upload-images justify-content-center">

                <div id='panel-image-progress-1' class='panel-image-progress mb-4'> 
                    <div id='panel-image-1' class='panel-image'>
                        <img id='img-1' class='imagen_preview' src=""/>
                        <div id='panel-image--div_icon-1' class='panel-image--div_icon'> 
                            <label for="input-image-1">
                            <i id='icon-1' class="fa fa-camera fa-3x panel-image--icon" aria-hidden="true" ></i>  
                            </label>
                        </div>
                                        
                        <input id='input-image-1' type="file" style='display:none;' onchange='validarImagen(this, "<?php echo $datos_anuncio["public_id"]; ?>","1")'>
                    </div>  
                <!--    <div id='pulpox-message-principal-1' class="pulpox-message--principal">
                        <span>Principal</span>
                    </div>    -->
                    <div id="pulpox-invalid-feedback-1" class="pulpox-invalid-feedback">
                    </div>                        
                </div> 

                <div id='panel-image-progress-2' class='panel-image-progress mb-4'> 
                    <div id='panel-image-2' class='panel-image'>
                        <img id='img-2' class='imagen_preview' src=""/>
                        <div id='panel-image--div_icon-2' class='panel-image--div_icon'> 
                            <label for="input-image-2">
                            <i id='icon-2' class="fa fa-camera fa-3x panel-image--icon" aria-hidden="true"></i>  
                            </label>
                        </div>
                                        
                        <input id='input-image-2' type="file" style='display:none;' onchange='validarImagen(this, "<?php echo $datos_anuncio["public_id"]; ?>","2")'>
                    </div>  
                    <div id="pulpox-invalid-feedback-2" class="pulpox-invalid-feedback">
                    </div>                        
                </div> 

                <div id='panel-image-progress-3' class='panel-image-progress mb-4'> 
                    <div id='panel-image-3' class='panel-image'>
                        <img id='img-3' class='imagen_preview' src=""/>
                        <div id='panel-image--div_icon-3' class='panel-image--div_icon'> 
                            <label for="input-image-3">
                            <i id='icon-3' class="fa fa-camera fa-3x panel-image--icon" aria-hidden="true"></i>  
                            </label>
                        </div>
                                        
                        <input id='input-image-3' type="file" style='display:none;' onchange='validarImagen(this, "<?php echo $datos_anuncio["public_id"]; ?>","3")'>
                    </div>  
                    <div id="pulpox-invalid-feedback-3" class="pulpox-invalid-feedback">
                    </div>                        
                </div> 

                <div id='panel-image-progress-4' class='panel-image-progress mb-4'> 
                    <div id='panel-image-4' class='panel-image'>
                        <img id='img-4' class='imagen_preview' src=""/>
                        <div id='panel-image--div_icon-4' class='panel-image--div_icon'> 
                            <label for="input-image-4">
                            <i id='icon-4' class="fa fa-camera fa-3x panel-image--icon" aria-hidden="true"></i>  
                            </label>
                        </div>
                                        
                        <input id='input-image-4' type="file" style='display:none;' onchange='validarImagen(this, "<?php echo $datos_anuncio["public_id"]; ?>","4")'>
                    </div>  
                    <div id="pulpox-invalid-feedback-4" class="pulpox-invalid-feedback">
                    </div>                        
                </div> 

                <div id='panel-image-progress-5' class='panel-image-progress mb-4'> 
                    <div id='panel-image-5' class='panel-image'>
                        <img id='img-5' class='imagen_preview' src=""/>
                        <div id='panel-image--div_icon-5' class='panel-image--div_icon'> 
                            <label for="input-image-5">
                            <i id='icon-5' class="fa fa-camera fa-3x panel-image--icon" aria-hidden="true"></i>  
                            </label>
                        </div>
                                        
                        <input id='input-image-5' type="file" style='display:none;' onchange='validarImagen(this, "<?php echo $datos_anuncio["public_id"]; ?>","5")'>
                    </div>  
                    <div id="pulpox-invalid-feedback-5" class="pulpox-invalid-feedback">
                    </div>                        
                </div> 

                <div id='panel-image-progress-6' class='panel-image-progress mb-4'> 
                    <div id='panel-image-6' class='panel-image'>
                        <img id='img-6' class='imagen_preview' src=""/>
                        <div id='panel-image--div_icon-6' class='panel-image--div_icon'> 
                            <label for="input-image-6">
                            <i id='icon-6' class="fa fa-camera fa-3x panel-image--icon" aria-hidden="true"></i>  
                            </label>
                        </div>
                                        
                        <input id='input-image-6' type="file" style='display:none;' onchange='validarImagen(this, "<?php echo $datos_anuncio["public_id"]; ?>","6")'>
                    </div>  
                    <div id="pulpox-invalid-feedback-6" class="pulpox-invalid-feedback">
                    </div>                        
                </div> 

                <div id='panel-image-progress-7' class='panel-image-progress mb-4'> 
                    <div id='panel-image-7' class='panel-image'>
                        <img id='img-7' class='imagen_preview' src=""/>
                        <div id='panel-image--div_icon-7' class='panel-image--div_icon'> 
                            <label for="input-image-7">
                            <i id='icon-7' class="fa fa-camera fa-3x panel-image--icon" aria-hidden="true"></i>  
                            </label>
                        </div>
                                        
                        <input id='input-image-7' type="file" style='display:none;' onchange='validarImagen(this, "<?php echo $datos_anuncio["public_id"]; ?>","7")'>
                    </div>  
                    <div id="pulpox-invalid-feedback-7" class="pulpox-invalid-feedback">
                    </div>                        
                </div> 

                <div id='panel-image-progress-8' class='panel-image-progress mb-4'> 
                    <div id='panel-image-8' class='panel-image'>
                        <img id='img-8' class='imagen_preview' src=""/>
                        <div id='panel-image--div_icon-8' class='panel-image--div_icon'> 
                            <label for="input-image-8">
                            <i id='icon-8' class="fa fa-camera fa-3x panel-image--icon" aria-hidden="true"></i>  
                            </label>
                        </div>
                                        
                        <input id='input-image-8' type="file" style='display:none;' onchange='validarImagen(this, "<?php echo $datos_anuncio["public_id"]; ?>","8")'>
                    </div>  
                    <div id="pulpox-invalid-feedback-8" class="pulpox-invalid-feedback">
                    </div>                        
                </div> 

                <div id='panel-image-progress-9' class='panel-image-progress mb-4'> 
                    <div id='panel-image-9' class='panel-image'>
                        <img id='img-9' class='imagen_preview' src=""/>
                        <div id='panel-image--div_icon-9' class='panel-image--div_icon'> 
                            <label for="input-image-9">
                            <i id='icon-9' class="fa fa-camera fa-3x panel-image--icon" aria-hidden="true"></i>  
                            </label>
                        </div>
                                        
                        <input id='input-image-9' type="file" style='display:none;' onchange='validarImagen(this, "<?php echo $datos_anuncio["public_id"]; ?>","9")' >
                    </div>  
                    <div id="pulpox-invalid-feedback-9" class="pulpox-invalid-feedback">
                    </div>                        
                </div> 

                <div id='panel-image-progress-10' class='panel-image-progress mb-4'> 
                    <div id='panel-image-10' class='panel-image'>
                        <img id='img-10' class='imagen_preview' src=""/>
                        <div id='panel-image--div_icon-10' class='panel-image--div_icon'> 
                            <label for="input-image-10">
                            <i id='icon-10' class="fa fa-camera fa-3x panel-image--icon" aria-hidden="true"></i>  
                            </label>
                        </div>
                                        
                        <input id='input-image-10' type="file" style='display:none;' onchange='validarImagen(this, "<?php echo $datos_anuncio["public_id"]; ?>","10")'>
                    </div>  
                    <div id="pulpox-invalid-feedback-10" class="pulpox-invalid-feedback">
                    </div>                        
                </div> 

            </div>  
        </div>    

        <div class="row justify-content-center mb-3 col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <button id='boton_guardar' class="btn btn-pulpox-info">Guardar Edición</button>            
        </div>
    </div>
</body>
