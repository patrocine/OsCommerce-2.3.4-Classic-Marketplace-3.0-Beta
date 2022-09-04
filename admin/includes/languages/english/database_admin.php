<?php
/**********************************************************

  file: my_computers.php - v 1.11 2008/08/03

  MY COMPUTERS FILTER CONTRIBUTION
  by Brian Finkelstein ( USKeyser@aol.com )
  http://www.bfafoodservice.com/store

  Please see readme.txt

  for use with osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
**********************************************************/

define('HEADER_TITLE', 'Administrar base de datos');
define('HEADER_TITLE_CURRENT_DB', 'BD actual:');
define('HEADER_TITLE_DB_LIST', 'Lista de bases de datos');
define('HEADER_TITLE_DROP_CURRENT_DB', 'Eliminar BD actual');
define('HEADER_TITLE_INTERVAL', ' | '); // esto no se traduce, es el separador de campos de la barra de menus
define('HEADER_TITLE_MENU', 'Menu');
define('HEADER_TITLE_SHOW_DB', 'Mostrar base de datos');
define('FOOTER_TEXT_DB', 'Base de datos: ');
define('FOOTER_TEXT_DB_SERVER', 'base de datos en el servidor ');
define('FOOTER_TEXT_DB_SELECTED', 'se selecciono');
define('FOOTER_TEXT_LOG', 'Log: ');

