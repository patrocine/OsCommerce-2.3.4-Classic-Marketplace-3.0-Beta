<?php
/*
  $Id: template_main.php,v 1.0 17:37:59 06/17/2009  

  Mian template class for AlgoZone AFTS templates

  Copyright (c) 2009 AlgoZone, Inc (www.algozone.com)

*/

//Include for template files
$tmpl_id = 'OSC2310002';
require_once('mapping/vars_map.php');

//Build hheader/footer/columns on the include of this file and store it for future use
ob_start(); 
// Collection of css included to the template.
// template_styles.css - Template Specific CSS
//#### HEADER CSS #########

?>
    <link rel="stylesheet" type="text/css" href="<?php echo  TMPL_CSS ?>template_styles.css" />
    <!--[if lt IE 8 ]><link rel="stylesheet" type="text/css" href="<?php echo  TMPL_CSS ?>template_styles_ie.css" /><![endif]-->    
    <link rel="stylesheet" type="text/css" href="<?php echo  TMPL_CSS ?>cart_styles.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo  TMPL_CSS ?>intro_boxes_styles.css" />
	
<!--[if lte IE 6]>
<style type="text/css">
 	img, .topbox_sep, .content_mid, 
	.az-button-left, .azbutton_left, .az-button-right, .azbutton_right, 
	.az-button-left2, .azbutton_left2, .az-button-right2, .azbutton_right2, 
	.az-button-left3, .azbutton_left3, .az-button-right3, .azbutton_right3 {
		behavior: url(<?php echo  TMPL_CSS ?>iepngfix.htc);
	}
</style>
<![endif]-->

<!--[if IE 8]>
<style type="text/css">
 	.min_height_ie8{ min-height:507px}
 	.min_height_normal{ min-height:335px}
</style>
<![endif]-->

 <!--[if IE 9]>
<style type="text/css">
 	.buttonSet {
    padding-top: 10px;
}
</style>
<![endif]-->
   
<?php
//#### END HEADER CSS #########
$az_html['css'] = ob_get_contents(); 
ob_end_clean();

ob_start(); 
?>
<?php
$az_html['js'] = ob_get_contents(); 
ob_end_clean(); 

ob_start(); 
// HTML Code for the header of the template
//#### HEADER HTML #########
?>
 
<div class="wrapper <?php echo ($tmpl['cfg']['main_page'] ? 'main_page' : 'default_page'); ?> " align="center">
	  	
	<div class="az_main_container">
				
		<div class="f_left header_store_name"><?php include(TMPL_BOXES . 'az_logo_box.php');?></div>
					
			<!--header_boxes-->
			<div class="f_right header_boxes">
					
							<?php include(TMPL_BOXES . 'az_shopping_cart.php');?>
							<div class="f_right header_box_lang"><?php require(TMPL_BOXES . 'az_languages.php'); ?></div>
							<div class="f_right header_box_currencies"><?php require(TMPL_BOXES . 'az_currencies.php'); ?></div>
							<div class="clear"></div>
							<div class="space_1"></div>
							<div class="f_right header_box_search"><?php include(TMPL_BOXES . 'az_search.php');?></div>
       
 <?php
                            if (DESCUENTO_CLIENTE){

                             $sumar_ofertas_sales_raw = "select sum(products_descuento_onoff) as value, count(*) as products_descuento_onoff from " . TABLE_PRODUCTS . " where products_descuento_onoff = 1 and products_status = 1";
    $sumar_ofertas_sales_query = tep_db_query($sumar_ofertas_sales_raw);
    $sumar_ofertas= tep_db_fetch_array($sumar_ofertas_sales_query);
echo '<b>Descuento del ' . DESCUENTO_CLIENTE . '% en '.$sumar_ofertas['value'].' Productos</b>';
                                               }


             ?>
       
							<!--menu-->
							<div class="f_right">
								<ul class="topmenu">
									<li><a href="<?php echo $tmpl['url']['loginout'] ?>"><?php echo $tmpl['txt']['loginout'] ?></a></li>
									<li><a href="<?php echo $tmpl['url']['checkout'] ?>"><?php echo $tmpl['txt']['checkout'] ?></a></li>
									<li><a href="<?php echo $tmpl['url']['cart'] ?>"><?php echo 'Carrito de Compras' ?></a></li>
									<li><a href="<?php echo $tmpl['url']['create_account'] ?>"><?php echo $tmpl['txt']['create_account'] ?></a></li>
					</ul>
							</div>
							<!--menu-->
							<div class="clear"></div>
					
			</div>
						
			<!--header_boxes-->
			<div class="clear"></div>
							   
			<!--categ-->
			<?php require(TMPL_BOXES . 'az_categories.php'); ?>
			<!--categ-->
			
			<?php if ( $tmpl['cfg']['main_page'] ) { 
	//		require(TMPL_BOXES . 'az_slider.php');
		require(TMPL_BOXES . 'az_slider_new_products.php');

			 } ?>
			
			
			
			<?php if ( !$tmpl['cfg']['main_page'] ) { ?><div class="space_4">&nbsp;</div> <?php } ?>
						   
	</div>
			 
      <div class="az_main_container">
		<div class="az_wrapper_color">	
	  
		<div class="space_3">&nbsp;</div>
