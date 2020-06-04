<body  class='container-fluid p-0'>  
  <div class='row justify-content-center m-0'>  
    <div class="mt-2 col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10"> 
      <H1>Mis Anuncios</H1>
    </div> 
  </div>
  <div class='row justify-content-center m-0'>
    <div class="mt-2 col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">  
      <table id="mis-anuncios-table" class="table table-striped table-bordered table-sm table-hover" cellspacing="0" width="100%">
        <thead class='pulpox-table--thead'>
          <tr>        
            <th class="th-sm d-none d-lg-table-cell">#</th>        
            <th class="th-sm">Título</th>
            <th class="th-sm text-center"><i class="fas fa-eye"></i></th>
            <th class="th-sm d-none d-lg-table-cell">Modalidad</th> 
            <th class="th-sm d-none d-lg-table-cell">Lugar</th> 
            <th class="th-sm d-none d-lg-table-cell">Sección</th>
            <th class="th-sm d-none d-lg-table-cell">ID</th>
            <th class="th-sm d-none d-lg-table-cell">Creado</th>
            <th class="th-sm ">Estatus</th>
          </tr>
        </thead>
        <tbody class='pulpox-table-tbody'>
        </tbody>
        <tfoot>
        <tr>
        <th class="th-sm d-none d-lg-table-cell">#</th>        
            <th class="th-sm">Título</th>
            <th class="th-sm text-center"><i class="fas fa-eye"></i></th>
            <th class="th-sm d-none d-lg-table-cell">Modalidad</th> 
            <th class="th-sm d-none d-lg-table-cell">Lugar</th> 
            <th class="th-sm d-none d-lg-table-cell">Sección</th>
            <th class="th-sm d-none d-lg-table-cell">ID</th>
            <th class="th-sm d-none d-lg-table-cell">Creado</th>
            <th class="th-sm ">Estatus</th>
          </tr>
        </tfoot>
      </table>
    </div>

    <script> 

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
        }

      }

      function mostrarDatosMovil(titulo,id,modalidad,estado,ciudad,seccion,apartado,creado,estatus){
        usuario_elimino_imagen = false;
        $.confirm({
            icon: 'fas fa-info-circle',
            title: 'Información de mi anuncio',
            type: 'blue',
            columnClass: 'medium',
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
              console.log(estatus)

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
                btnClass: 'btn-pulpox-primary--line',
                action:function(){
                  eliminarAnuncio(id);
                },
              },
                  
              activarEstatus:{
                text: 'Activar',
                btnClass: 'btn-pulpox-primary--line',
                isHidden: true,
                action:function(){
                  cambiarEstatusDeAnuncio(id,estatus);
                },
              },     
              suspenderEstatus:{
                text: 'Suspender',
                btnClass: 'btn-pulpox-primary--line',
                isHidden: true,
                action:function(){
                  cambiarEstatusDeAnuncio(id,estatus);
                },
              },              
              editarAnuncio: {
                text: 'Editar',
                btnClass: 'btn-pulpox-primary--line',
                isHidden: true,
                action: function(){   
                  $.confirm({
                      icon: 'fas fa-edit',
                      title: 'Editar anuncio',
                      type: 'blue', 
                      closeIcon:false,                                        
                      content: function(){   
                        var self = this;
                        $.post("<?php echo base_url().'index.php/'.'misanuncios/obtenerDatosParaEdicionMovil/'?>", {id})
                          .done(function(response){
                              var data = JSON.parse(response)
                              self.setContent( 
                                                  `
                                                    <div class="form-row justify-content-center">
                                                        <div class="form-group col-11 col-sm-11>
                                                            <label for="titulo">Título</label>
                                                            <input type="text" id='titulo' class="form-control pulpox-validar" maxlength="50" value='${titulo}' >
                                                            <div class="pulpox-invalid-feedback">
                                                                    Elije un título
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-row justify-content-center">
                                                        <div class="form-group col-11 col-sm-11">
                                                            <label for="anuncio">Anuncio</label>
                                                        <pre class="pulpox-validar"> <textarea id='anuncio' class="form-control pulpox-validar" aria-label="With textarea" rows="10" maxlength="1000"> ${data.anuncio}</textarea></pre>
                                                            <div class="pulpox-invalid-feedback">
                                                                    Escribe tu anuncio
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-row form-row justify-content-center">
                                                        <div class="form-group col-11 col-sm-11 ">
                                                            <label for="estado">Estado*</label>
                                                            <select id="estado" class="form-control pulpox-validar-select">                 
                                                            </select>   
                                                            <div class="pulpox-invalid-feedback">
                                                                  Elije un Estado
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-11 col-sm-11">
                                                            <label for="ciudad">Ciudad</label>
                                                            <select id="ciudad" class="form-control pulpox-validar-select" >             
                                                            </select>  
                                                            <div class="pulpox-invalid-feedback">
                                                                    Elije una ciudad
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-row form-row justify-content-center">
                                                        <div class="form-group col-11 col-sm-11">
                                                            <label for="modalidad">Modalidad</label>
                                                            <select id="modalidad" class="form-control pulpox-validar-select">                 
                                                            </select>  
                                                            <div class="pulpox-invalid-feedback">
                                                                    Elije una modalidad
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-11 col-sm-11">
                                                            <label for="seccion">Sección</label>
                                                            <select id="seccion" class="form-control pulpox-validar-select" >
                                                            </select>  
                                                            <div class="pulpox-invalid-feedback">
                                                                    Elije una sección
                                                            </div>
                                                        </div>         

                                                        <div class="form-group col-11 col-sm-11">
                                                            <label for="apartado">Apartado</label>
                                                            <select id="apartado" class="form-control pulpox-validar-select" >                    
                                                            </select>  
                                                            <div class="pulpox-invalid-feedback">
                                                                    Elije un apartado
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-row justify-content-center">
                                                        <div class="form-group col-11 col-sm-11">
                                                            <label for="telefono">Tel (opcional)</label>
                                                            <input id='telefono' type="text" class="form-control" maxlength="10" value='${data.telefono}'>
                                                            <div class="pulpox-invalid-feedback">
                                                                    Deben ser 10 dígitos.
                                                            </div>
                                                            <small  class="form-text text-muted">Ej. 6561234567</small>                
                                                        </div>

                                                        <div class="form-group col-11 col-sm-11">
                                                            <label for="celular">Cel (opcional)</label>
                                                            <input id="celular" type="text" class="form-control" maxlength="10" value='${data.celular}'>
                                                            <div class="pulpox-invalid-feedback">
                                                                    Deben ser 10 dígitos.
                                                            </div>
                                                            <small class="form-text text-muted">Ej. 6561234567</small>
                                                        </div>

                                                        <div class="form-group col-11 col-sm-11">
                                                            <label for="correo">Correo (opcional)</label>
                                                            <input id="correo" type="email" class="form-control"  value='${data.correo}'>
                                                            <div class="pulpox-invalid-feedback">
                                                                    Correo inválido
                                                            </div>
                                                        </div>
                                                  
                                                    </div>

                                                    <div class="form-row panel-upload-images justify-content-center">

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
                                                  `                                         
                              )
                              asignaListasSelects(modalidad,estado,ciudad,seccion,apartado)
                              asignarImagenes(id,data)                            
                              
                          })
                      },                             
                      buttons: {
                        cancelarEdicion: {
                          text: 'Cancelar',
                          btnClass: 'btn-pulpox-primary',
                          keys: ['escape'],
                          action: function(){
                          }
                        },
                                  guardarEdicion: {
                                                  text: 'Guardar',
                                                  id:'editar_boton_guardar',
                                                  btnClass: 'btn-pulpox-primary guardarEdicion',
                                                  keys: ['enter', 'shift'],                                                
                                                  action: function(){
                                                    if (usuario_elimino_imagen == false){
                                                      console.log('No ha eliminado fotos')


                                                    }
                                                    if (usuario_elimino_imagen == true){
                                                      console.log('Ya eliminó fotos')

                                                      $.confirm({
                                                        icon: 'fas fa-smile-wink',
                                                        title: 'Confirmación',
                                                        type: 'green',
                                                        content: `La imágen se elimino exitosamente.`,
                                                        closeIcon:false,
                                                        buttons: {
                                                          OK: {
                                                              text: 'Ok',
                                                              btnClass: 'btn-pulpox-primary',
                                                              keys: ['escape', 'shift'],
                                                              action: function(){
                                                              }
                                                          },                                      
                                                        }
                                                    });





                                                    }


                                                  }
                                              }
                                            }
                                        }); 
                        
                }
              },
              verAnuncio: {
                text: 'Ver',
                btnClass: 'btn-pulpox-primary--line',
                action: function(){   
                  $.confirm({
                      //icon: 'fas fa-edit',
                      title: 'Ver anuncio',
                      type: 'blue', 
                      closeIcon:false,    
                      backgroundDismiss: true,                                    
                      content: function(){   
                        var self = this;
                        $.post("<?php echo base_url().'index.php/'.'misanuncios/obtenerDatosAnuncioMovil/'?>", {id})
                          .done(function(response){
                              var data = JSON.parse(response)
                              console.log(data)
                              self.setContent(                                 
                                `    <div id='nuevo_anuncio_previo' class='col-10 col-sm-10 col-md-8 col-lg-8 col-xl-5 mt-3'>                                        
                                        <div class="row justify-content-center">
                                            <div class="col-10 col-sm-10 col-md-12 col-lg-12 col-xl-12">
                                                <h2 id='titulo_preview'>${data.titulo}</h2>      
                                            </div>
                                        </div>

                                        <div class="row justify-content-left">
                                            <div class="col-10 col-sm-10 col-md-12 col-lg-12 col-xl-12">
                                                <div class="icon-label mr-3" title='Modalidad'>                             
                                                    <img src="<?php echo base_url()?>assets/icons/handshake.png" class='anuncio-nuevo-preview_icon'/>  
                                                    <label id='modalidad_preview'>${data.modalidad}</label>
                                                </div>
                                                <div class="icon-label mr-3">                             
                                                    <img src="<?php echo base_url()?>assets/icons/place-24px.svg" class='anuncio-nuevo-preview_icon'/>  
                                                    <label id='estado_ciudad'>${data.estado} / ${data.ciudad}</label>
                                                </div>
                                                <div class="icon-label">
                                                    <img src="<?php echo base_url()?>assets/icons/list-24px.svg" class='anuncio-nuevo-preview_icon'  title="Bootstrap">
                                                    <label id='seccion_apartado'>${data.seccion} / ${data.apartado}</label>           
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row justify-content-center pulpox-carousel">               
                                        </div>

                                        <div class="row justify-content-left mt-3 mb-3">
                                            <div class="col-10 col-sm-10 col-md-12 col-lg-12 col-xl-12">
                                                <div id="anuncio_preview">  
                                                ${data.anuncio}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row justify-content-center mb-3">
                                            <div class="col-10 col-sm-10 col-md-12 col-lg-12 col-xl-12">
                                                <span id='modalidad_mensaje'></span>
                                            </div>        
                                        </div>

                                        <div class="row justify-content-left ">
                                            <div class="col-10 col-sm-10 col-md-12 col-lg-12 col-xl-12">
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

                                `                                    
                              )
                                                    
                              
                          })
                      },                             
                      buttons: {
                        cancelarEdicion: {
                          text: 'Cerrar',
                          btnClass: 'btn-pulpox-primary',
                          keys: ['escape'],
                          action: function(){
                          }
                        },
                       
                                            }
                                        }); 
                        
                }
              },
            }
          });    
       }
      function cambiarEstatusDeAnuncio(id,estatus){

        let estatus_actual = estatus
        let estatus_boton = ''

        if(estatus== 'ACTIVO' ){
           estatus_boton = 'Sí, quiero Suspenderlo.'
        }

        if(estatus== 'SUSPENDIDO' ){
           estatus_boton =  'Sí, quiero Activarlo.'
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
                  btnClass: 'btn-pulpox-primary--line',
                  keys: ['escape'],
                  action: function(){
                  }
              },
              cambiarEstatus:{
                text: estatus_boton,
                btnClass: 'btn-pulpox-primary',
                keys: ['enter'],
                action:function(){
                  cambiarEstatus(id,estatus_actual)
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
                  btnClass: 'btn-pulpox-primary--line',                 
                  action: function(){
                  }
              },
              eliminarAnuncio:{
                text: `Sí, eliminar este anuncio`,
                btnClass: 'btn-pulpox-primary',
                action:function(){
                  $.post("<?php echo base_url().'index.php/'.'misanuncios/eliminarAnuncio/'?>", {id})
                  .done(function(response){
                    var data = JSON.parse(response) 
                    
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
                              btnClass: 'btn-pulpox-primary--line',                           
                              action: function(){
                                window.location.replace("<?php echo base_url().'index.php/'.'misanuncios/'?>");
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
                              btnClass: 'btn-pulpox-primary--line',
                              keys: ['escape', 'shift'],
                              action: function(){
                              }
                          },                  
                        }
                      });  
                    }
                    
                                  
                  }) 

                },
              },  
                  
            }
          });

      }

      function cambiarEstatus(id,estatus_actual){      
        $.post("<?php echo base_url().'index.php/'.'misanuncios/cambiarEstatus/'?>", {id,estatus_actual})
          .done(function(response){
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
                      btnClass: 'btn-pulpox-primary--line',
                      keys: ['enter'],
                      action: function(){
                        window.location.replace("<?php echo base_url().'index.php/'.'misanuncios/'?>");
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
                      btnClass: 'btn-pulpox-primary--line',
                      keys: ['enter'],
                      action: function(){
                      }
                  },                  
                }
              }); 
            }
          })      
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
          </div>`)


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
                        btnClass: 'btn-pulpox-primary',
                        keys: ['escape', 'shift'],
                        action: function(){
                        }
                    },
                    misAnuncios: {
                        text: 'Sí',
                        btnClass: 'btn-pulpox-primary',
                        keys: ['enter', 'shift'],
                        action: function(){   
                          var fd = new FormData();        
                          fd.append('numero', numero_imagen); 
                          fd.append('path_imagen', path_imagen);        
                          $.ajax({ 
                              url: "<?php echo base_url() . 'index.php/' .'misanuncios/eliminarImagenActual/'?>" , 
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
                                                btnClass: 'btn-pulpox-primary',
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
                                                btnClass: 'btn-pulpox-primary',
                                                keys: ['escape', 'shift'],
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
                                                btnClass: 'btn-pulpox-primary',
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
          const BASE_URL = "<?php echo base_url();?>" + "index.php/"

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

        activarBotonGuardar()
          

        $('.guardarEdicion').prop( "disabled", true );

      }   



    </script>
  </div>
</body>
