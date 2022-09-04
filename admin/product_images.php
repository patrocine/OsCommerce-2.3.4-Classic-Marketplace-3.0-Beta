<?php


               $products_images_values = mysql_query("select * from " . TABLE_PRODUCTS . " where products_id = '" . $products_id_stock . "'");
             $products_images= mysql_fetch_array($products_images_values);
               $products_images_name_values = mysql_query("select * from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . $products_id_stock . "'");
             $products_images_name = mysql_fetch_array($products_images_name_values);


                    $ref_fabricante_values = mysql_query("select * from " . 'proveedor' . " where proveedor_id = '" . $products_images['codigo_proveedor'] . "'");
               $ref_fabricante= mysql_fetch_array($ref_fabricante_values);

      if ($ref_fabricante['proveedor_ruta_images']){

 if (getimagesize($ref_fabricante['proveedor_ruta_images']. $products_images['products_image'])) {



} else {



  }else{

           // si en la imagan el nombre empieza por http:// pues elimina la ruta actual para que la imagen del producto siempre se vea.
   if (ereg("^http://", $products_images['products_image']) ) {


}else{

        if (@getimagesize(DIR_WS_IMAGES . $products_images['products_image'])) {


        
   }else{



                 
                 
                 



       } // si existe images
    
    
    
    
    

     }

   } // fin ref_fabricante


}



 
  ?>
