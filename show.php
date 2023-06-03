<?php
require "includes/header.php";
require "config.php";
include "control/show.php";
?>
<h1 class="text-center mt-3"> POSTS</h1>
<div class="row">
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
        <form method="POST" id="comment_data">
            <h5 class="h3 mt-5 fw-normal text-center">Create Post</h5>
            <div class="form-floating">
                <input name="username" value="<?= $_SESSION['username'] ?>" type="hidden" class="form-control" id="username">
            </div>
            <div class="form-floating">
                <input name="post_id" value="<?= $posts->id ?>" type="hidden" class="form-control" id="post_id">
            </div>
            <div class="form-floating mt-4">
                <textarea name="comment" cols="30" rows="10" placeholder="comment" class="form-control" id="comment"></textarea>
                <label for="floatingPassword">Comment</label>
            </div>
            <button name="submit" class="w-100 btn btn-lg btn-primary mt-5" type="submit">Create Comment</button>
        </form>
        <div id="msg" class="nothing"></div>
        <div id="delete-msg" class="nothing"></div>
    </div>
    <div class="col-4">
        <?php foreach ($comment as $singleComment) : ?>
            <div class="card mt-3">
                <div class="card-header">
                    <?= "Author " . $singleComment->username ?>
                </div>
                <div class="card-body">
                    <p class="card-text"><?= $singleComment->comment ?></p>
                    <p style="font-size:12px ;">Fecha de creacion <?= $singleComment->created_at ?></p>
                    <?php if(isset($_SESSION['username']) && $_SESSION['username'] == $singleComment->username): ?>
                    <button id="delete-btn" value="<?= $singleComment->id ?>" class="btn btn-danger">Delete</button>
                    <?php endif; ?>
               
                </div>

            </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="row">
    <div class="col-8">

    </div>
    <div class="col-4"></div>
</div>
<?php require "includes/footer.php"; ?>

<script>
    $(document).ready(function() {
        $(document).on('submit', function(e) {
            e.preventDefault();
            //alert("form submitted");
            var formdata = $("#comment_data").serialize() + '&submit=submit';
            $.ajax({
                type: 'post',
                url: 'insert-comments.php',
                data: formdata,
                success: function() {
                    //alert("Succes");
                    $("#comment").val(null);
                    $("#username").val(null);
                    $("#post_id").val(null);

                    $("#msg").html("Added Successfully").toggleClass("alert alert-success bg-success text-white ");
                    fetch();
                }
            });
        });

        $("#delete-btn").on('click', function(e) {
            
            e.preventDefault();
            var id = $(this).val();

            $.ajax({
                type: 'post',
                url: 'delete-comment.php',
                data: {
                    delete: 'delete',
                    id: id
                },
                success: function() {
                    //alert(id);
                    $("#delete-msg").html("Delete Successfully").toggleClass("alert alert-danger bg-danger text-white ");
                    fetch();
                }
            });
        });

        function fetch() {
            setInterval(function() {
                $("body").load("show.php?id=<?= $_GET['id'] ?>")
            }, 4000);
        }
    })
</script>