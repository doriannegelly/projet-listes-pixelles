<?php $niveau="./";?>
<?php include ($niveau . "liaisons/inc/config.inc.php");?>

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
			<section class="listes">
				<h1 class="listes__titre">Listes</h1>
				<div class="listes__controls">
					<button class="listes__filtre" type="button">Filtrer <img class="listes__icone-filtre" src="<?php echo $niveau ?>liaisons/icones/chevronNoir.svg" alt="Icone filtre"></button>
				</div>
				<ul class="listes__list">
					<li class="listes__item">
						<div class=listes__item-contenu>
							<h2 class="list__titre">Titre de la liste</h2>
							<p class="listes__item-count">Nombre de tâches</p>
						</div>
						<div class="listes__item-actions">
							<a class="listes__view" href="#">Consulter la liste<img class="listes__icone-view" src="<?php echo $niveau ?>liaisons/icones/fleche.svg" alt="Icone voir"></a>
							<div class="actions__spacer">
							<a class="listes__edit" href="listes/modifier.php">Modifier la liste</a>
							<button class="btn__supprimer" type="button">Supprimer la liste</button>
							</div>
						</div>
					</li>
					<li class="listes__item">
						<div class=listes__item-contenu>
							<h2 class="list__titre">Titre de la liste</h2>
							<p class="listes__item-count">Nombre de tâches</p>
						</div>
						<div class="listes__item-actions">
							<a class="listes__view" href="#">Consulter la liste<img class="listes__icone-view" src="<?php echo $niveau ?>liaisons/icones/fleche.svg" alt="Icone voir"></a>
							<div class="actions__spacer">
							<a class="listes__edit" href="listes/modifier.php">Modifier la liste</a>
							<button class="btn__supprimer" type="button">Supprimer la liste</button>
							</div>
						</div>
					</li>
					<li class="listes__item">
						<div class=listes__item-contenu>
							<h2 class="list__titre">Titre de la liste</h2>
							<p class="listes__item-count">Nombre de tâches</p>
						</div>
						<div class="listes__item-actions">
							<a class="listes__view" href="#">Consulter la liste<img class="listes__icone-view" src="<?php echo $niveau ?>liaisons/icones/fleche.svg" alt="Icone voir"></a>
							<div class="actions__spacer">
							<a class="listes__edit" href="listes/modifier.php">Modifier la liste</a>
							<button class="btn__supprimer" type="button">Supprimer la liste</button>
							</div>
						</div>
					</li>
					<li class="listes__item">
						<div class=listes__item-contenu>
							<h2 class="list__titre">Titre de la liste</h2>
							<p class="listes__item-count">Nombre de tâches</p>
						</div>
						<div class="listes__item-actions">
							<a class="listes__view" href="#">Consulter la liste<img class="listes__icone-view" src="<?php echo $niveau ?>liaisons/icones/fleche.svg" alt="Icone voir"></a>
							<div class="actions__spacer">
							<a class="listes__edit" href="listes/modifier.php">Modifier la liste</a>
							<button class="btn__supprimer" type="button">Supprimer la liste</button>
							</div>
						</div>
					</li>
				</ul>
				<a class="listes__ajouter-item" href="listes/ajouter.php">
					<span class="ajouter-item__icone">
						<img class="ajouter-item__svg" src="<?php echo $niveau ?>liaisons/icones/plus2.svg" alt="">
					</span>
					AJOUTER UN ITEM
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
