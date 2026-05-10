<?php echo $this->extend('layout'); ?>
<?php echo $this->section('content'); ?>

<div class="layout">
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="brand">
            <a href="/" class="brand__mark">FitLife</a>
            <span class="brand__tag">v2.4</span>
        </div>

        <nav class="menu">
            <a href="/dashboard" class="menu__item">Tableau de bord</a>
            <a href="/goals" class="menu__item">Mes Objectifs</a>
            <a href="/activities" class="menu__item active">Activités Sportives</a>
            <a href="/regimes" class="menu__item">Régimes & Menus</a>
            <a href="/offres" class="menu__item">Mes Options</a>
            <a href="/wallet" class="menu__item">Mon Portefeuille</a>
            
            <div class="menu__amount">
                <span>Solde disponible</span>
                <strong><?= number_format((float)($walletBalance ?? 0), 2, ',', ' ') ?>€</strong>
                <a href="/wallet/deposit" class="menu__recharge">+ Recharger</a>
            </div>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="content">
        <header class="topbar">
            <div>
                <h1 style="font-family: 'Literata', serif; font-size: 28px; margin: 0;">Activités Sportives</h1>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Catalogue des exercices et dépenses caloriques.</p>
            </div>
            <a href="/activities/create" class="button button--primary">
                <span style="margin-right: 8px;">+</span> Ajouter une activité
            </a>
        </header>

        <!-- Message de succès -->
        <?php if (session()->getFlashdata('success')): ?>
            <div style="background: rgba(39, 174, 96, 0.08); border: 1px solid rgba(39, 174, 96, 0.2); padding: 15px; border-radius: 12px; color: #27ae60; font-size: 14px; font-weight: 600;">
                ✅ <?= session()->getFlashdata('success'); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($activities)): ?>
            <section class="hero__card" style="text-align: center; padding: 60px 20px;">
                <h2 style="font-family: 'Literata', serif; margin-bottom: 10px;">Aucune activité</h2>
                <p style="color: var(--muted); margin-bottom: 25px;">Votre catalogue est actuellement vide.</p>
                <a href="/activities/create" class="button button--primary">Créer la première activité</a>
            </section>
        <?php else: ?>
            <div style="display: grid; gap: 16px;">
                <?php foreach ($activities as $activity): ?>
                    <?php
                        $intensity = (string) ($activity['intensity'] ?? 'medium');
                        $intensityColor = [
                            'low' => '#2ecc71',
                            'medium' => 'var(--accent)',
                            'high' => '#e74c3c',
                        ];
                        $currentColor = $intensityColor[$intensity] ?? 'var(--muted)';
                    ?>
                    <div class="feature" style="display: flex; flex-direction: row; align-items: center; justify-content: space-between; padding: 20px 30px; cursor: default;">
                        
                        <div style="display: flex; align-items: center; gap: 20px;">
                            <!-- Indicateur d'intensité -->
                            <div style="width: 4px; height: 40px; background: <?= $currentColor ?>; border-radius: 4px; box-shadow: 0 0 10px <?= $currentColor ?>44;"></div>
                            
                            <div>
                                <h3 style="margin: 0; font-family: 'Space Grotesk', sans-serif; font-size: 18px; font-weight: 700; color: var(--ink);">
                                    <?= esc($activity['name'] ?? ''); ?>
                                </h3>
                                <div style="display: flex; align-items: center; gap: 12px; margin-top: 4px;">
                                    <span style="font-size: 13px; color: var(--muted);">
                                        🔥 <strong><?= number_format((int)($activity['calories_burn_per_hour'] ?? 0)); ?></strong> kcal/h
                                    </span>
                                    <span style="font-size: 11px; color: <?= $currentColor ?>; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;">
                                        • <?= esc($intensity) ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div style="display: flex; gap: 10px;">
                            <a href="/activities/<?= $activity['id']; ?>/edit" class="button button--ghost" style="padding: 8px 16px; font-size: 13px;">
                                Modifier
                            </a>
                            <a href="/activities/<?= $activity['id']; ?>/delete" class="button" style="padding: 8px 16px; font-size: 13px; background: rgba(231, 76, 60, 0.1); color: #e74c3c; border: 1px solid rgba(231, 76, 60, 0.2);">
                                Supprimer
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <footer style="padding: 40px 0; text-align:center; color:var(--muted); font-size:12px; opacity: 0.7;">
            © 2026 FitLife — Gestion de catalogue sport
        </footer>
    </main>
</div>

<?php echo $this->endSection(); ?>