<?php echo $this->extend('layout'); ?>

<?php echo $this->section('content'); ?>
<div class="page">
    <div class="card" style="border-top: 6px solid #e74c3c;">
        <div class="card__header">
            <p class="card__eyebrow" style="color: #e74c3c;">Zone de danger</p>
            <h1>Confirmation</h1>
            <p class="card__subtitle">
                Êtes-vous sûr de vouloir supprimer l'activité <strong><?= esc($activity['name'] ?? ''); ?></strong> ?
            </p>
        </div>

        <?php 
            $activityId = (int) ($activity['id'] ?? 0);
            $calories = (int) ($activity['calories_burn_per_hour'] ?? 0);
            $intensity = (string) ($activity['intensity'] ?? 'medium');
        ?>

        <div style="background: rgba(217, 124, 43, 0.05); border-radius: 16px; padding: 20px; margin: 20px 0; border: 1px solid var(--border); position: relative; z-index: 1;">
            <p style="margin: 0 0 10px; font-weight: 700; font-size: 14px; color: var(--ink);">Détails de l'activité :</p>
            <ul style="list-style: none; padding: 0; margin: 0; font-size: 14px; color: var(--muted); line-height: 1.6;">
                <li>• Énergie : <strong><?= number_format($calories); ?> kcal/h</strong></li>
                <li>• Effort : <strong><?= esc(ucfirst($intensity)); ?></strong></li>
            </ul>
        </div>

        <p style="color: #e74c3c; font-size: 13px; margin-bottom: 24px; font-weight: 500; position: relative; z-index: 1;">
            ⚠️ Attention : Cette action est irréversible.
        </p>

        <form method="post" action="/activities/<?= $activityId; ?>/destroy" class="form">
            <?= csrf_field(); ?>
            <div class="form-actions">
                <a href="/activities" class="button button--ghost" style="text-decoration: none; text-align: center; display: flex; align-items: center; justify-content: center;">
                    Annuler
                </a>
                <button type="submit" class="button" style="background: linear-gradient(120deg, #e74c3c, #c0392b);">
                    Supprimer
                </button>
            </div>
        </form>

        <div class="form-footer">
            <p style="font-size: 12px; color: var(--muted);">ID de l'activité : #<?= $activityId ?></p>
        </div>
    </div>
</div>
<?php echo $this->endSection(); ?>