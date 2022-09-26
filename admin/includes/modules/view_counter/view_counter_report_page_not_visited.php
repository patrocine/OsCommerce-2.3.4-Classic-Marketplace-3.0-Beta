<?php
  $langFiles = DIR_FS_CATALOG . 'includes/languages/' . $language . '/';  
  $filePath = glob($langFiles . '*.php');
  $files = ' ( ';
  $langFiles = array();
  foreach ($filePath as $file) {
      $pathParts = pathinfo($file);
      $files .= "'" . $pathParts['basename'] . "', ";
      $langFiles[] = $pathParts['basename'];
  }
  $files = substr($files, 0, -2) . ' ) ';
  
  $rootPath = glob(DIR_FS_CATALOG . '*.php');
  $rootFiles = array();
  foreach ($rootPath as $file) {
      $pathParts = pathinfo($file);
      $rootFiles[] = $pathParts['basename'];
  }
 
?>
           <tr>
             <td><table border="1" cellpadding="0" width="100%" class="BorderedBoxLight">
                    

               <tr class="smallText">
                 <td colspan="4"><table border="0" cellpadding="0" width="100%" style="border-width: thin; border-style: outset;">
                   <tr>
                     <td class="main" width="130"><?php echo TEXT_REPORT_COLOR_BACKGROUND; ?></td>
                   </tr>  
                 </table></td>
               </tr> 
                     
               <tr>
                 <td width="100%"><table border="1" cellpadding="0" width="100%" class="BorderedBoxLight">
                    
                   <!-- BEGIN OF ViewCounter -->           
                   <tr class="smallText">
                     <td width="90%" ><table border="0" cellpadding="0" width="100%" style="border-width: thin; border-style: outset;">
                       <?php 
                       $data = '';
                         foreach ($langFiles as $file) {
                             $view_page_query = tep_db_query("select 1 from view_counter where file_name = '" . $file . "'" );
                             
                             if (tep_db_num_rows($view_page_query) == 0) {
                                 $color = (in_array($file, $rootFiles) ? '' : ' style="background-color:#bef4ff;"' );
                                 $data .= '<tr>
                                            <td class="smallText"' . $color . '>' . $file  . '</td>
                                           </tr>';
                             }                         
                         }
                         echo $data;
                       ?>
                     </table><td>
                   </tr>
                 
                 </table></td>
               </tr>  

             </table></td>
           </tr>                 