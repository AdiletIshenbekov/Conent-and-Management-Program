<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure(); //restrict access if user did not login

include('includes/header.php');

if(isset($_POST['title'])) {
    if($stm = $connect->prepare('INSERT INTO posts (title , content , author , date) VALUES (? , ? , ? , ?)')) {
        $stm->bind_param('ssis' , $_POST['title'] , $_POST['content'] , $_SESSION['id'] , $_POST['date']);
        $stm->execute();

        set_message("A new post " . $_SESSION['username'] . " has been added");
        header('Location: posts.php');
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
        <div class="col-md-10">
            <h1>Add Content</h1>

            <form method="post">
                <!-- Title input -->
                <div class="mb-4">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" id="title" name="title" class="form-control" />
                </div>

                <!-- Content input -->
                <div class="mb-4">
                    <label for="content" class="form-label">Content</label>
                    <textarea name="content" id="content"></textarea>
                </div>

                <!-- Date input -->
                <div class="mb-4">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" id="date" name="date" class="form-control" />
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block">Add Content</button>
            </form>
        </div>
    </div>
</div>

<script src="js/tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: '#content'
    });
</script>

<?php
include('includes/footer.php');
?>