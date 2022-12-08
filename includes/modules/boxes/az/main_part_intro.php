
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
   
     <?php// require(TMPL_BOXES . 'az_market_intro.php'); ?>
   
   
      <p>&nbsp;</p>
  <?php

   $registros_values = tep_db_query("select * from " . 'products_compartir' . " where activo = '" . 3 . "'");
                    while  ($registros = tep_db_fetch_array($registros_values)){



            ?>
<table border="0" width="100%">
	<tr>
		<td width="194"><a href="<?php echo $registros['ruta_url'] ?>">
		<img src="<?php echo $registros['ruta_url'] . 'images/store_logo.png' ?>" alt="<?php echo $registros['nombre_oculto'] ?>" width="160" height=""></a></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
	</tr>
</table>

			<div class="main_part_title review_price_blocks"><?php // echo BOX_TAGS; ?></div>

   <?php

      }


      ?>
   
   
   
   
			
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
			<div class="main_part_title bestseller_title"> <a href="https://oscommerce.com"><img src="/images/logo_oscommerce.png"></a></div>
            <p><b><a href="https://github.com/patrocine/OsCommerce-2.3.4-Classic-Empresa-3.0-Beta"><font size="2">Descargar Tienda</a></font></b> <img border="0" src="https://github.githubassets.com/images/modules/logos_page/GitHub-Mark.png" width="30" height="">










   <?php





    $tiendas_values = mysql_query("select * from " . 'affiliate_compartir_empresas' . " where id_banners = '" .  $banner['id_banners'] . "'");
   if ($tiendas = mysql_fetch_array($tiendas_values)){


                if ($tiendas['url_affiliate']){

          }else{
        $tiendas['url_affiliate'] = $tiendas['url_web'];

      }

           ?>






<hr size="15" noshade color="#000000">


<table border="0" width="100%" id="table1" cellspacing="0" cellpadding="0">
	<tr>
		<td colspan="2">
		<p align="center"><b><font size="4"><?php echo '<a href="'.$tiendas['url_affiliate'] .'"><img border="0" src="'.$tiendas['url_web'] .'/images/store_logo.png'.'" width="120" height="">' ?></a></font></b></td>
	</tr>
	<tr>
		<td width="100%" colspan="2">
		<p align="center"><b><font size="4"><?php echo $tiendas['nombre'] ?></font></b></td>
>	</tr>
	<tr>
		<td width="6%"><b>Empresa:</b></td>
		<td width="94%"><b>&nbsp;<?php echo $tiendas['nombre_sector'] ?></b></td>
	</tr>
	<tr>
		<td colspan="2">
		<b>Ubicación: <?php echo $tiendas['nombre_ciudad'] ?></b></td>
	</tr>
	<tr>
		<td colspan="2">
		<p align="right"><b><a href="<?php echo $tiendas['url_affiliate'] ?>"><font size="3">Visitar Marketplace
		-&gt;&gt;</font></a></b></td>
	</tr>
</table>


                   <?php
           }












        echo ' <td class="smallText" align="center"><br><script language="javascript" src="'.$empresa_banner.'"> </script>'.$z.'</td>' . '</a><br />';



