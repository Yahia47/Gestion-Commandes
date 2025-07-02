<!-- Link header  -->
<?php
$client = true;
include("header.php");
include_once("main.php");
// wilayas sql 
$query = "SELECT * FROM wilayas ORDER BY nom_wilaya ASC";
$pdostmt = $pdo->prepare($query);
$pdostmt->execute();
$wilayas = $pdostmt->fetchAll(PDO::FETCH_ASSOC);

// var_dump($wilayas);

if (!empty($_POST["inputnom"]) && !empty($_POST["inputVille"]) && !empty($_POST["inputTelephone"])) {

    $qeury = "insert into client(nom,wilaya_id,telephone) values(:nom, :wilaya, :telephone)";
    $pdostmt = $pdo->prepare($qeury);
    $pdostmt->execute([
        'nom' => $_POST["inputnom"],
        'wilaya' => $_POST["inputVille"],
        'telephone' => $_POST["inputTelephone"]
    ]);
    $pdostmt->closeCursor();
    //link to page Clients 
    header("Location:clients.php");
}

?>


<h1 class="mt-5 m" style="margin-top: 7rem !important">Ajouter un Client</h1>
<form class="row g-3" method="post">
    <div class="col-md-6">
        <label for="inputEmail4" class="form-label">Nom</label>
        <input type="text" class="form-control" id="inputnom" name="inputnom" required>
    </div>
    <!-- <div class="col-md-6">
        <label for="inputEmail4" class="form-label">ville</label>
        <input type="text" class="form-control" id="inputEmail" name="inputEmail" required>
    </div> -->
    <div class="col-md-6">
        <label for="inputPassword4" class="form-label">Telephone</label>
        <input type="text" class="form-control" id="inputTelephone" name="inputTelephone" required>
    </div>
    <label for="inputVille" class="form-label">Wilaya</label>
    <select class="form-select" name="inputVille" required>
        <option value="">-- Choisir une wilaya --</option>
        <?php foreach ($wilayas as $wilaya): ?>
            <option value="<?= $wilaya['id_wilaya'] ?>">
                <?= htmlspecialchars($wilaya['nom_wilaya']) ?>
            </option>
        <?php endforeach; ?>
    </select>
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