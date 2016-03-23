<?php

/**
 * This file contains functions and code for:
 *  - Downloading database into an excel
 *  - Generating reports
 */

include (db_fns.php);

//Store database array into an excel file
function arrayToExcel() {

    $array = db_result_to_array(db_connect());

    header("Content-Disposition: attachment; filename=\"VillageHighSchoolReunionData.xls\"");
    header("Content-Type: application/vnd.ms-excel;");
    header("Pragma: no-cache");
    header("Expires: 0");
    $out = fopen("php://output", 'w');
    foreach ($array as $data)
    {
        fputcsv($out, $data,"\t");
    }
    fclose($out);
}




//BELOW IS CODE TO EXPORT DATABASE DIRECTLY TO EXCEL FILE

//function cleanData(&$str)
//{
//    $str = preg_replace("/\t/", "\\t", $str);
//    $str = preg_replace("/\r?\n/", "\\n", $str);
//    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
//}
//
//// filename for download
//$filename = "VillageHighReunionDatabase_" . date('Ymd') . ".xls";
//
//header("Content-Disposition: attachment; filename=\"$filename\"");
//header("Content-Type: application/vnd.ms-excel");
//
//$flag = false;
//$result = pg_query("SELECT * FROM student") or die('Query failed!');
//while(false !== ($row = pg_fetch_assoc($result))) {
//    if(!$flag) {
//        // display field/column names as first row
//        echo implode("\t", array_keys($row)) . "\r\n";
//        $flag = true;
//    }
//    array_walk($row, 'cleanData');
//    echo implode("\t", array_values($row)) . "\r\n";
//}
//
//exit;


