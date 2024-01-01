<?php
// Include connection file
include('connection.php');

// Create an instance of class Connection
$connection = new Connection();

// Call the selectDatabase method
$connection->selectDatabase('projet');

$nameValue = "";
$priceValue = "";

$successMessage = "";
$errorMessage = "";

if (isset($_POST["submit"])) {
    $nameValue = $_POST["article_name"];
    $priceValue = $_POST["price"];
    $category_idValue = $_POST["categories"];

    if (empty($priceValue) || empty($nameValue)) {
        $errorMessage = "All fields must be filled out!";
    } else {
        // Include the Clients class
        include('articles.php');

        // Create a new instance of the Clients class with the values of the inputs
        $article = new Articles ($nameValue, $priceValue, $category_idValue);

        // Call the insertClient method
        $article->insertArticle('Articles', $connection->conn);

        // Get the success and error messages from the Clients class
        $successMessage = articles::$successMsg;
        $errorMessage = Clients::$errorMsg;

        // Reset values
        $nameValue = "";
        $priceValue = "";
        $category_idValue = "";
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
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                
            </div>

            <div class="container" style="padding: 20px;">
                <form method="post" action="" >
                    <div class="row mb-3"></div>

                    <label for="firstname">Name</label>
                    <input value="<?php echo $nameValue ?>" type="text" id="name" name="article_name"
                        placeholder="name..">

                    <label for="lastname">Price</label>
                    <input value="<?php echo $priceValue ?>" type="text" id="price" name="price"
                        placeholder="price..">
                    <select name='categories' class="form-select">
                        <option value="" selected>Select the category</option>
                        <?php
                        // Include the file with the database connection
                       
                        include('categories.php');

                        // Create an instance of the Connection class
                        $connection = new Connection();

                        // Select the database
                        $connection->selectDatabase('projet');

                        // Get the connection property
                        

                        $categories = categorie::selectAllCategories('categories', $connection->conn);

                        foreach ($categories as $category) {
                            echo "<option value='$category[category_id]'>$category[category_name]</option>";
                        }
                        ?>
                    </select>
                    <input name="submit" type="submit" value="Submit">
                    <a class='status return' href='articleread.php' style="padding: 12px ;">Cancel</a>
                </form>
            </div>
        </div>
    </div>
                    <?php
                    if (!empty($successMessage)) {
                        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>$successMessage</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>
                            </button>
                            </div>";
                    }

                    if (!empty($errorMessage)) {
                        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>$errorMessage</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>
                            </button>
                            </div>";
                    }
                    ?>

                    <input name="submit" type="submit" value="Submit"> 
                    <a class='status return' href='clientread.php' style="padding: 12px ;">Cancel</a>
                </form>
            </div>
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule
        src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
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
  background-color: #04AA6D;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
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
