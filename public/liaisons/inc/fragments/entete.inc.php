<?php
// Établissement de la chaine de requête SQL
$strRequete = "SELECT prenom, nom, id FROM utilisateurs";

//Exécution de la requête
$pdosResultat = $pdoConnexion->prepare($strRequete);

$pdosResultat->execute();

$arrUtilisateur=array();
$ligne=$pdosResultat->fetch();
//Extraction de l'enregistrements de la BD
$arrUtilisateur['prenom']=$ligne['prenom'];
$arrUtilisateur['nom']=$ligne['nom'];
$arrUtilisateur['id']=$ligne['id'];

$pdosResultat ->closecursor();
?>
<header class="entete">
    <a class="entete__lien-logo" href="<?php echo $niveau ?>index.php"><img class="entete__logo" src="<?php echo $niveau ?>liaisons/logo/logo_1x.png" alt="Logo TODO"></a>
    <form class="entete__recherche" action="#" onsubmit="return false">
        <button class="entete__btn-recherche" type="submit" aria-label="Lancer la recherche">
            <img class="entete__icon-recherche" src="<?php echo $niveau ?>liaisons/icones/loupe.svg" alt="">
        </button>

        <input class="entete__champ-recherche" type="search" name="" placeholder="Recherche par mots clés" aria-label="Recherche par mots clés" id="champ-recherche" name="">

        <button class="entete__btn-annuler" type="reset" aria-label="Effacer la recherche">
            <img class="entete__icon-annuler" src="<?php echo $niveau ?>liaisons/icones/miniX.svg" alt="">
        </button>
    </form>
    <div class="entete__profil">
        <div class="utilisateur">
            <a class="entete__lien-profil" href="#">
                <img class="entete__icon-profil" src="<?php echo $niveau ?>liaisons/icones/profile.svg" alt="Profil">
                <p class="entete__nom-profil"><?php echo $arrUtilisateur['prenom'] . ' ' . $arrUtilisateur['nom']; ?></p>
            </a>
            <a href="#"><img class="profil__chevron profil__chevron--ferme" src="<?php echo $niveau ?>liaisons/icones/chevron.svg" alt="Ouvrir le menu utilisateur"></a>
        </div>

        <ul class="menu-profil menu--ferme">
            <li class="menu-profil__item menu-profil__bonjour">
                Bonjour <strong><?php echo $arrUtilisateur['prenom']; ?></strong>
            </li>
            <li class="menu-profil__item"><a href="#">Mon compte</a></li>
            <li class="menu-profil__item"><a href="#">Déconnexion</a></li>
        </ul>
    </div>

</header>  
