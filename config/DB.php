<?php
class DB{
    private $host;
    private $username;
    private $password;
    private $db_name;
    private $connection;
    public function __construct()
    {   
        $this->host=DB_HOST;
        $this->username=DB_USER;
        $this->password=DB_PASS;
        $this->db_name=DB_NAME;
        $this->connect();
    }
    private function connect(){
        try {
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db_name . ';charset=utf8mb4';
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $this->connection = new PDO($dsn,$this->username, $this->password, $options);
        } catch (PDOException $e) {
            die("Database error -> " . $e->getMessage());
        }
    }
    public function getConnection(){
        return $this->connection;
    }
}
