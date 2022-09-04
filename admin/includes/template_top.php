<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<meta name="robots" content="noindex,nofollow">
<title><?php echo TITLE; ?></title>
<base href="<?php echo HTTP_SERVER . DIR_WS_ADMIN; ?>" />
<!--[if IE]><script type="text/javascript" src="<?php echo tep_catalog_href_link('ext/flot/excanvas.min.js'); ?>"></script><![endif]-->
<link rel="stylesheet" type="text/css" href="<?php echo tep_catalog_href_link('ext/jquery/ui/redmond/jquery-ui-1.8.6.css'); ?>">
<script type="text/javascript" src="<?php echo tep_catalog_href_link('ext/jquery/jquery-1.4.2.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo tep_catalog_href_link('ext/jquery/ui/jquery-ui-1.8.6.min.js'); ?>"></script>

<?php
  if (tep_not_null(JQUERY_DATEPICKER_I18N_CODE)) {
?>
<script type="text/javascript" src="<?php echo tep_catalog_href_link('ext/jquery/ui/i18n/jquery.ui.datepicker-' . JQUERY_DATEPICKER_I18N_CODE . '.js'); ?>"></script>
<script type="text/javascript">
$.datepicker.setDefaults($.datepicker.regional['<?php echo JQUERY_DATEPICKER_I18N_CODE; ?>']);
</script>
<?php
  }
?>

<script type="text/javascript" src="<?php echo tep_catalog_href_link('ext/flot/jquery.flot.js'); ?>"></script>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script type="text/javascript" src="includes/general.js"></script>

   <?php //patrocine.es ?>
  <script language="javascript"><!--
function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=450,height=600,screenX=150,screenY=150,top=150,left=150')
}
//--></script>














 <script language="javascript"><!--
function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=450,height=600,screenX=150,screenY=150,top=150,left=150')
}
//--></script>









   <script language="javascript" src="includes/general.js"></script>
<script type="text/javascript" src="./ckeditor/ckeditor.js"></script>







 <?php

  if ($pcla){


}

 if ($comprobar){ ?>
<SCRIPT>
<!--
function sf(){document.fh.codigobarras_inv.focus();}
function clk(url,oi,cad,ct,cd,sg){if(document.images){var e = window.encodeURIComponent ? encodeURIComponent : escape;var u="";var oi_param="";var cad_param="";if (url) u="&url="+e(url.replace(/#.*/,"")).replace(/\+/g,"%2B");if (oi) oi_param="&oi="+e(oi);if (cad) cad_param="&cad="+e(cad);new Image().src="/url?sa=T"+oi_param+cad_param+"&ct="+e(ct)+"&cd="+e(cd)+u+"&ei=yzHqRPLoGpy2QP6B_X0"+sg;}return true;}
// -->
</SCRIPT>
   <?php }else if ($palabraclave){


         ?>

<SCRIPT>
<!--
function sf(){document.f.palabraclave.focus();}
function clk(url,oi,cad,ct,cd,sg){if(document.images){var e = window.encodeURIComponent ? encodeURIComponent : escape;var u="";var oi_param="";var cad_param="";if (url) u="&url="+e(url.replace(/#.*/,"")).replace(/\+/g,"%2B");if (oi) oi_param="&oi="+e(oi);if (cad) cad_param="&cad="+e(cad);new Image().src="/url?sa=T"+oi_param+cad_param+"&ct="+e(ct)+"&cd="+e(cd)+u+"&ei=yzHqRPLoGpy2QP6B_X0"+sg;}return true;}
// -->
</SCRIPT>

   <?php }else if ($pcla){


         ?>

<SCRIPT>
<!--
function sf(){document.f.palabraclave.focus();}
function clk(url,oi,cad,ct,cd,sg){if(document.images){var e = window.encodeURIComponent ? encodeURIComponent : escape;var u="";var oi_param="";var cad_param="";if (url) u="&url="+e(url.replace(/#.*/,"")).replace(/\+/g,"%2B");if (oi) oi_param="&oi="+e(oi);if (cad) cad_param="&cad="+e(cad);new Image().src="/url?sa=T"+oi_param+cad_param+"&ct="+e(ct)+"&cd="+e(cd)+u+"&ei=yzHqRPLoGpy2QP6B_X0"+sg;}return true;}
// -->
</SCRIPT>




      <?php
}else{
       ?>

<SCRIPT>
<!--
function sf(){document.f.codigobarras.focus();}
function clk(url,oi,cad,ct,cd,sg){if(document.images){var e = window.encodeURIComponent ? encodeURIComponent : escape;var u="";var oi_param="";var cad_param="";if (url) u="&url="+e(url.replace(/#.*/,"")).replace(/\+/g,"%2B");if (oi) oi_param="&oi="+e(oi);if (cad) cad_param="&cad="+e(cad);new Image().src="/url?sa=T"+oi_param+cad_param+"&ct="+e(ct)+"&cd="+e(cd)+u+"&ei=yzHqRPLoGpy2QP6B_X0"+sg;}return true;}
// -->
</SCRIPT>

     <?php } ?>
























<style type="text/css">
.Subtitle {
  font-family: Verdana, Arial, Helvetica, sans-serif;
  font-size: 11px;
  font-weight: bold;
  color: #FF6600;
}
</style>
































       <?php //patrocine.es ?>





</head>
<body>





<?php
  if (tep_session_is_registered('admin')) {
     require(DIR_WS_INCLUDES . 'header.php');


              $permiso_boxes_values = mysql_query("select * from " . 'administrators' . " where admin_id = '" . $login_id . "' and admin_boxes = '" . 1 . "'");
             if ($permiso_boxes = mysql_fetch_array($permiso_boxes_values)){
     
    include(DIR_WS_INCLUDES . 'column_left.php');
      }else{}
    
    
  } else {
?>

<style>
#contentText {
  margin-left: 0;
}
</style>

<?php
  }
?>


   
   
   
   
   <?php

              $permiso_boxes_values = mysql_query("select * from " . 'administrators' . " where admin_id = '" . $login_id . "' and admin_boxes = '" . 1 . "'");
             if ($permiso_boxes = mysql_fetch_array($permiso_boxes_values)){

          ?>

    <div id="contentText">
            <?php

      }else{}

       ?>

