<?php
/*
 * coupons_exclusions.php
 * September 29, 2006
 * author: Kristen G. Thorson
 * ot_discount_coupon_codes version 3.0
 *
 *
 * Released under the GNU General Public License
 *
 */

  class coupons_exclusions {

  	var $type, $display_fields, $coupons_id, $table_name, $selected_options, $all_options;

    function coupons_exclusions( $coupons_id, $type = 'products' ) {
    	//check that the coupon is not null or emtpy
    	if( tep_not_null( $coupons_id ) ) {
    		$this->coupons_id = tep_db_input( $coupons_id );
			} else {
				return false;
			}
			//check that the table definition for the type exists
			if( defined( 'TABLE_DISCOUNT_COUPONS_TO_'.strtoupper( $type ) ) ) {
				$this->type = $type;
				$this->table_name = constant( 'TABLE_DISCOUNT_COUPONS_TO_'.strtoupper( $type ) );
			} else {
				return false;
			}
			$this->selected_options = array();
			$this->all_options = array();
		}

		function save( $selected_options = array() ) {
			tep_db_query( $sql = 'DELETE FROM '.$this->table_name.' WHERE coupons_id="'.$this->coupons_id.'"' );
			if( is_array( $selected_options ) && count( $selected_options ) > 0 ) {
				foreach( $selected_options as $ids ) {
					tep_db_query( $sql = 'INSERT INTO '.$this->table_name.' VALUES ( "'.$this->coupons_id.'", '.(int)$ids.' )' );
				}
			} else return false;
		}

		function get_selected_options( $sql, $separator = ' :: '/*category exclusions*/, $category_separator = '->', $category_path = true/*end category exclusions*/ ) {
			if( !tep_not_null( $sql ) ) return false;
      $result = tep_db_query( $sql );
			$selected_ids = array();
  		if( tep_db_num_rows( $result ) > 0 ) {
				while( $row = tep_db_fetch_array( $result ) ) {
					$id = $row['id'];
					unset( $row['id'] ); //don't display in the list

					//category exclusions
					if( $category_path ) {
						$path = '';
			      //get the category path
			      $categories = array();
					  tep_get_parent_categories( $categories, $id );
					  $categories = array_reverse( $categories );
					  foreach( $categories as $cat ) {
					    $path .= tep_get_categories_name( $cat, (int)$languages_id ).$category_separator;
					  }
					  $row['categories_name'] = $path.$row['categories_name'];
					}
					//end category exclusions

					$selected_ids[] = $id;
			    $this->selected_options[] = array( 'text' => implode( $row, $separator ), 'id' => $id );
				}
				sort( $this->selected_options );
			}
			return $selected_ids;
		}

		function get_all_options( $sql, $separator = ' :: '/*category exclusions*/, $category_separator = '->', $category_path = true/*end category exclusions*/, $selected_ids = array() ) {
			if( !tep_not_null( $sql ) ) return false;
      $result = tep_db_query( $sql );
	    if( tep_db_num_rows( $result ) > 0 ) {
				while( $row = tep_db_fetch_array( $result ) ) {
					$id = $row['id'];

					//category exclusions
					if( $category_path ) {
						$path = '';
			      //get the category path
			      $categories = array();
					  tep_get_parent_categories( $categories, $id );
					  $categories = array_reverse( $categories );
					  foreach( $categories as $cat ) {
					    $path .= tep_get_categories_name( $cat, (int)$languages_id ).$category_separator;
					  }
					  $row['categories_name'] = $path.$row['categories_name'];
					}
					//end category exclusions

					unset( $row['id'] ); //don't display in the list
			    $this->all_options[] = array( 'text' => implode( $row, $separator ), 'id' => $id );
				}
				sort( $this->all_options );
			}
			return true;
		}

		function display() {
			$return = '
<script language="javascript" type="text/javascript"><!--

function updateSelect( to_select, from_select ) {
	 for( var i = 0; i < from_select.options.length; i++ ) {
		  if( from_select.options[i].selected ) {
		    var newOption = new Option( from_select.options[i].text, from_select.options[i].value )
		    to_select.options[ to_select.options.length ] = newOption;
		  }
	 }
	 deleteOptions( from_select );
}

function deleteOptions( delete_select ) {
  for( var i = 0; i < delete_select.options.length; i++ ) {
    if( delete_select.options[i].selected ) {
      delete_select.options[i] = null;
      i=-1;
    }
  }
}

function selectAll( to_select, from_select ) {
	for( var i=0; i < from_select.options.length; i++ ) {
	  from_select.options[i].selected = true;
	}
	updateSelect( to_select, from_select );
}

function form_submission( to_select ) {
  for( var i=0; i < to_select.options.length; i++ ) {
	  to_select.options[i].selected = true;
	}
}

//--></script>
'.tep_draw_form( 'choose'.$this->type, FILENAME_DISCOUNT_COUPONS_EXCLUSIONS, 'cID='.$this->coupons_id.'&type='.$this->type, 'post', 'onsubmit="form_submission( document.getElementById(\'selected_'.$this->type.'\') )"' ).'
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td align="center" class="main">'.HEADING_AVAILABLE.'</td>
			<td align="center">&nbsp;</td>
			<td align="center" class="main">'.HEADING_SELECTED.'</td>
		</tr>
		<tr>
			<td rowspan="5" align="center">'.tep_draw_pull_down_menu('available_'.$this->type.'[]', $this->all_options, '', 'size="20" multiple style="width: 300px" id="available_'.$this->type.'"').'</td>
			<td align="center"><input name="choose_all" type="button" id="choose_all" value="Choose All &gt;" onclick="selectAll( document.getElementById(\'selected_'.$this->type.'\'), document.getElementById(\'available_'.$this->type.'\') )"></td>
			<td rowspan="5" align="center">'.tep_draw_pull_down_menu('selected_'.$this->type.'[]', $this->selected_options, '', 'size="20" multiple style="width: 300px" id="selected_'.$this->type.'"').'</td>
		</tr>
		<tr>
			<td align="center"><input name="add" type="button" id="add" value="&gt; &gt;" onclick="updateSelect( document.getElementById(\'selected_'.$this->type.'\'), document.getElementById(\'available_'.$this->type.'\') )"></td>
		</tr>
		<tr>
			<td align="center"><input name="subtract" type="button" id="subtract" value="&lt; &lt;" onclick="updateSelect( document.getElementById(\'available_'.$this->type.'\'), document.getElementById(\'selected_'.$this->type.'\') )"></td>
		</tr>
		<tr>
			<td align="center"><input name="remove_all" type="button" id="remove_all" value="&lt; Remove All" onclick="selectAll( document.getElementById(\'available_'.$this->type.'\'), document.getElementById(\'selected_'.$this->type.'\') )"></td>
		</tr>
		<tr>
			<td align="center"><input name="action" type="submit" id="action" value="Save"> <input name="action" type="submit" id="action" value="Cancel"></td>
		</tr>
	</table>
</form>
';
			return $return;
		}

  }
?>
