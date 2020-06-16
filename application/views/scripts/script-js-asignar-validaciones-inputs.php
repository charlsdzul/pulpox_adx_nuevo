<script>

  function asignaValidacionesInputs(){
        /**
        * Define validaciones generales para selects e inputs
        */
            let patt = /<script>/gi; 
            $('#titulo').maxlength({
                alwaysShow: true,
                threshold: 50,
                warningClass: "label label-success",
                limitReachedClass: "label label-danger",
                separator: ' de ',
                preText: ' ',
                postText: '',
                validate: true,
            });

            $("#titulo").keyup(function() {
            let titulo_ingresado = $(this).val();            
            let titulo_limpio = titulo_ingresado.replace(patt,'');
            $(this).val(titulo_limpio)    
            });

            $('#mensaje').maxlength({
            alwaysShow: true,
            warningClass: "label label-success",
            limitReachedClass: "label label-danger",
            separator: ' de ',
            preText: ' ',
            postText: '',
            validate: true
            });

            $("#mensaje").keyup(function() {
            let titulo_ingresado = $(this).val();            
            let titulo_limpio = titulo_ingresado.replace(patt,'');
            $(this).val(titulo_limpio)       
            });
            
            $("#telefono").keyup(function() {
            let telefono_ingresado = $(this).val();
            let patt = /[^1-9]/g;        
            let telefono_limpio = telefono_ingresado.replace(patt,'');
            $(this).val(telefono_limpio)       
            });

            $("#celular").keyup(function() {
            let telefono_ingresado = $(this).val();
            let patt = /[^1-9]/g;        
            let telefono_limpio = telefono_ingresado.replace(patt,'');
            $(this).val(telefono_limpio)       
            });            

  }

</script>

