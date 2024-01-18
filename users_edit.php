<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure(); //restrict access if user did not login

include('includes/header.php');

?>

<head>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>

<?php

if (isset($_POST['username'])) {
    if ($stm = $connect->prepare('UPDATE users set username = ? , email = ? , active = ? WHERE id = ?')) {
        $stm->bind_param('sssi', $_POST['username'], $_POST['email'], $_POST['active'], $_GET['id']);
        $stm->execute();

        $stm->close();

        //UPDATE PASSWORD
        if (isset($_POST['password'])) {
            if ($stm = $connect->prepare('UPDATE users set password = ? WHERE id = ?')) {
                $hashed = SHA1($_POST['password']);
                $stm->bind_param('si', $hashed, $_GET['id']);
                $stm->execute();

                $stm->close();

            } else {
                echo 'Could not prepare password update statement!';
            }
        }
        //

        set_message("User " . $_GET['id'] . " has been updated");
        header('Location: users.php');
        die();

    } else {
        echo 'Could not user update prepare statement!';
    }
}

if (isset($_GET['id'])) {
    if ($stm = $connect->prepare('SELECT * from users WHERE id = ?')) {
        $stm->bind_param('i', $_GET['id']);
        $stm->execute();
        $result = $stm->get_result();
        $user = $result->fetch_assoc();


        if ($user) {
            ?>

            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <h1>Edit User</h1>

                        <form method="post">
                            <!-- Username input -->
                            <div class="mb-4">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" id="username" name="username" class="form-control"
                                    value="<?php echo $user['username'] ?>" />
                            </div>

                            <!-- Email input -->
                            <div class="mb-4">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" id="email" name="email" class="form-control"
                                    value="<?php echo $user['email'] ?>" />
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
                                    <option <?php echo ($user['active']) ? "selected" : ""; ?> value="1">Active</option>
                                    <option <?php echo ($user['active']) ? "" : "selected"; ?> value="0">Inactive</option>
                                </select>
                            </div>

                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary btn-block">Update User</button>
                        </form>
                    </div>
                </div>
            </div>


            <?php
        }
        $stm->close();

    } else {
        echo 'Could not prepare statement!';
    }


} else {
    echo "No user selected";
    die();
}

include('includes/footer.php');
?>