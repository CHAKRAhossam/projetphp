<?php
$emailValue = "";
$lnameValue = "";
$fnameValue = "";

$errorMesage = "";
$successMesage = "";

// Inclure le fichier de connexion
include('connection.php');

// Créer une instance de la classe Connection
$connection = new Connection();

// Appeler la méthode selectDatabase
$connection->selectDatabase('projet');

// Inclure le fichier clients
include('clients.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (isset($_GET['client_id'])) {
        $id = $_GET['client_id'];

        // Appeler la méthode statique selectClientById et stocker le résultat dans $row
        $row = Clients::selectClientById('clients', $connection->conn, $id);

        // Vérifier si les clés existent avant de les utiliser
        $lnameValue = isset($row["client_lastname"]) ? $row["client_lastname"] : "";
        $fnameValue = isset($row["client_firstname"]) ? $row["client_firstname"] : "";
        $emailValue = isset($row["client_email"]) ? $row["client_email"] : "";
        $ville_idValue = isset($row["ville_id"]) ? $row["ville_id"] : "";
    } else {
        // Gérer le cas où $_GET['id'] n'est pas défini
        // ...
    }

} else if (isset($_POST["submit"])) {

    $emailValue = $_POST["client_email"];
    $lnameValue = $_POST["client_lastName"];
    $fnameValue = $_POST["client_firstName"];
    $ville_idValue= $_POST["ville_id"];
    if (empty($emailValue) || empty($fnameValue) || empty($lnameValue)) {
        $errorMesage = "Tous les champs doivent être remplis!";
    } else {
        // Créer une nouvelle instance de client ($client) avec les valeurs en entrée
        $client = new Clients($fnameValue, $lnameValue, $emailValue , $ville_idValue);

        // Appeler la méthode statique updateClient et donner $client en paramètres
        Clients::updateClient($client, 'clients', $connection->conn, $_GET['id']);
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
                <input value="<?php echo $fnameValue ?>" type="text" id="fname" name="client_firstName" placeholder="Your name..">

                <label for="lastname">Last Name</label>
                <input value="<?php echo $lnameValue ?>" type="text" id="lname" name="client_lastName" placeholder="Your last name..">

                <label for="email">email</label>
                <input value=" <?php echo $emailValue ?>" type="email" id="email" name="client_email" placeholder="Your email..">
         
                <select name='ville_id' class="form-select">
                        <option value="" selected>Select your city</option>
                        <?php
                        // Include the file with the database connection
                       
                        include('villes.php');

                        // Create an instance of the Connection class
                        $connection = new Connection();

                        // Select the database
                        $connection->selectDatabase('projet');

                        // Get the connection property
                        

                        $cities = villes::selectAllcities('villes', $connection->conn);

                        foreach ($cities as $city) {
                            echo "<option value='$city[ville_id]'>$city[ville_name]</option>";
                        }
                        ?>
                    </select>

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
                <a class='status return' href='clientread.php' style="padding: 12px ;">Cancel</a>
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


</html>