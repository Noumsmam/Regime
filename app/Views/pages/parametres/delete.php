<?php echo $this->extend('layout'); ?>
<?php echo $this->section('content'); ?>

<div class="auth-container">
    <div class="card-auth" style="border-top: 6px solid #e74c3c;">
        <header style="margin-bottom: 25px;">
            <p style="text-transform: uppercase; letter-spacing: 0.1em; font-size: 11px; font-weight: 700; color: #e74c3c; margin-bottom: 8px;">Action Irréversible</p>
            <h1 style="font-family: 'Literata', serif; font-size: 24px; margin-bottom: 8px;">Supprimer le paramètre</h1>
            
            <?php 
                $parametreId = (int) ($parametre['id'] ?? 0);
                $nom = (string) ($parametre['nom'] ?? '');
                $valeur = (string) ($parametre['valeur'] ?? '');
                $categorie = (string) ($parametre['categorie'] ?? '—');
            ?>

            <p style="color: var(--muted); font-size: 14px;">
                Êtes-vous sûr de vouloir retirer <strong><?= esc($nom); ?></strong> de la configuration ?
            </p>
        </header>

        <!-- Détails techniques dans un encadré discret -->
        <div style="background: var(--bg-main); border-radius: 12px; padding: 16px; margin-bottom: 24px; border: 1px solid var(--border);">
            <p style="margin: 0 0 8px; font-weight: 700; font-size: 13px; color: var(--ink); text-transform: uppercase; letter-spacing: 0.05em;">Récapitulatif</p>
            <ul style="list-style: none; padding: 0; margin: 0; font-size: 14px; color: var(--muted); line-height: 1.6;">
                <li>• Valeur actuelle : <strong style="color: var(--ink);"><?= esc($valeur); ?></strong></li>
                <li>• Catégorie : <strong style="color: var(--ink);"><?= esc($categorie); ?></strong></li>
            </ul>
        </div>

        <p style="color: #e74c3c; font-size: 13px; margin-bottom: 24px; font-weight: 600; text-align: center;">
            ⚠️ Attention : La suppression peut impacter le comportement de l'application.
        </p>

        <form method="post" action="/parametres/<?= $parametreId; ?>/destroy" class="form">
            <?= csrf_field(); ?>
            
            <div style="display: flex; gap: 12px;">
                <a href="/parametres" class="button button--ghost" style="flex: 1; text-align: center; text-decoration: none;">
                    Annuler
                </a>
                <button type="submit" class="button" style="flex: 1; background: linear-gradient(120deg, #e74c3c, #c0392b); color: white;">
                    Confirmer la suppression
                </button>
            </div>
        </form>

        <div style="margin-top: 25px; padding-top: 15px; border-top: 1px solid var(--border); text-align: center;">
            <p style="font-size: 11px; color: var(--muted); font-family: 'Space Grotesk', sans-serif;">
                PARAM_ID: #<?= $parametreId ?>
            </p>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>