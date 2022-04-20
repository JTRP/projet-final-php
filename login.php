<?php
session_start();

// Inclusion de fichier
include('function/betterPrint.php');
require('inc/db.php');

// Etape de verification du formulaire
if (
    isset($_POST['email']) &&
    isset($_POST['password'])
) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verification des champs
    if ( !filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $errors['email'] = '<p class="message-error"> Email invalide </p>';

    }

    if ( !preg_match(
        '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[^a-zA-Z0-9]).{8,4096}$/',
        $password)
    ) {

        $errors['password'] = '<p class="message-error"> Le mot de passe doit comprendre au moins 8 caractères dont 1 lettre minuscule, 1 majuscule, un chiffre et un caractère spécial. </p>';

    }


    // Si tous est bon on cree le message de success
    if ( !isset( $errors ) ) {

        $selectUserInfo = $db->prepare('SELECT * FROM users WHERE email = ?');
        $selectUserInfo->execute([
            $email
        ]);

        $user = $selectUserInfo->fetch(PDO::FETCH_ASSOC);

        $selectUserInfo->closeCursor();

        if(!is_bool($user)){

            if(password_verify($_POST['password'], $user['password'])){
                $success = 'Vous êtes bien connecté !';

                $_SESSION['user'] = [
                    "username" => $user['pseudonym'],
                    "email" => $user['email'],
                    "register_date" => $user['register_date']
                ];

            } else {
                $errors['password'] = 'Mauvais mot de passe !';
            }

        } else {
            $errors['account'] = 'Ce compte n\'existe pas !';
        }

    }


}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/phpfinal.css" type="text/css">

    <title> Demo </title>
</head>

<body>

<main class="main-container">

    <?php include('inc/nav.php'); ?>


    <article class="article-content">

        <header class="article-header">
            <h2> Connexion </h2>
        </header>


        <?php

        if ( !isset( $success ) ) {


        ?>

        <form class="form-sign" action="" method="POST">

            <div>
                <label for="email"> Email </label>
                <input type="text" name="email" id="email">
                <?php

                if ( isset( $errors['email'] ) ) {

                    echo $errors['email'];

                } elseif ( isset( $errors['account'] ) ) {

                    echo $errors['account'];

                } else {

                    echo '';

                }
                ?>
            </div>

            <div>
                <label for="password"> Mot de passe </label>
                <input type="text" name="password" id="password">
                <?= isset( $errors['password'] ) ? $errors['password'] : '' ?>
            </div>


            <div>
                <input class="submit account" type="submit" value="Connexion">
            </div>

        </form>

        <?php
        } else {

            echo $success;

        }


        ?>
    </article>

</main>

</body>
</html>