<?php



    ob_start();


?>


<table border="1" width="100%" id="table1">
	<tr>
		<td>aaa</td>
		<td>ddd</td>
	</tr>
	<tr>
		<td>ssss</td>
		<td>eeee</td>
	</tr>
</table>


  <?php
// Cargamos la librería dompdf que hemos instalado en la carpeta dompdf
require_once 'pdf/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

// Introducimos HTML de prueba



     $html=ob_get_clean();



// Instanciamos un objeto de la clase DOMPDF.
$pdf = new DOMPDF();

// Definimos el tamaño y orientación del papel que queremos.
$pdf->set_paper("letter", "portrait");
//$pdf->set_paper(array(0,0,104,250));

// Cargamos el contenido HTML.
$pdf->load_html(utf8_decode($html));

// Renderizamos el documento PDF.
$pdf->render();

// Enviamos el fichero PDF al navegador.
$pdf->stream('reportePdf.pdf');


function file_get_contents_curl($url) {
	$crl = curl_init();
	$timeout = 5;
	curl_setopt($crl, CURLOPT_URL, $url);
	curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
	$ret = curl_exec($crl);
	curl_close($crl);
	return $ret;
}
