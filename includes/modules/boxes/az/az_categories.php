<div class="az_categ_box" align="left">
<?php
//constant font parameters in pixels for font 12px
$letter_width = 11;
$space_between_letters = 2;
$padding_between_cats = 25;
//constant widths in pixels 
$box_cat_width = 970;
$read_more_width = 90; //read more width in pixels

$width_without_read_more = $box_cat_width - $read_more_width; //box width without read more
   
//query
$categ_query = tep_db_query("select distinct c.categories_id, c.parent_id, cd.categories_id, cd.categories_name from " . TABLE_CATEGORIES . " c, ".TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = cd.categories_id and cd.language_id='" . (int)$languages_id ."' and c.parent_id = '0' order by c.categories_id ");
//end query
		
$number_of_categories = tep_db_num_rows($categ_query); //number of all categories

$all_cats_length = 0;

while ($cat = tep_db_fetch_array($categ_query)) { 
		
		$one_cat_length = strlen($cat['categories_name']) * $letter_width + (strlen($cat['categories_name'])-1)* $space_between_letters + $padding_between_cats;
		
		
		$all_cats_length = $all_cats_length + $one_cat_length; //all summary length of categories names;
		
}

//query
$categ_query = tep_db_query("select distinct c.categories_id, c.parent_id, cd.categories_id, cd.categories_name from " . TABLE_CATEGORIES . " c, ".TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = cd.categories_id and cd.language_id='" . (int)$languages_id ."' and c.parent_id = '0' order by c.categories_id ");
//end query
		
		
		if ($all_cats_length <=$box_cat_width) {
		
	//situation when all categories are not exceed all block width
		
			echo '<div id="az_categ_box_scroll">';
			while ($cat = tep_db_fetch_array($categ_query)) {
				 $cPath_new = 'cPath=' .$cat['categories_id']; 
				
	//parent category output
				 
				 echo '<div class="cat-name">';
				 echo '<a href="'.tep_href_link(FILENAME_DEFAULT, $cPath_new).'">'.$cat['categories_name'].'</a>';
				 $current_cat_id = $cat['categories_id'];
				 
	//sub category output
				 $categories_query_sub = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$current_cat_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' order by sort_order, cd.categories_name");
				
				$q1 = 0;
				if (tep_db_num_rows($categories_query_sub) > 0) { 
					echo '<div class="drop-box-subcat">'; 
					while ($sub_cat = tep_db_fetch_array($categories_query_sub)) {
						$q1 ++;
						echo '<div class="sub-cat-name">
						<a class="'.(($q1 == 1) ? 'first' : 'default_style').'" href="'.tep_href_link(FILENAME_DEFAULT, 'cPath='.$cat['categories_id'].'_'.$sub_cat['categories_id']).'">'.$sub_cat['categories_name'].'</a>';
						
						//sub sub cat 
						$last_subcat_id = $sub_cat['categories_id'];
									
						$subcategories_query_sub = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$last_subcat_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' order by sort_order, cd.categories_name");
						
						$q2 = 0;		
						
						if (tep_db_num_rows($subcategories_query_sub) > 0) {
									
							echo '<div class="drop-box-subsubcat"><div class="drop-box-subsubcat_color">'; 
										
							while ($sub_subcat = tep_db_fetch_array($subcategories_query_sub)) {
								$q2 ++;
								echo '<div class="subsub-cat-name"><a class="'.(($q2 == 1) ? 'first' : 'default_style').'" href="'.tep_href_link(FILENAME_DEFAULT, 'cPath='.$sub_subcat['categories_id']).'">'.$sub_subcat['categories_name'].'</a>';
								
								
								//3 sub cat 
								$last_subsubcat_id = $sub_subcat['categories_id'];
								$subcategories_query_3sub = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$last_subsubcat_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' order by sort_order, cd.categories_name");
								$q3 =0;
											
								//display block
								if (tep_db_num_rows($subcategories_query_3sub) > 0) {
									echo '<div class="drop-box-3subcat"><div class="drop-box-subsubcat_color">'; 
									while ($sub_3subcat = tep_db_fetch_array($subcategories_query_3sub)) {
										$q3 ++;
										echo '<a class="'.(($q3 == 1) ? 'first' : 'default_style').'" href="'.tep_href_link(FILENAME_DEFAULT, 'cPath='.$cat['categories_id'].'_'.$sub_cat['categories_id']).'_'.$sub_subcat['categories_id'].'_'.$sub_3subcat['categories_id'].'">'.$sub_3subcat['categories_name'].'</a>';
									}
									echo '</div></div>';
								}
								//display block
											
								//3 sub cat end 
								
								
								echo '</div>';
								
								
							}
							echo '</div></div>';
						}
						
						echo '</div>';
						//sub sub cat 
						
					}
					echo '</div>';
				}

				
			echo '</div>
			<div class="az_categ_box_top_line">'.az_image(TMPL_IMAGES .'az_top_cat_line.gif').'</div>';
				 
			}
			echo '</div>';
		}
		
	//situation when all categories are exceed all block width
		else {
			$sum_cat = 0;
			
			echo '
			<div id="az_categ_box_scroll">
			<div>';
			
			while ($cat = tep_db_fetch_array($categ_query)) {
				
					if ($sum_cat <= $width_without_read_more){
						$cPath_new = 'cPath=' .$cat['categories_id'];
				 		
						echo '<div class="cat-name">';
						echo '<div><a href="'.tep_href_link(FILENAME_DEFAULT, $cPath_new).'">'.$cat['categories_name'].'</a></div>';
						
						$last_id = $cat['categories_id']; //last category id
						
						$categories_query_sub = tep_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$last_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' order by sort_order, cd.categories_name");
							$q1 =0;
							if (tep_db_num_rows($categories_query_sub) > 0) { 
								echo '<div class="drop-box-subcat">'; 
								while ($sub_cat = tep_db_fetch_array($categories_query_sub)) {
									$q1++;
									echo '<div class="sub-cat-name"><a class="'.(($q1 == 1) ? 'first' : 'default_style').'" href="'.tep_href_link(FILENAME_DEFAULT, 'cPath='.$cat['categories_id'].'_'.$sub_cat['categories_id']).'">'.$sub_cat['categories_name'].'</a>';
										
									//sub sub cat 
									$last_subcat_id = $sub_cat['categories_id'];
									
									$subcategories_query_sub = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$last_subcat_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' order by sort_order, cd.categories_name");
									$q2 =0;
									if (tep_db_num_rows($subcategories_query_sub) > 0) {
									
										echo '<div class="drop-box-subsubcat"><div class="drop-box-subsubcat_color">'; 
										
										while ($sub_subcat = tep_db_fetch_array($subcategories_query_sub)) {
											$q2 ++;
											echo '<div class="subsub-cat-name"><a class="'.(($q2 == 1) ? 'first' : 'default_style').'" href="'.tep_href_link(FILENAME_DEFAULT, 'cPath='.$cat['categories_id'].'_'.$sub_cat['categories_id'].'_'.$sub_subcat['categories_id'].'_'.$sub_cat['categories_id']).'">'.$sub_subcat['categories_name'].'</a>';
											
											//3 sub cat 
											$last_subsubcat_id = $sub_subcat['categories_id'];
											$subcategories_query_3sub = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$last_subsubcat_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' order by sort_order, cd.categories_name");
											$q3 =0;
											
											//display block
											if (tep_db_num_rows($subcategories_query_3sub) > 0) {
												echo '<div class="drop-box-3subcat"><div class="drop-box-subsubcat_color">'; 
												while ($sub_3subcat = tep_db_fetch_array($subcategories_query_3sub)) {
													$q3 ++;
													echo '<a class="'.(($q3 == 1) ? 'first' : 'default_style').'" href="'.tep_href_link(FILENAME_DEFAULT, 'cPath='.$cat['categories_id'].'_'.$sub_cat['categories_id']).'_'.$sub_subcat['categories_id'].'_'.$sub_3subcat['categories_id'].'">'.$sub_3subcat['categories_name'].'</a>';
												}
												echo '</div></div>';
											}
											//display block
											
											//3 sub cat end 
											
											echo '</div>';
											
										}
										echo '<div class="clear"></div></div></div>';
									}
								echo '</div>';
								//sub sub cat 
								
								
								
								
								
								
							}
							echo '</div>';
						}
						
						echo '</div>
						<div class="az_categ_box_top_line">'.az_image(TMPL_IMAGES .'az_top_cat_line.gif').'</div>
						';
						
					}
					
					$sum_cat = $sum_cat + (strlen($cat['categories_name']) * $letter_width + (strlen($cat['categories_name'])-1)* $space_between_letters + $padding_between_cats);
					
					
			}
			
			
	//button read more appearing
			echo '
			<div id="scroll-box">
			<a href="#">Ver ++ ...</a>';
			
			
//query
$categ_query = tep_db_query("select distinct c.categories_id, c.parent_id, cd.categories_id, cd.categories_name from " . TABLE_CATEGORIES . " c, ".TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = cd.categories_id and cd.language_id='" . (int)$languages_id ."' and c.parent_id = '0' order by c.categories_id ");
//end query

	//drop box positioning
	
			echo '<div id="drop-box" align="left">';
			$q3 = 0;
			while ($cat = tep_db_fetch_array($categ_query)) {
				
				if ($cat['categories_id'] > $last_id) {
					$q3 ++;
					$cPath_new = 'cPath=' .$cat['categories_id'];
					echo '<div><a class="'.(($q3 == 1) ? 'first' : 'default_style').'" href="'.tep_href_link(FILENAME_DEFAULT, $cPath_new).'">'.$cat['categories_name'].'</a></div>';
					
				}
			}
			
			
			echo '
			
			
			</div>
			</div>
			<div class="clear"></div>';
			
			echo '
			</div>
			</div>';
		}
		
?>

<script type="text/javascript">
jQuery(function(){
		jQuery('#scroll-box').hover(
			function(){ $('div#drop-box',this).show() },
			function(){ $('div#drop-box',this).hide() }
		);
		jQuery('#az_categ_box_scroll .cat-name').hover(
			function(){ $('.drop-box-subcat',this).show() },
			function(){ $('.drop-box-subcat',this).hide() }
		);
		jQuery('#az_categ_box_scroll .sub-cat-name').hover(
			function(){ $('.drop-box-subsubcat',this).show() },
			function(){ $('.drop-box-subsubcat',this).hide() }
		);
		jQuery('#az_categ_box_scroll .subsub-cat-name').hover(
			function(){ $('.drop-box-3subcat',this).show() },
			function(){ $('.drop-box-3subcat',this).hide() }
		);
		
	});
</script>

</div>
