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

                <div class="search">
                    <label>
                        <input type="text" id="searchInput" placeholder="Search here" aria-label="Search users">
                        <ion-icon name="search-outline" aria-hidden="true"></ion-icon>
                    </label>
                </div>

            </div>


            <!-- ================ Order Details List ================= -->
            <div class="details">
                <div class="Users">

                    <div class="cardHeader">
                        <h2>Users List</h2>
                        <a href="userCreate.php" class="status delivered">Add User</a>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                                <?php

                                //include connection file
                                include('connection.php');
                            
                                //create in instance of class Connection
                                $connection = new Connection();

                                //call the selectDatabase method
                                $connection->selectDatabase('projet');

                                //include the user file
                                include('user.php');
                                
                                //call the static selectAllClients method and store the result of the method in $clients
                                $users = User::selectAllUsers('Users',$connection->conn);
                                
                                if ($users !== null) {
                                    foreach ($users as $row) {
                                        echo " <tr>
                                            <td>$row[id]</td>
                                            <td>$row[firstname]</td>
                                            <td>$row[lastname]</td>
                                            <td>$row[email]</td>
                                            <td class='actions'>
                                                <a class='status pending' href='userUpdate.php?id=$row[id]'>edit</a>
                                                <a class='status return' href='userDelete.php?id=$row[id]'>delete</a>
                                            </td>
                                        </tr>";
                                    }
                                } else {
                                    echo "No users found."; // Add a message if no users are found
                                }
                                
                                ?>
                        </tbody>
                    </table>
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