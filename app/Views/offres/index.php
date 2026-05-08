<?php $this->extend('layout'); ?>

<?php $this->section('content'); ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <h2>Mes Options Premium</h2>

            <?php if (isset($error)): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?= $error ?>
                    <br><small>Les migrations doivent être appliquées : <code>php spark migrate</code></small>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->has('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->has('info')): ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <?= session('info') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Offres actuelles -->
            <?php if (!empty($userOffres)): ?>
                <div class="mb-5">
                    <h4>Options Actives</h4>
                    <div class="list-group">
                        <?php foreach ($userOffres as $offre): ?>
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1"><?= esc($offre['libelle']) ?></h5>
                                    <span class="badge bg-success">✓ Actif</span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    Vous n'avez pas d'option active pour le moment.
                </div>
            <?php endif; ?>

            <!-- Options à acheter -->
            <div class="mb-5">
                <h4>Options Disponibles</h4>
                <?php if (empty($offres)): ?>
                    <div class="alert alert-info">
                        Aucune option disponible pour le moment.
                    </div>
                <?php else: ?>
                    <div class="row">
                        <?php foreach ($offres as $offre): ?>
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= esc($offre['libelle']) ?></h5>
                                        
                                        <p class="card-text">
                                            <strong>Remise :</strong> <?= $offre['remise'] ?>%
                                        </p>
                                        
                                        <?php if (in_array($offre['id'], $userOffreIds)): ?>
                                            <button class="btn btn-success btn-sm" disabled>✓ Possédée</button>
                                        <?php else: ?>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <?php if (isset($offre['price']) && $offre['price'] !== null): ?>
                                                    <span class="h5 mb-0 text-primary"><?= number_format((float)$offre['price'], 2, ',', ' ') ?>€</span>
                                                    <form action="/offres/buy/<?= $offre['id'] ?>" method="POST" style="display:inline;">
                                                        <?= csrf_field() ?>
                                                        <button type="submit" class="btn btn-primary btn-sm">Acheter</button>
                                                    </form>
                                                <?php else: ?>
                                                    <span class="text-muted">Gratuit</span>
                                                    <button class="btn btn-secondary btn-sm" disabled>Non concédée</button>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Info Gold -->
            <div class="alert alert-info">
                <h6>À propos de l'option Gold :</h6>
                <ul class="mb-0">
                    <li>Bénéficiez de <strong>15% de remise</strong> sur tous les régimes premium</li>
                    <li>Accès illimité à toutes les recettes exclusives</li>
                    <li>Support prioritaire 24/7</li>
                    <li>Une seule fois : <strong><?= number_format(9.99, 2, ',', ' ') ?>€</strong></li>
                </ul>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Portefeuille</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Solde disponible</p>
                    <h3 class="text-success"><?= number_format((float)($walletBalance ?? 0), 2, ',', ' ') ?>€</h3>
                    <a href="/wallet" class="btn btn-outline-primary btn-sm w-100 mt-3">Gérer mon portefeuille</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>
