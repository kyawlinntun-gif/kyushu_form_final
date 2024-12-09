<?php 
require('./../config/DB.php');

class ApplicantForm{
    private $connection;
    private $table="users_table";
    public function __construct()
    {   
        $connInstance=new DB();
        $this->connection= $connInstance->getConnection();
    }
    public function insert(string $data){
        try {
            $query = "INSERT INTO $this->table ( user_id,user_data,flag) VALUES ( :user_id, :user_data, :flag)";
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(":user_id", 1, PDO::PARAM_INT);
            $stmt->bindValue(":user_data", $data, PDO::PARAM_STR);
            $stmt->bindValue(":flag", 1, PDO::PARAM_INT);
            $result = $stmt->execute();
            return $result;
        } catch (PDOException $e) {
            echo "Query error: ", $e->getMessage();
        }
    }
}

?>