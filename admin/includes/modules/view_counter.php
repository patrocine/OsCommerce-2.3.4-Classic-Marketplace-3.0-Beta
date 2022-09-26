<?php
 
 $dateNow = date("Y-m-d", time() - (VIEW_COUNTER_FORCE_RESET * 86400)) . ' 23:59:59';

 $view_check_query = tep_db_query("delete from view_counter where last_date < '" . $dateNow ."' "); // . " where ip = '" . tep_db_input($viewSqlArray['ip']) . "'");
 