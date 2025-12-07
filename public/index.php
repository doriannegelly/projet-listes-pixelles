<?php $niveau="./";
include ($niveau . "liaisons/inc/config.inc.php");

error_reporting(E_ALL);

$strFichierTexte=file_get_contents($niveau."liaisons/js/objJSONMessages.json");
$jsonMessages=json_decode($strFichierTexte);

$id_utilisateur = 1;
// LISTES 

// Établissement de la chaine de requête SQL
$strRequeteListes = "SELECT listes.id AS id, couleur_id, nom, hexadecimal, utilisateur_id, hex_bordure FROM listes INNER JOIN couleurs ON listes.couleur_id = couleurs.id WHERE utilisateur_id = :id_utilisateur ORDER BY nom ASC";

//Exécution de la requête
$pdosResultat = $pdoConnexion->prepare($strRequeteListes);

//Liaison de valeur
$pdosResultat->bindValue(":id_utilisateur", $id_utilisateur);

$pdosResultat->execute();

//Extraction de l'enregistrements de la BD
$arrListes=array();
for($cptEnr=0;$ligne=$pdosResultat->fetch();$cptEnr ++){
    $arrListes[$cptEnr]['id']=$ligne['id'];
    $arrListes[$cptEnr]['couleur_id']=$ligne['couleur_id'];
    $arrListes[$cptEnr]['nom']=$ligne['nom'];
	$arrListes[$cptEnr]['hexadecimal']=$ligne['hexadecimal'];
	$arrListes[$cptEnr]['hex_bordure']=$ligne['hex_bordure'];

	// Récupération du nombre d'items par liste
	$strRequeteItems = "SELECT id FROM items WHERE liste_id = :id_liste";
	$pdosItems = $pdoConnexion->prepare($strRequeteItems);
	$pdosItems->bindValue(':id_liste', $arrListes[$cptEnr]['id']);
	$pdosItems->execute();

	$arrListes[$cptEnr]['nombre_items']=$pdosItems->rowCount();
	$pdosItems->closeCursor();
}
$pdosResultat ->closecursor();

// À ÉCHÉANCE
$strRequeteDue = "SELECT items.nom AS nom_items, listes.id AS id_listes, echeance, hexadecimal FROM listes INNER JOIN items ON listes.id = items.liste_id INNER JOIN couleurs ON listes.couleur_id = couleurs.id WHERE echeance IS NOT NULL AND est_complete = 0 ORDER BY echeance ASC LIMIT 3";
$pdosResultat = $pdoConnexion->prepare($strRequeteDue);
$pdosResultat->execute();

$arrDue = array();
for($cptEnr=0;$ligne=$pdosResultat->fetch();$cptEnr ++){
	$arrDue[$cptEnr]['nom_items']=$ligne['nom_items'];
	$arrDue[$cptEnr]['echeance']=$ligne['echeance'];
	$arrDue[$cptEnr]['hexadecimal']=$ligne['hexadecimal'];
}
$pdosResultat ->closecursor();

