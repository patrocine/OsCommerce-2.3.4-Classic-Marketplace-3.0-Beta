<?php
/*
  $Id: stats_products_viewed.php,v 1.29 2003/06/29 22:50:52 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/



  require('includes/application_top.php');
  
   require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

include(DIR_WS_CLASSES . 'order.php');


  $sonido = $_GET['sonido'];
 $palabraclave = $_POST['palabraclave'];
 $donde_esta_gloval = $_GET['donde_esta_gloval'];


  if ($login_id_remoto){
    $log_id =  $login_id_remoto;
}else{

    $log_id = $login_id;

}


    ?>
       <?php   require(DIR_WS_INCLUDES . 'template_top.php');?>
    <?php
            
            
            
if ($sonido){
    ?>
    
   <head>
<bgsound src="sonido/COCKGN-1.mid" loop="1">
</head>

    <?php
     }
  
 if (ereg ("^[A-Z]", $palabraclave, $mi_array)) {
   echo "OKS" . $sonido; // coincide. Lo mostramos en orden inverso porque somos asi : )
   


          $donde_esta_gloval = $palabraclave;
?>


               <script type="text/javascript">

    var pagina = '<?php echo $PHP_SELF, '?donde_esta_gloval='.$donde_esta_gloval.'&sonido=ok'; ?>';
    var segundos = 0;

    function redireccion() {

        document.location.href=pagina;

    }

    setTimeout("redireccion()",segundos);

     </script>



<?php


   



  //   tep_redirect(tep_href_link('donde_esta_tiendas.php', 'donde_esta_gloval='.$donde_esta_gloval.'&sonido=ok'));
   
} else {



    echo "Donde Esta "; // no coincide



      if ($palabraclave){


                           //    $login_id        solo con cuenta especifica
                         //      $log_id          solo hay que cambiarse de tienda


         // Situacion donde esta el producto en el almacen
         // cada tienda tiene su propio sistame de codi         /(
    $donde_esta_c_values = mysql_query("select * from " . 'products_donde_esta' . " where  products_id = '" . $palabraclave . "' and login_id = '" . $log_id . "' or products_model = '" . $palabraclave . "' and login_id = '" . $log_id . "'");
   if  ($donde_esta_c= mysql_fetch_array($donde_esta_c_values)){



             $sql_status_update_array = array('donde_esta' => $donde_esta_gloval);
            tep_db_perform('products_donde_esta', $sql_status_update_array, 'update', " products_id='" . $palabraclave . "' and login_id= '" . $log_id . "' or products_model = '" . $palabraclave . "' and login_id = '" . $log_id . "'");

                   ECHO 'PRODUCTO ACTUALIZADO'.$log_id.'/'.$palabraclave;

?>


  <head>
<bgsound src="sonido/gunshot.mid" loop="1">
</head>


<?php

}else{
                              // solo si el producto existe en la base de datos inserta el codigo.
       $confirmar_producto_values = mysql_query("select * from " . TABLE_PRODUCTS . " where products_id = '" . $palabraclave . "'");
    IF ($confirmar_producto = mysql_fetch_array($confirmar_producto_values)){

    ECHO 'PRODUCTO INSERTADO';

           $Query = "INSERT INTO " . 'products_donde_esta' . " set
              products_id = '" . $palabraclave . "',
              donde_esta = '" . $donde_esta_gloval . "',
              products_model = '" . $confirmar_producto["products_model"] . "',
              login_id = '" . $log_id . "'";
              tep_db_query($Query);




?>


  <head>
<bgsound src="sonido/gunshot.mid" loop="1">
</head>


<?php


         }



  }

}

}





















  
  
  
?>


 <SCRIPT>
<!--
function sf(){document.codigo_barras_c.palabraclave.focus();}
function clk(url,oi,cad,ct,cd,sg){if(document.images){var e = window.encodeURIComponent ? encodeURIComponent : escape;var u="";var oi_param="";var cad_param="";if (url) u="&url="+e(url.replace(/#.*/,"")).replace(/\+/g,"%2B");if (oi) oi_param="&oi="+e(oi);if (cad) cad_param="&cad="+e(cad);new Image().src="/url?sa=T"+oi_param+cad_param+"&ct="+e(ct)+"&cd="+e(cd)+u+"&ei=yzHqRPLoGpy2QP6B_X0"+sg;}return true;}
// -->
</SCRIPT>

<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" src="includes/general.js"></script>






  <script language="javascript"><!--
function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=450,height=600,screenX=150,screenY=150,top=150,left=150')
}
//--></script>


</head>


















           <BODY topMargin=3 onload=sf()>
      
      

 <form name="codigo_barras_c" method="post" action="<?php echo $PHP_SELF.'?oID='.$oID.'&action=edit&action_cod=ok&donde_esta_gloval='.$donde_esta_gloval; ?>">

  </p>
  <p style="margin-top: 0; margin-bottom: 0"><b><font face="Verdana" size="1">
  Búsquedas</font></b></p>
  <p style="margin-top: 0; margin-bottom: 0">
    <font size="1" face="Verdana"><b>
       <?php
      // seleccionado busca todos los productos que esten activados o desactivados.

       ?>
<input type="checkbox" name="stock_disponible" value="ON">
  <input name="palabraclave" type="text" value="" size="20" style="font-family: Verdana; font-size: 8pt; color: #000080; border-style: outset; border-width: 3; background-color: #FFFF00">
     <input type="hidden" name="add_product">
    <input type="submit" name="Submit" value="Buscar" style="color: #FFFFFF; font-family: ve; font-size: 8pt; background-color: #008080">
    </b></font>
  </p>
</form>







<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
