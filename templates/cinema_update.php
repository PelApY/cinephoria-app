<?php
// cinema_update.php - Formulaire pour mettre à jour un cinéma

?>

<form action="/index.php?controller=cinema&action=update&id=<?= $cinema['cinema_id'] ?>" method="POST">
    <label for="name">Nom du cinéma:</label>
    <input type="text" id="name" name="name" value="<?= htmlspecialchars($cinema['name']) ?>" required>
    
    <label for="city">Ville:</label>
    <input type="text" id="city" name="city" value="<?= htmlspecialchars($cinema['city']) ?>" required>
    
    <label for="country">Pays:</label>
    <input type="text" id="country" name="country" value="<?= htmlspecialchars($cinema['country']) ?>" required>
    
    <label for="address">Adresse:</label>
    <input type="text" id="address" name="address" value="<?= htmlspecialchars($cinema['address']) ?>" required>
    
    <label for="postalCode">Code postal:</label>
    <input type="text" id="postalCode" name="postalCode" value="<?= htmlspecialchars($cinema['postal_code']) ?>" required>
    
    <label for="phone">Numéro de téléphone:</label>
    <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($cinema['phone']) ?>" required>
    
    <label for="hours">Horaires:</label>
    <input type="text" id="hours" name="hours" value="<?= htmlspecialchars($cinema['hours']) ?>" required>
    
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?= htmlspecialchars($cinema['email']) ?>" required>
    
    <button type="submit">Mettre à jour</button>
</form>
