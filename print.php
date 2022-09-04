<?php
/*
  $Id: print.php,v 2.5.5 2008/10/19 23:03:53 10c $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

require('includes/application_top.php');
require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_BUILDER);

// get builder options - assembly fee
  $cbcomp_query = tep_db_query("select pc_system_assembly from " . TABLE_BUILDER_OPTIONS);
  while ($cbcomp = tep_db_fetch_array($cbcomp_query)){
    $pc_system_assembly = $cbcomp['pc_system_assembly'];
  }
?>

<html>
<head>
  <meta http-equiv="Content-Language" content="he">
  <meta http-equiv="Content-Type" content="text/html; charset=windows0255">
  <title><?php echo STORE_NAME; ?></title>
</head>

<body>
  <center>
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="650" id="AutoNumber1">
  <hr color="#000000" size="1">
    <tr>
      <td width="34%">
        <p align="center"><b><font face="Times New Roman" size="4"><u><?php echo STORE_NAME; ?></u><br>
        <?php echo TEXT_COMPUTER; ?></font></b>
      </td>
      <tr>
        <td width="37%">
          <p align="center"><b><font face="Verdana" size="2">
          <?php echo TEXT_ADDRESS; ?> : <?php echo nl2br(STORE_NAME_ADDRESS); ?><br>
          <?php echo TEXT_EMAIL; ?> : <?php echo STORE_OWNER_EMAIL_ADDRESS; ?></font></b>
        </td>
      </tr>
    </tr>
    <tr>
      <td colspan="3">
      <hr color="#000000" size="1">
      <br>
      <table border="1" align="center" cellpadding="0" cellspacing="5" style="border-collapse: collapse" bordercolor="#111111" width="645" id="AutoNumber2">
        <tr>
          <td width="16"><strong></strong></td>
          <td width="137"><strong><?php echo TEXT_PART_TYPE; ?></strong></td>
          <td width="373"><p align="center"><strong><?php echo TEXT_PART_NAME; ?></strong></td>
          <td width="100"><p align="center"><span lang="en-us"> <strong><?php echo TEXT_PART_PRICE; ?></strong></span></td>
          <td width="52"><p align="center"><strong><?php echo TEXT_PART_QUANTITY; ?></strong></td>
        </tr>
<?php
     $InsertProducts=($_POST["product"]);
     $InsertPrices=($_POST["price"]);
     $InsertQTY=$_POST["ammount"];
     $InsertProducts=explode("::",$InsertProducts);
     $InsertPrices=explode("::",$InsertPrices);
     $InsertQTY=explode("::",$InsertQTY);
     $pcount=1;
     $bcomp_query = tep_db_query("select pc_category_name from " . TABLE_BUILDER_CATEGORIES . " ORDER BY pc_category_id");
      while ($bcomp = tep_db_fetch_array($bcomp_query)){
		$pccat[$pcount]= $bcomp['pc_category_name'];
?>
        <tr>
          <td width="16"></td>
          <td width="137"><?php echo $pccat[$pcount]; ?></td>
          <td width="373"><?php if ($InsertProducts[$pcount]!="0"){echo $InsertProducts[$pcount];} ?></td>
          <td width="100" align="right"><?php if ($InsertProducts[$pcount]!="0"){echo $InsertPrices[$pcount];} ?></td>
          <td width="52" align="center"><?php if ($InsertProducts[$pcount]!="0"){echo $InsertQTY[$pcount];} ?></td>
        </tr>
<?php
            $pcount++;
      }
// CHECK IF ASSEMBLY FEE ENABLED
      if ($pc_system_assembly != '0') {
?>
        <tr>
          <td width="16"></td>
          <td width="137"><?php echo ASSEMBLY; ?></td>
          <td width="373"><?php  if ($InsertProducts[$pcount]!="0"){echo $InsertProducts[$pcount];} ?></td>
          <td width="100" align="right"><?php if ($InsertProducts[$pcount]!="0"){echo $InsertPrices[$pcount];} ?></td>
          <td width="52" align="center"><?php if ($InsertProducts[$pcount]!="0"){echo $InsertQTY[$pcount];} ?></td>
        </tr>
<?php
      }
?>
      </table>
      <br>
    </td>
  </tr>
  <?php //---------------------------------------------------------------------------------------------
  ?>
  <tr>
    <td colspan="3">
      <table border="1" align="center" cellpadding="0" cellspacing="5" style="border-collapse: collapse" bordercolor="#111111" width="66%" id="AutoNumber3">
        <tr>
          <td width="123%" colspan="2"><b><font size="4"><?php echo TEXT_TOTAL_PRICE; ?><span lang="en-us">
            :</span> </font><font size="4" face="David"><?php echo $_POST["totprint"]; ?></font></b></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td colspan="3"> <br>
      <hr color="#000000" size="1">
      <form method="POST">
        <p align="center" dir="ltr">
          <input type="button" value="PRINT" name="B1" onClick="window.print()">
          &nbsp;&nbsp;&nbsp;
          <input type="button" value="CLOSE" onClick="window.close()">
        </p>
      </form>
    </td>
  </tr>
</table>

</body>
       </center>
</html>