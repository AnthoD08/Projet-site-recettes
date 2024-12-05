<header>
  <div class="boxed">
    <div class="flex aligncenter space-between">
      <a href="accueil" class="header-logo">
        <img src="images/logo_header.jpg" alt="" />
      </a>
      <ul class="header-menu">
        <li><a href="accueil">Accueil</a></li>
        <li><a href="recettes/toutes">Recettes</a></li>
        <li><a href="contact">Contact</a></li>

        <!-- Affichez le lien vers le profil uniquement si l'utilisateur est connecté -->
        <?php if (isset($_SESSION['pseudo']) && !empty($_SESSION['pseudo'])): ?>
            <li><a href="profil">Mon Profil</a></li>
            <li><a href="deconnexion">Se déconnecter</a></li>
        <?php else: ?>
            <!-- Le bouton d'inscription n'est visible que si l'utilisateur n'est pas connecté -->
            <li><a href="inscription">Inscription</a></li>
            <li><a href="connexion">Connexion</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</header>
