<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="page-header">
  <div>
    <h2>Notes par semestre</h2>
    <div class="breadcrumb">Accueil / Notes / <span>Semestres</span></div>
  </div>
  <a href="/notes/ajout" class="btn btn-primary btn-sm">
    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Ajouter note
  </a>
</div>

<div class="kpi-grid">

  <a href="/notes/releve?semestre=S3" style="text-decoration:none;color:inherit;display:block">
    <div class="kpi-card">
      <div class="kpi-header">
        <div class="kpi-label">Semestre</div>
        <div class="kpi-icon bg-blue">
          <svg viewBox="0 0 24 24"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
        </div>
      </div>
      <div class="kpi-value">S3</div>
      <div class="kpi-delta up">Voir releve</div>
    </div>
  </a>

  <a href="/notes/releve?semestre=S4&option=dev" style="text-decoration:none;color:inherit;display:block">
    <div class="kpi-card">
      <div class="kpi-header">
        <div class="kpi-label">S4 - Dev</div>
        <div class="kpi-icon bg-green">
          <svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </div>
      </div>
      <div class="kpi-value">S4</div>
      <div class="kpi-delta up">Option Developpement</div>
    </div>
  </a>

  <a href="/notes/releve?semestre=S4&option=bdd" style="text-decoration:none;color:inherit;display:block">
    <div class="kpi-card">
      <div class="kpi-header">
        <div class="kpi-label">S4 - Bdd</div>
        <div class="kpi-icon bg-amber">
          <svg viewBox="0 0 24 24"><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        </div>
      </div>
      <div class="kpi-value">S4</div>
      <div class="kpi-delta up">Option Base de donnees</div>
    </div>
  </a>

  <a href="/notes/releve?semestre=S4&option=web" style="text-decoration:none;color:inherit;display:block">
    <div class="kpi-card">
      <div class="kpi-header">
        <div class="kpi-label">S4 - Web</div>
        <div class="kpi-icon bg-blue">
          <svg viewBox="0 0 24 24"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
        </div>
      </div>
      <div class="kpi-value">S4</div>
      <div class="kpi-delta up">Option Web &amp; design</div>
    </div>
  </a>

  <a href="/notes/releve?niveau=L2&option=dev" style="text-decoration:none;color:inherit;display:block">
    <div class="kpi-card">
      <div class="kpi-header">
        <div class="kpi-label">L2 - Dev</div>
        <div class="kpi-icon bg-green">
          <svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </div>
      </div>
      <div class="kpi-value">L2</div>
      <div class="kpi-delta up">Option Developpement</div>
    </div>
  </a>

  <a href="/notes/releve?niveau=L2&option=bdd" style="text-decoration:none;color:inherit;display:block">
    <div class="kpi-card">
      <div class="kpi-header">
        <div class="kpi-label">L2 - Bdd</div>
        <div class="kpi-icon bg-amber">
          <svg viewBox="0 0 24 24"><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        </div>
      </div>
      <div class="kpi-value">L2</div>
      <div class="kpi-delta up">Option Base de donnees</div>
    </div>
  </a>

  <a href="/notes/releve?niveau=L2&option=dev-2" style="text-decoration:none;color:inherit;display:block">
    <div class="kpi-card">
      <div class="kpi-header">
        <div class="kpi-label">L2 - Dev</div>
        <div class="kpi-icon bg-blue">
          <svg viewBox="0 0 24 24"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
        </div>
      </div>
      <div class="kpi-value">L2</div>
      <div class="kpi-delta up">Option Developpement</div>
    </div>
  </a>

</div>
<?= $this->endSection() ?>
