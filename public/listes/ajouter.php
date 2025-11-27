<?php $niveau="../";?>
<?php include ($niveau . "liaisons/inc/config.inc.php");?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="keyword" content="">
	<meta name="author" content="">
	<meta charset="utf-8">
	<title>Page ajouter une liste</title>
	<?php include ($niveau . "liaisons/inc/fragments/head_links.inc.php");?>
</head>
<body>
    <?php include ($niveau . "liaisons/inc/fragments/entete.inc.php");?>
    <main>
        <div id="contenu" class="conteneur">
            <h1>Ajouter une liste</h1>

            <form action="" method="GET">
                <div class="champ-formulaire">
                    <label class="champ-formulaire__label" for="">Nom de la liste</label>
                    <input class="champ-formulaire__input" type="text" name="" id="" value="" placeholder="Nom de la liste">
                </div>
                <div class="liste-couleur">
                    <label class="liste-couleur__label" for="couleur_liste">
                        Couleur de la liste
                    </label>
                    <div class="liste-couleur__choices">
                        <input type="radio" id="c-rose"  name="couleur_liste" value="#F5B7DB" class="liste-couleur__radio" checked>
                        <label for="c-rose"  class="liste-couleur__swatch liste-couleur__swatch--rose"></label>

                        <input type="radio" id="c-jaune" name="couleur_liste" value="#F6D868" class="liste-couleur__radio">
                        <label for="c-jaune" class="liste-couleur__swatch liste-couleur__swatch--jaune"></label>

                        <input type="radio" id="c-vert"  name="couleur_liste" value="#9AAC63" class="liste-couleur__radio">
                        <label for="c-vert"  class="liste-couleur__swatch liste-couleur__swatch--vert"></label>

                        <input type="radio" id="c-bleu"  name="couleur_liste" value="#B6CBEC" class="liste-couleur__radio">
                        <label for="c-bleu"  class="liste-couleur__swatch liste-couleur__swatch--bleu"></label>

                        <input type="radio" id="c-rouge" name="couleur_liste" value="#EE8C8D" class="liste-couleur__radio">
                        <label for="c-rouge" class="liste-couleur__swatch liste-couleur__swatch--rouge"></label>

                        <input type="radio" id="c-lilas" name="couleur_liste" value="#DECAF0" class="liste-couleur__radio">
                        <label for="c-lilas" class="liste-couleur__swatch liste-couleur__swatch--lilas"></label>
                    </div>
                </div>
                <div class="actions-formulaire">
                    <input type="submit" value="Ajouter la liste" name="btn_ajouter" class="btn__ajouter">
                    <input type="button" value="Annuler" name="btn_annuler" class="btn__annuler">
                </div>
            </form>
        </div>
    </main>

    <?php include ($niveau . "liaisons/inc/fragments/pied_de_page.inc.php");?>
</body>
</html>