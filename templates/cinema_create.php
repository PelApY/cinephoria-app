<?php
// cinema_create.php - Formulaire pour créer un cinéma

?>

<form action="/index.php?controller=cinema&action=create" method="POST">
    <label for="name">Nom du cinéma:</label>
    <input type="text" id="name" name="name" required>
    
    <label for="city">Ville:</label>
    <input type="text" id="city" name="city" required>
    
    <label for="country">Pays:</label>
    <input type="text" id="country" name="country" required>
    
    <label for="address">Adresse:</label>
    <input type="text" id="address" name="address" required>
    
    <label for="postalCode">Code postal:</label>
    <input type="text" id="postalCode" name="postalCode" required>
    
    <label for="phone">Numéro de téléphone:</label>
    <input type="tel" id="phone" name="phone" required>
    
    <label for="hours">Horaires:</label>
    <input type="text" id="hours" name="hours" required>
    
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    
    <button type="submit">Créer</button>
</form>
