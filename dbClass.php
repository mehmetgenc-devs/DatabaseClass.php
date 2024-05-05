<?php
/*
// Hataları açarsanız herşeyi daha da net görürsünüz ama sizinle birlikte herkes görür :)
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
*/

if ( !class_exists( 'DB' ) ) {
    class DB {
        public function __construct( // database bilgileri
        $user='database_user', // burayı değiştir
        $password='database_password', // burayı değiştir
        $database='database_name', // burayı değiştir
        $host = 'localhost:3306' // burayı değiştir
        ) {$this->user = $user; $this->password = $password; $this->database = $database; $this->host = $host; date_default_timezone_set('Europe/Istanbul'); // buraya dokunma!
        }
        protected function connect() { // database bağlantı.
            return new mysqli($this->host, $this->user, $this->password, $this->database); // buraya dokunma!
        }
        public function query($query) { // veri çekme
            $db = $this->connect();
            $db->set_charset("utf8mb4");
            $result = $db->query($query);
            while ( $row = $result->fetch_array(MYSQLI_ASSOC) ) {
                $results[] = $row;
            }
            return $results;
        }
        public function insert($query) { // veri oluşturma
            $db = $this->connect();
            $db->set_charset("utf8mb4");
            $result = $db->query($query);
            return $result;
        }
    }
$db = new DB(); //Db yi oluşturma
}
