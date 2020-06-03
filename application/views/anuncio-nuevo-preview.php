<body  class=' row justify-content-center'>

    <div id='nuevo_anuncio_previo' class='col-10 col-sm-10 col-md-8 col-lg-8 col-xl-5 mt-3'>
      
        <div class="row justify-content-center title='Título del anuncio'">
            <div class="col-10 col-sm-10 col-md-12 col-lg-12 col-xl-12">
                <h2 id='titulo_preview'></h2>      
            </div>
        </div>

        <div class="row justify-content-left">
            <div class="col-10 col-sm-10 col-md-12 col-lg-12 col-xl-12">
                <div class="icon-label mr-3" title='Modalidad'>                             
                    <img src="<?php echo base_url()?>assets/icons/handshake.png" class='anuncio-nuevo-preview_icon'/>  
                    <label id='modalidad_preview'></label>
                </div>
                <div class="icon-label mr-3" title='Lugar'>                             
                    <img src="<?php echo base_url()?>assets/icons/place-24px.svg" class='anuncio-nuevo-preview_icon'/>  
                    <label id='estado_ciudad'></label>
                </div>
                <div class="icon-label" title='Sección/Apartado'>
                    <img src="<?php echo base_url()?>assets/icons/list-24px.svg" class='anuncio-nuevo-preview_icon'  title="Bootstrap">
                    <label id='seccion_apartado'></label>           
                </div>
            </div>
        </div>

        <div class="row justify-content-center pulpox-carousel" title='Galería de imágenes'>               
        </div>

        <div class="row justify-content-center mt-1">
            <div class="col-10 col-sm-10 col-md-12 col-lg-12 col-xl-12" title='Mensaje'>
                <pre><div id="anuncio_preview">  
                </div></pre>
            </div>
        </div>

        <div class="row justify-content-center mb-3">
            <div class="col-10 col-sm-10 col-md-12 col-lg-12 col-xl-12">
                <span id='modalidad_mensaje'></span>
            </div>        
        </div>

        <div class="row justify-content-center ">
            <div class="col-10 col-sm-10 col-md-12 col-lg-12 col-xl-12">
                <div class="mr-3 icon-label" id='div_telefono_preview' title='Teléfono fijo'>
                    <img src="<?php echo base_url()?>assets/icons/phone-24px.svg" id='anuncio-nuevo-preview_icon--lugar' class='anuncio-nuevo-preview_icon' title="Bootstrap">
                    <label id='telefono_preview'></label>   
                </div>

                <div class="mr-3 icon-label" id='div_celular_preview' title='Celular'>
                    <img src="<?php echo base_url()?>assets/icons/stay_current_portrait-24px.svg" id='anuncio-nuevo-preview_icon--lugar' class='anuncio-nuevo-preview_icon' title="Bootstrap">
                    <label id='celular_preview'></label>  
                </div>
                
                <div class="mr-3 icon-label" id='div_correo_preview' title='Correo'>
                    <img src="<?php echo base_url()?>assets/icons/email-24px.svg" class='anuncio-nuevo-preview_icon'  title="Bootstrap">
                    <label id='correo_preview'></label>     
                </div>
            </div>
        </div>

    </div>   


    <div class="row justify-content-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-5">
    <a href="<?php echo base_url() . 'index.php/' .'anuncio/nuevo/' . $anuncio_id; ?>" id='boton_editar' class="btn ml-1 mr-1 btn-pulpox-secondary">Editar</a>
    <button id='boton_publicar' class="btn btn-pulpox-primary">Publicar</button>
    </div>





</body>
