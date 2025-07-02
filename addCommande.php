<!-- Link header  -->
<?php
$commande = true;
include("header.php");
include_once("main.php");
$qeury = "select id_client from client";
$objstmt = $pdo->prepare($qeury);
$objstmt->execute();

$qeury2 = "select id_article from article";
$objstmt2 = $pdo->prepare($qeury2);
$objstmt2->execute();


if (!empty($_POST["inputidCL"]) && !empty($_POST["inputdate"])) {

    $qeury = "insert into commande(id_client,date_commande) values(:id_client, :date_commande)";
    $pdostmt = $pdo->prepare($qeury);
    $pdostmt->execute([
        'id_client' => $_POST["inputidCL"],
        'date_commande' => $_POST["inputdate"],
    ]);
    $idcmd = $pdo->lastInsertId();
    $qeury2 = "insert into ligne_de_commande(id_article,id_commande,quantite) values(:id_article, :id_commande, :quantite)";
    $pdostmt = $pdo->prepare($qeury2);
    $pdostmt->execute([
        'id_article' => $_POST["inputarticle"],
        'id_commande' => $idcmd,
        'quantite' => $_POST["inputqte"]
    ]);
    $pdostmt->closeCursor();
    //link to page commandes 
    header("Location:commandes.php");
}

?>


<h1 class="mt-5 m" style="margin-top: 7rem !important">Ajouter un Commande</h1>
<form class="row g-3" method="post">
    <div class="col-md-6">
        <label for="inputidCL" style="margin: 5px;">ID Client</label>
        <select class="form-control" name="inputidCL" required>
            <?php
            foreach ($objstmt->fetchAll(PDO::FETCH_NUM) as $tab) {
                foreach ($tab as $elements) {
                    echo  "<option value =" . $elements . ">" . $elements . "</option> ";
                }
            }

            ?>
        </select>
    </div>
    <div class="col-md-6">
        <label for="inputdate" class="form-label">Date</label>
        <input type="date" class="form-control" id="inputdate" name="inputdate" required>
    </div>
    <div class="col-md-6">
        <label for="inputarticle" class="form-label">Article</label>
        <select class="form-control" name="inputarticle" required>
            <?php
            foreach ($objstmt2->fetchAll(PDO::FETCH_NUM) as $tab) {
                foreach ($tab as $elements) {
                    echo  "<option value =" . $elements . ">" . $elements . "</option> ";
                }
            }

            ?>
        </select>
    </div>
    <div class="col-md-6">
        <label for="inputqte" class="form-label">Quantite</label>
        <input type="text" class="form-control" id="inputqte" name="inputqte" required>
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