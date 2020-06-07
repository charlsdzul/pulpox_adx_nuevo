<script> 

  const BASE_URL = "<?php echo base_url();?>" + "index.php/";

  $(document).ready(function () {

    let mis_anuncios = <?php echo json_encode($misanuncios); ?>;
    let data;

      for (let index = 0; index < mis_anuncios.length; index++) { 

          if(mis_anuncios[index].estatus=='ACTIVO'){
            back_color ='';
          }
          if(mis_anuncios[index].estatus=='SUSPENDIDO'){
            back_color = '#ffbb33';
          }
          if(mis_anuncios[index].estatus=='ELIMINADO'){
            back_color = 'rgb(245, 132, 132)';
          }       

        data += `
          <tr style='background-color:${back_color}' id=${mis_anuncios[index].public_id}> 
            <td class='d-none d-lg-table-cell' >${index+1}</td>                      
            <td>${mis_anuncios[index].titulo}</td>
            <td class='text-center' title='Ver anuncio' id='pulpox-icon--ver' onclick='verAnuncio("${mis_anuncios[index].titulo}","${mis_anuncios[index].public_id}","${mis_anuncios[index].modalidad}","${mis_anuncios[index].estado}" ,"${mis_anuncios[index].ciudad}","${mis_anuncios[index].seccion}","${mis_anuncios[index].apartado}","${mis_anuncios[index].creado}","${mis_anuncios[index].estatus}")'><i class="fas fa-eye"></i></td>                 
            <td class='d-none d-lg-table-cell'>${mis_anuncios[index].modalidad} </td>
            <td class='d-none d-lg-table-cell'>${mis_anuncios[index].estado} / ${mis_anuncios[index].ciudad}</td>
            <td class='d-none d-lg-table-cell'>${mis_anuncios[index].seccion} / ${mis_anuncios[index].apartado}</td>
            <td class='d-none d-lg-table-cell'>${mis_anuncios[index].public_id}</td>
            <td class='d-none d-lg-table-cell'>${mis_anuncios[index].creado}</td>
            <td class=''>${mis_anuncios[index].estatus}</td>     
          </tr>`;    
      }  

    $('.pulpox-table-tbody').append(data); 
    $('#mis-anuncios-table').DataTable();
    $('.dataTables_length').addClass('bs-select');



  });

  var usuario_elimino_imagen = false;

  function verAnuncio(titulo,id,modalidad,estado,ciudad,seccion,apartado,creado,estatus){

    if(window.innerWidth< 960){
      mostrarDatosMovil(titulo,id,modalidad,estado,ciudad,seccion,apartado,creado,estatus)
    }else{
      window.open(BASE_URL+'misanuncios/ver/'+id, '_blank');
    }

  }

  function mostrarDatosMovil(titulo,id,modalidad,estado,ciudad,seccion,apartado,creado,estatus){
    usuario_elimino_imagen = false;
    $.confirm({
        icon: 'fas fa-info-circle',
        title: 'Información de mi anuncio',
        type: 'blue',
        columnClass: 'large',
        backgroundDismiss: true,
        content: `
          <b>Título:</b>  ${titulo} <br>
          <b>Modalidad:</b>  ${modalidad}<br>
          <b>Lugar:</b>  ${estado} / ${ciudad}<br>
          <b>Sección:</b>  ${seccion} / ${apartado}<br>
          <b>ID:</b> ${id}<br>
          <b>Creado:</b> ${creado}<br>
          <b>Estatus:</b> ${estatus}
        `,
        closeIcon:true,
        onContentReady:function(){
            this.buttons.suspenderEstatus.addClass("btn-pulpox-secondary--line")
            this.buttons.activarEstatus.addClass('btn-pulpox-secondary--line')
            this.buttons.eliminarAnuncio.addClass('btn-pulpox-secondary--line')
            this.buttons.editarAnuncio.addClass('btn-pulpox-secondary--line')
            this.buttons.verAnuncioMobil.addClass('btn-pulpox-secondary--line') 
          if(estatus=='ACTIVO'){
            this.buttons.suspenderEstatus.show()
            this.buttons.activarEstatus.hide()
            this.buttons.eliminarAnuncio.show()
            this.buttons.editarAnuncio.show()
          }
          if(estatus=='SUSPENDIDO'){
            this.buttons.activarEstatus.show()
            this.buttons.suspenderEstatus.hide()
            this.buttons.eliminarAnuncio.show()
            this.buttons.editarAnuncio.show()
          }
          if(estatus=='ELIMINADO'){
            this.buttons.activarEstatus.hide()
            this.buttons.suspenderEstatus.hide()
            this.buttons.eliminarAnuncio.hide()
            this.buttons.editarAnuncio.hide()
          }
        },
        buttons: {     
          eliminarAnuncio:{
            text: 'Eliminar',
            isHidden: true,
            action:function(){
              eliminarAnuncio(id);
            },
          },            
          activarEstatus:{
            text: 'Activar',
            isHidden: true,
            action:function(){
              cambiarEstatusDeAnuncio(id,estatus);
            },
          },     
          suspenderEstatus:{
            text: 'Suspender',
            isHidden: true,
            action:function(){
              cambiarEstatusDeAnuncio(id,estatus);
            },
          },              
          editarAnuncio: {
            text: 'Editar',
            isHidden: true,
            action: function(){
              editarAnuncioMovil(titulo,id,modalidad,estado,ciudad,seccion,apartado,creado,estatus);
            }
          },
          verAnuncioMobil: {
            text: 'Ver',
            action: function(){
              verAnuncioMovil(id)
            }
          },
        }
    });    
  }

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
      $('#anuncio_preview').html(anuncio_datos['mensaje'])
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

  function cambiarEstatusDeAnuncio(id,estatus){
    let estatus_actual = estatus
    let estatus_boton = ''
    if(estatus== 'ACTIVO' ){
      estatus_boton = 'Sí, quiero suspenderlo.'
    }
    if(estatus== 'SUSPENDIDO' ){
      estatus_boton =  'Sí, quiero activarlo.'
    }           
      $.confirm({
        icon: 'fas fa-info-circle',
        title: 'Cambiar Estatus del Anuncio',
        type: 'blue',
        columnClass: 'medium',
        backgroundDismiss: true,
        content: `
          El <b>estatus actual del anuncio es ${estatus} ¿Realmente desea cambiarlo?</b><br><br>Recuerde: 
          <label><b>ACTIVO:</b> El anuncio es visible para todo el mundo. Puedes Suspenderlo después.</label>  
          <label><b>SUSPENDIDO:</b> El anuncio nadie lo verá. Puedes Activarlo después.</label>          
        `,
        closeIcon:true,
        buttons: {
          cerrar: {
            text: 'Cancelar',
              btnClass: 'btn-pulpox-secondary--line',
              keys: ['escape'],           
          },
          cambiarEstatus:{
            text: estatus_boton,
            btnClass: 'btn-pulpox-secondary',
            keys: ['enter'],
            action:function(){    
              let dialog_cambiando_estatus = $.dialog({
                    icon: 'fa fa-spinner fa-spin',
                    title: 'Cambiar Estatus del Anuncio',
                    type: 'green',
                    content: 'Estamos cambiando el estatus de tu anuncio...',
                    closeIcon:false,
              });   
              $.post(BASE_URL+'misanuncios/cambiarEstatus/', {id,estatus_actual})
                .done(function(response){
                  dialog_cambiando_estatus.close(); 
                  var data = JSON.parse(response)  
                  if(data.codigo == 0){
                    $.confirm({
                      icon: 'fas fa-smile-wink',
                      title: 'Cambiar Estatus del Anuncio',
                      type: 'green',
                      columnClass: 'medium',
                      content: data.mensaje,
                      closeIcon:true,
                      buttons: {
                        ok: {
                          text: 'Ok',
                            btnClass: 'btn-pulpox-secondary--line',
                            keys: ['enter'],
                            action: function(){
                              window.location.replace(BASE_URL+'misanuncios/');
                            }
                        },                  
                      }
                  }); 

                  }else{
                    $.confirm({
                      icon: 'fas fa-sad-tear',
                      title: 'Cambiar Estatus del Anuncio',
                      type: 'red',
                      columnClass: 'medium',
                      content: data.mensaje,
                      closeIcon:true,
                      buttons: {
                        ok: {
                          text: 'Ok',
                            btnClass: 'btn-pulpox-secondary--line',
                            keys: ['enter'],              
                        },                  
                      }
                    }); 
                  }
                })     
                .fail(function() {
                  dialog_cambiando_estatus.close();   
                  $.confirm({
                    title: 'Detectamos un problema.',
                    content: 'Nuestro servidor tiene problemas actualmente. Intente más tarde.',
                    type: 'red',
                    typeAnimated: true,
                    backgroundDismiss: true, 
                    buttons: {
                    cerrarVerAnuncio: {
                      text: 'Cerrar',
                      btnClass: 'btn-pulpox-secondary',
                      keys: ['escape'],        
                    },                 
                  }
                  });
                })  
            },
          },              
        }
      });
  }

  function eliminarAnuncio(id){    
      $.confirm({
        icon: 'fas fa-info-circle',
        title: 'Eliminar Anuncio',
        type: 'blue',
        columnClass: 'medium',
        backgroundDismiss: true,
        content: `
          <b>¿Realmente desea eliminarlo?</b><br><br>Recuerde: 
          <label>El anuncio se eliminará y nadie podrá verlo, aunque tú podrás verlo en 'Mis Anuncios'.</label>                        
        `,
        closeIcon:true,
        buttons: {
          cerrar: {
            text: 'Cancelar',
              btnClass: 'btn-pulpox-secondary--line',                 
              action: function(){
              }
          },
          eliminarAnuncio:{
            text: `Sí, eliminar este anuncio`,
            btnClass: 'btn-pulpox-secondary',
            action:function(){
              let dialog_eliminando = $.dialog({
                  icon: 'fa fa-spinner fa-spin',
                  title: 'Eliminar Anuncio',
                  type: 'green',
                  content: 'Estamos eliminando tu anuncio...',
                  closeIcon:false,
              }); 
              $.post(BASE_URL+'misanuncios/eliminarAnuncio/', {id})
              .done(function(response){
                var data = JSON.parse(response) 
                dialog_eliminando.close();               
                if(data.codigo == 0){
                  $.confirm({
                    icon: 'fas fa-smile-wink',
                    title: 'Eliminar Anuncio',
                    type: 'green',
                    columnClass: 'medium',
                    content: data.mensaje,
                    closeIcon:true,
                    buttons: {
                      ok: {
                        text: 'Ok',
                          btnClass: 'btn-pulpox-secondary--line',                           
                          action: function(){
                            window.location.replace(BASE_URL+'misanuncios/');
                          }
                      },                  
                    }
                });  
                }else{
                  $.confirm({
                    icon: 'fas fa-sad-tear',
                    title: 'Eliminar Anuncio',
                    type: 'red',
                    columnClass: 'medium',
                    content: data.mensaje,
                    closeIcon:true,
                    buttons: {
                      ok: {
                        text: 'Ok',
                          btnClass: 'btn-pulpox-secondary--line',
                          keys: ['escape', 'shift'],
                          action: function(){
                          }
                      },                  
                    }
                  });  
                }               
              }) 
              .fail(function() {
                dialog_eliminando.close();   
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
            },
          },             
        }
      });
  }

  function editarAnuncioMovil(titulo,id,modalidad,estado,ciudad,seccion,apartado,creado,estatus){ 
    $.confirm({
      icon: 'fas fa-edit',
      title: 'Editar anuncio',
      columnClass: 'medium',
      type: 'blue', 
      modal: true,
      closeIcon:false,                                
      content: function(){   
          var self = this;
          $.post(BASE_URL+'misanuncios/obtenerDatosParaEdicionMovil/', {id})
          .done(function(response){
            var data = JSON.parse(response)
            self.setContent(`         
                    <div class="row justify-content-center">
                      <div class="form-group col-11 col-sm-11>
                        <label for="titulo">Título</label>
                        <input type="text" id='titulo' class="form-control pulpox-validar" maxlength="50" value='${titulo}' >
                        <div class="pulpox-invalid-feedback">Elije un título</div>
                      </div>
                    </div>
                    <div class="row justify-content-center">
                      <div class="form-group col-11 col-sm-11">
                        <label for="mensaje">Anuncio</label>
                        <textarea id='mensaje' class="form-control pulpox-validar" aria-label="With textarea" rows="10" maxlength="1000">${data.anuncio}</textarea>
                        <div class="pulpox-invalid-feedback">Escribe tu mensaje</div>
                      </div>
                    </div>
                    <div class="row justify-content-center">
                      <div class="form-group col-11 col-sm-11">
                        <label for="estado">Estado*</label>
                        <select id="estado" class="form-control pulpox-validar-select"></select>   
                        <div class="pulpox-invalid-feedback">Elije un Estado</div>
                      </div>
                      <div class="form-group col-11 col-sm-11">
                        <label for="ciudad">Ciudad</label>
                        <select id="ciudad" class="form-control pulpox-validar-select"></select>  
                        <div class="pulpox-invalid-feedback">Elije una ciudad</div>
                      </div>
                    </div>                                              
                    <div class="row justify-content-center">
                      <div class="form-group col-11 col-sm-11">
                        <label for="modalidad">Modalidad</label>
                        <select id="modalidad" class="form-control pulpox-validar-select"></select>  
                        <div class="pulpox-invalid-feedback">Elije una modalidad</div>
                      </div>
                      <div class="form-group col-11 col-sm-11">
                        <label for="seccion">Sección</label>
                        <select id="seccion" class="form-control pulpox-validar-select" ></select>  
                        <div class="pulpox-invalid-feedback">Elije una sección</div>
                      </div>  
                      <div class="form-group col-11 col-sm-11">
                        <label for="apartado">Apartado</label>
                        <select id="apartado" class="form-control pulpox-validar-select" ></select>  
                        <div class="pulpox-invalid-feedback">Elije un apartado</div>
                      </div>
                    </div>
                    <div class="row justify-content-center">
                      <div class="form-group col-11 col-sm-11">
                        <label for="telefono">Tel (opcional)</label>
                        <input id='telefono' type="text" class="form-control" maxlength="10" value='${data.telefono}'>
                        <div class="pulpox-invalid-feedback">Deben ser 10 dígitos.</div>
                        <small  class="form-text text-muted">Ej. 6561234567</small>                
                      </div>
                      <div class="form-group col-11 col-sm-11">
                        <label for="celular">Cel (opcional)</label>
                        <input id="celular" type="text" class="form-control" maxlength="10" value='${data.celular}'>
                        <div class="pulpox-invalid-feedback">Deben ser 10 dígitos.</div>
                        <small class="form-text text-muted">Ej. 6561234567</small>
                      </div>
                      <div class="form-group col-11 col-sm-11">
                        <label for="correo">Correo (opcional)</label>
                        <input id="correo" type="email" class="form-control"  value='${data.correo}'>
                        <div class="pulpox-invalid-feedback">Correo inválido</div>
                      </div>                                            
                    </div>
                    <div class="row justify-content-center panel-upload-images">
                        <div id='panel-image-progress-1' class='panel-image-progress mb-4'> 
                          <div id='panel-image-1' class='panel-image'>
                            <img id='img-1' class='imagen_preview' src=""/>
                            <div id='panel-image--div_icon-1' class='panel-image--div_icon'> 
                              <label for="input-image-1">
                                <i id='icon-1' class="fa fa-camera fa-3x panel-image--icon" aria-hidden="true" ></i>  
                              </label>
                            </div>
                                                  
                            <input id='input-image-1' type="file" style='display:none;' onchange='uploadImage(this)'data-numero-imagen='1'>
                          </div>  
                          <div id='pulpox-message-principal-1' class="pulpox-message--principal">
                            <span>Principal</span>
                          </div>  
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
                            <input id='input-image-2' type="file" style='display:none;' onchange='uploadImage(this)'data-numero-imagen='2'>
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
                                                  
                                <input id='input-image-3' type="file" style='display:none;' onchange='uploadImage(this)'data-numero-imagen='3'>
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
                                                  
                                <input id='input-image-4' type="file" style='display:none;' onchange='uploadImage(this)'data-numero-imagen='4'>
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
                                                  
                                <input id='input-image-5' type="file" style='display:none;' onchange='uploadImage(this)'data-numero-imagen='5'>
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
                                                  
                                <input id='input-image-6' type="file" style='display:none;' onchange='uploadImage(this)'data-numero-imagen='6'>
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
                                                  
                                <input id='input-image-7' type="file" style='display:none;' onchange='uploadImage(this)'data-numero-imagen='7'>
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
                                                  
                                <input id='input-image-8' type="file" style='display:none;' onchange='uploadImage(this)'data-numero-imagen='8'>
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
                                                  
                                <input id='input-image-9' type="file" style='display:none;' onchange='uploadImage(this)'data-numero-imagen='9'>
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
                                                  
                                <input id='input-image-10' type="file" style='display:none;' onchange='uploadImage(this)'data-numero-imagen='10'>
                            </div>  
                            <div id="pulpox-invalid-feedback-10" class="pulpox-invalid-feedback">
                            </div>                        
                        </div> 
                    </div>           
            `)
            asignaListasSelects(modalidad,estado,ciudad,seccion,apartado)
            asignarImagenes(id,data)  
          })
      },                             
      buttons: {
        cancelarEdicion: {
          text: 'Cancelar',
          btnClass: 'btn-pulpox-secondary--line',
          keys: ['escape'],        
        },
        guardarEdicion: {
          text: 'Guardar',
          id:'editar_boton_guardar',
          btnClass: 'btn-pulpox-secondary guardarEdicion',
          keys: ['enter'],                                                
          action: function(){
            let titulo_nuevo = $('#titulo').val()
            let mensaje_nuevo = $('#mensaje').val()
            let estado_nuevo = $('#estado').val()
            let ciudad_nuevo = $('#ciudad').val()
            let modalidad_nuevo = $('#modalidad').val()
            let seccion_nuevo = $('#seccion').val()
            let apartado_nuevo = $('#apartado').val()
            let telefono_nuevo = $('#telefono').val()
            let celular_nuevo = $('#celular').val()
            let correo_nuevo = $('#correo').val()

            let anuncio_editado = {
            'anuncio_public_id':id,
            'titulo': titulo_nuevo, 
            'mensaje': mensaje_nuevo, 
            'estado': estado_nuevo, 
            'ciudad': ciudad_nuevo, 
            'modalidad': modalidad_nuevo, 
            'seccion': seccion_nuevo, 
            'apartado': apartado_nuevo, 
            'telefono': telefono_nuevo, 
            'celular': celular_nuevo, 
            'correo': correo_nuevo, 
            }
            define
            $.post(BASE_URL+'mianuncio/editar/', {anuncio_editado})
              .done(function(response){
                var response = JSON.parse(response)
                if(response.codigo==0){               
                  $.confirm({
                  icon: 'fas fa-smile-wink',
                  title: 'Confirmación',
                  type: 'green',
                  content: response.mensaje,
                  closeIcon:false,
                  buttons: {
                    OK: {
                        text: 'Ok',
                        btnClass: 'btn-pulpox-secondary',
                        keys: ['enter'],
                        action: function(){
                          window.location.replace(BASE_URL+'misanuncios/');                        
                        }
                    },                                      
                  }
                });
                }else{
                  $.confirm({
                    icon: 'fas fa-sad-tear',
                    title: 'Confirmación',
                    type: 'red',
                    content: response.mensaje,
                    closeIcon:false,
                    buttons: {
                      OK: {
                          text: 'Ok',
                          btnClass: 'btn-pulpox-secondary',
                          keys: ['enter'],       
                          action: function(){
                          $(`#${response.objeto}`).focus();                   
                        }
                                  
                      },                                      
                    }
                  });
                }
              })
              .fail(function(){
                $.confirm({
                    icon: 'fas fa-sad-tear',
                    title: 'Confirmación',
                    type: 'red',
                    content: response.mensaje,
                    closeIcon:false,
                    buttons: {
                      OK: {
                          text: 'Ok',
                          btnClass: 'btn-pulpox-secondary',
                          keys: ['enter'],                   
                      },                                      
                    }
                });
              })

            if (usuario_elimino_imagen == false){
              console.log('No ha eliminado fotos')
            }
            if (usuario_elimino_imagen == true){
              console.log('Ya eliminó fotos')           
            }

            return false;
          }
        }
      }
    });                   
  }

  function verAnuncioMovil(id){   
    $.confirm({
      icon: 'fas fa-eye',
      title: 'Ver anuncio',
      type: 'blue', 
      columnClass: 'medium',
      closeIcon:false,    
      backgroundDismiss: true,                                    
      content: function(){   
        var self = this;
        $.post(BASE_URL+'misanuncios/obtenerDatosAnuncioMovil/', {id})
          .done(function(response){
            var data = JSON.parse(response)
            self.setContent(`  
              <div class='container-fluid p-0 mb-1'>
                <div class='row justify-content-center m-0'>    
                  <div id='nuevo_anuncio_previo' class='col-11 col-sm-11'>
                    <div class="row justify-content-center">
                      <div class="col-11 col-sm-11">
                        <h2 id='titulo_preview'></h2>      
                      </div>
                    </div>
                    <div class="row justify-content-center">
                      <div class="col-11 col-sm-11">
                          <div class="icon-label mr-3" title='Modalidad'>                             
                              <img src="<?php echo base_url()?>assets/icons/handshake.png" class='anuncio-nuevo-preview_icon'/>  
                              <label id='modalidad_preview'></label>
                          </div>
                          <div class="icon-label mr-3">                             
                              <img src="<?php echo base_url()?>assets/icons/place-24px.svg" class='anuncio-nuevo-preview_icon'/>  
                              <label id='estado_ciudad'></label>
                          </div>
                          <div class="icon-label">
                              <img src="<?php echo base_url()?>assets/icons/list-24px.svg" class='anuncio-nuevo-preview_icon'  title="Bootstrap">
                              <label id='seccion_apartado'></label>           
                          </div>
                      </div>
                    </div>
                    <div class="row justify-content-center pulpox-carousel">               
                    </div>          
                    <div class="row justify-content-center mt-2">
                      <div class="col-11 col-sm-11" title='Mensaje'>
                          <div id="anuncio_preview">  
                          </div>
                      </div>
                    </div> 
                    <div class="row justify-content-center">
                      <div class="col-11 col-sm-11">
                        <div class="mr-3 icon-label" id='div_telefono_preview'>
                          <img src="<?php echo base_url()?>assets/icons/phone-24px.svg" id='anuncio-nuevo-preview_icon--lugar' class='anuncio-nuevo-preview_icon' title="Bootstrap">
                          <label id='telefono_preview'></label>   
                        </div>
                        <div class="mr-3 icon-label" id='div_celular_preview'>
                          <img src="<?php echo base_url()?>assets/icons/stay_current_portrait-24px.svg" id='anuncio-nuevo-preview_icon--lugar' class='anuncio-nuevo-preview_icon' title="Bootstrap">
                          <label id='celular_preview'></label>  
                        </div>                        
                        <div class="mr-3 icon-label" id='div_correo_preview'>
                          <img src="<?php echo base_url()?>assets/icons/email-24px.svg" class='anuncio-nuevo-preview_icon'  title="Bootstrap">
                          <label id='correo_preview'></label>     
                        </div>
                      </div>
                    </div>
                  </div>  
                </div>
              </div>  
            `)
            creaCarousel(data)
            asignaValores(data)                     
          })
      },                             
      buttons: {
        cerrarVerAnuncio: {
          text: 'Cerrar',
          btnClass: 'btn-pulpox-secondary',
          keys: ['escape'],        
        },                 
      }
    });               
  }

  function asignarImagenes(id,data){
    let image_url = "<?php echo base_url().'imagenes_anuncios/'?>";
    for (let index = 1; index < 11; index++) {
      if(data[`img_${index}`]!=''){
        $(`#img-${index}`).attr('src', image_url+id+"/"+data[`img_${index}`]+ "?timestamp=" + new Date().getTime())
        $(`#panel-image--div_icon-${index}`).hide()
        $(`#panel-image-${index}`).after(`    
          <div id='panel-image--div-delete-${index}' class='panel-image--div-delete'> 
            <i id='icon-delete-${index}' class="material-icons icon-delete" onclick='eliminarImagenActual(this)' data-numero-imagen='${index}'>delete_forever</i>
          </div>
        `)
      }    
    }
  }

  function eliminarImagenActual(imagen){   
      /**Elimina imágen de servidor */    
      let numero_imagen = imagen.getAttribute("data-numero-imagen");
      let path_imagen = $(`#img-${numero_imagen}`).attr('src')

      $.confirm({
              icon: 'fas fa-info-circle',
              title: 'Eliminar Imágen',
              type: 'orange',
              content: `<b>¿Estás seguro se eliminar esta imágen?</b> <br> <img src='${path_imagen}'>`,
              closeIcon:false,
              buttons: {
                nuevoAnuncio: {
                    text: 'Cancelar',
                    btnClass: 'btn-pulpox-secondary',
                    keys: ['escape', 'shift'],
                    action: function(){
                    }
                },
                misAnuncios: {
                    text: 'Sí',
                    btnClass: 'btn-pulpox-secondary',
                    keys: ['enter', 'shift'],
                    action: function(){   
                      var fd = new FormData();        
                      fd.append('numero', numero_imagen); 
                      fd.append('path_imagen', path_imagen);        
                      $.ajax({ 
                          url: BASE_URL+'misanuncios/eliminarImagenActual/', 
                          type: 'post', 
                          data: fd, 
                          contentType: false, 
                          processData: false,                 
                          beforeSend: function() { 
                              //Antes de iniciar el proceso de eliminación   
                              $(`#img-${numero_imagen}`).attr('src', "")
                              $(`#icon-${numero_imagen}`).removeClass( "fa fa-camera fa-3x" ).addClass("fas fa-spinner fa-3x fa-spin");
                              $(`#panel-image--div_icon-${numero_imagen}`).show() 
                          },
                          success: function(response){ 
                              var data = JSON.parse(response)  
                              if(data.codigo == 0){
                                  $(`#img-${numero_imagen}`).attr('src', '')
                                  $(`#panel-image--div_progreso-${numero_imagen}`).remove()
                                  $(`#panel-image--div-delete-${numero_imagen}`).remove()
                                  $(`#icon-${numero_imagen}`).removeClass( "fas fa-spinner fa-3x fa-spin" ).addClass("fa fa-camera fa-3x");
                                  $.confirm({
                                      icon: 'fas fa-smile-wink',
                                      title: 'Confirmación',
                                      type: 'green',
                                      content: `La imágen se elimino exitosamente.`,
                                      closeIcon:false,
                                      buttons: {
                                        OK: {
                                            text: 'Ok',
                                            btnClass: 'btn-pulpox-secondary',
                                            keys: ['escape', 'shift'],
                                            action: function(){
                                            }
                                        },                                      
                                      }
                                  });

                                  usuario_elimino_imagen = true;
                                                          
                                  if(numero_imagen==1){
                                      $(`#pulpox-message-principal-1`).show() 
                                  }

                              }else{
                                $(`#img-${numero_imagen}`).attr('src', path_imagen)
                                $(`#panel-image--div_icon-${numero_imagen}`).hide() 
                                $.confirm({
                                      icon: 'fas fa-sad-tear',
                                      title: 'Confirmación',
                                      type: 'red',
                                      content: `Ocurrió un problema al eliminar la imágen. Disculpa. Intenta más tarde.`,
                                      closeIcon:false,
                                      buttons: {
                                        OK: {
                                            text: 'Ok',
                                            btnClass: 'btn-pulpox-secondary',
                                            keys: ['enter'],
                                            action: function(){
                                            }
                                        },                                      
                                      }
                                });                                

                              }
                          },   
                          error:function(){
                            $(`#img-${numero_imagen}`).attr('src', path_imagen)
                            $(`#panel-image--div_icon-${numero_imagen}`).hide() 
                            $.confirm({
                                      icon: 'fas fa-sad-tear',
                                      title: 'Confirmación',
                                      type: 'red',
                                      content: `Ocurrió un problema al eliminar la imágen. Disculpa. Intenta más tarde.`,
                                      closeIcon:false,
                                      buttons: {
                                        OK: {
                                            text: 'Ok',
                                            btnClass: 'btn-pulpox-secondary',
                                            keys: ['escape', 'shift'],
                                            action: function(){
                                            }
                                        },                                      
                                      }
                            });
                          }
                      });                  
                    }
                }
              }
              });
  }

  function asignaListasSelects(modalidad,estado,ciudad,seccion,apartado){
      /**Define lista de datos a los inputs ESTADO, CIUDAD, SECCION, APARTADO    
      * Asigna lista de Estados a 'Estado'. 
      * Asigna lista de ciudades correspondientes a 'Chihuahua'. Inicia en 'Juárez'
      * Al cambiar el Estado, se asignan sus ciudades correspondientes
      */             

      $.get( BASE_URL+"General/obtenerEstados", function( response ) {       
          response = JSON.parse(response);
          let lista_estados='';
          $.each(response, function(key, value){
              lista_estados += `<option value="${value.nombre}">${value.nombre}</option>`;
          });
              $('#estado').children().remove();
              $('#estado').append(lista_estados)                  
              $('#estado').val(estado)      
              $('#estado').change()                                        
      })   

      $('#estado').change(function(){
        let estado = $('#estado').val()
          $('#ciudad').find('option').remove() //Remover options actuales
          $.get( BASE_URL+"General/obtenerCiudades",{estado}, function( response ) {      
              response = JSON.parse(response);
              var lista_ciudades='';
                  $.each(response, function(key, value){
                      lista_ciudades += `<option value="${value.nombre}">${value.nombre}</option>`;
                  }); 
                  $('#ciudad').children().remove();
                  $('#ciudad').append(lista_ciudades) //Asignar lista de apartado correspondiente según la sección elegida.   
                  if(ciudad!=''){
                    $('#ciudad').val(ciudad)
                    ciudad=''
                  }                      
          });                                   
      })

      $.get( BASE_URL+"General/obtenerModalidades", function( response ) {       
          response = JSON.parse(response);
          let lista_modalidades='';
          $.each(response, function(key, value){
              lista_modalidades += `<option value="${value.nombre}">${value.nombre}</option>`;
          });
              $('#modalidad').children().remove();
              $('#modalidad').append(lista_modalidades) 
              $('#modalidad').val(modalidad)                      
      });  

      $.get( BASE_URL+"General/obtenerSecciones", function( response ) {       
          response = JSON.parse(response);
          let lista_secciones='';
          $.each(response, function(key, value){
              lista_secciones += `<option value="${value.nombre}">${value.nombre}</option>`;
          });
          $('#seccion').children().remove(); 
          $('#seccion').append(lista_secciones) 
          $('#seccion').val(seccion) 
          $('#seccion').change()            
      });

      $('#seccion').change(function(){
          let seccion = $(this).val();
          $('#apartado').find('option').remove() //Remover options actuales
          $.get( BASE_URL+"General/obtenerApartados",{seccion}, function( response ) {      
              response = JSON.parse(response);
                  let lista_apartados='';
                  $.each(response, function(key, value){
                      lista_apartados += `<option value="${value.nombre}">${value.nombre}</option>`;
                  }); 
                  $('#apartado').children().remove();
                  $('#apartado').append(lista_apartados) //Asignar lista de apartado correspondiente según la sección elegida.

                  if(apartado!=''){
                    $('#apartado').val(apartado)
                    apartado=''
                  }    
          });                     
      })  
  }  

</script>