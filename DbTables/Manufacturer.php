<?php

class Manufacturer {
    private $conn;
    private $table = 'manufacturers';
    
    // Serial Number, Manufacturer Name, Model Name, Count, Sold Button
    public $manufacturer_id;
    public $manufacturer_name;
    // public $model_id;
    // public $model_name;
    // public $count;

    public function __construct($db) {
        $this->conn = $db;
    }
    
    function manufacturerExists($manufac_name){
        // $this->conn = connectvar();
        // mysql_select_db("mydatabase", $con);
        $querycheck = $this->conn->query('SELECT * FROM ' . $this->table);
        while($row = $querycheck->fetch(PDO::FETCH_ASSOC)) {
            if($row['manufacturer_name'] === $manufac_name) {
                echo json_encode(
                    array("message" => "Manufacturer exists")
                );
                return false;
            }
        }
        
    }

    public function insert() { //INSERT INTO `manufacturers`(`manufacturer_id`, `manufacturer_name`) VALUES ([value-1],[value-2])
        try{
            $query = 'INSERT INTO
                ' . $this->table . '
                    (manufacturer_name)
                VALUES
                    (:manufacturer_name)';

            $stmt = $this->conn->prepare($query);

            $this->manufacturer_name = htmlspecialchars(strip_tags($this->manufacturer_name));
            $this->manufacturerExists($this->manufacturer_name);
            $stmt->bindParam(':manufacturer_name', $this->manufacturer_name);

            if($stmt->execute()) {
                return true;
            }

            print_f("Error: %s.\n", $stmt->error);

            return false;
        } catch(PDOException $error) {
            echo $error;
        }
    }
    
    public function read() {
        $query = 'SELECT * FROM ' . $this->table;

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;

    }
    
    
}
// CREATE TABLE manufacturers(
//     manufacturer_id INT NOT NULL AUTO_INCREMENT,
//     manufacturer_name VARCHAR(100) NOT NULL,
//     PRIMARY KEY ( manufacturer_id )
//  );