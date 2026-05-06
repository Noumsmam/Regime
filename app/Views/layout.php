<?php
$title = $title ?? 'EtuNote';
$pageTitle = $pageTitle ?? '';
$activeMenu = $activeMenu ?? '';
$useAppLayout = $useAppLayout ?? true;
$searchPlaceholder = $searchPlaceholder ?? 'Rechercher...';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= esc($title) ?></title>
  <link rel="stylesheet" href="/assets/css/style.css" />
  <style>
    .sidebar { transition: transform .2s ease; }
    .main { transition: margin-left .2s ease; }
    .sidebar-collapsed .sidebar { transform: translateX(-100%); }
    .sidebar-collapsed .main { margin-left: 0; }
  </style>
</head>
<body>

<?php if ($useAppLayout): ?>
<div class="app">

  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="logo-icon">
        <svg viewBox="0 0 24 24" width="18" height="18"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
      </div>
      <div>
        <div class="brand-name">EtuNote</div>
        <div class="brand-sub">v2.4.0</div>
      </div>
    </div>

    <div class="sidebar-section">Navigation</div>

    <!-- <a href="/dashboard" class="<?= ($activeMenu === 'dashboard') ? 'nav-item active' : 'nav-item' ?>">
      <svg viewBox="0 0 24 24"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
      Tableau de bord
    </a> -->
    <!-- <a href="/utilisateurs" class="<?= ($activeMenu === 'utilisateurs') ? 'nav-item active' : 'nav-item' ?>">
      <svg viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
      Utilisateurs
      <span class="nav-badge">24</span>
    </a> -->
    <a href="/etudiants" class="<?= ($activeMenu === 'etudiants') ? 'nav-item active' : 'nav-item' ?>">
      <svg viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
      Etudiants
    </a>
    <a href="/notes/ajout" class="<?= ($activeMenu === 'ajout_note') ? 'nav-item active' : 'nav-item' ?>">
      <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
      Ajout note
    </a>

    <div class="sidebar-bottom">
      <a href="/login" class="user-row">
        <div class="avatar">AD</div>
        <div class="user-info">
          <div class="name">Admin Sys</div>
          <div class="role">Super administrateur</div>
        </div>
      </a>
    </div>
  </aside>

  <div class="main">

    <div class="topbar">
      <button id="sidebar-toggle" class="icon-btn" aria-label="Afficher/masquer le menu">
        <svg viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
      </button>
      <div class="topbar-title"><?= esc($pageTitle) ?></div>
      <div class="topbar-search">
        <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" placeholder="<?= esc($searchPlaceholder) ?>" />
      </div>
      <div class="topbar-actions">
        <button class="icon-btn">
          <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
          <span class="notif-dot"></span>
        </button>
        <button class="icon-btn">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M20 21a8 8 0 1 0-16 0"/></svg>
        </button>
      </div>
    </div>

    <div class="content">
      <?= $this->renderSection('content') ?>
      <footer class="page-footer" style="margin-top:24px;text-align:center;font-size:12px;color:var(--c-muted)">
        EtuNote — Gestion interne
      </footer>
    </div>
  </div>
</div>
<?php else: ?>
<?= $this->renderSection('content') ?>
<?php endif; ?>

<?= $this->renderSection('scripts') ?>
<script>
  (function () {
    const toggle = document.getElementById('sidebar-toggle');
    if (!toggle) {
      return;
    }

    toggle.addEventListener('click', () => {
      document.body.classList.toggle('sidebar-collapsed');
    });
  })();
</script>
</body>
</html>
