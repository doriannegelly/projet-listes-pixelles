
<?php $niveau="../";
include($niveau . "liaisons/inc/config.inc.php");
$strFichierTexte=file_get_contents($niveau. '/liaisons/js/objJSONMessages.json');
$jsonMessageErreur=json_decode($strFichierTexte);

$arrChampsErreur=array("nom_item, echeance");
$arrMessagesErreur=array();
$arrMessagesErreur["nom_item"]="";
$arrMessagesErreur["echeance"] = "";


  $mois = [1 => "janvier",2 => "février",3 => "mars",4 => "avril",5 => "mai",6 => "juin",7 => "juillet",8 => "août",9 => "septembre",10 => "octobre",11 => "novembre",12 => "décembre"];
?>


<?php
if(isset($_GET["liste_id"]))
    {
        $strIdListe=$_GET["liste_id"];
    }

    if(isset($_GET["id"]))
    {
        $strIdItems=$_GET["id"];
    }

    $intCodeErreur = 0;
if(isset($_GET['btn_modifier'])){

    if (isset($_GET["jour"])) {
    $jour = $_GET["jour"];
} else {
    $jour = "null";
}

if (isset($_GET["mois"])) {
    $moisSelect = $_GET["mois"];
} else {
    $moisSelect = "null";
}

if (isset($_GET["annee"])) {
    $annee = $_GET["annee"];
} else {
    $annee = "null";
}
// VERIF NOM
if($_GET['nom_item'] == ""){
$arrMessagesErreur['nom_item'] = $jsonMessageErreur->nom_item->erreurs->vide;
$intCodeErreur = -1;
}
else{
    var_dump("Test regex", preg_match('/^[a-zA-ZÀ-ÿ0-9 \'\-#]{1,55}$/', $_GET["nom_item"]));
if(preg_match('/^[a-zA-ZÀ-ÿ0-9 \'\-#.]{1,55}$/', $_GET["nom_item"]) == false){
    $intCodeErreur = "-1";
$arrMessagesErreur['nom_item'] = $jsonMessageErreur->nom_item->erreurs->motif;
   array_push($arrChampsErreur,"nom_item");
}
}
// VERIF DATE
if ($jour === "null" && $moisSelect === "null" && $annee === "null") {
    $arrMessagesErreur["echeance"] = $jsonMessageErreur->echeance->erreurs->vide;
    $intCodeErreur = -1;
}

// 
elseif ($jour === "null" || $moisSelect === "null" || $annee === "null") {
    $arrMessagesErreur["echeance"] = $jsonMessageErreur->echeance->erreurs->motif;
    $intCodeErreur = -1;
}

//checkdate
else {
    if (!checkdate((int)$moisSelect, (int)$jour, (int)$annee)) {
        $arrMessagesErreur["echeance"] = $jsonMessageErreur->echeance->erreurs->motif;
        $intCodeErreur = -1;
    }
}


if($intCodeErreur == 0 ){

    $echeance = $annee . "-" . $moisSelect . "-" . $jour . " 00:00:00";
     $strRequete = "UPDATE items SET nom = :nom_item, echeance = :echeance WHERE id = :id";

         $pdosResultat = $pdoConnexion->prepare($strRequete);
    
         $pdosResultat->bindParam(':nom_item', $_GET["nom_item"]);
         $pdosResultat->bindParam(':id', $strIdItems);
$pdosResultat->bindParam(':echeance', $echeance);

           $pdosResultat->execute();
 $strMessage = "Modifications enregistrées";
    $strCodeErreur = $pdoConnexion->errorCode();
    var_dump($strCodeErreur);

    header("Location:" . $niveau . "items/afficher.php?liste_id=".$strIdListe . "&strCodeOperation=item_modifiee" );
    exit();

    }
}

$strRequete = "SELECT id, nom AS nom_item, DAY(echeance) AS jour, MONTH(echeance) AS mois, YEAR(echeance) AS annee FROM items WHERE id=:id";

$pdosResultat = $pdoConnexion->prepare($strRequete);

$pdosResultat->bindParam(":id", $strIdItems);

$pdosResultat->execute();

$arrItems = $pdosResultat->fetch();

    $pdosResultat ->closecursor();


