<header>
    <p class="title"><a href="index.php">Luxury Cars</a></p>

    <nav>
        <ul>
            <?php if(!isset($_SESSION['login'])) { ?>
                <li><a href="register.php" class="ui teal button">Créer mon compte</a></li>
                <li><a href="login.php" class="ui button">Me connecter</a></li>
            <?php } else { ?>
                <li><a href="#" class="ui teal button">Mon compte</a></li>
                <li><a href="logout.php" class="ui red button">Se déconnecter</a></li>
            <?php } ?>

            <li><a href="#" class="ui button">Véhicules</a></li>
        </ul>
    </nav>
</header>