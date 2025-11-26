<header class="entete">
    <a class="entete__lien-logo" href="<?php echo $niveau ?>index.php"><img class="entete__logo" src="<?php echo $niveau ?>liaisons/logo/logo_1x.png" alt="Logo TODO"></a>
    <form class="entete__recherche">
        <button class="entete__btn-recherche" type="submit" aria-label="Lancer la recherche">
            <img class="entete__icon-recherche" src="<?php echo $niveau ?>liaisons/icones/loupe.svg" alt="">
        </button>

        <input class="entete__champ-recherche" type="search" name="" placeholder="Recherche par mots clés" aria-label="Recherche par mots clés">

        <button class="entete__btn-annuler" type="reset" aria-label="Effacer la recherche">
            <img class="entete__icon-annuler" src="<?php echo $niveau ?>liaisons/icones/miniX.svg" alt="">
        </button>
    </form>
    <div class="entete__profil">
        <div class="utilisateur">
            <a class="entete__lien-profil" href=""><img class="entete__icon-profil" src="<?php echo $niveau ?>liaisons/icones/profile.svg" alt="Icone profil"><p class="entete__nom-profil">Dorianne Gelly</p></a>
        </div>
        <img class="profil__chevron" src="<?php echo $niveau ?>liaisons/icones/chevron.svg" alt="Icone chevron">
    </div>
</header>  
