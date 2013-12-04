<?php

class DB {

    private static $linkId;

    /*
      const HOST = 'mysql52.hoster.ru';
      const USER = 'm52566';
      const PASSWORD = 's5BHwxaP';
      const DB = 'db52566m';
     */
    const HOST = 'localhost';
    const USER = 'root';
    const PASSWORD = '';
    const DB = 'horoscope.local';
    
    public static $_mongoConn = null;

    public static function connect($host = self::HOST, $user=self::USER, $password=self::PASSWORD, $db=self::DB) {
        self::$linkId = @mysql_connect($host, $user, $password);
        if (self::$linkId === false) {
            throw new Exception(mysql_error());
        }
        if (!mysql_select_db($db, self::$linkId)) {
            throw new Exception('Нет базы');
        }
        return true;
    }

    public static function connect_($host = self::HOST, $db='test') {
        try {
            // open connection to MongoDB server
            self::$_mongoConn = new Mongo('localhost');
            
            // access database
            $db = self::$_mongoConn->test;

            return $db;
        } catch (MongoConnectionException $e) {
            die('Error connecting to MongoDB server');
        } catch (MongoException $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    
    public static function disconnect(){
        if(!empty(self::$_mongoConn))
           self::$_mongoConn->close();
    }

}
