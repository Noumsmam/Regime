<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="layout">
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="brand">
            <a href="/" class="brand__mark" style="text-decoration:none;">FitLife</a>
            <span class="brand__tag">v2.4</span>
        </div>

        <nav class="menu">
            <a href="/dashboard" class="menu__item" style="background: var(--accent); color: white; border: none; text-decoration:none;">Tableau de bord</a>
            <a href="/goals" class="menu__item" style="text-decoration:none;">Mes Objectifs</a>
            <a href="/activities" class="menu__item" style="text-decoration:none;">Activités Sportives</a>
            <a href="/regimes" class="menu__item" style="text-decoration:none;">Régimes & Menus</a>
            <a href="/wallet" class="menu__item" style="text-decoration:none;">Mon Portefeuille</a>
            
            <div class="menu__amount" style="margin-top: 20px;">
                <span>Solde disponible</span>
                <a href="/wallet" style="text-decoration:none; color:inherit;">
                    <strong><?= number_format((float)($walletBalance ?? 0), 2, ',', ' ') ?>€</strong>
                </a>
                <a href="/wallet/deposit" style="font-size: 11px; color: var(--accent-strong); font-weight: 700; text-decoration: none; text-transform: uppercase; display:block; margin-top:5px;">+ Recharger</a>
            </div>
        </nav>
    </aside>

    <main class="content">
        <!-- TOPBAR -->
        <header class="topbar">
            <div class="topbar__links">
                <span class="topbar__link">Accueil / <strong>Tableau de bord</strong></span>
            </div>
            <div style="display: flex; gap: 10px; align-items:center;">
                <!-- Bouton Exporter -->
                <a href="/dashboard/export" class="button button--ghost" style="padding: 8px 15px; text-decoration:none; display:flex; align-items:center;">
                    <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" fill="none" style="margin-right:8px"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                    Exporter
                </a>
                <a href="/profile" class="button button--ghost" style="padding: 8px 15px; text-decoration:none;">Profil</a>
                <a href="/logout" class="button button--ghost" style="padding: 8px 15px; border-color: #e74c3c; color: #e74c3c; text-decoration:none;">Déconnexion</a>
            </div>
        </header>

        <!-- HERO SECTION -->
        <section class="hero">
            <div class="hero__card" style="border-left: 6px solid <?= esc($imcStatus['color'] ?? 'var(--accent)') ?>; position:relative;">
                <p class="card__eyebrow">Statistiques Vitales</p>
                <h1>Bonjour, <?= esc($user['username'] ?? 'Utilisateur') ?></h1>
                <p>Statut actuel : <strong style="color: <?= esc($imcStatus['color'] ?? 'inherit') ?>"><?= esc($imcStatus['status'] ?? 'Inconnu') ?></strong></p>
                
                <div class="dashboard-stats" style="padding: 0; margin-top: 24px;">
                    <div class="stat-card">
                        <span>IMC</span>
                        <strong><?= number_format((float)($imc ?? 0), 2, ',', ' ') ?></strong>
                    </div>
                    <div class="stat-card">
                        <span>Poids</span>
                        <strong><?= esc($user['poids'] ?? 0) ?> kg</strong>
                    </div>
                    <div class="stat-card">
                        <span>Taille</span>
                        <strong><?= esc($user['taille'] ?? 0) ?> cm</strong>
                    </div>
                </div>
                <!-- Icône décorative de tendance -->
                <div style="position:absolute; top:30px; right:30px; opacity:0.1;">
                    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                </div>
            </div>
        </section>

        <!-- QUICK ACTIONS (FEATURES) -->
        <h2 style="font-family: 'Literata', serif; font-size: 20px; margin: 25px 0 15px;">Actions rapides</h2>
        <section class="features">
            <a href="/goals/create" class="feature" style="text-decoration:none; color:inherit; display:block;">
                <h3>🎯 Nouvel Objectif</h3>
                <p>Définir un but de poids</p>
            </a>
            <a href="/activities/create" class="feature" style="text-decoration:none; color:inherit; display:block;">
                <h3>💪 Enregistrer Sport</h3>
                <p>Ajouter une activité</p>
            </a>
            <a href="/wallet/deposit" class="feature" style="text-decoration:none; color:inherit; display:block;">
                <h3>💳 Créditer Compte</h3>
                <p>Ajouter des fonds</p>
            </a>
            <a href="/regimes" class="feature" style="text-decoration:none; color:inherit; display:block;">
                <h3>🥗 Voir Régimes</h3>
                <p>Catalogue des menus</p>
            </a>
        </section>

        <!-- CHARTS & PROGRESS -->
        <div class="dashboard-charts" style="padding: 0; margin-top:20px;">
            <div class="chart-card">
                <h3 class="chart-title">Évolution hebdomadaire</h3>
                <div style="height: 180px; display: flex; align-items: flex-end; gap: 10px; border-bottom: 1px solid var(--border); padding-bottom: 5px;">
                    <div style="flex: 1; background: var(--accent-strong); height: 85%; border-radius: 4px;"></div>
                    <div style="flex: 1; background: var(--accent); height: 80%; border-radius: 4px;"></div>
                    <div style="flex: 1; background: var(--accent-strong); height: 75%; border-radius: 4px;"></div>
                    <div style="flex: 1; background: var(--accent); height: 70%; border-radius: 4px;"></div>
                    <div style="flex: 1; background: var(--accent-strong); height: 65%; border-radius: 4px;"></div>
                </div>
            </div>

            <div class="chart-card">
                <h3 class="chart-title">Objectif actuel</h3>
                <div style="margin: 20px 0;">
                    <div style="display: flex; justify-content: space-between; font-size: 14px; margin-bottom: 8px;">
                        <span>Progression</span>
                        <strong>75%</strong>
                    </div>
                    <div style="width: 100%; background: var(--bg-2); height: 10px; border-radius: 10px;">
                        <div style="width: 75%; background: var(--accent-strong); height: 100%; border-radius: 10px;"></div>
                    </div>
                </div>
                <a href="/goals" class="button button--ghost" style="width: 100%; text-align: center; text-decoration: none; display: block;">Gérer mes programmes</a>
            </div>
        </div>

        <!-- GOLD SECTION -->
        <section class="gold" style="margin-top:30px;">
            <div class="gold__card">
                <div>
                    <h2>🌟 Passez au niveau supérieur</h2>
                    <p>Devenez membre <strong>Gold</strong> pour débloquer tous les régimes à -15%.</p>
                </div>
                <a href="/gold" class="button" style="text-decoration: none;">Devenir Gold</a>
            </div>
        </section>

        <footer class="footer" style="padding: 40px 0; text-align:center; color:var(--muted); font-size:13px;">
            © 2026 FitLife — Votre partenaire santé au quotidien
        </footer>
    </main>
</div>
<?= $this->endSection() ?>