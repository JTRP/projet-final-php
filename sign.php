<?php
session_start();

// Inclusion de fichier
include('function/betterPrint.php');
include('function/recaptchaValid.php');
require('inc/db.php');

betterPrint($_POST);

// Etape de verification du formulaire
if (
    isset($_POST['email']) &&
    isset($_POST['password']) &&
    isset($_POST['valid_password']) &&
    isset($_POST['username']) &&
    isset($_POST['g-recaptcha-response'])
) {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $validPassword = $_POST['valid_password'];
    $username = $_POST['username'];
    $captcha = $_POST['g-recaptcha-response'];

    // TODO: VERIFIER SI EMAIL EXISTE DEJA
//    $selectUserEmail = $db->prepare('SELECT email FROM users WHERE email = ?');
//    $selectUserEmail->execute([
//        $email
//    ]);
//    $getUserEmail = $selectUserEmail->fetch(PDO::FETCH_ASSOC);
//    $selectUserEmail->closeCursor();


    // Verification des champs
    if ( !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
        $errors['email'] = '<p class="message-error"> Email invalide </p>';
        
    }

//    if ( in_array( $email, $getUserEmail ) ) {
//
//        echo 123;
//
//    }




    if ( !preg_match(
            '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[^a-zA-Z0-9]).{8,4096}$/',
            $password)
    ) {

        $errors['password'] = '<p class="message-error"> Le mot de passe doit comprendre au moins 8 caractères dont 1 lettre minuscule, 1 majuscule, un chiffre et un caractère spécial. </p>';

    }

    if ( $password != $validPassword ) {

        $errors['invalid-password'] = '<p class="message-error"> La confirmation ne correspond pas au mot de passe </p>';

    }

    if ( mb_strlen( $username ) < 1 || mb_strlen( $username ) > 50 ) {

        $errors['username'] = '<p class="message-error"> Le pseudonyme doit contenir entre 1 et 50 caractères </p>';

    }

    if ( !recaptchaValid($captcha, $_SERVER['REMOTE_ADDR']) ) {

        $errors['captcha'] = '<p class="message-error"> Veuillez remplir correctement le captcha </p>';

    }


    // Si tous est bon on cree le message de success
    if ( !isset( $errors ) ) {

        $date = new DateTime();

        $getDateNow = $date->format('Y:m:d H:i:s');

        $insertUser = $db->prepare('INSERT INTO users(email, password, pseudonym, register_date) VALUES (?, ?, ? ,?)');

        $execUser = $insertUser->execute([
            $email,
            password_hash( $password, PASSWORD_BCRYPT ),
            $username,
            $getDateNow
        ]);

        if ( !$execUser ) {

            die("Un problem est survenu re-essayer plutard");

        }

        $insertUser->closeCursor();


        $success = 'Votre compte a bien été créé !';

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
        <script src="https://www.google.com/recaptcha/api.js"></script>
    </head>

    <body>

        <main class="main-container">

            <?php include('inc/nav.php'); ?>


            <article class="article-content">

                <header class="article-header">
                    <h2> Créer un compte sur Wikifruit </h2>
                </header>


                <?php

                if ( !isset( $success ) ) {


                ?>



                <form class="form-sign" action="" method="POST">

                    <?php // Changer le type des formulaire ?>
                    <div>
                        <label for="email"> Email </label>
                        <input type="text" name="email" id="email">
                        <?php

                        if ( isset( $errors['email'] ) ) {

                            echo $errors['email'];

                        }if ( isset( $errors['email-used'] ) ) {

                            echo $errors['email-used'];

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
                        <label for="valid_password"> Confirmation mot de passe </label>
                        <input type="text" name="valid_password" id="valid_password">
                        <?= isset( $errors['invalid-password'] ) ? $errors['invalid-password'] : '' ?>
                    </div>

                    <div>
                        <label for="username"> Pseudonyme </label>
                        <input type="text" name="username" id="username">
                        <?= isset( $errors['username'] ) ? $errors['username'] : '' ?>
                    </div>


                    <div class="g-recaptcha" data-theme="dark" data-sitekey="6LeJO8MUAAAAABowrxt-XzaxaSfT7slu-5txtQxX"></div>
                    <?= isset( $errors['captcha'] ) ? $errors['captcha'] : '' ?>


                    <div>
                        <input class="submit account" type="submit" value="Créer mon compte">
                    </div>

                </form>

                <?php
                } else {

                    echo '<p class="message-success"> ' . $success . ' </p>';

                }

                ?>

            </article>

        </main>

    </body>
</html>