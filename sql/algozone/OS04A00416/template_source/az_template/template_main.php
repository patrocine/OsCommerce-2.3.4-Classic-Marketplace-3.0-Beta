<?php
/*
  $Id: template_main.php,v 1.0 17:37:59 06/17/2009  

  Mian template class for AlgoZone AFTS templates

  Copyright (c) 2009 AlgoZone, Inc (www.algozone.com)

*/

//Include for template files
$tmpl_id = 'OS04A00416';

require_once('mapping/vars_map.php');

ob_start(); 
// Collection of css included to the template.
// template_styles.css - Template Specific CSS
// cart_styles.css - Override for cart stiles
//#### HEADER CSS #########
?>
<link rel="stylesheet" type="text/css" href="<?php echo TMPL_CSS;?>template_styles.css" />
<!--[if IE 7]><link rel="stylesheet" type="text/css" href="<?php echo  TMPL_CSS ?>template_styles_ie7.css" /><![endif]--> 
<link rel="stylesheet" type="text/css" href="<?php echo TMPL_CSS;?>animebox.css" />
<link rel="stylesheet" type="text/css" href="<?php echo TMPL_CSS;?>az_drop_menu_styles.css" />
<?php
//#### END HEADER CSS #########
$az_html['css'] = ob_get_contents(); 
ob_end_clean(); 

ob_start(); 
// Collection of JavaScreepts included to the template
//#### HEADER JS #########
?>
<script type="text/javascript">
<!--
	var	image_width 		= '<?php echo $tmpl['img']['cart_width']; ?>';
	var	image_height 		= '<?php echo $tmpl['img']['cart_height']; ?>';
	var	text_cart_quantity 	= '<?php echo $tmpl['txt']['cart_qty']; ?>';
	var	text_cart_subtotal	= '<?php echo $tmpl['txt']['cart_subtotal']; ?>';
	var	text_cart_empty		= '<?php echo $tmpl['txt']['cart_empty']; ?>';
	var	cart_text		    = '<?php echo $tmpl['txt']['cart_text']; ?>';
	var	cart_link		    = '<?php echo $tmpl['url']['cart']; ?>';
	var session_id          = '<?php echo $tmpl['session_param']; ?>';
	var	fetch_url		    = '<?php echo $tmpl['url']['cart_fetch']; ?>';
//-->
</script>
<script type="text/javascript" src="<?php echo TMPL_JS;?>jquery.js"></script>
<script type="text/javascript" src="<?php echo TMPL_JS;?>generic.js"></script>
<script type="text/javascript" src="<?php echo TMPL_JS;?>animebox.js"></script>
<script type="text/javascript" src="<?php echo TMPL_JS;?>az_drop_menu.js"></script>
<?php
//#### END HEADER JS #########
$az_html['js'] = ob_get_contents();
ob_end_clean();

ob_start(); 
// HTML Code for the header of the template
//#### HEADER HTML #########
?>
  <div id="az_page_wrapper">
	
	<div id="az_main_container_border">
	
	<div id="az_main_container">
	
	<div id="az_main_container_top_l">
	  <div id="az_main_container_top_r">
	    <div id="az_main_container_top_m"></div>
	  </div>
	</div>
	
	<div id="az_main_container_side_l">
	  <div id="az_main_container_side_r">
	
	  <div id="az_main_header">
	    
		<div id="az_topbox_sep"></div>
	    
<!--		<div id="az_header_top_l">
		  <div id="az_header_top_r">
		    <div id="az_header_top_m"></div>
		  </div>
		</div>
-->		
<!--		<div id="az_header_left">
		  <div id="az_header_right">
		    <div id="az_header_mid">			
-->
            <div id="az_header">
		      <div id="az_header_logo"><a href="<?php echo $tmpl['url']['index'];?>"></a></div>
		      <div id="az_header_banner">
			    <span id="az_banner_text1"><?php echo $tmpl['txt']['banner_text1']; ?></span>
			    <span id="az_banner_text2"><a href="<?php echo $tmpl['url']['checkout'];?>"><?php echo $tmpl['txt']['banner_text2']; ?></a></span>
			    <span id="az_banner_text3"><a href="<?php echo $tmpl['url']['newproducts'];?>"><?php echo $tmpl['txt']['banner_text3']; ?></a></span>
			  </div>
			  <div id="az_search_box"><?php require(TMPL_BOXES . 'az_search.php'); ?></div>
            </div>
<!--			</div>
		  </div>
		</div>
-->		
<!--		<div id="az_header_bottom_l">
		  <div id="az_header_bottom_r">
		    <div id="az_header_bottom_m"></div>
		  </div>
		</div>
