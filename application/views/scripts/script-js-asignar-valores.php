<script>

  function asignaValores(anuncio_datos){
      /** Asigna valores a VER ANUNCIO */
      
      $('#titulo_preview').text(anuncio_datos['titulo'])
      $('#mensaje_preview').html(anuncio_datos['mensaje'])
      $('#modalidad_preview').text(anuncio_datos['modalidad'])
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

      $('#anuncio_id').html('<b>ID del anuncio:</b> '+anuncio_datos['public_id'])
      $('#creado').html('<b>Creado:</b> '+anuncio_datos['creado'])
      $('#editado').html('<b>Editado:</b> '+anuncio_datos['editado'])
      $('#renovado').html('<b>Renovado:</b> '+anuncio_datos['renovado'])


      $('#estatus_actual').html('<b>Estatus actual:</b> '+anuncio_datos['estatus'])
      
      if(anuncio_datos['estatus']=='ACTIVO'){
        $('.div_estatus_actual').css('background-color','#52a35c')
        $('.div_estatus_actual').css('color','white')
      }

      if(anuncio_datos['estatus']=='SUSPENDIDO'){
        $('.div_estatus_actual').css('background-color','#a39c52')
        $('.div_estatus_actual').css('color','white')
      }

      if(anuncio_datos['estatus']=='ELIMINADO'){
        $('.div_estatus_actual').css('background-color','#a3525a')
        $('.div_estatus_actual').css('color','white')
      }

      $('.div_estatus_actual').css('text-align','center')

      switch (anuncio_datos['modalidad']) {
          case 'Compro':
          $('#modalidad_mensaje').html('El anunciante está comprando ¿Puedes ofrecerle algo? ¡Contáctalo!')     
          break;      
          case 'Busco':
          $('#modalidad_mensaje').html('El anunciante está buscando algo ¿Puedes ayudarlo? ¡Contáctalo!')     
          break;  
          case 'Dono':
          $('#modalidad_mensaje').html('El anunciante está donando ¿Lo necesitas? ¡Contáctalo!')     
          break;
          case 'Promuevo':
          $('#modalidad_mensaje').html('El anunciante está promoviendo ¿Te interesa? ¡Contáctalo!')     
          break;
          case 'Regalo':
          $('#modalidad_mensaje').html('El anunciante está regalando ¿Lo quieres? ¡Contáctalo!')     
          break;
          case 'Rento':
          $('#modalidad_mensaje').html('El anunciante está rentando ¿Lo necesitas? ¡Contáctalo!')     
          break;
          case 'Traspaso':
          $('#modalidad_mensaje').html('El anunciante está traspasando ¿Te interesa? ¡Contáctalo!')     
          break;
          case 'Vendo':
          $('#modalidad_mensaje').html('El anunciante está vendiendo ¿Te interesa? ¡Contáctalo!')     
          break; 
      }
  }  

</script>

