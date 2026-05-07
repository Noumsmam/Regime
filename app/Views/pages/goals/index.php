<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Mes Objectifs</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="/goals/create" class="btn btn-primary">+ Créer un objectif</a>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (empty($goals)): ?>
        <div class="alert alert-info">
            Aucun objectif créé. <a href="/goals/create">Créer un objectif maintenant</a>.
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($goals as $goal): ?>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php
                                    $typeLabel = [
                                        'gain'         => 'Augmenter poids',
                                        'lose'         => 'Réduire poids',
                                        'reach_ideal'  => 'Atteindre IMC idéal'
                                    ];
                                    echo $typeLabel[$goal['type']] ?? ucfirst($goal['type']);
                                ?>
                            </h5>
                            
                            <div class="mb-2">
                                <small class="text-muted">
                                    <strong>Objectif :</strong> 
                                    <?php
                                        if ($goal['type'] === 'reach_ideal') {
                                            echo 'IMC idéal (18.5 - 24.9)';
                                        } else {
                                            echo $goal['target_value'] . ' kg';
                                        }
                                    ?>
                                </small>
                            </div>

                            <div class="mb-2">
                                <small class="text-muted">
                                    <strong>Durée :</strong> <?= $goal['duration_days'] ?> jours
                                </small>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted">
                                    <strong>Poids actuel :</strong> <?= number_format($goal['current_weight'], 2) ?> kg
                                </small>
                                <br/>
                                <small class="text-muted">
                                    <strong>IMC actuel :</strong> <?= number_format($goal['current_imc'], 2) ?>
                                </small>
                            </div>

                            <!-- Progress bar -->
                            <div class="mb-3">
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar" role="progressbar" 
                                         style="width: <?= $goal['progress'] ?>%;" 
                                         aria-valuenow="<?= $goal['progress'] ?>" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                        <?= number_format($goal['progress'], 0) ?>%
                                    </div>
                                </div>
                            </div>

                            <!-- Status badge -->
                            <div class="mb-3">
                                <span class="badge 
                                    <?php
                                        $statusColor = [
                                            'pending'   => 'bg-warning',
                                            'active'    => 'bg-info',
                                            'completed' => 'bg-success',
                                            'cancelled' => 'bg-danger'
                                        ];
                                        echo $statusColor[$goal['status']] ?? 'bg-secondary';
                                    ?>
                                ">
                                    <?php
                                        $statusLabel = [
                                            'pending'   => 'En attente',
                                            'active'    => 'Actif',
                                            'completed' => 'Complété',
                                            'cancelled' => 'Annulé'
                                        ];
                                        echo $statusLabel[$goal['status']] ?? ucfirst($goal['status']);
                                    ?>
                                </span>
                            </div>

                            <!-- Actions -->
                            <div>
                                <?php if ($goal['status'] === 'pending'): ?>
                                    <a href="/goals/<?= $goal['id'] ?>/activate" class="btn btn-sm btn-success">
                                        Démarrer
                                    </a>
                                <?php endif; ?>

                                <?php if ($goal['status'] === 'active'): ?>
                                    <a href="/goals/<?= $goal['id'] ?>/complete" class="btn btn-sm btn-success">
                                        Marquer complété
                                    </a>
                                    <a href="/goals/<?= $goal['id'] ?>/plan" class="btn btn-sm btn-info">
                                        Voir mon plan
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
