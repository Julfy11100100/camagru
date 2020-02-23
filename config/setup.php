<?php

include 'database.php';

// create database
try {
   	$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE IF NOT EXISTS camagru";
    // use exec() because no results are returned
	$conn->exec($sql);
	//echo "Database created successfully<br>";
}
catch(PDOException $e){
    echo "ERROR CREATING DATABASE: ".$e->getMessage()." Aborting process<br>";
}

//create table users
try {
	$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$conn->exec("USE camagru");
	$sql = "CREATE TABLE IF NOT EXISTS users
	(
	    `id` int(11) NOT NULL AUTO_INCREMENT,
        `login` varchar(100) NOT NULL,
        `email` varchar(100) NOT NULL,
        `password` varchar(255) NOT NULL,
		`token` VARCHAR(16) NOT NULL,
        `verified` VARCHAR(1) DEFAULT '0',
		`comment_to_email` VARCHAR(1) DEFAULT '1',
        PRIMARY KEY (`id`)
		
	);";
	$conn->exec($sql);
}
catch(PDOException $e){
	echo "ERROR CREATING TABLE USERS ".$e->getMessage()." Aborting process<br>";
}

//create table images
try {
	$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$conn->exec("USE camagru");
	$sql = "CREATE TABLE IF NOT EXISTS images
	(
	    `id` int(11) NOT NULL AUTO_INCREMENT,
        `login` varchar(100) NOT NULL,
        `title` varchar(100) NOT NULL,
		`date` varchar(10) NOT NULL,
        PRIMARY KEY (`id`)
		
	);";
	$conn->exec($sql);
}
catch(PDOException $e){
	echo "ERROR CREATING TABLE USERS ".$e->getMessage()." Aborting process<br>";
}

//create table likes
try {
	$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$conn->exec("USE camagru");
	$sql = "CREATE TABLE IF NOT EXISTS likes
	(
	    `id` int(11) NOT NULL AUTO_INCREMENT,
        `login` varchar(100) NOT NULL,
        `img_title` varchar(100) NOT NULL,
        PRIMARY KEY (`id`)
		
	);";
	$conn->exec($sql);
}
catch(PDOException $e){
	echo "ERROR CREATING TABLE USERS ".$e->getMessage()." Aborting process<br>";
}

//create table comments
try {
	$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$conn->exec("USE camagru");
	$sql = "CREATE TABLE IF NOT EXISTS comments
	(
	    `id` int(11) NOT NULL AUTO_INCREMENT,
        `login` varchar(100) NOT NULL,
        `comment` varchar(140) NOT NULL,
		`img_title` varchar(100) NOT NULL,
        PRIMARY KEY (`id`)
		
	);";
	$conn->exec($sql);
}
catch(PDOException $e){
	echo "ERROR CREATING TABLE USERS ".$e->getMessage()." Aborting process<br>";
}


?>
