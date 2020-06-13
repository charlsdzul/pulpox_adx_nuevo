
<script> 
  var anuncio_datos = <?php echo json_encode($datos_anuncio,true)?>;

  $(document).ready(function() { 

      asignaValores(anuncio_datos) ;

       //Detecta si existe por lo menos 1 imágen almacenada en el sessionStorage
          for (let index = 1; index < 11; index++) {
            if(anuncio_datos[`img_${index}`]!=null && anuncio_datos[`img_${index}`]!=''){  
              $('.pulpox-carousel').append(`
                <div id="carouselIndicators" class="carousel slide col-10 col-sm-10 col-md-12 col-lg-12 col-xl-12" data-ride="carousel">
                  <ol class="carousel-indicators">                
                  </ol>                
                  <div class="carousel-inner carousel-images">        
                  </div>
                  <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
                          <span class="carousel-control-prev-icon " aria-hidden="true"></span>
                          <span class="sr-only aaa">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                          <span class="sr-only">Next</span>
                  </a>   
                </div>            
              `)

              generaCarousel(anuncio_datos)
              break;
            }    
          }  
  });

  function generaCarousel(anuncio_datos){
    /**Genera el carousel de imagenes según los datos almacenados en el sessionStorage */
    let carousel_indicators =$('.carousel-indicators');
    let carousel_indicators_counter = 0
    let carousel_images =$('.carousel-images');
    let base_url = "<?php echo base_url()?>";

    for (let index = 1; index < 11; index++) {
      let url_image = base_url+anuncio_datos[`img_${index}`];    

      if(anuncio_datos[`img_${index}`]!=null && anuncio_datos[`img_${index}`]!=''){     
        if(index==1){
          carousel_images.append(`
          <div class="carousel-item active">
            <img id='img-${index}-preview' class='carousel-inner--img' src="${url_image}">
          </div>`)
          carousel_indicators.append(`
          <li data-target="#carouselExampleIndicators" data-slide-to="${carousel_indicators_counter}" class="active"></li>
          `)
        }else{
          carousel_images.append(`
          <div class="carousel-item ">
            <img id='img-${index}-preview' class='carousel-inner--img' src="${url_image}">
          </div>`)
          carousel_indicators.append(`
          <li data-target="#carouselExampleIndicators" data-slide-to="${carousel_indicators_counter}"</li>
          `)
        }
        carousel_indicators_counter++;
      }  
    }
  }

  function asignaValores(anuncio_datos){
    /** Recibe valoresque han sido almacenados en sessionStorage en el Anuncio Nuevo.*/

    $('#titulo_preview').text(anuncio_datos['titulo'])
    $('#anuncio_preview').html(anuncio_datos['anuncio'])
    $('#modalidad_preview').html(anuncio_datos['modalidad'])

    let estado_ciudad = anuncio_datos['estado'] + ' / ' + anuncio_datos['ciudad']
    let seccion_apartado =  anuncio_datos['seccion'] + ' / ' + anuncio_datos['apartado']
    $('#estado_ciudad').text(estado_ciudad)
    $('#seccion_apartado').text(seccion_apartado)


    if(anuncio_datos['telefono']!=''){
      $('#telefono_preview').text(anuncio_datos['telefono'])
      $('#div_telefono_preview').css('display', 'inline-block')
    }

    if(anuncio_datos['celular']!=''){
      $('#celular_preview').text(anuncio_datos['celular'])
      $('#div_celular_preview').css('display', 'inline-block')
    }

    if(anuncio_datos['correo']!=''){
      $('#correo_preview').text(anuncio_datos['correo'])
      $('#div_correo_preview').css('display', 'inline-block')
    }

    switch (anuncio_datos['modalidad']) {
        case 'Compro':
        $('#modalidad_mensaje').html('El anunciante está comprando. ¿Puedes ofrecerle algo? ¡Contáctalo!')     
        break;
      
        case 'Busco':
        $('#modalidad_mensaje').html('El anunciante está buscando algo. ¿Puedes ayudarlo? ¡Contáctalo!')     
        break;  

        case 'Dono':
        $('#modalidad_mensaje').html('El anunciante está donando. ¿Lo necesitas? ¡Contáctalo!')     
        break;

        case 'Promuevo':
        $('#modalidad_mensaje').html('El anunciante está promoviendo. ¿Te interesa? ¡Contáctalo!')     
        break;

        case 'Regalo':
        $('#modalidad_mensaje').html('El anunciante está regalando. ¿Lo quieres? ¡Contáctalo!')     
        break;

        case 'Rento':
        $('#modalidad_mensaje').html('El anunciante está rentando ¿Lo necesitas? ¡Contáctalo!')     
        break;

        case 'Traspaso':
        $('#modalidad_mensaje').html('El anunciante está traspasando. ¿Te interesa? ¡Contáctalo!')     
        break;

        case 'Vendo':
        $('#modalidad_mensaje').html('El anunciante está vendiendo. ¿Te interesa? ¡Contáctalo!')     
        break;    
     
    }
  }  

</script>