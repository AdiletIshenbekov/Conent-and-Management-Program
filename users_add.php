<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure(); //restrict access if user did not login

include('includes/header.php');

if (isset($_POST['username'])) {
    if ($stm = $connect->prepare('INSERT INTO users (username , email , password , active) VALUES (? , ? , ? , ?)')) {
        $hashed = SHA1($_POST['password']);
        $stm->bind_param('ssss', $_POST['username'], $_POST['email'], $hashed, $_POST['active']);
        $stm->execute();

        set_message("A new user " . $_SESSION['username'] . " has been added");
        header('Location: users.php');
        $stm->close();
        die();

    } else {
        echo 'Could not prepare statement!';
    }
}

?>

<head>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1>Add User</h1>

            <form method="post">
                <!-- Username input -->
                <div class="mb-4">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control" />
                </div>

                <!-- Email input -->
                <div class="mb-4">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" id="email" name="email" class="form-control" />
                </div>

                <!-- Password input -->
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" />
                </div>

                <!-- Active select -->
                <div class="mb-4">
                    <label for="active" class="form-label">Active</label>
                    <select name="active" class="form-select" id="active">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block">Add User</button>
            </form>

        </div>
    </div>
</div>


<?php
include('includes/footer.php');
?>