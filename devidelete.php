<?php
// Include necessary files and classes
include('connection.php');
include('devi.php');
include('articledevi.php');  // Assuming this is the file containing the ArticleDevi class

// Create an instance of the Connection class
$connection = new Connection();

// Call the selectDatabase method
$connection->selectDatabase('projet');

// Check if devi_id is set in the URL
if (isset($_GET['devi_id'])) {
    $devi_id = $_GET['devi_id'];

    // Delete associated records in articledevis table
    ArticleDevi::deleteArticleDevisByDeviId($connection->conn, $devi_id);

    // Call the static deleteDevi method
    Devi::deleteDevi($connection->conn, $devi_id);

    // Redirect to the deviread.php page after deletion
    header("Location: deviread.php");
    exit();
} else {
    echo "Error: devi_id parameter is missing.";
}

?>
