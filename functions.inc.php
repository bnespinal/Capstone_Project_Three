<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 10/2/2019
 * Time: 9:39 AM
 */

//This function checks to see if someone is logged in
function checkLogin()
{
    if(!isset($_SESSION['ID']))
    {
        echo "<p class='error'>This page requires authentication.  Please log in to view details.</p>";
        require_once "footer.inc.php";
        exit();
    }
}
function checkDup($pdo, $sql, $userentry)
{
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $userentry);
        $stmt->execute();
        return $stmt->rowCount();
    }
    catch (PDOException $e)
    {
        echo "<p class='error'> Error checking duplicate members!" . $e->getMessage() . "</p>";
        exit();
    }
}
function pwdCheck($pdo, $sql, $userentry)
{
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $userentry);
        $stmt->execute();
        return $stmt->rowCount();
    }
    catch (PDOException $e)
    {
        echo "<p class='error'> Error checking bad passwords!" . $e->getMessage() . "</p>";
        exit();
    }
}
function checkAdmin()
{
    if($_SESSION['membertype'] != 1)
    {
        echo "<p class='error'>This page requires that you have administrative status.</p>";
        require_once "footer.inc.php";
        exit();
    }
}


