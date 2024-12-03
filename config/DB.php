<?php
require('./../config/const.php');

class DB{
    private $host;
    private $username;
    private $password;
    private $db_name;
    private $connection;

    public function __construct()
    {   $this->host=DB_HOST;
        $this->username=DB_USER;
        $this->password=DB_PASS;
        $this->db_name=DB_NAME;
        $this->connect();
    }

    private function connect() {
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

    public function insert(string $table,array $data){
        try {
            $columns= implode(", ", array_keys($data));
            $valueVariables=":". implode(", :", array_keys($data));
            $query = "INSERT INTO $table ( $columns) VALUES ( $valueVariables)";
            $stmt = $this->connection->prepare($query);
    
            //dynamic bind
            foreach($data as $column=>$value){
                $pdo_rule= is_int($value)?PDO::PARAM_INT:PDO::PARAM_STR;
                $stmt->bindValue(":$column", $value, $pdo_rule);
            }
            
            $result = $stmt->execute();
            return $result;
        } catch (PDOException $e) {
            echo "Query error: ", $e->getMessage();
        }

    }

    public function getConnection(){
        return $this->connection;
    }

    
}
