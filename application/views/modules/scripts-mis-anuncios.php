<script> 

  const BASE_URL = "<?php echo base_url();?>index.php/";

  $(document).ready(function () {

    let dialog_obtener_anuncios= $.dialog({
      icon: 'fa fa-spinner fa-spin',
      title: '<span class="titulo-confirm">Mis Anuncios</span>',
      type: 'blue',
      content: "<div class='contenido-confirm'>Estamos obteniedo tus anuncios...<div class='contenido-confirm'>",
      
    }); 

    $.get(BASE_URL+"misanuncios/obtenerMisAnuncios/")
    .done(function(response){
      let mis_anuncios = JSON.parse(response);      
      let data;

      for (let index = 0; index < mis_anuncios.length; index++) { 

          if(mis_anuncios[index].estatus=='ACTIVO'){
            back_color ='#52a35c';
            color = 'white';
          }
          if(mis_anuncios[index].estatus=='SUSPENDIDO'){
            back_color = '#a39c52';
            color = 'white';
          }
          if(mis_anuncios[index].renovar==0){
            boton_renovar=`<td id='pulpox-td-table'><button class='btn btn-pulpox-info' onclick=renovarAnuncio('${mis_anuncios[index].public_id}')>Renovar</button></td>`;         
          }   
          
          if(mis_anuncios[index].renovar==1){
            boton_renovar=`<td id='pulpox-td-table'>-</td>`; 
          }      
       
        data += `
          <tr id='${mis_anuncios[index].public_id}'> 
            <th class='d-none d-lg-table-cell'>${index+1}</th>                      
            <td style='word-break: break-all;'>${mis_anuncios[index].titulo}</td>
            <td id='pulpox-td-table' title='Ver anuncio' id='pulpox-icon--ver' onclick='verAnuncio("${mis_anuncios[index].renovado}","${mis_anuncios[index].editado}","${mis_anuncios[index].titulo}","${mis_anuncios[index].public_id}","${mis_anuncios[index].modalidad}","${mis_anuncios[index].estado}" ,"${mis_anuncios[index].ciudad}","${mis_anuncios[index].seccion}","${mis_anuncios[index].apartado}","${mis_anuncios[index].creado}","${mis_anuncios[index].estatus}")'><i class="fas fa-eye"></i></td>                 
            ${boton_renovar}
            <td class='d-none d-lg-table-cell'>${mis_anuncios[index].modalidad} </td>
            <td class='d-none d-lg-table-cell'>${mis_anuncios[index].estado} / ${mis_anuncios[index].ciudad}</td>
            <td class='d-none d-lg-table-cell'>${mis_anuncios[index].seccion} / ${mis_anuncios[index].apartado}</td>
            <td style='word-break: break-all;' class='d-none d-lg-table-cell'>${mis_anuncios[index].public_id}</td>
            <td class='d-none d-lg-table-cell'>${mis_anuncios[index].renovado}</td>
            <td class='d-none d-lg-table-cell'>${mis_anuncios[index].creado}</td>
            <td id='pulpox-td-table' style='background-color:${back_color};color:${color};'>${mis_anuncios[index].estatus}</td>     
          </tr>`;    
      }  

      $('.pulpox-table-tbody').append(data); 
      dialog_obtener_anuncios.close();
      $('#mis-anuncios-table').DataTable();
      $('.dataTables_length').addClass('bs-select');    
    })
    .fail(function() {
      dialog_cambiando_estatus.close();   
      $.confirm({
        title: '<span class="titulo-confirm">Lo sentimos.',
        content: "<div class='contenido-confirm'>Nuestro servidor tiene problemas actualmente. Intente más tarde.</div>",
        type: 'red',
        typeAnimated: true,
        backgroundDismiss: true, 
        buttons: {
        cerrarVerAnuncio: {
          text: 'Cerrar',
          btnClass: 'btn-pulpox-danger',
          keys: ['escape','enter'],        
        },                 
      }
      });
    })     
    
  });

  function verAnuncio(renovado,editado,titulo,id,modalidad,estado,ciudad,seccion,apartado,creado,estatus){
    if(window.innerWidth< 960){
      mostrarDatosMovil(renovado,editado,titulo,id,modalidad,estado,ciudad,seccion,apartado,creado,estatus)
    }else{
      window.open(BASE_URL+'mianuncio/ver/'+id, '_blank');
    }
  }

  function uploadImage(imagen,anuncio_id){
        /* Ejecutya funciones de validaciones */
        
        var numero_imagen = imagen.getAttribute("data-numero-imagen");  

        if(validarExtensionImagen(imagen.files[0].name)){ 
            $(`#pulpox-invalid-feedback-${numero_imagen}`).html('');
            $(`#pulpox-invalid-feedback-${numero_imagen}`).hide();
           if(validarTamanoImagen(imagen.files[0].size)){
                $(`#pulpox-invalid-feedback-${numero_imagen}`).html('')
                $(`#pulpox-invalid-feedback-${numero_imagen}`).hide()
                uploadImageAjax(imagen,numero_imagen,anuncio_id)
            }else{
                $(`#pulpox-invalid-feedback-${numero_imagen}`).show();    
                $(`#pulpox-invalid-feedback-${numero_imagen}`).html('La imágen es demasiado grande. Máximo 5 MB')       
            }
        }else{
            $(`#pulpox-invalid-feedback-${numero_imagen}`).html('Elige una imágen con extensión JPG, JPEG, PNG, GIF.')
            $(`#pulpox-invalid-feedback-${numero_imagen}`).show()
        }    
  }

  function uploadImageAjax(imagen,numero_imagen,anuncio_id){
        /** Sube imágen a servidor. */

        $(`#panel-image-${numero_imagen}`).after(`
        <div id='panel-image--div_progreso-${numero_imagen}' class='panel-image--div_progreso'> 
            <div id='panel-image--bar_progreso-${numero_imagen}' class='panel-image--bar_progreso'> 
                </div>
        </div>  
        <div id='panel-image--div-delete-${numero_imagen}' class='panel-image--div-delete'> 
            <i id='icon-delete-${numero_imagen}' class="material-icons icon-delete" onclick='eliminarImagen(this,"${anuncio_id}")' data-numero-imagen='${numero_imagen}'>delete_forever</i>
        </div>`)

            var fd = new FormData(); 
            var image = imagen.files[0]; 
            fd.append('imagen', image); 
            fd.append('numero', numero_imagen); 
            fd.append('anuncio_id', anuncio_id); 

            $.ajax({ 
                url: BASE_URL+'mianuncio/guardarImagen/' , 
                type: 'post', 
                data: fd, 
                contentType: false, 
                processData: false, 
                xhr: function() {
                    //Esto pasa durante la subida de la imágen
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = ((evt.loaded / evt.total) * 100);
                            $(`#panel-image--bar_progreso-${numero_imagen}`).css('width',percentComplete+'%');
                            $(`#panel-image--bar_progreso-${numero_imagen}`).html(percentComplete+'%');                               
                        }else{
                        }
                    }, false);
                    return xhr;
                },
                beforeSend: function() { 
                    //Antes de iniciar la subida, se muestra el icono loading                      
                    $(`#icon-${numero_imagen}`).removeClass("fa fa-camera fa-3x").addClass("fas fa-spinner fa-3x fa-spin");
                },
                success: function(response){ 
                    let data = JSON.parse(response)
                    let url = "<?php echo base_url();?>";                     

                    if(data.codigo == 0){
                        $(`#panel-image--div_icon-${numero_imagen}`).hide() 
                        $(`#img-${numero_imagen}`).attr('src', url+data.path+ "?timestamp=" + new Date().getTime());
                        $(`#pulpox-invalid-feedback-${numero_imagen}`).html('')
                        $(`#pulpox-invalid-feedback-${numero_imagen}`).hide()      
                        $.confirm({
                          icon: 'fas fa-check-circle',
                          title: '<span class="titulo-confirm">Actualizar Imágen</span>',
                          type: 'green',
                          content: `<div class='contenido-confirm'>${data.mensaje}</div>`,
                          buttons: {
                            OK: {
                                text: 'Ok',
                                btnClass: 'btn-pulpox-success',
                                keys: ['enter'],
                            },                                      
                          }
                      })                        
                    }else{
                        $(`#icon-${numero_imagen}`).removeClass( "fas fa-spinner fa-3x fa-spin" ).addClass("fa fa-camera fa-3x");
                        $(`#panel-image--div_progreso-${numero_imagen}`).remove()
                        $(`#panel-image--div-delete-${numero_imagen}`).remove()
                        $(`#pulpox-invalid-feedback-${numero_imagen}`).html(data.mensaje)
                        $(`#pulpox-invalid-feedback-${numero_imagen}`).show()
                    }                   
                }, 
                fail:function(){
                  $.confirm({
                          icon: 'fas fa-check-circle',
                          title: '<span class="titulo-confirm">Lo sentimos</span>',
                          type: 'red',
                          content: `<div class='contenido-confirm'>Hubo un problema a intenar actualizar tu imágen. Intenta más tarde.</div>`,
                          buttons: {
                            OK: {
                                text: 'Ok',
                                btnClass: 'btn-pulpox-danger',
                                keys: ['enter'],
                            },                                      
                          }
                      })  

                },
            }); 
  }

  function validaFormulario(anuncio_id){
        /* Valida campos obligatorios: Titulo, Anuncio, Estado, Ciudad,Seccion, Apartado 
         * Muestra aviso en caso de no escribir Telefono, Celular o Correo.
        */          

        let elementos_validados = 0; 
        let num_error = 0 ;
        $('.pulpox-validar').each(function(i){
            //Se validan 6 elementos, los que tienen clase .pulpox-validar
            
            if($(this).val()==''){
                $(this).css('border-color','red')
                $(this).next().show()  //Muestra el div con mensaje de error  
                $(this).focus();

            }else{
                $(this).css('border-color','')
                $(this).next().hide() 
                elementos_validados++;
            }             
        });    

        $('.pulpox-validar-select').each(function(i){
            //Se validan 6 elementos, los que tienen clase .pulpox-validar
            if($(this).find('option:selected').val()==''){
                $(this).css('border-color','red')
                $(this).next().show()  //Muestra el div con mensaje de error   
                $(this).focus();                
            }else{
                $(this).css('border-color','')
                $(this).next().hide() 
                elementos_validados++;
            }             
        });  

        /**VALIDA LONGITUD DE TELEFONO */
        var telefono = $('#telefono')
        if(telefono.val().length>0 && telefono.val().length<10){
            telefono.css('border-color','red');
            telefono.next().show() ; //Muestra el div con mensaje de error  
        }
        if(telefono.val().length==10){
            telefono.css('border-color','');
            telefono.next().hide() ;
            elementos_validados++;
        }
        if(telefono.val()==''){
            elementos_validados++;                   
        }

        /**VALIDA LONGITUD DE CELULAR */ 
        var celular = $('#celular')
        if(celular.val().length>0 && celular.val().length<10){
            celular.css('border-color','red');
            celular.next().show() ; //Muestra el div con mensaje de error  
        }
        if(celular.val().length==10){
            celular.css('border-color','');
            celular.next().hide() ;
            elementos_validados++;  
        }
        if(celular.val()==''){
            elementos_validados++;                   
        }

        /**VALIDA EMAIL*/ 
        var email_regex= new RegExp(/^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i);
        var correo = $('#correo')

        if(correo.val()==''){
            elementos_validados++; 
            correo.css('border-color','');
            correo.next().hide() ;
        }else{
            if(email_regex.test(correo.val())){
                correo.css('border-color','');
                correo.next().hide() ;
                elementos_validados++; 
            }else{
                correo.css('border-color','red');
                correo.next().show() ; //Muestra el div con mensaje de error  
            }
        }    

        var validation = 1;

        if (elementos_validados == 10){
            if($('#telefono').val()=='' && $('#celular').val()=='' && $('#correo').val()==''){
                $.confirm({
                    icon: 'fas fa-exclamation-circle',
                    title: '<span class="titulo-confirm">Aviso',
                    type: 'orange',
                    content: 'No pusiste ningún medio de contacto ¿Así lo quieres publicar?',                    
                    buttons: {
                        misAnuncios: {
                            text: 'Sí',
                            btnClass: 'btn-pulpox-secondary--line',
                            keys: ['enter', 'shift'],
                            action: function(){
                              guardarEdicion(anuncio_public_id)
                            }
                        },
                        nuevoAnuncio: {
                            text: 'No, editar.',
                            btnClass: 'btn-pulpox-secondary',
                            keys: ['enter', 'shift'],
                            action: function(){                              
                            }
                        },                      
                    }
                });
            }else{
              guardarEdicion(anuncio_public_id)
            }
        }
  }

  function mostrarDatosMovil(renovado,editado,titulo,id,modalidad,estado,ciudad,seccion,apartado,creado,estatus){
    $.confirm({
        icon: 'fas fa-info-circle',
        title: '<span class="titulo-confirm">Información de mi anuncio</span>',
        type: 'blue',
        columnClass: 'large',
        backgroundDismiss: true,
        content: `
          <div class='contenido-confirm'>
            <b>Título:</b>  ${titulo} <br>
            <b>Modalidad:</b>  ${modalidad}<br>
            <b>Lugar:</b>  ${estado} / ${ciudad}<br>
            <b>Sección:</b>  ${seccion} / ${apartado}<br>
            <b>ID:</b> ${id}<br>
            <b>Creado:</b> ${creado}<br>
            <b>Editado:</b> ${editado}<br>
            <b>Renovado:</b> ${renovado}<br>
            <div class='div_estatus_actual'>
              <b>Estatus:</b> ${estatus}
            </div>
          </div>
        `,
        closeIcon:true,
        onContentReady:function(){
          this.buttons.suspenderEstatus.addClass("btn-pulpox-warning--line")
          this.buttons.activarEstatus.addClass('btn-pulpox-success--line')
          this.buttons.eliminarAnuncio.addClass('btn-pulpox-danger--line')
          this.buttons.editarAnuncio.addClass('btn-pulpox-secondary--line')
          this.buttons.verAnuncioMobil.addClass('btn-pulpox-info--line') 
          $('.div_estatus_actual').css('text-align','center')

          if(estatus=='ACTIVO'){
            $('.div_estatus_actual').css('background-color','#52a35c')
            $('.div_estatus_actual').css('color','white')
            this.buttons.suspenderEstatus.show()
            this.buttons.activarEstatus.hide()
            this.buttons.eliminarAnuncio.show()
            this.buttons.editarAnuncio.show()            
          }
          if(estatus=='SUSPENDIDO'){
            $('.div_estatus_actual').css('background-color','#a39c52')
            $('.div_estatus_actual').css('color','white')
            this.buttons.activarEstatus.show()
            this.buttons.suspenderEstatus.hide()
            this.buttons.eliminarAnuncio.show()
            this.buttons.editarAnuncio.show()            
          }
          if(estatus=='ELIMINADO'){
            $('.div_estatus_actual').css('background-color','#a3525a')
            $('.div_estatus_actual').css('color','white')
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
              editarAnuncioMovil(titulo,id,modalidad,estado,ciudad,seccion,apartado);
              asignaValidacionesInputs();
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

  function cambiarEstatusDeAnuncio(id,estatus){
    let estatus_actual = estatus
    let estatus_boton = ''
    let clase_boton =''
    let type_confirm = ''
    if(estatus== 'ACTIVO' ){
      estatus_boton = 'Sí, quiero suspenderlo'
      clase_boton = 'btn-pulpox-info'
      type_confirm = 'blue'
    }
    if(estatus== 'SUSPENDIDO' ){
      estatus_boton =  'Sí, quiero activarlo'
      clase_boton = 'btn-pulpox-info'
      type_confirm = 'blue'
    }           
      $.confirm({
        icon: 'fas fa-info-circle',
        title: '<span class="titulo-confirm">Cambio de estatus<span>',
        type: type_confirm,
        columnClass: 'large',
        backgroundDismiss: true,
        content: `<div class='contenido-confirm'>
          El estatus actual del anuncio es <b>${estatus}</b> ¿Realmente desea cambiarlo?<br><br>Recuerde: 
          <label><b>ACTIVO:</b> El anuncio es visible para todo el mundo. Puedes Suspenderlo después.</label>  
          <label><b>SUSPENDIDO:</b> El anuncio nadie lo verá. Puedes Activarlo después.</label>          
        </div>`,
        buttons: {
          cerrar: {
            text: 'Cancelar',
              btnClass: 'btn-pulpox-danger--line',
              keys: ['escape'],           
          },
          cambiarEstatus:{
            text: estatus_boton,
            btnClass: clase_boton,
            keys: ['enter'],
            action:function(){    
              let dialog_cambiando_estatus = $.dialog({
                    icon: 'fa fa-spinner fa-spin',
                    title: '<span class="titulo-confirm">Cambio de estatus</span>',
                    type: 'blue',
                    content: "<div class='contenido-confirm'>Estamos cambiando el estatus de tu anuncio...<div class='contenido-confirm'>",
                    
              });   
              $.post(BASE_URL+'mianuncio/cambiarEstatus/', {id,estatus_actual})
                .done(function(response){
                  dialog_cambiando_estatus.close(); 
                  var data = JSON.parse(response)  
                  if(data.codigo == 0){
                    $.confirm({
                      icon: 'fas fa-check-circle',
                      title: '<span class="titulo-confirm">Cambio de estatus</span>',
                      type: 'green',
                      columnClass: 'large',
                      content: `<div class='contenido-confirm'>${data.mensaje}</div>`,
                      buttons: {
                        ok: {
                          text: 'Ok',
                            btnClass: 'btn-pulpox-success',
                            keys: ['enter'],
                            action: function(){
                              window.location.replace(BASE_URL+'misanuncios/');
                            }
                        },                  
                      }
                  }); 

                  }else{
                    $.confirm({
                      icon: 'fas fa-exclamation-circle',
                      title: '<span class="titulo-confirm">Cambio de estatus',
                      type: 'red',
                      columnClass: 'large',
                      content: `<div class='contenido-confirm'>${data.mensaje}</div>`,
                      closeIcon:true,
                      buttons: {
                        ok: {
                          text: 'Ok',
                            btnClass: 'btn-pulpox-danger',
                            keys: ['escape','enter'],              
                        },                  
                      }
                    }); 
                  }
                })     
                .fail(function() {
                  dialog_cambiando_estatus.close();   
                  $.confirm({
                    title: '<span class="titulo-confirm">Lo sentimos.</span>',
                    content: "<div class='contenido-confirm'>Nuestro servidor tiene problemas actualmente. Intente más tarde.</div>",
                    type: 'red',
                    typeAnimated: true,
                    backgroundDismiss: true, 
                    buttons: {
                    cerrarVerAnuncio: {
                      text: 'Cerrar',
                      btnClass: 'btn-pulpox-danger',
                      keys: ['escape','enter'],        
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
        title: '<span class="titulo-confirm">Eliminar Anuncio<span>',
        type: 'blue',
        columnClass: 'medium',
        backgroundDismiss: true,
        content: `
        <div class='contenido-confirm'><b>¿Realmente desea eliminarlo?</b><br><br>Recuerde: 
          <label>El anuncio se eliminará y nadie podrá verlo, aunque tú podrás verlo en 'Mis Anuncios'.</label></div>                      
        `,
        buttons: {
          cerrar: {
            text: 'Cancelar',
              btnClass: 'btn-pulpox-danger--line',  
              keys: ['escape'], 
          },
          eliminarAnuncio:{
            text: `Sí, eliminar este anuncio`,
            btnClass: 'btn-pulpox-info',
            keys: ['enter'], 
            action:function(){
              let dialog_eliminando = $.dialog({
                  icon: 'fa fa-spinner fa-spin',
                  title: '<span class="titulo-confirm">Eliminar Anuncio<span>',
                  type: 'blue',
                  content: "<div class='contenido-confirm'>Estamos eliminando tu anuncio...</div>",
                  
              }); 
              $.post(BASE_URL+'mianuncio/eliminar/', {id})
              .done(function(response){
                var data = JSON.parse(response) 
                dialog_eliminando.close();               
                if(data.codigo == 0){
                  $.confirm({
                    icon: 'fas fa-check-circle',
                    title: '<span class="titulo-confirm">Eliminar Anuncio',
                    type: 'green',
                    columnClass: 'medium',
                    backgroundDismiss: true,
                    content: `<div class='contenido-confirm'>${data.mensaje}</div>`,                   
                    buttons: {
                      ok_eliminado: {
                        text: 'Ok',
                        btnClass: 'btn-pulpox-success',    
                        keys: ['enter'],                       
                        action: function(){
                          window.location.replace(BASE_URL+'misanuncios/');
                        }
                      },                  
                    }
                });  
                }else{
                  $.confirm({
                    icon: 'fas fa-exclamation-circle',
                    title: '<span class="titulo-confirm">Eliminar Anuncio<span>',
                    type: 'red',
                    columnClass: 'medium',
                    content: `<div class='contenido-confirm'>${data.mensaje}</div>`,
                    backgroundDismiss: true,
                    buttons: {
                      ok: {
                        text: 'Ok',
                          btnClass: 'btn-pulpox-danger--line',
                          keys: ['enter'],                        
                      },                  
                    }
                  });  
                }               
              }) 
              .fail(function() {
                dialog_eliminando.close();   
                  $.confirm({
                    title: '<span class="titulo-confirm">Lo sentimos.<span>',
                    content: "<div class='contenido-confirm'>Nuestro servidor tiene problemas actualmente. Intente más tarde.</div>",
                    type: 'red',
                    backgroundDismiss: true,
                    typeAnimated: true,
                    buttons: {               
                      ok: {
                        text: 'Ok',
                          btnClass: 'btn-pulpox-danger--line',
                          keys: ['escape','enter'],
                      }, 
                    }
                  });
                }) 
            },
          },             
        }
      });
  }

  function editarAnuncioMovil(titulo,id,modalidad,estado,ciudad,seccion,apartado){ 
    $.confirm({
      icon: 'fas fa-edit',
      title: '<span class="titulo-confirm">Editar anuncio<span>',
      columnClass: 'large',
      backgroundDismiss: true,
      type: 'blue', 
      modal: true,                                      
      content: function(){   
          var self = this;
          $.get(BASE_URL+'mianuncio/obtenerDatosComplementariosEdicionMovil/', {id})
          .done(function(response){
            var data = JSON.parse(response)
            if(data.codigo==0){
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
                        <textarea id='mensaje' class="form-control pulpox-validar" aria-label="With textarea" rows="10" maxlength="1000">${data.mensaje}</textarea>
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
                                                  
                            <input id='input-image-1' type="file" style='display:none;' onchange='uploadImage(this,"${id}")' data-numero-imagen='1'>
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
                            <input id='input-image-2' type="file" style='display:none;' onchange='uploadImage(this,"${id}")'data-numero-imagen='2'>
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
                                                  
                                <input id='input-image-3' type="file" style='display:none;' onchange='uploadImage(this,"${id}")'data-numero-imagen='3'>
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
                                                  
                                <input id='input-image-4' type="file" style='display:none;' onchange='uploadImage(this,"${id}")'data-numero-imagen='4'>
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
                                                  
                                <input id='input-image-5' type="file" style='display:none;' onchange='uploadImage(this,"${id}")'data-numero-imagen='5'>
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
                                                  
                                <input id='input-image-6' type="file" style='display:none;' onchange='uploadImage(this,"${id}")'data-numero-imagen='6'>
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
                                                  
                                <input id='input-image-7' type="file" style='display:none;' onchange='uploadImage(this,"${id}")'data-numero-imagen='7'>
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
                                                  
                                <input id='input-image-8' type="file" style='display:none;' onchange='uploadImage(this,"${id}")'data-numero-imagen='8'>
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
                                                  
                                <input id='input-image-9' type="file" style='display:none;' onchange='uploadImage(this,"${id}")'data-numero-imagen='9'>
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
                                                  
                                <input id='input-image-10' type="file" style='display:none;' onchange='uploadImage(this,"${id}")'data-numero-imagen='10'>
                            </div>  
                            <div id="pulpox-invalid-feedback-10" class="pulpox-invalid-feedback">
                            </div>                        
                        </div> 
                    </div>           
            `)
            asignaListasSelects(modalidad,estado,ciudad,seccion,apartado)
            asignaValidacionesInputs();
            asignarImagenes(id,data) 
            
            }else{
              $.confirm({
                    icon: 'fas fa-check-circle',
                    title: '<span class="titulo-confirm">Lo sentimos.<span>',
                    type: 'red',
                    columnClass: 'medium',
                    content: data.mensaje,
                    closeIcon:true,
                    buttons: {
                      ok_eliminado: {
                        text: 'Ok',
                          btnClass: 'btn-pulpox-danger',                           
                          action: function(){
                          }
                      },                  
                    }
                }); 
            }             
          })
      },   
      onContentReady: function () {
        $('#titulo, #mensaje,#telefono,#celular,#correo').keyup(function(){
              $('.editar_boton_guardar').show()
            })
            $('#estado, #ciudad,#modalidad,#seccion,#apartado').change(function(){
              console.log('saasaa')
              $('.editar_boton_guardar').show()
            })
      },                          
      buttons: {
        cerrarEdicion: {
          text: 'Cerrar',
          id:'editar_boton_cerrar',
          btnClass: 'btn-pulpox-info editar_boton_cerrar',
          keys: ['escape'],  
        },
        guardarEdicion: {
          text: 'Guardar Edición',
          id:'editar_boton_guardar',
          btnClass: 'btn-pulpox-info guardarEdicion editar_boton_guardar',
          keys: ['enter'],   
          isHidden: true,  
          action: function(){ 
            validaFormulario(id)   
            return false;
          }
        },
      }
    });                   
  }

  function validaFormulario(anuncio_public_id){
        /* Valida campos obligatorios: Titulo, Anuncio, Estado, Ciudad,Seccion, Apartado 
         * Muestra aviso en caso de no escribir Telefono, Celular o Correo.
        */          

        let elementos_validados = 0; 
        let num_error = 0 ;
        $('.pulpox-validar').each(function(i){
            //Se validan 6 elementos, los que tienen clase .pulpox-validar
            
            if($(this).val()==''){
                $(this).css('border-color','red')
                $(this).next().show()  //Muestra el div con mensaje de error  
                $(this).focus();

            }else{
                $(this).css('border-color','')
                $(this).next().hide() 
                elementos_validados++;
            }             
        });    

        $('.pulpox-validar-select').each(function(i){
            //Se validan 6 elementos, los que tienen clase .pulpox-validar
            if($(this).find('option:selected').val()==''){
                $(this).css('border-color','red')
                $(this).next().show()  //Muestra el div con mensaje de error   
                $(this).focus();                
            }else{
                $(this).css('border-color','')
                $(this).next().hide() 
                elementos_validados++;
            }             
        });  

        /**VALIDA LONGITUD DE TELEFONO */
        var telefono = $('#telefono')
        if(telefono.val().length>0 && telefono.val().length<10){
            telefono.css('border-color','red');
            telefono.next().show() ; //Muestra el div con mensaje de error  
        }
        if(telefono.val().length==10){
            telefono.css('border-color','');
            telefono.next().hide() ;
            elementos_validados++;
        }
        if(telefono.val()==''){
            elementos_validados++;                   
        }

        /**VALIDA LONGITUD DE CELULAR */ 
        var celular = $('#celular')
        if(celular.val().length>0 && celular.val().length<10){
            celular.css('border-color','red');
            celular.next().show() ; //Muestra el div con mensaje de error  
        }
        if(celular.val().length==10){
            celular.css('border-color','');
            celular.next().hide() ;
            elementos_validados++;  
        }
        if(celular.val()==''){
            elementos_validados++;                   
        }

        /**VALIDA EMAIL*/ 
        var email_regex= new RegExp(/^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i);
        var correo = $('#correo')

        if(correo.val()==''){
            elementos_validados++; 
            correo.css('border-color','');
            correo.next().hide() ;
        }else{
            if(email_regex.test(correo.val())){
                correo.css('border-color','');
                correo.next().hide() ;
                elementos_validados++; 
            }else{
                correo.css('border-color','red');
                correo.next().show() ; //Muestra el div con mensaje de error  
            }
        }    

        var validation = 1;

        if (elementos_validados == 10){
            if($('#telefono').val()=='' && $('#celular').val()=='' && $('#correo').val()==''){
                $.confirm({
                    icon: 'fas fa-exclamation-circle',
                    title: '<span class="titulo-confirm">Aviso',
                    type: 'orange',
                    content: 'No pusiste ningún medio de contacto ¿Así lo quieres publicar?',
                    
                    buttons: {
                        misAnuncios: {
                            text: 'Sí',
                            btnClass: 'btn-pulpox-success--line',
                            keys: ['enter', 'shift'],
                            action: function(){
                              guardarEdicion(anuncio_public_id)
                            }
                        },
                        nuevoAnuncio: {
                            text: 'No, editar.',
                            btnClass: 'btn-pulpox-success',
                            keys: ['enter', 'shift'],
                            action: function(){                              
                            }
                        },                      
                    }
                });
            }else{
              guardarEdicion(anuncio_public_id)
            }
        }
  }

  function guardarEdicion(anuncio_public_id){
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
              'anuncio_public_id':anuncio_public_id,
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
            $.post(BASE_URL+'mianuncio/editarMovil/', {anuncio_editado})
              .done(function(response){
                var response = JSON.parse(response)
                if(response.codigo==0){               
                  $.confirm({
                  icon: 'fas fa-check-circle',
                  title: '<span class="titulo-confirm">Confirmación',
                  type: 'green',
                  content: response.mensaje,
                  
                  buttons: {
                    OK: {
                        text: 'Ok',
                        btnClass: 'btn-pulpox-success',
                        keys: ['enter'],
                        action: function(){
                          window.location.replace(BASE_URL+'misanuncios/');                        
                        }
                    },                                      
                  }
                });
                }else{
                  $.confirm({
                    icon: 'fas fa-exclamation-circle',
                    title: '<span class="titulo-confirm">Confirmación',
                    type: 'red',
                    content: response.mensaje,
                    
                    buttons: {
                      OK: {
                          text: 'Ok',
                          btnClass: 'btn-pulpox-danger',
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
                    icon: 'fas fa-exclamation-circle',
                    title: '<span class="titulo-confirm">Confirmación',
                    type: 'red',
                    content: response.mensaje,
                    
                    buttons: {
                      OK: {
                          text: 'Ok',
                          btnClass: 'btn-pulpox-danger',
                          keys: ['enter'],                   
                      },                                      
                    }
                });
              })
  }

  function verAnuncioMovil(id){   
    $.confirm({
      icon: 'fas fa-eye',
      title: '<span class="titulo-confirm">Ver anuncio<span>',
      type: 'blue', 
      columnClass: 'large',
          
      backgroundDismiss: true,                                    
      content: function(){   
        var self = this;
        $.get(BASE_URL+'mianuncio/verMovil/', {id})
          .done(function(response){
            var data = JSON.parse(response)
            self.setContent(`  
              <div class='container-fluid p-0 mb-1 mt-1'>
                <div class='row justify-content-center m-0'>    
                  <div id='nuevo_anuncio_previo' class='col-11 col-sm-11'>
                    <div class="row justify-content-center">
                      <div class="div-titulo col-11 col-sm-11">
                        <h1 id='titulo_preview'></h1>      
                      </div>
                    </div>
                    <div class="row justify-content-center">
                      <div class="div-modSecApa col-11 col-sm-11">
                          <div class="icon-label mr-3">                             
                              <img src="<?php echo base_url()?>assets/icons/handshake.png" class='anuncio-nuevo-preview_icon'/>  
                              <label id='modalidad_preview'></label>
                          </div>
                          <div class="icon-label mr-3">                             
                              <img src="<?php echo base_url()?>assets/icons/place-24px.svg" class='anuncio-nuevo-preview_icon'/>  
                              <label id='estado_ciudad'></label>
                          </div>
                          <div class="icon-label">
                              <img src="<?php echo base_url()?>assets/icons/list-24px.svg" class='anuncio-nuevo-preview_icon' >
                              <label id='seccion_apartado'></label>           
                          </div>
                      </div>
                    </div>
                    <div class="row justify-content-center pulpox-carousel div-carousel">               
                    </div>          
                    <div class="row justify-content-center mt-2">
                      <div class="col-11 col-sm-11" title='Mensaje'>
                          <div class='div-mensaje' id="mensaje_preview">  
                          </div>
                      </div>
                    </div> 
                    <div class="row justify-content-center div-forma-contacto">
                      <div class="col-11 col-sm-11">
                        <div class="mr-3 icon-label div-contacto" id='div_telefono_preview'>
                          <img src="<?php echo base_url()?>assets/icons/phone-24px.svg" id='anuncio-nuevo-preview_icon--lugar' class='anuncio-nuevo-preview_icon'>
                          <label id='telefono_preview'></label>   
                        </div>
                        <div class="mr-3 icon-label div-contacto" id='div_celular_preview'>
                          <img src="<?php echo base_url()?>assets/icons/stay_current_portrait-24px.svg" id='anuncio-nuevo-preview_icon--lugar' class='anuncio-nuevo-preview_icon'>
                          <label id='celular_preview'></label>  
                        </div>                        
                        <div class="mr-3 icon-label div-contacto" id='div_correo_preview'>
                          <img src="<?php echo base_url()?>assets/icons/email-24px.svg" class='anuncio-nuevo-preview_icon'>
                          <label id='correo_preview'></label>     
                        </div>
                      </div>
                    </div>
              <!--      <div class="row justify-content-center div-modalidad-mensaje" id='modalidad_mensaje--div'>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <span id='modalidad_mensaje'></span>
                        </div>        
                    </div> -->
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
          btnClass: 'btn-pulpox-info',
          keys: ['escape','enter'],        
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
            <i id='icon-delete-${index}' class="material-icons icon-delete" onclick='eliminarImagen(this,"${id}")' data-numero-imagen='${index}'>delete_forever</i>
          </div>
        `)
      }    
    }
  }

  function eliminarImagen(imagen,anuncio_id){   
      /**Elimina imágen de servidor */    
      let numero_imagen = imagen.getAttribute("data-numero-imagen");
      let path_imagen = $(`#img-${numero_imagen}`).attr('src')

      $.confirm({
              icon: 'fas fa-info-circle',
              title: '<span class="titulo-confirm">Eliminar Imágen</span>',
              type: 'blue',
              content: `<div class='contenido-confirm'>¿Estás seguro de eliminar esta imágen? <br> <img src='${path_imagen}'></div>`,
              backgroundDismiss: true,
              buttons: {
                nuevoAnuncio: {
                    text: 'Cancelar',
                    btnClass: 'btn-pulpox-danger--line',
                    keys: ['escape'],                   
                },
                misAnuncios: {
                    text: 'Sí, eliminar',
                    btnClass: 'btn-pulpox-info',
                    keys: ['enter'],
                    action: function(){   
                      var fd = new FormData();        
                      fd.append('numero', numero_imagen); 
                      fd.append('path_imagen', path_imagen);  
                      fd.append('anuncio_id', anuncio_id);         
                      $.ajax({ 
                          url: BASE_URL+'mianuncio/eliminarImagen/', 
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
                                      icon: 'fas fa-check-circle',
                                      title: '<span class="titulo-confirm">Eliminar Imágen</span>',
                                      type: 'green',
                                      content: `<div class='contenido-confirm'>${data.mensaje}</div>`,
                                      buttons: {
                                        OK: {
                                            text: 'Ok',
                                            btnClass: 'btn-pulpox-success',
                                            keys: ['enter'],
                                        },                                      
                                      }
                                  });                     
                                  if(numero_imagen==1){
                                      $(`#pulpox-message-principal-1`).show() 
                                  }
                              }else{
                                $(`#img-${numero_imagen}`).attr('src', path_imagen)
                                $(`#panel-image--div_icon-${numero_imagen}`).hide() 
                                $.confirm({
                                      icon: 'fas fa-exclamation-circle',
                                      title: '<span class="titulo-confirm">Lo sentimos.</span>',
                                      type: 'red',
                                      content: `<div class='contenido-confirm'>Ocurrió un problema al eliminar la imágen. Disculpa. Intenta más tarde.</div>`,
                                      buttons: {
                                        OK: {
                                            text: 'Ok',
                                            btnClass: 'btn-pulpox-danger',
                                            keys: ['enter','enter'],
                                        },                                      
                                      }
                                });     
                              }
                          },   
                          fail:function(){
                            $(`#img-${numero_imagen}`).attr('src', path_imagen)
                            $(`#panel-image--div_icon-${numero_imagen}`).hide() 
                            $.confirm({
                                      icon: 'fas fa-exclamation-circle',
                                      title: '<span class="titulo-confirm">Lo sentimos.</span>',
                                      type: 'red',
                                      content: `Ocurrió un problema al eliminar la imágen. Intenta más tarde.`,
                                      buttons: {
                                        OK: {
                                            text: 'Ok',
                                            btnClass: 'btn-pulpox-danger',
                                            keys: ['escape','enter'],                                           
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