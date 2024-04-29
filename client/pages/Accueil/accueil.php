<!DOCTYPE html>
<html lang="fr">

<head>


    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="pages/Accueil/accueil.css" media="all">

    <link rel="icon" type="image/png" href="assets/images/images_site/icone.png" />


    <meta charset="utf-8"  />
    <title>Produits</title>
</head>

<body>

    <div class="page-container">

        <div class="page-content">

            <header class="header">
                <h1>Administration du Restaurant</h1>
            </header>
            <div class="container">
                <h2> Produits </h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th> Interraction Produits</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <button class="action-button interact list"
                                    onclick="window.location.href='index.php?pages=produits'">
                                    <i class="fas fa-cog"></i> Interragir
                                </button>

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="container">
                <h2> Commandes </h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th> Interraction Commandes </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                            <button class="action-button interact list"
                                    onclick="window.location.href='index.php?page=commandes'">
                                    <i class="fas fa-cog"></i> Interragir
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>

