<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 10/2/2019
 * Time: 6:59 PM
 */
/* CREATE A CONNECTION TO THE SERVER */
try{
    $connString = "mysql:host=localhost;dbname=csci409sp19";
    $user = "csci409sp19";
    $pass = "csci409sp19!";
    $pdo = new PDO($connString,$user,$pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e)
{
    die( $e->getMessage() );
}

