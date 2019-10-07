<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 10/5/2019
 * Time: 6:05 PM
 */

$pagename ="Update Information";
include_once "header.inc.php";
?>
<div class="row">
    <div class="side">
    </div>
    <div class="main">
<?php

$showform = 1;
$errmsg = 0;
$errfname = "";
$errusername = "";
$erremail = "";
$errbio = "";
if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['ID']))
{
    $ID = $_GET['ID'];
}
elseif($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['ID']))
{
    $ID = $_POST['ID'];
}
else
{
    echo "<p class='error'>Something happened!  Cannot obtain the correct entry.</p>";
    $errmsg = 1;
}

if($_SERVER['REQUEST_METHOD'] == "POST")
{

    $formdata['fname'] = trim($_POST['fname']);
    $formdata['lname'] = trim($_POST['lname']);
    $formdata['email'] = trim(strtolower($_POST['email']));
    $formdata['bio'] = trim($_POST['bio']);


    if (empty($formdata['fname'])) {$errfname = "A first name is required."; $errmsg = 1; }
    if (empty($formdata['lname'])) {$errfname = "A last name is required."; $errmsg = 1; }
    if (empty($formdata['email'])) {$erremail = "An email is required."; $errmsg = 1;}
    if (empty($formdata['bio'])) {$errbio = "A bio is required."; $errmsg = 1; }



    if($formdata['email'] != $_POST['origemail'])
    {
        $sql = "SELECT * FROM members WHERE email = ?";
        $count = checkDup($pdo, $sql, $formdata['email']);
        if($count > 0)
        {
            $errmsg = 1;
            $erremail = "You cannot use the same email";
        }
    }

    if($errmsg == 1)
    {
        echo "<p class='error'>There are errors.  Please make corrections and resubmit.</p>";
    }
    else{



        try{
            $sql = "UPDATE blogmember 
                    SET fname = :fname, lname = :lname, email = :email, bio = :bio, updatedate = :updatedate 
                    WHERE ID = :ID";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':fname', $formdata['fname']);
            $stmt->bindValue(':lname', $formdata['lname']);
            $stmt->bindValue(':email', $formdata['email']);
            $stmt->bindValue(':bio', $formdata['bio']);
            $stmt->bindValue(':updatedate', $rightnow);
            $stmt->bindValue(':ID', $_SESSION['ID']);
            $stmt->execute();

            $showform =0; //hide the form
            echo "<p class='success' id='statement'>Thanks for updating the information.</p>";

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
    $sql = "SELECT * FROM blogmember WHERE ID = :ID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':ID',$ID); // VARIALE WE CREATED
    $stmt->execute();
    $row = $stmt->fetch();
    ?>
    <form name="memberupdate" id="memberupdate" method="post" action="memberupdate.php">
        <table>
            <tr><th><label for="fname">First Name:</label></th>
                <td>
                    <input name="fname"
                           id="fname"
                           type="text"
                           placeholder="Required fname"
                           value="<?php
                           if(isset($formdata['fname']) && !empty($formdata['fname']))           {
                               echo $formdata['fname'];
                           }
                           else
                           {
                               echo $row['fname'];
                           }

                           ?>"/></td></tr>
            <tr><th><label for="lname">Last Name:</label></th>
                <td>
                    <input name="lname"
                           id="lname"
                           type="text"
                           placeholder="Required lname"
                           value="<?php
                           if(isset($formdata['lname']) && !empty($formdata['lname']))           {
                               echo $formdata['lname'];
                           }
                           else
                           {
                               echo $row['lname'];
                           }

                           ?>"/></td></tr>
            <tr><th><label for="email">Email:</label></th>
                <td>
                    <input name="email"
                           id="email"
                           type="text"
                           placeholder="Required email"
                           value="<?php
                           if(isset($formdata['email']) && !empty($formdata['email']))           {
                               echo $formdata['email'];
                           }
                           else
                           {
                               echo $row['email'];
                           }

                           ?>"/>
                    <span class="error">*<?php if(isset($erremail)){echo $erremail;}?></span></td>
            </tr>
            <tr><th><label for="bio">Bio:</label></th>
                <td><span class="error">* <?php if(isset($errbio)){echo $errbio;}?></span>
                    <textarea name="bio" id="bio" placeholder="Required bio"><?php
                        if(isset($formdata['bio']) && !empty($formdata['bio']))           {
                            echo $formdata['bio'];
                        }
                        else
                        {
                            echo $row['bio'];
                        }

                        ?></textarea>
                </td>
            </tr>
            <tr><th><label for="submit">Submit:</label></th>
                <td><input type="hidden" name="ID" id="ID" value="<?php echo $row['ID'];?>"/>
                    <input type="hidden" name="username" id="username"
                           value="<?php echo $row['username'];?>"/>
                    <input type="hidden" name="origemail" id="origemail"
                           value="<?php echo $row['email'];?>"/>
                    <input type="submit" name="submit" id="submit" value="submit"/></td>
            </tr>

        </table>
    </form>
    <?php
}//end showform
?>
    </div>
    <div class="side">
    </div>
</div>
<?php
include_once "footer.inc.php";
?>
