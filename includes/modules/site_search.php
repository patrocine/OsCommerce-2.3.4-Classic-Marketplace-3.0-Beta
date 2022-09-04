<?php
/*
  $Id: site_search.php,v 1.00 Originally Created by: Jack York- http://www.oscommerce-solution.com

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com


  Copyright (c) 2003 osCommerce
  Portions Copyright 2005 oscommerce-solution.com

  Released under the GNU General Public License
*/


if (count($fileList) > 0 || count($pagesList) > 0) {
    $combinedList = array_merge($fileList, $pagesList);
    usort($combinedList, "SortFileLists");
?>
    <div style="clear:both; width:100%; padding-bottom:10px;">
       <div class="pageHeading" style="padding:10px 0px;"><?php echo TABLE_HEADING_SITESEARCH; ?></div>
       <?php
        $cnt = count($combinedList);

        for($i=0; $i < $cnt; ++$i) {
            echo '<div class="main">' . '<a href="' . tep_href_link($combinedList[$i]['file'], $combinedList[$i]['ext']) . '">' . ucwords(substr($combinedList[$i]['file'], 0, strrpos($combinedList[$i]['file'],'.')) . ' ' . ucwords($combinedList[$i]['ext'])) . '</a></div>';
        }

    echo '</div>';
}

if (count($articlesList) > 0) { ?>
    <div style="clear:both; width:100%; padding-bottom:10px;">
       <div class="pageHeading" style="padding:10px 0px;"><?php echo TABLE_HEADING_SITESEARCH_ARTICLES; ?></div>
       <?php
        $cnt = count($articlesList);

        for($i=0; $i < $cnt; ++$i) {
    	    echo '<div class="main">' . '<a href="' . tep_href_link(FILENAME_ARTICLE_INFO, 'articles_id='.$articlesList[$i]['id']) . '">' . ucwords($articlesList[$i]['name']) . '</a></div>';
        }

    echo '</div>';
}
?>
