<script>
    function botonGuardarEdicion(){
        $('#titulo, #mensaje,#telefono,#celular,#correo').keyup(function(){
          $('.editar_boton_guardar').show()
        })
        $('#estado, #ciudad,#modalidad,#seccion,#apartado').change(function(){
          $('.editar_boton_guardar').show()
        })
    } 
</script>