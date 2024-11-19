<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinéphoria - Landing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <main>
        <!-- Contenu principal du site -->

         <!-- Tab Content -->
         <div class="tab-content" id="myTabContent">

            <!-- Cinémas -->
            <div class="tab-pane fade show active" id="nav-cinemas" role="tabpanel" aria-labelledby="nav-cinemas-tab" tabindex="0" aria-label="Détails des cinémas" aria-describedby="cinemas-description">
                <div class="container">
                    <h1 class="h3 m-2 text-white" id="cinemas-title">Cinémas</h1>
                    <p class="mb-4 text-white" id="cinemas-description">Voici la liste des cinémas disponibles.</p>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Détails des Cinémas</h6>
                            <!-- Bouton d'ajout -->
                            <button type="button" class="btn btn-success btn-sm px-4" data-bs-toggle="modal" data-bs-target="#addCinemaModal">Ajouter un cinéma</button>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive mb-4">
                                <table class="table table-striped table-hover table-bordered" id="dataTable" width="100%" cellspacing="0" aria-label="Détails des cinémas">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Nom</th>
                                            <th scope="col" class="d-none d-lg-table-cell">Ville</th>
                                            <th scope="col" class="d-none d-lg-table-cell">Adresse</th>
                                            <th scope="col" class="d-none d-lg-table-cell">Code Postal</th>
                                            <th scope="col">Téléphone</th>
                                            <th scope="col" class="d-none d-lg-table-cell">Horaires</th>
                                            <th scope="col" class="d-none d-lg-table-cell">Email</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Nom</th>
                                            <th scope="col" class="d-none d-lg-table-cell">Ville</th>
                                            <th scope="col" class="d-none d-lg-table-cell">Adresse</th>
                                            <th scope="col" class="d-none d-lg-table-cell">Code Postal</th>
                                            <th scope="col">Téléphone</th>
                                            <th scope="col" class="d-none d-lg-table-cell">Horaires</th>
                                            <th scope="col" class="d-none d-lg-table-cell">Email</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php foreach ($cinemas as $cinema): ?>
                                        <tr>
                                            <th scope="row"><?= htmlspecialchars($cinema->getCinemaId()) ?></th>
                                            <td><?= htmlspecialchars($cinema->getName()) ?></td>
                                            <td class="d-none d-lg-table-cell"><?= htmlspecialchars($cinema->getCity()) ?></td>
                                            <td class="d-none d-lg-table-cell"><?= htmlspecialchars($cinema->getAddress()) ?></td>
                                            <td class="d-none d-lg-table-cell"><?= htmlspecialchars($cinema->getPostalCode()) ?></td>
                                            <td><?= htmlspecialchars($cinema->getPhone()) ?></td>
                                            <td class="d-none d-lg-table-cell"><?= htmlspecialchars($cinema->getHours()) ?></td>
                                            <td class="d-none d-lg-table-cell"><?= htmlspecialchars($cinema->getEmail()) ?></td>
                                            <td scope="row">
                                                <div class="d-flex gap-2">
                                                    <!-- Bouton Modifier -->
                                                    <a href="index.php?controller=cinema&action=update&id=<?= $cinema->getCinemaId() ?>" class="btn btn-primary btn-sm">Modifier</a>
                                                    <!-- Bouton Supprimer -->
                                                    <a href="index.php?controller=cinema&action=delete&id=<?= $cinema->getCinemaId() ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cinéma ?')">Supprimer</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal d'ajout de cinéma -->
            <div class="modal fade" id="addCinemaModal" tabindex="-1" aria-labelledby="addCinemaModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg my-5">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addCinemaModalLabel">Ajouter un cinéma</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Formulaire pour ajouter un cinéma -->
                            <form id="addCinemaForm" method="post">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <label for="name">Nom</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Nom du cinéma" required>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label for="city">Ville</label>
                                        <input type="text" class="form-control" id="city" name="city" placeholder="Ville" required>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6 col-12">
                                        <label for="country">Pays</label>
                                        <input type="text" class="form-control" id="country" name="country" placeholder="Pays" required>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label for="address">Adresse</label>
                                        <input type="text" class="form-control" id="address" name="address" placeholder="Adresse" required>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6 col-12">
                                        <label for="postalCode">Code Postal</label>
                                        <input type="text" class="form-control" id="postalCode" name="postalCode" placeholder="Code Postal" required>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label for="phone">Téléphone</label>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Numéro de téléphone" required>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6 col-12">
                                        <label for="hours">Horaires</label>
                                        <input type="text" class="form-control" id="hours" name="hours" placeholder="Horaires d'ouverture" required>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email du cinéma" required>
                                    </div>
                                </div>
                                <div class="modal-footer mt-4">
                                    <button type="submit" class="btn btn-success btn-sm">Ajouter le cinéma</button>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Annuler</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal de modification de cinéma -->
        <div class="modal fade" id="editCinemaModal" tabindex="-1" aria-labelledby="editCinemaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg my-5">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCinemaModalLabel">Modifier un cinéma</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulaire pour modifier un cinéma -->
                        <form id="editCinemaForm">
                            <input type="hidden" name="id" id="cinema_id" value="<?= $cinema['cinema_id']; ?>" />
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <label for="name">Nom</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($cinema['cinema_nom']); ?>" required>
                                </div>
                                <div class="col-md-6 col-12">
                                    <label for="city">Ville</label>
                                    <input type="text" class="form-control" id="city" name="city" value="<?= htmlspecialchars($cinema['cinema_ville']); ?>" required>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6 col-12">
                                    <label for="country">Pays</label>
                                    <input type="text" class="form-control" id="country" name="country" value="<?= htmlspecialchars($cinema['cinema_pays']); ?>" required>
                                </div>
                                <div class="col-md-6 col-12">
                                    <label for="address">Adresse</label>
                                    <input type="text" class="form-control" id="address" name="address" value="<?= htmlspecialchars($cinema['cinema_adresse']); ?>" required>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6 col-12">
                                    <label for="postalCode">Code Postal</label>
                                    <input type="text" class="form-control" id="postalCode" name="postalCode" value="<?= htmlspecialchars($cinema['cinema_cp']); ?>" required>
                                </div>
                                <div class="col-md-6 col-12">
                                    <label for="phone">Téléphone</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($cinema['cinema_numero']); ?>" required>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6 col-12">
                                    <label for="hours">Horaires</label>
                                    <input type="text" class="form-control" id="hours" name="hours" value="<?= htmlspecialchars($cinema['cinema_horaires']); ?>" required>
                                </div>
                                <div class="col-md-6 col-12">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($cinema['cinema_email']); ?>" required>
                                </div>
                            </div>
                            <div class="modal-footer mt-4">
                                <button type="submit" class="btn btn-success btn-sm">Mettre à jour le cinéma</button>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Footer -->
        <footer class="text-center text-lg-start bg-body-tertiary text-muted shadow">
            <section id="cinemaInfos">
                <div class="container text-md-start">
                    <div class="row mx-auto">
                        <!-- Cinéphoria Info -->
                        <div class="col-md-6 col-lg-3 col-xl-3 mt-4">
                            <h6 class="text-uppercase fw-bold"><i class="fas fa-gem me-3"></i>Cinéphoria</h6>
                            <p class="pe-2">Cinéphoria est une plateforme dédiée aux passionnés de cinéma, offrant une expérience unique avec une sélection variée de films et des horaires flexibles dans plusieurs villes.</p>
                        </div>

                        <!-- Affichage dynamique des cinémas -->
                        <?php foreach ($cinemas as $cinema): ?>
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
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>

            <!-- Copyright -->
            <div class="text-center p-3 bg-dark text-white">
                <p>&copy; 2024 PelApY - Tous droits réservés</p>
                <p>
                    <span class="text-white mx-1">&middot;</span>
                    <a class="link-light small" href="./pages/privacy-policy.html" target="_blank" rel="noopener noreferrer">Politique de confidentialité</a>
                    <span class="text-white mx-1">&middot;</span>
                    <a class="link-light small" href="./pages/terms-of-service.html" target="_blank" rel="noopener noreferrer">Conditions d'utilisation</a>
                    <span class="text-white mx-1">&middot;</span>
                    <a class="link-light small" href="./pages/contact.html">Page de Contact</a>
                </p>
            </div>
        </footer>
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="/../assets/js/cinema.js"></script>
</body>
</html>
