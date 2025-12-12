	<?php $niveau="../";
    
    
$strFichierTexte=file_get_contents($niveau."liaisons/js/objJSONMessages.json");
$jsonMessages=json_decode($strFichierTexte);

?>

    

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

$strRequeteListe = 'SELECT 
    listes.id AS liste_id,
    listes.nom AS nom_liste,
    listes.couleur_id,
    couleurs.hexadecimal 
FROM listes 
INNER JOIN couleurs ON listes.couleur_id = couleurs.id 
WHERE listes.id = :id';

$pdosResultat = $pdoConnexion->prepare($strRequeteListe);
$pdosResultat->bindParam(':id', $strIdListe);


$pdosResultat->execute();

$arrListe = $pdosResultat->fetch();
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

if (isset($_GET["btn_supprimer"]) && isset($_GET["id_item"])) {

$strIdItems = $_GET['id_item'];
           
$strRequete = 'DELETE FROM items WHERE id=:id';



$pdosResultat = $pdoConnexion->prepare($strRequete);

$pdosResultat->bindParam(':id', $strIdItems);

$pdosResultat->execute();

$pdosResultat ->closecursor();

header("Location: afficher.php?liste_id=" . $strIdListe . "&strCodeOperation=item_supprimee");
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
</head>
<body>
        <?php include ($niveau . "liaisons/inc/fragments/entete.inc.php");?>
    <div class="page-layout">
    <?php include ($niveau . "liaisons/inc/fragments/sidebar.inc.php");?>
<main class="conteneur">
	<a class="lien" href="<?php echo $niveau;?>index.php">Retour</a>

<div class="conteneur">

	<div id="contenu" class="conteneur">
			<?php if(isset($_GET["strCodeOperation"])) {
			if ($_GET["strCodeOperation"] == "item_modifiee") {
				echo "<p style='color: green'>" . $jsonMessages->retroactions->item->modifier . "</p>";
			} 
			if ($_GET["strCodeOperation"] == "item_ajoutee") {
				echo "<p style='color: green'>" . $jsonMessages->retroactions->item->ajouter . "</p>";
			}
			if ($_GET["strCodeOperation"] == "item_supprimee") {
				echo "<p style='color: green'>" . $jsonMessages->retroactions->item->supprimer . "</p>";
			}
        	} ?>
</div>


	<h1><?php echo $arrListe['nom_liste']?></h1>


<section class="items">
	<div class="due__cards">
					<ul class="due__list">
						 <?php for($cpt=0;$cpt<count($arrItems);$cpt++){ ?>
						<li class="due__item" style="--couleur-tour: <?php echo "#".$arrListe['hexadecimal']; ?>;">
							<div class="due__item-contenu">
								<div class="due__card-checkbox-container">
								<h2 class="due__card-titre"><?php echo $arrItems[$cpt]['nom'] ?></h2>
								</div>
								<p class="due__card-date"><?php echo "Date d'écheance : " . $arrItems[$cpt]['echeance'] ?></p>
							</div>
							<div class="due__item-actions">
	
					<a class="listes__edit modif_item"  href="./modifier.php?liste_id=<?php echo $strIdListe; ?>&id=<?php echo $arrItems[$cpt]['id']; ?>">Modifier l'item</a>

    <input type="hidden" name="liste_id" value="<?php echo $strIdListe; ?>">
    <input type="hidden" name="id" value="<?php echo $arrItems[$cpt]['id']; ?>">

<a href="afficher.php?liste_id=<?php echo $strIdListe; ?>&id_item=<?php echo $arrItems[$cpt]['id']; ?>&nom_item=<?php echo $arrItems[$cpt]['nom']; ?>&nom_liste=<?php echo $arrListe['nom_liste']; ?>#modale1" class="btn__supprimer">Supprimer l'item</a>
    
<form action="afficher.php" method="get">
    <input type="hidden" name="liste_id" value="<?php echo $strIdListe; ?>">
    <input type="hidden" name="id" value="<?php echo $arrItems[$cpt]['id']; ?>">
    <input type="hidden" name="etat" value="<?php echo $arrItems[$cpt]['est_complete']; ?>">

    <?php if ($arrItems[$cpt]['est_complete'] == 1) { ?>
        <input type="submit" class="btn-completer btn-done" name="btn_completer" value="Complété">
    <?php } else { ?>
        <input type="submit" class="btn-completer btn-todo" name="btn_completer" value="À Compléter">
    <?php } ?>
</form>
							</div>
						</li>
						     <?php  } ?>
					</ul>
				</div>
</section>
<a class="listes__ajouter-item" href="<?php echo './ajouter.php?liste_id=' . $strIdListe; ?>">
    <span class="ajouter-item__icone">
        <img class="ajouter-item__svg" src="<?php echo $niveau ?>liaisons/icones/plus2.svg" alt="">
    </span>
    AJOUTER UN ITEM
</a>
</div>
<br>
</main>
</div>
<footer>
    	<?php include ($niveau . "liaisons/inc/fragments/pied_de_page.inc.php");?>
</footer>

<div id="modale1" class="boiteModale">
    <div class="boiteModale__dialogue">
        <div class="boiteModale__fenetre">
            <header class="boiteModale__entete">
                <a href="#" class="btn btn--fermer fermer-modale">Fermer</a>
            </header>

            <div class="boiteModale__contenu">
                <p>
                    Voulez-vous vraiment supprimer l'item 
                    <strong id="modale-nom-item"></strong>
                    de la liste 
                    <span id="modale-nom-liste"></span> ?
                </p>
            </div>

            <footer class="boiteModale__actions">
          <form action="afficher.php" method="GET">
    
    <input type="hidden" name="liste_id" value="<?php echo $_GET['liste_id']; ?>">
    <input type="hidden" name="id_item" value="<?php echo $_GET['id_item']; ?>">
    <input type="hidden" name="nom_item" value="<?php echo $_GET['nom_item']; ?>">
    <input type="hidden" name="nom_liste" value="<?php echo $_GET['nom_liste']; ?>">
    <a href="afficher.php?liste_id=<?php echo $strIdListe; ?>" class="btn">Annuler</a>
    <input class="btn btn--danger" type="submit" value="Supprimer" name="btn_supprimer">
</form>
            </footer>
        </div>
    </div>
</div>

<script src="<?php echo $niveau; ?>liaisons/js/menu-lateral.js"></script>
</body>
</html>