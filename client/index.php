<!DOCTYPE html>
<html lang="fr">

<head>

	<link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">
	<link rel="icon" type="image/png" href="assets/images/images_site/icone.png" />

	<meta charset="utf-8" />
	<title>Restaurant</title>
</head>

<body>
<?php
include_once("tools/Rooter.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once("tools/Autoloader.php");

?>


	<div class="page-container">

		<div class="page-content">
			<?php
				if (!empty($_GET['page'])) {
					$page = $_GET['page'];
				} else {
					$page = "accueil";
				}
			

			include_once("tools/SuperController.php");
			SuperController::callPage($page);

			?>
		</div>
	</div>

	
</body>

</html>