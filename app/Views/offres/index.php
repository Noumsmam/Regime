<?php $this->extend('layout'); ?>

<?php $this->section('content'); ?>
<div class="layout">
    <aside class="sidebar">
        <div class="brand">
            <a href="/" class="brand__mark" style="text-decoration:none;">FitLife</a>
            <span class="brand__tag">v2.4</span>
        </div>

        <nav class="menu">
            <a href="/dashboard" class="menu__item" style="text-decoration:none;">Tableau de bord</a>
            <a href="/goals" class="menu__item" style="text-decoration:none;">Mes Objectifs</a>
            <a href="/activities" class="menu__item" style="text-decoration:none;">Activités Sportives</a>
            <a href="/regimes" class="menu__item" style="text-decoration:none;">Régimes & Menus</a>
            <a href="/offres" class="menu__item" style="background: var(--accent); color: white; border: none; text-decoration:none;">Mes Options</a>
            <a href="/wallet" class="menu__item" style="text-decoration:none;">Mon Portefeuille</a>
            
            <div class="menu__amount" style="margin-top: 20px;">
                <span>Solde disponible</span>
                <strong><?= number_format((float)($walletBalance ?? 0), 2, ',', ' ') ?>€</strong>
                <a href="/wallet/deposit" style="font-size: 11px; color: var(--accent-strong); font-weight: 700; text-decoration: none; text-transform: uppercase; display:block; margin-top:5px;">+ Recharger</a>
            </div>
        </nav>
    </aside>

    <main class="content">
        <header class="topbar">
            <div class="topbar__links">
                <span class="topbar__link">Accueil / <strong>Mes Options Premium</strong></span>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="/profile" class="button button--ghost" style="padding: 8px 15px; text-decoration:none;">Profil</a>
                <a href="/logout" class="button button--ghost" style="padding: 8px 15px; border-color: #e74c3c; color: #e74c3c; text-decoration:none;">Déconnexion</a>
            </div>
        </header>

        <?php if (isset($error) || session()->has('error')): ?>
            <div style="padding: 15px; background: rgba(231, 76, 60, 0.1); color: #e74c3c; border-radius: 12px; border: 1px solid rgba(231, 76, 60, 0.2); margin-bottom: 20px; font-size: 14px;">
                <strong>Erreur :</strong> <?= $error ?? session('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->has('success')): ?>
            <div style="padding: 15px; background: rgba(46, 204, 113, 0.1); color: #27ae60; border-radius: 12px; border: 1px solid rgba(46, 204, 113, 0.2); margin-bottom: 20px; font-size: 14px;">
                <strong>Succès :</strong> <?= session('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->has('info')): ?>
            <div style="padding: 15px; background: rgba(52, 152, 219, 0.1); color: #2980b9; border-radius: 12px; border: 1px solid rgba(52, 152, 219, 0.2); margin-bottom: 20px; font-size: 14px;">
                <?= session('info') ?>
            </div>
        <?php endif; ?>

        <section class="hero" style="margin-bottom: 30px;">
            <div class="hero__card" style="border-left: 6px solid var(--accent-strong);">
                <p class="card__eyebrow">Abonnements</p>
                <h1>Options Actives</h1>
                
                <?php if (!empty($userOffres)): ?>
                    <div style="display: grid; gap: 10px; margin-top: 20px;">
                        <?php foreach ($userOffres as $offre): ?>
                            <div style="background: white; padding: 15px 20px; border-radius: 12px; display: flex; justify-content: space-between; align-items: center; border: 1px solid var(--border);">
                                <span style="font-weight: 700;"><?= esc($offre['libelle']) ?></span>
                                <span style="font-size: 12px; font-weight: 700; color: #27ae60;">ACTIF</span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p style="margin-top:15px; color: var(--muted);">Aucune option active pour le moment.</p>
                <?php endif; ?>
            </div>
        </section>

        <h2 style="font-family: 'Literata', serif; font-size: 20px; margin: 30px 0 15px;">Offres de la boutique</h2>
        
        <?php if (empty($offres)): ?>
            <div class="card"><p style="text-align:center; color:var(--muted);">Aucune option disponible.</p></div>
        <?php else: ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 40px;">
                <?php foreach ($offres as $offre): ?>
                    <div class="chart-card" style="display: flex; flex-direction: column; justify-content: space-between; padding: 25px;">
                        <div>
                            <p class="card__eyebrow">Premium</p>
                            <h3 style="margin: 5px 0 10px;"><?= esc($offre['libelle']) ?></h3>
                            <p style="font-size: 14px; color: var(--muted); margin-bottom: 15px;">
                                Remise permanente de <strong><?= $offre['remise'] ?>%</strong> sur vos achats.
                            </p>
                        </div>

                        <div style="margin-top: auto; padding-top: 15px; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between;">
                            <?php if (in_array($offre['id'], $userOffreIds)): ?>
                                <span style="font-weight: 700; color: var(--muted);">Déjà possédé</span>
                                <button class="button button--ghost" disabled style="opacity: 0.5;">✓</button>
                            <?php else: ?>
                                <?php if (isset($offre['price']) && $offre['price'] !== null): ?>
                                    <span style="font-size: 18px; font-weight: 800;"><?= number_format((float)$offre['price'], 2, ',', ' ') ?>€</span>
                                    <form action="/offres/buy/<?= $offre['id'] ?>" method="POST">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="button">Acheter</button>
                                    </form>
                                <?php else: ?>
                                    <span style="color: var(--muted);">Gratuit</span>
                                    <button class="button button--ghost" disabled>Indisponible</button>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <section class="gold">
            <div class="gold__card">
                <div>
                    <h2>🌟 Avantages du compte Gold</h2>
                    <ul style="list-style: none; padding: 0; margin: 15px 0 0; font-size: 14px; line-height: 1.6;">
                        <li>• 15% de remise sur tous les régimes premium</li>
                        <li>• Accès illimité aux recettes exclusives</li>
                        <li>• Support prioritaire 24h/24</li>
                    </ul>
                </div>
                <div style="text-align: right;">
                    <div style="font-size: 24px; font-weight: 800;"><?= number_format(9.99, 2, ',', ' ') ?>€</div>
                    <div style="font-size: 12px; opacity: 0.8;">Paiement unique</div>
                </div>
            </div>
        </section>

        <footer class="footer">
            © 2026 FitLife — Plateforme de Gestion Santé
        </footer>
    </main>
</div>
<?php $this->endSection(); ?>