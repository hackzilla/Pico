<?

/*

All from Edward: 97686

All from edward where blocked: 7920

All from edward where not blocked: 89766

All blocked: 83627

All from blocked, where not in edward: 75707

*/

	include_once('../../crawler/db_connect.php');
//	include_once('../../config.php');

	$msg = 'All from Edward';
	$squirt = "SELECT COUNT(*) FROM edward";
	// $squirt = "SELECT COUNT(*) FROM edward WHERE lastindex > " . (time() - (60 * 60 * 24 * 14)) . ";";
	$result = mysql_query($squirt) or die( mysql_error());

	$edCount = mysql_result($result,0);
	echo "<p>{$msg}: $edCount</p>";

	mysql_free_result($result);


	$msg = 'All from edward where blocked';
	$squirt = "SELECT COUNT(*) FROM edward, block
	WHERE block.domain = edward.domain";
	// $squirt = "SELECT COUNT(*) FROM edward WHERE lastindex > " . (time() - (60 * 60 * 24 * 14)) . ";";
	$result = mysql_query($squirt) or die( mysql_error());

	$edBlCount = mysql_result($result,0);
	echo "<p>{$msg}: $edBlCount</p>";

	mysql_free_result($result);

	$msg = 'All from edward where not blocked';
	$count = $edCount - $edBlCount;
	echo "<p>{$msg}: $count</p>";

	$msg = 'All blocked';
	$squirt = "SELECT COUNT(*) FROM block";
	// $squirt = "SELECT COUNT(*) FROM edward WHERE lastindex > " . (time() - (60 * 60 * 24 * 14)) . ";";
	$result = mysql_query($squirt) or die( mysql_error());

	$blCount = mysql_result($result,0);
	echo "<p>{$msg}: $blCount</p>";

	mysql_free_result($result);


	$msg = 'All from blocked, where not in edward';
	$squirt = "SELECT COUNT(*) FROM edward";
	$count = $blCount - $edBlCount;
	echo "<p>{$msg}: $count</p>";




?>