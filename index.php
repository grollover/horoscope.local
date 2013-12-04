<?php
require_once('class' . DIRECTORY_SEPARATOR . 'db.php');
require_once('class' . DIRECTORY_SEPARATOR . 'horoscope.php');

try {
    $db = DB::connect();
    //Horoscope::createHoroscopeBase('./books/lt1.txt');
    //Horoscope::exportTable('lt1');
    //Horoscope::importTableInMongo($db, 'lt1');
    DB::disconnect();
} catch (Exception $e) {
    exit($e->getMessage());
}
?>
<!DOCTYPE html>
<html ng-app="horoscope">
<head>
    <title>Индивидуальный гороскоп</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="description" content="Индивидуальный гороскоп на каждый день.">
    <meta name="keywords" content="гороскоп, прогноз">
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <script src="/js/angular.min.js"></script>
    <script src="/js/app.js"></script>
</head>
<body>
<div id="content" ng-controller="horoCnt">
    <div class="border">
        <h2>Индивидуальный гороскоп</h2>

        <div id="zodiac">
            <div class="select">

                <div class="signs">
                    <h3>Знак зодиака:</h3>
                    <select ng-model="sign" ng-change="showTables()">
                        <option ng-repeat="sign in signs">{{sign}}</option>
                    </select>
                    <p ng-show="sign">Вы выбрали: {{sign}}</p>
                </div>

                <div class="tables" ng-show="sign">
                    <h3>Стиль гороскопа:</h3>
                    <select ng-model="table" ng-options="v.label for (k, v) in tables"></select>
                    <p ng-show="table">Вы выбрали: {{table.label}}</p>
                </div>

                <div ng-show="table.name">
                    <input type="button" value="Получить!" ng-click="getHoroscope()" />
                </div>
            </div>
            <div class="ajax_indicator_container">
                <div id="ajax_indicator" style="display: none;"><img src="js/ajax_indicator.gif"></div>
            </div>
        </div>
        <div id="horoscope" ng-show="horoscope">
            <h3>Ваш гороскоп на сегодня:</h3>
            <div id="horoscopeText">{{horoscope}}</div>
            Сегодня: <?php echo date("d.m.Y"); ?>
        </div>
    </div>
</div>
</body>
</html>