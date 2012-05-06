<?

	session_start();

	echo "<html><head></head><body>\n";

	include_once( '../../crawler2/db_connect.php' );
	include_once( '../../crawler2/functions.php' );
	include_once( '../../crawler2/crawlerFunctions.php' );
	include_once( '../../crawler2/pageFunctions.php' );
	include_once( '../../crawler2/languageFunctions.php' );

	$sql = "LOCK TABLES `keyword2` WRITE,`rank2` WRITE";
	$result = mysql_query( $sql ) or error_sql( $sql, mysql_error() );


	$sql = "delete from rank2 WHERE keyword_id IN ( SELECT id FROM keyword2 WHERE CHAR_LENGTH( `keyword` ) > 100)";
	$res = mysql_query( $sql ) or die( mysql_error() );

	$sql = "delete from keyword2 WHERE CHAR_LENGTH( `keyword` ) > 100";
	$res = mysql_query( $sql ) or die( mysql_error() );


	$sql = "UNLOCK TABLES";
	$result = mysql_query( $sql ) or error_sql( $sql, mysql_error() );

?>