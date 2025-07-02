<!-- Link header  -->
<?php
$articles = true;
include("header.php");
include_once("main.php");



if (!empty($_FILES["inputimg"]["size"]) && ($_POST["inputdes"]) && !empty($_POST["inputPrix"]) && $_FILES["inputimg"]["size"] < $_POST["MAX-FILE-SIZE"]) {

    if (!is_dir("images")) {
        mkdir("images");
    }
    $extension = pathinfo($_FILES["inputimg"]["name"], PATHINFO_EXTENSION);
    if (!in_array($extension, ["jpg", "jpeg", "png"])) {
        # code...
        echo "Extension que vous avez choisi n`est pas autorisee!";
    } else {
        $path = "images/" . time() . "_" . $_FILES["inputimg"]["name"];
        $upload = move_uploaded_file($_FILES["inputimg"]["tmp_name"], $path);

        if ($upload) {

            $qeury1 = "insert into article(description,prix_unitaire) values(:description, :prix_unitaire)";
            $pdostmt1 = $pdo->prepare($qeury1);
            $pdostmt1->execute([
                'description' => $_POST["inputdes"],
                'prix_unitaire' => $_POST["inputPrix"],
            ]);
            $id_article = $pdo->lastInsertId();


            $qeury2 = "insert into images(nom_img,chemin,taille_img,id_article) values(:nom_img, :chemin, :taille_img, :id_article)";
            $pdostmt2 = $pdo->prepare($qeury2);
            $pdostmt2->execute([
                'nom_img' => $_FILES["inputimg"]["name"],
                'chemin' => "images/" . $path,
                'taille_img' => $_FILES["inputimg"]["size"],
                'id_article' => $id_article
            ]);
            $pdostmt1->closeCursor();
            $pdostmt2->closeCursor();
            //link to page articles 
            header("Location:articles.php");
        } else {
            echo "transfert KO" . $_FILES["inputimg"]["error"];
        }
    }
}

?>


<h1 class="mt-5 m" style="margin-top: 7rem !important">Ajouter un article</h1>
<form class="row g-3" method="post" enctype="multipart/form-data">
    <input type="hidden" name="MAX-FILE-SIZE" value="10000000">
    <div class="col-md-6">
        <label for="inputdes" style="margin: 5px;">Description</label>
        <textarea class="form-control" placeholder="mettre la description" name="inputdes" id="inputdes" required></textarea>
    </div>
    <div class="col-md-6">
        <label for="inputPrix" class="form-label">PU</label>
        <input type="text" class="form-control" id="inputPrix" name="inputPrix" required>
    </div>
    <div class="col-md-12">
        <label for="inputimg" class="form-label">Charger vos Images</label>
        <input type="file" class="form-control" id="inputimg" name="inputimg" required>
        <p style="color: #ccc; font-size: 13px;">PNG ,JPEG JPG</p>
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </div>
</form>









<!-- Link footer  -->
<?php include("footer.php") ?>
<!-- <script src="/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" class="astro-vvvwv3sm"></script> -->


<!--cdn -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
<!--cdn -->