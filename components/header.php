<header>
    <p class="title"><a href="index.php">Luxury Cars</a></p>

    <nav>
	    <base href="/ecole/DEVOIRS/AGENCE/">
        <ul>
            <?php if(!isset($_SESSION['login'])) { ?>
                <li><a href="register.php" class="ui teal button">Créer mon compte</a></li>
                <li><a href="login.php" class="ui button">Me connecter</a></li>
            <?php } else { ?>
                <li><a href="compte.php" class="ui teal button">Mon compte</a></li>
                <li><a href="logout.php" class="ui red button">Se déconnecter</a></li>
            <?php } ?>

            <li><a href="vehicules.php" class="ui button">Véhicules</a></li>
	        <li><a href="reservations.php" class="ui button">Réservations</a></li>

	        <?php if(isset($_SESSION['login']) && isset($_SESSION['admin'])) {
				if($_SESSION['admin']) { ?>
					<li><a href="admin/utilisateurs.php" class="ui yellow button">Utilisateurs</a></li>
				<?php }
	        } ?>
        </ul>
    </nav>
</header>