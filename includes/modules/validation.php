<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  https://www.oscommerce.com

  Copyright (c) 2017 osCommerce

  Released under the GNU General Public License
*/
?>

<h2><?php //echo CATEGORY_ANTIROBOTREG; ?></h2>
  <div class="contentText">
    <div class="form-group has-feedback">
      <label for="AntirobotReg" class="control-label col-sm-3"><?php echo 'Escriba el código de validación de 3 letras que le aparece en el recuadro'; ?></label>
      <div class="col-sm-9">

<?php
  if ($is_read_only == false ) {
    $sql = "DELETE FROM anti_robotreg WHERE timestamp < '" . (time() - 3600) . "' OR session_id = '" . tep_session_id() . "'";
    if ( !$result = tep_db_query($sql) ) {
      die('Could not delete validation key');
    }
    $reg_key = gen_reg_key();
    $sql = "INSERT INTO anti_robotreg VALUES ('" . tep_session_id() . "', '" . $reg_key . "', '" . time() . "')";
    if ( !$result = tep_db_query($sql) ) {
      die('Could not check registration information');
	}

    $check_anti_robotreg_query = tep_db_query("select session_id, reg_key, timestamp from anti_robotreg where session_id = '" . tep_session_id() . "'");
    $new_guery_anti_robotreg = tep_db_fetch_array($check_anti_robotreg_query);
	if (empty($new_guery_anti_robotreg['session_id'])) echo 'Error, unable to read session id.';
    $validation_images = tep_image_captcha('validation_png.php?rsid=' . $new_guery_anti_robotreg['session_id'] .'&csh='.uniqid(0), 'name="Captcha" vspace="8" border="1"');

 	if ($validated == CODE_CHECKED && strlen($validated)) echo VALIDATED . tep_draw_hidden_field('validated',CODE_CHECKED);
      else
 echo $validation_images;
 ?>
 

 
      <?php
    if ($validated != CODE_CHECKED || strlen($validated) == 0) {
?>
<script type="text/javascript" >
  var valid_image = new Image();
  valid_image.src = "validation_png.php?rsid=<?php echo $new_guery_anti_robotreg['session_id'] . '&csh='.uniqid(0); ?>";
  var valid_image2 = new Image();
  valid_image2.src = "validation_png.php?rsid=<?php echo $new_guery_anti_robotreg['session_id'] . '&csh='.uniqid(0); ?>";
  var vImage = 2;
  function swap() {
    switch (vImage) {
	  case 1:
      vImage = 2
      return(false);
      case 2:
      vImage = 1
      return(true);
	  default :
	  vImage = 2 
	  return(false);
    }
  }
  document.writeln('<a onMousedown=" if ( swap() ) { Captcha.src=valid_image.src; } else { Captcha.src=valid_image2.src; } ">')
</script>



<?php



	echo tep_draw_input_field('antirobotreg', '', 'required aria-required="true" placeholder="' . '' . $new_guery_anti_robotreg['reg_key'] . '"', '', true) . ' ' . ($entry_antirobotreg_error ? '<strong><span style="color: #ff0000;">' . $text_antirobotreg_error . '</span></strong>' : 'Escriba el Codigo de 3 letras en el mismo recuadro');
    }

  }
?>

      </div>
    </div>
  </div>
