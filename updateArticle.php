<!-- Link header  -->
<?php
$articles = true;
include("header.php");
include_once("main.php");
// update information client 
if (!empty($_POST)) {
    $qeury1 = "update article set description=:description, prix_unitaire=:prix_unitaire where id_article=:id";
    $pdostmt1 = $pdo->prepare($qeury1);
    $pdostmt1->execute([
        'description' => $_POST["inputdes"],
        'prix_unitaire' => $_POST["inputPrix"],
        'id' => $_POST["myid"]
    ]);
    $pdostmt1->closeCursor();
    if (!empty($_FILES)) {
        if (!is_dir("images")) {
            mkdir("images");
        }
        // var_dump($_FILES["inputimg"]);
        // die();
        $total_files = count($_FILES["inputimg"]["name"]);

        for ($i = 0; $i < $total_files; $i++):          # code...

            $extension = pathinfo($_FILES["inputimg"]["name"][$i], PATHINFO_EXTENSION);
            if (!in_array($extension, ["jpg", "jpeg", "png"])) {
                echo "Extension que vous avez choisi n`est pas autorisee!";
            } else {
                $path = "images/" . time() . "_" . $_FILES["inputimg"]["name"][$i];
                $upload = move_uploaded_file($_FILES["inputimg"]["tmp_name"][$i], $path);

                if ($upload) {
                    // $qeury2 = "update images set nom_img =:nom_img,chemin=:chemin,taille_img =:taille_img where id_article =:id_article"; 
                    $qeury2 = "insert into images(nom_img,chemin,taille_img,id_article) values(:nom_img, :chemin, :taille_img, :id)";
                    $pdostmt2 = $pdo->prepare($qeury2);
                    $pdostmt2->execute([
                        'nom_img' => $_FILES["inputimg"]["name"][$i],
                        'chemin' => $path,
                        'taille_img' => $_FILES["inputimg"]["size"][$i],
                        'id' => $_POST["myid"]
                    ]);
                    $pdostmt2->closeCursor();
                    //link to page articles 
                    // header("Location:articles.php");
                } else {
                    echo "transfert KO" . $_FILES["inputimg"]["error"][$i];
                }
            }
        endfor;
    }

    // //link to page articles 
    // header("Location:articles.php");
    echo "<script>window.location.href='articles.php';</script>";
    exit;
}
// Select{Affichage } information client 
if (!empty($_GET["id"])) {

    $qeury1 = "select * from article where id_article =:id";
    $pdostmt1 = $pdo->prepare($qeury1);
    $pdostmt1->execute(['id' => $_GET["id"]]);
    $row1 = $pdostmt1->fetch(PDO::FETCH_ASSOC);

    $qeury2 = "select * from images where id_article=:id";
    $pdostmt2 = $pdo->prepare($qeury2);
    $pdostmt2->execute(['id' => $_GET["id"]]);

?>

    <h1 class="mt-5 m" style="margin-top: 7rem !important">Modifier Article</h1>
    <form class="row g-3" method="post" enctype="multipart/form-data">
        <input type="hidden" name="MAX-FILE-SIZE" value="10000000">
        <input type="hidden" name="myid" value=<?php echo $row1['id_article'] ?> />
        <div class="col-md-6">
            <label for="inputdes" style="margin: 5px;">Description</label>
            <textarea class="form-control" name="inputdes" id="inputdes" required><?php echo $row1['description'] ?></textarea>
        </div>
        <div class="col-md-6">
            <label for="inputPrix" class="form-label">PU</label>
            <input type="text" class="form-control" id="inputPrix" name="inputPrix" value="<?php echo $row1['prix_unitaire'] ?>" required>
        </div>
        <div class="col-md-7">
            <label for="inputimg" class="form-label">Charger vos Images</label>
            <input type="file" class="form-control" id="inputimg" name="inputimg[]" multiple>
            <p style="color: #ccc; font-size: 13px;">PNG ,JPEG JPG</p>
        </div>
        <div class="col-md-5">
            <?php while ($row2 = $pdostmt2->fetch(PDO::FETCH_ASSOC)): ?>
                <a href="Delete.php?id_article=<?php echo $row2["id_article"] ?>&id_image=<?php echo $row2['id_image'] ?>" class="btn btn-outline-danger" style="position: absolute;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z" />
                    </svg>
                </a>
                <img src="<?php echo $row2['chemin'] ?>" class="img-fluid" height="200" width="200" />

            <?php endwhile; ?>

        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Modifier</button>
        </div>
    </form>

<?php

    $pdostmt1->closeCursor();
    $pdostmt2->closeCursor();
}

?>







<!-- Link footer  -->
<?php include("footer.php") ?>
<!-- <script src="/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" class="astro-vvvwv3sm"></script> -->


<!--cdn -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
<!--cdn -->