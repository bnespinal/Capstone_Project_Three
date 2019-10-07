<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 10/7/2019
 * Time: 8:20 AM
 */

$pagename = "Manage Members";
require_once "header.inc.php";
checkLogin();
?>
    <div class="row">
        <div class="side">
        </div>
        <div class="main">
<?php

echo "<p id='statement'><b><a href='memberupdate.php?ID=" . $_SESSION['ID'] . "'>Update My Membership Information</a> | <a href='memberpwd.php?ID=" . $_SESSION['ID'] ."'>Update My Password</a></b></p>";
try{
    //query the data
    $sql = "SELECT * FROM blogmember";
    //executes a query.
    $result = $pdo->query($sql);

    ?>
    <?php
    echo "<table align='center'>
            <tr><th>Username</th><th>Joined</th></tr>";
    //loop through the results and display to the screen
    foreach ($result as $row){
        echo "<tr>
        <td><a href='memberdetails.php?ID=" . $row['ID'] . "'>". $row['username']. "</a></td>
        <td> ";
        echo date("l, F j, Y", $row['inputdate']);
        echo "</td></tr>\n";
    }
    echo "</table>";
}
catch (PDOException $e)
{
    die( $e->getMessage() );
}
?>
        </div>
        <div class="side">
        </div>
    </div>
<?php
require_once "footer.inc.php";








