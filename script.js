// Fonction pour afficher ou cacher le menu hamburger
function toggleMenu() {
    const navMenu = document.getElementById("nav-menu");
    navMenu.classList.toggle("active");
}

// Optionnel : Fermer le menu lorsque l'on clique en dehors
window.onclick = function(event) {
    const navMenu = document.getElementById("nav-menu");
    if (!event.target.matches('#hamburger') && navMenu.classList.contains('active')) {
        navMenu.classList.remove('active');
    }
}

// Afficher le loader pendant le chargement
window.addEventListener('load', function() {
    const loader = document.getElementById('loader');
    loader.style.display = 'none'; // Masquer le loader une fois la page chargée
});

// Afficher le loader lorsque vous effectuez une recherche
document.querySelector('form').addEventListener('submit', function() {
    const loader = document.getElementById('loader');
    loader.style.display = 'block'; // Afficher le loader lors de la recherche
});
