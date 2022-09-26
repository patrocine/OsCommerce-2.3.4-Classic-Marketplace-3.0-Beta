<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  $cl_box_groups[] = array(
    'heading' => BOX_HEADING_AFFILIATE,
    'apps' => array(
      array(
        'code' => FILENAME_AFFILIATE_SUMMARY,
        'title' => BOX_AFFILIATE_SUMMARY,
        'link' => tep_href_link(FILENAME_AFFILIATE_SUMMARY)
      ),
      array(
        'code' =>  FILENAME_AFFILIATE,
        'title' => BOX_AFFILIATE,
        'link' =>  tep_href_link(FILENAME_AFFILIATE)
      ),
      array(
        'code' =>  FILENAME_AFFILIATE_PAYMENT,
        'title' => BOX_AFFILIATE_PAYMENT,
        'link' =>  tep_href_link(FILENAME_AFFILIATE_PAYMENT)
      ),
      array(
        'code' =>  FILENAME_AFFILIATE_SALES,
        'title' => BOX_AFFILIATE_SALES,
        'link' =>  tep_href_link(FILENAME_AFFILIATE_SALES)
      ),
      array(
        'code' =>  FILENAME_AFFILIATE_CLICKS,
        'title' => BOX_AFFILIATE_CLICKS,
        'link' =>  tep_href_link(FILENAME_AFFILIATE_CLICKS)
      ),
      array(
        'code' =>  FILENAME_AFFILIATE_BANNER_MANAGER,
        'title' => BOX_AFFILIATE_BANNERS,
        'link' =>  tep_href_link(FILENAME_AFFILIATE_BANNER_MANAGER)
      ),
      array(
        'code' =>  FILENAME_AFFILIATE_NEWS,
        'title' => BOX_AFFILIATE_NEWS,
        'link' =>  tep_href_link(FILENAME_AFFILIATE_NEWS)
      ),
      array(
        'code' =>  FILENAME_AFFILIATE_NEWSLETTERS,
        'title' => BOX_AFFILIATE_NEWSLETTER_MANAGER,
        'link' =>  tep_href_link(FILENAME_AFFILIATE_NEWSLETTERS)
      ),
      array(
        'code' =>  FILENAME_AFFILIATE_CONTACT,
        'title' => BOX_AFFILIATE_CONTACT,
        'link' =>  tep_href_link(FILENAME_AFFILIATE_CONTACT)
      )
    )
  );
?>
