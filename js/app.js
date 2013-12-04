var app = angular.module('horoscope', []);

app.controller('horoCnt', ['$scope', '$http', function ($scope, $http) {

    $http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";

    $scope.signs = ['Овен', 'Телец', 'Близнецы', 'Рак', 'Дева', 'Весы', 'Скорпион', 'Стрелец', 'Козерог', 'Водолей', 'Рыбы'];


   // $scope.tables = [ { "name": "lt1", "label": "Л.Н. Толстой. Война и мир" }, { "name": "marks_karl_kapital", "label": "К. Маркс. Капитал" }, { "name": "tihiydon", "label": "М.А. Шолохов. Тихий дон" } ];


    $scope.showTables = function () {
        $http.post('/ajax.php', "action=getTables")
            .success(function (data) {
                $scope.tables = data;
                $scope.showTables = 1;
            });
    }

    $scope.getHoroscope = function () {
        $scope.loading = 1;
        $http.post('/ajax.php', "action=getHoroscope&tableName=" + $scope.table.name)
            .success(function (data) {
                $scope.horoscope = data;
                $scope.loading = 0;
            })
            .error(function(data, status){
                $scope.horoscope = status;
                $scope.loading = 0;
            });
    }


}]);





