<!-- Link header  -->
<?php
$client = true;
include("header.php");
include_once("main.php");



$query = "SELECT * FROM wilayas ORDER BY nom_wilaya ASC";
$pdostmt = $pdo->prepare($query);
$pdostmt->execute();
$wilayas = $pdostmt->fetchAll(PDO::FETCH_ASSOC);

// var_dump($wilayas);

// update information client 
if (!empty($_POST)) {
    $qeury = "update client set nom=:nom, wilaya_id = :wilaya, telephone=:telephone where id_client=:id";
    $pdostmt = $pdo->prepare($qeury);
    $pdostmt->execute([
        'nom' => $_POST["inputnom"],
        'wilaya' => $_POST["inputVille"],
        'telephone' => $_POST["inputTelephone"],
        'id' => $_POST["myid"]
    ]);
    // //link to page Clients 
    // header("Location:clients.php");
    echo "<script>window.location.href='clients.php';</script>";
    exit;
}
// Select{Affichage } information client 
if (!empty($_GET["id"])) {

    $qeury = "select * from client where id_client =:id";
    $pdostmt = $pdo->prepare($qeury);
    $pdostmt->execute(['id' => $_GET["id"]]);
    while ($row = $pdostmt->fetch(PDO::FETCH_ASSOC)):
?>

        <h1 class="mt-5 m" style="margin-top: 7rem !important">Modifier Client</h1>
        <form class="row g-3" method="post">
            <input type="hidden" name="myid" value=<?php echo $row['id_client'] ?> />
            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Nom</label>
                <input type="text" class="form-control" id="inputnom" name="inputnom" value="<?php echo $row['nom'] ?>" required>
            </div>
            <!-- <div class="col-md-6">
                <label for="inputEmail4" class="form-label">ville</label>
                <input type="text" class="form-control" id="inputVille" name="inputVille" value="<?php echo $row['ville'] ?>" required>
            </div> -->
            <div class="col-md-6">
                <label for="inputPassword4" class="form-label">Telephone</label>
                <input type="text" class="form-control" id="inputTelephone" name="inputTelephone" value="<?php echo $row['telephone'] ?>" required>
            </div>
            <label for="inputVille" class="form-label">Wilaya</label>
            <select class="form-select" name="inputVille" required>
                <option value="">-- Choisir une wilaya --</option>
                <?php foreach ($wilayas as $wilaya): ?>
                    <option value="<?= $wilaya['id_wilaya'] ?>" <?= ($wilaya['id_wilaya'] == $row['wilaya_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($wilaya['nom_wilaya']) ?>
                    </option>
                <?php endforeach; ?>
            </select>


            <div class="col-12">
                <button type="submit" class="btn btn-primary">Modifier</button>
            </div>
        </form>

<?php
    endwhile;
    $pdostmt->closeCursor();
}

?>







<!-- Link footer  -->
<?php include("footer.php") ?>
<script src="/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" class="astro-vvvwv3sm"></script>

<!--cdn -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
<!--cdn -->