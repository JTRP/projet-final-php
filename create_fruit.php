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
            <h2> Ajouter un nouveau fruit </h2>
        </header>

        <form action="" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="MAX_FILE_SIZE">

            <label for="fruit_name"> Nom </label>
            <input type="text" name="fruit_name" id="fruit_name" placeholder="Banane" >

            <label for="origin"> Pays d'origine </label>
            <select name="origin" id="origin">
                <option value="" disabled selected> -- Selectionner un pays -- </option>
                <option value="france"> France </option>
                <option value="allemagne"> Allemagne </option>
                <option value="espagne"> Espagne </option>
                <option value="japon"> Japon </option>
            </select>

            <label for="picture"> Photo </label>
            <input type="file" name="picture" id="picture" accept="image/png, image/jpeg">

            <label for="description"> Description </label>
            <textarea name="description" id="description" placeholder="Description..."></textarea>

            <input type="submit" value="Creer le fruit">
        </form>
    </article>

</main>
</body>
</html>