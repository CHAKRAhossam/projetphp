<?php

if($_SERVER['REQUEST_METHOD']=='GET'){

    $id=$_GET['id'];

    //include connection file
    include('connection.php');
                            
    //create in instance of class Connection
    $connection = new Connection();

    //call the selectDatabase method
    $connection->selectDatabase('projet');

    //include the user file
    include('articles.php');

    //call the static deleteClient method
    articles::deleteArticle('articles',$connection->conn,$id);

}
header("Location: articleread.php");
?>
