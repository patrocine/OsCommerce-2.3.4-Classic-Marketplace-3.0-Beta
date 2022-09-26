<?php
/*
  $Id: view_counter, v 1.0 2012/07/01 by Jack_mcs

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce
  Portions Copyright 2012 oscommerce-solution.com

  Released under the GNU General Public License
*/

  require('includes/application_top.php');
  require('includes/languages/' . $language . '/view_counter.php');
  require('includes/functions/view_counter.php');
          
  $colors = array();
  $presetChecked = array();
  $presetChecked[COLOR_PRESET_DEFAULT] = 'checked';
  $previewMode = (isset($_POST['color_preset']) ? true : false);

  if (isset($_POST['update'])) {
      SaveColorSettings($_POST);
      $previewMode = false;
  }
  
  else if (isset($_POST['preview'])) {
      foreach ($_POST as $id => $color) {
          if (strpos($color, '#') !== FALSE) {
              $colors[$id] = $color;
          }    
      }
  }

  else if (isset($_POST['color_preset'])) {
      switch ($_POST['color_preset']) {
           case COLOR_PRESET_AUTUM: 
              $colors = array('color1' =>  '#FF9900', 'color2' =>  '#FFCC00', 'color3' =>  '#FFFF66', 
                              'color4' =>  '#bef4ff', 'color5' =>  '#00ff00', 'color6' =>  '#FF9900', 
                              'color7' =>  '#ff9900', 'color8' =>  '#00ffba', 'color9' =>  '#03ffff', 
                              'color10' => '#ff0000', 'color11' => '#f191ef', 'color12' => '#f0f091' );
           
           break;           
           
           case COLOR_PRESET_BLUE:         
              $colors = array('color1' =>  '#66CCFF', 'color2' =>  '#CCFFCC', 'color3' =>  '#0099CC', 
                              'color4' =>  '#003399', 'color5' =>  '#00ff00', 'color6' =>  '#66CCFF', 
                              'color7' =>  '#0099CC', 'color8' =>  '#00ffba', 'color9' =>  '#03ffff', 
                              'color10' => '#ff0000', 'color11' => '#f191ef', 'color12' => '#f0f091' );
           break;           
            
           case COLOR_PRESET_OSCOMMERCE:         
              $colors = array('color1' =>  '#eeeeee', 'color2' =>  '#DEE4E8', 'color3' =>  '#DEE4E8', 
                              'color4' =>  '#DEE4E8', 'color5' =>  '#00ff00', 'color6' =>  '#c9C9C9', 
                              'color7' =>  '#c9C9C9', 'color8' =>  '#dddddd', 'color9' =>  '#d9C9C9', 
                              'color10' => '#ff0000', 'color11' => '#885297', 'color12' => '#f0f091' );
           break;     
           
           case COLOR_PRESET_DEFAULT:
           default: 
              $colors = array('color1' =>  '#a6e985', 'color2' =>  '#eee',    'color3' =>  '#c8c8c8', 
                              'color4' =>  '#bef4ff', 'color5' =>  '#00ff00', 'color6' =>  '#ffcc00', 
                              'color7' =>  '#9e92fd', 'color8' =>  '#00ffba', 'color9' =>  '#03ffff', 
                              'color10' => '#ff0000', 'color11' => '#f191ef', 'color12' => '#f0f091' );
           break;           
           
      }
      $presetChecked = array();
      $presetChecked[$_POST['color_preset']] = 'checked';
  }
 
  if (! isset($_POST['preview']) && ! $previewMode) {
      if (isset($_GET['clear_settings'])) { //only used for development
          tep_db_query("truncate view_counter_settings");
      } else {
          $mode = LoadColorSettings($colors);
          $presetChecked = array();
          $presetChecked[$mode] = 'checked';
      }
      
      if (count($colors) < 2) {
          $colors = array('color1' =>  '#a6e985', 'color2' =>  '#eee',    'color3' => '#c8c8c8', 
                          'color4' =>  '#bef4ff', 'color5' =>  '#00ff00', 'color6' =>  '#ffcc00', 
                          'color7' => '#9e92fd',  'color8' =>  '#00ffba', 'color9' =>  '#03ffff', 
                          'color10' => '#ff0000', 'color11' => '#f191ef', 'color12' => '#f0f091' );
      }
  }
 
  require('includes/view_counter_header.php');  
?>
<script src="includes/javascript/view_counter/spectrum.js"></script>
<link rel="stylesheet" href="includes/javascript/view_counter/spectrum.css" />

