<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="layout">
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="brand">
            <a href="/" class="brand__mark">FitLife</a>
            <span class="brand__tag">v2.4</span>
        </div>

        <nav class="menu">
            <a href="/dashboard" class="menu__item">Tableau de bord</a>
            <a href="/goals" class="menu__item active">Mes Objectifs</a>
            <a href="/activities" class="menu__item">Activités Sportives</a>
            <a href="/regimes" class="menu__item">Régimes & Menus</a>
            <a href="/offres" class="menu__item">Mes Options</a>
            <a href="/wallet" class="menu__item">Mon Portefeuille</a>
            
            <div class="menu__amount">
                <span>Solde disponible</span>
                <strong><?= number_format((float)($walletBalance ?? 0), 2, ',', ' ') ?>€</strong>
                <a href="/wallet" class="menu__recharge">+ Recharger</a>
            </div>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="content">
        <header class="topbar">
            <div>
                <h1 style="font-family: 'Literata', serif; font-size: 28px; margin: 0;">Mes Objectifs</h1>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Suivez votre transformation et vos étapes clés.</p>
            </div>
            <a href="/goals/create" class="button button--primary">
                + Nouvel Objectif
            </a>
        </header>

        <?php if (session()->getFlashdata('success')): ?>
            <div style="background: rgba(39, 174, 96, 0.08); border: 1px solid rgba(39, 174, 96, 0.2); padding: 15px; border-radius: 12px; color: #27ae60; font-size: 14px; font-weight: 600; margin-bottom: 25px;">
                ✅ <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (empty($goals)): ?>
            <section class="hero__card" style="text-align: center; padding: 60px 20px;">
                <h2 style="font-family: 'Literata', serif; margin-bottom: 10px;">Prêt pour le changement ?</h2>
                <p style="color: var(--muted); margin-bottom: 25px;">Vous n'avez pas encore défini d'objectifs santé pour le moment.</p>
                <a href="/goals/create" class="button button--primary">Définir mon premier objectif</a>
            </section>
        <?php else: ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px;">
                <?php foreach ($goals as $goal): ?>
                    <div class="feature" style="display: flex; flex-direction: column; cursor: default; padding: 25px;">
                        <header style="margin-bottom: 20px;">
                            <p class="card__eyebrow" style="margin-bottom: 5px;">
                                <?php
                                    $statusLabel = ['pending' => 'En attente', 'active' => 'En cours', 'completed' => 'Terminé', 'cancelled' => 'Annulé'];
                                    echo $statusLabel[$goal['status']] ?? ucfirst($goal['status']);
                                ?>
                            </p>
                            <h3 style="font-family: 'Literata', serif; font-size: 20px; margin: 0;">
                                <?php
                                    $typeLabel = ['gain' => 'Prise de poids', 'lose' => 'Perte de poids', 'reach_ideal' => 'Atteindre l\'IMC idéal'];
                                    echo $typeLabel[$goal['type']] ?? ucfirst($goal['type']);
                                ?>
                            </h3>
                        </header>

                        <div style="display: grid; gap: 10px; margin-bottom: 25px;">
                            <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--border); padding-bottom: 8px; font-size: 14px;">
                                <span style="color: var(--muted);">Cible</span>
                                <strong style="color: var(--ink);"><?= ($goal['type'] === 'reach_ideal') ? '18.5 - 24.9 IMC' : $goal['target_value'] . ' kg' ?></strong>
                            </div>
                            <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--border); padding-bottom: 8px; font-size: 14px;">
                                <span style="color: var(--muted);">Durée</span>
                                <strong style="color: var(--ink);"><?= $goal['duration_days'] ?> jours</strong>
                            </div>
                            <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--border); padding-bottom: 8px; font-size: 14px;">
                                <span style="color: var(--muted);">Actuel</span>
                                <strong style="color: var(--ink);"><?= number_format($goal['current_weight'], 1) ?> kg</strong>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div style="margin-bottom: 25px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 11px; font-weight: 800; text-transform: uppercase; color: var(--accent-strong);">
                                <span>Progression</span>
                                <span><?= number_format($goal['progress'], 0) ?>%</span>
                            </div>
                            <div style="width: 100%; background: var(--bg-main); height: 8px; border-radius: 10px; border: 1px solid var(--border); overflow: hidden;">
                                <div style="width: <?= $goal['progress'] ?>%; background: var(--gradient); height: 100%; border-radius: 10px; transition: width 1s ease-in-out;"></div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div style="margin-top: auto; display: flex; gap: 10px;">
                            <?php if ($goal['status'] === 'pending'): ?>
                                <a href="/goals/<?= $goal['id'] ?>/activate" class="button button--primary" style="flex: 1; text-align: center; font-size: 13px;">Démarrer</a>
                            <?php endif; ?>

                            <?php if ($goal['status'] === 'active'): ?>
                               regimes <a href="/goals/<?= $goal['id'] ?>/plan" class="button button--primary" style="flex: 1; text-align: center; font-size: 13px;">Voir le Plan</a>
                                <a href="/goals/<?= $goal['id'] ?>/complete" class="button button--ghost" style="flex: 1; text-align: center; font-size: 13px;">Terminer</a>
                            <?php endif; ?>
                            
                            <?php if ($goal['status'] === 'completed'): ?>
                                <div style="text-align: center; width: 100%; color: #27ae60; font-weight: 800; font-size: 13px; padding: 10px; background: rgba(39, 174, 96, 0.1); border-radius: 12px;">🏆 Objectif Atteint</div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <footer style="padding: 40px 0; text-align:center; color:var(--muted); font-size:12px; opacity: 0.7;">
            © 2026 FitLife — Votre parcours, votre réussite.
        </footer>
    </main>
</div>

<?php echo $this->endSection(); ?>