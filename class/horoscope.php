<?php

class Horoscope {

    public static function createHoroscopeBase($fileName) {
        mysql_query('SET NAMES utf8');
        $file_size = filesize($fileName);
        $time_start = microtime(true);
        $data = file($fileName);

        preg_match('/(\w+).\w+$/', $fileName, $matches);
        $tableName = $matches[1];

        if (!self::checkTableExsist($tableName)) {
            $q = "
                CREATE TABLE `$tableName` (
                  `id` int(11) NOT NULL auto_increment,
                  `word` varchar(100) NOT NULL,
                  `freq` int(11) NOT NULL default '1',
                  PRIMARY KEY  (`word`),
                  UNIQUE KEY `id` (`id`)
                ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
            ";
            mysql_query($q);
        }

        foreach ($data as $v) {
            preg_match_all('/[а-яА-ЯёЁ]+/u', $v, $words);
            $words = reset($words);

            if (!empty($words)) {

                $str = '';
                foreach ($words as $word) {
                    $str .= "('', '" . mb_strtolower($word, 'utf-8') . "' , '1'), ";
                }
                $str = substr($str, 0, strlen($str) - 2);


                $query = "
                INSERT INTO `$tableName` 
                VALUES " . $str . "
                ON DUPLICATE KEY UPDATE `freq` = `freq`  + 1";
                $sql = mysql_query($query);
                echo mysql_error();
            }
        }

        $time_end = microtime(true);
        echo $time_end - $time_start;
    }

    public static function getHoroscope($baseTable, $wordCount=50, $dotFactorMin=15, $dotFactorMax=10) {
        mysql_query('SET NAMES utf8');
        $str = array();

        $dot_index = array();
        $dot_count = mt_rand(round($wordCount / $dotFactorMin), round($wordCount / $dotFactorMax));
        for ($j = 1; $j < $dot_count; $j++) {
            $dot_index[] = mt_rand(2, $wordCount);
        }

        $time_start = microtime(true);

        $q = "
        SELECT word
        FROM `$baseTable`
        ORDER BY SQRT(freq)*RAND() DESC LIMIT 1";

        $q = "
        SELECT word
        FROM `$baseTable`
        ORDER BY RAND() DESC LIMIT 1";
        $last_word = '';
        for ($i = 0; $i < $wordCount; $i++) {
            $word = mysql_result(mysql_query($q), 0);
            echo mysql_error();
            //$word = iconv("CP1251", "UTF-8", $word);
            if ($word != $last_word)
                $str[] = $word;
            $last_word = $word;
        }


        $time_end = microtime(true);

        $result = '';
        $i = 0;

        foreach ($str as $v) {
            $i++;
            if (array_search($i, $dot_index, true) > 0)
                $result .= '. ' . mb_convert_case($v, MB_CASE_TITLE, "UTF-8");
            elseif ($i == 1)
                $result .= ' ' . mb_convert_case($v, MB_CASE_TITLE, "UTF-8");
            else
                $result .= ' ' . $v;
        }

        $result .= '.';

        echo $result;

        echo '<br><br>';
        echo 'Время вычисления гороскопа: ' . ($time_end - $time_start) . 'с.';
    }

    private static function checkTableExsist($tableName) {
        $r = mysql_query('SHOW TABLES');
        if (mysql_num_rows($r) > 0) {
            while ($table = mysql_fetch_array($r, MYSQL_NUM)) {
                $tables[] = reset($table);
            }
            return (array_search($tableName, $tables) !== false) ? true : false;
        }
    }

    public static function getTablesList() {
        $r = mysql_query('SHOW TABLES');
        if (mysql_num_rows($r) > 0) {
            while ($table = mysql_fetch_array($r, MYSQL_NUM)) {
                $tables[]['name'] = reset($table);
            }
        }
        return self::getLabelTable($tables);
    }

    private static function getLabelTable($tables) {
        if (!empty($tables)) {
            foreach ($tables as $k => &$v) {
                switch ($v['name']) {
                    case 'marks_karl_kapital': $v['label'] = 'К. Маркс. Капитал';
                        break;
                    case 'tihiydon': $v['label'] = 'М.А. Шолохов. Тихий дон';
                        break;
                    case 'lt1': $v['label'] = 'Л.Н. Толстой. Война и мир';
                        break;
                    default: unset($tables[$k]);
                }
            }
        }
        return $tables;
    }

    public static function exportTable($table) {

        $filename = './temp/' . $table . "_json.txt";

        if (is_writeable($filename)) {
            $fh = fopen($filename, "w");
        }

        mysql_query('SET NAMES utf8');

        $q = "
        SELECT id,word, freq
        FROM `$table`";

        $r = mysql_query($q);

        if (mysql_num_rows($r) > 0) {
            while ($row = mysql_fetch_array($r, MYSQL_ASSOC)) {
                $result['word'] = $row['word'];
                $result['freq'] = $row['freq'];
                $result_json = json_encode($result);
                $success = fputs($fh, $result_json . "\r\n");
            }
        }
        fclose($fh);
    }

    public static function importTableInMongo($db, $table) {
        $col = $db->lt1;
        
        $filename = './temp/' . $table . "_json.txt";

        $fp = fopen($filename, "r"); // Открываем файл в режиме чтения
        if ($fp) {
            while (!feof($fp)) {
                $row = fgets($fp, 999);
                //$a = json_decode($row, true);
                $col->insert(array(
                        htmlspecialchars('авпваппа')
                    ), 
                true);              
            }
        }
        else
            echo "Ошибка при открытии файла";
        fclose($fp);
    }

}
