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

           if (@tep_admin_files_boxes('easypopulate.php')){
         $easypopulate = 'easypopulate.php';
         $Actualizar_Catalagos = 'Actualizar Catalagos';
        }

           if (@tep_admin_files_boxes('easypopulate_referencias.php')){
         $easypopulate_referencias = 'easypopulate_referencias.php';
         $Actualizar_Catalagos_por_precios = 'Actualizar Catalagos por precio';
        }

           if (@tep_admin_files_boxes('easypopulate_extraimage_description.php')){
         $Actualizar_ExImag_Descripciones = 'easypopulate_extraimage_description.php';
         $Actualizar_Catalagos = 'Actualizar Catalagos';
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
        'code' => 'easypopulate_referencias_actualizar.php',
        'title' => 'Cambiar Referencias',
        'link' => tep_href_link('easypopulate_referencias_actualizar.php')
      ),
      array(
        'code' => 'regladeprecios.php',
        'title' => 'Regla de Precios',
        'link' => tep_href_link('regladeprecios.php')
      ),
      array(
        'code' => FILENAME_PRODUCTS_ATTRIBUTES,
        'title' => BOX_CATALOG_CATEGORIES_PRODUCTS_ATTRIBUTES,
        'link' => tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES)
      ),
      array(
        'code' => FILENAME_MANUFACTURERS,
        'title' => BOX_CATALOG_MANUFACTURERS,
        'link' => tep_href_link(FILENAME_MANUFACTURERS)
      ),
      array(
        'code' => FILENAME_REVIEWS,
        'title' => BOX_CATALOG_REVIEWS,
        'link' => tep_href_link(FILENAME_REVIEWS)
      ),
      array(
        'code' => FILENAME_SPECIALS,
        'title' => BOX_CATALOG_SPECIALS,
        'link' => tep_href_link(FILENAME_SPECIALS)
      ),
      array(
     'code' => FILENAME_DISCOUNT_COUPONS,
     'title' => BOX_CATALOG_DISCOUNT_COUPONS,
     'link' => tep_href_link(FILENAME_DISCOUNT_COUPONS)
     ),


      array(
        'code' => 'filtro_images_selec.php',
        'title' => 'Filtrar Imagenes',
        'link' => tep_href_link('filtro_images_selec.php')
      ),

      array(
        'code' => FILENAME_PRODUCTS_EXPECTED,
        'title' => BOX_CATALOG_PRODUCTS_EXPECTED,
        'link' => tep_href_link(FILENAME_PRODUCTS_EXPECTED)
      )
    )
  );
?>
