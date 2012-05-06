<?

	session_start();
	ini_set( 'error_reporting', E_ALL );

	echo "<html><head></head><body>\n";

	include_once( '../../crawler2/db_connect.php' );

	$sql = "SELECT UNCOMPRESS(header) FROM `cacheHeader` LIMIT 10";
	$res = mysql_query( $sql );

	while(list($header) = mysql_fetch_row($res)) {

		echo "<pre>" . print_r( unserialize($header), 1 ) . "</pre>";

	}

	print "</body>
</html>
";
//	print_r( $_POST );

?>