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
  <!-- On garde ton fichier CSS principal -->
  <link rel="stylesheet" href="/assets/css/app-theme.css">
  <link rel="stylesheet" href="/assets/css/home.css">

  <style>
    /* Reset minimal pour un layout pleine page */
    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: sans-serif;
      background-color: #f8f9fa; /* Couleur de fond légère */
    }

    .page-wrapper {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .main-content {
      flex: 1; /* Pousse le footer vers le bas */
      display: flex;
      justify-content: center; /* Centre horizontalement le contenu */
      align-items: center;     /* Centre verticalement le contenu */
      padding: 20px;
    }

    footer {
      padding: 20px;
      text-align: center;
      font-size: 13px;
      color: #888;
    }
  </style>
</head>
<body>

<?php if ($useAppLayout): ?>
  <div class="page-wrapper">
    
    <main class="main-content">
        <!-- C'est ici que ton contenu (Login, etc.) sera injecté -->
        <?= $this->renderSection('content') ?>
    </main>

    <footer>
      &copy; <?= date('Y') ?> — Tous droits réservés
    </footer>

  </div>
<?php else: ?>
  <!-- Si on veut le contenu brut sans aucun style de layout -->
  <?= $this->renderSection('content') ?>
<?php endif; ?>

<?= $this->renderSection('scripts') ?>
</body>
</html>