<script>
var colors = [ 
<?php
 $cnt = count($nameColorsArray);
 for ($i = 0; $i < $cnt; $i++) {
    echo "'{$nameColorsArray[$i]}'";
    if ($i < $cnt - 1) {
        echo ", ";
    } else {
        echo " ];";
    }
}
?>

$(document).ready(function() {

  $('.dia').click(function() {
    var id = ($(this).attr('id'));
    $("#dialog").html(id);  
    $('#dialog').load('view_counter_ajax.php?id='+$(this).attr('id')); 
    $("#dialog").dialog({modal: true, buttons: [{
                                                 text: "Ok",
                                                 click: function() { 
                                                  $(this).dialog("close"); }
                                                }]  , closeOnEscape: false ,
                                                      draggable: true,
                                                      height: 600,
                                                      width:800,
                                                      resizable: true,
                                                      title: 'IP DETAILS',                                    
                                                      zIndex: 9999    
                                                });
      return false;  // prevent the default action, e.g., following a link
  });  

  for (var i=0; i < colors.length; i++) {

  $('#' + colors[i]).spectrum({  
      showInitial: true,
      showInput: true,
      showPalette: true,
      showSelectionPalette: true,
      palette: [
          ['black', 'white', 'blanchedalmond'], 
          ['rgb(255, 128, 0);', 'hsv 100 70 50', 'lightyellow']
      ],
      localStorageKey: "view_counter_colors", // Any Spectrum with the same string will share selection
  });  
 }
       
});

</script>
<style type="text/css">
h2 { margin:0px; padding:10px; font-family: Georgia, "Times New Roman", Times, serif; font-size: 120%; font-weight: normal; color: #FFF; background-color: #CCC; border-bottom: #BBB 2px solid; }

/* Form styles */
div.form-container { margin: 10px; padding: 5px; background-color: #FFF; }

p.legend { margin-bottom: 1em; }
p.legend em { color: #C00; font-style: normal; }

div.form-container div.controlset {display: block; float:left; width: 100%; padding: 0.25em 0;}

div.form-container div.controlset label, 
div.form-container div.controlset input,
div.form-container div.controlset div { display: inline; float: left; }

div.form-container div.controlset label { width: 100px;}
label { white-space:nowrap; }  
th { border-width:thin; border-style: outset; background-color:<?php echo $colors[COLOR_COL_HEADINGS]; ?>}
</style>

<?php if (strpos(PROJECT_VERSION, 'v2.3') !== FALSE) { ?>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<?php } else { ?>
<body bgcolor="#FFFFFF" onload="SetFocus();">
<!-- header //-->
<?php require('includes/header.php'); ?>
<!-- header_eof //-->
<!-- body //-->
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
<?php require('includes/column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
<?php } ?>

 
    <td width="100%" valign="top"><table width="100%" border="0">
      <tr>
        <form action="view_counter_color.php?action=bgcolor&mode=add" method="post" enctype="multipart/form-data"><?php echo tep_hide_session_id(); ?>
          <td width="100%" >    
            <table width="100%" border="0">
              <tr>
               <td width="100%" colspan="3">
                <table width="100%" border="0">
                 <tr>
                  <td style="margin:0px; color: #FFF; background-color: #CCC; border-bottom: #BBB 2px solid; float:left; width:100%">
                   <h2> <?php echo HEADING_COLOR_PICKER; ?></h2>
                  </td>
                  <td style="margin:0px; color: #FFF; background-color: #CCC; border-bottom: #BBB 2px solid; float:left; width:100%">
                   <span style="margin: auto; width:100%; float:left; padding-left:120px; font-size: 16pt; font-weight: normal; color: #FF0000; background-color: #CCC; border-bottom: #BBB 2px solid;">PLEASE NOTE: THIS PAGE IS FOR CHANGING COLORS. THE LINKS ON IT ARE NOT VALID.</span>
                  </td>
                 </tr>
                </table> 
               </td>               
              </tr> 
              
              <tr>
                <td>
                <?php 
                  for ($i = 1, $n = 0; $i < count($colors) + 1; $i+=2, $n+=2) { 
                            echo '<div class="controlset"><label for="' . $nameColorsArray[$n] . '"><input id="' . $nameColorsArray[$n] . '" type="text" name="' . $nameColorsArray[$n] . '" value="' . $colors[$nameColorsArray[$n]]  . '" />&nbsp;&nbsp;' . $textColorsArray[$nameColorsArray[$n]] . '</label></div>';
                  }
                 ?>                
                </td>
                <td>
                <?php 
                  for ($i = 2, $n = 1; $i < count($colors) + 1; $i+=2, $n+=2) { 
                      echo '<div class="controlset"><label for="' . $nameColorsArray[$n] . '"><input id="' . $nameColorsArray[$n] . '" type="text" name="' . $nameColorsArray[$n] . '" value="' . $colors[$nameColorsArray[$n]]  . '" />&nbsp;&nbsp;' . $textColorsArray[$nameColorsArray[$n]] . '</label></div>';
                  }
                 ?>                
                </td>      

                <td valign="top" width="100%">
                  <div>
                    <div class="main"><b><?php echo COLOR_PRESET_HEADING; ?></b></div>
                    <div class="main" align=left><INPUT TYPE="radio" NAME="color_preset" VALUE="<?php echo COLOR_PRESET_DEFAULT; ?>" <?php echo $presetChecked[COLOR_PRESET_DEFAULT]; ?>  onChange="this.form.submit();"><?php echo COLOR_PRESET_DEFAULT; ?></div>
                    <div class="main" align=left><INPUT TYPE="radio" NAME="color_preset" VALUE="<?php echo COLOR_PRESET_AUTUM; ?>"  <?php echo $presetChecked[COLOR_PRESET_AUTUM]; ?> onChange="this.form.submit();"><?php echo COLOR_PRESET_AUTUM; ?></div>
                    <div class="main" align=left><INPUT TYPE="radio" NAME="color_preset" VALUE="<?php echo COLOR_PRESET_BLUE; ?>"  <?php echo $presetChecked[COLOR_PRESET_BLUE]; ?> onChange="this.form.submit();"><?php echo COLOR_PRESET_BLUE; ?></div>
                    <div class="main" align=left><INPUT TYPE="radio" NAME="color_preset" VALUE="<?php echo COLOR_PRESET_OSCOMMERCE; ?>"  <?php echo $presetChecked[COLOR_PRESET_OSCOMMERCE]; ?> onChange="this.form.submit();"><?php echo COLOR_PRESET_OSCOMMERCE; ?></div>
                  </div>
                </td>  
              </tr>
              
              <tr>
                <td>
                  <input type="submit" name="update" value="update" style="font-size:12px; height:24px; width:80px; border:2px outset #000; background-color:#c8c8c8;">
                  <input type="submit" name="preview" value="preview" style="font-size:12px; height:24px; width:80px; border:2px outset #000; background-color:#c8c8c8;">
                </td>
              </tr>     
   
            </table>              
          </td>  
        </form>
      </tr>
         
<!-- body_text //-->
    <tr><td colspan="2" width="100%" >
    <table border="2" width="100%" cellspacing="0" cellpadding="0">
    <tr>
      <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2" style="background-color:<?php echo $colors[COLOR_HDR_BKGND]; ?>">

       <tr>        
        <td><table border="0" width="40%" cellspacing="0" cellpadding="0">
            <tr>
               <td class="pageHeading" valign="top">ViewCounter&nbsp;V&nbsp;1.0</td>
            </tr>
            <tr>
               <td class="em_small" valign="top"><a href="http://forums.oscommerce.com/topic/34-viewcounter/" target="_blank"><span style="color: sienna;">(visit the support thread)</span></a></td>
            </tr>
        </table></td>                        
        <td><table border="0" width="100%">
         <tr>       
          <td class="em_small" align="right">by Jack_mcs from <a href="http://www.oscommerce-solution.com/" target="_blank"><span style="font-family: Verdana, Arial, sans-serif; color: sienna; font-size: 12px;">oscommerce-solution.com</span></a></td>
         </tr>
         <form name="version_check" action="not_for_use.php" method="post"><input type="hidden" name="action" value="getversion">               <tr>
                  <td class="em_small" align="right" style="font-weight: bold; color: red;"><INPUT TYPE="radio" NAME="version_check" onClick="this.form.submit();">Check for Updates</td>
               </tr>
           </form>
                  
        </table></td>
       </tr>  
       <tr>
        <td colspan="2"><img src="images/pixel_trans.gif" border="0" alt="" width="100%" height="10"></td>
       </tr>
       <tr>
         <td class="smallText" colspan="2"><div style="padding-bottom:5px;">This package allows you to see. among other things, the pages accessed on your site, the number of times they were accessed
          and the IP used. You can also do various things with the IP, as explained in the list below. Click here for
          <a href="javascript:void(null);" onclick="showHelp();"><span style="color:#ff0000;">help</span>.</a>
          <div id="dialog-modal" title="View Counter Help" style="display: none;"></div> 
          </div>
 
          <div style="float:left; margin-bottom:-20px;" >
            <div class="main" style="text-align:center; font-weight:bold; text-decoration:underline;">SETTINGS</div>
            <div class="smallText"">
             <ul>
             <li>Ban the IP: This prevents this IP from being able to access your site.</li>
             <li>Ignore the IP: Don't do anything with this IP (useful for your own and known good IP's).</li>
             <li>Delete the IP: Remove the IP from the list.</li>
             <li>Kick off the IP: Removes the session associated with this IP.</li>
            </ul>
           </div>
          </div>
          
          <div style="float:left; margin-bottom:-20px;">
            <div  class="main" style="text-align:center; font-weight:bold; text-decoration:underline;">COLORS</div>
            <div class="smallText">
             <ul style="padding-bottom:-5px;">
             <li style="color:#86c6c6">This IP accessed the admin.</li>
             <li style="color:#ff0000">This IP has possible hacker code in the parameters.</li>
             <li style="color:#00ffba">This IP is a bot.</li>
             <li style="color:#f191ef">This IP triggered the bot trap.</li>
            </ul>
           </div>
          </div>
         </td>
       </tr>
       <tr>
        <td colspan="2"><img src="images/pixel_trans.gif" border="0" alt="" width="100%" height="10"></td>
       </tr>   
      </table></td>  
     </tr>    
     
     <tr>
       <td><table border="0" width="100%" style="background-color:<?php echo $colors[COLOR_OPTIONS]; ?>">
          
       <!-- BEGIN OF ViewCounter -->
       <form name="view_counter_main" action="not_for_use.php" method="post"><input type="hidden" name="action" value="process"> 
              
         <tr>
           <td width="900"><table border="0" cellpadding="0" width="100%">       
             <tr>
               <td width="300" valign="top"><table border="0" cellpadding="0" width="100%" class="rightBar">
                 <tr>
                   <td width="150"><table border="0" cellpadding="0" width="100%">
                     <tr>
                       <td class="smallText"><select name="banned_ips"  id="ban_list" onChange="ChangeBoxStatus('ban');" style="width:140px;"><option value="0" SELECTED>Banned List</option><option value="1">yandex.com</option><option value="2">0.0.0.1/31</option><option value="3">0.0.0.3/30</option><option value="4">0.0.0.7/29</option><option value="5">0.0.0.15/28</option><option value="6">0.0.0.31/27</option><option value="7">0.0.0.63/26</option><option value="8">0.0.0.127/25</option><option value="9">0.0.10.0/19</option><option value="10">0.0.42.0/18</option><option value="11">0.0.106.0/13</option><option value="12">1.202.0.0/15</option><option value="13">8.0.0.0/8</option><option value="14">8.11.2.10</option><option value="15">37.59.213.209</option><option value="16">37.230.220.0/23</option><option value="17">38.0.0.0/8</option><option value="18">41.244.111.59</option><option value="19">46.33.96.0/19</option><option value="20">46.108.240.215</option><option value="21">59.172.155.206</option><option value="22">64.234.210.0</option><option value="23">67.152.0.0/14</option><option value="24">67.205.103.128/27</option><option value="25">77.75.77.11</option><option value="26">84.180.201.254</option><option value="27">85.50.100.144</option><option value="28">85.108.47.192</option><option value="29">88.165.150.0/23</option><option value="30">89.70.247.102</option><option value="31">91.0.0.0/8</option><option value="32">91.121.64.0/18</option><option value="33">91.201.64.0/24</option><option value="34">92.4.0.0/15</option><option value="35">92.85.0.0/16</option><option value="36">100.43.64.0/19</option><option value="37">101.80.65.211</option><option value="38">101.220.134.7</option><option value="39">101.224.0.1/11</option><option value="40">101.226.166.235</option><option value="41">101.226.166.251</option><option value="42">102.0.0.1/7</option><option value="43">103.14.172.0/22</option><option value="44">107.20.80.224</option><option value="45">109.120.157.179</option><option value="46">109.163.231.48</option><option value="47">109.173.248.227</option><option value="48">109.230.246.247</option><option value="49">110.84.26.21</option><option value="50">110.85.124.211</option><option value="51">110.86.185.127</option><option value="52">110.174.0.0/15</option><option value="53">111.72.0.0/13</option><option value="54">111.161.29.0/24</option><option value="55">111.161.30.0/24</option><option value="56">112.81.124.0/24</option><option value="57">112.100.0.0/14</option><option value="58">112.111.0.0/16</option><option value="59">112.111.190.233</option><option value="60">113.105.65.111</option><option value="61">113.212.64.0/19</option><option value="62">114.80.0.0/12</option><option value="63">117.26.194.103</option><option value="64">117.206.176.0/20</option><option value="65">118.96.135.184</option><option value="66">118.96.200.0/22</option><option value="67">119.63.192.0/21</option><option value="68">119.147.6.0/24</option><option value="69">119.147.75.0/24</option><option value="70">119.160.61.165</option><option value="71">120.40.150.181</option><option value="72">122.11.38.16</option><option value="73">122.11.38.17</option><option value="74">122.105.123.165</option><option value="75">123.0.0.0/8</option><option value="76">125.176.0.0/12</option><option value="77">128.75.0.0/16</option><option value="78">173.199.64.0/18</option><option value="79">173.224.120.15</option><option value="80">174.127.133.138</option><option value="81">177.22.48.161</option><option value="82">178.204.0.0/15</option><option value="83">182.0.0.0/8</option><option value="84">183.0.0.0/10</option><option value="85">184.22.0.0/16</option><option value="86">186.120.29.220</option><option value="87">186.151.34.63</option><option value="88">188.143.232.211</option><option value="89">193.41.184.0/22</option><option value="90">195.43.70.130</option><option value="91">199.187.122.91</option><option value="92">200.119.139.130</option><option value="93">201.46.62.178</option><option value="94">202.46.32.0/19</option><option value="95">204.15.64.0/21</option><option value="96">207.191.196.101</option><option value="97">208.115.111.74</option><option value="98">209.51.162.219</option><option value="99">211.167.112.1/32</option><option value="100">213.186.112.0/20</option><option value="101">216.152.240.0/20</option><option value="102">218.6.0.0/17</option><option value="103">218.6.15.42</option><option value="104">218.30.96.0/19</option><option value="105">220.181.0.0/16</option><option value="106">222.184.0.0/13</option></select></td>
                     </tr> 
                   </table></td>
                   <td width="120"><table border="0" cellpadding="0">
                     <tr class="smallText">
                       <td width="100" style="font-weight:bold;">Remove Ban:</td>
                       <td width="5"><input type="checkbox" name="remove_ban", id="remove_ban" value="", disabled onchange="this.form.submit();"></td>
                     </tr>  
                   </table></td>  
                 </tr>
                 <tr>
                   <td width="150"><table border="0" cellpadding="0" width="100%">
                     <tr>
                       <td class="smallText"><select name="ignored_ips"  id="ignore_list" onChange="ChangeBoxStatus('ignore');" style="width:140px;"><option value="0" SELECTED>Ignored List</option><option value="1">0.1.0.0/15</option><option value="2">0.3.0.0/14</option><option value="3">65.52.0.0/14</option><option value="4">66.249.64.0/19</option><option value="5">66.249.68.119</option><option value="6">66.249.71.46</option><option value="7">66.249.73.21</option><option value="8">72.167.191.15</option><option value="9">72.167.191.16</option><option value="10">72.167.191.17</option><option value="11">72.167.191.18</option><option value="12">137.117.0.0/16</option><option value="13">157.54.0.0/16</option><option value="14">157.55.32.86</option><option value="15">157.55.32.87</option><option value="16">157.55.32.103</option><option value="17">157.55.32.188</option><option value="18">157.55.34.32</option><option value="19">157.55.34.168</option><option value="20">157.55.35.37</option><option value="21">157.56.229.88</option><option value="22">157.60.0.0/16</option></select></td>
                     </tr> 
                   </table></td>
                   <td width="120"><table border="0" cellpadding="0">
                     <tr class="smallText">
                       <td width="100" style="font-weight:bold;">Remove Ignore:</td>
                       <td width="5"><input type="checkbox" name="remove_ignore", id="remove_ignore" value="", disabled onchange="this.form.submit();"></td>
                     </tr>  
                   </table></td>  
                 </tr>
               </table></td> 
  
               <td width="190" valign="top"><table border="0" cellpadding="0" width="100%">
                 <tr>             
                   <div style="margin-left:4px;">
                     <div class="smallText"style="float:left;">
                       <div style="font-weight:bold; padding-bottom:4px;">Show:</div>
                       <div><INPUT TYPE="radio" NAME="group2" VALUE="Admin"  onchange="this.form.submit();"> Admin</div>
                       <div><INPUT TYPE="radio" NAME="group2" VALUE="Bots"  onchange="this.form.submit();"> Bots</div>
                       <div><INPUT TYPE="radio" NAME="group2" VALUE="Visitors" checked onchange="this.form.submit();"> Visitors </div>
                       <div><INPUT TYPE="radio" NAME="group2" VALUE="All"  onchange="this.form.submit();"> All </div>
                     </div>
                     <div class="smallText rightBar" style="float:right; margin-right:4px;">
                       <div style="font-weight:bold; padding-bottom:4px;">Type:</div>
                       <div><INPUT TYPE="checkbox" NAME="show_only_active"  onchange="this.form.submit();"><nobr>Active Only</nobr></div>
                       <div><INPUT TYPE="checkbox" NAME="show_related_pages" checked onchange="this.form.submit();"><nobr>Related</nobr></div>
                       <div><INPUT TYPE="checkbox" NAME="show_only_spoofed"  onchange="this.form.submit();"><nobr>Spoofed Only</nobr></div>
                     </div>
                   </div> 
                 </tr>  
               </table></td> 
               
               <td width="220" valign="top"><table border="0" cellpadding="0" width="100%">
                 <tr>
                   <td><table border="0" cellpadding="0">
                     <tr class="smallText">             
                       <td><input type="submit" name="submit_only_this_ip" value="Show Only IP" style="font-size:10px; height:14px; width:80px; border:1px solid #000; background:<?php echo $colors[COLOR_BUTTONS]; ?>"></td>
                       <td width="60"><input type="" name="only_this_ip" maxlength="35" size="14"> </td>
                     </tr>
                     <tr class="smallText">             
                       <td><input type="submit" name="submit_block_range" value="Block Range" style="font-size:10px; height:14px; width:80px; border:1px solid #000; background:<?php echo $colors[COLOR_BUTTONS]; ?>"></td>
                       <td width="60"><input type="" name="block_range" maxlength="35" size="14"> </td>
                     </tr>  
                   </table></td> 
                   <td><table border="0" cellpadding="0">
                     <tr class="smallText">             
                       <td><input type="submit" name="submit_ip_in_cidr" value="IP in CIDR?" style="font-size:10px; height:14px; width:80px; border:1px solid #000; background:<?php echo $colors[COLOR_BUTTONS]; ?>"></td>
                       <td width="60"><input type="" name="ip_in_cidr" maxlength="35" size="14"> </td>
                     </tr>  
                     <tr class="smallText">             
                       <td><input type="submit" name="submit_ignore_range" value="Ignore Range" style="font-size:10px; height:14px; width:80px; border:1px solid #000; background:<?php echo $colors[COLOR_BUTTONS]; ?>"></td>
                       <td width="60"><input type="" name="ignore_range" maxlength="35" size="14"> </td>
                     </tr> 
                   </table></td>
                 </tr>  
                 <tr>             
                   <td align="center" colspan="2"><div class="smallText" style="padding-top:10px; text-align:center; font-weight:bold;">Last Refresh at 13:21:51 - Next Refresh in <b id="timeto_refresh">90</b> seconds</div></td>
                 </tr>  
               </table></td>                
              
             </tr> 
           </table></td>
         </tr>  
         <input type="hidden" name="sortBy" value="order by last_date  desc"><input type="hidden" name="sortByArray" value="a%3A7%3A%7Bs%3A4%3A%22date%22%3Bs%3A7%3A%22checked%22%3Bs%3A8%3A%22filename%22%3Bs%3A0%3A%22%22%3Bs%3A2%3A%22ip%22%3Bs%3A0%3A%22%22%3Bs%3A5%3A%22count%22%3Bs%3A0%3A%22%22%3Bs%3A3%3A%22arg%22%3Bs%3A0%3A%22%22%3Bs%3A7%3A%22visitor%22%3Bs%3A0%3A%22%22%3Bs%3A5%3A%22isbot%22%3Bs%3A0%3A%22%22%3B%7D"><input type="hidden" name="showType" value="and isbot = 0"><input type="hidden" name="showTypeArray" value="a%3A3%3A%7Bs%3A4%3A%22bots%22%3Bs%3A0%3A%22%22%3Bs%3A9%3A%22customers%22%3Bs%3A7%3A%22checked%22%3Bs%3A4%3A%22all%22%3Bs%3A0%3A%22%22%3B%7D"><input type="hidden" name="page"> 
       </form>
      </table></td>
     </tr>

     <!-- Show the list //-->
     <form name="view_counter_form" action="not_for_use.php" method="post"><input type="hidden" name="action" value="process_list">      
      <tr>     
       <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0" class="BorderedBoxLight">
      <input type="hidden" name="sortBy" value="order by last_date  desc"><input type="hidden" name="sortByArray" value="a%3A7%3A%7Bs%3A4%3A%22date%22%3Bs%3A7%3A%22checked%22%3Bs%3A8%3A%22filename%22%3Bs%3A0%3A%22%22%3Bs%3A2%3A%22ip%22%3Bs%3A0%3A%22%22%3Bs%3A5%3A%22count%22%3Bs%3A0%3A%22%22%3Bs%3A3%3A%22arg%22%3Bs%3A0%3A%22%22%3Bs%3A7%3A%22visitor%22%3Bs%3A0%3A%22%22%3Bs%3A5%3A%22isbot%22%3Bs%3A0%3A%22%22%3B%7D"><input type="hidden" name="showType" value="and isbot = 0"><input type="hidden" name="showTypeArray" value="a%3A3%3A%7Bs%3A4%3A%22bots%22%3Bs%3A0%3A%22%22%3Bs%3A9%3A%22customers%22%3Bs%3A7%3A%22checked%22%3Bs%3A4%3A%22all%22%3Bs%3A0%3A%22%22%3B%7D"><input type="hidden" name="show_only_active" value=""><input type="hidden" name="show_only_spoofed" value=""><input type="hidden" name="colsortChange" value="ignore"><input type="hidden" name="colsortSet"><input type="hidden" name="colsortType">           <tr>
             <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                 <style type="text/css">
     .product {color:#000; font-size:12px; white-space:nowrap;}
     .attribute {color:0000ff; font-size:10px; white-space:nowrap;}
    </style>
             
                        <tr>
                                                    <tr style="background-color:<?php echo $colors[COLOR_LANGUAGE_BAR]; ?>"><td class="smallText" width="100%" align="left" colspan="11"><b>English</b>&nbsp;&nbsp;(access count for last 24 hours is 1354)</td></tr>
                                                    <tr class="smallText">
                            <th width="5%"  onClick="SortColumn('VISITOR','view_counter_form')" style="background-color:" onmouseover="this.style.background='#00ff00';" onmouseout="this.style.background='';"  >VISITOR</th>
                            <th width="14%" onClick="SortColumn('File Name','view_counter_form')" style="background-color:" onmouseover="this.style.background='#00ff00';" onmouseout="this.style.background='';"  >FILE NAME</th>
                            <th width="14%" onClick="SortColumn('ARG','view_counter_form')" style="background-color:" onmouseover="this.style.background='#00ff00';" onmouseout="this.style.background='';"  >PARAMETERS</th>
                            <th width="3%"  onClick="SortColumn('Count','view_counter_form')" style="background-color:" onmouseover="this.style.background='#00ff00';" onmouseout="this.style.background='';"  >COUNT</th>
                            <th width="10%" onClick="SortColumn('IP','view_counter_form')" style="background-color:" onmouseover="this.style.background='#00ff00';" onmouseout="this.style.background='';"  >IP</th>
                            <th width="9%"  onClick="SortColumn('Date','view_counter_form')" style="background-color:<?php echo $colors[COLOR_SELECTED_COLUMN]; ?>" onmouseover="this.style.background='#00ff00';" onmouseout="this.style.background='#bef4ff';"  >LAST DATE TIME^</th>
                            <th width="3%" align="center">BAN</th>
                            <th width="3%" align="center">IGNORE</th>
                            <th width="3%" align="center">DELETE</th>
                            <th width="3%" align="center">KICK</th>
                            <th width="1%" align="center">?</th>
                          </tr>
                          <tr><td style="padding-bottom:4px;"></td></tr>
                        </tr>   
                                              <tr class="smallText"  style="background-color:<?php echo $colors[COLOR_IS_BOT]; ?>" >
                          <td class="borderCell" width="5%" >Guest</td>
                          <td class="borderCell" width="14%" ><a onMouseover="ddrivetip('Session is not active','#f0f091','300' )"; onMouseout="hideddrivetip()"href="http://NOT FOR USE">product_info.php</a></td>
                          <td class="borderCell" width="14%" >products_id=747</td>
                          <td class="borderCell" width="3%">2</td>
                          <td class="borderCell" width="10%"><span style="vertical-align:bottom;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;<span><span style="vertical-align:top;"><a href="http://NOT FOR USE">129.21.64.187</a></span></span></td>
                          <td class="borderCell" width="9%">Tue, 26th 12:52:46</td>
                          <td class="borderCell" width="3%" align="center"><input type="radio" name="ban_ip_129.21.64.187", value="129.21.64.187", onchange="this.form.submit();"></td>
                          <td class="borderCell" width="3%" align="center"><input type="radio" name="ignore_ip_129.21.64.187", value="129.21.64.187", onchange="this.form.submit();"></td>
                          <td class="borderCell" width="3%" align="center"><input type="radio" name="delete_ip_129.21.64.187", value="129.21.64.187", onchange="this.form.submit();"></td>
                          <td class="borderCell" width="3%" align="center"><input type="radio" name="kick_off_129.21.64.187", value="129.21.64.187", onchange="this.form.submit();"></td>
                          <td class="borderCell" width="1%" align="center"><a class="dia" href="#" id="129.21.64.187">?</a></td>
                          <input type="hidden" name="this_session_id" value="eff0d0dbbe00256f13d551bb9ab71308">
                        </tr>
 
                          <tr class="smallText"  style="background-color:<?php echo $colors[COLOR_IS_ADMIN]; ?>" >
                          <td class="borderCell" width="5%" >Guest</td>
                          <td class="borderCell" width="14%" ><a onMouseover="ddrivetip('Session is not active','#f0f091','300' )"; onMouseout="hideddrivetip()"href="http://NOT FOR USE">index.php</a></td>
                          <td class="borderCell" width="14%" >&nbsp;</td>
                          <td class="borderCell" width="3%">1</td>
                          <td class="borderCell" width="10%"><span style="vertical-align:bottom;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;<span><span style="vertical-align:top;"><a href="http://NOT FOR USE">75.114.239.212</a></span></span></td>
                          <td class="borderCell" width="9%">Tue, 26th 12:41:59</td>
                          <td class="borderCell" width="3%" align="center"><input type="radio" name="ban_ip_75.114.239.212", value="75.114.239.212", onchange="this.form.submit();"></td>
                          <td class="borderCell" width="3%" align="center"><input type="radio" name="ignore_ip_75.114.239.212", value="75.114.239.212", onchange="this.form.submit();"></td>
                          <td class="borderCell" width="3%" align="center"><input type="radio" name="delete_ip_75.114.239.212", value="75.114.239.212", onchange="this.form.submit();"></td>
                          <td class="borderCell" width="3%" align="center"><input type="radio" name="kick_off_75.114.239.212", value="75.114.239.212", onchange="this.form.submit();"></td>
                          <td class="borderCell" width="1%" align="center"><a class="dia" href="#" id="75.114.239.212">?</a></td>
                          <input type="hidden" name="this_session_id" value="a7fd68f07a6cc8f9aa3c62caf960e073">
                        </tr>
                     
 
                          <tr class="smallText"  style="background-color:<?php echo $colors[COLOR_IS_HACKER]; ?>" >
                          <td class="borderCell" width="5%" >Guest</td>
                          <td class="borderCell" width="14%" >&nbsp;&nbsp;-> <a onMouseover="ddrivetip('Session is not active','#f0f091','300' )"; onMouseout="hideddrivetip()"href="http://NOT FOR USE"_blank">index.php</a></td>
                          <td class="borderCell" width="14%" >&nbsp;</td>
                          <td class="borderCell" width="3%">1</td>
                          <td class="borderCell" width="10%"><span style="vertical-align:bottom;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;<span><span style="vertical-align:top;"><a href="http://NOT FOR USE">75.114.239.212</a></span></span></td>
                          <td class="borderCell" width="9%">Tue, 26th 12:41:58</td>
                          <td class="borderCell" width="3%" align="center"><input type="radio" name="ban_ip_75.114.239.212", value="75.114.239.212", onchange="this.form.submit();"></td>
                          <td class="borderCell" width="3%" align="center"><input type="radio" name="ignore_ip_75.114.239.212", value="75.114.239.212", onchange="this.form.submit();"></td>
                          <td class="borderCell" width="3%" align="center"><input type="radio" name="delete_ip_75.114.239.212", value="75.114.239.212", onchange="this.form.submit();"></td>
                          <td class="borderCell" width="3%" align="center"><input type="radio" name="kick_off_75.114.239.212", value="75.114.239.212", onchange="this.form.submit();"></td>
                          <td class="borderCell" width="1%" align="center"><a class="dia" href="#" id="75.114.239.212">?</a></td>
                          <input type="hidden" name="this_session_id" value="f562601ff4e8230cebc9669df41f47d0">
                        </tr>
 
                           <tr class="smallText" >
                          <td class="borderCell" width="5%" >Guest</td>
                          <td class="borderCell" width="14%" >&nbsp;&nbsp;-> <a onMouseover="ddrivetip('Session is not active','#f0f091','300' )"; onMouseout="hideddrivetip()"href="http://NOT FOR USE">product_info.php</a></td>
                          <td class="borderCell" width="14%"  style="background-color:#ff0000;">login.php&cause damage</td>
                          <td class="borderCell" width="3%">1</td>
                          <td class="borderCell" width="10%"><span style="vertical-align:bottom;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;<span><span style="vertical-align:top;"><a href="http://NOT FOR USE">75.114.239.212</a></span></span></td>
                          <td class="borderCell" width="9%">Tue, 26th 12:40:16</td>
                          <td class="borderCell" width="3%" align="center"><input type="radio" name="ban_ip_75.114.239.212", value="75.114.239.212", onchange="this.form.submit();"></td>
                          <td class="borderCell" width="3%" align="center"><input type="radio" name="ignore_ip_75.114.239.212", value="75.114.239.212", onchange="this.form.submit();"></td>
                          <td class="borderCell" width="3%" align="center"><input type="radio" name="delete_ip_75.114.239.212", value="75.114.239.212", onchange="this.form.submit();"></td>
                          <td class="borderCell" width="3%" align="center"><input type="radio" name="kick_off_75.114.239.212", value="75.114.239.212", onchange="this.form.submit();"></td>
                          <td class="borderCell" width="1%" align="center"><a class="dia" href="#" id="75.114.239.212">?</a></td>
                          <input type="hidden" name="this_session_id" value="d9f97cfbb887fff06d39cc0196774fac">
                        </tr>                        
 
                           <tr class="smallText"  style="background-color:<?php echo $colors[COLOR_IS_BOT_TRAP]; ?>" >
                          <td class="borderCell" width="5%" >Guest</td>
                          <td class="borderCell" width="14%" >&nbsp;&nbsp;-> <a onMouseover="ddrivetip('Session is not active','#f0f091','300' )"; onMouseout="hideddrivetip()"href="http://NOT FOR USE">product_info.php</a></td>
                          <td class="borderCell" width="14%"  style="background-color:#ff0000;">login.php&cause damage</td>
                          <td class="borderCell" width="3%">1</td>
                          <td class="borderCell" width="10%"><span style="vertical-align:bottom;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;<span><span style="vertical-align:top;"><a href="http://NOT FOR USE">75.114.239.212</a></span></span></td>
                          <td class="borderCell" width="9%">Tue, 26th 12:40:16</td>
                          <td class="borderCell" width="3%" align="center"><input type="radio" name="ban_ip_75.114.239.212", value="75.114.239.212", onchange="this.form.submit();"></td>
                          <td class="borderCell" width="3%" align="center"><input type="radio" name="ignore_ip_75.114.239.212", value="75.114.239.212", onchange="this.form.submit();"></td>
                          <td class="borderCell" width="3%" align="center"><input type="radio" name="delete_ip_75.114.239.212", value="75.114.239.212", onchange="this.form.submit();"></td>
                          <td class="borderCell" width="3%" align="center"><input type="radio" name="kick_off_75.114.239.212", value="75.114.239.212", onchange="this.form.submit();"></td>
                          <td class="borderCell" width="1%" align="center"><a class="dia" href="#" id="75.114.239.212">?</a></td>
                          <input type="hidden" name="this_session_id" value="d9f97cfbb887fff06d39cc0196774fac">
                        </tr>
 
                            <tr class="smallText" >
                          <td class="borderCell" width="5%" >Guest</td>
                          <td class="borderCell" width="14%"  style="background-color:#f191ef;">&nbsp;&nbsp;-> <a onMouseover="ddrivetip('Session is not active','#f0f091','300' )"; onMouseout="hideddrivetip()"href="http://NOT FOR USE">index.php</a></td>
                          <td class="borderCell" width="14%" >cPath=22</td>
                          <td class="borderCell" width="3%">1</td>
                          <td class="borderCell" width="10%"><span style="vertical-align:bottom;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;<span><span style="vertical-align:top;"><a href="http://NOT FOR USE">75.114.239.212</a></span></span></td>
                          <td class="borderCell" width="9%">Tue, 26th 12:40:12</td>
                          <td class="borderCell" width="3%" align="center"><input type="radio" name="ban_ip_75.114.239.212", value="75.114.239.212", onchange="this.form.submit();"></td>
                          <td class="borderCell" width="3%" align="center"><input type="radio" name="ignore_ip_75.114.239.212", value="75.114.239.212", onchange="this.form.submit();"></td>
                          <td class="borderCell" width="3%" align="center"><input type="radio" name="delete_ip_75.114.239.212", value="75.114.239.212", onchange="this.form.submit();"></td>
                          <td class="borderCell" width="3%" align="center"><input type="radio" name="kick_off_75.114.239.212", value="75.114.239.212", onchange="this.form.submit();"></td>
                          <td class="borderCell" width="1%" align="center"><a class="dia" href="#" id="75.114.239.212">?</a></td>
                          <input type="hidden" name="this_session_id" value="d9f97cfbb887fff06d39cc0196774fac">
                        </tr>
                     
        
                          
             </table></td>  
           </tr>  
                
           <tr>       
             <td colspan="4"><table border="0" width="100%" cellspacing="0" cellpadding="2">
               <tr>
                 <td class="smallText" valign="top">Displaying <b>1</b> to <b>20</b> (of <b>1005</b> links)</td>
                 <td class="smallText" align="right"><form name="pages" action="not_for_use.php" method="get">&lt;&lt;&nbsp;&nbsp;Page <select name="page" onChange="this.form.submit();"><option value="1" SELECTED>1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option><option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option><option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option><option value="50">50</option><option value="51">51</option></select> of 51&nbsp;&nbsp;<a href="not_for_use.php?page=2" class="splitPageLink">&gt;&gt;</a></form></td>
               </tr>
             </table></td>  
           <tr>
      
      </table>      
      
     </td>
     
</td></tr>
<!-- body_text //-->
    
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require('includes/view_counter_footer.php'); ?>