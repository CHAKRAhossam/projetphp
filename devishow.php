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


            <!-- ================ Order Details List ================= -->


            <div class="details">
                <div class="Users">
                    <?php

                        //include connection file
                        include('connection.php');

                        //create in instance of class Connection
                        $connection = new Connection();

                        //call the selectDatabase method
                        $connection->selectDatabase('projet');

                        //include the user file
                        include('devi.php');

                        $id = $_GET['id'];

                        $devi = Devi::selectDeviById($connection->conn, $id );

                        $devi_id = $devi['devi_id'];
                        $client_id = $devi['client_id'];
                        $client_firstname =$devi['client_firstname'];
                        $client_lastname = $devi['client_lastname'];
                        $client_email = $devi['client_email'];
                        $total = $devi['total'];


                    ?>
                    <div class="cardHeader">
                        <h2 style= "padding : 10px ;">Devi</h2>
                                             
                    </div>
                    <?php 
                    echo "
                        <div class='text-muted mb-1' style='font-size: 24px; padding: 10px;'>DEVI ID : $devi_id </div>  
                        <hr>
                        <div class='text-primary' style='font-size: 24px; padding: 10px;'>CLIENT ID : $client_id</div>
                        <div class='text-muted mb-1 ml-3' style='font-size: 20px;'>
                            <div style='padding: 5px;'>NAME : $client_firstname $client_lastname</div>
                            <div style='padding: 5px;'>EMAIL : $client_email</div>
                        </div>
                    ";
                    ?>

                    

                    <table>
                        <thead>
                            <tr>
                                <th >article</th>
                                <th >Qty</th>
                                <th >prix</th>
                                <th >prix * Qty</th>
                            </tr>
                        </thead>

                        <tbody>

                                <?php

                                
                            
                                //create in instance of class Connection
                                $connection = new Connection();

                                //call the selectDatabase method
                                $connection->selectDatabase('projet');

                                //include the user file
                                include('articleDevi.php');
                                
                                

                                //call the static selectAllClients method and store the result of the method in $clients
                                $ArticleDevis = ArticleDevi::selectArticleDevisByDeviId('articledevis',$connection->conn, $id );
                                
                                if ($ArticleDevis !== null) {
                                    foreach ($ArticleDevis as $row) {
                                        echo " <tr>
                                            <td>$row[article_id]</td>
                                            <td>$row[quantity]</td>
                                            <td>$row[quantity]</td>
                                            <td>$row[price]</td>
                                            </tr>";
                                    }
                                } else {
                                    echo "No article found."; // Add a message if no articles are found
                                }
                                
                                ?>
                        </tbody>
                    </table>
                    <?php 
                    echo "
                    <div class='mt-5 text-right text-danger' style='font-size: 25px;' >
                        <span colspan='4' class='mr-5'>Total </span>
                        <span class='total-all' id='total-price' name='prixt'>$total</span>
                    </div>
                    ";
                    ?>
                </div>
                
            </div>
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get the input element and user rows
            const searchInput = document.getElementById('searchInput');
            const userRows = document.querySelectorAll('.details .Users tbody tr');

            // Add an input event listener to the search input
            searchInput.addEventListener('input', function () {
                const searchTerm = searchInput.value.toLowerCase();

                // Loop through user rows and hide/show based on the search term
                userRows.forEach(function (row) {
                    const userText = row.innerText.toLowerCase();
                    if (userText.includes(searchTerm)) {
                        row.style.display = 'table-row';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>

</html>