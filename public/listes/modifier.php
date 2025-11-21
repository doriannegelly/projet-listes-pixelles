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
        <h1>Éditer la liste - Nom de la liste</h1>

        <form action="" method="GET">
            <div>
                <label for="">Nom de la liste</label>
                <input type="text" name="" id="" value="Nom de la liste sélectionnée">
            </div>
            <div>
                <label for="">Couleur de la liste</label>
                <select id="" name="">
                    <option value="0"></option>
                    <option value="">Rouge</option>
                    <option value="">Orange</option>
                    <option value="">Jaune</option>
                </select>
            </div>
            <div>
                <input type="submit" value="Enregistrer les modifications" name="btn_modifier">
                <input type="button" value="Annuler" name="btn_annuler">
            </div>
        </form>
    </main>

    <?php include ($niveau . "liaisons/inc/fragments/pied_de_page.inc.php");?>
</body>
</html>