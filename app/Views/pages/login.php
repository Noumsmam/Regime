<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="login-page">
  <div class="login-card">

    <div class="login-logo">
      <div class="logo-icon">
        <svg viewBox="0 0 24 24" width="22" height="22"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
      </div>
      <div>
        <h1>EtuNote</h1>
        <span>Gestion de notes</span>
      </div>
    </div>

    <h2>Connexion</h2>

    <form action="/login" method="post">
    <?= csrf_field() ?>
    <div class="field-group">
      <label>Adresse e-mail</label>
      <div class="input-wrap">
        <div class="icon">
          <svg viewBox="0 0 24 24"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
        </div>
        <input type="text" placeholder="user1" value="user1" name="username"/>
      </div>
    </div>

    <div class="field-group">
      <label>Mot de passe</label>
      <div class="input-wrap">
        <div class="icon">
          <svg viewBox="0 0 24 24"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        </div>
        <input type="password" placeholder="Votre mot de passe" name="password"/>
      </div>
    </div>

    <div class="remember-row">
      <label>
        <input type="checkbox" checked />
        Se souvenir de moi
      </label>
      <a href="#">Mot de passe oublié ?</a>
    </div>

    <input type="submit" value="se connecter">
    </form>
  </div>
</div>
<?= $this->endSection() ?>
