<script>

  function iniciarSesion(){
    $.confirm({
    title: '<span class="titulo-confirm">Iniciar Sesión</span>',
    content: '' +
    '<form class="formName">' +
    '<div class="form-group">' +
    '<label>Usuario o correo</label>' +
    '<input id="login_usuario" type="text" placeholder="Ingresa tu usuario o correo" class="name form-control" required />' +    
    '</div>' +
    '<div class="form-group">' +    
    '<label>Contraseña</label>' +
    '<input id="login_contrasena" type="password" placeholder="Ingresa tu contraseña" class="name form-control" required />' +
    '</div>' +
    '</form>',
      buttons: {      
      iniciarSesion: {
            text: 'Entrar',
            btnClass: 'plpx-btn plpx-btn-primary',
            action: function () {     
              let usuario = $("#login_usuario").val();
              let contrasena = $("#login_contrasena").val();
              if(usuario==""){
                $.alert({
                  title: '<span class="titulo-confirm">Iniciar Sesióno</span>',
                  content: `<div class='contenido-confirm'>Ingresa tu usuario o correo</div>`,
                  type: 'red',
                });
              } else if(contrasena==""){
                $.alert({
                  title: `<span class="titulo-confirm">Iniciar Sesión</span>`,
                  content: `<div class='contenido-confirm'>Ingresa tu contraseña</div>`,
                  type: 'red',
                });
              }
              if(usuario!="" && contrasena!="" ){
                  $.post( "../usuario/login", { usuario, contrasena})
                  .done(function( data ) {                    
                    let response = JSON.parse(data)       
                  console.log(response);              
                    if(response.codigo == 0){
                      window.location.replace(BASE_URL+response.redirect);                     
                    }else{
                      $.alert({
                        title: `<span class="titulo-confirm">Iniciar Sesión</span>`,
                        content: `<div class='contenido-confirm'>${response.mensaje}</div>`,
                        type: 'red',
                      });
                    }
                  })
                  .fail(function() {
                    $.confirm({
                      title: response_fail.titulo,
                      content: response_fail.mensaje,
                      type: 'red',
                      backgroundDismiss: true,
                      typeAnimated: true,
                      buttons: {               
                        ok: {
                          text: 'Ok',
                            btnClass: 'btn-pulpox-danger--line',
                            keys: ['enter'],
                        }, 
                      }
                    });
                  })
              }
              return false;
            }
        },  
        cerrar: {
                text: 'Cerrar',
                btnClass: 'plpx-btn plpx-btn-danger-line',
                keys: ['escape'],       
                action: function(){
                  self.close();
                } 
        },    
      },
    });

  }
</script>

