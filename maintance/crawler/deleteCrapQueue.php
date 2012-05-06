<?

	session_start();

	echo "<html><head></head><body>\n";

	include_once( '../../crawler/db_connect.php' );
	include_once( '../../crawler/functions.php' );
	include_once( '../../crawler/crawlerFunctions.php' );
	include_once( '../../crawler/pageFunctions.php' );
	include_once( '../../crawler/languageFunctions.php' );


	$sql = "delete from domain 'WHERE `domain` LIKE '%\%20%' and status = 'queue'";
	$res = mysql_query( $sql ) or die( mysql_error() );

?>