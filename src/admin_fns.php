<?php

/**
 * This file contains functions and code for:
 *  - Downloading database into an excel
 *  - Generating reports
 *
 * "Original PHP code by Chirp Internet: www.chirp.com.au
 * Please acknowledge use of this code by including this header."
 *
 * Modifications to the code made by Alligators group, ICS 499
 */

/**
 * Triggering a download
 * @param $str
 */
function cleanData(&$str)
{
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

// filename for download
$filename = "VillageHighReunionDatabase_" . date('Ymd') . ".xls";

header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");

$flag = false;
$result = pg_query("SELECT * FROM table ORDER BY field") or die('Query failed!');
while(false !== ($row = pg_fetch_assoc($result))) {
    if(!$flag) {
        // display field/column names as first row
        echo implode("\t", array_keys($row)) . "\r\n";
        $flag = true;
    }
    array_walk($row, 'cleanData');
    echo implode("\t", array_values($row)) . "\r\n";
}
exit;


