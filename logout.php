<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 10/2/2019
 * Time: 10:40 PM
 */
session_start();
session_unset();
session_destroy();
//did they change passwords?  If so, provide specific message
if($_SERVER['REQUEST_METHOD'] == "GET" && $_GET['state']==3) {
    header("Location: confirm.php?state=3");
}
else
{
    header("Location: confirm.php?state=1");
}
exit();
?>


