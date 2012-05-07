<div id="static">

<h1>Known Words</h1>

<?php

// $alpha = Array();
$alpha = Array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");

echo "<div align='center'><font size='1'>";
foreach ($alpha as $letter) {
	echo "<a href='/s/7/?l=" . $letter . "'>" . $letter . "</a> &nbsp;";
}
echo "</div>";

$chosena = ( isset($_GET['l']) ? $_GET['l'] : '' );
$chosenb = ( isset($_GET['lb']) ? $_GET['lb'] : '' );
if ($chosena) {

echo "<div align='center'>&nbsp;<br /><font size='1'>";
foreach ($alpha as $letter) {
	echo "<a href='/s/7/?l=" . $chosena . "&lb=" . $letter . "'>" . $chosena . $letter . "</a> &nbsp;";
}
echo "</div>";
}

if (($chosena)&&($chosenb)) {
$squirt = "SELECT * FROM keyword WHERE keyword LIKE '" . $chosena . $chosenb . "%' ORDER BY keyword ASC;";
$result = mysql_query($squirt, $con);

$counter = 0;
$counttop = mysql_numrows($result);
echo "<ul>";
while ($counter < $counttop) {
	$data = mysql_fetch_array($result);
	echo "<li><a href='/q/" . urlencode($data['keyword']) . "/'>" . $data['keyword'] . "</a></li>";
	$counter++;
}
echo "</ul>";
}
?>

</div>

<br />

