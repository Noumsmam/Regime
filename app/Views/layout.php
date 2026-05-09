<?php
$title = $title ?? 'Application';
$useAppLayout = $useAppLayout ?? true;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= esc($title) ?></title>
  
  <!-- <link rel="stylesheet" href="/assets/css/app-theme.css"> -->
  <link rel="stylesheet" href="/assets/css/style.css">

  <style>
    /* Reset complet pour éviter les scrollbars inutiles */
    *, ::after, ::before {
      box-sizing: border-box;
    }

    body, html {
      margin: 0;
      padding: 0;
      width: 100%;
      min-height: 100vh;
      font-family: 'Space Grotesk', sans-serif;
      background-color: #f6f3ec; /* Ton beige de base */
      overflow-x: hidden; /* Empêche le scroll horizontal global */
    }

    .page-wrapper {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      width: 100%;
    }

    .main-content {
      flex: 1;
      width: 100%;
      display: block; /* On enlève le flex center qui cassait tout */
      position: relative;
    }

    /* Si c'est une page hors Dashboard (ex: Login), on peut centrer via une classe spécifique */
    .is-centered {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    footer {
      width: 100%;
      padding: 20px;
      text-align: center;
      font-size: 13px;
      color: #888;
      background: transparent;
    }

    /* Fix pour que la sidebar et le contenu cohabitent sans déborder */
    .layout {
        display: flex;
        width: 100%;
        min-height: 100vh;
    }
  </style>
</head>
<body>

<?php if ($useAppLayout): ?>
  <div class="page-wrapper">
    
    <!-- On retire le centrage forcé d'ici pour laisser le Dashboard respirer -->
    <main class="main-content">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Le footer est souvent déjà dans ton Dashboard, 
         on peut le mettre en conditionnel ou le laisser simple -->
    <footer class="app-footer">
      &copy; <?= date('Y') ?> FitLife — Tous droits réservés
    </footer>

  </div>
<?php else: ?>
  <?= $this->renderSection('content') ?>
<?php endif; ?>

<?= $this->renderSection('scripts') ?>
</body>
</html>