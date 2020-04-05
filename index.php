 <?php
include_once ("header.php");
 include_once ("functions.php")
     ?>
<section class="parent">
    <div class="child">
        <?php
        if(!func::checkLoginState($dbh))
        {
            header("location:login.php");
            exit();
        }
        echo "Welcome   ".$_SESSION['user_username'] . '   !  ' ;

        ?>
    </div>
</section>
 <?php
 include_once ("footer.php");

 ?>