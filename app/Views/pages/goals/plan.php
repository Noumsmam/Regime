<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1>Mon Plan - 
                <?php
                    $typeLabel = [
                        'gain'         => 'Augmenter poids',
                        'lose'         => 'Réduire poids',
                        'reach_ideal'  => 'Atteindre IMC idéal'
                    ];
                    echo $typeLabel[$goal['type']] ?? ucfirst($goal['type']);
                ?>
            </h1>
        </div>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Goal Info -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informations de l'Objectif</h5>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <strong>Type :</strong> 
                        <?php
                            $typeLabel = [
                                'gain'         => 'Augmenter poids',
                                'lose'         => 'Réduire poids',
                                'reach_ideal'  => 'Atteindre IMC idéal'
                            ];
                            echo $typeLabel[$goal['type']] ?? ucfirst($goal['type']);
                        ?>
                    </div>
                    <div class="mb-2">
                        <strong>Objectif :</strong> 
                        <?php
                            if ($goal['type'] === 'reach_ideal') {
                                echo 'IMC idéal (18.5 - 24.9)';
                            } else {
                                echo $goal['target_value'] . ' kg';
                            }
                        ?>
                    </div>
                    <div class="mb-2">
                        <strong>Durée :</strong> <?= $goal['duration_days'] ?> jours
                    </div>
                    <div class="mb-2">
                        <strong>Statut :</strong> 
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
                    <div class="mb-2">
                        <strong>Début :</strong> 
                        <?= $goal['start_date'] ? date('d/m/Y à H:i', strtotime($goal['start_date'])) : 'Non commencé' ?>
                    </div>
                    <div>
                        <strong>Fin prévue :</strong> 
                        <?= $goal['end_date'] ? date('d/m/Y à H:i', strtotime($goal['end_date'])) : 'N/A' ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Plan Info -->
        <?php if ($goal['plan']): ?>
            <!-- Régime Card -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Régime Recommandé</h5>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title"><?= htmlspecialchars($goal['plan']['regime_name'] ?? 'N/A') ?></h6>
                        <div class="mb-2">
                            <strong>Calories par jour :</strong> 
                            <span class="badge bg-info"><?= $goal['plan']['calories_per_day'] ?? 'N/A' ?> kcal</span>
                        </div>
                        <div class="mb-3">
                            <strong>Description :</strong><br>
                            <small><?= htmlspecialchars($goal['plan']['regime_description'] ?? 'Pas de description') ?></small>
                        </div>
                        <div class="alert alert-info">
                            <small>
                                <strong>💡 Conseil :</strong> Suivez ce régime quotidiennement et combinez-le avec l'activité recommandée pour optimiser vos résultats.
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activité Card -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">Activité Sportive</h5>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title"><?= htmlspecialchars($goal['plan']['activity_name'] ?? 'N/A') ?></h6>
                        <div class="mb-2">
                            <strong>Calories brûlées par heure :</strong> 
                            <span class="badge bg-danger"><?= $goal['plan']['calories_burn_per_hour'] ?? 'N/A' ?> kcal</span>
                        </div>
                        <div class="mb-2">
                            <strong>Durée recommandée :</strong> 
                            <span class="badge bg-primary"><?= $goal['plan']['minutes_per_day'] ?? 30 ?> minutes/jour</span>
                        </div>
                        <div class="mb-3">
                            <strong>Bénéfices :</strong><br>
                            <small>
                                <?php
                                    $caloriePerMin = $goal['plan']['calories_burn_per_hour'] / 60;
                                    $caloriePerDay = $caloriePerMin * $goal['plan']['minutes_per_day'];
                                    echo "Avec " . $goal['plan']['minutes_per_day'] . " minutes de " . htmlspecialchars($goal['plan']['activity_name']) . ", vous brûlez environ " . round($caloriePerDay) . " kcal par jour.";
                                ?>
                            </small>
                        </div>
                        <div class="alert alert-success">
                            <small>
                                <strong>✅ Astuce :</strong> Pratiquez régulièrement cette activité pour obtenir les meilleurs résultats avec votre régime.
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Plan Summary -->
            <div class="col-md-12 mb-4">
                <div class="card bg-light">
                    <div class="card-header">
                        <h5 class="mb-0">Résumé de Votre Plan Quotidien</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <h6>Apport Calorique</h6>
                                <p class="display-6 text-success"><?= $goal['plan']['calories_per_day'] ?? 'N/A' ?> kcal</p>
                                <small class="text-muted">Régime</small>
                            </div>
                            <div class="col-md-4">
                                <h6>Dépense Calorique</h6>
                                <p class="display-6 text-danger">
                                    <?php
                                        $caloriePerMin = $goal['plan']['calories_burn_per_hour'] / 60;
                                        $caloriePerDay = round($caloriePerMin * $goal['plan']['minutes_per_day']);
                                        echo $caloriePerDay . ' kcal';
                                    ?>
                                </p>
                                <small class="text-muted"><?= $goal['plan']['minutes_per_day'] ?> min d'activité</small>
                            </div>
                            <div class="col-md-4">
                                <h6>Bilan Calorique</h6>
                                <p class="display-6 text-info">
                                    <?php
                                        $caloriePerMin = $goal['plan']['calories_burn_per_hour'] / 60;
                                        $caloriePerDay = round($caloriePerMin * $goal['plan']['minutes_per_day']);
                                        $bilan = $goal['plan']['calories_per_day'] - $caloriePerDay;
                                        echo ($bilan > 0 ? '+' : '') . $bilan . ' kcal';
                                    ?>
                                </p>
                                <small class="text-muted">Journalier</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="col-md-12">
                <div class="alert alert-info">
                    <strong>ℹ️ Note :</strong> Activez cet objectif pour que nous recommandions automatiquement un régime et une activité sportive adaptée.
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-4">
        <a href="/goals" class="btn btn-secondary">Retour aux objectifs</a>
    </div>
</div>

<?= $this->endSection() ?>
