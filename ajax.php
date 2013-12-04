<?php

require_once('class'. DIRECTORY_SEPARATOR .'db.php');
require_once('class'. DIRECTORY_SEPARATOR .'horoscope.php');

try {
    DB::connect();
}
catch (Exception $e) {
    exit($e->getMessage());
}

if(!empty($_POST['action']) && $_POST['action'] == "getHoroscope" && !empty($_POST['tableName'])){
    $horoscope = Horoscope::getHoroscope($_POST['tableName'], 50, 10);
    exit(json_encode(array('text' => $horoscope['text'], 'time' => $horoscope['time'])));
}


if(!empty($_POST['action']) && $_POST['action']=="getTables"){
    $tables = Horoscope::getTablesList();
    exit(json_encode($tables));
}