<script>  
  $(document).ready(function() {  
    let anuncio_id = "<?php echo $anuncio_id?>"; 
      if(sessionStorage.getItem(`titulo_${anuncio_id}`)==null){
        location.href = BASE_URL+'mianuncio/nuevo';
      }else{    
        asignaValoresPreview(anuncio_id)    
        creaCarousel(anuncio_id)          
        $('#boton_publicar').click(function(){
          guardaAnuncio(anuncio_id)
        })
      }     
  });

  function guardaAnuncio(anuncio_id){
    /**
      Guarda el anuncio.
    */   

      let dialog_publicando = $.dialog({
          icon: 'fa fa-spinner fa-spin',
          title: '<span class="titulo-confirm">Publicando...</span>',
          type: 'blue',
          content: "<div class='contenido-confirm'>Estamos publicando tu anuncio...</div>",
          closeIcon:false,
      });       

      var nuevo_anuncio={
      'titulo':sessionStorage.getItem(`titulo_${anuncio_id}`),
      'mensaje':sessionStorage.getItem(`mensaje_${anuncio_id}`),
      'estado':sessionStorage.getItem(`estado_${anuncio_id}`),
      'ciudad':sessionStorage.getItem(`ciudad_${anuncio_id}`),
      'modalidad':sessionStorage.getItem(`modalidad_${anuncio_id}`),
      'seccion':sessionStorage.getItem(`seccion_${anuncio_id}`),
      'apartado':sessionStorage.getItem(`apartado_${anuncio_id}`),
      'telefono':sessionStorage.getItem(`telefono_${anuncio_id}`),
      'celular':sessionStorage.getItem(`celular_${anuncio_id}`),
      'correo':sessionStorage.getItem(`correo_${anuncio_id}`),
      'id_temporal':anuncio_id,
      } 

    for (let index = 1; index < 11; index++) {
      if(sessionStorage.getItem(`img_${index}_${anuncio_id}`)==null){
        nuevo_anuncio[`img_${index}`] = '';
      }
      nuevo_anuncio[`img_${index}`] = sessionStorage.getItem(`img_${index}_${anuncio_id}`);      
    }

      $.post(BASE_URL+'/mianuncio/publicar/',  {nuevo_anuncio})   
        .done(function(response) { 
            dialog_publicando.close();        
            response = JSON.parse(response);
              if(response.codigo!=0){
                $.confirm({
                  icon: 'fas fa-exclamation-circle',
                  title: '<span class="titulo-confirm">Detectamos un problema.</span>',
                  content: ` <div class='contenido-confirm'>${response.mensaje}<div>`,
                  type: 'blue',
                  typeAnimated: true,
                  buttons: {               
                    ok: {
                      text: 'Ok',
                      btnClass: 'btn-pulpox-secondary',
                      keys: ['enter']                     
                    },  
                  }
                });
              }else{
                sessionStorage.clear();
                $.confirm({
                icon: 'fas fa-check-circle',
                title: '<span class="titulo-confirm">Publicado</span>',
                type: 'blue',
                content: `<div class='contenido-confirm'>${response.mensaje}<div>`,
                closeIcon:false,
                buttons: {
                  nuevoAnuncio: {
                      text: 'Nuevo Anuncio',
                      btnClass: 'btn-pulpox-secondary--line',
                      keys: ['enter'],
                      action: function(){
                        location.href = BASE_URL+'mianuncio/nuevo'; 
                      }
                  },
                  misAnuncios: {
                      text: 'Mis Anuncios',
                      btnClass: 'btn-pulpox-secondary',                    
                      action: function(){
                        location.href = BASE_URL+'misanuncios/'; 
                      }
                  }
                }
                });        
              }        
        })
        .fail(function() {
          dialog_publicando.close();   
          $.confirm({
            icon: 'fas fa-exclamation-circle',
            title: response_fail.titulo,
            content: response_fail.mensaje,
            type: 'red',
            typeAnimated: true,
            buttons: {               
              ok: {
                text: 'Ok',
                btnClass: 'btn-pulpox-secondary',
                keys: ['enter']                     
              },
            }
          })
        }) 
  }

  function generaCarousel(anuncio_id){
    /**Genera el carousel de imagenes según los datos almacenados en el sessionStorage */
    let carousel_indicators =$('.carousel-indicators');
    let carousel_indicators_counter = 0
    let carousel_images =$('.carousel-images');
    let active = 'active';

    for (let index = 1; index < 11; index++) {

      if(sessionStorage.getItem(`img_${index}_${anuncio_id}`)!=null && sessionStorage.getItem(`img_${index}_${anuncio_id}`)!=''){       
          carousel_images.append(`
          <div class="carousel-item ${active}">
            <img id='img-${index}-preview' class='carousel-inner--img' src="${sessionStorage.getItem(`img_${index}_${anuncio_id}`)}">
          </div>`)
          carousel_indicators.append(`
          <li data-target="#carouselExampleIndicators" data-slide-to="${carousel_indicators_counter}" class="${active}"></li>
          `);
        carousel_indicators_counter++;
        active='';
      }        
    }
  }

  function creaCarousel(anuncio_id){
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
              `);
              generaCarousel(anuncio_id)
              break;
            }    
          }
  }

  function asignaValoresPreview(anuncio_id){
    /** Recibe valoresque han sido almacenados en sessionStorage en el Anuncio Nuevo.*/

    $('#titulo_preview').text(sessionStorage.getItem(`titulo_${anuncio_id}`))
    $('#modalidad_preview').html(sessionStorage.getItem(`modalidad_${anuncio_id}`))
    let estado_ciudad = sessionStorage.getItem(`estado_${anuncio_id}`) + ' / ' + sessionStorage.getItem(`ciudad_${anuncio_id}`)
    let seccion_apartado =  sessionStorage.getItem(`seccion_${anuncio_id}`) + ' / ' + sessionStorage.getItem(`apartado_${anuncio_id}`)
    $('#estado_ciudad').text(estado_ciudad)
    $('#seccion_apartado').text(seccion_apartado)

    $('#mensaje_preview').html(sessionStorage.getItem(`mensaje_${anuncio_id}`))

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

    switch (sessionStorage.getItem(`modalidad_${anuncio_id}`)) {
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

