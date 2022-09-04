<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/



            if (@tep_admin_files_boxes('contabilidad_st.php')){

         $contabilidad_st = 'contabilidad_st.php';
         $Servicio_Asistencia = 'Servicio Asistencia';
        }

            if (@tep_admin_files_boxes(FILENAME_CUSTOMERS)){

         $FILENAME_CUSTOMERS = FILENAME_CUSTOMERS;
         $BOX_CUSTOMERS_CUSTOMERS = BOX_CUSTOMERS_CUSTOMERS;
        }

            if (@tep_admin_files_boxes(FILENAME_CUSTOMERS_POINTS)){

         $FILENAME_CUSTOMERS_POINTS = FILENAME_CUSTOMERS_POINTS;
         $BOX_CUSTOMERS_POINTS = BOX_CUSTOMERS_POINTS;
        }
            if (@tep_admin_files_boxes(FILENAME_CUSTOMERS_POINTS_PENDING)){

         $FILENAME_CUSTOMERS_POINTS_PENDING = FILENAME_CUSTOMERS_POINTS_PENDING;
         $BOX_CUSTOMERS_POINTS_PENDING = BOX_CUSTOMERS_POINTS_PENDING;
        }

            if (@tep_admin_files_boxes(FILENAME_CUSTOMERS_POINTS_REFERRAL)){

         $FILENAME_CUSTOMERS_POINTS_REFERRAL = FILENAME_CUSTOMERS_POINTS_REFERRAL;
         $BOX_CUSTOMERS_POINTS_REFERRAL = BOX_CUSTOMERS_POINTS_REFERRAL;
        }

            if (@tep_admin_files_boxes('newsletter_gestion_inscrits.php')){

         $newsletter_gestion_inscrits = 'newsletter_gestion_inscrits.php';
         $NewsLetter = 'NewsLetter';
        }


            if (@tep_admin_files_boxes(FILENAME_ORDERS)){

         $FILENAME_ORDERS = FILENAME_ORDERS;
         $BOX_CUSTOMERS_ORDERS = BOX_CUSTOMERS_ORDERS;
        }


            if (@tep_admin_files_boxes('orders_tienda.php')){

         $orders_tienda = 'orders_tienda.php';
         $name_boxes_a = $name_boxes;
        }


            if (@tep_admin_files_boxes('edit_orders_tienda.php')){

         $edit_orders_tienda = 'edit_orders_tienda.php';

        }



            if (@tep_admin_files_boxes('invoice_etiqueta.php')){

         $invoice_etiqueta = 'invoice_etiqueta.php';
         $Etiquetas= 'Etiquetas';
        }


            if (@tep_admin_files_boxes('invoice_factura.php')){

         $invoice_factura = 'invoice_factura.php';
         $Factura= 'Factura';
        }
        

            if (@tep_admin_files_boxes('invoice_form3.php')){

         $invoice_form3 = 'invoice_form3.php';
         $Certificado= 'Certificado';
        }

            if (@tep_admin_files_boxes('invoice_form1.php')){

         $invoice_form1 = 'invoice_form1.php';
         $Reembolso= 'Reembolso';
        }
        
            if (@tep_admin_files_boxes('create_order_tienda.php')){

         $create_order_tienda = 'create_order_tienda.php';
         $Crear_Pedido= 'Crear Pedido';
        }

        
        
        

        
  $cl_box_groups[] = array(
    'heading' => BOX_HEADING_CUSTOMERS,
    'apps' => array(
      array(
        'code' => $contabilidad_st,
        'title' => '<p><b><font color="#FF6600">'.$Servicio_Asistencia.'</font></b></p>',
        'link' => $contabilidad_st
      ),
           ######## Points/Rewards Module V2.1beta BOF ##################
     array(
        'code' => $FILENAME_CUSTOMERS,
        'title' => $BOX_CUSTOMERS_CUSTOMERS,
        'link' => $FILENAME_CUSTOMERS
      ),
      array(
        'code' => $FILENAME_CUSTOMERS_POINTS,
        'title' => $BOX_CUSTOMERS_POINTS,
        'link' => $FILENAME_CUSTOMERS_POINTS
      ),
      array(
        'code' => $FILENAME_CUSTOMERS_POINTS_PENDING,
        'title' => $BOX_CUSTOMERS_POINTS_PENDING,
        'link' => $FILENAME_CUSTOMERS_POINTS_PENDING
      ),
      array(
        'code' => $FILENAME_CUSTOMERS_POINTS_REFERRAL,
        'title' => $BOX_CUSTOMERS_POINTS_REFERRAL,
        'link' => $FILENAME_CUSTOMERS_POINTS_REFERRAL
      ),
      ######## Points/Rewards Module V2.1beta EOF ##################
      array(
        'code' => $newsletter_gestion_inscrits,
        'title' => '<p><b><font color="#66CCFF">'.$NewsLetter.'</font></b></p>',
        'link' => $newsletter_gestion_inscrits
      ),
      array(
        'code' => $FILENAME_ORDERS,
        'title' => '<p><b>'. $BOX_CUSTOMERS_ORDERS .'</b></p>',
        'link' => $FILENAME_ORDERS
      ),
      array(
        'code' => $orders_tienda,
        'title' => '<font color="#FF6600">'.$name_boxes_a.'</font>',
        'link' => $orders_tienda
      ),
      array(
        'code' => $orders_tienda,
        'title' => '<b><font color="#008000">Stock</font></b>',
        'link' => 'orders_tienda.php?status='.$entregas_stock
      ),
     array(
        'code' => $orders_tienda,
        'title' => '<b><font color="#008000">Cobrado</font></b>',
        'link' => 'orders_tienda.php?status='.$cobrado
      ),
     array(
        'code' => $orders_tienda,
        'title' => '<b><font color="#008000">Pagado</font></b>',
        'link' => 'orders_tienda.php?status='.$pagado
      ),
      array(
        'code' => $edit_orders_tienda,
        'title' => '',
        'link' => ''
      ),
      array(
        'code' => 'index.php',
        'title' => '',
        'link' => ''
      ),
      array(
        'code' => $invoice_etiqueta,
        'title' => '<p><b><font color="#66CCFF">'.$Etiquetas.'</font></b></p>',
        'link' => $invoice_etiqueta
      ),
      array(
        'code' => $invoice_factura,
        'title' => '<p><b><font color="#66CCFF">'.$Factura.'</font></b></p>',
        'link' => $invoice_factura
      ),
      array(
        'code' => $invoice_form3,
        'title' => '<p><b><font color="#66CCFF">'.$Certificado.'</font></b></p>',
        'link' => $invoice_form3
      ),
      array(
        'code' => $invoice_form1,
        'title' => '<p><b><font color="#66CCFF">'.$Reembolso.'</font></b></p>',
        'link' => $invoice_form1
      ),
      array(
        'code' => $create_order_tienda,
        'title' => '<font color="#FF9900">'.$Crear_Pedido.'</font>',
        'link' => $create_order_tienda
      )
    )
  );
?>
