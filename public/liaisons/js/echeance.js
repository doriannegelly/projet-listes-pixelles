/**
 * @file Drop down pour une date d'échéance avec poignée (icone + screen-reader-text)
 * En respect des principes de l'amélioration progressive.

 * @author Michel Rouleau <mrouleau@csfoy.ca> (javascript natif)
 * À compléter/ajuster selon vos besoins.
 */

const echeance = {
  refEcheance: null,
  refBouton: null,
  refLibelle: null,
  refChevron: null,

  initialiser() {
    //Javascript est activé (pour les css!)
    document.body.className = "js";

    // On sélectionne le div conteneur de la date d'échéance dans le HTML
    this.refEcheance = document.getElementById("echeance");

    // Création de la balise du bouton et ses attributs
    this.refBouton = document.createElement("button");
    this.refBouton.className = "echeance__controle";
    this.refBouton.setAttribute("type", "button");

    //Création de l'icone du bouton et ses attributs
    this.refIcone = document.createElement("i");
    this.refIcone.className = "icone fi flaticon-calendar";
    this.refIcone.setAttribute("aria-hidden", "true");

    this.refBouton.innerHTML = "&nbsp;Ajouter une échéance&nbsp;";
    this.refBouton.prepend(this.refIcone);

    //Création de la poignée du bouton
    this.refPoignee = document.createElement("span");
    this.refPoignee.className = "echeance__controlePoignee";
    this.refBouton.appendChild(this.refPoignee);

    //Création du chevron
    this.refChevron = document.createElement("span");
    this.refChevron.className = "icone fi flaticon-down-chevron";
    this.refPoignee.appendChild(this.refChevron);

    //Création du libellé
    this.refLibelle = document.createElement("span");
    this.refLibelle.className = "visuallyhidden";
    this.refLibelle.innerHTML = "Fermer";
    this.refPoignee.appendChild(this.refLibelle);

    //Ajoute le bouton construit à la div
    this.refEcheance.prepend(this.refBouton);

    // Ajout de l'écouteur d'événement pour la poignée seulement
    //this.refPoignee.addEventListener('click', this.afficherCacherBloc.bind(this));
    //Ou pour le bouton entier
    this.refBouton.addEventListener(
      "click",
      this.afficherCacherBloc.bind(this),
    );

    // Réinitialisation pour l'état par défaut
    this.resetBlocs();
  },

  resetBlocs() {
    // Ajout des classes nécessaires aux éléments pour l'état par défaut
    this.refEcheance.classList.add("echeance--is-collapsed");
    this.refChevron.classList.remove("flaticon-up-chevron");
    this.refLibelle.innerHTML = "Ouvrir";
  },

  afficherCacherBloc: function (evenement) {
    // Vérification de l'état de la boîte
    if (this.refEcheance.classList.contains("echeance--is-collapsed")) {
      // Si la boîte est fermée, on ouvre
      this.resetBlocs();
      this.refEcheance.classList.remove("echeance--is-collapsed");
      this.refChevron.classList.add("flaticon-up-chevron");
      this.refLibelle.innerHTML = "Fermer";
    } else {
      // Si la boîte est ouverte, on ferme
      this.resetBlocs();
    }
  },
};

//*******************
// Écouteurs d'événements
//*******************
window.addEventListener("load", echeance.initialiser.bind(echeance));
