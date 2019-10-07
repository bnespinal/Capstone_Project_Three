<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 10/3/2019
 * Time: 8:50 AM
 */
$pagename = "Content - Insert";
include_once "header.inc.php";
checkLogin();
//SET INITIAL VARIABLES
$showform = 1;  // show form is true
$errmsg = 0;
$errtitle = "";
$errblog = "";

if($_SERVER['REQUEST_METHOD'] == "POST")
{

    $formdata['title'] = trim($_POST['title']);
    $formdata['blog'] = trim($_POST['blog']);


    if (empty($formdata['title'])) {$errtitle = "The title is required."; $errmsg = 1; }
    if (empty($formdata['blog'])) {$errblog = "A blog is required."; $errmsg = 1; }


    try
    {
        $sql = "SELECT LCASE(title) FROM Blog WHERE title = :title";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':title', strtolower($formdata['title']));
        $stmt->execute();
        $countcat = $stmt->rowCount();
        if ($countcat > 0)
        {
            $errmsg = 1;
            $errtitle = "Title already taken.";
        }
    }
    catch (PDOException $e)
    {
        echo "<p class='error'>Error checking duplicate titles!" . $e->getMessage() . "</p>";
        exit();
    }


    if($errmsg == 1)
    {
        echo "<p class='error'>There are errors.  Please make corrections and resubmit.</p>";
    }
    else{

        try{
            $sql = "INSERT INTO Blog (username, title, blog, inputdate, updatedate)
                    VALUES (:username, :title, :blog, :inputdate, :updatedate) ";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':username', $_SESSION['username']);
            $stmt->bindValue(':title', $formdata['title']);
            $stmt->bindValue(':blog', $formdata['blog']);
            $stmt->bindValue(':inputdate', $rightnow);
            $stmt->bindValue(':updatedate', $rightnow);
            $stmt->execute();

            $showform =0; //hide the form
            ?>
            <div class="row">
                <div class="side">
                </div>
                <div class="main">
                    <?php
                    echo "<p class='success'>Thanks for Posting.</p>";
                    ?>
                </div>
                <div class="side">
                </div>
            </div>
            <?php
        }
        catch (PDOException $e)
        {
            die( $e->getMessage() );
        }
    } // else errormsg
}//submit

//display form if Show Form Flag is true
if($showform == 1)
{
?>
<div class="row">
    <div class="side">
    </div>
    <div class="main">
    <form name="bloginsert" id="bloginsert" method="post" action="bloginsert.php">
        <table>
            <tr><th><label for="title">Title:</label><span class="error">*</span></th>
                <td><input name="title" id="title" type="text"  placeholder="Required Title"
                           value="<?php if(isset($formdata['title'])){echo $formdata['title'];}?>"/>
                    <span class="error"><?php if(isset($errtitle)){echo $errtitle;}?></span></td>
            </tr>
            <tr><th><label for="blog">Blog Text:</label><span class="error">*</span></th>
                <td><span class="error"><?php if(isset($errblog)){echo $errblog;}?></span>
                    <textarea name="blog" id="blog" placeholder="Required Blog"><?php if(isset($formdata['blog'])){echo $formdata['blog'];}?></textarea>
                </td>
            </tr>
            <tr><th><label for="submit">Submit:</label></th>
                <td><input type="submit" name="submit" id="submit" value="submit"/></td>
            </tr>

        </table>
    </form>

    </div>
    <div class="side">
    </div>
</div>
    <?php
}//end showform
include_once "footer.inc.php";
?>








