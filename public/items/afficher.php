
<?php $niveau="../";?>
<a href="<?php echo $niveau;?>index.php">Retour</a>

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
    	<?php include ($niveau . "liaisons/inc/fragments/entete.inc.php");?>
<body>
<main>
        <h1>Voici les items de la liste - </h1>
<section class="items">
<ul class="liste_item">
            		<li class="item">
						<div class="item__item-contenu">
							<h2 class="item__titre">Item</h2>
						</div>
						<div class="item-actions">
							<a class="listes__edit" href="./modifier.php"><img src="../liaisons/icones/edit.svg">Modifier la liste</a>
							<button class="btn__supprmer" type="button">Supprimer la liste</button>
						</div>
					</li>
</ul>

</section>

<a class="ajout_item" href="./ajouter.php"><img class="item_ajout-plus"src="../liaisons/icones/plus.svg">Ajouter un item</a>

</main>
    	<?php include ($niveau . "liaisons/inc/fragments/pied_de_page.inc.php");?>
</body>