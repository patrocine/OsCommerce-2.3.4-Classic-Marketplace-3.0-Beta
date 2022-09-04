<?php

         if ($sumar_a){




    $sumar_entregado_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status =a.entregas_stock and a.admin_groups_id=6 and a.admin_id = 14";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_entregado_total= tep_db_fetch_array($sumar_entregado_total_sales_query);

    $sumar_mercancia_entregado_procesando_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status =a.status_entregas and a.admin_groups_id=6 and a.admin_id = 14";
    $sumar_mercancia_entregado_procesando_sales_query = tep_db_query($sumar_mercancia_entregado_procesando_sales_raw);
    $sumar_mercancia_entregado_procesando= tep_db_fetch_array($sumar_mercancia_entregado_procesando_sales_query);

    $sumar_retirado_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status =a.retirarado and a.admin_groups_id=6 and a.admin_id = 14";
    $sumar_retirado_sales_query = tep_db_query($sumar_retirado_sales_raw);
    $sumar_retirado= tep_db_fetch_array($sumar_retirado_sales_query);

    $sumar_credito_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status =a.credito and a.admin_groups_id=6";
    $sumar_credito_total_sales_query = tep_db_query($sumar_credito_total_sales_raw);
    $sumar_credito_total= tep_db_fetch_array($sumar_credito_total_sales_query);


    //$sumar_no_recogido_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $product_info['products_id'] . "'and o.orders_status =a.no_recogido and a.admin_groups_id=6";
    //$sumar_no_recogido_sales_query = tep_db_query($sumar_no_recogido_sales_raw);
    //$sumar_no_recogido= tep_db_fetch_array($sumar_no_recogido_sales_query);

    $sumar_pagado_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status =a.pagado and a.admin_groups_id=6";
    $sumar_pagado_total_sales_query = tep_db_query($sumar_pagado_total_sales_raw);
    $sumar_pagado_total= tep_db_fetch_array($sumar_pagado_total_sales_query);

    $sumar_cobrados_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status =a.cobrado and a.admin_groups_id=6";
    $sumar_cobrados_total_sales_query = tep_db_query($sumar_cobrados_total_sales_raw);
    $sumar_cobrados_total= tep_db_fetch_array($sumar_cobrados_total_sales_query);

    $sumar_pagado_transferencia_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status =a.pagado_transferencia and a.admin_groups_id=6";
    $sumar_pagado_transferencia_sales_query = tep_db_query($sumar_pagado_transferencia_sales_raw);
    $sumar_pagado_transferencia= tep_db_fetch_array($sumar_pagado_transferencia_sales_query);

    $sumar_paypal_enviado_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status =a.paypal_enviado and a.admin_groups_id=6";
    $sumar_paypal_enviado_sales_query = tep_db_query($sumar_paypal_enviado_sales_raw);
    $sumar_paypal_enviado= tep_db_fetch_array($sumar_paypal_enviado_sales_query);

    $sumar_pendiente_entrada_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status = a.pendiente_entrada and a.admin_groups_id=6";
    $sumar_pendiente_entrada_total_sales_query = tep_db_query($sumar_pendiente_entrada_total_sales_raw);
    $sumar_pendiente_entrada_total= tep_db_fetch_array($sumar_pendiente_entrada_total_sales_query);

    $sumar_credito_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status =a.credito and a.admin_groups_id=6";
    $sumar_credito_sales_query = tep_db_query($sumar_credito_sales_raw);
    $sumar_credito= tep_db_fetch_array($sumar_credito_sales_query);


    $sumar_pagos_procesando_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status =a.status_liquidacion and a.admin_groups_id=6";
    $sumar_pagos_procesando_sales_query = tep_db_query($sumar_pagos_procesando_sales_raw);
    $sumar_pagos_procesando= tep_db_fetch_array($sumar_pagos_procesando_sales_query);







    $sumar_pagado_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $pagado . "'";
    $sumar_pagado_sales_query = tep_db_query($sumar_pagado_sales_raw);
    $sumar_pagado= tep_db_fetch_array($sumar_pagado_sales_query);



    $sumar_entregado_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $entregas_stock . "'";
    $sumar_entregado_sales_query = tep_db_query($sumar_entregado_sales_raw);
    $sumar_entregado= tep_db_fetch_array($sumar_entregado_sales_query);




    $sumar_retirado_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $retirarado . "'";
    $sumar_retirado_sales_query = tep_db_query($sumar_retirado_sales_raw);
    $sumar_retirado= tep_db_fetch_array($sumar_retirado_sales_query);

    $sumar_cobrados_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $cobrado . "'";
    $sumar_cobrados_sales_query = tep_db_query($sumar_cobrados_sales_raw);
    $sumar_cobrados= tep_db_fetch_array($sumar_cobrados_sales_query);

    $sumar_presupuestos_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $login_presupuestos . "'";
    $sumar_presupuestos_sales_query = tep_db_query($sumar_presupuestos_sales_raw);
    $sumar_presupuestos= tep_db_fetch_array($sumar_presupuestos_sales_query);
    
    
    $sumar_credito_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $login_credito . "'";
    $sumar_credito_sales_query = tep_db_query($sumar_credito_sales_raw);
    $sumar_credito= tep_db_fetch_array($sumar_credito_sales_query);

    $sumar_login_pendiente_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $login_pendiente . "'";
    $sumar_login_pendiente_sales_query = tep_db_query($sumar_login_pendiente_sales_raw);
    $sumar_login_pendiente= tep_db_fetch_array($sumar_login_pendiente_sales_query);



    $sumar_status_salidas_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $status_salidas . "'";
    $sumar_status_salidas_sales_query = tep_db_query($sumar_status_salidas_sales_raw);
    $sumar_status_salidas= tep_db_fetch_array($sumar_status_salidas_sales_query);


    // status que generan negativos de mercancias





    $sumar_pagado_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $pagado . "'";
    $sumar_pagado_sales_query = tep_db_query($sumar_pagado_sales_raw);
    $sumar_pagado= tep_db_fetch_array($sumar_pagado_sales_query);



    $sumar_pagado_internacional_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $pagado_internacional . "'";
    $sumar_pagado_internacional_sales_query = tep_db_query($sumar_pagado_internacional_sales_raw);
    $sumar_pagado_internacional= tep_db_fetch_array($sumar_pagado_internacional_sales_query);


     $sumar_status_procesando_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $login_procesando . "'";
    $sumar_status_procesando_sales_query = tep_db_query($sumar_status_procesando_sales_raw);
    $sumar_status_procesando= tep_db_fetch_array($sumar_status_procesando_sales_query);

     $sumar_status_entregas_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $status_entregas . "'";
    $sumar_status_entregas_sales_query = tep_db_query($sumar_status_entregas_sales_raw);
    $sumar_status_entregas= tep_db_fetch_array($sumar_status_entregas_sales_query);

    $sumar_cancelado_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $login_cancelado . "'";
    $sumar_cancelado_sales_query = tep_db_query($sumar_cancelado_sales_raw);
    $sumar_cancelado= tep_db_fetch_array($sumar_cancelado_sales_query);


    $sumar_status_liquidacion_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $status_liquidacion . "'";
    $sumar_status_liquidacion_query = tep_db_query($sumar_status_liquidacion_raw);
    $sumar_status_liquidacion= tep_db_fetch_array($sumar_status_liquidacion_query);




    $sumar_status_liquidacion_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, " . TABLE_ADMIN . " a where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status =a.status_liquidacion and a.admin_groups_id=6";
    $sumar_status_liquidacion_total_sales_query = tep_db_query($sumar_status_liquidacion_total_sales_raw);
    $sumar_status_liquidacion_total= tep_db_fetch_array($sumar_status_liquidacion_total_sales_query);

    $sumar_status_albaran_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, " . TABLE_ADMIN . " a where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status =a.albaran and a.admin_groups_id=6";
    $sumar_status_albaran_query = tep_db_query($sumar_status_albaran_raw);
    $sumar_status_albaran = tep_db_fetch_array($sumar_status_albaran_query);











    $sumar_pagado_paypal_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $pagado_paypal . "'";
    $sumar_pagado_paypal_sales_query = tep_db_query($sumar_pagado_paypal_sales_raw);
    $sumar_pagado_paypal= tep_db_fetch_array($sumar_pagado_paypal_sales_query);

    $sumar_pagado_internacional_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $pagado_internacional . "'";
    $sumar_pagado_internacional_sales_query = tep_db_query($sumar_pagado_internacional_sales_raw);
    $sumar_pagado_internacional= tep_db_fetch_array($sumar_pagado_internacional_sales_query);




    $sumar_pagado_paypal_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $pagado_paypal . "'";
    $sumar_pagado_paypal_sales_query = tep_db_query($sumar_pagado_paypal_sales_raw);
    $sumar_pagado_paypal= tep_db_fetch_array($sumar_pagado_paypal_sales_query);

   $sumar_transferencia_pendiente_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $login_transferencia . "'";
    $sumar_transferencia_pendiente_sales_query = tep_db_query($sumar_transferencia_pendiente_sales_raw);
    $sumar_transferencia_pendiente= tep_db_fetch_array($sumar_transferencia_pendiente_sales_query);


   $sumar_transferencia_procesando_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $login_transferencia_procesando . "'";
    $sumar_transferencia_procesando_sales_query = tep_db_query($sumar_transferencia_procesando_sales_raw);
    $sumar_transferencia_procesando= tep_db_fetch_array($sumar_transferencia_procesando_sales_query);

   $sumar_procesando_paypal_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $login_procesando_paypal . "'";
    $sumar_procesando_paypal_sales_query = tep_db_query($sumar_procesando_paypal_sales_raw);
    $sumar_procesando_paypal= tep_db_fetch_array($sumar_procesando_paypal_sales_query);



   $sumar_procesando_reembolso_internacional_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $login_procesando_reembolso_internacional . "'";
    $sumar_procesando_reembolso_internacional_sales_query = tep_db_query($sumar_procesando_reembolso_internacional_sales_raw);
    $sumar_procesando_reembolso_internacional= tep_db_fetch_array($sumar_procesando_reembolso_internacional_sales_query);


    $sumar_pendiente_entrada_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $login_pendiente_entrada . "'";
    $sumar_pendiente_entrada_sales_query = tep_db_query($sumar_pendiente_entrada_sales_raw);
    $sumar_pendiente_entrada= tep_db_fetch_array($sumar_pendiente_entrada_sales_query);
    

                }// fin sumar_a
