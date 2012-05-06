<?

//---------------------------------------------------------------------------

  $db_host="localhost"; // Your database host server, eg. db.server.com
  $db_user="pico";      // User who has full access to that database
  $db_pass="pico";      // User's password to access database
  $db_name="pico";      // Database title

//---------------------------------------------------------------------------
//Error_Reporting(E_ERRORS);

 $link = @mysql_pconnect("$db_host","$db_user","$db_pass");

	if(!$link) {
		echo "SQL_ERROR: Cannot connect to DB: $db_name<br>"; exit();
	}

	@mysql_select_db("$db_name") or die("SQL_ERROR: Cannot select DB: $db_name");

	unset($db_host);
	unset($db_user);
	unset($db_pass);

	function ofdan_query( $sql ) {

		//$result = mysql_query( 'LOCK TABLES'."\n".$sql."\n".'UNLOCK TABLES'."\n" ) or error_sql( $sql, mysql_error() );
		$result = mysql_query( $sql ); // or error_sql( $sql, mysql_error() );
		return $result;

	}


 /* mysql_query( $sql ) or error_sql( $sql, mysql_error() ); */
function error_sql( $sql, $error ) {

	// error_sql( $sql, mysql_error() );

	$sql = addslashes( $sql );
	$URLerror = addslashes( $error );

	$sta= "INSERT INTO `error_sql` VALUES ( '', '$sql', '$URLerror' )";
	$result = ofdan_query( $sta ); // or die(mysql_error() );
	//die( 'Error: ' . $sql . "<br>\n" . $error );

}

?>
