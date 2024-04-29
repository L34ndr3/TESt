<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="pages/produits/produit.css" media="all">
    <title>Menu du Restaurant</title>
</head>

<body>

    <?php

    include_once("tools/Autoloader.php");
    include_once("DAO/ProduitDAO.php");
    include_once("DTO/ProduitDTO.php");
    spl_autoload_register('includeFileWithClassName');


    $produits = (ProduitDAO::getAllProducts());


    ?>
    <h1>Menu du Restaurant</h1>

    <button type="button" action="index.php?page=produits&action=create" class="btn btn-primary btn-lg" onclick="window.location.href = 'index.php?page=produits&action=create';">Ajouter un produit</button>

    <div class="container">
        <div class="row">

            <?php foreach ($produits as $product): ?>

                <div class="col-lg-3 col-md-4 col-sm-6">

                    <div class="card" style="width: 18rem; height: 23rem;">
                        <img class="image-produit" src="../tapas_groupe1_webservice/src/images/produits/<?php echo $product->image; ?>"
                            class="card-img-top" alt="..." style="width: 286px; height: 200px;">

                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo $product->nom; ?> -
                                <?php echo $product->prix; ?> €
                            </h5>
                            <p class="card-text">
                                <?php echo $product->description; ?>
                            </p>
                            <!-- Button trigger modal -->
                            <div style="display: flex; align-items:center;">
                                <button type="button" class="btn btn" id="myInput" data-bs-toggle="modal"
                                    data-bs-target="#modal<?php echo $product->id ?>">
                                    <a class="">
                                        <img class="icon-admin"
                                            src="../tapas_groupe1_webservice/src/images/image_site/icon_edit.png" alt=""
                                            style="width: 30px; height: 30px;" />
                                    </a>
                                </button>
                                <form action="index.php?page=produits&action=delete" method="POST">
                                    <input type="hidden" name="produitid" value="<?php echo $product->id; ?>">
                                    <button type="submit" class="delete-button">
                                        <img class="icon-admin"
                                            src="../tapas_groupe1_webservice/src/images/image_site/icon_delete.png"
                                            style="width: 30px; height: 30px;" />
                                    </button>
                                </form>
                            </div>


                            <!-- Modal -->
                            <div class="modal fade" id="modal<?php echo $product->id ?>" tabindex="-1"
                                aria-labelledby="modal<?php echo $product->id ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form class="modal-content" method="POST" action="index.php?page=produits&action=edit">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="<?php echo $product->id ?>">
                                                <div class="line-produit">
                                                    <div>
                                                        <img class="produit-photo"
                                                            src="../tapas_groupe1_webservice/src/images/produits/<?php echo $product->image; ?>"
                                                            a alt="" style="width: 150px; height: 150px;">
                                                    </div>
                                                    <label class="label-produit">Photo : </label>
                                                    <input type="file" name="field-avatar"
                                                        value="../tapas_groupe1_webservice/src/images/produits/<?php echo $product->image; ?>" />
                                                </div>

                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="line-produit">
                                                <label class="label-produit">id : </label>
                                                <input type="text" name="field-id" value="<?php echo $product->id; ?>"
                                                    readonly>

                                            </div>
                                            <div class="line-produit">
                                                <label class="label-produit">Nom de l'individu : </label>
                                                <input type="text" name="field-nom" value="<?php echo $product->nom; ?>">
                                            </div>
                                        </div>
                                        <div class="line-produit">
                                            <label class="label-produit">Prix : </label>
                                            <input type="number" name="field-prix" value="<?php echo $product->prix; ?>">
                                        </div>
                                        <div class="line-produit"><label class="label-produit">Description : </label></div>
                                        <textarea class="produit-description"
                                            name="field-description"><?php echo $product->description; ?></textarea>
                                        <div class="line-produit"><label class="label-produit">Catégorie : </label></div>
                                        <textarea class="produit-categorie"
                                            name="field-categorie"><?php echo $product->categorie_id; ?></textarea>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Modifier</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>
        <script>
            const listModal = document.querySelectorAll('.modal');
            const myInput = document.querySelectorAll('#myInput');

            for (let i = 0; i < listModal.length; i++) {
                const modal = listModal[i];
                modal.addEventListener('shown.bs.modal', () => {
                    myInput[i].focus();
                });
            }


        </script>

    </div>
</body>

</html>