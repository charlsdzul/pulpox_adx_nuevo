<script>
    function asignarImagenes(datos_anuncio){
        let image_url = "<?php echo base_url()?>";
        console.log(datos_anuncio);
        for (let index = 1; index < 11; index++) {
        if(datos_anuncio[`img_${index}`]!=''){
            $(`#img-${index}`).attr('src', image_url+datos_anuncio[`img_${index}`]+ "?timestamp=" + new Date().getTime())
            $(`#panel-image--div_icon-${index}`).hide()
            $(`#panel-image-${index}`).after(`    
            <div id='panel-image--div-delete-${index}' class='panel-image--div-delete'> 
                <i id='icon-delete-${index}' class="material-icons icon-delete" onclick=eliminarImagen(this,"${datos_anuncio.public_id}") data-numero-imagen='${index}'>delete_forever</i>
            </div>
            `)
        }    
        }
    } 
</script>