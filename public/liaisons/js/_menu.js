
var menuProfil = {
  lblMenuFerme: 'Menu',
  lblMenuOuvert: 'Fermer',
  refBouton: null,
  refLibelle: null,
  refMenu: null,

  configurerNav: function ()
  {
    //********** Création du bouton du menu mobile

    // On sélectionne le menu dans le HTML
    this.refMenu = document.querySelector(".menu-profil");

    this.refBouton = document.querySelector(".profil__chevron");


    // Ajout de l'écouteur d'événement sur le bouton du menu
    // this.refBouton.addEventListener('click', function () {
    //   menu.ouvrirFermerNav();
    // });
    this.refBouton.addEventListener('click', this.ouvrirFermerNav.bind(this));
  },

  ouvrirFermerNav: function ()
  {
    // On bascule la classe de fermeture du menu
    this.refMenu.classList.toggle("menu--ferme");

    this.refMenu.classList.toggle("menu--ouvert");
    if (this.refMenu.classList.contains("menu--ouvert")) {
      this.refBouton.classList.remove("profil__chevron--ferme");
      this.refBouton.classList.add("profil__chevron--ouvert");
      this.refBouton.setAttribute('alt', 'Fermer le menu utilisateur');
    } else {
      this.refBouton.classList.remove("profil__chevron--ouvert");
      this.refBouton.classList.add("profil__chevron--ferme");
      this.refBouton.setAttribute('alt', 'Ouvrir le menu utilisateur');
    }

  }
};


//*******************
// Écouteurs d'événements
//*******************

window.addEventListener('load', function () { menuProfil.configurerNav(); });