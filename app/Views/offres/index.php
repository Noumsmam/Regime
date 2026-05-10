<?php $this->extend('layout'); ?>

<?php $this->section('content'); ?>
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
            <a href="/activities" class="menu__item">Activités Sportives</a>
            <a href="/regimes" class="menu__item">Régimes & Menus</a>
            <a href="/offres" class="menu__item active">Mes Options</a>
            <a href="/wallet" class="menu__item">Mon Portefeuille</a>
            
            <div class="menu__amount">
                <span>Solde disponible</span>
                <strong><?= number_format((float)($walletBalance ?? 0), 2, ',', ' ') ?>€</strong>
                <a href="/wallet/deposit" class="menu__recharge">+ Recharger</a>
            </div>
        </nav>
    </aside>

    <main class="content">
        <!-- TOPBAR -->
        <header class="topbar">
            <div class="topbar__links">
                <span class="topbar__link">Accueil / <strong>Mes Options Premium</strong></span>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="/profile" class="button button--ghost" style="padding: 8px 15px;">Profil</a>
                <a href="/logout" class="button button--ghost" style="padding: 8px 15px; border-color: #e74c3c; color: #e74c3c;">Déconnexion</a>
            </div>
        </header>

        <!-- NOTIFICATIONS -->
        <?php if (isset($error) || session()->has('error')): ?>
            <div style="background: rgba(231, 76, 60, 0.08); border: 1px solid rgba(231, 76, 60, 0.2); padding: 15px; border-radius: 12px; color: #e74c3c; font-size: 14px; font-weight: 600;">
                ⚠️ <?= $error ?? session('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->has('success')): ?>
            <div style="background: rgba(39, 174, 96, 0.08); border: 1px solid rgba(39, 174, 96, 0.2); padding: 15px; border-radius: 12px; color: #27ae60; font-size: 14px; font-weight: 600;">
                ✅ <?= session('success') ?>
            </div>
        <?php endif; ?>

        <!-- OPTIONS ACTIVES -->
        <section class="hero">
            <div class="hero__card" style="border-left: 6px solid var(--accent-strong);">
                <p class="card__eyebrow">Abonnements</p>
                <h1 style="font-family: 'Literata', serif; margin: 10px 0;">Options Actives</h1>
                
                <?php if (!empty($userOffres)): ?>
                    <div style="display: grid; gap: 12px; margin-top: 20px;">
                        <?php foreach ($userOffres as $offre): ?>
                            <div style="background: var(--bg-main); padding: 15px 20px; border-radius: 12px; display: flex; justify-content: space-between; align-items: center; border: 1px solid var(--border);">
                                <span style="font-weight: 700; color: var(--ink);"><?= esc($offre['libelle']) ?></span>
                                <span style="font-size: 11px; font-weight: 800; color: #27ae60; background: rgba(39, 174, 96, 0.1); padding: 4px 10px; border-radius: 20px;">ACTIF</span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p style="margin-top:15px; color: var(--muted); font-size: 14px;">Aucune option active pour le moment.</p>
                <?php endif; ?>
            </div>
        </section>

        <h2 style="font-family: 'Literata', serif; font-size: 20px; margin: 10px 0;">Offres de la boutique</h2>
        
        <?php if (empty($offres)): ?>
            <div class="hero__card"><p style="text-align:center; color:var(--muted);">Aucune option disponible.</p></div>
        <?php else: ?>
            <div class="features"> <!-- Utilisation de la grille 'features' du bundle -->
                <?php foreach ($offres as $offre): ?>
                    <div class="feature" style="display: flex; flex-direction: column; justify-content: space-between; cursor: default;">
                        <div>
                            <p class="card__eyebrow" style="margin-bottom: 5px;">Premium</p>
                            <h3 style="font-family: 'Literata', serif; font-size: 18px; margin-bottom: 10px;"><?= esc($offre['libelle']) ?></h3>
                            <p style="font-size: 13px; color: var(--muted); line-height: 1.4;">
                                Remise permanente de <strong style="color: var(--accent-strong);"><?= $offre['remise'] ?>%</strong> sur tous vos futurs achats de régimes.
                            </p>
                        </div>

                        <div style="margin-top: 25px; padding-top: 15px; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; gap: 10px;">
                            <?php if (in_array($offre['id'], $userOffreIds)): ?>
                                <span style="font-size: 12px; font-weight: 700; color: var(--muted);">Possédé</span>
                                <span style="color: var(--accent);">✓</span>
                            <?php else: ?>
                                <?php if (isset($offre['price'])): ?>
                                    <span style="font-size: 18px; font-weight: 800; color: var(--ink);"><?= number_format((float)$offre['price'], 2, ',', ' ') ?>€</span>
                                    <form action="/offres/buy/<?= $offre['id'] ?>" method="POST">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="button button--primary" style="padding: 8px 16px; font-size: 12px;">Acheter</button>
                                    </form>
                                <?php else: ?>
                                    <span style="color: var(--muted); font-size: 13px;">Indisponible</span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- SECTION GOLD AMÉLIORÉE -->
        <section class="gold" style="margin-top: 20px;">
            <div class="hero__card" style="background: linear-gradient(135deg, #fff 0%, #fff9f0 100%); border: 1px solid #ffd700;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 20px;">
                    <div style="flex: 2; min-width: 280px;">
                        <h2 style="font-family: 'Literata', serif; font-size: 22px; margin-bottom: 10px;">🌟 Devenez Membre Gold</h2>
                        <ul style="list-style: none; padding: 0; margin: 0; font-size: 13px; color: var(--muted); display: grid; gap: 8px;">
                            <li>✅ <strong>15% de remise</strong> sur tous les régimes premium</li>
                            <li>✅ Accès illimité aux <strong>recettes exclusives</strong></li>
                            <li>✅ Support prioritaire 24h/24</li>
                        </ul>
                    </div>
                    <div style="flex: 1; min-width: 150px; text-align: right; display: flex; flex-direction: column; justify-content: center;">
                        <div style="font-size: 28px; font-weight: 900; color: var(--ink);"><?= number_format(9.99, 2, ',', ' ') ?>€</div>
                        <div style="font-size: 11px; color: var(--muted); margin-bottom: 15px;">Paiement unique à vie</div>
                        <a href="/gold" class="button button--primary" style="background: #ffd700; color: #000; box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);">Améliorer maintenant</a>
                    </div>
                </div>
            </div>
        </section>

        <footer style="padding: 40px 0; text-align:center; color:var(--muted); font-size:12px; opacity: 0.7;">
            © 2026 FitLife — Votre plateforme santé haut de gamme
        </footer>
    </main>
</div>
<?php $this->endSection(); ?>