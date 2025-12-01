	<?php $niveau="../";?>
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

 <div class="conteneur">
        <nav class="menu menu--ferme">
            <ul class="menu__liste">
                <li class="menu__listeItem"><a href="#" class="menu__lien">Accueil</a></li>
				<li class="menu__listeItem"><a class="ajout_item" href="./ajouter.php"><img class="item_ajout-plus"src="../liaisons/icones/plus.svg">Ajouter un item</a></li>
				<span> Les listes </span>
									<hr class="ligne">
                <li class="menu__listeItem"><a href="#" class="menu__lien">Liste</a></li>
                <li class="menu__listeItem"><a href="#" class="menu__lien">Liste</a></li>
            </ul>
        </nav>
    </div>


        <h1>Items de la liste</h1>


<section class="items">
	<div class="due__cards">
					<ul class="due__list">
						<li class="due__item">
							<div class="due__item-contenu">
								<div class="due__card-checkbox-container">
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



<a class="ajout_item" href="./ajouter.php"><img class="item_ajout-plus"src="../liaisons/icones/plus.svg">Ajouter un item</a>

</main>
<footer>
    	<?php include ($niveau . "liaisons/inc/fragments/pied_de_page.inc.php");?>
</footer>
<script src="../liaisons/js/_menu.js"></script>
 <script>  document.body.classList.add('js');
 </script>
</body>
<html>