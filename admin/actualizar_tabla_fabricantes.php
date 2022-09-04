<?php
/*
Copyright 2005 © insidephp@gmail.com

Se otorga el permiso para copiar, distribuir, y/o modificar este programa bajo los términos 
de la Licencia GNU de Documentación Libre (GFDL, GNU Free Documentation License) versión 2 
o posteriores publicadas por la Fundación Software Libre (FSF, Free Software Foundation).

Según esta licencia, cualquier trabajo derivado de esta documentación deberá ser notificado 
al autor, aunque la voluntad del mismo es otorgar la máxima libertad posible. 

Este programa se distribuye con la intención de ser útil, pero SIN NINGUNA GARANTÍA; incluso 
sin la garantía implícita de USABILIDAD o UTILIDAD PARA UN FIN PARTICULAR. Vea la Licencia 
Pública General GNU para más detalles.

Soporte y Updaters: http://insidephp.sytes.net
email: insidephp@gmail.com
*/
//------------------------------------------------------------------------------------------
//  Definiciones


  require('includes/application_top.php');

	$db_server			= DB_SERVER;
	$db_name				= DB_DATABASE;
	$db_username		= DB_SERVER_USERNAME;
	$db_password		= DB_SERVER_PASSWORD;


	//  Nombre del archivo.

	$filename 			= "actualizar_tabla_fabricantes";


//------------------------------------------------------------------------------------------
//  No tocar
	error_reporting( E_ALL & ~E_NOTICE );
	define( 'Str_VERS', "1.1.2" );
	define( 'Str_DATE', "28 de Marzo de 2005" );
//------------------------------------------------------------------------------------------
?>
<?php
///////  El área protegida empieza DESPUÉS de la SIGUIENTE línea  /////
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
<HTML>
 <HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Insertar Tabla actualizar_tabla_fabricantes</title>
	<!-- no cache headers -->
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="no-cache">
	<meta http-equiv="Expires" content="-1">
	<meta http-equiv="Cache-Control" content="no-store">
	<meta http-equiv="Cache-Control" content="no-cache">
	<meta http-equiv="Cache-Control" content="must-revalidate">
	<!-- end no cache headers --> 
 </HEAD>
<BODY 
	bgcolor="#D5D5D5" 
	text="#000000" 
	id="all" 
	leftmargin="25" 
	topmargin="25" 
	marginwidth="25" 
	marginheight="25" 
	link="#000020" 
	vlink="#000020" 
	alink="#000020">
<strong>
 
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
        </table></td>
<!-- body_text //-->
 <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
 

 
