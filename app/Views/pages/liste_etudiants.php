<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="page-header">
  <div>
    <h2>Liste des etudiants <a href="/deconnexion">Déconnexion</a></h2>
    <div class="breadcrumb">Accueil / <span>Etudiants</span></div>
  </div>
  <div style="display:flex;gap:10px">
    <a href="/notes/ajout" class="btn btn-primary btn-sm">
      <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Ajouter note
    </a>
  </div>
</div>

<!-- <div class="toolbar">
  <div class="toolbar-left">
    <div class="search-box">
      <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <input type="text" placeholder="Rechercher un etudiant..." />
    </div>
    <select class="filter-select">
      <option>Niveau</option>
      <option>L1</option>
      <option>L2</option>
      <option>L3</option>
      <option>M1</option>
      <option>M2</option>
    </select>
    <select class="filter-select">
      <option>Filiere</option>
      <option>Informatique</option>
      <option>Gestion</option>
      <option>Comptabilite</option>
      <option>Marketing</option>
    </select>
    <select class="filter-select">
      <option>Statut</option>
      <option>Actif</option>
      <option>Inactif</option>
      <option>Redoublant</option>
    </select>
  </div>
  <button class="btn btn-ghost btn-sm">
    <svg viewBox="0 0 24 24"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
    Filtres avances
  </button>
</div> -->

<div class="table-card">
  <table>
    <thead>
      <tr class="row-link" data-href="/notes/semestres" role="link" tabindex="0" style="cursor:pointer">
        <th class="sortable">Etudiant</th>
        <th class="sortable">Matricule</th>
      </tr>
    </thead>
    <tbody>
      <tr class="row-link" data-href="/notes/semestres" role="link" tabindex="0" style="cursor:pointer">
        <td>
          <div style="display:flex;align-items:center;gap:10px">
            <div>
              <a href="/notes/semestres" style="font-weight:600;text-decoration:none;color:inherit">Andry Rakoto</a>
            </div>
          </div>
        </td>
        <td style="color:var(--c-muted);font-family:monospace">ETU-0041</td>
      </tr>

      <tr class="row-link" data-href="/notes/semestres" role="link" tabindex="0" style="cursor:pointer">
        <td>
          <div style="display:flex;align-items:center;gap:10px">
            <div>
              <a href="/notes/semestres" style="font-weight:600;text-decoration:none;color:inherit">Fanja Razafy</a>
            </div>
          </div>
        </td>
        <td style="color:var(--c-muted);font-family:monospace">ETU-0042</td>
      </tr>

      <tr>
        <td>
          <div style="display:flex;align-items:center;gap:10px">
            <div>
              <a href="/notes/semestres" style="font-weight:600;text-decoration:none;color:inherit">Hery Ranaivo</a>
            </div>
          </div>
        </td>
        <td style="color:var(--c-muted);font-family:monospace">ETU-0043</td>
      </tr>

    </tbody>
  </table>

  <!-- <div class="pagination">
    <span>Affichage de <strong>1-3</strong> sur <strong>248</strong> etudiants</span>
    <div class="page-btns">
      <button class="page-btn">&lsaquo;</button>
      <button class="page-btn active">1</button>
      <button class="page-btn">2</button>
      <button class="page-btn">3</button>
      <button class="page-btn">&rsaquo;</button>
    </div>
  </div> -->

</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  (function () {
    document.querySelectorAll('.row-link').forEach((row) => {
      const href = row.getAttribute('data-href');
      if (!href) {
        return;
      }

      row.addEventListener('click', (event) => {
        const target = event.target;
        if (target && target.closest('a')) {
          return;
        }
        window.location.href = href;
      });

      row.addEventListener('keydown', (event) => {
        if (event.key === 'Enter' || event.key === ' ') {
          event.preventDefault();
          window.location.href = href;
        }
      });
    });
  })();
</script>
<?= $this->endSection() ?>
