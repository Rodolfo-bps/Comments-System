<?php

if (!isset($_SESSION['username'])) {
    header("location: login.php");
}

$errors = array();

if (isset($_POST['submit'])) {
    if ($_POST['title'] == '' || $_POST['body'] == '') {
        $errors[] = "Some inputs are empty";
    } else {
        // Perform individual validations for each field
        if (strlen($_POST['title']) < 10) {
            $errors[] = "Title must be at least 5 characters long";
        } elseif (strlen($_POST['body']) < 50) {
            $errors[] = "Body must be at least 200 characters long";
        } else {
            // All fields are valid, proceed with further processing
            $title = isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '';
            $body = isset($_POST['body']) ? htmlspecialchars($_POST['body']) : '';
            $username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : '';

            $insert = $conn->prepare("INSERT INTO posts (title, body, username) VALUES (:title, :body, :username)");
            $insert->execute([
                ":title" => $title,
                ":body" => $body,
                ":username" => $username
            ]);
            header("location: index.php");
        }
    }
}
