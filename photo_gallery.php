<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_PHOTO_GALLERY);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_PHOTO_GALLERY));

  //Image Gallery
  $photo_gallery_images_dir = 'gallery/';

  require(DIR_WS_INCLUDES . 'template_top.php');
?>
<style type="text/css">
	.thumbs{
		text-align: center;
	}

	.thumbs li{
		padding: 5px;
	}
</style>
<h1><?php echo HEADING_TITLE; ?></h1>

<div class="contentContainer">
  <div class="contentText">
    <div align="center">
		<div id="piGal" align="center">
			<ul>
				<?php
					  $photos_query_raw = "select gallery_photo_id, gallery_photo_title, gallery_photo, gallery_photo_order, gallery_photo_status, gallery_photo_added from " .  TABLE_GALLERY_PHOTOS . " where gallery_photo_status = '1' and products_model = '" .  $_GET['products_model'] . "'  order by gallery_photo_order ASC";
					  $photos_query = tep_db_query($photos_query_raw);

					  while($photos_array = tep_db_fetch_array($photos_query)){
				?>
				<li>
					<a href="<?php echo tep_href_link(DIR_WS_IMAGES . $photo_gallery_images_dir . $photos_array['gallery_photo'], '', 'NONSSL', false); ?>" title="<?php echo $photos_array['gallery_photo_title']; ?>" target="_blank" rel="fancybox"><?php echo tep_image(DIR_WS_IMAGES . $photo_gallery_images_dir . $photos_array['gallery_photo']); ?></a>
				</li>
				<?php
					  }
				?>
			</ul>
		</div>
	</div>

	<script type="text/javascript">
		$('#piGal ul').bxGallery({
		  maxwidth: 600,
		  maxheight: 400,
		  thumbwidth: 100,
		  thumbcontainer: 800,
		  load_image: 'ext/jquery/bxGallery/spinner.gif'
		});
	</script>
	<script type="text/javascript">
		$("#piGal a[rel^='fancybox']").fancybox({
		  cyclic: false
		});
	</script>
  </div>
</div>

<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
