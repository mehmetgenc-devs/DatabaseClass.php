<?php
/*
// Hataları açarsanız herşeyi daha da net görürsünüz ama sizinle birlikte herkes görür :)
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
*/

if ( !class_exists( 'DB' ) ) {
    class DB {
        protected $user;
        protected $password;
        protected $database;
        protected $host;
        protected $connection;

        public function __construct( // database bilgileri
            $user='database_user', // burayı değiştir
            $password='database_password', // burayı değiştir
            $database='database_name', // burayı değiştir
            $host = 'localhost:3306' // burayı değiştir
        ) {
            $this->user = $user;
            $this->password = $password;
            $this->database = $database;
            $this->host = $host;
            $this->connection = null;
            date_default_timezone_set('Europe/Istanbul'); // buraya dokunma!
        }

        protected function connect() { // database bağlantı.
            if ($this->connection instanceof mysqli && @$this->connection->ping()) {
                return $this->connection;
            }

            $this->connection = new mysqli($this->host, $this->user, $this->password, $this->database); // buraya dokunma!
            $this->connection->set_charset('utf8mb4');

            return $this->connection;
        }

        public function __destruct() {
            if ($this->connection instanceof mysqli) {
                $this->connection->close();
            }
        }

        public function escape($value) {
            $db = $this->connect();
            return $db->real_escape_string((string) $value);
        }

        protected function escapeIdentifier($identifier) {
            return '`' . str_replace('`', '``', (string) $identifier) . '`';
        }

        public function query($query) { // veri çekme
            try {
                $db = $this->connect();
                $result = $db->query($query);

                if (!($result instanceof mysqli_result)) {
                    return [];
                }

                $results = [];
                while ( $row = $result->fetch_array(MYSQLI_ASSOC) ) {
                    $results[] = $row;
                }

                $result->free();
                return $results;
            } catch (\Exception $e) {
                echo $e->getMessage();
                return [];
            }
        }

        public function insert($table, $array)
        {
            try {
                $q = "INSERT INTO " . $this->escapeIdentifier($table) . " ";
                $q .= "(";
                foreach (array_keys($array) as $field) {
                    $q .= $this->escapeIdentifier($field) . ", ";
                }
                $q = rtrim($q, ', ') . ") VALUES (";

                foreach ($array as $value) {
                    $q .= "'" . $this->escape($value) . "', ";
                }

                $q = rtrim($q, ', ') . ")";
                return $this->q($q);
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }

        public function update($table, $data, $where) {
            try {
                $q = "UPDATE " . $this->escapeIdentifier($table) . " SET ";
                foreach ($data as $key => $value) {
                    $q .= $this->escapeIdentifier($key) . " = '" . $this->escape($value) . "', ";
                }
                $q = rtrim($q, ', ');
                $q .= " WHERE " . $where;
                return $this->q($q);
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }

        public function delete($table, $where) {
            try {
                $q = "DELETE FROM " . $this->escapeIdentifier($table) . " WHERE " . $where;
                return $this->q($q);
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }

        public function q($query) { // veri düzenleme - ekleme
            try {
                $db = $this->connect();
                $result = $db->query($query);
                return $result;
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }
    }
$db = new DB(); //Db yi oluşturma
}
