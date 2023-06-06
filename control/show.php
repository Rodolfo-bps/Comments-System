<?php

$id = isset($_GET['id']) ? $_GET['id'] : null;
$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT); // Ejemplo de sanitización como número entero

// Validación adicional
if (!is_numeric($id) || $id < 1 || $id > 100) {
    exit("ID inválido.");
    header("location: index.php");
}

$onePost = $conn->prepare("SELECT * FROM posts WHERE id=:id");
$onePost->bindParam(":id", $id, PDO::PARAM_INT);
$onePost->execute();
$posts = $onePost->fetch(PDO::FETCH_OBJ);

// Verificar si se encontraron resultados
if (!$posts) {
    exit("No se encontró el post.");
}

$comments = $conn->prepare("SELECT * FROM comments WHERE post_id = :id");
$comments->bindParam(":id", $id, PDO::PARAM_INT);
$comments->execute();
$comment = $comments->fetchAll(PDO::FETCH_OBJ);

$ratings = $conn->prepare("SELECT * FROM rates WHERE post_id = :id AND user_id = '$_SESSION[user_id]'");
$ratings->bindParam(":id", $id, PDO::PARAM_INT);
$ratings->execute();
$rating = $ratings->fetch(PDO::FETCH_OBJ);

print_r($rating);
