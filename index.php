<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
include('includes/header.php');

if(isset($_SESSION['id'])) {
    header('Location: dashboard.php');
    die();
}

if(isset($_POST['email'])) {
    if($stm = $connect->prepare('SELECT * FROM users WHERE email = ? AND password = ? AND active = 1')) {
        $hashed = SHA1($_POST['password']);
        $stm->bind_param('ss' , $_POST['email'] , $hashed);
        $stm->execute();

        $result = $stm->get_result();
        $user = $result->fetch_assoc();

        if($user) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['username'] = $user['username'];

            set_message("You have succesfully logged in " . $_SESSION['username']);
            header('Location: dashboard.php');
            die();
        }

        $stm->close();
    } else {
        echo 'Could not prepare statement!';
    }
}

?>

<head>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>

<body style="background: linear-gradient(to bottom right, #FBD925, #FB8412); margin: 0; padding: 0; height: 100vh; background-size: cover; position: relative;">

    <div class="container mt-5 login-box">
        <div class="row justify-content-center">
            <div class="col-md-6" style="background-color: white; padding: 20px; border-radius: 10px;">
                <h1>Login</h1>
                <br>

                <form method="post">
                    <!-- Email input -->
                    <label style="color: black; margin-top: 10px;" class="form-label" for="email">Email</label>

                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="email" id="email" name="email" class="form-control" />
                        <label style="margin-top: 5px;" class="form-label" for="email">Enter your email address</label>
                        <hr>
                    </div>

                    <!-- Password input -->
                    <label style="color: black; margin-top: 10px;" class="form-label" for="password">Password</label>

                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="password" id="password" name="password" class="form-control" />
                        <label style="margin-top: 5px;" class="form-label" for="password">Enter your password</label>
                        <hr>
                    </div>

                    <br>

                    <!-- Submit button -->
                    <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block">Sign in</button>             
                </form>
            </div>
        </div>
    </div>

<?php
include('includes/footer.php');
?>

