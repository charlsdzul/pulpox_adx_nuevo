<body  class=' row justify-content-center'>

    <div id='nuevo_anuncio_previo' class='col-10 col-sm-10 col-md-10 col-lg-10 col-xl-6'  >
      
        <div class="row justify-content-center">
            <div class=" col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <h2 id='titulo_preview'></h2>      
            </div>
        </div>

        <div class="row justify-content-left">
            <div class="icon-label mr-3">                             
                <img src="<?php echo base_url()?>assets/icons/place-24px.svg" class='anuncio-nuevo-preview_icon'/>  
                <label id='estado_ciudad'></label>
            </div>
            <div class="icon-label">
                <img src="<?php echo base_url()?>assets/icons/list-24px.svg" class='anuncio-nuevo-preview_icon'  title="Bootstrap">
                <label id='seccion_apartado'></label>           
            </div>
        </div>

        <div class="row justify-content-center ">
            <div id="carouselExampleIndicators" class="carousel slide " data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner ">
                    <div class="carousel-item active">
                        <img class="" src="https://www.w3schools.com/bootstrap/la.jpg" alt="First slide">
                        </div>
                        <div class="carousel-item">
                        <img class="" src="https://www.w3schools.com/bootstrap/la.jpg" alt="Second slide">
                        </div>
                        <div class="carousel-item">
                        <img class="" src="https://www.w3schools.com/bootstrap/la.jpg" alt="Third slide">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>  
        </div>


        <div class="row justify-content-left mt-3 mb-3">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div id="anuncio_preview">  
                </div>
            </div>
        </div>

        <div class="row justify-content-left">
            <div class="mr-3 icon-label">
                <img src="<?php echo base_url()?>assets/icons/phone-24px.svg" id='anuncio-nuevo-preview_icon--lugar' class='anuncio-nuevo-preview_icon' title="Bootstrap">
                <label id='telefono_preview'></label>   
            </div>

            <div class="mr-3 icon-label">
                <img src="<?php echo base_url()?>assets/icons/stay_current_portrait-24px.svg" id='anuncio-nuevo-preview_icon--lugar' class='anuncio-nuevo-preview_icon' title="Bootstrap">
                <label id='celular_preview'></label>  
            </div>
            
            <div class="mr-3 icon-label">
                <img src="<?php echo base_url()?>assets/icons/email-24px.svg" class='anuncio-nuevo-preview_icon'  title="Bootstrap">
                <label id='correo_preview'></label>     
            </div>
        </div>



    </div>   


    <div class="row justify-content-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-5">
    <a href="<?php echo base_url() . 'index.php/' .'anuncio/nuevo/' . $anuncio_id; ?>" id='boton_editar' class="btn ml-1 mr-1 btn-pulpox-secondary">Editar</a>
    <a id='boton_publicar' class="btn btn-pulpox-primary">Publicar</a>
    </div>
</body>
