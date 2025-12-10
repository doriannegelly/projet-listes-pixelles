<?php
// Établissement de la chaine de requête SQL
$strRequeteListes = "SELECT listes.id AS id, couleur_id, nom, hexadecimal, utilisateur_id, hex_bordure FROM listes INNER JOIN couleurs ON listes.couleur_id = couleurs.id ";

//Exécution de la requête
$pdosResultat = $pdoConnexion->prepare($strRequeteListes);

$pdosResultat->execute();

//Extraction de l'enregistrements de la BD
$arrListes=array();
for($cptEnr=0;$ligne=$pdosResultat->fetch();$cptEnr ++){
    $arrListes[$cptEnr]['id']=$ligne['id'];
    $arrListes[$cptEnr]['couleur_id']=$ligne['couleur_id'];
    $arrListes[$cptEnr]['nom']=$ligne['nom'];
	$arrListes[$cptEnr]['hexadecimal']=$ligne['hexadecimal'];
	$arrListes[$cptEnr]['hex_bordure']=$ligne['hex_bordure'];
}
$pdosResultat ->closecursor();
?>


<aside class="sidebar" id="sidebar">
    <button class="sidebar__toggle" id="btnSidebar" type="button">
        <span><img class="sidebar__icon" src="<?php echo $niveau;?>/liaisons/icones/btnMenu.svg"></span>
    </button>

    <div class="sidebar__panel">
 
        <nav class="sidebar__nav">

            <div class="sidebar__section-liens">
            <a href="<?php echo $niveau; ?>index.php" class="sidebar__link sidebar__link--home"><img src="<?php echo $niveau; ?>/liaisons/icones/maison.svg"> Accueil</a>
            <a href="<?php echo $niveau; ?>listes/ajouter.php" class="sidebar__link"><img src="<?php echo $niveau; ?>/liaisons/icones/plus.svg"> Ajouter une liste</a>
            </div>

            <div class="sidebar__section-listes">
            <p class="sidebar__title">Les listes</p>

            <ul class="sidebar__listes">
                <?php
                if (!empty($arrListes)) {
                    for ($cpt=0; $cpt < count($arrListes); $cpt++) { ?>
                        <li class="sidebar__liste-item">
                            <span class="sidebar__bullet"
                                style="background-color: <?php echo '#'.$arrListes[$cpt]['hexadecimal']; ?>;">
                            </span>
                            <a href="<?php echo $niveau;?>/items/afficher.php?liste_id=<?php echo $arrListes[$cpt]['id']; ?>"><?php echo $arrListes[$cpt]['nom']; ?></a>
                        </li>
                <?php   }
                } ?>
            </ul>
            </div>
        </nav>
    </div>
</aside>