<?php echo $this->extend('layout'); ?>
<?php echo $this->section('content'); ?>

<div class="auth-container">
    <div class="card-auth" style="border-top: 6px solid #e74c3c;">
        <header style="margin-bottom: 25px;">
            <p style="text-transform: uppercase; letter-spacing: 0.1em; font-size: 11px; font-weight: 700; color: #e74c3c; margin-bottom: 8px;">Action Irréversible</p>
            <h1 style="font-family: 'Literata', serif; font-size: 24px; margin-bottom: 8px;">Supprimer le régime</h1>
            
            <p style="color: var(--muted); font-size: 14px;">
                Êtes-vous sûr de vouloir supprimer le régime <strong><?= htmlspecialchars($regime['name']); ?></strong> ?
            </p>
        </header>

        <!-- Détails du régime pour confirmation -->
        <div style="background: var(--bg-main); border-radius: 12px; padding: 20px; margin-bottom: 24px; border: 1px solid var(--border);">
            <p style="margin: 0 0 12px; font-weight: 700; font-size: 13px; color: var(--ink); text-transform: uppercase; letter-spacing: 0.05em;">Récapitulatif nutritionnel</p>
            
            <div style="display: grid; gap: 8px; font-size: 14px; color: var(--muted);">
                <div style="display: flex; justify-content: space-between;">
                    <span>Objectif :</span>
                    <strong style="color: var(--ink);"><?= number_format($regime['calories_per_day']); ?> kcal / jour</strong>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span>Difficulté :</span>
                    <strong style="color: var(--ink);">
                        <?php
                            $labels = ['easy' => 'Facile', 'medium' => 'Moyen', 'hard' => 'Difficile'];
                            echo $labels[$regime['difficulty']] ?? $regime['difficulty'];
                        ?>
                    </strong>
                </div>
                <div style="display: flex; justify-content: space-between; border-top: 1px dashed var(--border); pt-8; mt-4;">
                    <span>Composition :</span>
                    <span style="font-size: 12px; font-weight: 600; color: var(--accent-strong);">
                        V: <?= $regime['pourcentage_viande']; ?>% | 
                        P: <?= $regime['pourcentage_poisson']; ?>% | 
                        Vol: <?= $regime['pourcentage_volaille']; ?>%
                    </span>
                </div>
            </div>
        </div>

        <div style="background: rgba(231, 76, 60, 0.05); padding: 12px; border-radius: 8px; margin-bottom: 24px;">
            <p style="color: #e74c3c; font-size: 12px; margin: 0; font-weight: 600; text-align: center; line-height: 1.4;">
                ⚠️ Cette action supprimera également tous les plans alimentaires associés à ce régime.
            </p>
        </div>

        <form method="post" action="/regimes/<?= $regime['id']; ?>/destroy" class="form">
            <?= csrf_field(); ?>
            
            <div style="display: flex; gap: 12px;">
                <a href="/regimes" class="button button--ghost" style="flex: 1; text-align: center; text-decoration: none;">
                    Annuler
                </a>
                <button type="submit" class="button" style="flex: 1; background: linear-gradient(120deg, #e74c3c, #c0392b); color: white;">
                    Confirmer
                </button>
            </div>
        </form>

        <div style="margin-top: 25px; padding-top: 15px; border-top: 1px solid var(--border); text-align: center;">
            <p style="font-size: 11px; color: var(--muted); font-family: 'Space Grotesk', sans-serif;">
                ID_REGIME: #<?= $regime['id']; ?>
            </p>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>