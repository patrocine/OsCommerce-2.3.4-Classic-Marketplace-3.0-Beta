var s=""+
"<?php

  require('includes/configure.php');


// include the database functions
  require(DIR_WS_FUNCTIONS . 'database.php');

// make a connection to the database... now
  tep_db_connect() or die('Unable to connect to database server!');

// set the application parameters
  $configuration_query = tep_db_query('select configuration_key as cfgKey, configuration_value as cfgValue from ' . 'configuration');
  while ($configuration = tep_db_fetch_array($configuration_query)) {
    define($configuration['cfgKey'], $configuration['cfgValue']);
  }

?>"+


"<?php



              $linkbanner = $_GET['linkbanner'];
              $linkenlace = $_GET['linkenlace'];
              $url_web = $_GET['url_web'];
              $nombre = $_GET['nombre'];
              $nombre_sector = $_GET['nombre_sector'];
              $nombre_ciudad = $_GET['nombre_ciudad'];
              $email = $_GET['email'];

                $link_values = mysql_query("select * from " . 'affiliate_compartir_empresas' . " where 	url_enlace = '" . $linkenlace . "'");
              if ($link= mysql_fetch_array($link_values)){



                      if ($link['aut'] == 1){
       $link = ' <img border=0 src='.$_GET['url_web'].'images/verde.jpg width=26 height=24>';

                      $sql_status_update_array = array('nombre' => $nombre,
                                                      'email' => $email,
                                                      'url_empresa_catalog' => $linkbanner,
                                                      'url_web' => $url_web,
                                                      'nombre_sector' => $nombre_sector,
                                                      'nombre_ciudad' => $nombre_ciudad,
                                                      'url_enlace' => $linkenlace,
                                                     );

             tep_db_perform('affiliate_compartir_empresas', $sql_status_update_array, 'update', " url_enlace = '" . $linkenlace . "'");

                                        }else{

       $link = ' <img border=0 src='.$_GET['url_web'].'images/rojo.jpg width=26 height=24>';



                                    }
       
       
       
          }else{
             $link = ' <img border=0 src='.$_GET['url_web'].'images/rojo.jpg width=26 height=24>';
         
           $Query = "INSERT INTO " . 'affiliate_compartir_empresas' . " set
              url_enlace = '" . $_GET['linkenlace'] . "',
              url_empresa_catalog = '" . $_GET['linkbaner']. "'";
              tep_db_query($Query);
              $new_id = tep_db_insert_id();

         
         
      }

              
              
                       
?>"+



"    "+
"    </p><?php echo $link; ?></td></a> ";


document.write(s);
