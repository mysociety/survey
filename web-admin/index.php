<?php
/*
 * index.php:
 * Admin page for demographic survey.
 * 
 * Copyright (c) 2008 UK Citizens Online Democracy. All rights reserved.
 * Email: francis@mysociety.org; WWW: http://www.mysociety.org
 *
 * $Id: index.php,v 1.3 2008-06-25 11:44:44 francis Exp $
 * 
 */

require_once "../conf/general";
require_once "../commonlib/phplib/error.php";
require_once "../commonlib/phplib/db.php";
require_once "../commonlib/phplib/utility.php";
require_once "../commonlib/phplib/auth.php";

function survey_handle_error($num, $message, $file, $line, $context) {
    print("<strong>$message</strong> in $file:$line");
    return;
}
err_set_handler_display('survey_handle_error');

db_connect();

function get_column_names() {
    $columns = array();
    $q = db_query('select key from data_item group by key');
    while ($r = db_fetch_row($q)) {
        $columns[] = $r[0];
    }
    sort($columns);
    return $columns;
}

function overview() {
    $number_surveys_done = db_getOne('select count(*) from survey_done');
    $number_surveys_done = db_getOne('select count(*) from survey_done');
    $last_date = db_getOne('select max(whenstored) from data_item');

    ?>

    <h1>Survey admin interface</h1>

    <p>
        <strong>Number of surveys done:</strong> <?= $number_surveys_done ?>
        <br><strong>Date of last survey:</strong> <?= $last_date ?>
    </p>

    <p>
        <a href="survey.csv">Download All Results</a>
    </p>

    <form action="survey.csv" method="get">
        <label for="site">Download results for site:</label><br>
        <input type="text" name="site" id="site">
        <input type="submit" value="Download">
    </form>

    <?
}

overview();


