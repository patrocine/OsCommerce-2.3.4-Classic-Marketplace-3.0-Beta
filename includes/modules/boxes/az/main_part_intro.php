
<script type="text/javascript" src="<?php echo TMPL_JS ?>jquery-1.4.2.min.js"></script>	
<script type="text/javascript" src="<?php echo TMPL_JS ?>jquery.jcarousel.min.js"></script>	

<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('#mycarousel').jcarousel({
        vertical: true,
        scroll: 1,
		auto: 1,
		wrap: 'circular',
		animation: 2000
    });
});
</script>
<script type="text/javascript" src="<?php echo TMPL_JS ?>jcarousellite.js"></script>
<script type="text/javascript">
jQuery(function(){
jQuery(".gallery2").jCarouselLite({
		btnNext2: ".next2",
		btnPrev2: ".prev2"
	});
});
</script>



<div class="main_part_intro_page">
	
	<div class="main_part_left_box">
		<div class="main_part_left_box_pad">
   <?php require(TMPL_BOXES . 'az_categ_intro.php'); ?>

			<div class="main_part_title review_price_blocks"><?php // echo BOX_TAGS; ?></div>

   <?php // require(TMPL_BOXES . 'az_flash.php'); ?>
   
   
   
   
			
		</div>
	</div>
 
 
 


 
 
 
 
	<div class="newsletter_form">


   <?php


  if ($pro_ale <= 11){


   $banner_values = mysql_query("select * from " . 'affiliate_compartir_empresas' . " where aut = '" . 1 . "'   ORDER BY RAND() LIMIT 1");
   if ($banner = mysql_fetch_array($banner_values)){






 $empresa_banner = $banner['url_empresa_catalog'].$banner['numero_productos'];

  }else{

   $empresa_banner = 'affiliate_banners_products.php?pro_ale=5';
}

  }


            $z .= '<p style="margin-top: 0; margin-bottom: 0"><b>'.'MERKAPLACE'.'</b></p>';

    $tiendas_values = mysql_query("select * from " . 'affiliate_compartir_empresas' . " where aut = '" .  1 . "'");
   while ($tiendas = mysql_fetch_array($tiendas_values)){
 $z .= '<p style="margin-top: 0; margin-bottom: 0"><b><a href="'.$tiendas['url_web'].'">'.$tiendas['nombre_sector'].'->>'.$tiendas['nombre'].'</a></b></p>';

           }


          ?>


	<div class="main_part_middle_box">
		<div class="main_part_middle_box_pad">
			<div class="main_part_title"><a href="<?php echo tep_href_link(FILENAME_PRODUCTS_NEW); ?>"><?php echo MENU_TEXT_NEW_PRODUCTS; ?></a></div>
			<?php include(DIR_WS_MODULES . FILENAME_NEW_PRODUCTS); ?>
		</div>
	</div>
	
	<div class="main_part_right_box">
		<div class="main_part_right_box_pad">
			<div class="main_part_title bestseller_title"><?php echo TAB_TEXT_BEST_SELLERS; ?></div>
			<?php require(TMPL_BOXES . 'az_bestsellers_flow.php');


       ?>


		</div>
	</div>


	<div class="main_part_right_box">
		<div class="main_part_right_box_pad">
			<div class="main_part_title bestseller_title"><?php echo PUBLICIDAD; ?></div> <?php


        echo ' <td class="smallText" align="center"><br><script language="javascript" src="'.$empresa_banner.'"> </script>'.$z.'</td>' . '</a><br />';

       ?>


		</div>
	</div>
	<div class="clear"></div>
</div>






