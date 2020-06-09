<body class='container-fluid p-0'>
    <div class='row justify-content-center m-0'>    
        <div class="col-10 col-sm-10 col-md-8 col-lg-8 col-xl-5 mt-3"> 
        <H1>Anuncio Previo</H1>
        </div> 
    </div>
    <div class='row justify-content-center m-0'>
        <div id='nuevo_anuncio_previo' class='col-10 col-sm-10 col-md-8 col-lg-8 col-xl-5'>
        
            <div class="row justify-content-center" id='nuevo_anuncio_previo--titulo' title='Título del anuncio'>
                <div class="div-titulo col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <h1 id='titulo_preview'></h1>      
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="div-modSecApa col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
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

            <div class="row justify-content-center div-carousel pulpox-carousel" title='Galería de imágenes'>               
            </div>
           
                <div class="row justify-content-center"> 
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" title='Mensaje'>
                        <div class='div-mensaje' id="mensaje_preview">  
                        </div>
                    </div>
                   </div>   
                  

            <div class="row justify-content-center div-forma-contacto">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="mr-3 icon-label div-contacto" id='div_telefono_preview' title='Teléfono fijo'>
                        <img src="<?php echo base_url()?>assets/icons/phone-24px.svg" id='anuncio-nuevo-preview_icon--lugar' class='anuncio-nuevo-preview_icon' title="Bootstrap">
                        <label id='telefono_preview'></label>   
                    </div>

                    <div class="mr-3 icon-label div-contacto" id='div_celular_preview' title='Celular'>
                        <img src="<?php echo base_url()?>assets/icons/stay_current_portrait-24px.svg" id='anuncio-nuevo-preview_icon--lugar' class='anuncio-nuevo-preview_icon' title="Bootstrap">
                        <label id='celular_preview'></label>  
                    </div>
                    
                    <div class="mr-3 icon-label div-contacto" id='div_correo_preview' title='Correo'>
                        <img src="<?php echo base_url()?>assets/icons/email-24px.svg" class='anuncio-nuevo-preview_icon'  title="Bootstrap">
                        <label id='correo_preview'></label>     
                    </div>
                </div>
            </div>

      <!--      <div class="row justify-content-center div-modalidad-mensaje" id='modalidad_mensaje--div'>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <span id='modalidad_mensaje'></span>
                </div>        
            </div>
-->

        </div>  

        <div class="row justify-content-center mb-3 col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3">
            <a href="<?php echo base_url() . 'index.php/' .'mianuncio/nuevo/' . $anuncio_id; ?>" id='boton_editar' class="btn ml-1 mr-1 btn-pulpox-secondary--line">Editar</a>
            <button id='boton_publicar' class="btn btn-pulpox-secondary">Publicar</button>
        </div>
    </div>
</body>