<?php
//#### END HEADER HTML #########
$az_html['header'] = ob_get_contents();
ob_end_clean(); 

ob_start(); 
// HTML Code for the footer of the template
//#### FOOTER HTML #########
?>
		
		
		
		</div>
		
		
		
	<!-- class="az_main_container" -->
		</div>
		
		<!-- footer //-->
		<div class="footer_box">
			<div class="footer_width_pad"><?php require(TMPL_BOXES . 'az_information_footer.php'); ?></div>
		</div>
		<div align="left" class="footer_copyright"><?php echo $tmpl['txt']['copyright'] ?></div>
		<!-- footer //-->

		</div>

    	

	

<?php include(TMPL_BOXES . 'az_socials.php');?>


<?php
//#### END FOOTER HTML #########
$az_html['footer'] = ob_get_contents(); 
ob_end_clean(); 

ob_start(); 
// HTML Code for the main content section of the template, top part
//#### CONTENT TOP HTML #########
?>
		<div class="az_main_content">
		
			
				<?php if ( !$tmpl['cfg']['main_page'] ) { ?>
				<!-- class="az_left_bar -->
				<div class="az_left_bar col-left side-col">
					<div class="az_left_bar_inner">	
						<!-- left_navigation //-->
						<?php require(TMPL_INC_DIR . 'az_tmpl_column_left.php'); ?>
						<!-- left_navigation_eof //-->
  				<div class="main_part_title"><?php// echo BOX_TAGS; ?></div>

						<?php// require(TMPL_BOXES . 'az_flash.php'); ?>
					</div>
				</div>
				<!-- class="az_left_bar -->
				<?php } ?>
			
			<div class="az_site_content">

				<div class="az_site_content_inner">
				<?php if (!$tmpl['cfg']['main_page'] ) {require(TMPL_BOXES . 'az_bread_crumbs.php');} ?>
				
	<?php
	//#### END CONTENT TOP HTML #########
	$az_html['content_top'] = ob_get_contents(); 
	ob_end_clean(); 
	
	ob_start(); 
	// HTML Code for the main content section of the template, bottom part
	//#### CONTENT BOTTOM HTML #########
	?>
							
				<div class="clear"></div>
							
				</div>
			</div>
			
			
			
			<!-- class="az_site_content" -->
			
			
		   <div class="clear"></div>
		</div>
		<!-- class="az_main_content" -->
<?php
//#### END CONTENT BOTTOM HTML #########
$az_html['content_bot'] = ob_get_contents(); 
ob_end_clean(); 

$GLOBALS['az_html'] = $az_html;
if (!class_exists('azTmpl', false)) {
    class azTmpl {
    
    	// class constructor
		function azTmpl($html='', $direct_output = false) {
			if(empty($html)) {
				$this->html = $GLOBALS['az_html'];
			} else {
				$this->html = $html;
			}
		}    
		
    	function az_tmpl_css () {
    		echo $this->html['css'];
    	}
    
    	function az_tmpl_js () {
    		echo $this->html['js'];
    	}
    	
    	function az_tmpl_header () {
    		echo $this->html['header'];
    	}
    	
    	function az_tmpl_footer () {
    		echo $this->html['footer'];
    	}
    	
    	function az_tmpl_content_top () {
    		echo $this->html['content_top'];
    	}
    	
    	function az_tmpl_content_bottom () {
    		echo $this->html['content_bot'];
    	}
    	
    }
}
?>
