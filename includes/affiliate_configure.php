<?php
/*
  $Id: osCAffiliate 20-Nov-2014
  OSC-Affiliate for osCommerce 2.3xx family
  Contribution based on: http://addons.oscommerce.com/info/158
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2002 - 2014 osCommerce
  Released under the GNU General Public License
  Updated by Fimble (http://forums.oscommerce.com/user/15542-fimble/)
  http://www.linuxuk.co.uk
*/

  define('AFFILIATE_KIND_OF_BANNERS','2');          // 1 Direct Link to Banner ; no counting of how much banners are shown
                                                    // 2 Banners are shown with affiliate_show_banner.php; bannerviews are counted (recommended)
  define('AFFILIATE_SHOW_BANNERS_DEBUG', 'false');  // Debug for affiliate_show_banner.php; If you have difficulties geting banners set to true,
                                                    // and try to load the banner in a new Browserwindow
                                                    // i.e.: http://yourdomain.com/affiliate_show_banner.php?ref=3569&affiliate_banner_id=3
  define('AFFILIATE_SHOW_BANNERS_DEFAULT_PIC', ''); // absolute path to default pic for affiliate_show_banner.php, which is showed if no banner is found
                                                    // Only works with AFFILIATE_KIND_OF_BANNERS=2
?>