// totales para control de almacen central. PARA USO GENERAL DE TODAS LAS CUENTAS.

    
    $sumar_pendiente_entrada_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, " . TABLE_ADMIN . "  a where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status = a.pendiente_entrada and a.admin_groups_id=6";
    $sumar_pendiente_entrada_total_sales_query = tep_db_query($sumar_pendiente_entrada_total_sales_raw);
    $sumar_pendiente_entrada_total= tep_db_fetch_array($sumar_pendiente_entrada_total_sales_query);

    $sumar_pagado_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, " . TABLE_ADMIN . " a where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status =a.pagado and a.admin_groups_id=6";
    $sumar_pagado_total_sales_query = tep_db_query($sumar_pagado_total_sales_raw);
    $sumar_pagado_total= tep_db_fetch_array($sumar_pagado_total_sales_query);

    $sumar_cobrados_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, " . TABLE_ADMIN . " a where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status =a.cobrado and a.admin_groups_id=6";
    $sumar_cobrados_total_sales_query = tep_db_query($sumar_cobrados_total_sales_raw);
    $sumar_cobrados_total= tep_db_fetch_array($sumar_cobrados_total_sales_query);




    $sumar_no_recogido_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, " . TABLE_ADMIN . " a where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status =a.no_recogido and a.admin_groups_id=6";
    $sumar_no_recogido_sales_query = tep_db_query($sumar_no_recogido_sales_raw);
    $sumar_no_recogido= tep_db_fetch_array($sumar_no_recogido_sales_query);
    
    $sumar_pagado_transferencia_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, " . TABLE_ADMIN . " a where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status =a.pagado_transferencia and a.admin_groups_id=6";
    $sumar_pagado_transferencia_sales_query = tep_db_query($sumar_pagado_transferencia_sales_raw);
    $sumar_pagado_transferencia= tep_db_fetch_array($sumar_pagado_transferencia_sales_query);

    
    $sumar_paypal_enviado_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, " . TABLE_ADMIN . " a where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status =a.paypal_enviado and a.admin_groups_id=6";
    $sumar_paypal_enviado_sales_query = tep_db_query($sumar_paypal_enviado_sales_raw);
    $sumar_paypal_enviado= tep_db_fetch_array($sumar_paypal_enviado_sales_query);

    $sumar_entregado_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, " . TABLE_ADMIN . " a where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status =a.entregas_stock and a.admin_groups_id=6";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_entregado_total= tep_db_fetch_array($sumar_entregado_total_sales_query);


    $sumar_pendiente_entrada_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, " . TABLE_ADMIN . " a where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status = a.pendiente_entrada and a.admin_groups_id=6";
    $sumar_pendiente_entrada_total_sales_query = tep_db_query($sumar_pendiente_entrada_total_sales_raw);
    $sumar_pendiente_entrada_total= tep_db_fetch_array($sumar_pendiente_entrada_total_sales_query);

    $sumar_credito_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, " . TABLE_ADMIN . " a where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status = a.credito and a.admin_groups_id=6";
    $sumar_credito_sales_query = tep_db_query($sumar_credito_sales_raw);
    $sumar_credito= tep_db_fetch_array($sumar_credito_sales_query);


