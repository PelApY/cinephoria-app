<?php
// Assurez-vous que $cinemas contient un tableau d'objets Cinema
foreach ($cinemas as $cinema):
?>
<div class="row">
    <div class="col-md-4 col-lg-3 col-xl-3 mx-0 mt-4">
        <h3 class="text-uppercase fw-bold mb-2"><?= htmlspecialchars($cinema->getName()) ?></h3>
        <ul class="list-unstyled d-flex flex-column">
            <li><i class="fas fa-home me-3"></i><?= htmlspecialchars($cinema->getAddress()) ?></li>
            <li><i class="fas fa-envelope me-3"></i><a href="mailto:<?= htmlspecialchars($cinema->getEmail()) ?>"><?= htmlspecialchars($cinema->getEmail()) ?></a></li>
            <li><i class="fas fa-phone me-3"></i><?= htmlspecialchars($cinema->getPhone()) ?></li>
            <li><i class="fas fa-clock me-3"></i>Horaires : <?= htmlspecialchars($cinema->getHours()) ?></li>
            <li><i class="fas fa-city me-3"></i><?= htmlspecialchars($cinema->getCity()) ?>, <?= htmlspecialchars($cinema->getCountry()) ?></li>
            <li><i class="fas fa-map-marker-alt me-3"></i><?= htmlspecialchars($cinema->getPostalCode()) ?></li>
        </ul>
    </div>
</div>
<?php endforeach; ?>
