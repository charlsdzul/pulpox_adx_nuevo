<body  class=' row justify-content-center '>
<div class="mt-2 col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10 ">  
  <table id="mis-anuncios-table" class="table table-striped table-bordered table-sm table-hover" cellspacing="0" width="100%">
    <thead class='pulpox-table--thead'>
      <tr>        
        <th class="th-sm">#</th>        
        <th class="th-sm">Título</th>
        <th class="th-sm">Lugar</th> 
        <th class="th-sm">Sección</th>
        <th class="th-sm">ID</th>
        <th class="th-sm">Creado</th>
        <th class="th-sm">Estatus</th>
        
      </tr>
    </thead>
    <tbody class='pulpox-table-tbody'>
    </tbody>
    <tfoot>
      <tr>
        <th class="th-sm">#</th>        
        <th class="th-sm">Título</th>
        <th class="th-sm">Lugar</th> 
        <th class="th-sm">Sección</th>
        <th class="th-sm">ID</th>
        <th class="th-sm">Creado</th>
        <th class="th-sm">Estatus</th>
      </tr>
    </tfoot>
  </table>
</div>

<script src="<?php echo base_url();?>assets/util/estados.js"></script>
<script src="<?php echo base_url();?>assets/util/ciudades_misanuncios.js"></script>
<script src="<?php echo base_url();?>assets/util/secciones.js"></script>
<script src="<?php echo base_url();?>assets/util/apartados_misanuncios.js"></script> 

<script> 

  mis_anuncios = <?php echo json_encode($misanuncios); ?>;
  let data;

      for (let index = 0; index < mis_anuncios.length; index++) {

         $.each(estados, function(key, value){
          if(mis_anuncios[index].estado == key){
            estado = value; 
            return  '';       
          }     
        });

        $.each(ciudades, function(key, value){
          if(mis_anuncios[index].ciudad == key){
            ciudad = value; 
            return  '';       
          }     
        });

        $.each(secciones, function(key, value){
          if(mis_anuncios[index].seccion == key){
            seccion = value; 
            return  '';       
          }     
        });

        $.each(apartados, function(key, value){
          if(mis_anuncios[index].apartado == key){
            apartado = value; 
            return  '';       
          }     
        });

        mis_anuncios[index].estatus==0 ? estatus = 'ACTIVO' : '';
        mis_anuncios[index].estatus==1 ? estatus = 'INACTIVO' : '';
        mis_anuncios[index].estatus==2 ? estatus = 'ELIMINADO' : '';

        data += `<tr> 
        <td>${index+1}</td>        
        <td><a class='pulpox-table--titulo' href= '<?php echo base_url() . 'index.php/misanuncios/ver/';?>${mis_anuncios[index].public_id}'>${mis_anuncios[index].titulo}</a></td>
        <td>${estado} / ${ciudad}</td>
        <td>${seccion} / ${apartado}</td>
        <td>${mis_anuncios[index].public_id}</td>
        <td>${mis_anuncios[index].creado}</td>
        <td>${estatus}</td>
      <!--  <td>
          <a href= '<?php echo base_url() . 'index.php/misanuncios/ver/';?>${mis_anuncios[index].public_id}'>  
            <img src="<?php echo base_url()?>assets/icons/visibility-24px.svg" id='anuncio-nuevo-preview_icon--lugar' class='anuncio-nuevo-preview_icon'>
          </a>
        </td>-->
       
        </tr>
       
        
        `;  
            
      }  

      $('.pulpox-table-tbody').append(data); 

  $(document).ready(function () {
    $('#mis-anuncios-table').DataTable();
    $('.dataTables_length').addClass('bs-select');
  });







</script>


</body>