// Suma productos al stock
      //mercancia entregada procesando
   $suman_productos = $sumar_entregado_total['value']; // $sumar_status_entregas['value']+
      //mercancia entregada

      //no recodigo
    //  $sumar_no_recogido['value'];
      //cancelado
   // $sumar_cancelado['value'];




 //restan productos del stock

    //pedido enviado (Admin y Empleados)
   $restan_productos =  $sumar_credito['value']+$sumar_cobrados_total['value']+ $sumar_pagado_total['value']+$sumar_pagado_transferencia['value']+$sumar_paypal_enviado['value']+$sumar_pendiente_entrada_total['value'];
   
      /*
   
   
    // pedido enviado internacional (Admin)
    $sumar_pagado_internacional['value']+
    // Pagado   (Admin y Empleados)
    $sumar_pagado['value']+
    // Paypal Envíado (admin)
    $sumar_paypal_enviado['value']+
    // Transferencia, Pedido Envíado (Admin)
    $sumar_pagado_transferencia['value']+


    // pendiente de entreda(admin y empleado)
    $sumar_pendiente_entrada['value']+
    // pendiente (admin y empleado)
    $sumar_login_pendiente['value']+
    // Pagado Paypal(admin)
    $sumar_pagado_paypal['value']+
    // Transferencia  (admin)
    $sumar_transferencia_pendiente['value']+



    // Procesando Reembolso (admin y Empleado)
    $sumar_status_procesando['value']+
    // procesando reembolso internacional (admin)
    $sumar_procesando_reembolso_internacional['value']+
    // transferencia procesando
    $sumar_transferencia_procesando['value']+
    // paypal procesando
    $sumar_paypal_procesando['value']+



    // mercancía en proceso de retirada.
    $sumar_status_salidas['value']+
    // mercancía retirada.
    $sumar_retirado['value'];
       */

 ?>
