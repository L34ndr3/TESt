<?php

class Rooter {
	public static function redirectToPage($pageName) {
		header("location: index.php?uc=" . $pageName);
		exit;
	}
}