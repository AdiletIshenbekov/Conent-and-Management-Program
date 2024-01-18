<?php

function secure()  {
    if(!isset($_SESSION['id'])) {
        set_message("Please login first");
        header('Location: /cms');
        die();
    }
}

function set_message($message) {
    $_SESSION['message'] = $message;
}

function get_message() {
    if(isset($_SESSION['message'])) {
        echo "<script type='text/javascript'> showToast('" . $_SESSION['message'] . "','top right'  , 'warning') </script>";
        unset($_SESSION['message']);
    }
}

?>