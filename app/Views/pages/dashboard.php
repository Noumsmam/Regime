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
            <!-- La classe 'active' colorera l'item en orange -->
            <a href="/dashboard" class="menu__item active">Tableau de bord</a>
            <a href="/goals" class="menu__item">Mes Objectifs</a>
            <a href="/activities" class="menu__item">Activités Sportives</a>
            <a href="/regimes" class="menu__item">Régimes & Menus</a>
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
                <span class="topbar__link">Accueil / <strong>Tableau de bord</strong></span>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="/dashboard/export" class="button button--ghost">
                    <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" fill="none" style="margin-right:8px"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                    Exporter
                </a>
                <a href="/profile" class="button button--ghost">Profil</a>
                <a href="/logout" class="button button--ghost" style="border-color: #e74c3c; color: #e74c3c;">Déconnexion</a>
            </div>
        </header>

        <!-- HERO SECTION -->
        <section class="hero">
            <div class="hero__card" style="border-left: 6px solid <?= esc($imcStatus['color'] ?? 'var(--accent)') ?>;">
                <p class="card__eyebrow">Statistiques Vitales</p>
                <h1 style="font-family: 'Literata', serif; margin: 10px 0;">Bonjour, <?= esc($user['username'] ?? 'Utilisateur') ?></h1>
                <p>Statut actuel : <strong style="color: <?= esc($imcStatus['color'] ?? 'inherit') ?>"><?= esc($imcStatus['status'] ?? 'Inconnu') ?></strong></p>
                
                <div class="dashboard-stats">
                    <div class="stat-card">
                        <span style="font-size: 11px; color: var(--muted); text-transform: uppercase;">IMC</span><br>
                        <strong><?= number_format((float)($imc ?? 0), 2, ',', ' ') ?></strong>
                    </div>
                    <div class="stat-card">
                        <span style="font-size: 11px; color: var(--muted); text-transform: uppercase;">Poids</span><br>
                        <strong><?= esc($user['poids'] ?? 0) ?> kg</strong>
                    </div>
                    <div class="stat-card">
                        <span style="font-size: 11px; color: var(--muted); text-transform: uppercase;">Taille</span><br>
                        <strong><?= esc($user['taille'] ?? 0) ?> cm</strong>
                    </div>
                </div>
            </div>
        </section>

        <!-- QUICK ACTIONS -->
        <h2 style="font-family: 'Literata', serif; font-size: 20px;">Actions rapides</h2>
        <section class="features">
            <a href="/goals/create" class="feature">
                <h3>🎯 Nouvel Objectif</h3>
                <p style="font-size: 13px; color: var(--muted);">Définir un but de poids</p>
            </a>
            <a href="/activities/create" class="feature">
                <h3>💪 Sport</h3>
                <p style="font-size: 13px; color: var(--muted);">Ajouter une activité</p>
            </a>
            <a href="/wallet/deposit" class="feature">
                <h3>💳 Créditer</h3>
                <p style="font-size: 13px; color: var(--muted);">Ajouter des fonds</p>
            </a>
            <a href="/regimes" class="feature">
                <h3>🥗 Régimes</h3>
                <p style="font-size: 13px; color: var(--muted);">Catalogue des menus</p>
            </a>
        </section>

        <!-- CHARTS -->
        <div class="dashboard-charts">
            <div class="chart-card">
                <h3 style="font-size: 16px; margin-bottom: 20px;">Évolution hebdomadaire</h3>
                <div style="height: 150px; display: flex; align-items: flex-end; gap: 8px; border-bottom: 1px solid var(--border);">
                    <div style="flex: 1; background: var(--accent-strong); height: 80%; border-radius: 4px;"></div>
                    <div style="flex: 1; background: var(--accent); height: 60%; border-radius: 4px;"></div>
                    <div style="flex: 1; background: var(--accent-strong); height: 90%; border-radius: 4px;"></div>
                    <div style="flex: 1; background: var(--accent); height: 70%; border-radius: 4px;"></div>
                </div>
            </div>

            <div class="chart-card">
                <h3 style="font-size: 16px; margin-bottom: 15px;">Objectif actuel</h3>
                <div style="margin: 20px 0;">
                    <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 8px;">
                        <span>Progression</span>
                        <strong>75%</strong>
                    </div>
                    <div style="width: 100%; background: var(--bg-main); height: 10px; border-radius: 10px; overflow: hidden;">
                        <div style="width: 75%; background: var(--accent-strong); height: 100%;"></div>
                    </div>
                </div>
                <a href="/goals" class="button button--ghost" style="width: 100%;">Gérer mes programmes</a>
            </div>
        </div>

        <!-- GOLD -->
        <section class="gold">
            <div class="hero__card" style="background: linear-gradient(135deg, #fff 0%, #fff9f0 100%); border: 1px solid #ffd700; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                <div>
                    <h2 style="font-family: 'Literata', serif; font-size: 20px;">🌟 Niveau Gold</h2>
                    <p style="font-size: 14px; color: var(--muted);">Débloquez tous les régimes à <strong>-15%</strong>.</p>
                </div>
                <a href="/gold" class="button button--primary" style="background: #ffd700; color: #000;">Devenir Gold</a>
            </div>
        </section>

        <footer style="padding: 40px 0; text-align:center; color:var(--muted); font-size:12px;">
            © 2026 FitLife — Votre partenaire santé
        </footer>
    </main>
</div>
<?= $this->endSection() ?>