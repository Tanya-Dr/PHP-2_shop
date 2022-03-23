<?php
include_once('m/constants.php');

function get_db(){
    $connect_str = DB_DRIVER . ':dbname='.DB_NAME . ';host=' . DB_HOST;
    return $db = new PDO($connect_str,DB_USER,DB_PASS);
}
