<?php

class Devi {

    public $devi_id;
    public $client_id;
    public $total;
    public $reg_date;

    public static $errorMsg = "";
    public static $successMsg = "";

    public function __construct($client_id, $total) {
        // Initialize the attributes of the class with the parameters
        $this->client_id = $client_id;
        $this->total = $total;
    }

    public function insertDevi($table, $conn)
    {
        $query = "INSERT INTO $table (client_id, total) VALUES ('$this->client_id', '$this->total')";
        $result = mysqli_query($conn, $query); // <-- Corrected

        if ($result) {
            // Success
            self::$successMsg = "Devi inserted successfully";
        } else {
            // Failure
            self::$errorMsg = "Error: " . $query . "<br>" . mysqli_error($conn);
        }
    }


    public static function selectAllDevis($table, $conn) {
        $sql = "SELECT devi.*, clients.client_firstname, clients.client_lastname
                FROM $table
                JOIN clients ON devi.client_id = clients.client_id";
        $result = mysqli_query($conn, $sql);
        $data = [];
    
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
    
        return $data;
    }
    
    

    public static function selectDeviById($conn, $id) {
        // Select a devi by id
        $sql = "SELECT devi.*, clients.client_firstname, clients.client_lastname, clients.client_email
        FROM devi
        JOIN clients ON devi.client_id = clients.client_id
        WHERE devi.devi_id='$id'";
        $result = mysqli_query($conn, $sql);
        $row = [];

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
        }

        return $row;
    }

    public static function updateDevi($devi, $conn, $id) {
        // Update a devi by id
        $sql = "UPDATE Devi SET client_id='$devi->client_id', 
               total='$devi->total'
               WHERE devi_id='$id'";

        if (mysqli_query($conn, $sql)) {
            self::$successMsg = "Devi record updated successfully";
            header("Location: deviread.php");
        } else {
            self::$errorMsg = "Error updating Devi record: " . mysqli_error($conn);
        }
    }

    public static function deleteDevi($conn, $id) {
        // Delete a devi by id
        $sql = "DELETE FROM Devi WHERE devi_id='$id'";

        if (mysqli_query($conn, $sql)) {
            self::$successMsg = "Devi record deleted successfully";
            header("Location: deviread.php");
        } else {
            self::$errorMsg = "Error deleting Devi record: " . mysqli_error($conn);
        }
    }
}

?>
