<?php echo $this->extend('layout'); ?>
<?php echo $this->section('content'); ?>

<div class="container mt-5">
    <?php $activities = $activities ?? []; ?>
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Gestion des activités sportives</h2>
        </div>
        <div class="col-md-4 text-right">
            <a href="/activities/create" class="btn btn-primary">+ Ajouter une activité</a>
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

    <?php if (!empty($activities)): ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nom</th>
                        <th>Calories brûlées / heure</th>
                        <th>Intensité</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($activities as $activity): ?>
                        <?php
                            $activityName = (string) ($activity['name'] ?? '');
                            $caloriesBurnPerHour = (int) ($activity['calories_burn_per_hour'] ?? 0);
                            $intensity = (string) ($activity['intensity'] ?? 'medium');
                            $intensityLabel = [
                                'low' => 'Faible',
                                'medium' => 'Moyenne',
                                'high' => 'Élevée',
                            ];
                            $intensityBadge = [
                                'low' => 'success',
                                'medium' => 'warning',
                                'high' => 'danger',
                            ];
                            $intensityBadgeClass = (string) ($intensityBadge[$intensity] ?? 'secondary');
                            $intensityLabelText = (string) ($intensityLabel[$intensity] ?? $intensity);
                        ?>
                        <tr>
                            <td><strong><?= esc($activityName); ?></strong></td>
                            <td><?= number_format($caloriesBurnPerHour); ?> kcal</td>
                            <td>
                                <span class="badge bg-<?= esc($intensityBadgeClass); ?>">
                                    <?= esc($intensityLabelText); ?>
                                </span>
                            </td>
                            <td>
                                <a href="/activities/<?= $activity['id']; ?>/edit" class="btn btn-sm btn-warning">Modifier</a>
                                <a href="/activities/<?= $activity['id']; ?>/delete" class="btn btn-sm btn-danger">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            Aucune activité trouvée. <a href="/activities/create">Créer la première activité</a>
        </div>
    <?php endif; ?>
</div>

<?php echo $this->endSection(); ?>