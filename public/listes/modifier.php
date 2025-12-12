<?php $niveau="../";
include ($niveau . "liaisons/inc/config.inc.php");

$strFichierTexte=file_get_contents($niveau."liaisons/js/objJSONMessages.json");
$jsonMessagesErreur=json_decode($strFichierTexte);

$arrChampsErreur = array();
$arrMessagesErreur = array();
$arrMessagesErreur["nom_liste"] = "";
$arrMessagesErreur["couleurs"] = "";

if (isset($_GET["liste_id"])) {
    $id_liste = $_GET["liste_id"];
} elseif (isset($_GET["id_liste"])) {
    $id_liste = $_GET["id_liste"];
}

// Fonction utilitaire pour l'affichage des boutons radio
function ecrireChecked($valeurRadio, $nomRadio) {
    $strCocher = "";
    global $arrListe;
    if ($valeurRadio == $arrListe[$nomRadio]) {
        $strCocher = 'checked = "checked"';
    }
    return $strCocher;
}

$strCodeErreur='00000';

$strMessage="";

// Établissement de la chaine de requête SQL
$strRequeteListe = "SELECT id, nom, couleur_id FROM listes WHERE id = :id_liste";

//Exécution de la requête
$pdosResultat = $pdoConnexion->prepare($strRequeteListe);

//Liaison de valeur
$pdosResultat->bindValue(":id_liste", $id_liste);

$pdosResultat->execute();

$arrListe=array();
$ligne=$pdosResultat->fetch();
//Extraction de l'enregistrements de la BD
$arrListe['id']=$ligne['id'];
$arrListe['nom']=$ligne['nom'];
$arrListe['couleur_id']=$ligne['couleur_id'];

$pdosResultat ->closecursor();

//**********************************************************
// Couleurs
//**********************************************************
//Établissement de la chaine de requête
$strRequeteCouleurs = "SELECT id, nom_fr, nom_en, hexadecimal, rgb, hex_bordure FROM couleurs";
//Exécution de la requête
$pdosResultat = $pdoConnexion->prepare($strRequeteCouleurs);
//$pdosResultat = $pdoConnexion->query($strRequeteCouleurs);
$pdosResultat->execute();
//Extraction de l'enregistrements de la BD
$arrCouleurs=array();
for($cptEnr=0;$ligne=$pdosResultat->fetch();$cptEnr ++){
    $arrCouleurs[$cptEnr]['id']=$ligne['id'];
    $arrCouleurs[$cptEnr]['nom_fr']=$ligne['nom_fr'];
    $arrCouleurs[$cptEnr]['nom_en']=$ligne['nom_en'];
    $arrCouleurs[$cptEnr]['hexadecimal']=$ligne['hexadecimal'];
    $arrCouleurs[$cptEnr]['hex_bordure']=$ligne['hex_bordure'];
    $arrCouleurs[$cptEnr]['rgb']=$ligne['rgb'];
}
$pdosResultat ->closecursor();

if (isset($_GET['btn_modifier'])) {
    $arrListe["id"] = $_GET["id_liste"];
    $arrListe["nom"] = $_GET["nom"];
    $arrListe["couleur_id"] = $_GET["couleur_id"];

    if ($arrListe["nom"] == "") {
        $strCodeErreur="-1";
        array_push($arrChampsErreur, [
            "champ" => "nom_liste",
            "code" => "vide"
        ]);
    } elseif (preg_match("/^[\p{L} \'\-#]{1,50}$/u", $arrListe["nom"]) == 0) {
        $strCodeErreur="-1";
        array_push($arrChampsErreur, [
            "champ" => "nom_liste",
            "code" => "motif"
        ]);
    }

    if ($arrListe["couleur_id"] == 0) {
        $strCodeErreur = "-1";
        array_push($arrChampsErreur, [
            "champ" => "couleurs",
            "code"  => "vide"
        ]);
    }
    
    if ($strCodeErreur!="-1" && isset($_GET['btn_modifier'])) {
    $strRequete="UPDATE listes SET ".
    "id='".$arrListe["id"]."',".
    "nom='".$arrListe["nom"]."',".
    "couleur_id=".$arrListe["couleur_id"].
    " WHERE id = :id_liste";

    $pdosResultat = $pdoConnexion->prepare($strRequete);

    $pdosResultat->bindParam(":id_liste", $id_liste);

    $pdosResultat->execute();

    header("Location:" .$niveau. "index.php?strCodeOperation=liste_modifiee");
    }

    if ($strCodeErreur!="00000") {
    for ($cpt=0; $cpt<count($arrChampsErreur); $cpt++) {
        $champ=$arrChampsErreur[$cpt]["champ"];
        $code  = $arrChampsErreur[$cpt]["code"]; 
        $arrMessagesErreur[$champ]=$jsonMessagesErreur->{$champ}->{"erreurs"}->{$code};
    }
    }
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
	<title>Modifier une liste</title>
	<?php include ($niveau . "liaisons/inc/fragments/head_links.inc.php");?>
</head>
<body>
    <?php include ($niveau . "liaisons/inc/fragments/entete.inc.php");?>
    <div class="page-layout">
    <?php include ($niveau . "liaisons/inc/fragments/sidebar.inc.php");?>

    <main>
        <div id="contenu" class="conteneur">
            <h1>Éditer la liste - <?php echo $arrListe['nom']; ?></h1>

            <form action="modifier.php" method="GET">
                <input type="hidden" name="id_liste" value="<?php echo $arrListe['id']; ?>">
                <div class="champ-formulaire">
                    <label class="champ-formulaire__label" for="nom"><?php echo $arrListe['nom']; ?></label>
                    <input class="champ-formulaire__input <?php if (!empty($arrMessagesErreur["nom_liste"])) echo "champ-formulaire__input--erreur"; ?>" type="text" name="nom" id="nom" value="<?php echo $arrListe['nom']; ?>">
                    <span class="message-erreur"><?php echo $arrMessagesErreur["nom_liste"]?></span>
                </div>
                <div class="liste-couleur">
                    <label class="liste-couleur__label" for="couleur_id">
                        Couleur de la liste
                    </label>
                    <div class="liste-couleur__choices">
                        <?php for($cpt=0; $cpt<count($arrCouleurs); $cpt++){ ?>
                        <input type="radio" id="<?php echo $arrCouleurs[$cpt]['id']; ?>"  name="couleur_id" value="<?php echo $arrCouleurs[$cpt]['id']; ?>" class="liste-couleur__radio" <?php echo ecrireChecked($arrCouleurs[$cpt]['id'],  'couleur_id'); ?>>
                        <label for="<?php echo $arrCouleurs[$cpt]['id']; ?>"  class="liste-couleur__swatch" style="background-color: <?php echo "#".$arrCouleurs[$cpt]['hexadecimal']; ?>;"></label>
                        <?php } ?>
                    </div>
                </div>
                <div>                
                    <input type="submit" value="Enregistrer les modifications" name="btn_modifier" class="btn__modifier">
                    <a href="<?php echo $niveau; ?>index.php" class="btn__annuler">Annuler</a>
                </div>
            </form>
        </div>
    </main>
    </div>

    <?php include ($niveau . "liaisons/inc/fragments/pied_de_page.inc.php");?>
    <script src="<?php echo $niveau; ?>liaisons/js/menu-lateral.js"></script>

</body>
</html>