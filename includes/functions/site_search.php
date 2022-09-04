<?php
/*
  $Id: site_search.php,v 1.00 Originally Created by: Jack York- http://www.oscommerce-solution.com

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com


  Copyright (c) 2003 osCommerce
  Portions Copyright 2005 oscommerce-solution.com

  Released under the GNU General Public License
*/


function CheckAllPages($dir, $searchTerm, &$fileList, &$articlesList, &$pagesList, $languages_id) {
    $languageDir = GetLanguageDirectory($languages_id); //need the name of the directory to search
    $fileList = CheckFileContents($dir, $searchTerm, $fileList, $languageDir);
    $pagesList = CheckInfomationPages($searchTerm, $pagesList, $languages_id);
    $articlesList = CheckArticles($searchTerm, $languages_id);
}

//search the indicated direcory for the search term
function CheckFileContents($dir, $searchTerm, &$fileList, $languageDir) {
    $matches = glob($dir . '/*');

    if (is_array($matches)) {
        foreach ($matches as $filePath) {
            if (is_dir($filePath)) {
               if ($languageDir === end(explode("/", $filePath))) {
                  CheckFileContents($filePath, $searchTerm, $fileList, $languageDir);
               }
            } else {
               $fileName = end(explode("/", $filePath));
               if (end(explode(".", $fileName)) == 'php') { //NOTE: fails if there's an extenstion such file.php.old
                  $contents = file_get_contents($filePath);

                  if (strpos(strtolower($contents), strtolower($searchTerm))) {
                      if (file_exists(DIR_FS_CATALOG . '/' . $fileName)) {
                          $fileList[] = array('file' => $fileName, 'ext' => '');
                      }
                  }
              }
           }
       }
    }

    return $fileList;
}

function CheckArticles($searchTerm, $languages_id) {
    $articlesList = array();

    $config_query = tep_db_query("select count(*) as total from " . TABLE_CONFIGURATION_GROUP . " where configuration_group_title LIKE '" . 'Articles Manager' . "'");
    $config = tep_db_fetch_array($config_query);

    if ($config['total'] > 0) {
        $term = tep_db_input($searchTerm);
        $articles_query = tep_db_query("select articles_id, articles_name, articles_description from " . TABLE_ARTICLES_DESCRIPTION . " where ( articles_name like '%" . $term . "%' or articles_description like '%" . $term . "%' or articles_head_desc_tag like '%" . $term . "%' ) and language_id = " . (int)$languages_id);
        if (tep_db_num_rows($articles_query) > 0) {
            while ($articles = tep_db_fetch_array($articles_query)) {
                $articlesList[] = array('id' => $articles['articles_id'], 'name' => $articles['articles_name']);
            }
        }
    }
    return $articlesList;
}

function CheckInfomationPages($searchTerm, $pagesList, $languages_id) {
    if (defined('TABLE_PAGES')) {
        $term = tep_db_input($searchTerm);
        $pages_query = tep_db_query("select pd.pages_id, p.pages_name from " . TABLE_PAGES . " p left join " . TABLE_PAGES_DESCRIPTION . " pd on p.pages_id = pd.pages_id where ( pages_title like '%" . $term . "%' or pages_body like '%" . $term . "%' ) and language_id = " . (int)$languages_id);
        if (tep_db_num_rows($pages_query) > 0) {
            while ($pages = tep_db_fetch_array($pages_query)) {
                $pagesList[] = array('file' => FILENAME_PAGES, 'ext' => 'page='.$pages['pages_name']);
            }
        }
    }
    return $pagesList;
}

function SortFileLists($a, $b) {
    return strnatcasecmp($a["file"], $b["file"]);
}

function GetLanguageDirectory($language_id) { //cut down version just for site search to use
    $languages_query = tep_db_query("select directory from " . TABLE_LANGUAGES . " where languages_id = " . (int)$language_id);
    $languages = tep_db_fetch_array($languages_query);
    return $languages['directory'];
}
?>