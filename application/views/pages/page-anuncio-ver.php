

<body class='container-fluid p-0'>
    <div class="row justify-content-center m-0" >        
            <div class="row justify-content-center div-informacion-anuncio mt-3">
                <div id='' class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6'>
                    <label><b>Información de mi anuncio</b></label><br>
                    <label id='anuncio_id'></label><br>                    
                    <div class='div_opciones'>                          
                        <?php 
                    
                            $public_id_act = "`".$datos_anuncio["public_id"]."`";
                            $estatus_act = "`".$datos_anuncio["estatus"]."`";
                            $url_editar = base_url()."index.php/mianuncio/editar/".$datos_anuncio["public_id"];
                            
                            if($datos_anuncio['estatus']=='ELIMINADO'){
                            }                        
                            if($datos_anuncio['estatus']=='ACTIVO'){
                                echo "<button id='boton_eliminar' class='btn btn-pulpox-danger--line m-1' onclick='eliminarAnuncio()'>Eliminar</button>";
                                echo "<a href='$url_editar' id='boton_editar' class='btn ml-1 mr-1 btn-pulpox-secondary--line'>Editar</a>";
                                echo "<button id='boton_suspender' class='btn btn-pulpox-warning--line m-1' onclick='cambiarEstatusDeAnuncio($public_id_act,$estatus_act)'>Suspender</button>";             
                            }   
                            if($datos_anuncio['estatus']=='SUSPENDIDO'){
                                echo "<button id='boton_eliminar' class='btn btn-pulpox-danger--line m-1' onclick='eliminarAnuncio()'>Eliminar</button>";
                                echo "<button id='boton_editar' class='btn btn-pulpox-secondary--line m-1'>Editar</button>";
                                echo "<button id='boton_activar' class='btn btn-pulpox-success--line m-1' onclick='cambiarEstatusDeAnuncio($public_id_act,$estatus_act)'>Activar</button>";                             
                            }
                            if($datos_anuncio['renovar']==0){
                                echo "<button class='btn btn-pulpox-info' onclick=renovarAnuncio($public_id_act)>Renovar</button>";
                            }else{
                            
                            }
                        ?>   
                    </div> 
                </div>
                <div id='' class='col-5 col-sm-5 col-md-4 col-lg-6 col-xl-6'>
                    <label id='anuncio_id'></label><br>
                    <label id='creado'></label><br>
                    <label id='editado'></label><br>
                    <label id='renovado'></label><br>
                    <div class='div_estatus_actual'>
                        <span id='estatus_actual'></span>
                    </div>               
                </div>
            </div>    
    </div>

    <div class='row justify-content-center m-0 mb-3'>
        <div id='nuevo_anuncio_previo' class='col-10 col-sm-10 col-md-8 col-lg-8 col-xl-5 mt-3'>

            <div class="row justify-content-center" id='nuevo_anuncio_previo--titulo' title='Título del anuncio'>
                <div class="div-titulo col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <h1 id='titulo_preview'></h1>      
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="div-modSecApa col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="icon-label mr-3" title='Modalidad'>                             
                        <img src="<?php echo base_url()?>assets/icons/acuerdo.svg" class='pulpox-icon'/>  
                        <label id='modalidad_preview'></label>
                    </div>
                    <div class="icon-label mr-3" title='Lugar'>                             
                        <img src="<?php echo base_url()?>assets/icons/place-24px.svg" class='pulpox-icon'/>  
                        <label id='estado_ciudad'></label>
                    </div>
                    <div class="icon-label" title='Sección/Apartado'>
                        <img src="<?php echo base_url()?>assets/icons/list-24px.svg" class='pulpox-icon'>
                        <label id='seccion_apartado'></label>           
                    </div>
                </div>
            </div>

            <div class="row justify-content-center pulpox-carousel div-carousel" title='Galería de imágenes'>               
            </div>

            <div class="row justify-content-center"> 
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 " title='Mensaje'>
                    <div class='div-mensaje' id="mensaje_preview">  
                    </div>
                </div>
            </div> 

            <div class="row justify-content-center div-forma-contacto">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="mr-3 icon-label div-contacto" id='div_telefono_preview' title='Teléfono fijo'>
                        <img src="<?php echo base_url()?>assets/icons/phone-24px.svg" id='anuncio-nuevo-preview_icon--lugar' class='pulpox-icon' >
                        <label id='telefono_preview'></label>   
                    </div>

                    <div class="mr-3 icon-label div-contacto" id='div_celular_preview' title='Celular'>
                        <img src="<?php echo base_url()?>assets/icons/stay_current_portrait-24px.svg" id='anuncio-nuevo-preview_icon--lugar' class='pulpox-icon' >
                        <label id='celular_preview'></label>  
                    </div>
                    
                    <div class="mr-3 icon-label div-contacto" id='div_correo_preview' title='Correo'>
                        <img src="<?php echo base_url()?>assets/icons/email-24px.svg" class='pulpox-icon'  >
                        <label id='correo_preview'></label>     
                    </div>
                </div>
            </div>
        </div>   
    </div>    
</body>
