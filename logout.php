<?php
session_start();

// Inclusion de fichier
include('function/betterPrint.php');

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
                    <h2> Deconexion </h2>
                </header>

                <?php

                if ( isset( $_SESSION['user'] ) ) {

                    unset($_SESSION['user']);

                    echo '<p class="message-success"> Vous avez bien été déconnecté ! </p>';

                } else {

                    echo '';

                }

                ?>

            </article>

        </main>
    </body>
</html>