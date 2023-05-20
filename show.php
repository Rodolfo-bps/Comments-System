<?php
require "includes/header.php";
require "config.php";

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
?>

<h1 class="text-center mt-3"> POSTS</h1>
<div class="row">
    <div class="col-2"></div>
    <div class="col-8">
        <div class="card mt-3">
            <div class="card-header">
                <?= "Author " . $posts->username ?>
            </div>
            <div class="card-body">
                <h5 class="card-title"><?= $posts->title ?></h5>
                <p class="card-text"><?= $posts->body ?></p>
                <p style="font-size:12px ;">Fecha de creacion <?= $posts->created_at ?></p>
            </div>
        </div>
    </div>
    <div class="col-2"></div>
</div>

<?php require "includes/footer.php"; ?>