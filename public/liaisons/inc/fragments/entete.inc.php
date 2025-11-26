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
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="24" viewBox="0 0 12 24"><path fill="#000" fill-rule="evenodd" d="M10.157 12.711L4.5 18.368l-1.414-1.414l4.95-4.95l-4.95-4.95L4.5 5.64l5.657 5.657a1 1 0 0 1 0 1.414"/></svg>
        </div>
        <img class="profil__chevron" src="<?php echo $niveau ?>liaisons/icones/chevron.svg" alt="Icone chevron">
        <style>
.entete__recherche {
  background: lime !important;
  border: 4px solid red !important;
  outline: 6px dashed blue !important;
}
</style>
</header>  