define('TEXT_ACTIONS', 'Acciones');
define('TEXT_ADD_FIELD', 'Añadir campo');
define('TEXT_ADD_INDEX', 'Añadir indice en ');
define('TEXT_AFTER', 'Despues');
define('TEXT_AFTER_COLUMN', 'Despues de la columna ');
define('TEXT_ALTER_TABLE', 'Modificar tabla ');
define('TEXT_ALTERED', ' modificada');
define('TEXT_AT_BEGINNING_TABLE', 'Al comienzo de la tabla');
define('TEXT_AT_END_TABLE', 'Al final de la tabla');
define('TEXT_BACK_TABLE', 'Volver a las tablas ');
define('TEXT_BACK_TABLE_CONTENT', 'Volver al contenido de la tabla');
define('TEXT_BROWSE', 'Navegar');
define('TEXT_BROWSE_TABLE', 'Navegar por la tabla');
define('TEXT_CARDINALITY', 'Cardinalidad');
define('TEXT_CHANGE', 'Cambiar');
define('TEXT_CHECK_QUERY', 'compruebe su consulta');
define('TEXT_CLEAN', 'Limpiar');
define('TEXT_COLUMNS', 'columnas');
define('TEXT_COLUMNS_NUMBERS', 'Numero de columnas ');
define('TEXT_CREATE', ' creada');
define('TEXT_CREATE_INDEX', 'Crear un indice en ');
define('TEXT_CREATE_INDEX_2', 'Crear indice');
define('TEXT_CREATE_INDEX_TABLE', 'Crear indice en la tabla ');
define('TEXT_CREATE_TABLE', 'Crear tabla ');
define('TEXT_CREATED', ' creado');
define('TEXT_CSV_FILE', 'archivo CSV: ');
define('TEXT_DB', 'Base de datos ');
define('TEXT_DEFAULT', 'Por defecto');
define('TEXT_DELETE', 'Eliminar');
define('TEXT_DELETE_RECORD', 'Eliminar registro?');
define('TEXT_DENIED', 'Acceso denegado. Compruebe su configuracion');
define('TEXT_DROP', 'Eliminar');
define('TEXT_DROP_DB', 'Eliminar base de datos ');
define('TEXT_DROPPED', ' eliminada');
define('TEXT_EDIT', 'Editar');
define('TEXT_EDIT_FIELD', 'Editar campo ');
define('TEXT_EMPTY', 'Vaciar');
define('TEXT_EMPTY_NOW', ' ahora esta vacia');
define('TEXT_ERROR_CREATING_TABLE', 'Error creando tabla');
define('TEXT_ERROR_EXECUTING_QUERY', 'Error ejecutando consulta');
define('TEXT_ERROR_REMOVING_DB', 'Error al eliminar la base de datos');
define('TEXT_EXECUTE', 'Ejecutar');
define('TEXT_EXPORT', 'Exportar');
define('TEXT_EXTRA', 'Extra');
define('TEXT_FAILED', 'Error');
define('TEXT_FIELD', 'Campo');
define('TEXT_FIRST', 'Primero');
define('TEXT_FOR_TABLE', ' en la tabla ');
define('TEXT_FROM_TABLE', ' de la tabla ');
define('TEXT_GO', 'Ir');
define('TEXT_IMPORT', 'Importar');
define('TEXT_IMPORT_CSV', 'Importar CSV');
define('TEXT_INDEX', 'Indice ');
define('TEXT_INDEX_NAME', 'Nombre del indice: ');
define('TEXT_INDEX_TYPE', 'Tipo de indice: ');
define('TEXT_INFO', ' una tabla solo puede tener una clave principal que siempre se llama PRIMARY');
define('TEXT_INTO_TABLE', ' en la tabla ');
define('TEXT_INSERT', 'Insertar');
define('TEXT_KEY_NAME', 'Nombre de la clave');
define('TEXT_LAST', 'Ultima');
define('TEXT_NAME', 'Administrador base de datos - 1 base de datos');
define('TEXT_NULL', 'Nulo');
define('TEXT_NUMBER_FIELD', 'Numero de campos:');
define('TEXT_OK', 'Ok!');
define('TEXT_OPTIMIZE', 'Optimizar');
define('TEXT_PAGE', ' a la pagina ');
define('TEXT_PAGE_PREVIOUS', ' Pagina anterior');
define('TEXT_PAGE_NEXT', ' Pagina siguiente');
define('TEXT_PRIMARY', 'Primaria');
define('TEXT_PRIMARY_KEY', 'Llave primaria');
define('TEXT_PROPERTIES', 'Propiedades');
define('TEXT_QUERY', 'Consulta (query)');
define('TEXT_QUERY_EXECUTE', 'Consulta ejecutada');
define('TEXT_QUERY_FROM_FILE', 'Consultar archivo .sql');
define('TEXT_QUERY_RESULTS', 'Resultados de la consulta:');
define('TEXT_RECORDS_DELETED', 'Registro eliminado');
define('TEXT_RECORDS_FOR_PAGE', ' registros por pagina');
define('TEXT_RENAME', 'Renombrar'); 
define('TEXT_RENAME_AS', ' renombrada como '); 
define('TEXT_RESET', 'Reiniciar');
define('TEXT_SAVE', 'Guardar');
define('TEXT_SELECT', 'Seleccionar');
define('TEXT_SELECT_CSV', 'Seleccionar archivo <b>CSV</b> a importar ');
define('TEXT_SELECT_FAILED', 'Error en la seleccion!');
define('TEXT_SELECT_FROM', 'SELECT * FROM');
define('TEXT_SHOW', 'Mostrar');
define('TEXT_SHOW_TABLE', 'Mostrar tablas');
define('TEXT_SURE_DROP_FIELD', 'Seguro que quiere eliminar el campo ');
define('TEXT_SURE_DROP_INDEX', 'Seguro que quiere eliminar el indice ');
define('TEXT_TABLE', 'Tabla ');
define('TEXT_TABLE_OF', 'Tablas de ');
define('TEXT_TABLE_LIST', 'Lista de tablas: ');
define('TEXT_TABLE_CREATED', 'creado.');
define('TEXT_TABLE_CURRENT', 'Tabla actual:');
define('TEXT_TABLE_INDEXES', 'Indices de la tabla');
define('TEXT_TABLE_NAME', 'Nombre de la tabla:');
define('TEXT_TABLE_OPERATIONS', 'Operaciones de la tabla');
define('TEXT_TABLE_OPTIMIZED', 'optimizada!');
define('TEXT_TABLE_PROPERTIES', 'Propiedades de la tabla');
define('TEXT_TABLE_RECORDS', 'Registros:');
define('TEXT_TABLE_REMOVED', 'eliminada!');
define('TEXT_TABLE_RENAME', 'Renombrar tabla como ');
define('TEXT_TABLE_SELECTED', ' seleccionada');
define('TEXT_TABLE_STRUCTURE', 'Estructura de la tabla');
define('TEXT_TYPE', 'Tipo');
define('TEXT_UNABLE_ALTERED_TABLE', 'No se pudo modificar la tabla ');
define('TEXT_UNABLE_CREATE_INDEX', 'No se pudo crear un indice ');
define('TEXT_UNABLE_DELETED_RECORDS', 'No se puede eliminar el registro');
define('TEXT_UNABLE_DROP_FIELD', 'No se pudo eliminar el campo ');
define('TEXT_UNABLE_DROP_INDEX', 'No se pudo eliminar el indice ');
define('TEXT_UNABLE_RENAME_TABLE', 'No se pudo renombrar la tabla ');
define('TEXT_WHERE', 'donde (where)');
?>