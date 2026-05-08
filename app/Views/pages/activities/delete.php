<?php echo $this->extend('layout'); ?>
<?php echo $this->section('content'); ?>

<div class="container mt-5">
    <?php $activity = $activity ?? []; ?>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <?php
                $activityName = (string) ($activity['name'] ?? '');
                $activityId = (int) ($activity['id'] ?? 0);
                $caloriesBurnPerHour = (int) ($activity['calories_burn_per_hour'] ?? 0);
                $intensity = (string) ($activity['intensity'] ?? 'medium');
            ?>
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Confirmation de suppression</h5>
                </div>
                <div class="card-body">
                    <p class="mb-3">
                        Êtes-vous sûr de vouloir supprimer l'activité <strong><?= esc($activityName); ?></strong> ?
                    </p>
                    <p class="text-muted small">
                        <strong>Attention :</strong> Cette action est irréversible.
                    </p>

                    <div class="alert alert-warning">
                        <p class="mb-0"><strong>Détails de l'activité :</strong></p>
                        <ul class="mb-0 mt-2">
                            <li>Calories brûlées par heure : <?= number_format($caloriesBurnPerHour); ?> kcal</li>
                            <li>Intensité : <?= esc(ucfirst($intensity)); ?></li>
                        </ul>
                    </div>

                    <form method="post" action="/activities/<?= $activityId; ?>/destroy" class="d-inline">
                        <?= csrf_field(); ?>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="/activities" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-danger">Supprimer définitivement</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>