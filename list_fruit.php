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

        <section class="article-content list-fruit">

            <header class="article-header">
                <h2> Liste des fruits </h2>
            </header>

            <!-- TODO: LIST FRUIT -->
            <article class="article-list-fruit">

                <div class="image-fruit">
                    <img src="d" alt="Image de fruit">
                </div>

                <div class="origin-fruit">

                    <div>
                        <h3> Banane </h3>
                    </div>

                    <div>
                        <p>
                            Pays d'origine : Espagne
                        </p>
                    </div>

                    <div>
                        <p>
                            Posté par : Alice
                        </p>
                    </div>

                </div>

                <div>
                    <p>
                        La banane est le fruit ou la baie dérivant de l’inflorescence du bananier.
                        Les bananes sont des fruits très généralement stériles issus de variétés domestiquées.
                        Seuls les fruits des
                        bananiers sauvages et de quelques cultivars domestiques contiennent des graines.
                    </p>
                </div>


            </article>
        </section>

    </main>

</body>
</html>