	<?php $niveau="../";?>

<?php
include($niveau . "liaisons/inc/config.inc.php");

if(isset($_GET["liste_id"]))
    {
        $strIdListe=$_GET["liste_id"];
    }

    if(isset($_GET["id"]))
    {
        $strIdItems=$_GET["id"];
    }


	//Établissement de la chaine de requête pour les items 
	$strRequete =  'SELECT id, nom, echeance, est_complete, liste_id FROM items
    WHERE liste_id=:liste_id';

	//Exécution de la requête
	$pdosResultat = $pdoConnexion->prepare($strRequete);

    $pdosResultat->bindParam(':liste_id',$strIdListe);
    $pdosResultat->execute();

    //Affichage des erreurs SQL
    var_dump($pdoConnexion->errorInfo());

	//Extraction de l'enregistrements de la BD
   $arrItems=array();
    for($cpt= 0; $ligne = $pdosResultat->fetch(); $cpt ++){
        $arrItems[$cpt]['id'] = $ligne['id'];
        $arrItems[$cpt]['nom'] = $ligne['nom'];
        $arrItems[$cpt]['echeance'] = $ligne['echeance'];
        $arrItems[$cpt]['est_complete'] = $ligne['est_complete'];
    }

    $pdosResultat ->closecursor();
    
// Requete pour le nom de la liste

$strRequeteListe = 'SELECT id, nom, couleur_id FROM listes WHERE id=:id';

$pdosResultat = $pdoConnexion->prepare($strRequeteListe);
$pdosResultat->bindParam(':id', $strIdListe);
$pdosResultat->execute();

$arrListes = $pdosResultat->fetch();
// var_dump(['liste_id' => $strIdListe, 'item_id' => $strIdItems]);
// die;

$pdosResultat ->closecursor();

// État compléter
if (isset($_GET["btn_completer"]) && isset($_GET["id"]) && isset($_GET["etat"])) {

if ($_GET["etat"] == 1) {
    $nouvelEtat = 0;
} else {
    $nouvelEtat = 1;
}
    $strRequete = 'UPDATE items SET est_complete = :etat WHERE id = :id';

    $pdosResultat = $pdoConnexion->prepare($strRequete);

    $pdosResultat->bindParam(':id', $strIdItems);
    $pdosResultat->bindParam(':etat', $nouvelEtat);

    $pdosResultat->execute();
    $pdosResultat->closeCursor();


    header("Location: afficher.php?liste_id=" . $strIdListe);
    exit();
}


// Delete

if (isset($_GET["btn_supprimer"]) && isset($_GET["id"])) {


$strRequete = 'DELETE FROM items WHERE id=:id';

$pdosResultat = $pdoConnexion->prepare($strRequete);

$pdosResultat->bindParam(':id', $strIdItems);

$pdosResultat->execute();

$pdosResultat ->closecursor();

  header("Location: afficher.php?liste_id=" . $strIdListe);
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="keyword" content="">
	<meta name="author" content="">
	<meta charset="utf-8">
	<title>Afficher les items d'une liste- Alice</title>
	<?php include ($niveau . "liaisons/inc/fragments/head_links.inc.php");?>
    
    	<?php include ($niveau . "liaisons/inc/fragments/entete.inc.php");?>
<body>
<main>
	<a href="<?php echo $niveau;?>index.php">Retour</a>

 <div class="conteneur_menu">
        <nav class="menu menu--ferme">
            <ul class="menu__liste">
                <li class="menu__listeItem"><a href="../index.php" class="menu__lien"><img class="item_ajout-plus"src="../liaisons/icones/maison.svg">Accueil</a></li>
				<li class="menu__listeItem"><a class="ajout_item menu__lien" href="../listes/ajouter.php"><img class="item_ajout-plus"src="../liaisons/icones/plus.svg">Ajouter une liste</a></li>
  <li class="menu__listeItem"><span class="menu__lien">Mes listes</span>
	<hr class="ligne"></li>
                <li class="menu__listeItem"><a href="#" class="menu__lien">Liste</a></li>
                <li class="menu__listeItem"><a href="#" class="menu__lien">Liste</a></li>
            </ul>
        </nav>
    </div>

<div class="conteneur">
	<h1><?php echo $arrListes['nom'] . ' ' . $arrListes['couleur_id'];?> </h1>


<section class="items">
	<div class="due__cards">
					<ul class="due__list">
						 <?php for($cpt=0;$cpt<count($arrItems);$cpt++){ ?>
						<li class="due__item">
							<div class="due__item-contenu">
								<div class="due__card-checkbox-container">
								<h2 class="due__card-titre"><?php echo $arrItems[$cpt]['nom'] ?></h2>
								</div>
								<p class="due__card-date"><?php echo $arrItems[$cpt]['echeance'] ?></p>
							</div>
							<div class="due__item-actions">
							<?php echo $arrItems[$cpt]['est_complete'] ?>
					<a class="modif_item" href="./modifier.php?liste_id=<?php echo $strIdListe; ?>&id=<?php echo $arrItems[$cpt]['id']; ?>">Modifier l'item</a>
<form action="afficher.php" method="get">
    <input type="hidden" name="liste_id" value="<?php echo $strIdListe; ?>">
    <input type="hidden" name="id" value="<?php echo $arrItems[$cpt]['id']; ?>">
    <input  class="btn__supprimer" type="submit" name="btn_supprimer" value="Supprimer l'item">
</form> 
<form action="afficher.php" method="get">
    <input type="hidden" name="liste_id" value="<?php echo $strIdListe; ?>">
    <input type="hidden" name="id" value="<?php echo $arrItems[$cpt]['id']; ?>">
    <input type="hidden" name="etat" value="<?php echo $arrItems[$cpt]['est_complete']; ?>">

    <?php if ($arrItems[$cpt]['est_complete'] == 1) { ?>
        <input type="submit" name="btn_completer" value="À compléter">
    <?php } else { ?>
        <input type="submit" name="btn_completer" value="Compléter">
    <?php } ?>
</form>
							</div>
						</li>
						     <?php  } ?>
					</ul>
				</div>
</section>
<br>
 <?php 
?>
					<span class="ajouter-item__icone">
						<img class="ajouter-item__svg" src="<?php echo $niveau ?>liaisons/icones/plus2.svg" alt="">
					</span>
 <?php 
 echo "<a href='./ajouter.php?liste_id=" . $strIdListe . "'>Ajouter un item</a>";
?>
</div>
</main>
<footer>
    	<?php include ($niveau . "liaisons/inc/fragments/pied_de_page.inc.php");?>
</footer>
<script src="../liaisons/js/_menu.js"></script>
 <script>  document.body.classList.add('js');
 </script>
</body>
<html>