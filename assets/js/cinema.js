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

$(document).ready(function() {
    // Gérer la soumission du formulaire de modification
    $('#editCinemaForm').on('submit', function(e) {
        e.preventDefault();  // Empêcher l'envoi normal du formulaire
        
        // Récupérer l'ID du cinéma pour l'action
        const cinemaId = $('#cinema_id').val();
        
        // Envoyer les données via AJAX
        $.ajax({
            url: 'index.php?controller=cinema&action=update&id=' + cinemaId,  // URL du contrôleur avec l'ID
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Cinéma mis à jour avec succès !');
                    location.reload();  // Recharger la page pour voir les modifications
                } else {
                    alert('Erreur: ' + response.message);
                }
            },
            error: function() {
                alert('Une erreur s\'est produite.');
            }
        });
    });
});
