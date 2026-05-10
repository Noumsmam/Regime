<?php echo $this->extend('layout'); ?>
<?php echo $this->section('content'); ?>

<div class="layout">
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="brand">
            <a href="/" class="brand__mark">FitLife</a>
            <span class="brand__tag">Nutrition</span>
        </div>

        <nav class="menu">
            <a href="/dashboard" class="menu__item">Tableau de bord</a>
            <a href="/goals" class="menu__item">Mes Objectifs</a>
            <a href="/regimes" class="menu__item active">Régimes & Menus</a>
            <a href="/offres" class="menu__item">Mes Options</a>
            <a href="/wallet" class="menu__item">Mon Portefeuille</a>
            
            <div class="menu__amount">
                <span>Solde FitWallet</span>
                <strong><?= number_format((float)($walletBalance ?? 0), 2, ',', ' ') ?>€</strong>
            </div>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="content">
        <header class="topbar">
            <div>
                <h1 style="font-family: 'Literata', serif; font-size: 28px; margin: 0;">Gestion des Régimes</h1>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Optimisez votre nutrition avec nos programmes sur mesure.</p>
            </div>
            <a href="/regimes/create" class="button button--primary">
                + Ajouter un régime
            </a>
        </header>

        <!-- Section Premium / Offres -->
        <?php if (!empty($userOptions)): ?>
            <div class="feature" style="background: linear-gradient(120deg, rgba(39, 174, 96, 0.1), rgba(46, 204, 113, 0.05)); border: 1px solid rgba(39, 174, 96, 0.2); margin-bottom: 25px; padding: 20px;">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <span style="font-size: 24px;">🎁</span>
                    <div>
                        <h3 style="margin: 0; font-size: 16px; color: #27ae60;">Options Premium Actives</h3>
                        <div style="display: flex; gap: 10px; margin-top: 8px;">
                            <?php foreach ($userOptions as $option): ?>
                                <span style="background: #27ae60; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;">
                                    <?= esc($option['libelle'] ?? '') ?> (-<?= $option['remise'] ?>%)
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="hero__card" style="margin-bottom: 25px; padding: 20px; display: flex; justify-content: space-between; align-items: center;">
                <p style="margin: 0; font-size: 14px; color: var(--muted);">
                    💡 Bénéficiez de <strong>15% de remise</strong> immédiate sur tous les régimes.
                </p>
                <a href="/offres" style="color: var(--accent); font-weight: 700; text-decoration: none; font-size: 14px;">Découvrir l'offre Gold →</a>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div style="background: rgba(39, 174, 96, 0.08); border: 1px solid rgba(39, 174, 96, 0.2); padding: 15px; border-radius: 12px; color: #27ae60; font-size: 14px; font-weight: 600; margin-bottom: 20px;">
                ✅ <?= session()->getFlashdata('success'); ?>
            </div>
        <?php endif; ?>

        <!-- Catalogue des Régimes -->
        <?php if (!empty($regimes)): ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 20px;">
                <?php foreach ($regimes as $regime): ?>
                    <div class="feature" style="display: flex; flex-direction: column; cursor: default;">
                        <header style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                            <div>
                                <h3 style="font-family: 'Literata', serif; font-size: 20px; margin: 0;"><?= htmlspecialchars($regime['name']); ?></h3>
                                <span style="font-size: 12px; color: var(--muted);"><?= number_format($regime['calories_per_day']); ?> kcal / jour</span>
                            </div>
                            <?php
                                $diffColors = ['easy' => '#2ecc71', 'medium' => '#f1c40f', 'hard' => '#e74c3c'];
                                $diffLabels = ['easy' => 'Facile', 'medium' => 'Moyen', 'hard' => 'Difficile'];
                                $color = $diffColors[$regime['difficulty']] ?? 'var(--muted)';
                            ?>
                            <span style="font-size: 10px; font-weight: 800; text-transform: uppercase; color: <?= $color ?>; border: 1px solid <?= $color ?>; padding: 2px 8px; border-radius: 4px;">
                                <?= $diffLabels[$regime['difficulty']] ?? $regime['difficulty']; ?>
                            </span>
                        </header>

                        <p style="font-size: 14px; color: var(--muted); line-height: 1.5; margin-bottom: 20px;">
                            <?= substr(htmlspecialchars($regime['description']), 0, 85); ?>...
                        </p>

                        <div style="background: var(--bg-main); border-radius: 10px; padding: 12px; margin-bottom: 20px; font-size: 12px;">
                            <div style="display: flex; justify-content: space-around; text-align: center;">
                                <div><strong style="display:block; color: var(--ink);"><?= $regime['pourcentage_viande']; ?>%</strong> Viande</div>
                                <div><strong style="display:block; color: var(--ink);"><?= $regime['pourcentage_poisson']; ?>%</strong> Poisson</div>
                                <div><strong style="display:block; color: var(--ink);"><?= $regime['pourcentage_volaille']; ?>%</strong> Volaille</div>
                            </div>
                        </div>

                        <!-- Zone Achat -->
                        <div style="margin-top: auto; padding-top: 15px; border-top: 1px solid var(--border);">
                            <form action="/regimes/<?= $regime['id']; ?>/buy" method="POST" style="display: flex; align-items: flex-end; gap: 10px;">
                                <?= csrf_field() ?>
                                <div style="flex: 1;">
                                    <label style="font-size: 10px; font-weight: 800; color: var(--muted); text-transform: uppercase; display: block; margin-bottom: 4px;">Durée (jours)</label>
                                    <input type="number" name="duration_days" min="7" max="365" value="30" 
                                           style="width: 100%; padding: 8px; border: 1px solid var(--border); border-radius: 8px; font-size: 14px;">
                                </div>
                                <button type="submit" class="button button--primary" style="padding: 10px 20px; font-size: 13px;">
                                    <?= !empty($regime['price']) ? number_format((float)$regime['price'], 2, ',', ' ') . '€' : 'Gratuit' ?>
                                </button>
                            </form>
                        </div>

                        <!-- Admin Actions -->
                        <div style="display: flex; justify-content: center; gap: 15px; margin-top: 15px;">
                            <a href="/regimes/<?= $regime['id']; ?>/edit" style="font-size: 12px; color: var(--muted); text-decoration: none; font-weight: 600;">Modifier</a>
                            <a href="/regimes/<?= $regime['id']; ?>/delete" style="font-size: 12px; color: #e74c3c; text-decoration: none; font-weight: 600;">Supprimer</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="hero__card" style="text-align: center; padding: 60px;">
                <p style="color: var(--muted);">Aucun régime n'est disponible pour le moment.</p>
                <a href="/regimes/create" class="button button--primary" style="margin-top: 15px;">Créer le premier régime</a>
            </div>
        <?php endif; ?>
    </main>
</div>

<?php echo $this->endSection(); ?>