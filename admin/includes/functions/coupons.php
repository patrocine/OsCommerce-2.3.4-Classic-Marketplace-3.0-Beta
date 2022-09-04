<?php
/*
 * coupons.php
 * September 25, 2006
 * author: Kristen G. Thorson
 * ot_discount_coupon_codes version 3.0
 *
 * 
 * Released under the GNU General Public License
 *
 */



	//from catalog/includes/functions
  function tep_get_parent_categories(&$categories, $categories_id) {
    $parent_categories_query = tep_db_query("select parent_id from " . TABLE_CATEGORIES . " where categories_id = '" . (int)$categories_id . "'");
    while ($parent_categories = tep_db_fetch_array($parent_categories_query)) {
      if ($parent_categories['parent_id'] == 0) return true;
      $categories[sizeof($categories)] = $parent_categories['parent_id'];
      if ($parent_categories['parent_id'] != $categories_id) {
        tep_get_parent_categories($categories, $parent_categories['parent_id']);
      }
    }
  }

  //from catalog/includes/functions
  function tep_get_categories_name($category_id, $language = '') {
    global $languages_id;

    if (empty($language)) $language = $languages_id;

    $category_query = tep_db_query("select categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id = '" . (int)$category_id . "' and language_id = '" . (int)$language . "'");
    $category = tep_db_fetch_array($category_query);

    return $category['categories_name'];
  }
  
  function kgt_draw_type_drop_down( $type = 'discount', $name = '', $default = '', $params = '' ) {
    if( $type == 'discount' ) {
      $values = array( array( 'id' => 'fixed', 'text' => 'Fixed Amount' ),
                       array( 'id' => 'percent', 'text' => 'Percentage Discount' ),
                       array( 'id' => 'shipping', 'text' => 'Shipping Discount' ) );
    } else if( $type == 'min_order' ) {
      $values = array( array( 'id' => 'price', 'text' => 'Price Total' ),
                       array( 'id' => 'quantity', 'text' => 'Product Quantity' ) );
    }
    return tep_draw_pull_down_menu( $name, $values, $default, $params );
  }

  /**
  * original kgt_create_random_coupon() contributed by Cubez
  */
  function kgt_create_random_coupon() {
    $chars = "ABCDEFGHJKLMNPQRTUVWXYZ023456789";
    srand( (double) microtime() * 1000000 );
    $pass = '';
    for( $i = 0; $i < MODULE_ORDER_TOTAL_DISCOUNT_COUPON_RANDOM_CODE_LENGTH; $i++ ) {
        $pass .= substr( $chars, ( rand() % 33 ), 1 );
    }
    return $pass;
  }

	/**
	* Returns a formatted date from a string based on a given format
	*
	* Supported formats
	*
	* %Y - year as a decimal number including the century
	* %m - month as a decimal number (range 1 to 12)
	* %d - day of the month as a decimal number (range 1 to 31)
	*
	* %H - hour as decimal number using a 24-hour clock (range 0 to 23)
	* %M - minute as decimal number
	* %s - second as decimal number
	* %u - microsec as decimal number
	* @param string date  string to convert to date
	* @param string format expected format of the original date
	* @return string rfc3339 w/o timezone YYYY-MM-DD YYYY-MM-DDThh:mm:ss YYYY-MM-DDThh:mm:ss.s
	*/
	function kgt_parse_date( $date, $format ) {
		// Builds up date pattern from the given $format, keeping delimiters in place.
		if( !preg_match_all( "/%([YmdHMsu])([^%])*/", $format, $formatTokens, PREG_SET_ORDER ) ) {
			return false;
		}
		foreach( $formatTokens as $formatToken ) {
			$delimiter = preg_quote( $formatToken[2], "/" );
			if($formatToken[1] == 'Y') {
				$datePattern .= '(.{1,4})'.$delimiter;
			} elseif($formatToken[1] == 'u') {
				$datePattern .= '(.{1,5})'.$delimiter;
			} else {
				$datePattern .= '(.{1,2})'.$delimiter;
			}
		}

		// Splits up the given $date
		if( !preg_match( "/".$datePattern."/", $date, $dateTokens) ) {
			return false;
		}
		$dateSegments = array();
		for($i = 0; $i < count($formatTokens); $i++) {
			$dateSegments[$formatTokens[$i][1]] = $dateTokens[$i+1];
		}

		// Reformats the given $date into rfc3339
		if( $dateSegments["Y"] && $dateSegments["m"] && $dateSegments["d"] ) {
			if( ! checkdate ( $dateSegments["m"], $dateSegments["d"], $dateSegments["Y"] ) ) return false;
			$dateReformated = str_pad($dateSegments["Y"], 4, '0', STR_PAD_LEFT)."-".str_pad($dateSegments["m"], 2, '0', STR_PAD_LEFT)."-".str_pad($dateSegments["d"], 2, '0', STR_PAD_LEFT);
		} else {
			return false;
		}
		if( $dateSegments["H"] && $dateSegments["M"] ) {
			$dateReformated .= "T".str_pad($dateSegments["H"], 2, '0', STR_PAD_LEFT).':'.str_pad($dateSegments["M"], 2, '0', STR_PAD_LEFT);

			if( $dateSegments["s"] ) {
				$dateReformated .= ":".str_pad($dateSegments["s"], 2, '0', STR_PAD_LEFT);
				if( $dateSegments["u"] ) {
					$dateReformated .= '.'.str_pad($dateSegments["u"], 5, '0', STR_PAD_RIGHT);
				}
			}
		}

		return $dateReformated;
	}
?>
