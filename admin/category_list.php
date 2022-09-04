<?php
	require('includes/application_top.php');
	require(DIR_WS_CLASSES . 'currencies.php');

	global $languages_id;

	function GetItems (){
		$currencies = new currencies();
		global $languages_id;

		if (isset($_POST['cat']))
		{
			if ($exclude == '') {
			  $exclude = array();
			}

			$select_string = '<li> Products:&nbsp;<select name="' . $_POST['name'] . '"';

			if ($parameters) {
			  $select_string .= ' ' . $parameters;
			}

			$select_string .= '>';

			$strQuery = " SELECT p.products_id, pd.products_name, p.products_price";
			$strQuery .=" FROM " . TABLE_PRODUCTS . " p";
			$strQuery .=" INNER JOIN ". TABLE_PRODUCTS_TO_CATEGORIES . " as pc ";
			$strQuery .=" on  p.products_id =  pc.products_id" ;
			$strQuery .=" INNER JOIN " . TABLE_PRODUCTS_DESCRIPTION . " as pd on p.products_id = pd.products_id ";
			$strQuery .=" where ";
			$strQuery .=" pd.language_id = '" . (int)$languages_id . "'";
			$strQuery .=" and pc.categories_id = '". $_POST['cat'] ."' order by products_name";

			$products_query = tep_db_query($strQuery);
			while ($products = tep_db_fetch_array($products_query)) {
			  if (!in_array($products['products_id'], $exclude)) {
			    $select_string .= '<option value="' . $products['products_id'] . '">' . $products['products_name'] . ' (' . $currencies->format($products['products_price']) . ')</option>';
			  }
			}
			$select_string .= '</select></li>';

			echo $select_string;
		}
	}
	function InsertRelation (){
		if (isset($_POST['pid1']) && isset($_POST['pid2']))
		{
			$strQuery = " SELECT * FROM compbuild_dependence";
			$strQuery .= " WHERE (product1_id = ". $_POST['pid1'] ." and product2_id = ". $_POST['pid2']. ")";
			$strQuery .= " or (product1_id = ". $_POST['pid2'] ." and product2_id = ". $_POST['pid1']. ")";
			$dependence_query = tep_db_query($strQuery);
			if (! $dependence = tep_db_fetch_array($dependence_query))
			{
				$strQuery = " INSERT INTO compbuild_dependence(product1_id, product2_id)";
				$strQuery .= " VALUES (". $_POST['pid1'] .", ". $_POST['pid2']. ")";
				$insert_query = tep_db_query($strQuery);
			}
		}
	}

	function DeleteRelation (){
		if (isset($_POST['pid1']) && isset($_POST['pid2']))
		{
			$strQuery = " DELETE FROM compbuild_dependence";
			$strQuery .= " WHERE (product1_id = ". $_POST['pid1'] ." and product2_id = ". $_POST['pid2']. ")";
			$strQuery .= " or (product1_id = ". $_POST['pid2'] ." and product2_id = ". $_POST['pid1']. ")";
			$dependence_query = tep_db_query($strQuery);
		}
	}

	function GetRelations()
	{
		global $languages_id;
		$strQuery = " SELECT product1_id as p1id, pd1.products_name as p1name, catdes.categories_name as p1cat,";
		$strQuery .=" product2_id as p2id, pd2.products_name as p2name, catdes2.categories_name as p2cat";
		$strQuery .=" FROM compbuild_dependence as cd";
		$strQuery .=" INNER JOIN products_description as pd1 on pd1.products_id = cd.product1_id";
		$strQuery .=" INNER JOIN products_description as pd2 on pd2.products_id = cd.product2_id";
		$strQuery .=" INNER JOIN products_to_categories as ptc on ptc.products_id = product1_id";
		$strQuery .=" INNER JOIN categories_description as catdes on catdes.categories_id = ptc.categories_id";
		$strQuery .=" INNER JOIN products_to_categories as ptc2 on ptc2.products_id = product2_id";
		$strQuery .=" INNER JOIN categories_description as catdes2 on catdes2.categories_id = ptc2.categories_id";
		$strQuery .=" WHERE ((product1_id = ". $_POST['pid1'] .")";
		$strQuery .=" or (product2_id = ". $_POST['pid1']. "))";
		$strQuery .=" and pd1.language_id =". $languages_id ." and pd2.language_id =". $languages_id;
		$strQuery .=" and catdes.language_id=".$languages_id." and catdes2.language_id=".$languages_id;
		$dependence_query = tep_db_query($strQuery);
		$strRelations = "";
		while ($dependence = tep_db_fetch_array($dependence_query)) {
			$strRelations .= "<tr class='dependenceTableRow'>";
			$strRelations .= "<td>".$dependence['p1name']."</td>";
			$strRelations .="<td>".$dependence['p1cat']."</td>";
			$strRelations .="<td>".$dependence['p2name']."</td>";
			$strRelations .="<td>".$dependence['p2cat']."</td>";
			$strRelations .="<td><a href='#' onclick='DeleteRelation(".$dependence['p1id'] .", ".$dependence['p2id'].");'>click here to Remove Dependance</a></td></tr>";
		}
		$strTable = '<table>';
		$strTable .= '<tr class="dependenceHeadingContent"><td>Product</td><td>Category</td><td>Product</td><td colspan=2>Category</td></tr>';
		$strTable .= $strRelations;
		$strTable .= '</table>';
		echo $strTable;
	}

	switch ($_POST['funcion'])
	{
		case 1:
			//die($_POST['funcion']);
			GetItems();
			break;
		case 2:
			//die($_POST['funcion']);
			InsertRelation();
			GetRelations();
			break;
		case 3:
			//die($_POST['funcion']);
			GetRelations();
			break;
		case 4:
			//die($_POST['funcion']);
			DeleteRelation();
			GetRelations();
			break;
	}
?>