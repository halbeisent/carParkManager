<!-- J'ajoute la classe navbar-fixed pour garder ma navbar à l'écran pendant la navigation -->
<div class="navbar-fixed">
    <!-- Structure de ma navbar (en mode utilisateur -->
    <nav>
        <div class="nav-wrapper blue-grey darken-3">
            <a href="#!" class="brand-logo">CarPark Manager - Utilisateur</a>
            <!-- Ajout du bouton pour déclencher la sidenav sur appareil mobile -->
            <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
                <!-- Contenu de ma navbar -->
                <li><a href="views/dashboard.php">Dashboard utilisateur</a></li>
                <li><a href="../controllers/logout.php">Déconnexion</a></li>
            </ul>
        </div>
    </nav>
</div>
<!-- Structure de la sidenav -->
<ul class="sidenav" id="mobile-demo">
    <!-- Contenu de la sidenav -->
    <li><a href="views/dashboard.php">Dashboard utilisateur</a></li>
    <li><a href="../controllers/logout.php">Déconnexion</a></li>
</ul>