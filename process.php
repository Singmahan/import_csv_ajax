<?php 
    $connect = new PDO("mysql:host=localhost; dbname=import_csv_ajax", "root", "");

    $query = "SELECT * FROM user";
    $statment = $connect->prepare($query);
    $statment->execute();
    echo $statment->rowCount();
?>