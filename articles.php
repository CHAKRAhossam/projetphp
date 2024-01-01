
<?php

class Articles {

    public $article_id;
    public $article_name;
  
    public $category_id;
    public $price;
    public $reg_date; 

    public static $errorMsg = "";
    public static $successMsg = "";

    public function __construct($name, $price, $category_id) {
        // Initialize the attributes of the class with the parameters
        $this->article_name = $name;
        $this->price = $price;
      $this->category_id = $category_id;
      
    }

    public function insertArticle($tableName, $conn) {
        // // Check if the email already exists
        // $checkDuplicate = mysqli_query($conn, "SELECT client_email FROM $tableName WHERE client_email='$this->client_email'");
        // if (mysqli_num_rows($checkDuplicate) > 0) {
        //     // Email already exists, handle the error
        //     self::$errorMsg = "Email address already exists!";
        //     return;
        // }

        // Email doesn't exist, insert a client in the database
        $sql = "INSERT INTO $tableName (article_name, price, category_id)
                VALUES ('$this->article_name', '$this->price', '$this->category_id')";

        if (mysqli_query($conn, $sql)) {
            self::$successMsg = "New record created successfully";
        } else {
            self::$errorMsg = "Error: " . $sql . mysqli_error($conn);
        }
        header("Location: articleread.php");
    }

    public static function selectAllArticles($tableName, $conn) {
        // Select all the clients from the database
        $sql = "SELECT a.article_id, a.article_name,  a.price, a.category_id, c.category_name
        FROM $tableName a
        INNER JOIN categories c ON a.category_id = c.category_id";
        $result = mysqli_query($conn, $sql);
        $data = [];

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }

        return $data;
    }

    public static function selectArticleById($tableName, $conn, $id) {
        // Select a client by id
        $sql = "SELECT article_name, price, category_id FROM $tableName WHERE article_id='$id'";
        $result = mysqli_query($conn, $sql);
        $row = [];

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
        }

        return $row;
    }

    public static function updateArticle($article, $tableName, $conn, $id) {
        // Update a client by id
        $sql = "UPDATE $tableName SET article_name='$article->article_name', 
               price='$article->price', category_id='$article->category_idValue'
               WHERE article_id='$id'";
        if (mysqli_query($conn, $sql)) {
            self::$successMsg = "Record updated successfully";
            header("Location: articleread.php");
        } else {
            self::$errorMsg = "Error updating record: " . mysqli_error($conn);
        }
    }
    

public static function deleteArticle($tableName, $conn, $id) {
    // Delete associated records in articledevis table
    $sqlDeleteArticleDevis = "DELETE FROM articledevis WHERE article_id='$id'";
    mysqli_query($conn, $sqlDeleteArticleDevis);

    // Delete the article from the articles table
    $sqlDeleteArticle = "DELETE FROM $tableName WHERE article_id='$id'";

    if (mysqli_query($conn, $sqlDeleteArticle)) {
        self::$successMsg = "Record deleted successfully";
    } else {
        self::$errorMsg = "Error deleting record: " . mysqli_error($conn);
    }
}
}

?>
