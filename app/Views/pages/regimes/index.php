<?php echo $this->extend('layout'); ?>
<?php echo $this->section('content'); ?>

<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Gestion des Régimes</h2>
        </div>
        <div class="col-md-4 text-right">
            <a href="/regimes/create" class="btn btn-primary">+ Ajouter un régime</a>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($regimes)): ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nom</th>
                        <th>Calories/jour</th>
                        <th>Difficulté</th>
                        <th>Composition</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($regimes as $regime): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($regime['name']); ?></strong></td>
                            <td><?= number_format($regime['calories_per_day']); ?> kcal</td>
                            <td>
                                <?php
                                    $difficultyLabel = [
                                        'easy' => 'Facile',
                                        'medium' => 'Moyen',
                                        'hard' => 'Difficile'
                                    ];
                                    $badge = [
                                        'easy' => 'success',
                                        'medium' => 'warning',
                                        'hard' => 'danger'
                                    ];
                                ?>
                                <span class="badge bg-<?= $badge[$regime['difficulty']] ?? 'secondary'; ?>">
                                    <?= $difficultyLabel[$regime['difficulty']] ?? $regime['difficulty']; ?>
                                </span>
                            </td>
                            <td>
                                <small>
                                    Viande: <?= $regime['pourcentage_viande']; ?>% |
                                    Poisson: <?= $regime['pourcentage_poisson']; ?>% |
                                    Volaille: <?= $regime['pourcentage_volaille']; ?>%
                                </small>
                            </td>
                            <td><?= substr(htmlspecialchars($regime['description']), 0, 50); ?>...</td>
                            <td>
                                <a href="/regimes/<?= $regime['id']; ?>/edit" class="btn btn-sm btn-warning">Modifier</a>
                                <a href="/regimes/<?= $regime['id']; ?>/delete" class="btn btn-sm btn-danger">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            Aucun régime trouvé. <a href="/regimes/create">Créer le premier régime</a>
        </div>
    <?php endif; ?>
</div>

<?php echo $this->endSection(); ?>
