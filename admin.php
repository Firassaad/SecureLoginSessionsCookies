<?php include_once("header.php")?>
<?php include_once("functions.php")?>

<?php
    if (!func::checkLoginState($dbh))
    {
        header("location:login.php");
        exit();
    }
    ?>

<section class="parent">
    <div class="child">
        <p>Hello <?php echo $_COOKIE['users_username'];?> and welcom to your private adlin section for this web application</p>
        <ul>
            <li>Manage</li>
            <li>Finance</li>
            <li>Friends</li>
            <li>Settings</li>
        </ul>
    </div>
</section>
<?php include_once("footer.php") ?>
