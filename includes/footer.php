

<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/


  require(DIR_WS_INCLUDES . 'counter.php');
?>




<div class="grid_24 ui-widget infoBoxContainer">



</div>


       <p align="center"></p>
                                <?php if (PERMISO_DIRECCIONWEB == 'True'){ ?>
<p align="center"><?php echo STORE_NAME_ADDRESS; ?> </p>
                                <?php  } ?>
  <p align="center"></p>
    </div>

    </td>

  </tr>

  <tr>
      </div>

    </td>

  </tr>

  <tr>
    <td width="100%" height="61">

    <p align="center">
<table border="0" width="100%" id="table1">
	<tr>
		<td>
    <?php if (PERMISO_MAPAWEB == 'True'){ ?>
		<p align="center"><?php echo USER_LOCALIZACION_GOOGLEMAPS_WEB; ?></tr>
  <?php  } ?>
	</tr>
</table>

<script type="text/javascript">
$('.productListTable tr:nth-child(even)').addClass('alt');
</script>


   <p align="center">
               <?php if (PERMISO_TWITTER_CODE == 'True'){ ?>
   <?php echo USER_TWITTER_CODE;
                    }

   ?>

              </p>
              
              
<!-- Begin Cookie Consent plugin by Silktide - http://silktide.com/cookieconsent -->
<link rel="stylesheet" type="text/css" href="http://assets.cookieconsent.silktide.com/current/style.min.css"/>
<script type="text/javascript" src="http://assets.cookieconsent.silktide.com/current/plugin.min.js"></script>
<script type="text/javascript">
// <![CDATA[
cc.initialise({
	cookies: {
		advertising: {}
	},
	settings: {
		consenttype: "implicit"
   	},
	strings: {
		analyticsDefaultTitle: 'Analíticas ',
		socialDefaultDescription: 'Facebook, Twitter y otros sitios de redes sociales tienen que saber quién eres para que funcione correctamente.',
		analyticsDefaultDescription: 'Nosotros medimos de forma anónima su uso de este sitio web para mejorar su experiencia.',
		advertisingDefaultTitle: 'Publicidad',
		advertisingDefaultDescription: 'Los anuncios serán elegidos de forma automática en base a su comportamiento e intereses pasado.',
		necessaryDefaultTitle: 'Estrictamente necesario',
		necessaryDefaultDescription: 'Algunas cookies en este sitio web son estrictamente necesarios y no se pueden desactivar.',
		defaultTitle: 'Título de cookies por defecto',
		defaultDescription: 'Descripción cookies por defecto.',
		learnMore: 'Aprender más',
		closeWindow: 'Cerrar la Ventana',
		notificationTitle: 'Su experiencia en este sitio se mejorará al permitir las cookies',
		notificationTitleImplicit: 'Utilizamos cookies propias para conocer los intereses de nuestros clientes. Al continuar con la navegación entendemos que se acepta nuestra política de cookies.',
		customCookie: 'Esta página web utiliza un tipo personalizado de cookie que necesita la aprobación específica',
		seeDetails: 'ver más detalles',
		seeDetailsImplicit: 'cambiar la configuración',
		hideDetails: 'Ocultar detalles',
		allowCookies: 'Permitir cookies',
		allowCookiesImplicit: 'Cerrar',
		allowForAllSites: 'Permitir todos los sitios',
		savePreference: 'Salvar Preferencias',
		saveForAllSites: 'Guardar para todos los sitios',
		privacySettings: 'configuración de privacidad',
		privacySettingsDialogTitleA: 'configuración de privacidad',
		privacySettingsDialogTitleB: 'para este sitio web',
		privacySettingsDialogSubtitle: 'Algunas funciones de este sitio web es necesario su consentimiento para recordar quién eres.',
		changeForAllSitesLink: 'Cambiar la configuración para todos los sitios web',
		preferenceUseGlobal: 'Use ajuste global',
		preferenceConsent: 'Doy mi consentimiento',
		preferenceDecline: 'me niego',
		notUsingCookies: 'Este sitio web no utiliza cookies.',
		allSitesSettingsDialogTitleA: 'configuración de privacidad',
		allSitesSettingsDialogTitleB: 'para todos los sitios web',
		allSitesSettingsDialogSubtitle: 'Usted puede dar su consentimiento a estas cookies para todos los sitios web que utilizan e,ste plugin.',
		backToSiteSettings: 'Volver a la configuración del ,sitio web',
		preferenceAsk: 'Pídeme cada vez',
		preferenceAlways: 'siempre permita',
		preferenceNever: 'Nunca permita'
	}
});
// ]]>
</script>
<!-- End Cookie Consent plugin -->
 <script type="text/javascript">
$('.hastip').tooltipsy({
    css: {
        'padding': '5px',
        'max-width': '300px',
        'color': '#303030',
        'background-color': '#F0F7FE',
        'border': '1px solid #6DB8E7',
        '-moz-box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
        '-webkit-box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
        'box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
        'text-shadow': 'none'
    }
});
</script>

