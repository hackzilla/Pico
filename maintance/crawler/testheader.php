<?

	session_start();
	ini_set( 'error_reporting', E_ALL );

	echo "<html><head></head><body>\n";

	include_once( '../../crawler2/db_connect.php' );
	include_once( '../../crawler2/functions.php' );
	include_once( '../../crawler2/crawlerFunctions.php' );
	include_once( '../../crawler2/pageFunctions.php' );
	include_once( '../../crawler2/httpFunctions.php' );

	if( isset( $_REQUEST['page'] ) ) {

		$page = trim( strtolower( stripslashes( $_REQUEST['page'] )));

	} else {
		$page = '';
	}

	echo "<form action='{$_SERVER['PHP_SELF']}' method='get'>

	<input name='page' type='text' value='{$page}'>
	<input type='submit' value='fetch'>
</form>
<br>
<br>
";
//	print_r( $_POST );

//	$page = " \n ".$page;

	if( $page ) {

		echo "running: <br>\n";
		echo nl2br( print_r( get_headers( 'http://'.$page.'/', 1 ), true ));

		#echo print_r( $http_response_header, true );

	}


#		preg_match_all('|<meta[^>]+name=\\"([^"]*)\\"[^>]+content="([^\\"]*)"[^>]+>|i', $page, $out);

#		print_r( $out );


	print "</body>
</html>
";
//	print_r( $_POST );

?>