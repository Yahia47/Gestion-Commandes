<!-- Link header  -->
<?php
$index = true;
include("header.php");
include_once("main.php");
$qeury = "select id_client from client";
$objstmt = $pdo->prepare($qeury);
$objstmt->execute();

$qeury2 = "select id_article from article";
$objstmt2 = $pdo->prepare($qeury2);
$objstmt2->execute();


if ($_POST) {
    //link to page Acceuil 
    header("Location:index.php");
}

// Select and display Commandes information
if (!empty($_GET["id"])) {
    $qeury = "
    SELECT 
        c.*, 
        lc.id_article, 
        lc.quantite, 
        cl.nom, 
        cl.telephone, 
        cl.ville,
        w.nom_wilaya
    FROM commande c
    JOIN client cl ON c.id_client = cl.id_client
    JOIN wilayas w ON cl.wilaya_id = w.id_wilaya
    JOIN ligne_de_commande lc ON lc.id_commande = c.id_commande
    WHERE c.id_commande = :id
";
    $pdostmt = $pdo->prepare($qeury);
    $pdostmt->execute(['id' => $_GET["id"]]);
    $row = $pdostmt->fetch(PDO::FETCH_ASSOC);

    $qeury_views = 'update commande set vues =:vues where id_commande =:id';
    $objstmt_views = $pdo->prepare($qeury_views);
    $objstmt_views->execute([
        'id' => $row['id_commande'],
        "vues" => $row["vues"] + 1
    ]);
    $qeury_views_Select = "select * from commande where id_commande = :id";
    $objstmt_views_select = $pdo->prepare($qeury_views_Select);
    $objstmt_views_select->execute([
        'id' => $row['id_commande']
    ]);
    $row_selected = $objstmt_views_select->fetch(PDO::FETCH_ASSOC);
?>
    <div style="float:right; color:blue">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
        </svg>
        <?php echo $row_selected['vues'] ?>
    </div>
    <h1 class="mt-5 m" style="margin-top: 7rem !important">Details de la Commande</h1>
    <form class="row g-3" method="get">

        <div class="col-md-6">
            <label for="inputidCL" style="margin: 5px;">ID Client</label>
            <select class="form-control" name="inputidCL" disabled>
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
            <label for="inputdate" class="form-label">Nom</label>
            <input type="text" class="form-control" id="inputdate" name="inputdate" value="<?php echo $row['nom'] ?>" disabled>
        </div>
        <div class="col-md-6">
            <label for="inputdate" class="form-label">Telephone</label>
            <input type="text" class="form-control" id="inputdate" name="inputdate" value="<?php echo $row['telephone'] ?>" disabled>
        </div>
        <div class="col-md-6">
            <label for="inputdate" class="form-label">Ville</label>
            <input type="text" class="form-control" id="inputdate" name="inputdate" value="<?php echo $row['nom_wilaya'] ?>" disabled>
        </div>
        <div class="col-md-6">
            <label for="inputdate" class="form-label">Date</label>
            <input type="Date" class="form-control" id="inputdate" name="inputdate" value="<?php echo $row['date_commande'] ?>" disabled>
        </div>
        <div class="col-md-6">
            <label for="inputarticle" class="form-label">Article</label>
            <select class="form-control" name="inputarticle" disabled>
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
            <input type="text" class="form-control" id="inputqte" name="inputqte" value="<?php echo $row['quantite'] ?>" disabled>
        </div>

        <div class="col-12">
            <a href="index.php" class="btn btn-primary">Fermer</a>
        </div>
    </form>

<?php
    $objstmt->closeCursor();
    $objstmt2->closeCursor();
    $objstmt_views->closeCursor();
    $objstmt_views_select->closeCursor();
}
include("footer.php")

?>
<!--cdn -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
<!--cdn -->
<script src="/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" class="astro-vvvwv3sm"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>