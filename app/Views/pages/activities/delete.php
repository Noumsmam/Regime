<?php echo $this->extend('layout'); ?>

<?php echo $this->section('content'); ?>
<div class="auth-container">
    <div class="card-auth" style="border-top: 6px solid #e74c3c;">
        <header style="margin-bottom: 25px;">
            <p style="text-transform: uppercase; letter-spacing: 0.1em; font-size: 11px; font-weight: 700; color: #e74c3c; margin-bottom: 8px;">Zone de danger</p>
            <h1 style="font-family: 'Literata', serif; font-size: 24px; margin-bottom: 8px;">Confirmation</h1>
            <p style="color: var(--muted); font-size: 14px;">
                Êtes-vous sûr de vouloir supprimer l'activité <strong><?= esc($activity['name'] ?? ''); ?></strong> ?
            </p>
        </header>

        <?php 
            $activityId = (int) ($activity['id'] ?? 0);
            $calories = (int) ($activity['calories_burn_per_hour'] ?? 0);
            $intensity = (string) ($activity['intensity'] ?? 'medium');
        ?>

        <!-- Encadré récapitulatif -->
        <div style="background: var(--bg-main); border-radius: 12px; padding: 16px; margin-bottom: 24px; border: 1px solid var(--border);">
            <p style="margin: 0 0 8px; font-weight: 700; font-size: 13px; color: var(--ink); text-transform: uppercase; letter-spacing: 0.05em;">Détails de l'activité</p>
            <ul style="list-style: none; padding: 0; margin: 0; font-size: 14px; color: var(--muted); line-height: 1.6;">
                <li>• Énergie : <strong style="color: var(--ink);"><?= number_format($calories); ?> kcal/h</strong></li>
                <li>• Effort : <strong style="color: var(--ink);"><?= esc(ucfirst($intensity)); ?></strong></li>
            </ul>
        </div>

        <p style="color: #e74c3c; font-size: 13px; margin-bottom: 24px; font-weight: 600; text-align: center;">
            ⚠️ Cette action est définitive et irréversible.
        </p>

        <form method="post" action="/activities/<?= $activityId; ?>/destroy" class="form">
            <?= csrf_field(); ?>
            
            <div style="display: flex; gap: 12px;">
                <a href="/activities" class="button button--ghost" style="flex: 1; text-align: center; text-decoration: none;">
                    Annuler
                </a>
                <button type="submit" class="button" style="flex: 1; background: linear-gradient(120deg, #e74c3c, #c0392b); color: white;">
                    Supprimer
                </button>
            </div>
        </form>

        <div style="margin-top: 25px; padding-top: 15px; border-top: 1px solid var(--border); text-align: center;">
            <p style="font-size: 11px; color: var(--muted); font-family: 'Space Grotesk', sans-serif;">
                REFERENCE_ID: #<?= $activityId ?>
            </p>
        </div>
    </div>
</div>
<?php echo $this->endSection(); ?>