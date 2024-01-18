<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure(); //restrict access if user did not login

include('includes/header.php');

//var_dump($_SESSION);

?>

<head>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1>Dashboard</h1>
            
            <a href="users.php">Users Management</a>
            <a href="posts.php">Posts Management</a>
        </div>
    </div>
</div>



<?php
include('includes/footer.php');
?>