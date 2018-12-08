<?php

class Model {
    private $conn;
    private $table = 'models';
    
    // Serial Number, Manufacturer Name, Model Name, Count, Sold Button
    public $manufacturer_id;
    public $manufacturer_name;
    public $model_id;
    public $model_name;
    public $count;

    public function __construct($db) {
        $this->conn = $db;
    }

    function modelExists($model_name){
        // $this->conn = connectvar();
        // mysql_select_db("mydatabase", $con);
        $querycheck = $this->conn->query('SELECT * FROM ' . $this->table);
        while($row = $querycheck->fetch(PDO::FETCH_ASSOC)) {
            if($row['model_name'] === $model_name) {
                echo json_encode(
                    array("message" => "Model exists")
                );
                return false;
            }
        }
        
    }

    public function insert() { //INSERT INTO `manufacturers`(`manufacturer_id`, `manufacturer_name`) VALUES ([value-1],[value-2])
        try{
            $query = 'INSERT INTO
                ' . $this->table . '
                    (model_name, count, manufacturer_id)
                VALUES
                    (:model_name, :count, :manufacturer_id)';

            $stmt = $this->conn->prepare($query);

            $this->model_name = htmlspecialchars(strip_tags($this->model_name));
            $this->count = htmlspecialchars(strip_tags($this->count));
            $this->manufacturer_id = htmlspecialchars(strip_tags($this->manufacturer_id));
            
            $this->modelExists($this->model_name);
            $stmt->bindParam(':model_name', $this->model_name);
            $stmt->bindParam(':count', $this->count);
            $stmt->bindParam(':manufacturer_id', $this->manufacturer_id);

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
        $query = 'SELECT *
                -- man.id as manufacturer_id,
                -- man.name as manufacturer_name,
                -- mod.id,
                -- mod.name,
                -- mod.count
            FROM
               ' . $this->table . '
            NATURAL JOIN
                manufacturers';

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;

    }

    public function update() { //INSERT INTO `manufacturers`(`manufacturer_id`, `manufacturer_name`) VALUES ([value-1],[value-2])
        try{
            $query = 'UPDATE
                ' . $this->table . '
                SET
                    count = count - 1
                WHERE 
                    model_id = :id';

            $stmt = $this->conn->prepare($query);

            // $this->model_name = htmlspecialchars(strip_tags($this->model_name));
            // $this->count = htmlspecialchars(strip_tags($this->count));
            // $this->manufacturer_id = htmlspecialchars(strip_tags($this->manufacturer_id));
            $this->model_id = htmlspecialchars(strip_tags($this->model_id));
            
            // $this->modelExists($this->model_name);
            // $stmt->bindParam(':model_name', $this->model_name);
            // $stmt->bindParam(':count', $this->count);
            // $stmt->bindParam(':manufacturer_id', $this->manufacturer_id);
            $stmt->bindParam(':id', $this->model_id);

            if($stmt->execute()) {
                return true;
            }

            print_f("Error: %s.\n", $stmt->error);

            return false;
        } catch(PDOException $error) {
            echo $error;
        }
    }
}