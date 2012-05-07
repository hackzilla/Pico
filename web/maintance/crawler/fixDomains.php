<?

	set_time_limit(0);

	include_once( '../../crawler2/db_connect.php' );
	include_once( '../../crawler2/functions.php' );


	$sql = "SELECT domain, id FROM domain"; # ORDER BY id ASC LIMIT 1,10000";
	$res = mysql_query( $sql ) or die( mysql_error());

	if( $res ) {

		$count = 0;
		while( list( $domain, $id ) = mysql_fetch_row( $res )) {

			if( !isValidDomain( $domain ) ) {
				$count++;
				echo "{$domain} ({$id})<br>\n";
				$sql = "DELETE FROM `domain` WHERE `id`='$id' LIMIT 1";
				$resDel = mysql_query( $sql ) or die( $sql . '<br>' . mysql_error() . '<br>');

				flush();
			}

		}

		echo "$count domains not valid.";

		mysql_free_result( $res );

		
#		if( $count ) {
			// do something.
#  		}

	}


?>