<?php
	@set_time_limit( 0 );
	$queries_para_info = 1000;     //  cada n queries procesadas, se envia el progreso al navegador.

	echo( "- Base de Datos: '$db_name' en '$db_server'.<br>" );
	$error = false;

	if ( !@function_exists( 'gzopen' ) ) {
		$hay_Zlib = false;
		echo( "- Ya que no está disponible Zlib, usaré el BackUp de la Base de Datos: '$filename'<br>" );
	}
	else {
		$hay_Zlib = true;
		$filename = $filename . ".sql";
		echo( "- Ya que está disponible Zlib, usaré el BackUp de la Base de Datos: '$filename'<br>" );
	}

	if( !$file = @fopen( $filename,"r" ) ) {
	    echo ("<br>- Lo siento, no encuentro o no puedo abrir: '$filename'.<br>");
	    $error = true;
	}
	else { 
	    if( fseek($file, 0, SEEK_END)==0 )
	        $filesize_comprimido = ftell( $file );
	    else { 
	       echo ("<br>- Lo siento, no puedo obtener las dimensiones de '$filename'.<br>");
	       $error = true;
	    }
	 	  fclose( $file );
	}

	if ( !$error ) {
		if( $hay_Zlib ) {
			if ( !$file = @gzopen( $filename, "rb" ) ) {
				echo( "<br>- Lo siento, no encuentro o no puedo abrir: '$filename'.<br>" );
				$error = true;
			}
			else {
				gzrewind( $file );
			}
		}
		else {
			if ( !$file = @fopen( $filename, "rb" ) ) {
				echo( "<br>- Lo siento, no encuentro o no puedo abrir: '$filename'.<br>" );
				$error = true;
			}
			else {
				rewind( $file );
			}
		}
	}

	if (!$error) { 
	    $dbconnection = @mysql_connect( $db_server, $db_username, $db_password ); 
	    if ($dbconnection) 
	        $db = mysql_select_db( $db_name );
	    if ( !$dbconnection || !$db ) { 
	        echo( "<br>" );
	        echo( "- Lo siento, la conexion con la Base de datos ha fallado: ".mysql_error()."<br>" );
	        $error = true;
	    }
	    else {
	        echo( "<br>" );
	        echo( "- He establecido conexion con la Base de datos.<br>" );
	    }
	}

	if (!$error) { 
	    $result = mysql_list_tables( $db_name );
			if (!$result) {
					print "<br>- Error, no puedo obtener la lista de las tablas.<br>";
					print '<br>- MySQL Error: ' . mysql_error(). '<br>';
					$error = true;
			}
			else {
					// $count es el número de tablas en la base de datos
					$count = mysql_num_rows($result);

			}
	}

	if( !$error ) { 
	    $query = "";
	    $last_query = "";
    	$queries_info = 0;
	    $total_queries = 0;
	    $total_lineas = 0;
	
			$t_start = time();
	    echo( "<br>" );
	    
			while( 1 ) {
				if( $hay_Zlib )
					$seacabo = gzeof( $file ) OR $error;
				else
					$seacabo = feof( $file ) OR $error;
				if( $seacabo )
					break;
				if( $hay_Zlib )
					$statement = gzgets( $file );
				else
					$statement = fgets( $file );
					
	        $statement = trim( $statement );
	        $total_lineas++;
	        // no se procesan comentarios ni lineas en blanco
	        if ( $statement=="--" || $statement=="" || strpos ($statement, "#") === 0) { 
	            continue;
	        }
	        // pasa a query
	        $query .= $statement;
	        // ejecuta query si esta completo
	        if( ereg( ";$", $statement ) ) { 
	            if ( !mysql_query( $query, $dbconnection) ) { 
	                echo(" <br>" );
	                echo("- Error en statement: $statement<br>" );
	                echo("- Query: $query<br>");
	                echo("- MySQL: ".mysql_error()."<br>" );
	                $error = true;
	                break;
	            }
	            $last_query = $query;
	            $query = "";
	            $total_queries++;
            	$queries_info++;
            	if( $queries_info == $queries_para_info ) {
									$sl = number_format($total_lineas, 0, ',', '.');
									$sq = number_format($total_queries, 0, ',', '.');
                	echo("&nbsp;&nbsp;&nbsp;Lineas - Queries procesadas: $sl - $sq<br>");
                	$queries_info = 0;
            	}
	        }
	    }

			if( $hay_Zlib )
				$file_offset = gztell($file);
	    else
	    	$file_offset = ftell($file);
	
			$total_lineas = number_format($total_lineas, 0, ',', '.');
			$total_queries = number_format($total_queries, 0, ',', '.');
			$filesize_comprimido = number_format($filesize_comprimido, 0, ',', '.');
			$file_offset = number_format($file_offset, 0, ',', '.');
			
	    echo( "<pre>" );
	    echo( "- Líneas procesadas......................... $total_lineas<br>" );
	    echo( "- Queries procesadas........................ $total_queries<br>" );
	    echo( "- Último Query procesado.................... '$last_query'<br>" );
			if( $hay_Zlib ) {
	    	echo( "- Base de Datos comprimida.................. $filesize_comprimido bytes<br>");
	    	echo( "- Base de Datos descomprimida y procesada... $file_offset bytes<br>" );
	  	}
	  	else {
	    	echo( "- Base de Datos procesada................... $file_offset bytes<br>" );
	  	}
	    echo( "</pre>" );
			$t_now = time();
			$t_delta = $t_now - $t_start;
			if( !$t_delta )
				$t_delta = 1;
			$t_delta = floor(($t_delta-(floor($t_delta/3600)*3600))/60)." minutos y "
			.floor($t_delta-(floor($t_delta/60))*60)." segundos.";
			echo( "- He completado el Restore de la Base de Datos en $t_delta<br>" );
	}

	if ( $dbconnection )
	    mysql_close();
	if ( $file )
		if( $hay_Zlib )
			gzclose($file);
	   else
	    fclose($file);

	echo( "</strong><br><br><hr><center><small>" );
	setlocale( LC_TIME,"spanish" );
	echo strftime( "%A %d %B %Y&nbsp;-&nbsp;%H:%M:%S", time() );
	echo( "<br>&copy;2005 <a href=\"mailto:insidephp@gmail.com\">Inside PHP</a><br>" );
	echo( "vers." . Str_VERS . "<br>" );
	echo( "</small></center>" );
	echo( "</BODY>" );
	echo( "</HTML>" );

//------------------------------------------------------------------------------------------
//  END
?>


<?php
///////  El área protegida acaba ANTES de la ANTERIOR línea  /////
?>
