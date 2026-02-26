<?php
/*
  create_account.php
  osCommerce, Open Source E-Commerce Solutions
*/

require('includes/application_top.php');

// BOF Anti Robot Registration v4.5
if (ACCOUNT_VALIDATION == 'true' && ACCOUNT_CREATE_VALIDATION == 'true') {
    require('includes/languages/' . $language . '/account_validation.php');
    include_once('includes/functions/account_validation.php');
}
// EOF Anti Robot Registration v4.5

require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CREATE_ACCOUNT);
require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_LOGIN);

$process = false;
if (isset($_POST['action']) && $_POST['action'] == 'process' && isset($_POST['formid']) && $_POST['formid'] == $sessiontoken) {
    $process = true;

    // Recoger campos
    if (ACCOUNT_GENDER == 'true') {
        $gender = $_POST['gender'] ?? false;
    }
    $firstname = tep_db_prepare_input($_POST['firstname']);
    $lastname = tep_db_prepare_input($_POST['lastname']);
    $billetera = tep_db_prepare_input($_POST['billetera']);
    $account_dninie = tep_db_prepare_input($_POST['account_dninie']);
    $dob = ACCOUNT_DOB == 'true' ? tep_db_prepare_input($_POST['dob']) : '';
    $email_address = tep_db_prepare_input($_POST['email_address']);
    $company = ACCOUNT_COMPANY == 'true' ? tep_db_prepare_input($_POST['company']) : '';
    $street_address = tep_db_prepare_input($_POST['street_address']);
    $suburb = ACCOUNT_SUBURB == 'true' ? tep_db_prepare_input($_POST['suburb']) : '';
    $postcode = tep_db_prepare_input($_POST['postcode']);
    $city = tep_db_prepare_input($_POST['city']);
    $state = ACCOUNT_STATE == 'true' ? tep_db_prepare_input($_POST['state']) : '';
    $zone_id = isset($_POST['zone_id']) ? tep_db_prepare_input($_POST['zone_id']) : false;
    $country = tep_db_prepare_input($_POST['country']);
    $telephone = tep_db_prepare_input($_POST['telephone']);
    $fax = tep_db_prepare_input($_POST['fax']);
    $newsletter = isset($_POST['newsletter']) ? tep_db_prepare_input($_POST['newsletter']) : false;
    $password = tep_db_prepare_input($_POST['password']);
    $confirmation = tep_db_prepare_input($_POST['confirmation']);

    $error = false;

    // Validaciones básicas
    if (ACCOUNT_GENDER == 'true' && !in_array($gender, ['m','f'])) {
        $error = true;
        $messageStack->add('create_account', ENTRY_GENDER_ERROR);
    }
    if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
        $error = true;
        $messageStack->add('create_account', ENTRY_FIRST_NAME_ERROR);
    }
    if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
        $error = true;
        $messageStack->add('create_account', ENTRY_LAST_NAME_ERROR);
    }
    if (ACCOUNT_DOB == 'true' && (!empty($dob) && (!is_numeric(tep_date_raw($dob)) || !@checkdate(substr(tep_date_raw($dob), 4, 2), substr(tep_date_raw($dob), 6, 2), substr(tep_date_raw($dob), 0, 4))))) {
        $error = true;
        $messageStack->add('create_account', ENTRY_DATE_OF_BIRTH_ERROR);
    }
    if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH || !tep_validate_email($email_address)) {
        $error = true;
        $messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_ERROR);
    } else {
        $check_email_query = tep_db_query("SELECT COUNT(*) AS total FROM " . TABLE_CUSTOMERS . " WHERE customers_email_address = '" . tep_db_input($email_address) . "'");
        $check_email = tep_db_fetch_array($check_email_query);
        if ($check_email['total'] > 0) {
            $error = true;
            $messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_ERROR_EXISTS);
        }
    }
    if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
        $error = true;
        $messageStack->add('create_account', ENTRY_STREET_ADDRESS_ERROR);
    }
    if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
        $error = true;
        $messageStack->add('create_account', ENTRY_CITY_ERROR);
    }
    if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
        $error = true;
        $messageStack->add('create_account', ENTRY_POST_CODE_ERROR);
    }
    if (!is_numeric($country)) {
        $error = true;
        $messageStack->add('create_account', ENTRY_COUNTRY_ERROR);
    }
    if (ACCOUNT_STATE == 'true') {
        $zone_id = 0;
        $check_query = tep_db_query("SELECT COUNT(*) AS total FROM " . TABLE_ZONES . " WHERE zone_country_id = '" . (int)$country . "'");
        $check = tep_db_fetch_array($check_query);
        $entry_state_has_zones = ($check['total'] > 0);
        if ($entry_state_has_zones == true) {
            $zone_query = tep_db_query("SELECT DISTINCT zone_id FROM " . TABLE_ZONES . " WHERE zone_country_id = '" . (int)$country . "' AND (zone_name = '" . tep_db_input($state) . "' OR zone_code = '" . tep_db_input($state) . "')");
            if (tep_db_num_rows($zone_query) == 1) {
                $zone = tep_db_fetch_array($zone_query);
                $zone_id = $zone['zone_id'];
            } else {
                $error = true;
                $messageStack->add('create_account', ENTRY_STATE_ERROR_SELECT);
            }
        } else {
            if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {
                $error = true;
                $messageStack->add('create_account', ENTRY_STATE_ERROR);
            }
        }
    }
    if (strlen($telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
        $error = true;
        $messageStack->add('create_account', ENTRY_TELEPHONE_NUMBER_ERROR);
    }
    if (strlen($password) < ENTRY_PASSWORD_MIN_LENGTH) {
        $error = true;
        $messageStack->add('create_account', ENTRY_PASSWORD_ERROR);
    } elseif ($password != $confirmation) {
        $error = true;
        $messageStack->add('create_account', ENTRY_PASSWORD_ERROR_NOT_MATCHING);
    }

    // BOF Anti Robot Registration v4.5
    if (ACCOUNT_VALIDATION == 'true' && ACCOUNT_CREATE_VALIDATION == 'true') {
        $entry_antirobotreg_error = false;
        if (!isset($_POST['antirobotreg']) || empty($_POST['antirobotreg'])) {
            $entry_antirobotreg_error = true;
        } else {
            $antirobotreg = tep_db_prepare_input($_POST['antirobotreg']);
            include('includes/modules/validation_check.php');
        }
        if ($entry_antirobotreg_error == true) {
            $error = true;
            $messageStack->add('create_account', $text_antirobotreg_error);
        }
    }
    // EOF Anti Robot Registration v4.5

    // Si no hay errores -> guardar usuario
    if ($error == false) {
        // Código para insertar en base de datos...
        // (Mantengo tu código actual aquí)
        tep_redirect(tep_href_link(FILENAME_CREATE_ACCOUNT_SUCCESS, '', 'SSL'));
    }
}