-->		
		<div id="az_info_bar">
		  <div id="az_info_bar_bottom">
		  
	      <div class="az_info_bar_1">
		    <div id="az_main_menu">
			  <div id="az_main_menu_l"></div>
			  <div id="az_menubarmain">
		      	<ul>				  
				  <li class="az_main_menu_start"><a href="<?php echo $tmpl['url']['index'];?>"><span><?php echo $tmpl['txt']['home'];?></span></a></li>
		          <li><a href="<?php echo $tmpl['url']['newproducts'];?>"><span><?php echo $tmpl['txt']['products'];?></span></a></li>
				  <li><a href="<?php echo $tmpl['url']['specials'];?>"><?php echo $tmpl['txt']['specials'];?></a></li>
				  <li><a href="<?php echo $tmpl['url']['contact'];?>"><span><?php echo $tmpl['txt']['contact'];?></span></a></li>
				  <li><a href="<?php echo $tmpl['url']['cart'];?>"><span><?php echo $tmpl['txt']['cart'];?></span></a></li>
				  <li class="az_main_menu_end"><a href="<?php echo $tmpl['url']['account'];?>"><span><?php echo $tmpl['txt']['members'];?></span></a></li>
		      	</ul>
		      </div>
			  <div id="az_main_menu_r"></div>
			</div>
		  </div>
		  <div class="az_info_bar_2"><div id="btn_animBoxCart"><?php require(TMPL_BOXES . 'az_shopping_cart.php'); ?></div></div>
		  <div class="clear"></div>
		  
		  </div>
	    </div><div id="animBoxCart"></div>
		
		<div id="az_category_menu_box"><?php require(TMPL_BOXES . 'az_categories.php'); ?></div>
		
	  </div>

<?php
//#### END HEADER HTML #########
$az_html['header'] = ob_get_contents();
ob_end_clean(); 

ob_start(); 
// HTML Code for the footer of the template
//#### FOOTER HTML #########
?>
	  <div id="az_main_footer"><!-- footer //-->
		
<!--		<div id="az_left_bar_footer">
		  <div id="az_right_bar_footer">
	
		<div id="az_mid_bar_footer">
-->		  <div id="az_footer_menu_tb"><?php require(TMPL_BOXES . 'az_information.php'); ?></div>
		  <div id="az_loginbox"><?php require(TMPL_BOXES.'az_loginbox.php');?></div>
<!--		</div>
			
		  </div>
		</div>
-->		
	  </div><!-- class="az_main_footer" -->
	
	  </div><!-- az_main_container_side_r -->
	</div><!-- az_main_container_side_l -->
	
	<div id="az_main_container_bottom_l">
	  <div id="az_main_container_bottom_r">
		<div id="az_main_container_bottom_m"></div>
	  </div>
	</div>
	
	<div id="az_footer_note"><?php echo $tmpl['txt']['copyright'];?></div>
	
	</div><!-- class="az_main_container" -->
	
	</div><!-- class="az_main_container_border" -->
	
  </div>
<?php
//#### END FOOTER HTML #########
$az_html['footer'] = ob_get_contents();
ob_end_clean(); 

ob_start(); 
// HTML Code for the main content section of the template, top part
//#### CONTENT TOP HTML #########
?>
		<div id="az_main_content">
	
		  <?php if($tmpl['cfg']['left_column']) { ?>
		  <div id="az_left_bar">
			<div id="az_left_bar_top"></div>
	
			<!-- left_navigation //-->
			<div id="az_left_bar_mid" align="right"><?php require(TMPL_INC_DIR . 'az_tmpl_column_left.php'); ?></div>
			<!-- left_navigation_eof //-->
	 			
			<div id="az_left_bar_bottom"></div>
		  </div><!-- class="az_left_bar" -->
		  <?php } ?>
			
		  <div id="az_site_content">
			
			<div id="az_site_content_top"></div>
			
			<div id="az_site_content_mid">
<?php
//#### END CONTENT TOP HTML #########
$az_html['content_top'] = ob_get_contents();
ob_end_clean(); 

ob_start(); 
// HTML Code for the main content section of the template, bottom part
//#### CONTENT BOTTOM HTML #########
?>
			</div>
			
			<div id="az_site_content_bottom"></div>
		<div class="clear"></div>	
		  </div><!-- class="az_site_content" -->
		  	
		  <?php if( $tmpl['cfg']['right_column'] ) { ?>
		  <div id="az_right_bar">
			<div id="az_right_bar_top"></div>
			
			<!-- right_navigation //-->
			<div id="az_right_bar_mid"><?php require(TMPL_INC_DIR . 'az_tmpl_column_right.php'); ?></div>
			<!-- right_navigation_eof //-->
				
			<div id="az_right_bar_bottom"></div>
		  </div><!-- class="az_right_bar" -->
		  <?php } ?>
		  
		  <div id="az_info_bar2"><?php require(TMPL_BOXES.'az_manufacturers.php');?></div>
		  
		  <div class="clear"></div>
		  
		</div><!-- class="az_main_content" -->

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