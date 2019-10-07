<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 10/4/2019
 * Time: 12:20 PM
 */
$pagename = "Search-Blog";
require_once "header.inc.php";
require_once "functions.inc.php";
checkLogin();
$showform = 1;
$errmsg = 0;
?>
<div class="row">
    <div class="side">
    </div>
    <div class="main">
<?php
if($_SERVER['REQUEST_METHOD'] == "POST")
{
    // We are just echoing out the search term for the user's benefit
    echo "<p id='statement'>Searching for:  " .  $_POST['term'] . "</p>";
    echo "<hr />";

    $formdata['term'] = trim($_POST['term']);


    if (empty($formdata['term'])){
        $errterm = "The term is missing.";
        $errmsg = 1;
    }

    if($errmsg == 1)
    {
        echo "<p class='error'>There are errors.  Please make corrections and resubmit.</p>";
    }
    else {
        try {
            //query the data
            $sql = "SELECT * 
                    FROM Blog 
                    WHERE title
                    LIKE '%{$formdata['term']}%'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() == 0) {
                echo "<p class='error' id='statement'>There are no results.  Please try a different search term.</p>";
            } else {
                echo "<p class='success' id='statement'>The following results matched your search:</p>";
                echo "<table align='center'><tr><th>Username</th><th>Title</th><th>Post</th></tr>";
                foreach ($result as $row)
                {
                    echo "<tr><td>" . $row['username'] . "</td>";
                    echo "<td>".$row['title']."</td>";
                    echo "<td>" . $row['blog'];
                    echo "</td></tr>";
                }

                echo "</table>";
                echo "<p id='statement'>Return to page to search again. <a href='http://ccuresearch.coastal.edu/bnespinal/csci409sp19/Project3/searchblog.php'>SEARCH</a></p>";
                $showform = 0;
            }
        }//try
        catch (PDOException $e) {
            die($e->getMessage());
        }
    } // if errors
}//if post
if($showform ==1) {
    ?>

    <form name="searchform" id="searchform" method="post" action="searchblog.php">
        <label for="term">Search Blog:</label><span class="error">*</span>
        <input name="term" id="term" type="text" />
        <span class="error"><?php if(isset($errterm)){echo $errterm;}?></span>
        <br />
        <input type="submit" name="submit" id="submit" value="submit" />
    </form>

    <?php
}//showform

?>
    </div>
    <div class="side">
    </div>
</div>
<?php
require_once "footer.inc.php";
?>








