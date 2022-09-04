<?php
/*
  $Id: product_depends.ph, v 2.5.5 2008/10/19 10c $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2005 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

// CHECK IF THIS IS AN UPDATE CYCLE
switch ($_GET['action']) {
  case 'update' :
    if ($_POST['prod1']) {
      $previous_product = 0;
      $depend_count = 0;
      $prod1=$_POST['prod1'];
      $prod2=$_POST['prod2'];
      $d_max=$_POST['matrix'];
      $product_count=0;
      foreach ($prod1 as $product_1) {
        foreach ($prod2 as $product_2) {
          if ($product_1 <> $previous_product) {
            $previous_product = $product_1;
            tep_db_query("DELETE FROM " . TABLE_BUILDER_DEPENDENCES . " WHERE product1_id='" . (int)$product_1 . "'");
          }
          if (($d_max[$product_1][$product_2] == 1) OR ($d_max[$product_1][$product_2] == 'on')) {
            tep_db_query("INSERT INTO " . TABLE_BUILDER_DEPENDENCES . " SET product1_id='" . (int)$product_1 . "', product2_id='" . (int)$product_2 . "'");
            $depend_count++;
          }
        }
        $product_count++;
      }
    }
    if ($product_2 > 1) {
      $messageStack->add($product_count . ' ' . TEXT_PRODUCTS_UPDATED . ' ' . $depend_count . ' ' . TEXT_DEPENDENCES_UPDATED );
    }
  break;
  unset ($prod1);
  unset ($prod2);
  unset ($d_max);
}

// SOMETHING TO DO WITH ROWS BY PAGE APPARENTLY - IT WORKS!!
($row_by_page) ? define('MAX_DISPLAY_ROW_BY_PAGE' , $row_by_page ) : $row_by_page = MAX_DISPLAY_SEARCH_RESULTS; define('MAX_DISPLAY_ROW_BY_PAGE' , MAX_DISPLAY_SEARCH_RESULTS );

// LOAD BUILDER CATEGORIES INTO ARRAY
$bcomp_query = tep_db_query("select * from " . TABLE_BUILDER_CATEGORIES . " ORDER BY pc_category_id");
while ($bcomp = tep_db_fetch_array($bcomp_query)){
  $pcid[$bcomp['pc_category_id']]= $bcomp['pc_category_id'];
  $pccat[$bcomp['pc_category_id']]= $bcomp['pc_category_name'];
  $pcdcat[$bcomp['pc_category_id']]= $bcomp['pc_depends_category_id'];
  $pcimg[$bcomp['pc_category_id']]= $bcomp['pc_category_image'];
  $osccat[$bcomp['pc_category_id']]= $bcomp['osc_category_id'];
}

// FUNCTION : BUILDER CATEGORY LIST
function builders_list(){
  global $builder;
  global $pcid;
  global $pcdcat;
  global $pccat;
  global $cID;
  $return_string = '<select name="cID" onChange="this.form.submit();">';
  $return_string .= '<option value="' . 0 . '">' . TEXT_ALL_BUILDERS . '</option>';
  foreach ($pcid as $builder_cat) {
    if ($pcdcat[$builder_cat] > 0) {
      $return_string .= '<option value="' . $builder_cat . '"';
      if($cID && $builder_cat == $cID) $return_string .= ' SELECTED';
      $return_string .= '>' . $pccat[$builder_cat] . '</option>';
    }
  }
  $return_string .= '</select>';
  return $return_string;
}

// GET INCOMING BUILDER CATEGORY IDS AND OSC CATEGORY IDS
$cID = $_GET['cID'];
$cID_osc = $osccat[$cID];
$dID = $pcdcat[$_GET['cID']];
$dID_osc = $osccat[$dID];
$manufacturer = $_GET['manufacturer'];
$d_manufacturer = $_GET['d_manufacturer'];

// GET CURRENT DEPENDENCY DEFINITIONS (nb: product 1 = dependant, product 2 = master)
$bdep_query = tep_db_query("select * from " . TABLE_BUILDER_DEPENDENCES . " ORDER BY product1_id");
while ($bdep = tep_db_fetch_array($bdep_query)){
  $product_1 = $bdep['product1_id'];
  $product_2 = $bdep['product2_id'];
  $prod1_id[$product_1]= $bdep['product1_id'];
  $prod2_id[$product_1]= $bdep['product2_id'];
// AND PLUG THEM INTO THE MATRIX WHILE WERE HERE
  $matrix[$product_1][$product_2] = '1';
}

// GET MANUFACTURER INFO
$manufacturers_array = array(array('id' => '0', 'text' => NO_MANUFACTURER));
$manufacturers_query = tep_db_query("select manufacturers_id, manufacturers_name from " . TABLE_MANUFACTURERS . " order by manufacturers_name");
while ($manufacturers = tep_db_fetch_array($manufacturers_query)) {
  $manufacturers_array[] = array('id' => $manufacturers['manufacturers_id'],'text' => $manufacturers['manufacturers_name']);
}

// FUNCTION : GET MANUFACTURER LIST
function manufacturers_list(){
  global $manufacturer;
  $manufacturers_query = tep_db_query("select m.manufacturers_id, m.manufacturers_name from " . TABLE_MANUFACTURERS . " m order by m.manufacturers_name ASC");
  $return_string = '<select name="manufacturer" onChange="this.form.submit();">';
  $return_string .= '<option value="' . 0 . '">' . TEXT_ALL_MANUFACTURERS . '</option>';
  while($manufacturers = tep_db_fetch_array($manufacturers_query)){
    $return_string .= '<option value="' . $manufacturers['manufacturers_id'] . '"';
    if($manufacturer && $manufacturers['manufacturers_id'] == $manufacturer) $return_string .= ' SELECTED';
    $return_string .= '>' . $manufacturers['manufacturers_name'] . '</option>';
  }
  $return_string .= '</select>';
  return $return_string;
}

// FUNCTION : GET DEPENDENCE MANUFACTURER LIST
function d_manufacturers_list(){
  global $d_manufacturer;
  $d_manufacturers_query = tep_db_query("select m.manufacturers_id, m.manufacturers_name from " . TABLE_MANUFACTURERS . " m order by m.manufacturers_name ASC");
  $return_string = '<select name="d_manufacturer" onChange="this.form.submit();">';
  $return_string .= '<option value="' . 0 . '">' . TEXT_ALL_MANUFACTURERS . '</option>';
  while($d_manufacturers = tep_db_fetch_array($d_manufacturers_query)){
    $return_string .= '<option value="' . $d_manufacturers['manufacturers_id'] . '"';
    if($d_manufacturer && $d_manufacturers['manufacturers_id'] == $d_manufacturer) $return_string .= ' SELECTED';
    $return_string .= '>' . $d_manufacturers['manufacturers_name'] . '</option>';
  }
  $return_string .= '</select>';
  return $return_string;
}

// DEFINE THE STEP INCREMENT FOR USER-SELECTABLE lines per page
$row_bypage_array = array(array());
for ($i = 10; $i <=100 ; $i=$i+15) {
  $row_bypage_array[] = array('id' => $i,'text' => $i);
}

// AND NOW DIVE IN
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->
<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_image(DIR_WS_CATALOG_IMAGES . 'table_background_compbuilder.gif', HEADING_PICTURE_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="center"><table width="100%" height="30" cellspacing="0" cellpadding="2" border="1" bgcolor="#e9e9ff" bordercolor="#D1E7EF">
          <tr>
            <td>
              <table width="100%" cellspacing="0" cellpadding="2" border="0">
                <tr align="left">
                  <form name="update" method="POST" action="<?php echo $_SERVER['PHP_SELF']."?action=update&page=". $page."&sort_by=". $sort_by ."&cID=". $cID. "&row_by_page=". $row_by_page ."&manufacturer=". $manufacturer . "&d_manufacturer=" . $d_manufacturer; ?>">
                  <td class="dataTableWarning" align="center"><?php echo WARNING_MESSAGE; ?></td>
                </tr>
              </table>
            </td>
          </tr>
        </table></td>
      </tr>

      <tr>
        <td align="center"><table width="100%" cellspacing="0" cellpadding="0" border="1" bgcolor="#F3F9FB" bordercolor="#D1E7EF">
          <tr align="left">
            <td><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="top"><table border="0" height="280" width="280" cellspacing="0" cellpadding="0">
                  <tr class="dataTableHeadingRow_d">
                    <td valign="middle">
                      <table height="45%" width="100%" cellspacing="0" cellpadding="2" border="0">
                        <tr height="30">
                          <td colspan="2" class="dataTableTitleRow"><?php echo '&nbsp;' . TABLE_HEADING_ROW; ?></td>
                        </tr>
                        <tr height="25">
                          <td class="dataTableContent" align="right"><?php echo DISPLAY_BUILDER_CATEGORIES; ?></td>
<?php
if ($cID) {
?>
                          <td class="dataTableContent" align="left"><?php echo $pccat[$dID]; ?></td></form>
<?php
} else {
?>
                          <td class="dataTableContent" align="left"><?php echo TEXT_ALL_BUILDERS; ?></td>
<?php
}
?>
                        </tr>
                        <tr height="25">
                          <?php echo tep_draw_form('categorie', FILENAME_DEPENDS, '', 'get'); echo tep_draw_hidden_field( 'row_by_page', $row_by_page); echo tep_draw_hidden_field( 'manufacturer', $manufacturer); echo tep_draw_hidden_field( 'd_manufacturer', $d_manufacturer); echo tep_draw_hidden_field('cID', $cID);?>
                          <td colspan="2" class="dataTableContent" align="center"><?php echo '(' . tep_output_generated_category_path($dID_osc) . ')'; ?></td></form>
                        </tr>
                        <tr height="25">
                          <?php echo tep_draw_form('d_manufacturers', FILENAME_DEPENDS, '', 'get'); echo tep_draw_hidden_field( 'row_by_page', $row_by_page); echo tep_draw_hidden_field( 'cID', $cID); echo tep_draw_hidden_field( 'manufacturer', $manufacturer);?>
                          <td class="dataTableContent" width="50%" align="right"><?php echo DISPLAY_MANUFACTURERS . '&nbsp;'; ?></td>
                          <td class="dataTableContent" width="50%" align="left"><?php echo d_manufacturers_list(); ?></td></form>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr class="dataTableHeadingRow_c">
                    <td><table height="45%" width="100%" cellspacing="0" cellpadding="2" border="0">
                      <tr height="30">
                        <td colspan="2" class="dataTableTitleColumn"><?php echo '&nbsp;' . TABLE_HEADING_COLUMN; ?></td>
                      </tr>
                      <tr height="25">
                        <?php echo tep_draw_form('builder', FILENAME_DEPENDS, '', 'get'); echo tep_draw_hidden_field( 'row_by_page', $row_by_page);?>
                        <td class="dataTableContent" width="50%" align="right"><?php echo DISPLAY_BUILDER_CATEGORIES; ?></td>
                        <td class="dataTableContent" width="50%" align="left"><?php echo builders_list(); ?></td></form>
                      </tr>
                      <tr height="25">
                        <?php echo tep_draw_form('categorie', FILENAME_DEPENDS, '', 'get'); echo tep_draw_hidden_field( 'row_by_page', $row_by_page); echo tep_draw_hidden_field( 'manufacturer', $manufacturer); echo tep_draw_hidden_field( 'd_manufacturer', $d_manufacturer); echo tep_draw_hidden_field('cID', $cID);?>
                        <td colspan="2" class="dataTableContent" align="center"><?php echo '(' . tep_output_generated_category_path($cID_osc) . ')'; ?></td></form>
                      </tr>
                      <tr height="25">
                        <?php echo tep_draw_form('manufacturers', FILENAME_DEPENDS, '', 'get'); echo tep_draw_hidden_field( 'row_by_page', $row_by_page); echo tep_draw_hidden_field( 'cID', $cID); echo tep_draw_hidden_field( 'd_manufacturer', $d_manufacturer);?>
                        <td class="dataTableContent" align="right"><?php echo DISPLAY_MANUFACTURERS . '&nbsp;'; ?></td>
                        <td class="dataTableContent" align="left"><?php echo manufacturers_list(); ?></td></form>
                      </tr>
                    </table></td>
                  </tr>
                  <tr class="dataTableHeadingRow_c">
                    <td><table height="10%" width="100%" cellspacing="0" cellpadding="2" border="0">
                      <tr class="dataTableContent">
                        <td align="right">
                          <?php echo TEXT_SORT_BY . '&nbsp;';?>
                          <?php echo TABLE_HEADING_MODEL . " <a href=\"" . tep_href_link( FILENAME_DEPENDS, 'cID='. $cID .'&sort_by=p.products_model ASC&page=' . $page.'&row_by_page=' . $row_by_page . '&manufacturer=' . $manufacturer . '&d_manufacturer=' . $d_manufacturer)."\" >".tep_image(DIR_WS_IMAGES . 'icon_up.gif', TEXT_SORT_ALL . TABLE_HEADING_MODEL . ' ' . TEXT_ASCENDINGLY)."</a>
                          <a href=\"" . tep_href_link( FILENAME_DEPENDS, 'cID='. $cID .'&sort_by=p.products_model DESC&page=' . $page.'&row_by_page=' . $row_by_page . '&manufacturer=' . $manufacturer . '&d_manufacturer=' . $d_manufacturer)."\" >".tep_image(DIR_WS_IMAGES . 'icon_down.gif', TEXT_SORT_ALL . TABLE_HEADING_MODEL . ' ' . TEXT_DESCENDINGLY)."</a>";?>
                          <?php echo '&nbsp;' . TABLE_HEADING_PRODUCTS . " <a href=\"" . tep_href_link( FILENAME_DEPENDS, 'cID='. $cID .'&sort_by=pd.products_name ASC&page=' . $page.'&row_by_page=' . $row_by_page . '&manufacturer=' . $manufacturer . '&d_manufacturer=' . $d_manufacturer)."\" >".tep_image(DIR_WS_IMAGES . 'icon_up.gif', TEXT_SORT_ALL . TABLE_HEADING_PRODUCTS . ' ' . TEXT_ASCENDINGLY)."</a>
                          <a href=\"" . tep_href_link( FILENAME_DEPENDS, 'cID='. $cID .'&sort_by=pd.products_name DESC&page=' . $page.'&row_by_page=' . $row_by_page . '&manufacturer=' . $manufacturer . '&d_manufacturer=' . $d_manufacturer)."\" >".tep_image(DIR_WS_IMAGES . 'icon_down.gif', TEXT_SORT_ALL . TABLE_HEADING_PRODUCTS . ' ' . TEXT_DESCENDINGLY)."</a>";?>
                          <?php echo '&nbsp;';?>
                        </td>
                      </tr>
                    </table></td>
                  </tr>
                </table></td>
                <form name="update" method="POST" action="<?php echo $_SERVER['PHP_SELF']."?action=update&page=". $page."&sort_by=". $sort_by ."&cID=". $cID. "&row_by_page=". $row_by_page ."&manufacturer=". $manufacturer . "&d_manufacturer=" . $d_manufacturer; ?>">
                <td valign="top"><table border="0" cellspacing="0" cellpadding="0">
                  <tr class="dataTableHeadingRow">
                    <td class="dataTableHeadingContent" align="left" valign="middle">
                      <table border="0" cellspacing="0" cellpadding="0">
                        <tr class="dataTableHeadingRow_d">
<?php
// LIST SORTING CONTROL STRING USED IN QUERIES - DEFAULT BY NAME - ALWAYS BY SUBCATEGORY
if ($sort_by) {
  if (strpos($sort_by, ' by ') < 1) {
    $sort_by = ' order by pc.categories_id, '.$sort_by;
  }
} else {
  $sort_by = ' order by pc.categories_id, pd.products_name';
}

// GET DEPENDENCY PRODUCTS NAMES SO WE CAN DISPLAY THEM ACROSS THE TOP - THIS IS THE 'Y' AXIS OF THE MATRIX
// all builder categories or just one ?
if ($cID_osc == 0) {
  $where_str = "p.products_id = pd.products_id and pd.language_id = '$languages_id' and p.products_id = pc.products_id and c.categories_id = pc.categories_id and (";
  $first_time = 1;
  foreach ($pcid as $build_cat) {
    $add_to_list = 0;
// categories that have multiple dependents will clutter the query - this check makes sure it only features once
    foreach ($pcdcat as $depend_cat) {
      if ($build_cat == $depend_cat && $got_already[$depend_cat] != 1) {
        $add_to_list = 1;
        $got_already[$depend_cat] = 1;
      }
    }
    if ($add_to_list != 0) {
      $dID_osc = $osccat[$build_cat];
      if ($first_time) {
        $where_str .= "pc.categories_id = '" . $dID_osc . "'";
        $first_time = 0;
      } else {
        $where_str .= " or pc.categories_id = '" . $dID_osc . "'";
      }
      if (tep_childs_in_category_count($dID_osc)) {
        $subcategories_array = array();
        tep_get_subcategories($subcategories_array, $dID_osc);
        for ($i=0, $n=sizeof($subcategories_array); $i<$n; $i++ ) {
          $where_str .= " or pc.categories_id = '" . (int)$subcategories_array[$i] . "'";
        }
      }
    }
  }
} else {
  $where_str = "p.products_id = pd.products_id and pd.language_id = '$languages_id' and p.products_id = pc.products_id and c.categories_id = pc.categories_id and (pc.categories_id = '" . $dID_osc . "'";
  if (tep_childs_in_category_count($dID_osc)) {
    $subcategories_array = array();
    tep_get_subcategories($subcategories_array, $dID_osc);
    for ($i=0, $n=sizeof($subcategories_array); $i<$n; $i++ ) {
      $where_str .= " or pc.categories_id = '" . (int)$subcategories_array[$i] . "'";
    }
  }
}

$where_str .= ")";
// trap for bad where strings
if (strstr($where_str,"()")) {
  $where_str = substr($where_str,0,strlen($where_str)-7);
}
if ($d_manufacturer) {
  $d_products_query_raw = "select p.products_id, p.products_status, p.products_model, pd.products_name, pc.categories_id, c.parent_id from  " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION .  " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " pc, " . TABLE_CATEGORIES . " c where " . $where_str . " and p.manufacturers_id = " . $d_manufacturer . " $sort_by ";
} else {
  $d_products_query_raw = "select p.products_id, p.products_status, p.products_model, pd.products_name, pc.categories_id, c.parent_id from  " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION .  " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " pc, " . TABLE_CATEGORIES . " c where " . $where_str . $sort_by ;
}
$d_products_query = tep_db_query($d_products_query_raw);

// GOT ALL TOP ROW DATA, NOW DISPLAY THEM
$d_previous_category = 0;
while ($_d_products = tep_db_fetch_array($d_products_query)) {
  if ($_d_products['categories_id'] != $d_previous_category) {
// THE FOLLOWING TO CHECK IF THE SUBCATEGORY CHANGES
      $d_previous_category = $_d_products['categories_id'];
                    echo "<td class=\"dataTableVerticalTitle\" height=\"280\" width=\"20\" align=\"center\">&nbsp;&nbsp;<b>". tep_get_category_name($_d_products['categories_id'], $languages_id) . "&nbsp;</b>(". tep_get_category_name($_d_products['parent_id'], $languages_id) . ")</td>";
      $blank_d_list_of_products_ids[$_d_products['products_id']] = 1;
  }
                    echo "<td class=\"dataTableVertical\" height=\"280\" width=\"20\" align=\"center\">&nbsp;&nbsp;".$_d_products['products_name']."</td>\n";
  $d_products[$_d_products['products_id']] = $_d_products;
  $d_list_of_products_ids[$_d_products['products_id']] = $_d_products['products_id'];
}
                    echo "<td class=\"dataTableVertical\" width=\"20\" align=\"left\"></td>\n";
                    echo "<td class=\"dataTableVertical\" width=\"30\" align=\"left\"></td>\n";
?>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td colspan="2" valign="top"><table border="0" cellspacing="0" cellpadding="0">
                  <tr class="dataTableHeadingRow_c">
                    <td class="dataTableHeadingContent" align="left" valign="middle">
                      <table border="0" cellspacing="0" cellpadding="0">
<?php
// CONTROL MAXIMUM LINES PER PAGE
$split_page = $page;
if ($split_page > 1) $rows = $split_page * MAX_DISPLAY_ROW_BY_PAGE - MAX_DISPLAY_ROW_BY_PAGE;

// GET PRODUCTS FOR THE CURRENT BUILDER CATEGORY - THESE WILL BE USED TO CONSTRUCT THE LEFT COLUMN - THE DEPENDENTS
// all builder categories or just one ?
if ($cID_osc == 0) {
  $where_str = "p.products_id = pd.products_id and pd.language_id = '$languages_id' and p.products_id = pc.products_id and c.categories_id = pc.categories_id and (";
  $first_time = 1;
  foreach ($pcid as $build_cat) {
// dont show builder categories that have no dependence
    if ($pcdcat[$build_cat] > 0){
      $cID_osc = $osccat[$build_cat];
      if ($first_time) {
        $where_str .= "pc.categories_id = '" . $cID_osc . "'";
        $first_time = 0;
      } else {
        $where_str .= " or pc.categories_id = '" . $cID_osc . "'";
      }
      if (tep_childs_in_category_count($cID_osc)) {
        $subcategories_array = array();
        tep_get_subcategories($subcategories_array, $cID_osc);
        for ($i=0, $n=sizeof($subcategories_array); $i<$n; $i++ ) {
          $where_str .= " or pc.categories_id = '" . (int)$subcategories_array[$i] . "'";
        }
      }
    }
  }
} else {
  $where_str = "p.products_id = pd.products_id and pd.language_id = '$languages_id' and p.products_id = pc.products_id and c.categories_id = pc.categories_id and (pc.categories_id = '" . $cID_osc . "'";
  if (tep_childs_in_category_count($cID_osc)) {
    $subcategories_array = array();
    tep_get_subcategories($subcategories_array, $cID_osc);
    for ($i=0, $n=sizeof($subcategories_array); $i<$n; $i++ ) {
      $where_str .= " or pc.categories_id = '" . (int)$subcategories_array[$i] . "'";
    }
  }
}
$where_str .= ")";
// trap for bad where strings
if (strstr($where_str,"()")) {
  $where_str = substr($where_str,0,strlen($where_str)-7);
}
if ($manufacturer) {
  $products_query_raw = "select p.products_id, p.products_status, p.products_model, pd.products_name, pc.categories_id, c.parent_id from  " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION .  " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " pc, " . TABLE_CATEGORIES . " c where " . $where_str . " and p.manufacturers_id = " . $manufacturer . " $sort_by ";
} else {
  $products_query_raw = "select p.products_id, p.products_status, p.products_model, pd.products_name, pc.categories_id, c.parent_id from  " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION .  " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " pc, " . TABLE_CATEGORIES . " c where " . $where_str . $sort_by ;
}

// THIS LITTLE ROUTINE SPLITS THE PAGES UP ACCORDING TO THE lines per page SETTING
$products_split = new splitPageResults($split_page, MAX_DISPLAY_ROW_BY_PAGE, $products_query_raw, $products_query_numrows);
$products_query = tep_db_query($products_query_raw);

// DUMP CURRENT BUILDER CATEGORY PRODUCTS IDS INTO AN ARRAY
$previous_category = 0;
while ($_products = tep_db_fetch_array($products_query)) {
// THE FOLLOWING TO CHECK IF SUBCATEGORY CHANGES
  if ($_products['categories_id'] != $previous_category) {
      $previous_category = $_products['categories_id'];
      $blank_list_of_products_ids[$_products['products_id']] = 1;
  }
  $products[$_products['products_id']] = $_products;
  $list_of_products_ids[$_products['products_id']] = $_products['products_id'];
}

// FOR EACH BUILDER PRODUCT, DISPLAY ITS DETAILS AND A ROW OF CHECKBOXES, ENDING WITH A LINK TO PRODUCT EDITOR
if ((tep_not_null($list_of_products_ids)) && (tep_not_null($d_list_of_products_ids))) {

// DISPLAY THE BUILDER PRODUCT DESCRIPTION AND CATEGORIES DOWN THE LEFT SIDE OF THE PAGE - THIS WILL BE THE 'X' AXIS OF THE MATRIX
  foreach ($list_of_products_ids as $product_focus) {
    echo tep_draw_hidden_field('prod1['. $product_focus .']',$list_of_products_ids[$product_focus]);
    $rows++;
    if (strlen($rows) < 2) $rows = '0' . $rows;
?>
                        <tr>
                          <td class="dataTableHeadingRow_c">
<?php
// CHECK IF WE NEED TO INSERT A BLANKER, OR CATEGORY DETAILS IF THE PRODUCT CATEGORY CHANGES
    if ($blank_list_of_products_ids[$product_focus] == 1) {
      if ($products[$product_focus]['categories_id'] != 0) {
?>
                            <td class="dataTableHorizontalTitle" width="80" align="left"><?php echo '&nbsp;';?></td>
                            <td class="dataTableHorizontalTitle" align="right" width="200"><?php echo '(' . tep_get_category_name($products[$product_focus]['parent_id'], $languages_id) . ')&nbsp;<b>' . tep_get_category_name($products[$product_focus]['categories_id'], $languages_id) . '</b>&nbsp;&nbsp;';?></td>
<?php
      } else {
?>
                            <td class="dataTableHorizontal" width="80" align="left"><?php echo '&nbsp;';?></td>
                            <td class="dataTableHorizontal" align="right" width="200"><?php echo '&nbsp;';?></td>
<?php
      }
?>
                          </td>
<?php
// MATRIX HEADER - BLANK SPACER
?>
                          <td class="dataTableHeadingRow">
<?php
      foreach ($d_list_of_products_ids as $product_focus_2) {
?>
                            <td class="dataTableHeadingRow" width="20" align="center"><?php echo '&nbsp;';?></td>
<?php
        if ($blank_d_list_of_products_ids[$product_focus_2] == 1) {
                      echo "<td class=\"dataTableHeadingRow\" width=\"20\" align=\"center\">\n";
                        echo '&nbsp;';
                      echo "</td>\n";
        }
      }
?>
                            <td class="dataTableHeadingRow" width="20" align="center"><?php echo '&nbsp;';?></td>
                            <td class="dataTableHeadingRow_c" width="30" valign="center" align="center"><?php echo '&nbsp;';?></td>
                          </td>
                        </tr>
                        <tr>
                          <td class="dataTableHeadingRow_c">
<?php
    }
// BLANKER / CATEGORY DESCRIPTION ENDS

// SHOW PRODUCT DETAILS (FOR PRODUCTS ON LEFT)
?>
                            <td class="dataTableHorizontal" width="80" align="left"><?php echo '&nbsp;'. $products[$product_focus]['products_model'];?></td>
                            <td class="dataTableHorizontal" align="right" width="200"><?php echo $products[$product_focus]['products_name'] . '&nbsp;&nbsp;';?></td>
                          </td>
                          <td class="dataTableHeadingRow">
<?php
// DISPLAY THE ROW OF CHECKBOXES REPRESENTING THE DEPENDENCY LINKS TO THE MASTER PRODUCTS (listed on top)
      foreach ($d_list_of_products_ids as $product_focus_2) {
        echo tep_draw_hidden_field('prod2['. $product_focus_2 .']',$d_list_of_products_ids[$product_focus_2]);
                      echo "<td class=\"dataTableHeadingRow\" width=\"20\" align=\"center\">\n";

// DRAW THE CHECKBOX, OR A BLANK IF THERE IS NO PRODUCT CODE FOR THE MASTER OR FOR THE SLAVE
        if ($blank_d_list_of_products_ids[$product_focus_2] == 1) {
                        echo '&nbsp;';
                      echo "</td>\n";
                      echo "<td class=\"dataTableHeadingRow\" width=\"20\" align=\"center\">\n";
}
// ONLY DRAW A CHECKBOX IF THE LINK IS NOT TO ITSELF, OTHERWISE SHOW SOMETHING ELSE (A BLANKER OR AN ICON)
        if ($list_of_products_ids[$product_focus] != $d_list_of_products_ids[$product_focus_2]) {

          echo tep_draw_checkbox_field('matrix[' . $product_focus . '][' . $product_focus_2 . ']' , 0, $matrix[$product_focus][$product_focus_2]);
        } else {
          echo tep_image(DIR_WS_IMAGES . 'icon_status_red.gif', TEXT_IMAGE_DENIED);
        }
                      echo "</td>\n";
      }
                      echo "<td class=\"dataTableHeadingRow\" width=\"20\" align=\"center\"><?php echo '&nbsp;';?></td>\n";
                      echo "<td class=\"dataTableHeadingRow_c\" width=\"30\" valign=\"center\" align=\"center\"><a href=\"". tep_href_link (FILENAME_CATEGORIES, 'pID='. $products[$product_focus]['products_id'] .'&cPath='. $products[$product_focus]['categories_id'] .'&action=new_product')."\">". tep_image(DIR_WS_IMAGES . 'icon_arrow_right_blue.gif', TEXT_IMAGE_SWITCH_EDIT) ."</a></td>\n";
  }
// YAWN!
  echo tep_draw_hidden_field( 'row_by_page', $row_by_page);
  echo tep_draw_hidden_field( 'sort_by', $sort_by);
  echo tep_draw_hidden_field( 'page', $split_page);
                    echo "</td>\n";
                  echo "</tr>\n";
}
// MATRIX DISPLAY IS NOW COMPLETE
// MATRIX FOOTER - ANOTHER BLANKER
if (tep_not_null($d_list_of_products_ids)) {
?>
                        <tr>
                          <td class="dataTableHeadingRow_c">
                            <td class="dataTableHorizontal" width="80" align="left"><?php echo '&nbsp;';?></td>
                            <td class="dataTableHorizontal" align="right" width="200"><?php echo '&nbsp;';?></td>
                          </td>
                          <td class="dataTableHeadingRow">
<?php
      foreach ($d_list_of_products_ids as $product_focus_2) {
?>
                            <td class="dataTableHeadingRow" width="20" align="center"><?php echo '&nbsp;';?></td>
<?php
        if ($blank_d_list_of_products_ids[$product_focus_2] == 1) {
                      echo "<td class=\"dataTableHeadingRow\" width=\"20\" align=\"center\">\n";
                        echo '&nbsp;';
                      echo "</td>\n";
        }
      }
// END OF MATRIX FOOTER
?>
                            <td class="dataTableHeadingRow" width="20" align="center"><?php echo '&nbsp;';?></td>
                            <td class="dataTableHeadingRow_c" width="30" valign="center" align="center"><?php echo '&nbsp;';?></td>
                          </td>
                        </tr>
<?php
}
?>
                      </table>
                    </td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>

        </table></td>
      </tr>
<form name="update" method="POST" action="<?php echo $_SERVER['PHP_SELF']."?action=update&page=". $page."&sort_by=". $sort_by ."&cID=". $cID. "&row_by_page=". $row_by_page ."&manufacturer=". $manufacturer . "&d_manufacturer=" . $d_manufacturer; ?>">
      <tr>
        <td align="center"><table width="100%" height="50" cellspacing="0" cellpadding="2" border="1" bgcolor="#e9e9ff" bordercolor="#D1E7EF">
          <tr>
            <td>
              <table width="100%" cellspacing="0" cellpadding="2" border="0">
                <tr>
                  <td width="300" class="dataTableHeadingContent" align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr class="dataTableContent">
                      <td width="33%" align="center"><?php echo tep_image_submit('button_update.gif', IMAGE_UPDATE);?></td>
                      <td width="33%" align="center"><?php echo '<a href="' . tep_href_link(FILENAME_BUILDER) . '">' . tep_image_button('button_back.gif', IMAGE_BACK) . '</a>';?></td>
                      <td width="33%" align="center"><?php echo '<a href="javascript:window.print()">' . tep_image_button('button_print.gif', IMAGE_PRINT) . '</a>';?></td>
                    </tr>
                  </table></td>
                </tr>
              </table>
            </td>
          </tr>
        </table></td>
      </tr>
</form>
      <tr>
        <td align="center"><table width="100%" cellspacing="0" cellpadding="0" border="1" bgcolor="#e9e9ff" bordercolor="#D1E7EF">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr class="dataTableContent">
                    <td height="30" class="dataTableHeadingContent" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr class="dataTableContent">
                        <td class="dataTableContent" align="left"><?php echo $products_split->display_count($products_query_numrows, MAX_DISPLAY_ROW_BY_PAGE, $split_page, TEXT_DISPLAY_NUMBER_OF_PRODUCTS);  ?></td>
                        <td class="dataTableContent" align="center"><?php echo $products_split->display_links($products_query_numrows, MAX_DISPLAY_ROW_BY_PAGE, MAX_DISPLAY_PAGE_LINKS, $split_page, '&cID='. $cID .'&sort_by='.$sort_by . '&row_by_page=' . $row_by_page . '&manufacturer=' . $manufacturer . '&d_manufacturer=' . $d_manufacturer); ?></td>
                        <td class="dataTableContent" align="right"><?php echo tep_draw_form('row_by_page', FILENAME_DEPENDS, '', 'get'); echo tep_draw_hidden_field( 'manufacturer', $manufacturer); echo tep_draw_hidden_field( 'd_manufacturer', $d_manufacturer); echo tep_draw_hidden_field( 'cID', $cID); echo tep_draw_hidden_field('dID',$dID);?></td>
                        <td class="dataTableContent" align="right"><?php echo TEXT_MAXI_ROW_BY_PAGE . '&nbsp;&nbsp;' . tep_draw_pull_down_menu('row_by_page', $row_bypage_array, $row_by_page, 'onChange="this.form.submit();"'); ?></form></td>
                      </tr>
                    </table></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>

        </table></td>
<!-- body_text_eof //-->
      </tr>
    </table></td>
<!-- body_eof //-->
  </tr>
</table>

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
