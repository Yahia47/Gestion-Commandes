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


if (!empty($_POST["inputidCL"]) && !empty($_POST["inputdate"]) && !empty($_POST["inputarticle"]) && !empty($_POST["inputqte"])) {

    $qeury = "update commande set id_client = :id_client, date_commande = :date_commande where id_commande = :id";
    $pdostmt = $pdo->prepare($qeury);
    $pdostmt->execute([
        'id_client' => $_POST["inputidCL"],
        'date_commande' => $_POST["inputdate"],
        'id' => $_POST["myid"]
    ]);

    $qeury2 = "update ligne_de_commande set id_article = :id_article, quantite = :quantite where id_commande = :id_commande";
    $pdostmt2 = $pdo->prepare($qeury2);
    $pdostmt2->execute([
        'id_article' => $_POST["inputarticle"],
        'id_commande' => $_POST["myid"],
        'quantite' => $_POST["inputqte"]
    ]);
    $pdostmt->closeCursor();
    //link to page commandes 
    header("Location:commandes.php");
}

// Select and display Commandes information
if (!empty($_GET["id"])) {
    $qeury = "select c.*, lc.id_article, lc.quantite from commande c left join ligne_de_commande lc on lc.id_commande = c.id_commande where c.id_commande = :id";
    $pdostmt = $pdo->prepare($qeury);
    $pdostmt->execute(['id' => $_GET["id"]]);
    $row = $pdostmt->fetch(PDO::FETCH_ASSOC);
?>

    <h1 class="mt-5 m" style="margin-top: 7rem !important">Modifier une Commande</h1>
    <form class="row g-3" method="post">
        <input type="hidden" name="myid" value="<?php echo $row['id_commande'] ?>" />
        <div class="col-md-6">
            <label for="inputidCL" style="margin: 5px;">ID Client</label>
            <select class="form-control" name="inputidCL" required>
                <?php
                foreach ($objstmt->fetchAll(PDO::FETCH_NUM) as $tab) {
                    foreach ($tab as $elements) {
                        if ($row["id_client"] == $elements) {
                            $selected = "selected";
                        } else {
                            $selected = "";
                        }
                        echo  "<option value =" . $elements . " " . $selected . ">" . $elements . "</option> ";
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-md-6">
            <label for="inputdate" class="form-label">Date</label>
            <input type="date" class="form-control" id="inputdate" name="inputdate" value="<?php echo $row['date_commande'] ?>" required>
        </div>
        <div class="col-md-6">
            <label for="inputarticle" class="form-label">Article</label>
            <select class="form-control" name="inputarticle" required>
                <?php
                foreach ($objstmt2->fetchAll(PDO::FETCH_NUM) as $tab) {
                    foreach ($tab as $elements) {
                        if ($row["id_article"] == $elements) {
                            $selected = "selected";
                        } else {
                            $selected = "";
                        }
                        echo  "<option value =" . $elements . " " . $selected . ">" . $elements . "</option> ";
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-md-6">
            <label for="inputqte" class="form-label">Quantite</label>
            <input type="text" class="form-control" id="inputqte" name="inputqte" value="<?php echo $row['quantite'] ?>" required>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Modifier</button>
        </div>
    </form>

<?php
    $pdostmt->closeCursor();
}
?>

<!-- Link footer  -->
<?php include("footer.php") ?>

<!--cdn -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
<!--cdn -->