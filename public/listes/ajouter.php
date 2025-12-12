<?php $niveau="../";
include ($niveau . "liaisons/inc/config.inc.php");

$strFichierTexte=file_get_contents($niveau."liaisons/js/objJSONMessages.json");
$jsonMessagesErreur=json_decode($strFichierTexte);

$arrChampsErreur = array();
$arrMessagesErreur = array();
$arrMessagesErreur["nom_liste"] = "";
$arrMessagesErreur["couleurs"] = "";

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

$arrListe=array();

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
    $arrCouleurs[$cptEnr]['rgb']=$ligne['rgb'];
    $arrCouleurs[$cptEnr]['hex_bordure']=$ligne['hex_bordure'];
}

if (isset($_GET['btn_nouveau'])) {
    $arrListe["id"]=0;
    $arrListe['nom']="";
    $arrListe["couleur_id"]=0; 
}

if (isset($_GET['btn_ajouter'])) {
    $arrListe["nom"] = $_GET["nom"];
    if (!isset($_GET["couleur_id"])) {
        $_GET["couleur_id"] = 0;
    }
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
    if ($strCodeErreur!="-1") {
    //Établir la requête d'insertion
    $strRequete="INSERT INTO listes ".
    "(nom, couleur_id, utilisateur_id)".
    " VALUES (:nom, :couleur_id, :utilisateur_id)";

    //Exécution de la requêtre
    //$pdosResultat = $pdoConnexion->query($strRequete);
    $pdosResultat=$pdoConnexion->prepare($strRequete);
    var_dump($pdoConnexion->errorInfo());
    
    $pdosResultat->bindParam(':nom', $arrListe["nom"]);
    $pdosResultat->bindParam(':couleur_id', $arrListe["couleur_id"]);
    $pdosResultat->bindValue(':utilisateur_id', 1);

    $pdosResultat->execute();

    header("Location:" .$niveau. "index.php?strCodeOperation=liste_ajoutee");
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
	<title>Page ajouter une liste</title>
	<?php include ($niveau . "liaisons/inc/fragments/head_links.inc.php");?>
</head>
<body>
    <?php include ($niveau . "liaisons/inc/fragments/entete.inc.php");?>
    <div class="page-layout">
    <?php include ($niveau . "liaisons/inc/fragments/sidebar.inc.php");?>
    <main>
        <div id="contenu" class="conteneur">
            <h1>Ajouter une liste</h1>

            <form action="ajouter.php" method="GET">
                <div class="champ-formulaire">
                    <label class="champ-formulaire__label" for="nom">Nom de la liste</label>
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
                    <span class="message-erreur"><?php echo $arrMessagesErreur["couleurs"]; ?></span>
                </div>
                <div>                
                    <input type="submit" value="Ajouter la liste" name="btn_ajouter" class="btn__ajouter">
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