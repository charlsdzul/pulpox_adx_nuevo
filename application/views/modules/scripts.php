
<!-- GENERAL SCRIPTS -->
<script src="../../assets/libs/jquery-3.1.1/jquery-3.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script  src="../../assets/libs/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>


<script>
  $(function() {
    $('#toggle-one').bootstrapToggle();
  })
</script>

<script src="../../assets/ajax/getPublicStock.js"></script>
<script src="../../assets/ajax/getFilter.js"></script>




<!-- SCRIPTS propiedadesAlta -->
<script> 
    $('#moneda_button__dropdown-menu a').click
    (function(){
        var moneda_seleccionada = $(this).html()
        $('#venta_moneda').val(moneda_seleccionada)
    })  

    $('#comision_button__dropdown-menu a').click
    (function(){
        var moneda_seleccionada = $(this).html()
        $('#venta_comision').val(moneda_seleccionada)
    })  

    $('#general_tipo').change
    (function(){
        var tipo_seleccionado = $(this).val()
        
        if(tipo_seleccionado=='RESIDENCIAL'){
            $('#accordion-comercial').hide()
            $('#accordion-terreno').hide()
            $('#accordion-residencial').show()          
        }

        if(tipo_seleccionado=='COMERCIAL'){
            $('#accordion-residencial').hide()
            $('#accordion-terreno').hide()
            $('#accordion-comercial').show()           
        }

        if(tipo_seleccionado=='TERRENO'){
            $('#accordion-residencial').hide()
            $('#accordion-comercial').hide()
            $('#accordion-terreno').show()  
        }


    })  


</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>







   <!--

<script src='../../assets/libs/jquery-nice-select-1.1.0/js/fastclick.js'></script>
<script src='../../assets/libs/jquery-nice-select-1.1.0/js/jquery.nice-select.min.js'></script>
<script src='../../assets/libs/jquery-nice-select-1.1.0/js/prism.js'></script>
<script src='../../assets/libs/jquery-nice-select-1.1.0/gulpfile.js'></script>


   

    <script >
        $(document).ready(function(){
            $('select').niceSelect();
        });
    </script>

    <link href='../../assets/libs/jquery-nice-select-1.1.0/css/nice-select.css' rel='stylesheet'>
<link rel="stylesheet" href="../../assets/libs/animate-3.7.2/animate.min.css"/>


    -->