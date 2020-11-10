<!DOCTYPE html>

<html lang='es'>

    <body >
        
        <main class='container-fluid plpx-p2'>
            <div class='row justify-content-center'>  
                <div class="col-11 col-sm-11 col-md-12 col-lg-12 col-xl-12" style="display: flex; justify-content:space-between">
                    <div>
                        <a>Portal Principal</a>
                    </div>       
                    <div style="display:inline-block">
                            <a><- Anuncio Anterior</a>
                    </div> 
                    <div>
                            <a>Anuncio Siguiente -></a>
                    </div> 
                </div>  
            </div>  

            <div class='row justify-content-center'>  

                <section class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-9" style="background-color:rosybrown;">

                    <div class='row justify-content-center'> 
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="background-color:red;">
                            <h1><?php echo $datos_anuncio["titulo"]; ?></h1>
                        </div>                         
                    </div> 

                    <div class='row justify-content-center'> 
                        <div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-9" style="background-color:pink;">
                        <h5><?php echo $datos_anuncio["modalidad"]."/".$datos_anuncio["estado"]."/".$datos_anuncio["ciudad"]."/".$datos_anuncio["seccion"]."/".$datos_anuncio["apartado"]; ?></h5>
                        </div> 
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3" style="background-color:orange;">
                            <span>Reportar este anuncio</span>
                        </div> 
                    </div> 

                    <div class='row justify-content-center'> 
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="background-color:gray;">
                            IMAGENES
                        </div> 
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="background-color:orange;">
                        <p><?php echo $datos_anuncio["mensaje"]; ?></p>
                        </div> 
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="background-color:GREEN;">
                            DATOS DE CONTACTO
                        </div> 
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 plpx-flexbox-spacebetween">
                            <div>
                                <span>Creado: <?php echo $datos_anuncio["creado"]; ?> </span> 
                            </div>    
                            <div>
                                <span>ID: <?php echo $datos_anuncio["anuncio_id"]; ?></span> 
                            </div>                            
                        </div> 
                    </div> 

                </section> 

                <aside class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3" style="background-color:gray;">
                    ANUNCIOS    
                </aside> 

            </div>
        </main>  
    </body>

</html>