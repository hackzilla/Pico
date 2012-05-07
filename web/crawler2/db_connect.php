<?
ini_set( 'error_reporting', E_ALL );
//---------------------------------------------------------------------------

  $db_host="localhost"; // Your database host server, eg. db.server.com
  $db_user="pico";      // User who has full access to that database
  $db_pass="getlostscum93";      // User's password to access database
  $db_name="pico2";      // Database title

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
		$result = mysql_query( $sql ) or error_sql( $sql, mysql_error() ); // or error_sql( $sql, mysql_error() );
		return $result;

	}


 /* mysql_query( $sql ) or error_sql( $sql, mysql_error() ); */
function error_sql( $sql, $error ) {

	// error_sql( $sql, mysql_error() );

	$sql = addslashes( $sql );
	$URLerror = addslashes( $error );

	$sta= "INSERT INTO `error_sql` VALUES ( '', NOW(), '$sql', '$URLerror', '" . str_replace("'", '"', print_r( debug_backtrace(), true )) . "' )";
	$result = mysql_query( $sta ) or die( "error: " . mysql_error()); // or die(mysql_error() );
	die( 'Error: ' . $sql . "<br>\n" . $error );

}

function whereMake( $values ) {
	$str = '1';
	foreach( $values as $col => $value ) {
		$str .= " AND `$col`='$value'";
	}

	return $str;
}

function setMake( $values ) {
	$sets = array();
	foreach( $values as $col => $value ) {
		$sets[] = "`$col`='$value'";
	}

	return implode( ',', $sets );
}

function insertMake( $values ) {

	$cols = "`" . implode( "`,`", array_keys($values)) . "`";
	$values = "'" . implode( "','", $values ) . "'";

	return array($cols, $values);
}

function insertOrUpdate ( $table, $values, $checks ) {

	$where = whereMake( $checks );

	$sql = "SELECT 1 FROM `{$table}` WHERE " . $where . " LIMIT 1";
	$res = mysql_query($sql) or error_sql( $sql, mysql_error() );

	if( $res ) {

		if( mysql_num_rows( $res )) {
			$set = setMake( $values );
			$sql = "UPDATE `{$table}` SET $set WHERE " . $where . " LIMIT 1";
		} else {

			list( $cols, $values ) = insertMake( $values + $checks );
			$sql = "INSERT INTO `{$table}` ({$cols}) VALUES ({$values})";

		}

#		die( $sql );

		$res = mysql_query($sql) or error_sql( $sql, mysql_error() );

	} else {
		return false;
	}

}

?>
