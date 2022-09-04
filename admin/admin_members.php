<?php
/*
  $Id: admin_members.php,v 1.29 2002/03/17 17:52:23 harley_vb Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');
    require('includes/functions/password_funcs.php');
  $action = (isset($HTTP_GET_VARS['action']) ? $HTTP_GET_VARS['action'] : '');

// prepare to logout an active administrator if the login page is accessed again
  if (tep_session_is_registered('admin')) {
    $action = 'logoff';
  }



     
  $current_boxes = DIR_FS_ADMIN . DIR_WS_BOXES;
  
  if ($HTTP_GET_VARS['action']) {
    switch ($HTTP_GET_VARS['action']) {
      case 'member_new':
        $check_email_query = tep_db_query("select admin_email_address from " . TABLE_ADMIN . "");
        while ($check_email = tep_db_fetch_array($check_email_query)) {
          $stored_email[] = $check_email['admin_email_address'];
        }
        
        if (in_array($HTTP_POST_VARS['admin_email_address'], $stored_email)) {
          tep_redirect(tep_href_link(FILENAME_ADMIN_MEMBERS, 'page=' . $HTTP_GET_VARS['page'] . 'mID=' . $HTTP_GET_VARS['mID'] . '&error=email&action=new_member'));
        } else {
          function randomize() {
            $salt = "abchefghjkmnpqrstuvwxyz0123456789";
            srand((double)microtime()*1000000); 
            $i = 0;
    	    while ($i <= 7) {
    		$num = rand() % 33;
    		$tmp = substr($salt, $num, 1);
    		$pass = $pass . $tmp;
    		$i++;
  	    }
  	    return $pass;
          }
          $makePassword = randomize();
          
          // crear cuentas cerrado por seguridad

          $sql_data_array = array('admin_groups_id' => tep_db_prepare_input($HTTP_POST_VARS['admin_groups_id']),
                                  'admin_firstname' => tep_db_prepare_input($HTTP_POST_VARS['admin_firstname']),
                                  'admin_lastname' => tep_db_prepare_input($HTTP_POST_VARS['admin_lastname']),
                                  'admin_email_address' => tep_db_prepare_input($HTTP_POST_VARS['admin_email_address']),
                                  'admin_password' => tep_encrypt_password($makePassword),
                                  'admin_created' => 'now()');
        
          tep_db_perform(TABLE_ADMIN, $sql_data_array);
          $admin_id = tep_db_insert_id();

          tep_mail($HTTP_POST_VARS['admin_firstname'] . ' ' . $HTTP_POST_VARS['admin_lastname'], 'euroconsolas@gmail.com', ADMIN_EMAIL_SUBJECT, sprintf(ADMIN_EMAIL_TEXT, $HTTP_POST_VARS['admin_firstname'], HTTP_SERVER . DIR_WS_ADMIN, $HTTP_POST_VARS['admin_email_address'], $makePassword, STORE_OWNER), STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);

          tep_redirect(tep_href_link(FILENAME_ADMIN_MEMBERS, 'page=' . $HTTP_GET_VARS['page'] . '&mID=' . $admin_id));
        }
        break;
      case 'member_edit':
        $admin_id = tep_db_prepare_input($HTTP_POST_VARS['admin_id']);
        $hiddenPassword = '-hidden-';
        $stored_email[] = 'NONE';
        
        $check_email_query = tep_db_query("select admin_email_address from " . TABLE_ADMIN . " where admin_id <> " . $admin_id . "");
        while ($check_email = tep_db_fetch_array($check_email_query)) {
          $stored_email[] = $check_email['admin_email_address'];
        }
        
        if (in_array($HTTP_POST_VARS['admin_email_address'], $stored_email)) {
          tep_redirect(tep_href_link(FILENAME_ADMIN_MEMBERS, 'page=' . $HTTP_GET_VARS['page'] . 'mID=' . $HTTP_GET_VARS['mID'] . '&error=email&action=edit_member'));
        } else {
                            //cambiar de codigo
                         if (tep_db_prepare_input($HTTP_POST_VARS['code_new_x'])){

                         $cambiar_code_admin_values = mysql_query("select * from " . TABLE_ADMIN . " where admin_id = '" . $HTTP_GET_VARS['mID']. "'");
          if   ($cambiar_code_admin = mysql_fetch_array($cambiar_code_admin_values)){



      $sql_status_update_array = array('tienda' => tep_db_prepare_input($HTTP_POST_VARS['code_new_x']));
                tep_db_perform('orders_status', $sql_status_update_array, 'update', " tienda = '" . tep_db_prepare_input($HTTP_POST_VARS['code_admin_x']) . "'");
                
                     }

                       }else{


      }


          $sql_data_array = array('admin_groups_id' => tep_db_prepare_input($HTTP_POST_VARS['admin_groups_id']),
                                  'admin_firstname' => tep_db_prepare_input($HTTP_POST_VARS['admin_firstname_x']),
                                  'admin_lastname' => tep_db_prepare_input($HTTP_POST_VARS['admin_lastname_x']),
                                  'admin_email_address' => tep_db_prepare_input($HTTP_POST_VARS['admin_email_address_x']),
                                  'name_boxes' => tep_db_prepare_input($HTTP_POST_VARS['name_boxes_x']),
                                  'code_admin' => tep_db_prepare_input($HTTP_POST_VARS['code_admin_x']),
                                  'transferencia' => tep_db_prepare_input($HTTP_POST_VARS['transferencia_pendiente_x']),
                                  'procesando_reembolso_internacional' => tep_db_prepare_input($HTTP_POST_VARS['status_procesando_reembolso_internacional_h']),
                                  'procesando_paypal' => tep_db_prepare_input($HTTP_POST_VARS['status_procesando_paypal_h']),
                                  'no_recogido' => tep_db_prepare_input($HTTP_POST_VARS['no_recogido_h']),
                                  'transferencia_procesando' => tep_db_prepare_input($HTTP_POST_VARS['status_transferencia_procesando_h']),
                                  'tienda_cuenta_cliente' => tep_db_prepare_input($HTTP_POST_VARS['tienda_cuenta_cliente_x']),
                                  'admin_cif' => tep_db_prepare_input($HTTP_POST_VARS['admin_cif_x']),
                                  'admin_direccion' => tep_db_prepare_input($HTTP_POST_VARS['admin_direccion_x']),
                                  'admin_poblacion' => tep_db_prepare_input($HTTP_POST_VARS['admin_poblacion_x']),
                                  'admin_provincia' => tep_db_prepare_input($HTTP_POST_VARS['admin_provincia_x']),
                                  'admin_titularbanco' => tep_db_prepare_input($HTTP_POST_VARS['admin_titularbanco_x']),
                                  'admin_nombrebanco' => tep_db_prepare_input($HTTP_POST_VARS['admin_nombrebanco_x']),
                                  'admin_cuentabancaria' => tep_db_prepare_input($HTTP_POST_VARS['admin_cuentabancaria_x']),
                                  'admin_cp' => tep_db_prepare_input($HTTP_POST_VARS['admin_cp_x']),
                                  'admin_telefono' => tep_db_prepare_input($HTTP_POST_VARS['admin_telefono_x']),
                                  'admin_movil' => tep_db_prepare_input($HTTP_POST_VARS['admin_movil_x']),
                                  'cobrado' => tep_db_prepare_input($HTTP_POST_VARS['status_cobrado_h']),
                                  'paypal_enviado' => tep_db_prepare_input($HTTP_POST_VARS['status_paypal_enviado_h']),
                                  'abono' => tep_db_prepare_input($HTTP_POST_VARS['status_abono_h']),
                                  'pagado' => tep_db_prepare_input($HTTP_POST_VARS['status_pagado_h']),
                                  'pagado_internacional' => tep_db_prepare_input($HTTP_POST_VARS['status_pagado_internacional_h']),
                                  'pagado_transferencia' => tep_db_prepare_input($HTTP_POST_VARS['status_pagado_transferencia_h']),
                                  'pagado_paypal' => tep_db_prepare_input($HTTP_POST_VARS['status_pagado_paypal_h']),
                                  'entregas_stock' => tep_db_prepare_input($HTTP_POST_VARS['entregas_stock_h']),
                                  'retirarado' => tep_db_prepare_input($HTTP_POST_VARS['status_retirarado_h']),
                                  'status_entregas' => tep_db_prepare_input($HTTP_POST_VARS['status_entregas_h']),
                                  'status_liquidacion' => tep_db_prepare_input($HTTP_POST_VARS['status_liquidacion_h']),
                                  'status_salidas' => tep_db_prepare_input($HTTP_POST_VARS['status_salidas_h']),
                                  'peticiones_mercancias' => tep_db_prepare_input($HTTP_POST_VARS['peticiones_mercancias_h']),
                                  'pendiente_entrada' => tep_db_prepare_input($HTTP_POST_VARS['pendiente_entrada_h']),
                                  'pendiente_entrada_entienda' => tep_db_prepare_input($HTTP_POST_VARS['pendiente_entrada_entienda_h']),
                                  'presupuestos' => tep_db_prepare_input($HTTP_POST_VARS['presupuestos_h']),
                                  'credito' => tep_db_prepare_input($HTTP_POST_VARS['credito_h']),
                                  'albaran' => tep_db_prepare_input($HTTP_POST_VARS['albaran_h']),
                                  'albaran_cobrar' => tep_db_prepare_input($HTTP_POST_VARS['albaran_cobrar_h']),
                                  'status_pendiente' => tep_db_prepare_input($HTTP_POST_VARS['status_pendiente_h']),
                                  'status_procesando' => tep_db_prepare_input($HTTP_POST_VARS['status_procesando_h']),
                                  'recoger' => tep_db_prepare_input($HTTP_POST_VARS['recoger_h']),
                                  'facturado' => tep_db_prepare_input($HTTP_POST_VARS['facturado_h']),
                                  'cancelado' => tep_db_prepare_input($HTTP_POST_VARS['cancelado_h']),
                                  'esperando_respuesta' => tep_db_prepare_input($HTTP_POST_VARS['esperando_respuesta_h']),
                                  'cambio_procesando' => tep_db_prepare_input($HTTP_POST_VARS['cambio_procesando_h']),
                                  'reserva' => tep_db_prepare_input($HTTP_POST_VARS['reserva_h']),
                                  'admin_modified' => 'now()');
          tep_db_perform(TABLE_ADMIN, $sql_data_array, 'update', 'admin_id = \'' . $admin_id . '\'');

          
          
                          // cambiar de codigo
                   if (tep_db_prepare_input($HTTP_POST_VARS['code_new_x'])){

          $sql_status_update_array = array('code_admin' => tep_db_prepare_input($HTTP_POST_VARS['code_new_x']));
                tep_db_perform(TABLE_ADMIN, $sql_status_update_array, 'update', " admin_id = '" . $HTTP_GET_VARS['mID'] . "'");

                       }else{
                   }





          

          tep_mail($HTTP_POST_VARS['admin_firstname'] . ' ' . $HTTP_POST_VARS['admin_lastname'], $HTTP_POST_VARS['admin_email_address'], ADMIN_EMAIL_EDIT_SUBJECT, sprintf(ADMIN_EMAIL_EDIT_TEXT, $HTTP_POST_VARS['admin_firstname'], HTTP_SERVER . DIR_WS_ADMIN, $HTTP_POST_VARS['admin_email_address'], $hiddenPassword, STORE_OWNER), STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
          
          tep_redirect(tep_href_link(FILENAME_ADMIN_MEMBERS, 'page=' . $HTTP_GET_VARS['page'] . '&mID=' . $admin_id));
        }
        break;
      case 'member_delete':
        $admin_id = tep_db_prepare_input($HTTP_POST_VARS['admin_id']);
        tep_db_query("delete from " . TABLE_ADMIN . " where admin_id = '" . $admin_id . "'");
        tep_db_query("delete from " . 'admin_supervisores' . " where admin_id = '" . $admin_id . "'");

        
        
        
        
        tep_redirect(tep_href_link(FILENAME_ADMIN_MEMBERS, 'page=' . $HTTP_GET_VARS['page']));
        break;
      case 'group_define':
        $selected_checkbox = $HTTP_POST_VARS['groups_to_boxes'];
        
        $define_files_query = tep_db_query("select admin_files_id from " . TABLE_ADMIN_FILES . " order by admin_files_id");
        while ($define_files = tep_db_fetch_array($define_files_query)) {
          $admin_files_id = $define_files['admin_files_id'];
          
          if (in_array ($admin_files_id, $selected_checkbox)) {
            $sql_data_array = array('admin_groups_id' => tep_db_prepare_input($HTTP_POST_VARS['checked_' . $admin_files_id]));
            //$set_group_id = $HTTP_POST_VARS['checked_' . $admin_files_id];
          } else {
            $sql_data_array = array('admin_groups_id' => tep_db_prepare_input($HTTP_POST_VARS['unchecked_' . $admin_files_id]));
            //$set_group_id = $HTTP_POST_VARS['unchecked_' . $admin_files_id];
          }
          tep_db_perform(TABLE_ADMIN_FILES, $sql_data_array, 'update', 'admin_files_id = \'' . $admin_files_id . '\'');
        }
               
        tep_redirect(tep_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $HTTP_POST_VARS['admin_groups_id']));
        break;
      case 'group_delete':
        $set_groups_id = tep_db_prepare_input($HTTP_POST_VARS['set_groups_id']);
        
        tep_db_query("delete from " . TABLE_ADMIN_GROUPS . " where admin_groups_id = '" . $HTTP_GET_VARS['gID'] . "'");
        tep_db_query("alter table " . TABLE_ADMIN_FILES . " change admin_groups_id admin_groups_id set( " . $set_groups_id . " ) NOT NULL DEFAULT '1' ");
        tep_db_query("delete from " . TABLE_ADMIN . " where admin_groups_id = '" . $HTTP_GET_VARS['gID'] . "'");
               
        tep_redirect(tep_href_link(FILENAME_ADMIN_MEMBERS, 'gID=groups'));
        break;        
      case 'group_edit':
        $admin_groups_name = ucwords(strtolower(tep_db_prepare_input($HTTP_POST_VARS['admin_groups_name'])));
        $name_replace = ereg_replace (" ", "%", $admin_groups_name);
        
        if (($admin_groups_name == '' || NULL) || (strlen($admin_groups_name) <= 5) ) {
          tep_redirect(tep_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $HTTP_GET_VARS[gID] . '&gName=false&action=action=edit_group'));
        } else {
          $check_groups_name_query = tep_db_query("select admin_groups_name as group_name_edit from " . TABLE_ADMIN_GROUPS . " where admin_groups_id <> " . $HTTP_GET_VARS['gID'] . " and admin_groups_name like '%" . $name_replace . "%'");
          $check_duplicate = tep_db_num_rows($check_groups_name_query);
          if ($check_duplicate > 0){
            tep_redirect(tep_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $HTTP_GET_VARS['gID'] . '&gName=used&action=edit_group'));
          } else {
            $admin_groups_id = $HTTP_GET_VARS['gID'];
            tep_db_query("update " . TABLE_ADMIN_GROUPS . " set admin_groups_name = '" . $admin_groups_name . "' where admin_groups_id = '" . $admin_groups_id . "'");
            tep_redirect(tep_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $admin_groups_id));
          }
        }
        break;              
      case 'group_new':
        $admin_groups_name = ucwords(strtolower(tep_db_prepare_input($HTTP_POST_VARS['admin_groups_name'])));
        $name_replace = ereg_replace (" ", "%", $admin_groups_name);
        
        if (($admin_groups_name == '' || NULL) || (strlen($admin_groups_name) <= 5) ) {
          tep_redirect(tep_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $HTTP_GET_VARS[gID] . '&gName=false&action=new_group'));
        } else {
          $check_groups_name_query = tep_db_query("select admin_groups_name as group_name_new from " . TABLE_ADMIN_GROUPS . " where admin_groups_name like '%" . $name_replace . "%'");
          $check_duplicate = tep_db_num_rows($check_groups_name_query);
          if ($check_duplicate > 0){
            tep_redirect(tep_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $HTTP_GET_VARS['gID'] . '&gName=used&action=new_group'));
          } else {
            $sql_data_array = array('admin_groups_name' => $admin_groups_name);
            tep_db_perform(TABLE_ADMIN_GROUPS, $sql_data_array);
            $admin_groups_id = tep_db_insert_id();

            $set_groups_id = tep_db_prepare_input($HTTP_POST_VARS['set_groups_id']);
            $add_group_id = $set_groups_id . ',\'' . $admin_groups_id . '\'';
            tep_db_query("alter table " . TABLE_ADMIN_FILES . " change admin_groups_id admin_groups_id set( " . $add_group_id . ") NOT NULL DEFAULT '1' ");
            
            tep_redirect(tep_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $admin_groups_id));
          }
        }
        break;        
    }
  }

?>
<?php   require(DIR_WS_INCLUDES . 'template_top.php');?>





        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">

    </table></td>
<!-- body_text //-->    
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
<?php
 if ($HTTP_GET_VARS['gPath']) {
   $group_name_query = tep_db_query("select admin_groups_name from " . TABLE_ADMIN_GROUPS . " where admin_groups_id = " . $HTTP_GET_VARS['gPath']);
   $group_name = tep_db_fetch_array($group_name_query);
  
   if ($HTTP_GET_VARS['gPath'] == 1) {
     echo tep_draw_form('defineForm', FILENAME_ADMIN_MEMBERS, 'gID=' . $HTTP_GET_VARS['gPath']);
   } elseif ($HTTP_GET_VARS['gPath'] != 1) {
     echo tep_draw_form('defineForm', FILENAME_ADMIN_MEMBERS, 'gID=' . $HTTP_GET_VARS['gPath'] . '&action=group_define', 'post', 'enctype="multipart/form-data"');
     echo tep_draw_hidden_field('admin_groups_id', $HTTP_GET_VARS['gPath']); 
   }
?>
            <table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td colspan=2 class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_GROUPS_DEFINE; ?></td>
              </tr>
<?php
  $db_boxes_query = tep_db_query("select admin_files_id as admin_boxes_id, admin_files_name as admin_boxes_name, admin_groups_id as boxes_group_id from " . TABLE_ADMIN_FILES . " where admin_files_is_boxes = '1' order by admin_files_name");
  while ($group_boxes = tep_db_fetch_array($db_boxes_query)) {
    $group_boxes_files_query = tep_db_query("select admin_files_id, admin_files_name, admin_groups_id from " . TABLE_ADMIN_FILES . " where admin_files_is_boxes = '0' and admin_files_to_boxes = '" . $group_boxes['admin_boxes_id'] . "' order by admin_files_name");

    $selectedGroups = $group_boxes['boxes_group_id'];
    $groupsArray = explode(",", $selectedGroups);

    if (in_array($HTTP_GET_VARS['gPath'], $groupsArray)) {     
      $del_boxes = array($HTTP_GET_VARS['gPath']);
      $result = array_diff ($groupsArray, $del_boxes);
      sort($result);
      $checkedBox = $selectedGroups;
      $uncheckedBox = implode (",", $result);
      $checked = true;
    } else {
      $add_boxes = array($HTTP_GET_VARS['gPath']);
      $result = array_merge ($add_boxes, $groupsArray);
      sort($result);
      $checkedBox = implode (",", $result);
      $uncheckedBox = $selectedGroups;
      $checked = false;
    }    
?>
              <tr class="dataTableRowBoxes">
                <td class="dataTableContent" width="23"><?php echo tep_draw_checkbox_field('groups_to_boxes[]', $group_boxes['admin_boxes_id'], $checked, '', 'id="groups_' . $group_boxes['admin_boxes_id'] . '" onClick="checkGroups(this)"'); ?></td>
                <td class="dataTableContent"><b><?php echo ucwords(substr_replace ($group_boxes['admin_boxes_name'], '', -4)) . ' ' . tep_draw_hidden_field('checked_' . $group_boxes['admin_boxes_id'], $checkedBox) . tep_draw_hidden_field('unchecked_' . $group_boxes['admin_boxes_id'], $uncheckedBox); ?></b></td>
              </tr>
              <tr class="dataTableRow">
                <td class="dataTableContent">&nbsp;</td>
                <td class="dataTableContent">
                  <table border="0" cellspacing="0" cellpadding="0">
<?php
     //$group_boxes_files_query = tep_db_query("select admin_files_id, admin_files_name, admin_groups_id from " . TABLE_ADMIN_FILES . " where admin_files_is_boxes = '0' and admin_files_to_boxes = '" . $group_boxes['admin_boxes_id'] . "' order by admin_files_name");
     while($group_boxes_files = tep_db_fetch_array($group_boxes_files_query)) {
       $selectedGroups = $group_boxes_files['admin_groups_id'];
       $groupsArray = explode(",", $selectedGroups);

       if (in_array($HTTP_GET_VARS['gPath'], $groupsArray)) {     
         $del_boxes = array($HTTP_GET_VARS['gPath']);
         $result = array_diff ($groupsArray, $del_boxes);
         sort($result);
         $checkedBox = $selectedGroups;
         $uncheckedBox = implode (",", $result);
         $checked = true;
       } else {
         $add_boxes = array($HTTP_GET_VARS['gPath']);
         $result = array_merge ($add_boxes, $groupsArray);
         sort($result);
         $checkedBox = implode (",", $result);
         $uncheckedBox = $selectedGroups;
         $checked = false;
       }
?>
                                       
                    <tr>
                      <td width="20"><?php echo tep_draw_checkbox_field('groups_to_boxes[]', $group_boxes_files['admin_files_id'], $checked, '', 'id="subgroups_' . $group_boxes['admin_boxes_id'] . '" onClick="checkSub(this)"'); ?></td>
                      <td class="dataTableContent"><?php echo $group_boxes_files['admin_files_name'] . ' ' . tep_draw_hidden_field('checked_' . $group_boxes_files['admin_files_id'], $checkedBox) . tep_draw_hidden_field('unchecked_' . $group_boxes_files['admin_files_id'], $uncheckedBox);?></td>
                    </tr>
<?php       
     }
?>
                  </table>
                </td>
              </tr>              
<?php
  }
?>
              <tr class="dataTableRowBoxes">
                <td colspan=2 class="dataTableContent" valign="top" align="right"><?php if ($HTTP_GET_VARS['gPath'] != 1) { echo  '<a href="' . tep_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $HTTP_GET_VARS['gPath']) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a> ' . tep_image_submit('button_save.gif', IMAGE_INSERT); } else { echo tep_image_submit('button_back.gif', IMAGE_BACK); } ?>&nbsp;</td>
              </tr>
            </table></form>
<?php
 } elseif ($HTTP_GET_VARS['gID']) {
?>
            <table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_GROUPS_NAME; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $db_groups_query = tep_db_query("select * from " . TABLE_ADMIN_GROUPS . " order by admin_groups_id");
  
  $add_groups_prepare = '\'0\'' ;
  $del_groups_prepare = '\'0\'' ;
  $count_groups = 0;
  while ($groups = tep_db_fetch_array($db_groups_query)) {
    $add_groups_prepare .= ',\'' . $groups['admin_groups_id'] . '\'' ;
    if (((!$HTTP_GET_VARS['gID']) || ($HTTP_GET_VARS['gID'] == $groups['admin_groups_id']) || ($HTTP_GET_VARS['gID'] == 'groups')) && (!$gInfo) ) {
      $gInfo = new objectInfo($groups);
    }
   
    if ( (is_object($gInfo)) && ($groups['admin_groups_id'] == $gInfo->admin_groups_id) ) {
      echo '                <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . tep_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $groups['admin_groups_id'] . '&action=edit_group') . '\'">' . "\n";
    } else {
      echo '                <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . tep_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $groups['admin_groups_id']) . '\'">' . "\n";
      $del_groups_prepare .= ',\'' . $groups['admin_groups_id'] . '\'' ;
    }
?>
                <td class="dataTableContent">&nbsp;<b><?php echo $groups['admin_groups_name']; ?></b></td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($gInfo)) && ($groups['admin_groups_id'] == $gInfo->admin_groups_id) ) { echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo '<a href="' . tep_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $groups['admin_groups_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    $count_groups++;
  } 
?>
              <tr>
                <td colspan="2"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo TEXT_COUNT_GROUPS . $count_groups; ?></td>
                    <td class="smallText" valign="top" align="right"><?php echo '<a href="' . tep_href_link(FILENAME_ADMIN_MEMBERS) . '">' . tep_image_button('button_back.gif', IMAGE_BACK) . '</a> <a href="' . tep_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $gInfo->admin_groups_id . '&action=new_group') . '">' . tep_image_button('button_admin_group.gif', IMAGE_NEW_GROUP) . '</a>'; ?>&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            </table>
<?php
 } else {
?> 
            <table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_NAME; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_EMAIL; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_GROUPS; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_LOGNUM; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $db_admin_query_raw = "select * from " . TABLE_ADMIN . " order by admin_firstname";
  
  $db_admin_split = new splitPageResults($HTTP_GET_VARS['page'], MAX_DISPLAY_SEARCH_RESULTS, $db_admin_query_raw, $db_admin_query_numrows);
  $db_admin_query = tep_db_query($db_admin_query_raw);
  //$db_admin_num_row = tep_db_num_rows($db_admin_query);
  
  while ($admin = tep_db_fetch_array($db_admin_query)) {
    $admin_group_query = tep_db_query("select admin_groups_name from " . TABLE_ADMIN_GROUPS . " where admin_groups_id = '" . $admin['admin_groups_id'] . "'");
    $admin_group = tep_db_fetch_array ($admin_group_query);
    if (((!$HTTP_GET_VARS['mID']) || ($HTTP_GET_VARS['mID'] == $admin['admin_id'])) && (!$mInfo) ) {
      $mInfo_array = array_merge($admin, $admin_group);
      $mInfo = new objectInfo($mInfo_array);
    }
   
    if ( (is_object($mInfo)) && ($admin['admin_id'] == $mInfo->admin_id) ) {
      echo '                  <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . tep_href_link(FILENAME_ADMIN_MEMBERS, 'page=' . $HTTP_GET_VARS['page'] . '&mID=' . $admin['admin_id'] . '&action=edit_member') . '\'">' . "\n";
    } else {
      echo '                  <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . tep_href_link(FILENAME_ADMIN_MEMBERS, 'page=' . $HTTP_GET_VARS['page'] . '&mID=' . $admin['admin_id']) . '\'">' . "\n";
    }
?>
                <td class="dataTableContent">&nbsp;<?php echo $admin['admin_firstname']; ?>&nbsp;<?php echo $admin['admin_lastname']; ?></td>
                <td class="dataTableContent"><?php echo $admin['admin_email_address']; ?></td>
                <td class="dataTableContent" align="center"><?php echo $admin_group['admin_groups_name']; ?></td>
                <td class="dataTableContent" align="center"><?php echo $admin['admin_lognum']; ?></td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($mInfo)) && ($admin['admin_id'] == $mInfo->admin_id) ) { echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo '<a href="' . tep_href_link(FILENAME_ADMIN_MEMBERS, 'page=' . $HTTP_GET_VARS['page'] . '&mID=' . $admin['admin_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
  } 
?>
              <tr>
                <td colspan="5"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $db_admin_split->display_count($db_admin_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $HTTP_GET_VARS['page'], TEXT_DISPLAY_NUMBER_OF_MEMBERS); ?><br><?php echo $db_admin_split->display_links($db_admin_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $HTTP_GET_VARS['page']); ?></td>
                    <td class="smallText" valign="top" align="right"><?php echo '<a href="' . tep_href_link(FILENAME_ADMIN_MEMBERS, 'gID=groups') . '">' . tep_image_button('button_admin_groups.gif', IMAGE_GROUPS) . '</a>'; echo ' <a href="' . tep_href_link(FILENAME_ADMIN_MEMBERS, 'page=' . $HTTP_GET_VARS['page'] . '&mID=' . $mInfo->admin_id . '&action=new_member') . '">' . tep_image_button('button_admin_member.gif', IMAGE_NEW_MEMBER) . '</a>'; ?>&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            </table>
<?php
 }
?>
            </td>
<?php
  $heading = array();
  $contents = array();
  switch ($HTTP_GET_VARS['action']) {  
    case 'new_member': 
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW . '</b>');

      $contents = array('form' => tep_draw_form('newmember', FILENAME_ADMIN_MEMBERS, 'action=member_new&page=' . $page . 'mID=' . $HTTP_GET_VARS['mID'], 'post', 'enctype="multipart/form-data"')); 
      if ($HTTP_GET_VARS['error']) {
        $contents[] = array('text' => TEXT_INFO_ERROR); 
      }
      $contents[] = array('text' => '<br>&nbsp;' . TEXT_INFO_FIRSTNAME . '<br>&nbsp;' . tep_draw_input_field('admin_firstname')); 
      $contents[] = array('text' => '<br>&nbsp;' . TEXT_INFO_LASTNAME . '<br>&nbsp;' . tep_draw_input_field('admin_lastname'));
      $contents[] = array('text' => '<br>&nbsp;' . TEXT_INFO_EMAIL . '<br>&nbsp;' . tep_draw_input_field('admin_email_address')); 
      
      $groups_array = array(array('id' => '0', 'text' => TEXT_NONE));
      $groups_query = tep_db_query("select admin_groups_id, admin_groups_name from " . TABLE_ADMIN_GROUPS);
      while ($groups = tep_db_fetch_array($groups_query)) {
        $groups_array[] = array('id' => $groups['admin_groups_id'],
                                'text' => $groups['admin_groups_name']);
      }
      $contents[] = array('text' => '<br>&nbsp;' . TEXT_INFO_GROUP . '<br>&nbsp;' . tep_draw_pull_down_menu('admin_groups_id', $groups_array, '0')); 
      $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_insert.gif', IMAGE_INSERT, 'onClick="validateForm();return document.returnValue"') . ' <a href="' . tep_href_link(FILENAME_ADMIN_MEMBERS, 'page=' . $HTTP_GET_VARS['page'] . '&mID=' . $HTTP_GET_VARS['mID']) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');    
      break;
    case 'edit_member': 
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW . '</b>');
      
      $contents = array('form' => tep_draw_form('newmember', FILENAME_ADMIN_MEMBERS, 'action=member_edit&page=' . $page . '&mID=' . $HTTP_GET_VARS['mID'], 'post', 'enctype="multipart/form-data"')); 
      if ($HTTP_GET_VARS['error']) {
        $contents[] = array('text' => TEXT_INFO_ERROR); 
      }

          $status_values = mysql_query("select * from " . TABLE_ADMIN . " where admin_id = '" . $HTTP_GET_VARS['mID'] . "'");
   $status_c = mysql_fetch_array($status_values);

    if ($status_c['admin_groups_id'] == 6){
      $admin_groups_id_z = '<br>&nbsp;' . 'Cambiar Codigo' . '<br>&nbsp;' . tep_draw_input_field('code_new_x', $nd_codigo);
}

         
         

      $contents[] = array('text' => tep_draw_hidden_field('admin_id', $mInfo->admin_id)); 
      $contents[] = array('text' => '<br>&nbsp;' . TEXT_INFO_FIRSTNAME . '<br>&nbsp;' . tep_draw_input_field('admin_firstname_x', $mInfo->admin_firstname));
      $contents[] = array('text' => '<br>&nbsp;' . TEXT_INFO_LASTNAME . '<br>&nbsp;' . tep_draw_input_field('admin_lastname_x', $mInfo->admin_lastname));
      $contents[] = array('text' => '<br>&nbsp;' . TEXT_INFO_EMAIL . '<br>&nbsp;' . tep_draw_input_field('admin_email_address_x',  $status_c['admin_email_address']));
      $contents[] = array('text' => '<br>&nbsp;' . 'Nombre del Boxe' . '<br>&nbsp;' . tep_draw_input_field('name_boxes_x', $status_c['name_boxes']));
      $contents[] = array('text' => '<br>&nbsp;' . 'Codigo' . '<br>&nbsp;' . tep_draw_input_field('code_admin_x', $status_c['code_admin']));
      $contents[] = array('text' => $admin_groups_id_z);
      $contents[] = array('text' => '<br>&nbsp;' . 'Cuenta Cliente Vinculante' . '<br>&nbsp;' . tep_draw_input_field('tienda_cuenta_cliente_x', $status_c['tienda_cuenta_cliente']));
      $contents[] = array('text' => '<br>&nbsp;' . 'CIF/NIF' . '<br>&nbsp;' . tep_draw_input_field('admin_cif_x', $status_c['admin_cif']));
      $contents[] = array('text' => '<br>&nbsp;' . 'Direccion' . '<br>&nbsp;' . tep_draw_input_field('admin_direccion_x', $status_c['admin_direccion']));
      $contents[] = array('text' => '<br>&nbsp;' . 'Poblacion' . '<br>&nbsp;' . tep_draw_input_field('admin_poblacion_x', $status_c['admin_poblacion']));
      $contents[] = array('text' => '<br>&nbsp;' . 'Provincia' . '<br>&nbsp;' . tep_draw_input_field('admin_provincia_x', $status_c['admin_provincia']));
      $contents[] = array('text' => '<br>&nbsp;' . 'Cuenta Bancaria Titular' . '<br>&nbsp;' . tep_draw_input_field('admin_titularbanco_x', $status_c['admin_titularbanco']));
      $contents[] = array('text' => '<br>&nbsp;' . 'Cuenta Nombre Banco' . '<br>&nbsp;' . tep_draw_input_field('admin_nombrebanco_x', $status_c['admin_nombrebanco']));
      $contents[] = array('text' => '<br>&nbsp;' . 'Cuenta Bancaria' . '<br>&nbsp;' . tep_draw_input_field('admin_cuentabancaria_x', $status_c['admin_cuentabancaria']));
      $contents[] = array('text' => '<br>&nbsp;' . 'Codigo Postal' . '<br>&nbsp;' . tep_draw_input_field('admin_cp_x', $status_c['admin_cp']));
      $contents[] = array('text' => '<br>&nbsp;' . 'Telefono' . '<br>&nbsp;' . tep_draw_input_field('admin_telefono_x', $status_c['admin_telefono']));
      $contents[] = array('text' => '<br>&nbsp;' . 'Movil' . '<br>&nbsp;' . tep_draw_input_field('admin_movil_x', $status_c['admin_movil']));
             if ($mInfo->admin_id == 1) {
        $contents[] = array('text' => tep_draw_hidden_field('admin_groups_id', $mInfo->admin_groups_id));
      } else {



        $groups_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $groups_query = tep_db_query("select admin_groups_id, admin_groups_name from " . TABLE_ADMIN_GROUPS);
        while ($groups = tep_db_fetch_array($groups_query)) {
          $groups_array[] = array('id' => $groups['admin_groups_id'],
                                  'text' => $groups['admin_groups_name']);
        }
        $contents[] = array('text' => '<br>&nbsp;' . TEXT_INFO_GROUP . '<br>&nbsp;' . tep_draw_pull_down_menu('admin_groups_id', $groups_array, $mInfo->admin_groups_id));
      }
      $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_insert.gif', IMAGE_INSERT, 'onClick="validateForm();return document.returnValue"') . ' <a href="' . tep_href_link(FILENAME_ADMIN_MEMBERS, 'page=' . $HTTP_GET_VARS['page'] . '&mID=' . $HTTP_GET_VARS['mID']) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');


         // credito otorgado a empleados y clientes de confianza.

        $credito_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $credito_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and  tienda = '" . $status_c['code_admin']. "' ORDER BY orders_status_name");
        while ($credito = tep_db_fetch_array($credito_query)) {
          $credito_array[] = array('id' => $credito['orders_status_id'],
                                  'text' => $credito['orders_status_name']);
        }
        $contents[] = array('text' => '' . '<p>Credito otorgado a empleados y clientes de confianza</p>Credito: ' . '' . tep_draw_pull_down_menu('credito_h', $credito_array, $status_c['credito']));

        $albaran_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $albaran_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and  tienda = '" . $status_c['code_admin']. "' ORDER BY orders_status_name");
        while ($albaran = tep_db_fetch_array($albaran_query)) {
          $albaran_array[] = array('id' => $albaran['orders_status_id'],
                                  'text' => $albaran['orders_status_name']);
        }
        $contents[] = array('text' => '' . '<p>Albaran a clientes</p>Albaran: ' . '' . tep_draw_pull_down_menu('albaran_h', $credito_array, $status_c['albaran']));






        $albaran_cobrar_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $albaran_cobrar_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and  tienda = '" . $status_c['code_admin']. "' ORDER BY orders_status_name");
        while ($albaran_cobrar = tep_db_fetch_array($albaran_cobrar_query)) {
          $albaran_cobrar_array[] = array('id' => $albaran_cobrar['orders_status_id'],
                                  'text' => $albaran_cobrar['orders_status_name']);
        }
        $contents[] = array('text' => '' . '<p>Albaran pendiente de cobrar a clientes</p>Albaran Cobrar: ' . '' . tep_draw_pull_down_menu('albaran_cobrar_h', $credito_array, $status_c['albaran_cobrar']));







        $cobrado_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $cobrado_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and  tienda = '" . $status_c['code_admin']. "' ORDER BY orders_status_name");
        while ($cobrado = tep_db_fetch_array($cobrado_query)) {
          $cobrado_array[] = array('id' => $cobrado['orders_status_id'],
                                  'text' => $cobrado['orders_status_name']);
        }
        $contents[] = array('text' => '' . '<p>Pedidos Enviados o Cobrados en Tienda</p>Cobrado / Pedido Enviado: ' . '' . tep_draw_pull_down_menu('status_cobrado_h', $cobrado_array, $status_c['cobrado']));

        $pagado_transferencia_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $pagado_transferencia_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and  tienda = '" . $status_c['code_admin']. "' ORDER BY orders_status_name");
        while ($pagado_transferencia = tep_db_fetch_array($pagado_transferencia_query)) {
          $pagado_transferencia_array[] = array('id' => $pagado_transferencia['orders_status_id'],
                                  'text' => $pagado_transferencia['orders_status_name']);
        }
        $contents[] = array('text' => '' . '<p>Pedidos Transferencia Pedido Enviado</p>Transferencia Pedido Enviado: ' . '' . tep_draw_pull_down_menu('status_pagado_transferencia_h', $pagado_transferencia_array, $status_c['pagado_transferencia']));


                         // solo administradores
      if ($mID == 14){
        $pagado_internacional_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $pagado_internacional_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and  tienda = '" . $status_c['code_admin']. "' ORDER BY orders_status_name");
        while ($pagado_internacional = tep_db_fetch_array($pagado_internacional_query)) {
          $pagado_internacional_array[] = array('id' => $pagado_internacional['orders_status_id'],
                                  'text' => $pagado_internacional['orders_status_name']);
        }
        $contents[] = array('text' => '' . 'Pedido Enviado Internacional: ' . '' . tep_draw_pull_down_menu('status_pagado_internacional_h', $pagado_internacional_array, $status_c['pagado_internacional']));

              }//fin administradores





        $pagado_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $pagado_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and  tienda = '" . $status_c['code_admin']. "' ORDER BY orders_status_name");
        while ($pagado = tep_db_fetch_array($pagado_query)) {
          $pagado_array[] = array('id' => $pagado['orders_status_id'],
                                  'text' => $pagado['orders_status_name']);
        }
        $contents[] = array('text' => '' . '<p>&nbsp;</p><p>Pididos ya Pagados a la Admininstración.</p>Pagado: ' . '' . tep_draw_pull_down_menu('status_pagado_h', $pagado_array, $status_c['pagado']));





                         // solo administradores
      if ($mID == 14){

        $paypal_enviado_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $paypal_enviado_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and  tienda = '" . $status_c['code_admin']. "' ORDER BY orders_status_name");
        while ($paypal_enviado = tep_db_fetch_array($paypal_enviado_query)) {
          $paypal_enviado_array[] = array('id' => $paypal_enviado['orders_status_id'],
                                  'text' => $paypal_enviado['orders_status_name']);
        }
        $contents[] = array('text' => '' . 'Pedido Enviado por Paypal: ' . '' . tep_draw_pull_down_menu('status_paypal_enviado_h', $paypal_enviado_array, $status_c['paypal_enviado']));


        $pagado_transferencia_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $pagado_transferencia_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and  tienda = '" . $status_c['code_admin']. "' ORDER BY orders_status_name");
        while ($pagado_transferencia = tep_db_fetch_array($pagado_transferencia_query)) {
          $pagado_transferencia_array[] = array('id' => $pagado_transferencia['orders_status_id'],
                                  'text' => $pagado_transferencia['orders_status_name']);
        }
        $contents[] = array('text' => '' . 'Pedido Enviado por Transferencia: ' . '' . tep_draw_pull_down_menu('status_pagado_transferencia_h', $pagado_transferencia_array, $status_c['pagado_transferencia']));







              } //fin administradores






      $status_pendiente_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $status_pendiente_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and  tienda = '" . $status_c['code_admin']. "' ORDER BY orders_status_name");
        while ($status_pendiente = tep_db_fetch_array($status_pendiente_query)) {
          $status_pendiente_array[] = array('id' => $status_pendiente['orders_status_id'],
                                  'text' => $status_pendiente['orders_status_name']);
        }
        $contents[] = array('text' => '' . '<p>&nbsp;</p><p>Status Pendientes, primer status cuando el cliente hace un pedido.</p>Pendiente: ' . '' . tep_draw_pull_down_menu('status_pendiente_h', $status_pendiente_array, $status_c['status_pendiente']));



              // solo administradores
  //    if ($mID == 14){




        $pagado_paypal_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $pagado_paypal_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and  tienda = '" . $status_c['code_admin']. "' ORDER BY orders_status_name");
        while ($pagado_paypal = tep_db_fetch_array($pagado_paypal_query)) {
          $pagado_paypal_array[] = array('id' => $pagado_paypal['orders_status_id'],
                                  'text' => $pagado_paypal['orders_status_name']);
        }
        $contents[] = array('text' => '' . 'Paypal Pendiente: ' . '' . tep_draw_pull_down_menu('status_pagado_paypal_h', $pagado_paypal_array, $status_c['pagado_paypal']));



        $transferencia_pendiente_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $transferencia_pendiente_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and  tienda = '" . $status_c['code_admin']. "' ORDER BY orders_status_name");
        while ($transferencia_pendiente = tep_db_fetch_array($transferencia_pendiente_query)) {
          $transferencia_pendiente_array[] = array('id' => $transferencia_pendiente['orders_status_id'],
                                  'text' => $transferencia_pendiente['orders_status_name']);
        }
        $contents[] = array('text' => '' . 'Transferencia Pendiente: ' . '' . tep_draw_pull_down_menu('transferencia_pendiente_x', $transferencia_pendiente_array, $status_c['transferencia']));


       //    }// fin solo administradores





      $status_procesando_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $status_procesando_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and  tienda = '" . $status_c['code_admin']. "' ORDER BY orders_status_name");
        while ($status_procesando = tep_db_fetch_array($status_procesando_query)) {
          $status_procesando_array[] = array('id' => $status_procesando['orders_status_id'],
                                  'text' => $status_procesando['orders_status_name']);
        }
        $contents[] = array('text' => '' . '<p>&nbsp;</p><p>Pedidos Procesandose</p>Procesando: ' . '' . tep_draw_pull_down_menu('status_procesando_h', $status_procesando_array, $status_c['status_procesando']));



                     // solo administradores
    //  if ($mID == 14){


      $status_procesando_reembolso_internacional_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $status_procesando_reembolso_internacional_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and  tienda = '" . $status_c['code_admin']. "' ORDER BY orders_status_name");
        while ($status_procesando_reembolso_internacional = tep_db_fetch_array($status_procesando_reembolso_internacional_query)) {
          $status_procesando_reembolso_internacional_array[] = array('id' => $status_procesando_reembolso_internacional['orders_status_id'],
                                  'text' => $status_procesando_reembolso_internacional['orders_status_name']);
        }
        $contents[] = array('text' => '' . 'Procesando Reembolso Internacional: ' . '' . tep_draw_pull_down_menu('status_procesando_reembolso_internacional_h', $status_procesando_reembolso_internacional_array, $status_c['procesando_reembolso_internacional']));





      $status_transferencia_procesando_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $status_transferencia_procesando_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and  tienda = '" . $status_c['code_admin']. "' ORDER BY orders_status_name");
        while ($status_transferencia_procesando = tep_db_fetch_array($status_transferencia_procesando_query)) {
          $status_transferencia_procesando_array[] = array('id' => $status_transferencia_procesando['orders_status_id'],
                                  'text' => $status_transferencia_procesando['orders_status_name']);
        }
        $contents[] = array('text' => '' . 'Transferencia Procesando: ' . '' . tep_draw_pull_down_menu('status_transferencia_procesando_h', $status_transferencia_procesando_array, $status_c['transferencia_procesando']));




      $status_procesando_paypal_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $status_procesando_paypal_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and  tienda = '" . $status_c['code_admin']. "' ORDER BY orders_status_name");
        while ($status_procesando_paypal = tep_db_fetch_array($status_procesando_paypal_query)) {
          $status_procesando_paypal_array[] = array('id' => $status_procesando_paypal['orders_status_id'],
                                  'text' => $status_procesando_paypal['orders_status_name']);
        }
        $contents[] = array('text' => '' . 'Procesando por Paypal: ' . '' . tep_draw_pull_down_menu('status_procesando_paypal_h', $status_procesando_paypal_array, $status_c['procesando_paypal']));




            //     }// fin administradores




       $status_entregas_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $status_entregas_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and  tienda = '" . $status_c['code_admin']. "' ORDER BY orders_status_name");
        while ($status_entregas = tep_db_fetch_array($status_entregas_query)) {
          $status_entregas_array[] = array('id' => $status_entregas['orders_status_id'],
                                  'text' => $status_entregas['orders_status_name']);
        }
        $contents[] = array('text' => '' . '<p>&nbsp;</p><p>Entradas de Mercancias</p>Mercancía Entregada Procesando: ' . '' . tep_draw_pull_down_menu('status_entregas_h', $status_entregas_array, $status_c['status_entregas']));



      $entregas_stock_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $entregas_stock_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and  tienda = '" . $status_c['code_admin']. "' ORDER BY orders_status_name");
        while ($entregas_stock = tep_db_fetch_array($entregas_stock_query)) {
          $entregas_stock_array[] = array('id' => $entregas_stock['orders_status_id'],
                                  'text' => $entregas_stock['orders_status_name']);
        }
        $contents[] = array('text' => '' . 'Mercancia Entregada: ' . '' . tep_draw_pull_down_menu('entregas_stock_h', $entregas_stock_array, $status_c['entregas_stock']));


                         // solo administradores
      if ($mID == 14){

      $no_recogido_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $no_recogido_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and  tienda = '" . $status_c['code_admin']. "' ORDER BY orders_status_name");
        while ($no_recogido = tep_db_fetch_array($no_recogido_query)) {
          $no_recogido_array[] = array('id' => $no_recogido['orders_status_id'],
                                  'text' => $no_recogido['orders_status_name']);
        }
        $contents[] = array('text' => '' . 'Pedidos no Recogidos: ' . '' . tep_draw_pull_down_menu('no_recogido_h', $no_recogido_array, $status_c['no_recogido']));


      $cancelado_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $cancelado_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and  tienda = '" . $status_c['code_admin']. "' ORDER BY orders_status_name");
        while ($cancelado = tep_db_fetch_array($cancelado_query)) {
          $cancelado_array[] = array('id' => $cancelado['orders_status_id'],
                                  'text' => $cancelado['orders_status_name']);
        }
        $contents[] = array('text' => '' . 'Cancelado: ' . '' . tep_draw_pull_down_menu('cancelado_h', $cancelado_array, $status_c['cancelado']));


         }// fin administradores
         
         
         
         

     $status_salidas_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $status_salidas_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and  tienda = '" . $status_c['code_admin']. "' ORDER BY orders_status_name");
        while ($status_salidas = tep_db_fetch_array($status_salidas_query)) {
          $status_salidas_array[] = array('id' => $status_salidas['orders_status_id'],
                                  'text' => $status_salidas['orders_status_name']);
        }
        $contents[] = array('text' => '' . '<p>&nbsp;</p><p>Traspasos y Retiradas de Mercancias</p>Mercancía en proceso de Retirada: ' . '' . tep_draw_pull_down_menu('status_salidas_h', $status_salidas_array, $status_c['status_salidas']));



       $retirarado_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $retirarado_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and  tienda = '" . $status_c['code_admin']. "' ORDER BY orders_status_name");
        while ($retirarado = tep_db_fetch_array($retirarado_query)) {
          $retirarado_array[] = array('id' => $retirarado['orders_status_id'],
                                  'text' => $retirarado['orders_status_name']);
        }
        $contents[] = array('text' => '' . 'Mercancía Retirada: ' . '' . tep_draw_pull_down_menu('status_retirarado_h', $retirarado_array, $status_c['retirarado']));


        $abono_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $abono_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and  tienda = '" . $status_c['code_admin']. "' ORDER BY orders_status_name");
        while ($abono = tep_db_fetch_array($abono_query)) {
          $abono_array[] = array('id' => $abono['orders_status_id'],
                                  'text' => $abono['orders_status_name']);
        }
        $contents[] = array('text' => '' . '<p>&nbsp;</p><p>Otros tipos de Status.</p>Almacen: ' . '' . tep_draw_pull_down_menu('status_abono_h', $abono_array, $status_c['abono']));












     $status_liquidacion_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $status_liquidacion_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and  tienda = '" . $status_c['code_admin']. "' ORDER BY orders_status_name");
        while ($status_liquidacion = tep_db_fetch_array($status_liquidacion_query)) {
          $status_liquidacion_array[] = array('id' => $status_liquidacion['orders_status_id'],
                                  'text' => $status_liquidacion['orders_status_name']);
        }
        $contents[] = array('text' => '' . 'Pagos Procesando: ' . '' . tep_draw_pull_down_menu('status_liquidacion_h', $status_liquidacion_array, $status_c['status_liquidacion']));





      $peticiones_mercancias_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $peticiones_mercancias_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and  tienda = '" . $status_c['code_admin']. "' ORDER BY orders_status_name");
        while ($peticiones_mercancias = tep_db_fetch_array($peticiones_mercancias_query)) {
          $peticiones_mercancias_array[] = array('id' => $peticiones_mercancias['orders_status_id'],
                                  'text' => $peticiones_mercancias['orders_status_name']);
        }
        $contents[] = array('text' => '' . 'Peticiones de Mercancías: ' . '' . tep_draw_pull_down_menu('peticiones_mercancias_h', $peticiones_mercancias_array, $status_c['peticiones_mercancias']));



      $pendiente_entrada_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $pendiente_entrada_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and  tienda = '" . $status_c['code_admin']. "' ORDER BY orders_status_name");
        while ($pendiente_entrada = tep_db_fetch_array($pendiente_entrada_query)) {
          $pendiente_entrada_array[] = array('id' => $pendiente_entrada['orders_status_id'],
                                  'text' => $pendiente_entrada['orders_status_name']);
        }
        $contents[] = array('text' => '' . 'Pendiente de Entrada: ' . '' . tep_draw_pull_down_menu('pendiente_entrada_h', $pendiente_entrada_array, $status_c['pendiente_entrada']));



      $pendiente_entrada_entienda_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $pendiente_entrada_entienda_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and  tienda = '" . $status_c['code_admin']. "' ORDER BY orders_status_name");
        while ($pendiente_entrada_entienda = tep_db_fetch_array($pendiente_entrada_entienda_query)) {
          $pendiente_entrada_entienda_array[] = array('id' => $pendiente_entrada_entienda['orders_status_id'],
                                  'text' => $pendiente_entrada_entienda['orders_status_name']);
        }
        $contents[] = array('text' => '' . 'Pendiente de Entrada en Tienda: ' . '' . tep_draw_pull_down_menu('pendiente_entrada_entienda_h', $pendiente_entrada_entienda_array, $status_c['pendiente_entrada_entienda']));



      $presupuestos_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $presupuestos_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and  tienda = '" . $status_c['code_admin']. "' ORDER BY orders_status_name");
        while ($presupuestos = tep_db_fetch_array($presupuestos_query)) {
          $presupuestos_array[] = array('id' => $presupuestos['orders_status_id'],
                                  'text' => $presupuestos['orders_status_name']);
        }
        $contents[] = array('text' => '' . 'Presupuestos: ' . '' . tep_draw_pull_down_menu('presupuestos_h', $presupuestos_array, $status_c['presupuestos']));








      $recoger_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $recoger_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and  tienda = '" . $status_c['code_admin']. "' ORDER BY orders_status_name");
        while ($recoger = tep_db_fetch_array($recoger_query)) {
          $recoger_array[] = array('id' => $recoger['orders_status_id'],
                                  'text' => $recoger['orders_status_name']);
        }
        $contents[] = array('text' => '' . 'Recoger: ' . '' . tep_draw_pull_down_menu('recoger_h', $recoger_array, $status_c['recoger']));


      $facturado_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $facturado_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and  tienda = '" . $status_c['code_admin']. "' ORDER BY orders_status_name");
        while ($facturado = tep_db_fetch_array($facturado_query)) {
          $facturado_array[] = array('id' => $facturado['orders_status_id'],
                                  'text' => $facturado['orders_status_name']);
        }
        $contents[] = array('text' => '' . 'Facturado: ' . '' . tep_draw_pull_down_menu('facturado_h', $facturado_array, $status_c['facturado']));





      $esperando_respuesta_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $esperando_respuesta_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and  tienda = '" . $status_c['code_admin']. "' ORDER BY orders_status_name");
        while ($esperando_respuesta = tep_db_fetch_array($esperando_respuesta_query)) {
          $esperando_respuesta_array[] = array('id' => $esperando_respuesta['orders_status_id'],
                                  'text' => $esperando_respuesta['orders_status_name']);
        }
        $contents[] = array('text' => '' . 'Esperando Respuesta: ' . '' . tep_draw_pull_down_menu('esperando_respuesta_h', $esperando_respuesta_array, $status_c['esperando_respuesta']));





      $cambio_procesando_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $cambio_procesando_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and  tienda = '" . $status_c['code_admin']. "' ORDER BY orders_status_name");
        while ($cambio_procesando = tep_db_fetch_array($cambio_procesando_query)) {
          $cambio_procesando_array[] = array('id' => $cambio_procesando['orders_status_id'],
                                  'text' => $cambio_procesando['orders_status_name']);
        }
        $contents[] = array('text' => '' . 'Cambio Procesando: ' . '' . tep_draw_pull_down_menu('cambio_procesando_h', $cambio_procesando_array, $status_c['cambio_procesando']));



      $reserva_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $reserva_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and  tienda = '" . $status_c['code_admin']. "' ORDER BY orders_status_name");
        while ($reserva = tep_db_fetch_array($reserva_query)) {
          $reserva_array[] = array('id' => $reserva['orders_status_id'],
                                  'text' => $reserva['orders_status_name']);
        }
        $contents[] = array('text' => '' . 'Reserva: ' . '' . tep_draw_pull_down_menu('reserva_h', $reserva_array, $status_c['reserva']));





























     break;
    case 'del_member': 
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE . '</b>');
      if ($mInfo->admin_id == 1 || $mInfo->admin_email_address == STORE_OWNER_EMAIL_ADDRESS) {
      $contents[] = array('align' => 'center', 'text' => '<br><a href="' . tep_href_link(FILENAME_ADMIN_MEMBERS, 'page=' . $HTTP_GET_VARS['page'] . '&mID=' . $mInfo->admin_id) . '">' . tep_image_button('button_back.gif', IMAGE_BACK) . '</a><br>&nbsp;');
      } else {
      $contents = array('form' => tep_draw_form('edit', FILENAME_ADMIN_MEMBERS, 'action=member_delete&page=' . $page . '&mID=' . $admin['admin_id'], 'post', 'enctype="multipart/form-data"')); 
      $contents[] = array('text' => tep_draw_hidden_field('admin_id', $mInfo->admin_id));
      $contents[] = array('align' => 'center', 'text' =>  sprintf(TEXT_INFO_DELETE_INTRO, $mInfo->admin_firstname . ' ' . $mInfo->admin_lastname));    
      $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . tep_href_link(FILENAME_ADMIN_MEMBERS, 'page=' . $HTTP_GET_VARS['page'] . '&mID=' . $HTTP_GET_VARS['mID']) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');    
      }
      break;
    case 'new_group':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_GROUPS . '</b>');

      $contents = array('form' => tep_draw_form('new_group', FILENAME_ADMIN_MEMBERS, 'action=group_new&gID=' . $gInfo->admin_groups_id, 'post', 'enctype="multipart/form-data"')); 
      if ($HTTP_GET_VARS['gName'] == 'false') {
        $contents[] = array('text' => TEXT_INFO_GROUPS_NAME_FALSE . '<br>&nbsp;');
      } elseif ($HTTP_GET_VARS['gName'] == 'used') {
        $contents[] = array('text' => TEXT_INFO_GROUPS_NAME_USED . '<br>&nbsp;');
      }
      $contents[] = array('text' => tep_draw_hidden_field('set_groups_id', substr($add_groups_prepare, 4)) );
      $contents[] = array('text' => TEXT_INFO_GROUPS_NAME . '<br>');      
      $contents[] = array('align' => 'center', 'text' => tep_draw_input_field('admin_groups_name'));      
      $contents[] = array('align' => 'center', 'text' => '<br><a href="' . tep_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $gInfo->admin_groups_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a> ' . tep_image_submit('button_next.gif', IMAGE_NEXT) );    
      break;
    case 'edit_group': 
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_GROUP . '</b>');

      $contents = array('form' => tep_draw_form('edit_group', FILENAME_ADMIN_MEMBERS, 'action=group_edit&gID=' . $HTTP_GET_VARS['gID'], 'post', 'enctype="multipart/form-data"')); 
      if ($HTTP_GET_VARS['gName'] == 'false') {
        $contents[] = array('text' => TEXT_INFO_GROUPS_NAME_FALSE . '<br>&nbsp;');
      } elseif ($HTTP_GET_VARS['gName'] == 'used') {
        $contents[] = array('text' => TEXT_INFO_GROUPS_NAME_USED . '<br>&nbsp;');
      }      
      $contents[] = array('align' => 'center', 'text' => TEXT_INFO_EDIT_GROUP_INTRO . '<br>&nbsp;<br>' . tep_draw_input_field('admin_groups_name', $gInfo->admin_groups_name)); 
      $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . tep_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $gInfo->admin_groups_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');    
      break;
    case 'del_group': 
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_GROUPS . '</b>');

      $contents = array('form' => tep_draw_form('delete_group', FILENAME_ADMIN_MEMBERS, 'action=group_delete&gID=' . $gInfo->admin_groups_id, 'post', 'enctype="multipart/form-data"')); 
      if ($gInfo->admin_groups_id == 1) {
        $contents[] = array('align' => 'center', 'text' => sprintf(TEXT_INFO_DELETE_GROUPS_INTRO_NOT, $gInfo->admin_groups_name));
        $contents[] = array('align' => 'center', 'text' => '<br><a href="' . tep_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $HTTP_GET_VARS['gID']) . '">' . tep_image_button('button_back.gif', IMAGE_BACK) . '</a><br>&nbsp;');
      } else {
        $contents[] = array('text' => tep_draw_hidden_field('set_groups_id', substr($del_groups_prepare, 4)) );
        $contents[] = array('align' => 'center', 'text' => sprintf(TEXT_INFO_DELETE_GROUPS_INTRO, $gInfo->admin_groups_name));    
        $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . tep_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $HTTP_GET_VARS['gID']) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a><br>&nbsp;');    
      }
      break;
    case 'define_group':      
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DEFINE . '</b>');
      	
      $contents[] = array('text' => sprintf(TEXT_INFO_DEFINE_INTRO, $group_name['admin_groups_name']));
      if ($HTTP_GET_VARS['gPath'] == 1) {
        $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $HTTP_GET_VARS['gPath']) . '">' . tep_image_button('button_back.gif', IMAGE_CANCEL) . '</a><br>');      
      }
      break;
    case 'show_group': 
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_GROUP . '</b>');
        $check_email_query = tep_db_query("select admin_email_address from " . TABLE_ADMIN . "");
        //$stored_email[];
        while ($check_email = tep_db_fetch_array($check_email_query)) {
          $stored_email[] = $check_email['admin_email_address'];
        }
        
        if (in_array($HTTP_POST_VARS['admin_email_address'], $stored_email)) {
          $checkEmail = "true";
        } else {
          $checkEmail = "false";
        }
      $contents = array('form' => tep_draw_form('show_group', FILENAME_ADMIN_MEMBERS, 'action=show_group&gID=groups', 'post', 'enctype="multipart/form-data"')); 
      $contents[] = array('text' => $define_files['admin_files_name'] . tep_draw_input_field('level_edit', $checkEmail)); 
      //$contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_insert.gif', IMAGE_INSERT) . ' <a href="' . tep_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $gInfo->admin_groups_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');    
      break;
    default:
      if (is_object($mInfo)) {
        $heading[] = array('text' => '<b>&nbsp;' . TEXT_INFO_HEADING_DEFAULT . '</b>');
        $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_ADMIN_MEMBERS, 'page=' . $HTTP_GET_VARS['page'] . '&mID=' . $mInfo->admin_id . '&action=edit_member') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link(FILENAME_ADMIN_MEMBERS, 'page=' . $HTTP_GET_VARS['page'] . '&mID=' . $mInfo->admin_id . '&action=del_member') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a><br>&nbsp;');
        $contents[] = array('text' => '&nbsp;<b>' . TEXT_INFO_FULLNAME . '</b><br>&nbsp;' . $mInfo->admin_firstname . ' ' . $mInfo->admin_lastname);
        $contents[] = array('text' => '&nbsp;<b>' . TEXT_INFO_EMAIL . '</b><br>&nbsp;' . $mInfo->admin_email_address);
        $contents[] = array('text' => '&nbsp;<b>' . TEXT_INFO_GROUP . '</b>' . $mInfo->admin_groups_name);
        $contents[] = array('text' => '&nbsp;<b>' . TEXT_INFO_CREATED . '</b><br>&nbsp;' . $mInfo->admin_created);
        $contents[] = array('text' => '&nbsp;<b>' . TEXT_INFO_MODIFIED . '</b><br>&nbsp;' . $mInfo->admin_modified);
        $contents[] = array('text' => '&nbsp;<b>' . TEXT_INFO_LOGDATE . '</b><br>&nbsp;' . $mInfo->admin_logdate);
        $contents[] = array('text' => '&nbsp;<b>' . TEXT_INFO_LOGNUM . '</b>' . $mInfo->admin_lognum);
        $contents[] = array('text' => '<br>');
      } elseif (is_object($gInfo)) {
        $heading[] = array('text' => '<b>&nbsp;' . TEXT_INFO_HEADING_DEFAULT_GROUPS . '</b>');
        
        $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_ADMIN_MEMBERS, 'gPath=' . $gInfo->admin_groups_id . '&action=define_group') . '">' . tep_image_button('button_admin_permission.gif', IMAGE_FILE_PERMISSION) . '</a> <a href="' . tep_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $gInfo->admin_groups_id . '&action=edit_group') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $gInfo->admin_groups_id . '&action=del_group') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a>');
        $contents[] = array('text' => '<br>' . TEXT_INFO_DEFAULT_GROUPS_INTRO . '<br>&nbsp');
      }
  }
  
  if ( (tep_not_null($heading)) && (tep_not_null($contents)) ) {
    echo '            <td width="25%" valign="top">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' . "\n";
  }
?>
          </tr>
        </table></td>
      </tr>
    </table></td>  
<!-- body_text_eof //-->
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