// Nom de la liste
$strRequeteListe = 'SELECT id, nom, couleur_id FROM listes WHERE id=:id';

$pdosResultat = $pdoConnexion->prepare($strRequeteListe);
$pdosResultat->bindParam(':id', $strIdListe);

$pdosResultat->execute();

$arrListe = $pdosResultat->fetch();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="keyword" content="">
	<meta name="author" content="">
	<meta charset="utf-8">
	<title>Modifier un item - Alice</title>
	<?php include ($niveau . "liaisons/inc/fragments/head_links.inc.php");?>
</head>
	<?php include ($niveau . "liaisons/inc/fragments/entete.inc.php");?>
<body>
    <div class="page-layout">
    <?php include ($niveau . "liaisons/inc/fragments/sidebar.inc.php");?>
<main class="conteneur"> 
<h1><?php echo $arrListe['nom'];?></h1>

<form action="" method="GET">

    <input type="hidden" name="liste_id" value="<?php echo $strIdListe; ?>">
    <input type="hidden" name="id" value="<?php echo $strIdItems; ?>">

  <label class="champ-formulaire__label" for="nom_item">Nom : </label>
    <?php
if (isset($_GET['nom_item'])) {
    $valueNomItem = $_GET['nom_item'];
} else {
    $valueNomItem = $arrItems['nom_item'];
}
?>
<input class="champ-formulaire__input" type="text" id="nom_item" name="nom_item" value="<?php echo $valueNomItem; ?>">
<span><?php echo $arrMessagesErreur["nom_item"] ?></span>
<br>
<br>
 <div id="echeance" class="echeance">

      <fieldset class="echeance__bloc">
        <legend>Ajouter une échéance</legend>
        <!-- JOUR -->
      <label for="jour" class="visuallyhidden">Jour</label>
      <select name="jour" id="jour">
        <option value="null" selected>jour</option>
        <?php
$jourItem = $arrItems["jour"];

echo '<option value="null"';
if ($jourItem === null) {
    echo ' selected';
}

for ($i = 1; $i <= 31; $i++) {
    echo "<option value='$i'";
    if ($i == $jourItem) {
        echo " selected";
    }
    echo ">$i</option>";
}?>
      </select>

<label for="mois" class="visuallyhidden">Mois</label>
<select name="mois" id="mois">
    <?php
    if (isset($_GET["mois"])) {
        $moisItem = $_GET["mois"];
    } else {
        $moisItem = $arrItems["mois"];
    }

    // vide
    echo '<option value="null"';
    if ($moisItem === null || $moisItem === "null") {
        echo ' selected';
    }
    echo '>mois</option>';

//    afficher les mois
    foreach ($mois as $numero => $nom) {
        echo "<option value='$numero'";
        if ($numero == $moisItem) echo ' selected';
        echo ">$nom</option>";
    }
    ?>
</select>
<!-- annes -->
            <label for="annee" class="visuallyhidden">Année</label>
            <select name="annee" id="annee">
                <option value="null" selected>année</option>
                <?php
         $anneeItem = $arrItems["annee"];

if ($anneeItem === null) {
    echo ' selected';
}

for ($a = 2016; $a <= 2030; $a++) {
    echo "<option value='$a'";
    if ($a == $anneeItem) {
        echo " selected";
    }
    echo ">$a</option>";
}
                ?>
            </select>
            <span><?php echo $arrMessagesErreur["echeance"] ?></span>
      </fieldset>
    </div>


<br>
<?php
if($intCodeErreur == -1){
    echo "Erreur!";
     echo '<input class="btn__modifier" type="submit" value="Enregistrer les modifications" name="btn_modifier">';
}else {
 echo '<input class="btn__modifier" type="submit" value="Enregistrer les modifications" name="btn_modifier">';
}?>

<?php
echo '<a class="btn__annuler" href="./afficher.php?liste_id=' . $strIdListe . '">Annuler</a>';
?>
</form> 
<br>
  <script src="../liaisons/js/echeance.js"></script>
</main> 
</div>
<footer>

    	<?php include ($niveau . "liaisons/inc/fragments/pied_de_page.inc.php");?>
</footer>
<script src="<?php echo $niveau; ?>liaisons/js/menu-lateral.js"></script>

</body>