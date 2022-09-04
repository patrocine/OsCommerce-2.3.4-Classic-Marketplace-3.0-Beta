<?php
/*
  $Id: prduct_list.php,v 2.5.5 2008/10/19 23:03:53 10c $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

require('includes/application_top.php');

// GET CURRENCY STUFF
$currency_symb_query = tep_db_query("select symbol_left, symbol_right, decimal_point, thousands_point from " . TABLE_CURRENCIES . " where code='".$currency."'");
$currency_symb = tep_db_fetch_array($currency_symb_query);

// GET BUILDER OPTIONS AND CATEGORIES ------------------------------------------
if( mysql_num_rows(mysql_query("SHOW TABLES LIKE '" . TABLE_BUILDER_OPTIONS . "'"))==1) {

// get builder options
  $cbcomp_query = tep_db_query("select * from " . TABLE_BUILDER_OPTIONS);
  while ($cbcomp = tep_db_fetch_array($cbcomp_query)){
    $pc_system_assembly= $cbcomp['pc_system_assembly'];
    $pc_assembly_osccat= $cbcomp['pc_assembly_osccat'];
    $pc_use_dependence= $cbcomp['pc_use_dependence'];
    $pc_use_software= $cbcomp['pc_use_software'];
  }

// get builder categories - insert them into a perfect sequential array (i.e. 1,2,3,4,etc..)
  $pcount=0;
  $bcomp_query = tep_db_query("select * from " . TABLE_BUILDER_CATEGORIES . " ORDER BY pc_category_id");
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
  exit();
}

// LANGUAGE FILE ---
require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_BUILDER);

// SHORT DESCRIPTION LENGTH - DISPLAYED IN POPUP LIST AND SELECTED COMPONENTS WHILE BUILDING
$short_description_length = 50;

// GET CATEGORY DESCRIPTIONS ----------------------------------
$category_query = tep_db_query("select categories_id, categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " where language_id='".$languages_id."'");
while ($categories=tep_db_fetch_array($category_query)){
  $category_names[$categories['categories_id']]=$categories['categories_name'];
}
$output = $pcount;
for ($ib = 0; $ib < $output; $ib++) {
  $cat = $osccat[$ib]; //
  if ($_GET['row'] == $ib) $temp = $cat;
}
$acount=0;

// CHECK IF WE MUST USE DEPENDENCIES (selected in admin)
if ($pc_use_dependence==1){
// the very next two sql's address the same database - can these not be done in one sweep
  if ($pcid[$_GET['row']] != $pcdcat[$_GET['row']] && $pcdcat[$_GET['row']] != 0) {
    $strDependences ="(";
    $d_query = tep_db_query("select product2_id from " . TABLE_BUILDER_DEPENDENCES . " where product1_id='".$_GET['idp'.$pcdcat[$_GET['row']]]."'");
    while ($depends=tep_db_fetch_array($d_query)) {
      $strDependences .=", ".$depends['product2_id'];
    }
    $d_query = tep_db_query("select product1_id from " . TABLE_BUILDER_DEPENDENCES . " where product2_id='".$_GET['idp'.$pcdcat[$_GET['row']]]."'");
    while ($depends=tep_db_fetch_array($d_query)) {
      $strDependences .=", ".$depends['product1_id'];
    }
    $strDependences .= ")";
    $strDependences = substr_replace($strDependences,'',1,1);
    if ($strDependences != "(") {
      $strQueryProducts= "select pc.products_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " pc, " . TABLE_PRODUCTS . " p where p.products_id = pc.products_id and p.products_status = '1' and p.products_quantity > 0 and pc.categories_id='".$temp."' and pc.products_id in ". $strDependences . " order by p.products_price";
    } else {
      $strQueryProducts= "select pc.products_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " pc, " . TABLE_PRODUCTS . " p where p.products_id = pc.products_id and p.products_status = '1' and p.products_quantity > 0 and pc.categories_id='".$temp."' order by p.products_price";
    }
  } else {
    $strQueryProducts= "select pc.products_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " pc, " . TABLE_PRODUCTS . " p where p.products_id = pc.products_id and p.products_status = '1' and p.products_quantity > 0 and pc.categories_id='".$temp."' order by p.products_price";
  }
} else {
  $strQueryProducts= "select pc.products_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " pc, " . TABLE_PRODUCTS . " p where p.products_id = pc.products_id and p.products_status = '1' and p.products_quantity > 0 and pc.categories_id='".$temp."' order by p.products_price";
}
$a_query = tep_db_query("select categories_id from " . TABLE_CATEGORIES . " where parent_id='".$temp."'");
while ($acat=tep_db_fetch_array($a_query)){
  $acategory[$temp][$acount]=$acat['categories_id'];
  $acount++;
}
$count1=1;
$count2=0;

// SHOW AVAILABLE PRODUCTS IN POPUP ----------------------------------------------
// POPUP BOX HEADER ---
$textshow[$temp].="print_deselect('"."<font color=\"red\">".TEXT_DESELECT_ITEM."</font>"."','".$_GET['row']."');\n";
$textshow[$temp].="print_title('".$category_names[$temp] . TEXT_SELECT_ITEM ."'); \n";

// PRODUCTS WITHOUT SUB CATEGORIES ---
$c_query = tep_db_query($strQueryProducts);
while ($count = tep_db_fetch_array($c_query)) {
  $a_query = tep_db_query("select pd.products_name, left(pd.products_description,50) as products_description from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p where p.products_id = pd.products_id and p.products_status = '1' and p.products_quantity > 0 and (pd.products_id='".$count['products_id']."' AND pd.language_id='".$languages_id."')");
  while ($aount = tep_db_fetch_array($a_query)) {
    $product ['name'] = addslashes($aount['products_name']);
// CLEANUP THE DESCRIPTION AND CUT TO SIZE
      $temp_description = str_replace("\r", "", $aount['products_description']);
      $temp_description = str_replace("\n", "", $temp_description);
      $temp_description = strip_tags(addslashes($temp_description));
      if (strlen($temp_description) >= $short_description_length) {
        $temp_description = substr($temp_description,0,$short_description_length) . "...";
      }
      $product ['description'] = $temp_description;
    $product ['id']= $count['products_id'];
    if (DISPLAY_PRICE_WITH_TAX) {
      $b_query = tep_db_query("select codigo_proveedor, products_price, products_image, products_tax_class_id from " . TABLE_PRODUCTS . " where products_status = '1' and products_quantity > 0 and products_id='".$count['products_id']."'");
    } else {
      $b_query = tep_db_query("select codigo_proveedor, products_price, products_image from " . TABLE_PRODUCTS . " where products_status = '1' and products_quantity > 0 and products_id='".$count['products_id']."'");
    }
    $temps=tep_db_fetch_array($b_query);
    $product ['price'] = '&nbsp;'. $currencies->display_price($temps['products_price'],tep_get_tax_rate($temps['products_tax_class_id'])).'&nbsp;';
    $product ['image'] = $temps['products_image'];
    if (!$product ['image']) {
      $product ['image'] = 'no_product_image.gif';
    }
    $ccount++;
  }
  $textshow[$temp].= "print_line('".$count2."','".$product ['image']."','".$product ['name']."','".$product ['description']."','".$product ['price']."','".$product ['id']."','".$_GET['row']."'); \n";
  $count2++;
}

// PRODUCTS WITH SUBCATEGORIES ---
for ($f = 0, $z = $acount; $f < $z; $f++) {
  $textshow[$temp].="print_title('".$category_names[$acategory[$temp][$f]]. TEXT_SELECT_SUBCATEGORY . "'); \n";
  $count2++;
  if ($pc_use_dependence==1 && ($pcid[$_GET['row']] != $pcdcat[$_GET['row']]) && ($pcdcat[$_GET['row']] != 0)) {
    if ($strDependences != "(") {
	$c_query = tep_db_query($strQueryProducts2="select pc.products_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " pc, " . TABLE_PRODUCTS . " p where p.products_id = pc.products_id and p.products_status = '1' and p.products_quantity > 0 and pc.categories_id='".$acategory[$temp][$f]."' and pc.products_id in ". $strDependences . " order by p.products_price");
    } else {
	$c_query = tep_db_query($strQueryProducts2="select pc.products_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " pc, " . TABLE_PRODUCTS . " p where p.products_id = pc.products_id and p.products_status = '1' and p.products_quantity > 0 and pc.categories_id='".$acategory[$temp][$f]."' order by p.products_price");
    }
  } else {
    $c_query = tep_db_query($strQueryProducts2="select pc.products_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " pc, " . TABLE_PRODUCTS . " p where p.products_id = pc.products_id and p.products_status = '1' and p.products_quantity > 0 and pc.categories_id='".$acategory[$temp][$f]."' order by p.products_price");
  }
  while ($count = tep_db_fetch_array($c_query)) {
    $a_query = tep_db_query("select pd.products_name, left(pd.products_description,50) as products_description from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p where p.products_id = pd.products_id and p.products_status = '1' and p.products_quantity > 0 and (pd.products_id='".$count['products_id']."' AND pd.language_id='".$languages_id."')");
    while ($aount = tep_db_fetch_array($a_query)) {
      $product ['name'] = addslashes($aount['products_name']);
// CLEANUP THE DESCRIPTION AND CUT TO SIZE
      $temp_description = str_replace("\r", "", $aount['products_description']);
      $temp_description = str_replace("\n", "", $temp_description);
      $temp_description = strip_tags(addslashes($temp_description));
      if (strlen($temp_description) >= $short_description_length) {
        $temp_description = substr($temp_description,0,$short_description_length) . "...";
      }
      $product ['description'] = $temp_description;
      $product ['id']= $count['products_id'];
      if (DISPLAY_PRICE_WITH_TAX) {
        $b_query = tep_db_query("select codigo_proveedor, products_price, products_image, products_tax_class_id from " . TABLE_PRODUCTS . " where products_status = '1' and products_quantity > 0 and products_id='".$count['products_id']."'");
      } else {
        $b_query = tep_db_query("select codigo_proveedor, products_price, products_image from " . TABLE_PRODUCTS . " where products_status = '1' and products_quantity > 0 and products_id='".$count['products_id']."'");
      }
      $temps=tep_db_fetch_array($b_query);
      $product ['price'] = '&nbsp;'. $currencies->display_price($temps['products_price'],tep_get_tax_rate($temps['products_tax_class_id'])).'&nbsp;';
      $product ['image'] = $temps['products_image'];
      if (!$product ['image']) {
        $product ['image'] = 'no_product_image.gif';
      }
      $ccount++;
    }
    $textshow[$temp].= "print_line('".$count2."','".$product ['image']."','".$product ['name']."','".$product ['description']."','".$product ['price']."','".$product ['id']."','".$_GET['row']."'); \n";
    $count2++;
  }
}

// POPUP BOX FOOTER ---
$count1++;
if ($count2==0) {
  $textshow[$temp].="print_title('".TEXT_NO_ITEMS."'); \n";
} else {
  $textshow[$temp].="print_deselect('"."<font color=\"red\">".TEXT_DESELECT_ITEM."</font>"."','".$_GET['row']."');\n";
}

// DEFINE SOME FUNCTIONS WE NEED
?>
<html><head>
<style>TD,TH,BODY{font-family:Arial,Tahoma,Helvetica,sans-serif;font-size:9pt;}TH{background-color:#86A5D2;filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0,StartColorStr='#0086A5D2',EndColorStr='#C0FFFFFF');font-style:italic;border:1px solid Black;cursor:default;}.select_table{BORDER-COLLAPSE:collapse;border:1px ridge;background-color:#F5F5F5;}tr{cursor:hand;}BODY{overflow: auto;margin: 0 0 0 0;background-color: #F5F5F5;}</style>
<script language="JavaScript">

function print_line(pnum,pimage,pdesc,pinfo,pprice,precid,row){
  var currency_left="<?php echo $currency_symb['symbol_left'];?>";
  var currency_right="<?php echo $currency_symb['symbol_right'];?>";
  var pdesc2 = pdesc.replace(/:inc:/gi, '"')
  var currency_left="<?php echo $currency_symb['symbol_left'];?>";
  var currency_right="<?php echo $currency_symb['symbol_right'];?>";
  re2 = new RegExp ('\'', 'gi') ;
  pdesc = pdesc.replace(re2, ":tag:")
  pinfo = pinfo.replace(re2, "")
  pprice = pprice.replace(currency_left,"")
  pprice = pprice.replace(currency_right,"")
  pprice = pprice.replace("<?php echo $currency_symb['decimal_point'];?>",".")
// no calculation possible with thousands seperation, and millions - NB: DISPLAY FORMAT IS WRONG BUT THIS WILL BE FIXED LATER
<?php if ($currency_symb['thousands_point'] != "") {?>
  pprice = pprice.replace("<?php echo $currency_symb['thousands_point'];?>","")
// catering for millions - well its actually the other way round (left to right) - this takes care of the calc but the display format is wrong
  pprice = pprice.replace("<?php echo $currency_symb['thousands_point'];?>","")
<?php }



               $ref_fabricante_values = mysql_query("select * from " . 'proveedor' . " where proveedor_id = '" . $temps['codigo_proveedor'] . "'");
               $ref_fabricante= mysql_fetch_array($ref_fabricante_values);

      if ($ref_fabricante['proveedor_ruta_images']){
    $rute_image = $ref_fabricante['proveedor_ruta_images']. '"+pimage+"';
}


     // "+pimage+"
?>
// THE FOLLOWING LINE ALTERED BY TENCENTS TO INCLUDE PRODUCT IMAGE AND DESCRIPTION IN THE DROPDOWN LIST
  document.write ("<tr onclick=\"parent.document.mainform.elements['products_id["+row+"]'].value='"+precid+"';parent.add_product('"+pnum+"','"+pimage+"','"+pdesc+"','"+pinfo+"','"+pprice+"','"+precid+"','"+row+"');\" onmouseover=\"this.style.backgroundColor='#86A5D2';\" onmouseout=\"this.style.backgroundColor='';\">"
  +"<td align='left' width='50'><img height='50' width='50' src='<?php echo $rute_image;?>'></td><td>"+pdesc2+"<br>"+pinfo+"</td><td align='right' width=80>&nbsp;"+currency_left+" "+pprice+" "+currency_right+"</td></tr>");
}

function print_title(title){
  document.write("<tr><th align='center' colspan='3'>"+title+"</th></tr>");
}

function print_deselect(title,pindex){
  document.write("<tr onmouseover=\"this.style.backgroundColor='#86A5D2';\" onmouseout=\"this.style.backgroundColor='';\" onclick=\"parent.add_product('','','','','','','"+pindex+"');parent.document.mainform.elements['products_id["+pindex+"]'].value='-1';\"><td align='center' colspan=3><b>"+title+"</b></td></tr>");
}
</script>
</head>
<?php
// END OF FUNCTIONS DEFINITIONS

// ASSEMBLY FEES.... GETS ITS OWN PROCEDURE -------------------------------------------
// This can also be changed because assy fees are a product too - TENCENTS
?>
<body>
<table style="BORDER-COLLAPSE: collapse" borderColor="#86a5d2" border="1" width="100%">
<script language='JavaScript'>
<?php
if ($_GET['row']==$_GET['assemb_id']) {
  $textshow['assembly'].="print_deselect('"."<font color=\"red\">".TEXT_DESELECT_ITEM."</font>"."','".$_GET['pindex']."');\n";
  $textshow['assembly'].="print_title('". ASSEMBLY . TEXT_SELECT_ITEM ."'); \n";
  $c_query = tep_db_query("select pc.products_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " pc, " . TABLE_PRODUCTS . " p where p.products_id = pc.products_id and p.products_status = '1' and p.products_quantity > 0 and pc.categories_id='" . (int)$pc_assembly_osccat . "' order by p.products_price");
  $count2=0;
  while ($count = tep_db_fetch_array($c_query)) {
    $a_query = tep_db_query("select pd.products_name, pd.products_description from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p where p.products_id = pd.products_id and p.products_status = '1' and p.products_quantity > 0 and (pd.products_id='".$count['products_id']."' AND pd.language_id='".$languages_id."')");
    while ($aount = tep_db_fetch_array($a_query)){
      $assembly_fees['name'] = addslashes($aount['products_name']);

// CLEANUP THE DESCRIPTION AND CUT TO SIZE
      $temp_description = str_replace("\r", "", $aount['products_description']);
      $temp_description = str_replace("\n", "", $temp_description);
      $temp_description = strip_tags(addslashes($temp_description));
      if (strlen($temp_description) >= $short_description_length) {
        $temp_description = substr($temp_description,0,$short_description_length) . "...";
      }
      $assembly_fees['description'] = $temp_description;

      $assembly_fees['id']= $count['products_id'];
      if (DISPLAY_PRICE_WITH_TAX) {
        $b_query = tep_db_query("select products_price, products_image, products_tax_class_id from " . TABLE_PRODUCTS . " where products_status = '1' and products_quantity > 0 and products_id='".$count['products_id']."'");
      } else {
        $b_query = tep_db_query("select products_price, products_image from " . TABLE_PRODUCTS . " where products_status = '1' and products_quantity > 0 and products_id='".$count['products_id']."'");
      }
      $temps=tep_db_fetch_array($b_query);
      $assembly_fees['fee'] = '&nbsp;'. $currencies->display_price($temps['products_price'],tep_get_tax_rate($temps['products_tax_class_id'])).'&nbsp;';
      $assembly_fees['image'] = $temps['products_image'];
      if (!$assembly_fees ['image']) {
        $assembly_fees ['image'] = 'no_product_image.gif';
      }
      $ccount++;
    }
    $textshow['assembly'].= "print_line('".$count2."','".$assembly_fees ['image']."','".$assembly_fees ['name']."','".$assembly_fees ['description']."','".$assembly_fees ['fee']."','".$assembly_fees ['id']."','".$_GET['row']."'); \n";
    $count2++;
  }
  $textshow['assembly'].="print_deselect('"."<font color=\"red\">".TEXT_DESELECT_ITEM."</font>"."','".$_GET['row']."');\n";
  echo $textshow['assembly'];
} else {
  $output = $pcount;
  for ($ib = 0; $ib < $output; $ib++) {
    $cat = $osccat[$ib]; //
    if ($_GET['row'] == $ib) echo $textshow[$cat];
  }
}
?>
</script>
</body>
</html>
