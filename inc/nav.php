<header class="header-content">

    <div class="header-title">
        <h1> <a href="index.php"> Wikifruit </a> </h1>
    </div>

    <nav class="nav-content">
        <ul class="nav-list">
            <li> <a href="index.php"> Accueil </a> </li>
            <li> <a href="list_fruit.php"> Liste des fruits </a> </li>

            <?php
            if ( isset( $_SESSION['user'] ) ) {


            ?>

                <li> <a href="logout.php"> Deconexion </a> </li>
                <li> <a href="profil.php"> Mon profil </a> </li>
                <li> <a href="create_fruit.php"> Ajouter un Fruit </a> </li>

            <?php
            } else {

            ?>

            <li> <a href="sign.php"> Inscription </a> </li>
            <li> <a href="login.php"> Connexion </a> </li>

            <?php
            }
            ?>

        </ul>
    </nav>


    <div class="header-search">
        <!-- TODO: BAR DE RECHERCHE-->
        <form action="" method="GET">

            <div>
                <input type="search" name="search_fruit" placeholder="Chercher un fruit">
            </div>

            <div>
                <button type="submit"> <i class="fa-solid fa-magnifying-glass"></i> </button>
            </div>

        </form>
    </div>

</header>
