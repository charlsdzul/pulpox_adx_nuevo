<script>

  var anuncio_id = <?php echo $anuncio_id?>; //Variable pasada a al view

  $(document).ready(function() {   

      if(sessionStorage.getItem(`titulo_${anuncio_id}`)==null){
        location.href = "<?php echo base_url() . 'index.php/anuncio/nuevo'; ?>" 
      }else{
        asignaValoresPreview(anuncio_id)
        
          //Detecta si existe por lo menos 1 imágen almacenada en el sessionStorage
          for (let index = 1; index < 11; index++) {
            if(sessionStorage.getItem(`img_${index}_${anuncio_id}`)!=null && sessionStorage.getItem(`img_${index}_${anuncio_id}`)!=''){  
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

              generaCarousel(anuncio_id)
              break;
            }    
          }

          $('#boton_publicar').click(function(){
            guardaAnuncio(anuncio_id)
          })
      }     
  });

</script>

<script>

  function guardaAnuncio(anuncio_id){
    /**
      Guarda el anuncio.
    */   

      let dialog_publicando = $.dialog({
          icon: 'fa fa-spinner fa-spin',
          title: 'Publicando...',
          type: 'green',
          content: 'Estamos publicando tu anuncio!',
          closeIcon:false,
      });       

      var nuevo_anuncio={}
      nuevo_anuncio['titulo'] = sessionStorage.getItem(`titulo_${anuncio_id}`)
      nuevo_anuncio['anuncio']  = sessionStorage.getItem(`anuncio_${anuncio_id}`)
      nuevo_anuncio['estado'] = sessionStorage.getItem(`estado_${anuncio_id}`)
      nuevo_anuncio['ciudad'] = sessionStorage.getItem(`ciudad_${anuncio_id}`)
      nuevo_anuncio['seccion']  = sessionStorage.getItem(`seccion_${anuncio_id}`)
      nuevo_anuncio['apartado']  = sessionStorage.getItem(`apartado_${anuncio_id}`)
      nuevo_anuncio['telefono']  = sessionStorage.getItem(`telefono_${anuncio_id}`)
      nuevo_anuncio['celular']  = sessionStorage.getItem(`celular_${anuncio_id}`)
      nuevo_anuncio['correo'] = sessionStorage.getItem(`correo_${anuncio_id}`)
      nuevo_anuncio['id_temporal'] = anuncio_id

    for (let index = 1; index < 11; index++) {

      if(sessionStorage.getItem(`img_${index}_${anuncio_id}`)==null){
        nuevo_anuncio[`img_${index}`] = '';
      }
      nuevo_anuncio[`img_${index}`] = sessionStorage.getItem(`img_${index}_${anuncio_id}`);
      
    }


      $.post("<?php echo base_url().'index.php/anuncio/publicar/'?>",  nuevo_anuncio)   
        .done(function(response) { 
            dialog_publicando.close();        
            response = JSON.parse(response);
              if(response.codigo!=0){
                $.confirm({
                title: 'Detectamos un problema.',
                content: response.mensaje,
                type: 'orange',
                typeAnimated: true,
                buttons: {               
                    close: function () {
                    }                }
                });
              }else{
                sessionStorage.clear();
                $.confirm({
                icon: 'fas fa-check-circle',
                title: 'Publicado',
                type: 'green',
                content: 'Tú anuncio ya se publicó. ¿A dónde quieres ir?',
                closeIcon:false,
                buttons: {
                  nuevoAnuncio: {
                      text: 'Nuevo Anuncio',
                      btnClass: 'btn-pulpox-primary',
                      keys: ['enter', 'shift'],
                      action: function(){
                        location.href = "<?php echo base_url() . 'index.php/anuncio/nuevo'; ?>" 
                      }
                  },
                  misAnuncios: {
                      text: 'mis Anuncios',
                      btnClass: 'btn-pulpox-primary',
                      keys: ['enter', 'shift'],
                      action: function(){
                        location.href = "<?php echo base_url() . 'index.php/misanuncios'; ?>" 
                      }
                  }
                }
                });        
              }        
        })
        .fail(function() {
          $.confirm({
            title: 'Detectamos un problema.',
            content: 'Nuestro servidor tiene problemas actualmente. Intente más tarde.',
            type: 'red',
            typeAnimated: true,
            buttons: {               
                close: function () {
                }
            }
          });

        })    
     
  }

  function generaCarousel(anuncio_id){
    /**Genera el carousel de imagenes según los datos almacenados en el sessionStorage */
    let carousel_indicators =$('.carousel-indicators');
    let carousel_indicators_counter = 0
    let carousel_images =$('.carousel-images');

    for (let index = 1; index < 11; index++) {

      if(sessionStorage.getItem(`img_${index}_${anuncio_id}`)!=null && sessionStorage.getItem(`img_${index}_${anuncio_id}`)!=''){   
        if(index==1){
          carousel_images.append(`
          <div class="carousel-item active">
            <img id='img-${index}-preview' class='carousel-inner--img' src="${sessionStorage.getItem(`img_${index}_${anuncio_id}`)}">
          </div>`)
          carousel_indicators.append(`
          <li data-target="#carouselExampleIndicators" data-slide-to="${carousel_indicators_counter}" class="active"></li>
          `)
        }else{
          carousel_images.append(`
          <div class="carousel-item ">
            <img id='img-${index}-preview' class='carousel-inner--img' src="${sessionStorage.getItem(`img_${index}_${anuncio_id}`)}">
          </div>`)
          carousel_indicators.append(`
          <li data-target="#carouselExampleIndicators" data-slide-to="${carousel_indicators_counter}"</li>
          `)
        }
        carousel_indicators_counter++;
      }  
    }
  }

  function asignaValoresPreview(anuncio_id){
    /** Recibe valoresque han sido almacenados en sessionStorage en el Anuncio Nuevo.*/

    $('#titulo_preview').text(sessionStorage.getItem(`titulo_${anuncio_id}`))
    $('#anuncio_preview').html(sessionStorage.getItem(`anuncio_${anuncio_id}`))

    let estado_ciudad = sessionStorage.getItem(`estado_text_${anuncio_id}`) + ' / ' + sessionStorage.getItem(`ciudad_text_${anuncio_id}`)
    let seccion_apartado =  sessionStorage.getItem(`seccion_text_${anuncio_id}`) + ' / ' + sessionStorage.getItem(`apartado_text_${anuncio_id}`)
    $('#estado_ciudad').text(estado_ciudad)
    $('#seccion_apartado').text(seccion_apartado)


    if(sessionStorage.getItem(`telefono_${anuncio_id}`)!=''){
      $('#telefono_preview').text(sessionStorage.getItem(`telefono_${anuncio_id}`))
      $('#div_telefono_preview').css('display', 'inline-block')
    }

    if(sessionStorage.getItem(`celular_${anuncio_id}`)!=''){
      $('#celular_preview').text(sessionStorage.getItem(`celular_${anuncio_id}`))
      $('#div_celular_preview').css('display', 'inline-block')
    }

    if(sessionStorage.getItem(`correo_${anuncio_id}`)!=''){
      $('#correo_preview').text(sessionStorage.getItem(`correo_${anuncio_id}`))
      $('#div_correo_preview').css('display', 'inline-block')
    }
  }  

</script>