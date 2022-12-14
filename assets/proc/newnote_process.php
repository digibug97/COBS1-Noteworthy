<?php

function validate_inputs($title, $body, $errors) {
    global $errors;

    // Length check for title
    // 1 character or more to ensure no empty titles
    // 25 characters or less to meet database requirements
    if (strlen($title) < 1 || strlen($title) > 25) {
        $errors[] = "Title must be 1-25 characters";
    }

    // Length check for body
    // 1 character or more to ensure no empty bodies
    // 25 characters or less to meet database requirements
    if (strlen($body) < 1 || strlen($body) > 255) {
        $errors[] = "Body must be 8-20 characters";
    }

    // Return true if validates, return false if not.
    if (count($errors) == 0) {
        return true;
    } else {
        return false;
    }
}

session_start();

$noteTitle = $_POST['title'];
$noteMessage = $_POST['message'];

$errors = [];

include "../inc/toast_handler.php";

if (validate_inputs($noteTitle, $noteMessage, $errors)) {
    
    $username = $_SESSION['username'];

    $conn = mysqli_connect('localhost', 'root', '', 'thenotesapp');
    $sql_newnote = "INSERT INTO note(username, title, message) VALUES ('$username', '$noteTitle', '$noteMessage')";
    $rs_newnote = mysqli_query($conn, $sql_newnote);
    create_toast("success", "Note Created", "Your note has been saved", "../../notes.php");
} else {
    create_toast("error", "Note Creation Failed", $errors, "../../notes.php");
}




?>