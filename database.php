<?php

//include the connection file
include('connection.php');

//create inctance of connection class
$connection = new Connection();

//call createDatabase methode
$connection->createDatabase('projet');

//call selectDatabase methode
$connection->selectDatabase('projet');

// Define the SQL query to create the 'Users' table
$usersTableQuery = "
CREATE TABLE Users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(50) UNIQUE,
    password VARCHAR(50),
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
";

// Create the 'Users' table
$connection->createTable($usersTableQuery);

// Define the SQL query to create the 'Villes' table
$villesTableQuery = "
CREATE TABLE Villes (
    ville_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ville_name VARCHAR(50) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
";

// Create the 'Villes' table
$connection->createTable($villesTableQuery);

// Define the SQL query to create the 'Clients' table with a foreign key referencing 'Villes'
$clientsTableQuery = "
CREATE TABLE Clients (
    client_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    client_firstname VARCHAR(50) NOT NULL,
    client_lastname VARCHAR(50) NOT NULL,
    client_email VARCHAR(50) UNIQUE,
    ville_id INT(6) UNSIGNED,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (ville_id) REFERENCES Villes(ville_id)
)
";

// Create the 'Clients' table
$connection->createTable($clientsTableQuery);

// Define the SQL query to create the 'Categories' table
$categoriesTableQuery = "
CREATE TABLE Categories (
    category_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(50) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
";

// Create the 'Categories' table
$connection->createTable($categoriesTableQuery);

// Define the SQL query to create the 'Articles' table
$articlesTableQuery = "
CREATE TABLE Articles (
    article_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    article_name VARCHAR(100) NOT NULL,
    category_id INT(6) UNSIGNED,
    price DECIMAL(10, 2) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES Categories(category_id)
)
";

// Create the 'Articles' table
$connection->createTable($articlesTableQuery);



// Define the SQL query to create the 'Devi' table
$deviTableQuery = "
CREATE TABLE Devi (
    devi_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    client_id INT(6) UNSIGNED,
    total DECIMAL(10, 2) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES Clients(client_id)
)
";

// Create the 'Devi' table
$connection->createTable($deviTableQuery);



$articleDeviTableQuery = "
CREATE TABLE ArticleDevis  (
    article_devis_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    devi_id INT(6) UNSIGNED,
    article_id INT(6) UNSIGNED,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (article_id) REFERENCES Articles(article_id),
    FOREIGN KEY (devi_id) REFERENCES Devi(devi_id)
)
";

$connection->createTable($articleDeviTableQuery);

?>