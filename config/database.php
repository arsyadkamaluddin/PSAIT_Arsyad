<?php
// used to get mysql database connection
class DatabaseService{

    private $db_host = "10.33.102.102";
    private $db_name = "sait_arsyad";
    private $db_user = "sait_arsyad";
    private $db_password = "sait_arsyad";
    private $connection;

    public function getConnection(){

        $this->connection = null;

        try{
            $this->connection = new PDO("mysql:host=" . $this->db_host . ";dbname=" . $this->db_name, $this->db_user, $this->db_password);
        }catch(PDOException $exception){
            echo "Connection failed: " . $exception->getMessage();
        }

        return $this->connection;
    }
}
?>