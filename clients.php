<?php

class Clients {

    public $client_id;
    public $client_firstname;
    public $client_lastname;
    public $client_email;
    public $ville_id;
    public $reg_date; 

    public static $errorMsg = "";
    public static $successMsg = "";

    public function __construct($firstname, $lastname, $email, $ville_id) {
        // Initialize the attributes of the class with the parameters
        $this->client_firstname = $firstname;
        $this->client_lastname = $lastname;
        $this->client_email = $email;
        $this->ville_id = $ville_id;
    }

    public function insertClient($tableName, $conn) {
        // // Check if the email already exists
        // $checkDuplicate = mysqli_query($conn, "SELECT client_email FROM $tableName WHERE client_email='$this->client_email'");
        // if (mysqli_num_rows($checkDuplicate) > 0) {
        //     // Email already exists, handle the error
        //     self::$errorMsg = "Email address already exists!";
        //     return;
        // }

        // Email doesn't exist, insert a client in the database
        $sql = "INSERT INTO $tableName (client_firstname, client_lastname, client_email, ville_id)
                VALUES ('$this->client_firstname', '$this->client_lastname', '$this->client_email', '$this->ville_id')";

        if (mysqli_query($conn, $sql)) {
            self::$successMsg = "New record created successfully";
        } else {
            self::$errorMsg = "Error: " . $sql . mysqli_error($conn);
        }
        header("Location: clientread.php");
    }

    public static function selectAllClients($tableName, $conn) {
        // Select all the clients from the database
        $sql = "SELECT c.client_id, c.client_firstname, c.client_lastname, c.client_email, c.ville_id, v.ville_name 
        FROM $tableName c
        INNER JOIN villes v ON c.ville_id = v.ville_id";
        $result = mysqli_query($conn, $sql);
        $data = [];

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }

        return $data;
    }

    public static function selectClientById($tableName, $conn, $id) {
        // Select a client by id
        $sql = "SELECT client_firstname, client_lastname, client_email ,ville_id FROM $tableName WHERE client_id='$id'";
        $result = mysqli_query($conn, $sql);
        $row = [];

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
        }

        return $row;
    }

    public static function updateClient($client, $tableName, $conn, $id) {
        // Update a client by id
        $sql = "UPDATE $tableName SET client_firstname='$client->client_firstname', 
               client_lastname='$client->client_lastname', client_email='$client->client_email' ,ville_id='$client->ville_id'
               WHERE client_id='$id'";

        if (mysqli_query($conn, $sql)) {
            self::$successMsg = "Record updated successfully";
        } else {
            self::$errorMsg = "Error updating record: " . mysqli_error($conn);
        }
        header("Location: clientread.php");
    }

    public static function deleteClient($tableName, $conn, $id) {
        // Delete associated records in articledevis table
        $sqlDeleteArticleDevis = "DELETE FROM articledevis WHERE devi_id IN (SELECT devi_id FROM devi WHERE client_id='$id')";
        mysqli_query($conn, $sqlDeleteArticleDevis);
    
        // Delete associated records in devi table
        $sqlDeleteDevi = "DELETE FROM devi WHERE client_id='$id'";
        mysqli_query($conn, $sqlDeleteDevi);
    
        // Delete the client from the clients table
        $sqlDeleteClient = "DELETE FROM $tableName WHERE client_id='$id'";
    
        if (mysqli_query($conn, $sqlDeleteClient)) {
            self::$successMsg = "Record deleted successfully";
        } else {
            self::$errorMsg = "Error deleting record: " . mysqli_error($conn);
        }
    }
    
    
}

?>
