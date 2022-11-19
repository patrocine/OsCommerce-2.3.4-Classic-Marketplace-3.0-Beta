<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/           //   tep_href_link(tep_selected_file('administrator.php')

        // tep_admin_files_boxes(  array( 'code' => 'cpe.php', 'title' => 'Reglas Categorias', 'link' => tep_href_link('cpe.php'))),



            if (@tep_admin_files_boxes(FILENAME_CATEGORIES)){
         $FILENAME_CATEGORIES_a = FILENAME_CATEGORIES;
         $BOX_CATALOG_CATEGORIES_PRODUCTS_a = BOX_CATALOG_CATEGORIES_PRODUCTS;
        }


            if (@tep_admin_files_boxes('cpe.php')){

         $cpe_a = 'cpe.php';
         $reglas_categorias = 'Reglas Categorias';
        }

            if (@tep_admin_files_boxes('products_multi.php')){
         $products_multi = 'products_multi.php';
         $Multiples_Cambios = 'Multiples Cambios';
        }

            if (@tep_admin_files_boxes('quick_cliente.php')){
         $quick_cliente = 'quick_cliente.php';
         $Mod_Productos = 'Mod Productos';
        }
            if (@tep_admin_files_boxes('easypopulate_googleshopping.php')){
         $easypopulate_googleshopping = 'easypopulate_googleshopping.php';
         $Actualizar_Catalagos_s = 'Google Shopping export';
     }

           if (@tep_admin_files_boxes('easypopulate.php')){
         $easypopulate = 'easypopulate.php';
         $Actualizar_Catalagos = 'Actualizar Catalagos';
        }

           if (@tep_admin_files_boxes('easypopulate_referencias.php')){
         $easypopulate_referencias = 'easypopulate_referencias.php';
         $Actualizar_Catalagos_por_precios = 'Actualizar Catalagos por precio';
        }

           if (@tep_admin_files_boxes('easypopulate_referencias_actualizar.php')){
         $easypopulate_referencias_actualizar = 'easypopulate_referencias_actualizar.php';
         $referencias_actualizar = 'Actualizar Catalagos';
        }

           if (@tep_admin_files_boxes('regladeprecios.php')){
         $easypopulate_referencias_actualizar = 'regladeprecios.php';
         $regladeprecios_text = 'Regla de Precios';
        }
           if (@tep_admin_files_boxes('products_attributes.php')){
         $products_attributes = 'products_attributes.php';
         $products_attributes_text = 'Atributos';
        }

           if (@tep_admin_files_boxes(FILENAME_MANUFACTURERS)){
         $FILENAME_MANUFACTURERS = FILENAME_MANUFACTURERS;
         $BOX_CATALOG_MANUFACTURERS = BOX_CATALOG_MANUFACTURERS;
        }
           if (@tep_admin_files_boxes(FILENAME_REVIEWS)){
         $FILENAME_REVIEWS = FILENAME_REVIEWS;
         $BOX_CATALOG_REVIEWS = BOX_CATALOG_REVIEWS;
        }

            if (@tep_admin_files_boxes(FILENAME_SPECIALS)){
         $FILENAME_SPECIALS = FILENAME_SPECIALS;
         $BOX_CATALOG_SPECIALS = BOX_CATALOG_SPECIALS;
        }
             if (@tep_admin_files_boxes(FILENAME_DISCOUNT_COUPONS)){
         $FILENAME_DISCOUNT_COUPONS = FILENAME_DISCOUNT_COUPONS;
         $BOX_CATALOG_DISCOUNT_COUPONS = BOX_CATALOG_DISCOUNT_COUPONS;
        }

           if (@tep_admin_files_boxes('filtro_images_selec.php')){
         $filtro_images_selec = 'filtro_images_selec.php';
         $filtro_images_selec_text = 'Filtrar Imagenes';
        }
           if (@tep_admin_files_boxes(FILENAME_PRODUCTS_EXPECTED)){
         $FILENAME_PRODUCTS_EXPECTED = FILENAME_PRODUCTS_EXPECTED;
         $BOX_CATALOG_PRODUCTS_EXPECTED = BOX_CATALOG_PRODUCTS_EXPECTED;
                           }
          
          

//echo tep_admin_files_boxes('cpe.php', 'REGLAS CATEGORIAS');
  //echo tep_admin_files_boxes('products_multi.php', 'Multiples Cambios');

  $cl_box_groups[] = array(
    'heading' => BOX_HEADING_CATALOG,
    'apps' => array(
      array(
        'code' => $FILENAME_CATEGORIES_a,
        'title' => $BOX_CATALOG_CATEGORIES_PRODUCTS_a,
        'link' => $FILENAME_CATEGORIES_a
      ),
    array(
       'code' =>  $cpe_a,
        'title' => $reglas_categorias,
        'link' => $cpe_a
      ),
      array(
        'code' => $products_multi,
        'title' => $Multiples_Cambios,
        'link' => $products_multi
      ),
      array(
        'code' => $quick_cliente,
        'title' => $Mod_Productos,
        'link' => $quick_cliente
      ),
      array(
        'code' => $easypopulate,
        'title' => $Actualizar_Catalagos,
        'link' => $easypopulate
      ),
            array(
        'code' => $easypopulate_googleshopping,
        'title' => $Actualizar_Catalagos_s ,
        'link' => $easypopulate_googleshopping
      ),
      array(
        'code' => $easypopulate_referencias,
        'title' => $Actualizar_Catalagos_por_precios,
        'link' => $easypopulate_referencias
      ),
      //array(
      //  'code' => 'easypopulate_referencias_sino.php',
      //  'title' => 'Actualizar Catalagos por Act-Inac',
      //  'link' => tep_href_link('easypopulate_referencias_sino.php')
     // ),
      array(
        'code' => $easypopulate_extraimage_description,
        'title' => $Actualizar_ExImag_Descripciones,
        'link' => $easypopulate_extraimage_description
      ),
      array(
        'code' => $easypopulate_referencias_actualizar,
        'title' => $referencias_actualizar,
        'link' => $easypopulate_referencias_actualizar
      ),
      array(
        'code' => $regladeprecios,
        'title' => $regladeprecios_text,
        'link' => $regladeprecios
      ),
      array(
        'code' => $products_attributes,
        'title' => $products_attributes_text,
        'link' => $products_attributes
      ),
      array(
        'code' => $FILENAME_MANUFACTURERS,
        'title' => $BOX_CATALOG_MANUFACTURERS,
        'link' => $FILENAME_MANUFACTURERS
      ),
      array(
        'code' => $FILENAME_REVIEWS ,
        'title' => $BOX_CATALOG_REVIEWS,
        'link' => $FILENAME_REVIEWS
      ),
      array(
        'code' => $FILENAME_SPECIALS,
        'title' => $BOX_CATALOG_SPECIALS,
        'link' => $FILENAME_SPECIALS
      ),
      array(
     'code' => $FILENAME_DISCOUNT_COUPONS,
     'title' => $BOX_CATALOG_DISCOUNT_COUPONS,
     'link' => $FILENAME_DISCOUNT_COUPONS
     ),


      array(
        'code' => $filtro_images_selec,
        'title' => $filtro_images_selec_text,
        'link' => $filtro_images_selec
      ),

      array(
        'code' => $FILENAME_PRODUCTS_EXPECTED,
        'title' => $BOX_CATALOG_PRODUCTS_EXPECTED,
        'link' => $FILENAME_PRODUCTS_EXPECTED
      )
    )
  );
?>