// Breadcrumb
$breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'));

// Headers anti cache para captcha
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("cache-Control: no-cache, no-store, must-revalidate");
header("pragma: no-cache");

require(DIR_WS_INCLUDES . 'template_top.php');
require('includes/form_check.js.php');
?>

<?php
if ($messageStack->size('create_account') > 0) {
    echo $messageStack->output('create_account');
}
?>

<div class="contentContainer">
    <div class="contentText">
        <?php echo tep_draw_form('create_account', tep_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'), 'post', 'onsubmit="return check_form(create_account);"', true) . tep_draw_hidden_field('action', 'process'); ?>

        <!-- Campos de formulario (nombre, email, telefono...) -->
        <table border="0" cellspacing="2" cellpadding="2" width="100%">
            <tr>
                <td class="fieldKey"><?php echo ENTRY_FIRST_NAME; ?></td>
                <td class="fieldValue"><?php echo tep_draw_input_field('firstname'); ?></td>
            </tr>
            <tr>
                <td class="fieldKey"><?php echo ENTRY_LAST_NAME; ?></td>
                <td class="fieldValue"><?php echo tep_draw_input_field('lastname'); ?></td>
            </tr>
            <tr>
                <td class="fieldKey"><?php echo ENTRY_EMAIL_ADDRESS; ?></td>
                <td class="fieldValue"><?php echo tep_draw_input_field('email_address'); ?></td>
            </tr>
        </table>

        <!-- BOF Anti Robot Registration v4.5 -->
             <div class="contentText">
                <table border="0" cellspacing="2" cellpadding="2" width="100%">
                    <tr>
                        <td class="fieldKey"><?php echo ENTRY_ANTIROBOTREG; ?></td>
                        <td class="fieldValue">
                            <?php echo tep_draw_input_field('antirobotreg', '', 'size="6" maxlength="6" autocomplete="off"'); ?><br>
                            <img src="<?php echo tep_href_link('includes/modules/validation_image.php'); ?>" alt="Captcha" style="margin-top:5px;border:1px solid #ccc;"><br>
                            <small><?php echo ENTRY_ANTIROBOTREG_TEXT; ?></small>
                        </td>
                    </tr>
                </table>
            </div>

        <!-- EOF Anti Robot Registration v4.5 -->

        <div class="buttonSet">
            <span class="buttonAction"><?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'person', null, 'primary'); ?></span>
        </div>

    </form>
</div>

<?php
require(DIR_WS_INCLUDES . 'template_bottom.php');
require(DIR_WS_INCLUDES . 'application_bottom.php');
?>

