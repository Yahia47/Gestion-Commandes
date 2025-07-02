

 <?php
    include("main.php");
    //client
    if (!empty($_GET["id"])) {

        $query = "delete  FROM client WHERE id_client =:id";
        $objstmt = $pdo->prepare($query);
        $objstmt->execute(['id' => $_GET['id']]); // correct spelling: execute
        $objstmt->closeCursor();
        header("Location: clients.php");
    }

    //articles
    if (!empty($_GET["id_art"])) {

        $query = "delete  FROM article WHERE id_article =:id";
        $objstmt = $pdo->prepare($query);
        $objstmt->execute(['id' => $_GET['id_art']]); // correct spelling: execute
        $objstmt->closeCursor();
        header("Location: articles.php");
    }

    //commandes
    if (!empty($_GET["id_cmd"])) {

        $query = "delete FROM ligne_de_commande WHERE id_commande =:id";
        $objstmt = $pdo->prepare($query);
        $objstmt->execute(['id' => $_GET['id_cmd']]); // correct spelling: execute
        $objstmt->closeCursor();
        $query2 = "delete  FROM commande WHERE id_commande =:id";
        $objstmt2 = $pdo->prepare($query2);
        $objstmt2->execute(['id' => $_GET['id_cmd']]); // correct spelling: execute
        $objstmt2->closeCursor();
        header("Location: commandes.php");
    }
    //images
    if (!empty($_GET["id_image"]) && !empty($_GET["id_article"])) {

        $query1 = "select * FROM images WHERE id_image =:id";
        $objstmt1 = $pdo->prepare($query1);
        $objstmt1->execute(['id' => $_GET['id_image']]); // correct spelling: execute
        $row = $objstmt1->fetch(PDO::FETCH_ASSOC);
        unlink($row["chemin"]);  //delete from all chemin fichier and bdd
        $objstmt1->closeCursor();


        $query2 = "delete  FROM images WHERE id_image =:id";
        $objstmt2 = $pdo->prepare($query2);
        $objstmt2->execute(['id' => $_GET['id_image']]); // correct spelling: execute
        $objstmt2->closeCursor();
        header("Location: updateArticle.php?id=" . $_GET["id_article"]);
    }
    ?> 




