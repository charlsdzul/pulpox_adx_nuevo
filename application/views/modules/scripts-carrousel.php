<script>

function creaCarousel(anuncio_datos){    
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
  }

  function generaCarousel(anuncio_datos){
      /**Genera el carousel de imagenes según los datos almacenados en el sessionStorage */
      let carousel_indicators =$('.carousel-indicators');
      let carousel_indicators_counter = 0
      let carousel_images =$('.carousel-images');
      let base_url = "<?php echo base_url()?>";
      let active = 'active';

      for (let index = 1; index < 11; index++) {
        let url_image = base_url+anuncio_datos[`img_${index}`];    

        if(anuncio_datos[`img_${index}`]!=null && anuncio_datos[`img_${index}`]!=''){              
            carousel_images.append(`
            <div class="carousel-item ${active}">
              <img id='img-${index}-preview' class='carousel-inner--img' src="${url_image}">
            </div>`)
            carousel_indicators.append(`
            <li data-target="#carouselExampleIndicators" data-slide-to="${carousel_indicators_counter}" class="${active}"></li>
            `)          
          carousel_indicators_counter++;
          active='';
        }  
      }
  } 
</script>

