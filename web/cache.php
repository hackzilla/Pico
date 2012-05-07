<?php

include_once('fns/database.php');

$cacheLink = cacheLink();

if( !$cacheLink )
{
  header('HTTP/1.1 503 Service Unavailable');
?>
<html>
<head>
	<title>Cached Page</title>
</head>
<body>
Sorry we were unable to find that page in our cache.
</body>
</html>
<?

  die();
}

$domain = $cacheLink->real_escape_string ( urldecode($_REQUEST['domain']));

$squirt = "SELECT UNCOMPRESS(`cacheIndex`.`index`), `cacheIndex`.`date`
FROM `domain`,`cacheIndex`
WHERE `domain`.id = `cacheIndex`.`domainId` AND `domain`.`domain`='" . $domain . "';";
$result = $cacheLink->query($squirt) or error_sql( $squirt, $cacheLink->error );

if( $result && ( $result->num_rows >0 )) {

	list( $html, $date ) = $result->fetch_row();
	$result->free();

	$html = stripslashes( $html );
	$html = str_replace("<head>", "<head>
<script src='http://www.google-analytics.com/urchin.js' type='text/javascript'>
</script>
<script type='text/javascript'>
	_uacct = 'UA-486690-3';
	urchinTracker();
</script>
<base href='http://" . $domain . "/'>", $html);

}

if( isset( $html )) {

	echo $html;

} else {

?>
<html>
<head>
	<title>Cached Page</title>
</head>
<body>
Sorry we were unable to find that page in our cache.
</body>
</html>
<?

}

?>
