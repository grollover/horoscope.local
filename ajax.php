<?php

require_once('class'. DIRECTORY_SEPARATOR .'db.php');
require_once('class'. DIRECTORY_SEPARATOR .'horoscope.php');

try {
    DB::connect();
}
catch (Exception $e) {
    exit($e->getMessage());
}

if(!empty($_POST['action']) && $_POST['action'] == "getHoroscope" && !empty($_POST['tableName']))
    exit(json_encode(Horoscope::getHoroscope($_POST['tableName'], 50, 10)));


if(!empty($_POST['action']) && $_POST['action']=="getTables"){
    $tables = Horoscope::getTablesList();
    exit(json_encode($tables));
}