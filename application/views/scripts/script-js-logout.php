<script>

$(document).ready(function() {  


$("#boton_salir").click(function(){
  let csrf = "123456";
  $.get( "usuario/logout",{csrf} )
                  .done(function( data ) {  
                    console.log(data)                  
                    let response = JSON.parse(data)                     
                    if(response.codigo == 0){
                      window.location.replace(BASE_URL+response.redirect);                     
                    }else{
                      $.alert({
                        title: `<span class="titulo-confirm">Cerrar Sesión</span>`,
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
})
  
  });


</script>