if (isset($_GET['btn_supprimer'])) {
	$id_liste = $_GET['id'];
    //Établissement de la chaine de requête suppression
    $strRequete = "DELETE FROM listes WHERE id=:id_liste";
    //Exécution de la requêtre
    $pdosResultat = $pdoConnexion->prepare($strRequete);
    //$pdosResultat = $pdoConnexion->query($strRequete);
    //Binder le paramètre :id_participant avec la variable $id
    $pdosResultat->bindParam(':id_liste', $id_liste);

	$pdosResultat->execute();

    $pdosResultat->closeCursor();
    var_dump($pdoConnexion->errorInfo());
    //Récuperation du code d'erreur
    $strCodeErreur = $pdoConnexion->errorCode();
	header("Location: index.php?strCodeOperation=liste_supprimee");
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
	<title>Un beau titre ici!</title>
	<?php include ($niveau . "liaisons/inc/fragments/head_links.inc.php");?>
</head>

<body>

	<?php include ($niveau . "liaisons/inc/fragments/entete.inc.php");?>

	<main>
		
		<div id="contenu" class="conteneur">
			<?php if(isset($_GET["strCodeOperation"])) {
			if ($_GET["strCodeOperation"] == "liste_modifiee") {
				echo "<p style='color: green'>" . $jsonMessages->retroactions->liste->modifier . "</p>";
			} 
			if ($_GET["strCodeOperation"] == "liste_ajoutee") {
				echo "<p style='color: green'>" . $jsonMessages->retroactions->liste->ajouter . "</p>";
			}
			if ($_GET["strCodeOperation"] == "liste_supprimee") {
				echo "<p style='color: green'>" . $jsonMessages->retroactions->liste->supprimer . "</p>";
			}
        	} ?>

			<!-- À échéance -->
			<section class="due">
				<h1 class="due__titre">À échéance</h1>

				<div class="due__cards">
					<ul class="due__list">
						<li class="due__item">
							<div class="due__item-contenu">
								<div class="due__card-checkbox-container">
								<input class=due__card-checkbox type="checkbox">
								<h2 class="due__card-titre">Titre de la tâche</h2>
								</div>
								<p class="due__card-date">Date d'échéance: 1er juillet 2025</p>
							</div>
							<div class="due__item-actions">
								<a class="due__item-editer" href="#">Éditer Item</a>
								<button class="btn__supprimer" type="button">Supprimer l'item</button>
							</div>
						</li>
						<li class="due__item">
							<div class="due__item-contenu">
								<div class="due__card-checkbox-container">
								<input class=due__card-checkbox type="checkbox">
								<h2 class="due__card-titre">Titre de la tâche</h2>
								</div>
								<p class="due__card-date">Date d'échéance: 1er juillet 2025</p>
							</div>
							<div class="due__item-actions">
								<a class="due__item-editer" href="#">Éditer Item</a>
								<button class="btn__supprimer" type="button">Supprimer l'item</button>
							</div>
						</li>
						<li class="due__item">
							<div class="due__item-contenu">
								<div class="due__card-checkbox-container">
								<input class=due__card-checkbox type="checkbox">
								<h2 class="due__card-titre">Titre de la tâche</h2>
								</div>
								<p class="due__card-date">Date d'échéance: 1er juillet 2025</p>
							</div>
							<div class="due__item-actions">
								<a class="due__item-editer" href="#">Éditer Item</a>
								<button class="btn__supprimer" type="button">Supprimer l'item</button>
							</div>
						</li>
					</ul>
				</div>
			</section>

			<!-- Listes -->
			<section class="listes">
				<h1 class="listes__titre">Listes</h1>
				<div class="listes__controls">
					<button class="listes__filtre" type="button">Filtrer <img class="listes__icone-filtre" src="<?php echo $niveau ?>liaisons/icones/chevronNoir.svg" alt="Icone filtre"></button>
				</div>
				<ul class="listes__list">
				<?php for($cpt=0; $cpt<count($arrListes); $cpt++){ ?>			
					<li class="listes__item" style="--couleur-principale: <?php echo "#".$arrListes[$cpt]['hexadecimal']; ?>;   --couleur-bordure: <?php echo "#".$arrListes[$cpt]['hex_bordure']; ?>">
						<div class=listes__item-contenu>
							<h2 class="list__titre"><?php echo $arrListes[$cpt]['nom']; ?></h2>
							<p class="listes__item-count"><?php echo $arrListes[$cpt]["nombre_items"]; ?> items dans la liste</p>
						</div>
						<div class="listes__item-actions">
						<form action="index.php" method="GET">
							<div>
        		    			<input type="hidden" name="id" value="<?php echo $arrListes[$cpt]['id']; ?>">
        					</div>
							<a class="listes__view" href="items/afficher.php?id_liste=<?php echo $arrListes[$cpt]['id']; ?>">Consulter la liste<img class="listes__icone-view" src="<?php echo $niveau ?>liaisons/icones/fleche.svg" alt="Icone voir"></a>
							<div class="actions__spacer">
							<a class="listes__edit" href="listes/modifier.php?id_liste=<?php echo $arrListes[$cpt]['id']; ?>">Modifier la liste</a>
							<input class="btn__supprimer" type="submit" value="Supprimer" name="btn_supprimer"><br>
							</div>
						</form>
						</div>
					</li>
				<?php } ?>	
				</ul>
				<a class="listes__ajouter-item" href="listes/ajouter.php">
					<span class="ajouter-item__icone">
						<img class="ajouter-item__svg" src="<?php echo $niveau ?>liaisons/icones/plus2.svg" alt="">
					</span>
					AJOUTER UNE LISTE
				</a>

			</section>
	</main>
	
	<!--<aside>
        <h3>Barre latérale</h3>
        <p>
        	Lorem ipsum dolor nunc aut nunquam sit amet, consectetur adipiscing elit. Vivamus at est eros, vel fringilla urna. Pellentesque odio rhoncus
        </p>
	</aside>!-->
	
	
	<?php include ($niveau . "liaisons/inc/fragments/pied_de_page.inc.php");?>
</body>
</html>
