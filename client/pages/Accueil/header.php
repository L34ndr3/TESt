<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="css/accueil.css">
    <title>Administration Restaurant</title>

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-dark text-white">
        <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
                <img width="80" class="img=fluid" src="../../images/restaurant_icon.png"/>
            <button class="navbar-toggler text-warning" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-ellipsis-v"></i>
            </button>
            <div class="collapse navbar-collapse text-center justify-content-end" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link text-warning" href="index.php">
                        <i class="fas fa-concierge-bell"></i>
                        <span>Accueil</span>
                    </a>
                    <a class="nav-link text-warning" href="staff.php">
                        <i class="fas fa-user-circle"></i>
                        <span>Equipe</span>
                    </a>
                    <a class="nav-link text-warning" href="status.php">
                        <i class="fas fa-tv"></i>
                        <span>Commandes</span>
                    </a>
                    <a class="nav-link text-warning" href="menu.php">
                        <i class="fas fa-utensils"></i>
                        <span>Menu</span>
                    </a>
                    <a class="nav-link text-warning" href="#" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-power-off"></i>
                        <span>Deconnexion</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row">

<!-- Modal logout -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="exampleModalLabel">Log Out</h5>
                <button class="close btn btn-dark text-white" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body bg-dark text-light">
                Voulez-vous vraiment vous déconnecter ?
                <br/>Appuyez sur logout pour quitter l'administration.
            </div>
            <div class="modal-footer bg-warning">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                <a class="btn btn-danger" href="logout.php">Deconnexion</a>
            </div>
        </div>
    </div>
</div>
</div>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
