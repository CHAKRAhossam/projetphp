<?php

class ArticleDevi {

    public $article_devis_id;
    public $devi_id;
    public $article_id;
    public $quantity;
    public $price;
    public $reg_date;

    public static $errorMsg = "";
    public static $successMsg = "";

    public function __construct($devi_id, $article_id, $quantity, $price) {
        // Initialize the attributes of the class with the parameters
        $this->devi_id = $devi_id;
        $this->article_id = $article_id;
        $this->quantity = $quantity;
        $this->price = $price;
    }

    public function insertArticleDevi($tableName, $conn) {
        // Insert a new ArticleDevi record into the database
        $sql = "INSERT INTO $tableName (devi_id, article_id, quantity, price)
                VALUES ('$this->devi_id', '$this->article_id', '$this->quantity', '$this->price')";

        if (mysqli_query($conn, $sql)) {
            self::$successMsg = "New ArticleDevi record created successfully";
        } else {
            self::$errorMsg = "Error: " . $sql . mysqli_error($conn);
        }
    }

    public static function selectArticleDevisByDeviId($tableName, $conn, $devi_id) {
        // Select all the ArticleDevis for a specific Devi from the database
        $sql = "SELECT * FROM $tableName WHERE devi_id='$devi_id'";
        $result = mysqli_query($conn, $sql);
        $data = [];

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }

        return $data;
    }

    public static function deleteArticleDevisByDeviId($conn, $devi_id) {
        // Delete ArticleDevis records for a specific Devi from the database
        $sql = "DELETE FROM articledevis WHERE devi_id='$devi_id'";
    
        if (mysqli_query($conn, $sql)) {
            self::$successMsg = "ArticleDevis records deleted successfully";
        } else {
            self::$errorMsg = "Error deleting ArticleDevis records: " . mysqli_error($conn);
        }
    }
    

    public static function selectAllArticleDevis($tableName, $conn) {
        // Select all ArticleDevis records from the database
        $sql = "SELECT * FROM $tableName";
        $result = mysqli_query($conn, $sql);
        $data = [];

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }

        return $data;
    }
}

?>