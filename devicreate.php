<?php
// Include connection file
include('connection.php');

// Create an instance of class Connection
$connection = new Connection();

// Call the selectDatabase method
$connection->selectDatabase('projet');

$client_id= "" ;
$total = "";

$devi_id = "";
$article_id = "";
$quantity ="";
$price ="";

if (isset($_POST["submit"])) {
    $client_id = $_POST["clients"];
    $total = $_POST["prixt"];

    

    if (empty($client_id) || empty($total)) {
        $errorMessage = "All fields must be filled out!";
    } else {
        
        include('Devi.php');
        include('ArticleDevi.php');

        // Create a new instance of Devi to insert into the 'devis' table
        $devi = new Devi($client_id, $total );

        // Insert Devi into the 'devis' table
        $devi->insertDevi('devi', $connection->conn);


        // Get the last inserted devi_id
        $devi_id = mysqli_insert_id($connection->conn);

        foreach ($_POST['articles'] as $key => $article_id) {
            // Get quantity and total for the current article

            $quantity = $_POST['quantity'][$key];
            $price = $_POST['total'][$key];
            
            // Create a new instance of ArticleDevis for each article
            $articleDevis = new ArticleDevi($devi_id, $article_id, $quantity, $price ); 
            
            // Insert ArticleDevis into the 'articledevis' table
            $articleDevis->insertArticleDevi('articledevis', $connection->conn);
        }

        // Get the success and error messages from the Clients class
        $successMessage = Devi::$successMsg;
        $errorMessage = Devi::$errorMsg;

        // Reset values
        $client_id= "" ;
        $total = "";

        $devi_id = "";
        $article_id = "";
        $quantity ="";
        $price ="";

        // Redirect to a success page or do any further processing
        header("Location: deviread.php");
        exit();

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


            <div class="details">
                <div class="Users">
                    <div class="container" style="padding: 20px;">
                        <form method="post" action="" >

                            <select name='clients' class="form-select">
                                <option value="" selected>Select a client</option>
                                <?php
                                // Include the file with the database connection
                            
                                include('clients.php');

                                // Create an instance of the Connection class
                                $connection = new Connection();

                                // Select the database
                                $connection->selectDatabase('projet');

                                // Get the connection property
                                

                                $clients = Clients::selectAllClients('clients', $connection->conn);

                                foreach ($clients as $client) {
                                    echo "<option value='$client[client_id]'>$client[client_firstname] $client[client_lastname]</option>";
                                }
                                ?>
                            </select>
                        
                                <table>
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th >article</th>
                                            <th >prix</th>
                                            <th >Qty</th>
                                            <th >prix * Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody id="articleTableBody">
                                        <tr id="row-1">
                                            <td>
                                                <button onclick="deleteRow(this)">Delete Row</button>
                                            </td>
                                            <td>
                                                <select name="articles[]" class="form-select article-select" onchange="updatePrice(this)">
                                                    <option value="" selected>Select an article</option>
                                                    <?php
                                                    // Include the file with the database connection
                                                    include('articles.php');

                                                    // Select the database
                                                    $connection->selectDatabase('projet');

                                                    // Get the connection property

                                                    $articles = Articles::selectAllArticles('articles', $connection->conn);

                                                    foreach ($articles as $article) {
                                                        echo "<option value='$article[article_id]' data-price='$article[price]'>$article[article_name]</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <span class="articlePrice">0</span>
                                            </td>
                                            <td><input type="number" name="quantity[]" min="1" step="1" oninput="updateTotal(this)"></td>
                                            <td><input type="text" name="total[]" readonly></td>
                                        </tr>
                                    </tbody>
                                </table>
                                
                        
                            



                        
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

                            
                            <input type="hidden" name="prixt" id="hidden-total" value="0">
                            <div class="mt-5 text-right text-danger" style="font-size: 25px;">
                                <span colspan="4" class="mr-5">Total </span>
                                <span class="total-all" id="total-price">0</span>
                            </div>

                            <button type="button" onclick="addRow()">Add Row</button>
                            <input name="submit" type="submit" value="Submit"> 
                            <a class='status return' href='deviread.php' style="padding: 12px ;">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script>
            function addRow() {
                
                var table = document.querySelector('table tbody');
                
                // Check if the table is empty
                if (table.rows.length === 0) {
                    // Create a new row manually
                    var newRow = document.createElement('tr');
                    newRow.innerHTML = `
                        <td>
                            <button onclick="deleteRow(this)">Delete Row</button>
                        </td>
                        <td>
                            <select name="articles[]" class="form-select article-select" onchange="updatePrice(this)">
                                <option value="" selected>Select an article</option>
                                <?php
                                foreach ($articles as $article) {
                                            echo "<option value='$article[article_id]' data-price='$article[price]'>$article[article_name]</option>";
                                        }
                                ?>
                            </select>
                        </td>
                        <td>
                             <span class="articlePrice">0</span>
                        </td>
                        <td><input type="number" name="quantity[]" min="1" step="1" oninput="updateTotal(this)"></td>
                        <td><input type="text" name="total[]" readonly></td>
                    `;

                    // Append the new row to the table
                    table.appendChild(newRow);
                } else {
                    // Clone the last row
                    var lastRow = table.rows[table.rows.length - 1];
                    var newRow = lastRow.cloneNode(true);

                    // Update IDs and values to ensure uniqueness
                    var newRowId = "row-" + (table.rows.length + 1);
                    newRow.id = newRowId;

                    var articleSelect = newRow.querySelector('[name="articles[]"]');
                    articleSelect.value = ""; // Reset the selected option

                    var articlePrice = newRow.querySelector('.articlePrice');
                    articlePrice.innerText = "0"; // Reset the article price

                    var quantityInput = newRow.querySelector('[name="quantity[]"]');
                    quantityInput.value = ""; // Reset the quantity

                    var totalInput = newRow.querySelector('[name="total[]"]');
                    totalInput.value = ""; // Reset the total

                    // Append the new row to the table
                    table.appendChild(newRow);
                }
                updateTotalPrice();
            }


            function deleteRow(button) {
                var row = button.closest('tr');

                // Ensure that at least one row is present
                if (row) {
                    // Delete the found row
                    row.parentNode.removeChild(row);
                }
                updateTotalPrice();
            }

            function updatePrice(selectElement) {
                var selectedOption = selectElement.options[selectElement.selectedIndex];
                var price = selectedOption.getAttribute("data-price");
                var row = selectElement.parentNode.parentNode;
                row.querySelector('.articlePrice').innerText = price;
                updateTotalPrice();
            }

            function updateTotal(input) {
                // Get the corresponding row
                var row = input.parentNode.parentNode;

                // Get the article price
                var articlePrice = parseFloat(row.querySelector('.articlePrice').innerText) || 0;

                // Get the quantity input
                var quantity = parseFloat(row.querySelector('input[name="quantity[]"]').value) || 0;

                // Calculate the total
                var total = articlePrice * quantity;

                // Update the total input
                row.querySelector('input[name="total[]"]').value = total.toFixed(2);
                updateTotalPrice();
            }

            function updateTotalPrice() {
                var table = document.querySelector('table tbody');
                var rows = table.querySelectorAll('tr');
                var totalPrice = 0;

                // Iterate through each row and calculate the total price
                rows.forEach(function (row) {
                    var articlePrice = parseFloat(row.querySelector('.articlePrice').innerText) || 0;
                    var quantity = parseFloat(row.querySelector('input[name="quantity[]"]').value) || 0;
                    totalPrice += articlePrice * quantity;
                });

                // Update the total price display
                document.getElementById('total-price').innerText = totalPrice.toFixed(2);

                // Update the value of the hidden input
                document.getElementById('hidden-total').value = totalPrice.toFixed(2);
            }


    // Add an event listener to update the total price when the page loads
    window.addEventListener('load', updateTotalPrice);

        </script>
</body>
<style>


input[type=text],input[type=number],input[type=email],input[type=password], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  margin-top: 6px;
  margin-bottom: 16px;
  resize: vertical;
}
span[id=articlePrice]{
  width: 100%;
  padding: 16px 117px 7px 10px;
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

button{
    background-color: #FFA500;
  color: white;
  padding: 8px 8px;
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
