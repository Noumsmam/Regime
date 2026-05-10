<?php echo $this->extend('layout'); ?>
<?php echo $this->section('content'); ?>

<div class="layout">
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="brand">
            <a href="/" class="brand__mark">FitLife</a>
            <span class="brand__tag">Admin</span>
        </div>

        <nav class="menu">
            <a href="/dashboard" class="menu__item">Tableau de bord</a>
            <a href="/activities" class="menu__item">Activités Sportives</a>
            <a href="/parametres" class="menu__item active">Paramètres Système</a>
            <a href="/users" class="menu__item">Utilisateurs</a>
            <div class="menu__amount">
                <span>Santé du Système</span>
                <strong>Opérationnel</strong>
            </div>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="content">
        <header class="topbar">
            <div>
                <h1 style="font-family: 'Literata', serif; font-size: 28px; margin: 0;">Paramètres système</h1>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Configuration globale et variables de l'application.</p>
            </div>
            <a href="/parametres/create" class="button button--primary">
                + Ajouter un paramètre
            </a>
        </header>

        <!-- Alertes de session -->
        <?php if (session()->getFlashdata('success')): ?>
            <div style="background: rgba(39, 174, 96, 0.08); border: 1px solid rgba(39, 174, 96, 0.2); padding: 15px; border-radius: 12px; color: #27ae60; font-size: 14px; font-weight: 600; margin-bottom: 20px;">
                ✅ <?= session()->getFlashdata('success'); ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div style="background: rgba(231, 76, 60, 0.08); border: 1px solid rgba(231, 76, 60, 0.2); padding: 15px; border-radius: 12px; color: #e74c3c; font-size: 14px; font-weight: 600; margin-bottom: 20px;">
                ⚠️ <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($parametres)): ?>
            <div style="display: grid; gap: 12px;">
                <?php foreach ($parametres as $parametre): ?>
                    <?php
                        $parametreId = (int) ($parametre['id'] ?? 0);
                        $nom = (string) ($parametre['nom'] ?? '');
                        $valeur = (string) ($parametre['valeur'] ?? '');
                        $categorie = (string) ($parametre['categorie'] ?? 'Général');
                        $isActive = !empty($parametre['is_active']);
                    ?>
                    <div class="feature" style="display: flex; flex-direction: row; align-items: center; justify-content: space-between; padding: 16px 24px; cursor: default;">
                        
                        <div style="display: flex; align-items: center; gap: 20px; flex: 1;">
                            <!-- Indicateur de statut -->
                            <div style="width: 10px; height: 10px; background: <?= $isActive ? '#2ecc71' : 'var(--muted)' ?>; border-radius: 50%; box-shadow: 0 0 8px <?= $isActive ? '#2ecc71' : 'transparent' ?>;"></div>
                            
                            <div style="flex: 1;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <h3 style="margin: 0; font-family: 'Space Grotesk', sans-serif; font-size: 16px; font-weight: 700; color: var(--ink);">
                                        <?= esc($nom); ?>
                                    </h3>
                                    <span style="font-size: 10px; padding: 2px 8px; background: var(--bg-main); border: 1px solid var(--border); border-radius: 20px; color: var(--muted); text-transform: uppercase; font-weight: 700;">
                                        <?= esc($categorie); ?>
                                    </span>
                                </div>
                                <p style="margin: 4px 0 0; font-size: 14px; color: var(--accent-strong); font-family: 'Space Grotesk', sans-serif;">
                                    <?= esc($valeur); ?>
                                </p>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div style="display: flex; gap: 8px;">
                            <a href="/parametres/<?= $parametreId; ?>/edit" class="button button--ghost" style="padding: 8px 14px; font-size: 12px;">
                                Modifier
                            </a>
                            <a href="/parametres/<?= $parametreId; ?>/delete" class="button" style="padding: 8px 14px; font-size: 12px; background: rgba(231, 76, 60, 0.05); color: #e74c3c; border: 1px solid rgba(231, 76, 60, 0.1);">
                                Supprimer
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="hero__card" style="text-align: center; padding: 50px;">
                <p style="color: var(--muted);">Aucun paramètre n'a été configuré.</p>
                <a href="/parametres/create" class="button button--primary" style="margin-top: 15px;">Créer le premier paramètre</a>
            </div>
        <?php endif; ?>

        <footer style="padding: 40px 0; text-align:center; color:var(--muted); font-size:12px; opacity: 0.6;">
            FitLife Core Service — Version 2.4.0
        </footer>
    </main>
</div>

<?php echo $this->endSection(); ?>