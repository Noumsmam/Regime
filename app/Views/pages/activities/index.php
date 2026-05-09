<?php echo $this->extend('layout'); ?>
<?php echo $this->section('content'); ?>

<div class="page">
    <div style="width: 100%; max-width: 960px; margin-bottom: 32px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-family: 'Literata', serif; font-size: 32px; margin: 0;">Activités Sportives</h1>
            <p style="color: var(--muted); margin: 6px 0 0;">Catalogue des exercices et dépenses caloriques.</p>
        </div>
        <a href="/activities/create" class="button" style="text-decoration: none;">+ Ajouter une activité</a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div style="width: 100%; padding: 14px 20px; background: rgba(46, 204, 113, 0.1); color: #27ae60; border-radius: 14px; border: 1px solid rgba(46, 204, 113, 0.2); margin-bottom: 24px; font-weight: 600;">
            ✔ <?= session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>

    <?php if (empty($activities)): ?>
        <div class="card" style="width: 100%; text-align: center; padding: 60px 20px;">
            <div class="card__header">
                <p class="card__eyebrow">Catalogue vide</p>
                <h1>Aucune activité</h1>
                <p class="card__subtitle">Commencez par ajouter des activités sportives à votre base de données.</p>
            </div>
            <a href="/activities/create" class="button" style="text-decoration: none; margin-top: 16px;">Créer une activité</a>
        </div>
    <?php else: ?>
        <div style="display: grid; gap: 16px; width: 100%;">
            <?php foreach ($activities as $activity): ?>
                <?php
                    $intensity = (string) ($activity['intensity'] ?? 'medium');
                    $intensityColor = [
                        'low' => '#2ecc71',
                        'medium' => '#d97c2b',
                        'high' => '#e74c3c',
                    ];
                    $intensityLabel = [
                        'low' => 'Intensité Faible',
                        'medium' => 'Intensité Moyenne',
                        'high' => 'Intensité Élevée',
                    ];
                    $currentColor = $intensityColor[$intensity] ?? 'var(--muted)';
                ?>
                <div class="card" style="width: 100%; padding: 24px 32px; display: flex; flex-direction: row; align-items: center; justify-content: space-between; gap: 24px;">
                    
                    <div style="display: flex; align-items: center; gap: 24px; flex: 1;">
                        <!-- Barre d'intensité visuelle -->
                        <div style="width: 4px; height: 44px; background: <?= $currentColor ?>; border-radius: 4px; box-shadow: 0 0 12px <?= $currentColor ?>44;"></div>
                        
                        <div>
                            <h3 style="margin: 0; font-family: 'Space Grotesk', sans-serif; font-size: 19px; font-weight: 700; color: var(--ink);">
                                <?= esc($activity['name'] ?? ''); ?>
                            </h3>
                            <div style="margin-top: 4px; display: flex; align-items: center; gap: 12px;">
                                <span style="font-size: 14px; color: var(--muted); font-weight: 500;">
                                    🔥 <?= number_format((int)($activity['calories_burn_per_hour'] ?? 0)); ?> kcal / heure
                                </span>
                                <span style="font-size: 12px; color: <?= $currentColor ?>; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">
                                    • <?= $intensityLabel[$intensity] ?? $intensity ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Groupe d'actions -->
                    <div style="display: flex; gap: 12px; align-items: center;">
                        <a href="/activities/<?= $activity['id']; ?>/edit" class="button button--ghost" style="padding: 10px 20px; font-size: 14px; text-decoration: none; border-radius: 12px;">
                            Modifier
                        </a>
                        <a href="/activities/<?= $activity['id']; ?>/delete" class="button" style="padding: 10px 20px; font-size: 14px; text-decoration: none; background: #e74c3c; border-radius: 12px;">
                            Supprimer
                        </a>
                    </div>
                    
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php echo $this->endSection(); ?>