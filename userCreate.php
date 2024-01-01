<?php

$emailValue = "";
$lnameValue = "";
$fnameValue = "";
$passwordValue = "";
$successMesage = "";
$errorMesage = "";
if(isset($_POST["submit"])){
    
    $fnameValue = $_POST["firstName"];
    $lnameValue = $_POST["lastName"];
    $emailValue = $_POST["email"];  
    $passwordValue = $_POST["password"];

    if(empty($emailValue) || empty($fnameValue) || empty($lnameValue) || empty($passwordValue)){

            $errorMesage = "all fileds must be filed out!";

    }else if(strlen($passwordValue) < 8 ){
        $errorMesage = "password must contains at least 8 char";
    }else if(preg_match("/[A-Z]+/", $passwordValue)==0){
        $errorMesage = "password must contains  at least one capital letter!";
    }else{
    
        //include connection file
        include('connection.php');
   
        //create in instance of class Connection
        $connection = new Connection();

        //call the selectDatabase method
        $connection->selectDatabase('projet');
   
    
        //include the user file
        include('user.php');

        //create new instance of client class with the values of the inputs
        $user = new User($fnameValue, $lnameValue, $emailValue, $passwordValue);

        //call the insertClient method
        $user->insertUser('Users',$connection->conn);

        // Check if a new record is created successfully
        if (!empty(User::$successMsg)) {
            $successMesage = User::$successMsg;

            // Redirect to userRead.php
            header("Location: userRead.php");
            exit(); // Make sure to exit after a header redirect
        }

        // If there was an error, update $errorMesage
        if (!empty(User::$errorMsg)) {
            $errorMesage = User::$errorMsg;
        }

        $emailValue = "";
        $lnameValue = "";
        $fnameValue = "";   
            
        
        
        
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Admin Dashboard | Korsat X Parmaga</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="assets/css/style.css">
    
</head>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
    <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="logo-apple"></ion-icon>
                        </span>
                        <span class="title">
                           <?php
                            session_start();
                            echo $_SESSION['firstname'] . ' ' . $_SESSION['lastname'];
                            ?>
                        </span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="userRead.php">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">Users</span>
                    </a>
                </li>

                <li>
                    <a href="clientread.php">
                        <span class="icon">
                        <ion-icon name="person-outline"></ion-icon>
                        </span>
                        <span class="title">Clients</span>
                    </a>
                </li>

                <li>
                    <a href="articleread.php">
                        <span class="icon">
                        <ion-icon name="cart-outline"></ion-icon>
                        </span>
                        <span class="title">Articles</span>
                    </a>
                </li>

                <li>
                    <a href="deviread.php">
                        <span class="icon">
                            <ion-icon name="receipt-outline"></ion-icon>
                        </span>
                        <span class="title">Devis</span>
                    </a>
                </li>

                <li>
                    <a href="signout.php">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                
            </div>

        <div class="containerr">
            <form method="post" action="">
            <div class="row mb-3">
            </div>

                <label for="firstname">First Name</label>
                <input value="<?php echo $fnameValue ?>" type="text" id="fname" name="firstName" placeholder="Your name..">

                <label for="lastname">Last Name</label>
                <input value="<?php echo $lnameValue ?>" type="text" id="lname" name="lastName" placeholder="Your last name..">

                <label for="email">email</label>
                <input value=" <?php echo $emailValue ?>" type="email" id="email" name="email" placeholder="Your email..">

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Your Password.." >

                <?php
            if (!empty($successMesage)) {
                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>$successMesage</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>
                    </button>
                    </div>";
            }

            if (!empty($errorMesage)) {
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>$errorMesage</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>
                    </button>
                    </div>";
            }
            ?>

                <input name="submit" type="submit" value="Submit">
                <a class='status return' href='userRead.php' style="padding: 12px ;">Cancel</a>
            </form>
        </div>

        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

<style>


input[type=text],input[type=email],input[type=password], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  margin-top: 6px;
  margin-bottom: 16px;
  resize: vertical;
}

input[type=submit] {
  background-color: #008000;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  font-weight: 500;
}

input[type=submit]:hover {
  background-color: #45a049;
}

.containerr {
  border-radius: 5px;
  padding: 20px;
}

/* Styles for success message */
.alert-success {
    background-color: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
}

/* Styles for error message */
.alert-danger {
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
}

/* Common styles for all alert messages */
.alert {
    padding: 1rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
    border-radius: 0.25rem;
}

/* Close button styles */
.btn-close {
    float: right;
    font-size: 1.25rem;
    font-weight: bold;
    line-height: 1;
    color: #000;
    text-shadow: 0 1px 0 #fff;
    opacity: 0.5;
}

</style>
</html>