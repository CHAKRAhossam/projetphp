<?php

class User{

public $id;
public $firstname;
public $lastname;
public $email;
public $password;
public $reg_date; 

public static $errorMsg = "";

public static $successMsg="";


public function __construct($firstname,$lastname,$email,$password){

    //initialize the attributs of the class with the parameters, and hash the password
    $this->firstname = $firstname;
    $this->lastname = $lastname;
    $this->email = $email;
    $this->password = password_hash($password ,PASSWORD_DEFAULT);
}



public function insertUser($tableName, $conn) {
    // Check if the email already exists
    $checkDuplicate = mysqli_query($conn, "SELECT email FROM $tableName WHERE email='$this->email'");
    if (mysqli_num_rows($checkDuplicate) > 0) {
        // Email already exists, handle the error
        self::$errorMsg = "Email address already exists!";
        return;
    }

    // Email doesn't exist, //insert a client in the database, and give a message to $successMsg and $errorMsg
    $sql = "INSERT INTO $tableName (firstname, lastname, email, password)
            VALUES ('$this->firstname', '$this->lastname', '$this->email','$this->password')";

    if (mysqli_query($conn, $sql)) {
        self::$successMsg = "New record created successfully";
    } else {
        self::$errorMsg = "Error: " . $sql . mysqli_error($conn);
    }
}


public static function  selectAllUsers($tableName,$conn){

//select all the client from database, and inset the rows results in an array $data[]
        $sql = "SELECT id, firstname, lastname,email FROM $tableName";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
        // output data of each row
        $data=[];
        while($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }
}

static function selectUserById($tableName,$conn,$id){
    //select a client by id, and return the row result

    $sql = "SELECT firstname, lastname,email FROM $tableName WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
    // output data of each row
    $row = mysqli_fetch_assoc($result);
    }
    return $row;
}

static function updateUser($user,$tableName,$conn,$id){
    //update a client of $id, with the values of $client in parameter
    //and send the user to read.php

    $sql = "UPDATE $tableName SET lastname='$user->lastname',firstname='$user->firstname',email='$user->email' WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        self::$successMsg = "New record updated successfully";
        header("Location:userRead.php");
    } else {
        self::$errorMsg = "Error updating record: " . mysqli_error($conn);
    }
}

static function deleteUser($tableName,$conn,$id){
    //delet a client by his id, and send the user to read.php
    $sql = "DELETE FROM $tableName WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        self::$successMsg = "Record deleted successfully";
        header("Location:userRead.php");
    } else {
        self::$errorMsg = "Error deleting record: " . mysqli_error($conn);
    }
      
    }

    static function authenticateUser($tableName, $conn, $email, $password) {
        $sql = "SELECT * FROM $tableName WHERE email = '$email' LIMIT 1";
        $result = mysqli_query($conn, $sql);
    
        if ($result) {
            // Check if any rows were returned
            if (mysqli_num_rows($result) > 0) {
                // Fetch the user data
                $row = mysqli_fetch_assoc($result);
    
                // Verify the password
                if (password_verify($password, $row['password'])) {
                    // Password matches, authentication successful
    
                    // Start a session and store user information
                    session_start();
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['firstname'] = $row['firstname'];
                    $_SESSION['lastname'] = $row['lastname'];
                    $_SESSION['email'] = $row['email'];
    
                    // Redirect to userRead.php
                    header("Location: userRead.php");
                    exit();
                } else {
                    // Password does not match
                    self::$errorMsg = "Invalid email or password. Please try again. ";
                }
            } else {
                // User not found
                self::$errorMsg = "User not found";
            }
        } else {
            // Error executing the query
            self::$errorMsg = "Error: " . mysqli_error($conn);
        }
    }
    
}

?>
