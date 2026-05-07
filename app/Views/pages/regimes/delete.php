<?php echo $this->extend('layout'); ?>
<?php echo $this->section('content'); ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Confirmation de suppression</h5>
                </div>
                <div class="card-body">
                    <p class="mb-3">
                        Êtes-vous sûr de vouloir supprimer le régime <strong><?= htmlspecialchars($regime['name']); ?></strong> ?
                    </p>
                    <p class="text-muted small">
                        <strong>Attention :</strong> Cette action est irréversible et supprimera aussi tous les plans associés à ce régime.
                    </p>

                    <div class="alert alert-warning">
                        <p class="mb-0"><strong>Détails du régime :</strong></p>
                        <ul class="mb-0 mt-2">
                            <li>Calories/jour: <?= number_format($regime['calories_per_day']); ?> kcal</li>
                            <li>Difficulté: 
                                <?php
                                    $difficultyLabel = [
                                        'easy' => 'Facile',
                                        'medium' => 'Moyen',
                                        'hard' => 'Difficile'
                                    ];
                                    echo $difficultyLabel[$regime['difficulty']] ?? $regime['difficulty'];
                                ?>
                            </li>
                            <li>Composition: Viande <?= $regime['pourcentage_viande']; ?>%, Poisson <?= $regime['pourcentage_poisson']; ?>%, Volaille <?= $regime['pourcentage_volaille']; ?>%</li>
                        </ul>
                    </div>

                    <form method="post" action="/regimes/<?= $regime['id']; ?>/destroy" class="d-inline">
                        <?= csrf_field(); ?>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="/regimes" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-danger">Supprimer définitivement</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>
