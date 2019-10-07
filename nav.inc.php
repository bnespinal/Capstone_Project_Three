<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 10/5/2019
 * Time: 7:20 PM
 */
?>
<ul id="nav">
    <?php
    if(isset($_COOKIE)) {
        echo ($currentfile == "index.php") ? "<li>Home</li>" : "<li><a href='index.php'>Home</a></li>";
        echo ($currentfile == "memberinsert.php") ? "<li>Register</li>" : "<li><a href='memberinsert.php'>Register</a></li>";
        echo ($currentfile == "bloglist.php") ? "<li>Media Feed</li>" : "<li><a href='bloglist.php'>Media Feed</a></li>";
        if (isset($_SESSION['ID'])) {
            echo ($currentfile == "membermanage.php") ? "<li>Meet Your Peers</li>" : "<li><a href='membermanage.php'>Meet Your Peers</a></li>";
            echo ($currentfile == "searchuser.php") ? "<li>Search Users</li>" : "<li><a href='searchuser.php'>Search Users</a></li>";
            echo ($currentfile == "searchblog.php") ? "<li>Search Blogs</li>" : "<li><a href='searchblog.php'>Search Blogs</a></li>";
            echo ($currentfile == "bloginsert.php") ? "<li>Blog Input</li>" : "<li><a href='bloginsert.php'>Write a blog</a></li>";
            echo "<li><a href='logout.php'>Log Out</a></li>";
            echo "Welcome back, " . $_SESSION['username'];
        } else {
            echo "<li><a href='login.php'>Log In</a></li>";
        }
    }
    ?>
</ul>

