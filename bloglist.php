<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 10/4/2019
 * Time: 9:20 AM
 */
$pagename = "Content - Details";
require_once "header.inc.php";
?>
    <div class="row">
        <div class="side">
        </div>
        <div class="main">
<?php
try{
    $sql = "SELECT * FROM Blog";
    $result = $pdo->query($sql);


    echo "<table align='center'><tr><th>Title</th><th>Post</th><th>Date Posted</th><th>Last Updated</th></tr>";

    foreach ($result as $row){
        echo "<tr><td>". $row['title']. "</td><td>";
        echo $row['blog'];
        echo "</td><td>";
        echo date("l, F j, Y", $row['inputdate']);
        echo "</td><td>";
        echo date("l, F j, Y", $row['updatedate']);
        echo "</td></tr>\n";
    }
    echo "</table>";
}
catch (PDOException $e) {
    die($e->getMessage());
}

?>
        </div>
        <div class="side">
        </div>
    </div>
<?php
require_once "footer.inc.php";









