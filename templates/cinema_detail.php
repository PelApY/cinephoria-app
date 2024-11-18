<?php
// cinema_detail.php - Affiche les détails d'un cinéma

$cinema = $cinemaController->find($cinemaId);  // Récupérer le cinéma par son ID
?>

<h2><?= htmlspecialchars($cinema['name']) ?></h2>
<p>Adresse: <?= htmlspecialchars($cinema['address']) ?></p>
<p>Ville: <?= htmlspecialchars($cinema['city']) ?></p>
<p>Pays: <?= htmlspecialchars($cinema['country']) ?></p>
<p>Téléphone: <?= htmlspecialchars($cinema['phone']) ?></p>
<p>Email: <a href="mailto:<?= htmlspecialchars($cinema['email']) ?>"><?= htmlspecialchars($cinema['email']) ?></a></p>
<p>Horaires: <?= htmlspecialchars($cinema['hours']) ?></p>

<a href="/index.php?controller=cinema&action=update&id=<?= $cinema['cinema_id'] ?>">Modifier</a> | 
<a href="/index.php?controller=cinema&action=delete&id=<?= $cinema['cinema_id'] ?>">Supprimer</a>
