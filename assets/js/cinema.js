// Assurez-vous que le formulaire d'ajout de cinéma est bien pris en charge
document.getElementById('addCinemaForm').addEventListener('submit', function(event) {
    event.preventDefault();  // Empêche la soumission du formulaire classique

    let formData = new FormData(this);  // Récupère toutes les données du formulaire
    // Envoi des données via fetch (AJAX)
    fetch('/index.php?controller=cinema&action=create', {
        method: 'POST',
        body: formData  // Envoie le formulaire sous forme de FormData
    })
    .then(response => response.json())  // Attendre une réponse JSON
    .then(data => {
        if (data.success) {
            // Si le cinéma a été ajouté avec succès
            alert(data.message);  // Afficher un message de succès
            $('#addCinemaModal').modal('hide');  // Fermer le modal
            location.reload();  // Rafraîchir la page pour voir le cinéma ajouté
        } else {
            // Si des erreurs sont renvoyées par le serveur
            alert('Erreur: ' + data.message);
        }
    })
    .catch(error => {
        // Gestion d'erreur
        console.error('Erreur:', error);  // Log de l'erreur
        alert('Une erreur est survenue, veuillez réessayer.');
    });
});
