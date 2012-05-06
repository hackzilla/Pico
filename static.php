<?

if ($static == 4) {
	include("addsite.php");
} else {
	include("static/" . $static . ".php");
}
?>

