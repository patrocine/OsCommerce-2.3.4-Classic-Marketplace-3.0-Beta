<?php
/*
  $Id: compbuild.php,v 2.5.5 2008/10/19 23:03:53 10c $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/


require('includes/application_top.php');

// check for action variable if set on reload
switch ($_GET['action']) {
  case 'add_products' :
    foreach ($_POST['qty'] as $key => $value) {
      $products_qty[$key]=$value;
    }
    foreach ($_POST['products_id'] as $key => $value) {
      $products_count[$key]=$value;
    }
    for ($i = 0, $n = count($products_count); $i < $n; $i++) {
      $cart->add_cart($products_count[$i], $cart->get_quantity(tep_get_uprid($products_count[$i], $_POST['id']))+$products_qty[$i], $_POST['id']);
    }

    tep_redirect(tep_href_link($goto,''));
  break;
}

// get info from OSC currency tables
$currency_symb_query = tep_db_query("select symbol_left, symbol_right, decimal_point, thousands_point from currencies where code='".$currency."'");
$currency_symb = tep_db_fetch_array($currency_symb_query);

// check if the compbuild tables exist
// if tables exist, get all category options into an array, otherwise bomb with error
if (mysql_num_rows(mysql_query("SHOW TABLES LIKE 'compbuild_options'"))==1) {

// GET BUILDER OPTIONS AND CATEGORIES -------------------------------------
// get builder options
  $cbcomp_query = tep_db_query("select * from `compbuild_options`");
  while ($cbcomp = tep_db_fetch_array($cbcomp_query)){
    $pc_system_assembly= $cbcomp['pc_system_assembly'];
    $pc_assembly_osccat= $cbcomp['pc_assembly_osccat'];
    $pc_use_dependence= $cbcomp['pc_use_dependence'];
    $pc_use_software= $cbcomp['pc_use_software'];
  }
// get builder categories - insert them into a perfect sequential array (i.e. 1,2,3,4,etc..)
  $pcount=0;
  $bcomp_query = tep_db_query("select * from `compbuild_categories` ORDER BY pc_category_id");
  while ($bcomp = tep_db_fetch_array($bcomp_query)){
    $pcshadowid[$pcount] = $bcomp['pc_category_id'];
    $pcid[$pcount]= $pcount+1;
    $pccat[$pcount]= $bcomp['pc_category_name'];
    $pcdcat[$pcount]= $bcomp['pc_depends_category_id'];
    $pcimg[$pcount]= $bcomp['pc_category_image'];
    $osccat[$pcount]= $bcomp['osc_category_id'];
    $pcount++;
  }
// arrange the dependency ids to match the new (phantom) category ids
  foreach($pcid as $new_id) {
    if ($pcdcat[$new_id] < 1) {
      $pcdcat[$new_id] = 0;
    } else {
      $x=0;
      for($x;$x<$pcount;$x++) { 
        if ($pcshadowid[$x] == $pcdcat[$new_id]) {
          $pcdcat[$new_id] = $pcid[$x];
        }
      }
    }
  }
  unset($pcshadowid);
} else {
  echo "<table bgcolor=\"red\"><tr><td><font color=\"yellow\"><B>Tables may not exist, or Database Error</B></font></td></tr></table>";
}

global $assemb_id;
$assemb_id=$pcount;
require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_BUILDER);
$breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_BUILDER, '', 'NONSSL'));
  require(DIR_WS_INCLUDES . 'template_top.php');
?>

<h1><?php echo HEADING_TITLE; ?></h1>



<?php require(FILENAME_BUILDER2); ?>

<div style="OVERFLOW: auto; display: none; position: absolute; border: solid 2; background-color: White; z-index: auto;" id=oFrame></div>
<div align=center>
  <span id=loadstr><br><br><?php echo TEXT_LOADING_PLEASE_WAIT; ?><img src="build/pbar.gif" width="71" height="11" alt="" border="0"></span>
  <table width="100%">
    <tr>
      <td width="100%" class="main" align="center">

<script language="JavaScript">
// MAXIMUM BUILDER CATEGORIES
var tlines=50;
var currency = "<?php echo $currency;?>";
var currency_left="<?php echo $currency_symb['symbol_left'];?>";
var currency_right="<?php echo $currency_symb['symbol_right'];?>";
if (currency_left=="&euro;"||currency_left=="&#8364;"){
  currency_left=" ";
}
if (currency_right=="&euro;"||currency_right=="&#8364;"){
  currency_right=" ";
}
l = new Array(tlines);
for (i=0;i<tlines;i++){
  l[i] = new Array(100);
}

// DEFINE SOME FUNCTIONS WE NEED
//--------------------- Adding Product To The List ------------------------- recoded by meisterbartsch
// ALTERED BY TENCENTS TO INCLUDE IMAGESAND DESCRIPTIONS
//
function add_product(ipid,ipimage,ipname,ipinfo,iprice,irecid,row){
  iprice2 = iprice;
  iprice = decimal_substitution(iprice,'calc');
  row++;
  var enable=false;
  if (ipid=='-1') {
    enable=true;
    ipid="";
  }
  ipname = ipname.replace(/:inc:/gi, '"')
  ipname = ipname.replace(/:tag:/gi, '\'')
  var prods_row = document.getElementById("prod_table").rows[row];
  var title_cell=prods_row.cells[1].childNodes[0].childNodes[0].childNodes[0].cells[0];
  var price_cell=prods_row.cells[2];
  if (!ipname) {
    title_cell.innerHTML=default_line;
    price_cell.innerHTML="";
    price[row] = 0;
    product[row] = "0";
    description[row] = "";
    image[row] = "";
    pid[row] = "";
    recid[row] = "";
//
// NOTE: SOME CODE MUST BE PUT HERE TO SET products_id[row] to '-1'. SEE THE print_deselect() FUNCTION IN prduct_list.php.
// THIS IS PART OF THE REMOVALS ISSUE WHICH HAS ALREADY BEEN FIXED FOR INDIVIDUAL COMPONENTS.
// FOR EXAMPLE: RAM DEPENDS ON MB, MB DEPENDS ON CPU. IF YOU HAVE ALL THREE COMPONENTS SELECTED THEN DESELECT CPU, YOU WILL SEE THAT
// MB AND RAM ARE CLEARED AUTOMATICALLY - NOW CLICK ADD TO CART AND YOU'LL SEE THAT MB AND RAM ARE IN THE CART.
// NOW TRY THE SAME THING, MANUALLY DESELECTING INDIVIDUAL COMPONENTS - THEY DONT MAKE IT TO THE CART :)
//
  } else {

         <?php

                         $ref_fabricante_values = mysql_query("select * from " . 'proveedor' . " where proveedor_id = '" . 653762 . "'");
               $ref_fabricante= mysql_fetch_array($ref_fabricante_values);

      if ($ref_fabricante['proveedor_ruta_images']){
    $rute_image = $ref_fabricante['proveedor_ruta_images']. '"+ipimage+"';
}

            ?>

    title_cell.innerHTML="<img align='left' height='50' hspace='5' width='50' src='<?php echo $rute_image; ?>'>"+"<u><font color='blue' size='2'>"+ipname+"</font></u><br><font size='1'>"+ipinfo+"</font>";
    price_cell.innerHTML=currency_left+" "+iprice2+" "+currency_right+"&nbsp;&nbsp;";
    price[row]=iprice;
    product[row]=ipname;
    description[row]=ipinfo;
    image[row]=ipimage;
    pid[row]=ipid;
    recid[row]=irecid;
  }
  if (!enable) document.getElementById("oFrame").style.display="none";
  calc_total_tmp(document.mainform);
}

//----------------- Format float number (2 digits after dot) --------------- CHANGED BY TENCENTS FOR THE '.00' PROBLEM
function formatnumber(num,num_after_dot){
  if (!num_after_dot) num_after_dot=2;
  if (num<0.05) num=0;
  var snum = (String) (num);
  var is_dot_ok=snum.indexOf('.')
  if (!(is_dot_ok==-1)) {
    snum = snum.substr(0,is_dot_ok+num_after_dot+1);
    if ((snum.length-is_dot_ok)==2) {
      snum=snum+"0"
    } else {
      if ((snum.length-is_dot_ok)==1) {
        snum=snum+"00"
      }
    }
  } else {
    snum=snum+".00"
  }
  return decimal_substitution(snum,'display');
}

//----------------- Substitute Decimal signs for display and calculation --------------- by meisterbartsch
function decimal_substitution(num,direction){
  switch (direction){
    case 'calc':
      num = num.replace("<?php echo $currency_symb['thousands_point'];?>","#|#");
      num = num.replace("<?php echo $currency_symb['thousands_point'];?>","#|#");
      num = num.replace("<?php echo $currency_symb['decimal_point'];?>",".");
      num = num.replace("#|#",",");
    break;
    case 'display':
      num = num.replace(",","#|#");
      num = num.replace(".","<?php echo $currency_symb['decimal_point'];?>");
      num = num.replace("#|#","<?php echo $currency_symb['thousands_point'];?>");
      num = num.replace("#|#","<?php echo $currency_symb['thousands_point'];?>");
    break;
  }
  return num;
}
</script>

<?php
$output = $pcount;
for ($ib = 0; $ib < $output; $ib++) {
  $cat = $osccat[$ib];
  echo $textshow[$cat];
}
echo tep_draw_form('mainform', tep_href_link(FILENAME_BUILDER, tep_get_all_get_params(array('action')) . 'action=add_products'));
?>
          <table border='0' cellspacing='0' cellpadding='0' width='100%' style='border-collapse: collapse' bordercolor='#628AC5'>
            <tr width="100%" height="40">
              <td class="builder_heading" align="center" width='23%'><?php echo TEXT_PART_TYPE; ?></td>
              <td class="builder_heading" align="center" width='54%'><?php echo TEXT_PART_NAME; ?></td>
              <td class="builder_heading" align="center" width='15%'><?php echo TEXT_PART_PRICE; ?></td>
              <td class="builder_heading" align="center" width='8%'><?php echo TEXT_PART_QUANTITY; ?></td>
            </tr>
          </table>
          <table id='prod_table' name='prod_table' border='0' cellspacing='0' cellpadding='0' width='100%' bordercolor='#999999'>
            <tr width="100%" height="0">
              <td width='23%'></td>
              <td width='54%'></td>
              <td width='18%'></td>
              <td width='5%'></td>
            </tr>

<script language="JavaScript">
var text_please_wait="<?php echo TEXT_LOADING_PLEASE_WAIT; ?>";
var note1=" <font color=#FF0000><b><?php echo TEXT_PLEASE_SELECT_CPU; ?></b></font>";
var note2=" <font color=#FF0000><b><?php echo TEXT_PLEASE_SELECT_MOTHER_BOARD; ?></b></font>";
var note3=" <font color=#FF0000><b><?php echo TEXT_PLEASE_SELECT_MOTHER_BOARD; ?></b></font>";
var text_no_items="<?php echo TEXT_NO_ITEMS; ?>";
var text_deselect_items="<?php echo TEXT_DESELECT_ITEM; ?>";
document.getElementById("loadstr").innerHTML="";

<?php
$c_java = 0;
$output = $pcount;
for ($ib = 0; $ib < $output; $ib++) {
  $cat = $pccat[$ib];
  $picname = $pcimg[$ib];
?>
  print_field('<?php echo $cat;?>','<?php echo $c_java;?>','<?php echo $ib;?>','<?php echo $picname;?>',<?php echo $assemb_id;?>);
<?php
  $c_java++;
}

// ASSEMBLY FEE CHECK - this code will change in future to allow a flat assembly fee to be applied with every build (admin selectable)
if ($pc_system_assembly != "0") { 
?>
  print_field('<?php echo ASSEMBLY; ?>','<?php echo $c_java;?>','<?php echo $ib;?>','assembly.gif',<?php echo $assemb_id;?>);
<?php
// reserved for future - default assembly id - leaving it here so I don't forget
  if ($ADD_ASSEMBLY == 1) {
    echo '&nbsp;&nbsp;&nbsp;&nbsp;'.$pc_system_assembly ; // this variable will need to change to a new builder option.
  }
} else {
// take it off the list if assembly is disabled
  $c_java--;
}
?>
</script>

            </td>
          </tr>
        </table>

        <table height="40" width="100%" id='prod_table' name='prod_table' border='0' callpadding='0' cellspacing='0' style='border-collapse: collapse' bordercolor='#628AC5'>
          <input type="hidden" name="select1" onchange="calc_subtotal(mainform);calc_total(mainform);" size="4" multiple style="width=330">
          <input type="hidden" name="sum">
          <input type="hidden" name="totprint">
          <tr onClick="oFrame.style.display='none'">
            <td width='80%' class='builder_footing' align='right'><?php echo TEXT_TOTAL_PRICE . "&nbsp;:&nbsp;" . $currency_symb['symbol_left'] . "&nbsp;"; ?></td>
            <td class='builder_footing' align='left'><input type=text size=13 name="totsum" readonly style="font: bold 10pt;"></td>
            <td class='builder_footing' align='left'><?php echo "&nbsp;" . $currency_symb['symbol_right']; ?></td>
          </tr>
        </table>
      </td>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxClean">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="3">
              <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <tr>
                  <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                  <td align="center"><input type="button" value="<?php echo TEXT_PRINT_PREVIEW; ?>" onClick="mainform_onsubmit(mainform,1,<?php echo $c_java;?>);" class="button">
                  <td align="right"><input type="button" value="<?php echo TEXT_MAKE_ORDER; ?>" onClick="mainform_onsubmit(mainform,2,<?php echo $c_java;?>);" class="button">
<?php // echo tep_image_submit('button_submit.gif', IMAGE_BUTTON_SUBMIT); ?></td>
                  <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                </tr>
              <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      </tr>
    </table>
    <input type=hidden name="price">
    <input type=hidden name="product">
    <input type=hidden name="description">
    <input type=hidden name="image">
    <input type=hidden name="pid">
    <input type=hidden name="recid">
    <input type=hidden name="ammount">
    </form>
</div>
</tr></tr></tr>
</table></td>
<!-- body_text_eof //-->
<td width="<?php echo BOX_WIDTH; ?>" valign="top">
  <table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="0" cellpadding="2">
<!-- right_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_right.php'); ?>
<!-- right_navigation_eof //-->
  </table>
</td>
</tr>
</table>
<!-- body_eof //-->
<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
