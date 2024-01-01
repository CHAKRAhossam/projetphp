<?php

class Connection{

    private $servername="localhost";
    private $username = "root";
    private $password = "";
    public $conn ;

    public function __construct() {

        //create connection
        $this->conn = mysqli_connect($this->servername, $this->username, $this->password);
        
        //check connection
        if(!$this->conn){
            die("connection failed: " . mysqli_connect_error());
        }

    }

    public function createDatabase($dbName) {

         // Create database
        $sql = "CREATE DATABASE $dbName";
        if (mysqli_query($this->conn, $sql)) {
        echo "Database created successfully";
        } else {
        echo "Error creating database: " . mysqli_error($this->conn);
        }

    }

    public function selectDatabase($dbName) {

        mysqli_select_db($this->conn, $dbName);
    }

    public function createTable($query){

        if(mysqli_query($this->conn, $query)){
            echo "Table Created Successfully";
        }else{
            echo "Error Creating Table" . mysqli_error($this->conn);
        }
    }
}
?>