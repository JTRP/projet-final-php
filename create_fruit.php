<?php
session_start();

// Inclusion de fichier
include('function/betterPrint.php');

betterPrint($_POST);

betterPrint($_FILES);

if ( isset( $_POST['fruit_name'] ) &&
    isset( $_POST['description'] ) &&
    isset( $_FILES['picture'] )
) {

    $name = $_POST['fruit_name'];
    $description = $_POST['description'];
    $picture = $_FILES['picture'];

    betterPrint($name);

    $originList = [
        'france',
        'espagne',
        'japon',
        'allemagne'
    ];

    $allowType = [
        'jpg' => 'image/jpeg',
        'png' => 'image/png'
    ];


    if ( mb_strlen( $name ) < 1 || mb_strlen( $name ) > 50 ) {

        $errors['username'] = '<p class="message-error"> Le nom doit contenir entre 1 et 50 caractères ! </p>';

    }

    if ( !isset( $_POST['origin'] ) ) {

        $errors['origin'] = '<p class="message-error"> Le pays est invalide </p>';

        if ( isset( $_POST['origin'] ) ) {

            if ( !in_array( $_POST['origin'] , $originList) ) {

                $errors['origin'];

            }

        }


    }



    if ( isset( $_FILES['picture'] ) ) {

        $pictureError = $picture['error'];

        if ( $pictureError == 1 || $pictureError == 2 || $picture['size'] > 5242880	) {

            $errors['picture']['size'] = '<p class="message-error"> Taille du fichier doit etre 5mb </p>';

        } elseif ( $pictureError == 4 ) {

            $picture = NULL;

        } elseif ($pictureError > 5) {


            $errors['picture']['server'] = '<p class="message-error"> Un problem est survenu re-essayer plutard </p>';

        } else {

            $getTypeMINE = finfo_file( finfo_open( FILEINFO_MIME_TYPE ), $picture['tmp_name'] );


            if ( !in_array( $getTypeMINE, $allowType ) ) {

                $errors['picture']['ext'] = '<p class="message-error"> Le format du fichier ne convient pas </p>';

            }

            if ( !isset( $errors ) ) {

                $ext = array_search( $getTypeMINE, $allowType );

                do {

                    $randomName = md5( random_bytes(50) ) . '.' . $ext;

                } while( file_exists( 'tmp_file_upload/' . $randomName ) );

                move_uploaded_file( $picture['tmp_name'], 'tmp_file_upload/' . $randomName);

            }

        }


    }

    if ( !empty( $description ) ) {

        if ( mb_strlen( $description ) < 5 || mb_strlen( $description ) > 20_000 ) {

            $errors['description'] = '<p class="message-error"> La description doit contenir entre 5 et 20 000 caractères ! </p>';

        }

    }



    if ( !isset( $errors ) ) {

        require('inc/db.php');

        $insertFruit = $db->prepare('INSERT INTO fruits(name, origin, description, picture_name, user_id) VALUES (?, ?, ?, ?, ?)');

        betterPrint($_FILES);

        $executeFruit = $insertFruit->execute([
            $name,
            $_POST['origin'],
            empty( $description ) ? NULL : $description,
            $randomName ?? NULL,
            $_SESSION['user']['id']
        ]);

        $success = '<p class="message-success"> Fruit creer avec success </p>';

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
            <h2> Ajouter un nouveau fruit </h2>
        </header>

        <?php

        if ( !isset( $success ) ) {

        ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="MAX_FILE_SIZE" value="2048000">

            <label for="fruit_name"> Nom </label>
            <input type="text" name="fruit_name" id="fruit_name" placeholder="Banane" >
            <?= $errors['username'] ?? '' ?>

            <label for="origin"> Pays d'origine </label>
            <select name="origin" id="origin">
                <option value="none" disabled selected> -- Selectionner un pays -- </option>
                <option value="france"> France </option>
                <option value="allemagne"> Allemagne </option>
                <option value="espagne"> Espagne </option>
                <option value="japon"> Japon </option>
            </select>
            <?= $errors['origin'] ?? '' ?>

            <label for="picture"> Photo </label>
            <input type="file" name="picture" id="picture" accept="image/png, image/jpeg">
            <?php

            if ( isset($errors['picture'] ) ) {

                foreach ($errors['picture'] as $error) {

                    echo $error;

                }

            }

            ?>

            <label for="description"> Description </label>
            <textarea name="description" id="description" placeholder="Description..."></textarea>
            <?= $errors['description'] ?? '' ?>

            <input type="submit" value="Creer le fruit">
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