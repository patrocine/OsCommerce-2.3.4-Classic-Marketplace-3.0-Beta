<script type="text/javascript" src="<?php echo  TMPL_JS ?>jquery.js"></script>
<script type="text/javascript" src="<?php echo  TMPL_JS ?>slider.js"></script>
<script type="text/javascript" src="<?php echo  TMPL_JS ?>jquery_1.js"></script>

<script type="text/javascript">
$(function() {
    $('#slideshow').cycle({
        fx:     'fade',
        speed:   2000,
        timeout: 1,
        pager:  '#nav',
        before: function() { 
            $('#caption').html(this.alt);
        }
    });
});
</script>


<?php
$x=1;
$counter= 1;
$counter2= 1;
$ban = array();
$banners_demo = tep_db_query("select * from " . TABLE_BANNERS . " where banners_group = 'index'");
if (tep_db_num_rows($banners_demo) == 0 ) {
	
	$default_banner1 = tep_db_query("insert into " . TABLE_BANNERS . " (banners_title,  banners_url, banners_image, banners_group, date_added, status) values ('1', 'products_new.php', 'az_slide_1.jpg', 'index', now(), 1)");
		
		$default_banner2 = tep_db_query("insert into " . TABLE_BANNERS . " (banners_title,  banners_url, banners_image, banners_group, date_added, status) values ('2', 'products_new.php', 'az_slide_2.jpg', 'index', now(), 1)");
		
		$default_banner3 = tep_db_query("insert into " . TABLE_BANNERS . " (banners_title,  banners_url, banners_image, banners_group, date_added, status) values ('3', 'products_new.php', 'az_slide_3.jpg', 'index', now(), 1)");
		
		$default_banner4 = tep_db_query("insert into " . TABLE_BANNERS . " (banners_title,  banners_url, banners_image, banners_group, date_added, status) values ('4', 'products_new.php', 'az_slide_4.jpg', 'index', now(), 1)");
	
	
	$default_banner5 = tep_db_query("insert into " . TABLE_BANNERS . " (banners_title,  banners_url, banners_image, banners_group, date_added, status) values ('5', 'specials.php', 'az_banner_1.gif', 'index', now(), 1)");
	$default_banner6 = tep_db_query("insert into " . TABLE_BANNERS . " (banners_title,  banners_url, banners_image, banners_group, date_added, status) values ('6', 'shipping.php', 'az_banner_2.gif', 'index', now(), 1)");
	
	
}

$banners_demo_query = tep_db_query("select * from " . TABLE_BANNERS . " where banners_group = 'index' order by banners_title");
 
if (tep_db_num_rows($banners_demo_query)) {
	while ($banners1 = tep_db_fetch_array($banners_demo_query)) {  
		  $ban[$counter] = array();
		  $ban[$counter]['banners_id'] = $banners1['banners_id'];
		  $ban[$counter]['banners_title'] = $banners1['banners_title'];
		  $ban[$counter]['banners_url'] = $banners1['banners_url'];
		  $ban[$counter]['banners_image'] = $banners1['banners_image']; 
		  $counter++; 
	}   
}
?>

<?php  
$numb_query = tep_db_query("select products_id from " . TABLE_PRODUCTS . " ");
$numb = tep_db_fetch_array($numb_query);
				
do { 
	$max_id = 1;
	if ($numb['products_id'] > $max_id) {
		$max_id = $numb['products_id'];
	}
}
while ($numb = mysql_fetch_array($numb_query));
		 
?>

<div class="slider_box">
	<div class="jQuery">
			<div id="nav"></div>
			<div id="slideshow" class="pics">
				<div><?php if (tep_banner_exists('static', $ban[1]['banners_id'])){ echo str_replace('_blank', '_self', tep_display_banner('static', $ban[1]['banners_id'])); } ?></div>
				<div><?php if (tep_banner_exists('static', $ban[2]['banners_id'])){ echo str_replace('_blank', '_self', tep_display_banner('static', $ban[2]['banners_id'])); } ?></div>
				<div><?php if (tep_banner_exists('static', $ban[3]['banners_id'])){ echo str_replace('_blank', '_self', tep_display_banner('static', $ban[3]['banners_id'])); } ?></div>
				<div><?php if (tep_banner_exists('static', $ban[4]['banners_id'])){ echo str_replace('_blank', '_self', tep_display_banner('static', $ban[4]['banners_id'])); } ?></div>
			</div>
			<div id="caption"></div>	
	</div>
</div>

<div class="banners_box">
	<?php if (tep_banner_exists('static', $ban[5]['banners_id'])){ echo str_replace('_blank', '_self', tep_display_banner('static', $ban[5]['banners_id'])); } ?>
	<?php if (tep_banner_exists('static', $ban[6]['banners_id'])){ echo str_replace('_blank', '_self', tep_display_banner('static', $ban[6]['banners_id'])); } ?>
	
</div>
<div class="clear"></div>
