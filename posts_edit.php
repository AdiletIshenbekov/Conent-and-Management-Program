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

if (isset($_POST['title'])) {
    if ($stm = $connect->prepare('UPDATE posts set title = ? , content = ? , date = ? WHERE id = ?')) {
        $stm->bind_param('sssi', $_POST['title'], $_POST['content'], $_POST['date'], $_GET['id']);
        $stm->execute();

        $stm->close();

        set_message("Content " . $_GET['id'] . " has been updated");
        header('Location: posts.php');
        die();

    } else {
        echo 'Could not prepare content update statement!';
    }
}

if (isset($_GET['id'])) {
    if ($stm = $connect->prepare('SELECT * from posts WHERE id = ?')) {
        $stm->bind_param('i', $_GET['id']);
        $stm->execute();
        $result = $stm->get_result();
        $post = $result->fetch_assoc();


        if ($post) {
            ?>

            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <h1>Edit Content</h1>

                        <form method="post">
                            <!-- Title input -->
                            <div class="mb-4">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" id="title" name="title" class="form-control"
                                    value="<?php echo $post['title'] ?>" />
                            </div>

                            <!-- Content input -->
                            <div class="mb-4">
                                <label for="content" class="form-label">Content</label>
                                <textarea name="content" id="content"><?php echo $post['content'] ?></textarea>
                            </div>

                            <!-- Date input -->
                            <div class="mb-4">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" id="date" name="date" class="form-control" value="<?php echo $post['date'] ?>" />
                            </div>

                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary btn-block">Edit Content</button> 
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