<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="page-header">
  <div>
    <h2>Relevé de notes</h2>
    <div class="breadcrumb">Accueil / Notes / <span>Détails</span></div>
  </div>
  <div style="display:flex;gap:10px">
    <a href="/notes/semestres" class="btn btn-secondary btn-sm">
      <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
      Retour
    </a>
  </div>
</div>

<div class="table-card" style="padding: 20px;">
  <!-- Tableau des notes -->
  <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
      <tr style="border-bottom: 2px solid #333; text-align: left;">
        <th style="padding: 8px;">UE</th>
        <th style="padding: 8px;">Intitulé</th>
        <th style="padding: 8px; text-align: center;">Crédits</th>
        <th style="padding: 8px; text-align: center;">Note/20</th>
        <th style="padding: 8px; text-align: center;">Résultat</th>
      </tr>
    </thead>
    <tbody>
      <!-- SEMESTRE 3 -->
      <tr>
        <td style="padding: 8px;">INF201</td>
        <td style="padding: 8px;">Programmation orientée objet</td>
        <td style="padding: 8px; text-align: center;">6</td>
        <td style="padding: 8px; text-align: center;">10,5</td>
        <td style="padding: 8px; text-align: center;">P</td>
      </tr>
      <tr>
        <td style="padding: 8px;">INF202</td>
        <td style="padding: 8px;">Bases de données objets</td>
        <td style="padding: 8px; text-align: center;">6</td>
        <td style="padding: 8px; text-align: center;">14</td>
        <td style="padding: 8px; text-align: center;">B</td>
      </tr>
      <tr>
        <td style="padding: 8px;">INF203</td>
        <td style="padding: 8px;">Programmation système</td>
        <td style="padding: 8px; text-align: center;">4</td>
        <td style="padding: 8px; text-align: center;">11</td>
        <td style="padding: 8px; text-align: center;">P</td>
      </tr>
      <tr>
        <td style="padding: 8px;">INF208</td>
        <td style="padding: 8px;">Réseaux informatiques</td>
        <td style="padding: 8px; text-align: center;">6</td>
        <td style="padding: 8px; text-align: center;">10</td>
        <td style="padding: 8px; text-align: center;">P</td>
      </tr>
      <tr>
        <td style="padding: 8px;">MTH201</td>
        <td style="padding: 8px;">Méthodes numériques</td>
        <td style="padding: 8px; text-align: center;">4</td>
        <td style="padding: 8px; text-align: center;">6,5</td>
        <td style="padding: 8px; text-align: center;">Comp.</td>
      </tr>
      <tr>
        <td style="padding: 8px;">ORG201</td>
        <td style="padding: 8px;">Bases de gestion</td>
        <td style="padding: 8px; text-align: center;">4</td>
        <td style="padding: 8px; text-align: center;">13</td>
        <td style="padding: 8px; text-align: center;">AB</td>
      </tr>
      
      <!-- LIGNE TOTAL SEMESTRE 3[cite: 1] -->
      <tr style="border-top: 1px solid #333; border-bottom: 2px solid #333; font-weight: bold; background-color: #f9f9f9;">
        <td></td>
        <td style="padding: 8px;">SEMESTRE 3 - option dev</td>
        <td style="padding: 8px; text-align: center;">30</td>
        <td style="padding: 8px; text-align: center;">10,97</td>
        <td style="padding: 8px; text-align: center;">Passable</td>
      </tr>

      <!-- Vous pouvez répéter la même structure pour le Semestre 4 si nécessaire -->
    </tbody>
  </table>

  <!-- RÉSUMÉ FINAL[cite: 1] -->
  <div style="border: 2px solid #333; padding: 15px; margin-top: 30px; display: flex; justify-content: space-between;">
    <div style="line-height: 1.8;">
      <div>Résultat: <span style="font-weight: bold; text-transform: uppercase;">ADMIS(E)</span></div>
      <div>Crédits acquis: <span style="font-weight: bold;">60</span></div>
    </div>
    <div style="text-align: right; line-height: 1.8;">
      <div>Moyenne générale: <span style="font-weight: bold; font-size: 1.2em;">11,24</span></div>
      <div>Mention: <span style="font-weight: bold;">Passable</span></div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>